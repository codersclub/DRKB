---
Title: Расшифровка строки, ранее зашифрованной фукцией UBPFD.Encrypt
Date: 01.01.2007
---


Расшифровка строки, ранее зашифрованной фукцией UBPFD.Encrypt
=============================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Расшифровка строки
     
    Предназначена для расшифровки строки, ранее зашифрованной фукцией UBPFD.Encrypt
     
    Зависимости: UBPFD.Encrypt
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:   (c) Anatoly Podgoretsky, 1996
    Дата:        26 апреля 2002 г.
    ********************************************** }
     
    const
      StartKey = 471; // Start default key
      MultKey = 62142; // Mult default key
      AddKey = 11719; // Add default key
    // обязательно смените ключи до использования
     
    {$R-}
    {$Q-}
    function Decrypt(const InString:string; StartKey,MultKey,AddKey:Integer): string;
    var
      I : Byte;
    //Если поменять тип переменной I на Integer, то будет возможно шифрование 
    //текста длиной более 255 символом - VID.
    begin
      Result := '';
      for I := 1 to Length(InString) do
      begin
        Result := Result + CHAR(Byte(InString[I]) xor (StartKey shr 8));
        StartKey := (Byte(InString[I]) + StartKey) * MultKey + AddKey;
      end;
    end;
    {$R+}
    {$Q+} 

Пример использования:

    S := 'Ваш старый пароль: <' + Decrypt(S, StartKey, MultKey, AddKey) + '>'; 

------------------------------------------------------------------------

\
 

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Расшифровка строки InString, зашифрованной с помощью функции EncryptEX
     
    Функция является модификацией UBPFD.Decrypt. Отличие в том, что UBPFD.DecryptEX расшифровывает шифр-текст, зашифрованный с помощью функции UBPFD.EncryptEX
     
    Зависимости: UBPFD.Decrypt, UBPFD.AsсiiToStr
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        30 апреля 2002 г.
    ********************************************** }
     
    Function DecryptEX(const InString:string; StartKey,MultKey,AddKey:Integer): string;
    Begin
    Result := Decrypt(AsciiToStr(InString), StartKey, MultKey, AddKey);
    END; 

Пример использования:

    var S : String;
    begin
      S := UBPFD.EncryptEX ('String', 1,1,1);
    //S является источником данных для функции UBPFD.DecryptEX
      ShowMessage ('Расшифровка: '+UBPFD.DecryptEX (S, 1,1,1));
    end; 
