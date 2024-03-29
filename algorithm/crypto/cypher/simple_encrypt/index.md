---
Title: Простые алгоритмы шифрования текста
Author: Song
Date: 01.01.2007
---


Простые алгоритмы шифрования текста
===================================

Вариант 1:

**Шифрование методом XOR**

    Function Decode(S: String; Code: Integer): String;
    Var t: Integer;
    Begin
      For t:=1 to Length(S) Do S[t]:=Chr(Ord(S[t]) xor Code);
      Result:=S;
    End;

В параметрах функции передайте саму строку, которую хотите зашифровать и
код шифрования. Зашифрованная строка будет результатом функции. Для
декодирования примените к закодированной строке вызов функции с тем же
самым кодом.

Автор: Song

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Вариант 2:

Простое симметричное шифрование строк ключом длиной 96 бит.

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Шифрование строки
     
    Предназначена для простого шифрование строк и паролей, ключ 96 бит, шифрование
    симметричное.
     
    Зависимости: UBPFD.decrypt
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:   (c) Anatoly Podgoretsky, 1996
    Дата:        26 апреля 2002 г.
    ********************************************** }
     
    const
      StartKey = 471; // Start default key
      MultKey = 62142; // Mult default key
      AddKey = 11719; // Add default key
    // обязательно смените ключи до использования
     
    function Encrypt(const InString:string; StartKey,MultKey,AddKey:Integer): string;
    var
      I : Byte;
    //Если поменять тип переменной I на Integer, то будет 
    //возможно шифрование текста длиной более 255 символом - VID.
    begin
      Result := '';
      for I := 1 to Length(InString) do
      begin
        Result := Result + CHAR(Byte(InString[I]) xor (StartKey shr 8));
        StartKey := (Byte(Result[I]) + StartKey) * MultKey + AddKey;
      end;
    end; 

Пример использования:

    if Encrypt(S, StartKey, MultKey, AddKey) <> OriginalPwd then ... 

------------------------------------------------------------------------

Вариант 3:

Простое симметричное шифрование строк с сохранением результата в файл.

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Шифрование строки InString, с возможностью корректного 
    сохранения результата шифрования в TEXT-FILE
     
    Функция представляет модификацию функции UBPFD.Encrypt. 
    Отличие от указанной функции заключается в том, что 
    функция EncryptEX возвращает результат, обработанный функцией 
    UBPFD.StrToAsсii, т.е. обеспечивает возможность корректного 
    сохранения шифр-текста в текстовый файл.
     
    Зависимости: UBPFD.Encrypt, UBPFD.StrToAscii
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        30 апреля 2002 г.
    ********************************************** }
     
    Function EncryptEX(const InString:string; StartKey,MultKey,AddKey:Integer): string;
    Begin
    Result := StrTOAscii(Encrypt(InString, StartKey, MultKey, AddKey));
    END;

------------------------------------------------------------------------

Вариант 4:

Шифрование строки паролем

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Шифрование текста
     
    Процедура шифрует текст основываясь на введенном пароле.
     
    Зависимости: Windows, SysUtils, Classes
    Автор:       Danger, robinzon2000@pochtamt.ru, Киев
    Copyright:   Danger
    Дата:        04 мая 2002 г.
    ********************************************** }
     
    var
      s: string;
     
    procedure Code(var text: string; password: string;
      decode: boolean);
    var
      i, PasswordLength: integer;
      sign: shortint;
    begin
      PasswordLength := length(password);
      if PasswordLength = 0 then Exit;
      if decode
        then sign := -1
        else sign := 1;
      for i := 1 to Length(text) do
        text[i] := chr(ord(text[i]) + sign *
          ord(password[i mod PasswordLength + 1]));
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      s := Memo1.Text;
      code(s, Edit1.Text, false);
      Memo1.Text := s;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      code(s, Edit1.Text, true);
      Memo1.Text := s;
    end; 

------------------------------------------------------------------------

Вариант 5:

    unit uEncrypt; 
     
    interface 
     
    function Decrypt(const S: AnsiString; Key: Word): AnsiString; 
    function Encrypt(const S: AnsiString; Key: Word): AnsiString; 
     
    implementation 
     
    const 
      C1 = 52845; 
      C2 = 22719; 
     
    function Decode(const S: AnsiString): AnsiString; 
    const 
      Map: array[Char] of Byte = (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 62, 0, 0, 0, 63, 52, 53, 
        54, 55, 56, 57, 58, 59, 60, 61, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 
        3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 
        20, 21, 22, 23, 24, 25, 0, 0, 0, 0, 0, 0, 26, 27, 28, 29, 30, 
        31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 
        46, 47, 48, 49, 50, 51, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 
        0); 
    var 
      I: LongInt; 
    begin 
      case Length(S) of 
        2: 
          begin 
            I := Map[S[1]] + (Map[S[2]] shl 6); 
            SetLength(Result, 1); 
            Move(I, Result[1], Length(Result)) 
          end; 
        3: 
          begin 
            I := Map[S[1]] + (Map[S[2]] shl 6) + (Map[S[3]] shl 12); 
            SetLength(Result, 2); 
            Move(I, Result[1], Length(Result)) 
          end; 
        4: 
          begin 
            I := Map[S[1]] + (Map[S[2]] shl 6) + (Map[S[3]] shl 12) + 
              (Map[S[4]] shl 18); 
            SetLength(Result, 3); 
            Move(I, Result[1], Length(Result)) 
          end 
      end 
    end; 
     
    function PreProcess(const S: AnsiString): AnsiString; 
    var 
      SS: AnsiString; 
    begin 
      SS := S; 
      Result := ''; 
      while SS <> '' do 
      begin 
        Result := Result + Decode(Copy(SS, 1, 4)); 
        Delete(SS, 1, 4) 
      end 
    end; 
     
    function InternalDecrypt(const S: AnsiString; Key: Word): AnsiString; 
    var 
      I: Word; 
      Seed: Word; 
    begin 
      Result := S; 
      Seed := Key; 
      for I := 1 to Length(Result) do 
      begin 
        Result[I] := Char(Byte(Result[I]) xor (Seed shr 8)); 
        Seed := (Byte(S[I]) + Seed) * Word(C1) + Word(C2) 
      end 
    end; 
     
    function Decrypt(const S: AnsiString; Key: Word): AnsiString; 
    begin 
      Result := InternalDecrypt(PreProcess(S), Key) 
    end; 
     
    function Encode(const S: AnsiString): AnsiString; 
    const 
      Map: array[0..63] of Char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' + 
        'abcdefghijklmnopqrstuvwxyz0123456789+/'; 
    var 
      I: LongInt; 
    begin 
      I := 0; 
      Move(S[1], I, Length(S)); 
      case Length(S) of 
        1: 
          Result := Map[I mod 64] + Map[(I shr 6) mod 64]; 
        2: 
          Result := Map[I mod 64] + Map[(I shr 6) mod 64] + 
            Map[(I shr 12) mod 64]; 
        3: 
          Result := Map[I mod 64] + Map[(I shr 6) mod 64] + 
            Map[(I shr 12) mod 64] + Map[(I shr 18) mod 64] 
      end 
    end; 
     
    function PostProcess(const S: AnsiString): AnsiString; 
    var 
      SS: AnsiString; 
    begin 
      SS := S; 
      Result := ''; 
      while SS <> '' do 
      begin 
        Result := Result + Encode(Copy(SS, 1, 3)); 
        Delete(SS, 1, 3) 
      end 
    end; 
     
    function InternalEncrypt(const S: AnsiString; Key: Word): AnsiString; 
    var 
      I: Word; 
      Seed: Word; 
    begin 
      Result := S; 
      Seed := Key; 
      for I := 1 to Length(Result) do 
      begin 
        Result[I] := Char(Byte(Result[I]) xor (Seed shr 8)); 
        Seed := (Byte(Result[I]) + Seed) * Word(C1) + Word(C2) 
      end 
    end; 
     
    function Encrypt(const S: AnsiString; Key: Word): AnsiString; 
    begin 
      Result := PostProcess(InternalEncrypt(S, Key)) 
    end; 
     
    end. 
     
    {**************************************************************} 
    // Example: 
    {**************************************************************} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    const 
     my_key = 33189; 
    var 
      sEncrypted, sDecrypted :AnsiString; 
    begin 
      // Encrypt a string 
      sEncrypted := Encrypt('this is a sample text 
        to encrypt...abcd 123 {}[]?=)=(',my_key); 
      // Show encrypted string 
      ShowMessage(sEncrypted); 
      // Decrypt the string 
      sDecrypted := Decrypt(sEncrypted,my_key); 
       // Show decrypted string 
      ShowMessage(sDecrypted); 
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 6:

Метод основан на сложении текста и пароля: "мой текст" + "пароль" =
(\'м\'+\'п\')(\'о\'+\'а\')... То есть каждый символ получают путем
сложения соответствующих символов текста и пароля. Под "сложением
символов" я подразумеваю сложение номеров этих символов. Обычно пароль
длиннее текста, поэтому его размножают: "парольпар".

Чтобы расшифровать текст, нужно проделать обратную операцию, то есть из
текста вычесть пароль.

При нажатии на Button1 эта программа шифрует текст из Memo1 при помощи
пароля из Edit1. Результат сохраняется в строку s. Для наглядности
зашифрованный текст также помещается в Memo1. При нажатии на Button2
текст из s расшифровывается. Если Вы нажмете Button1 два раза подряд,
получится зашифрованный зашифрованный текст. Вернуть начальный текст
можно будет двумя нажатиями на Button2. Но, поскольку в результате
шифрования в строке могут появится

     
    var
      s: string;
     
    procedure Code(var text: string; password: string;
      decode: boolean);
    var
      i, PasswordLength: integer;
      sign: shortint;
    begin
      PasswordLength := length(password);
      if PasswordLength = 0 then Exit;
      if decode
        then sign := -1
        else sign := 1;
      for i := 1 to Length(text) do
        text[i] := chr(ord(text[i]) + sign *
          ord(password[i mod PasswordLength + 1]));
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      s := Memo1.Text;
      code(s, Edit1.Text, false);
      Memo1.Text := s;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      code(s, Edit1.Text, true);
      Memo1.Text := s;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 7:

    {$I-,R-}
     
    Unit Crypter;
     
    interface
    Uses Objects;
     
    procedure EnCrypt(var Pntr: Array of Char; ArrLen: Word; password: string);
    { - Закpиптовать блок }

    procedure DeCrypt(var Pntr: Array of Char; ArrLen: Word; password: string);
    { - Раскиптовать блок }
     
    procedure EnCryptStream(var st: tStream; Password: String);
    { - Закpиптовать поток }

    procedure DeCryptStream(var st: tStream; Password: String);
    { - Раскиптовать поток }
     
    implementation
     
    procedure EnCrypt(var Pntr: Array of Char; ArrLen:Word; password: string);
    var
      len,pcounter: byte;
      x:Word;
    begin
      len := length(password) div 2;
      pcounter := 1;
      for x:=0 to ArrLen-1 do begin
        Pntr[x] := chr(ord(password[pcounter]) + ord(Pntr[x]) + len);
        inc(pcounter);
        if pcounter > length(password) then pcounter := 1;
      end;
    end;
     
    procedure DeCrypt(var Pntr: Array of Char; ArrLen:Word; password: string);
    var
      len,pcounter: byte;
      x:Word;
    begin
      len := length(password) div 2;
      pcounter := 1;
      for x:=0 to ArrLen-1 do begin
        Pntr[x] := chr(ord(Pntr[x]) - ord(password[pcounter]) - len);
        inc(pcounter);
        if pcounter > length(password) then pcounter := 1;
      end;
    end;
     
    type
     pBuffer = ^tBuffer;
     tBuffer = Array[1..$FFFF] of Char;
     
    procedure EnCryptStream(var st: tStream; Password: String);
     var
      buf: pBuffer;
      StSize, StPos, p: Longint;
     begin
      if (@st=nil) or (Password='') then exit;
      New(buf);
      StPos:=st.GetPos;
      StSize:=st.GetSize;
      st.Reset;
      st.Seek(0);
      repeat
       p:=st.GetPos;
       if SizeOf(Buf^)> St.GetSize-St.GetPosthen st.Read(buf^,St.GetSize-St.GetPos)
    else st.Read(buf^,SizeOf(Buf^));
       EnCrypt(buf^,SizeOf(buf^),password);
       st.Reset;
       st.Seek(p);
       st.Write(buf^,SizeOf(Buf^));
      until (St.GetSize=St.GetPos);
      st.Seek(StSize);
      st.Truncate;
      st.Seek(StPos);
      Dispose(buf);
     end;
     
    procedure DeCryptStream(var st: tStream; Password: String);
     var
      buf: pBuffer;
      StSize, StPos, p: Longint;
     begin
      if (@st=nil) or (Password='') then exit;
      New(buf);
      StPos:=st.GetPos;
      StSize:=st.GetSize;
      st.Reset;
      st.Seek(0);
      repeat
       p:=st.GetPos;
       if SizeOf(Buf^)> St.GetSize-St.GetPosthen st.Read(buf^,St.GetSize-St.GetPos)
    else st.Read(buf^,SizeOf(Buf^));
       DeCrypt(buf^,SizeOf(buf^),password);
       st.Reset;
       st.Seek(p);
       st.Write(buf^,SizeOf(Buf^));
      until (St.GetSize=St.GetPos);
      st.Seek(StSize);
      st.Truncate;
      st.Seek(StPos);
      Dispose(buf);
     end;
     
    end.
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 8:

    { 
     This two functions are used to encrypt and decrypt text. 
     Here's how to use it: 
     The four entries Key1, Key2, Key3 and Key4 are numbers 
     that can range from 1 to 120. In order to decrypt a text, 
     you must use the same numbers you used to encrypt the text. 
     No one that doesn't know what values were used on Key1, Key2, Key3 and Key4 
     will be able to decrypt your text! 
     Note that Key1*Key4 MUST be different than Key2*Key3. 
     If any Key is zero, or Key1*Key4 is equal to Key2*Key3, 
     the function will return ''. 
     In Brief: 
          Key1, Key2, Key3, Key4 : integer from range[1..120] 
          Key1*Key4  Key2*Key3 
    }
     
     function Encrypt(Text : string; Key1, Key2, Key3, Key4 : Integer) : string;
     var
      BufS, Hexa, Hexa1, Hexa2 : string;
      BufI, BufI2, Sc, Sl, Num1, Num2, Num3, Num4, Res1, Res2, Res3, Res4 : Integer;
     begin
      Sl := Length(Text);
      Sc := 0;
      BufS := '';
      if (Key1 in [1 .. 120]) and (Key2 in [1 .. 120]) and (Key3 in [1 .. 120]) and (Key4 in [1 .. 120]) then
      begin
       BufI := Key1 * Key4;
       BufI2 := Key3 * Key2;
       BufI := BufI - BufI2;
       if BufI = 0 then
       begin
        Result := '';
        Exit;
       end;
      end
      else
      begin
       Result := '';
       Exit;
      end;
      repeat
       Inc(Sc);
       if Sc > Sl then Num1 := 0 else Num1 := Ord(Text[Sc]);
       Inc(Sc);
       if Sc > Sl then Num2 := 0 else Num2 := Ord(Text[Sc]);
       Inc(Sc);
       if Sc > Sl then Num3 := 0 else Num3 := Ord(Text[Sc]);
       Inc(sc);
       if Sc > Sl then Num4 := 0 else Num4 := Ord(Text[Sc]);
       Res1 := Num1 * Key1;
       BufI := Num2 * Key3;
       Res1 := Res1 + BufI;
       Res2 := Num1 * Key2;
       BufI := Num2 * Key4;
       Res2 := Res2 + BufI;
       Res3 := Num3 * Key1;
       BufI := Num4 * Key3;
       Res3 := Res3 + BufI;
       Res4 := Num3 * Key2;
       BufI := Num4 * Key4;
       Res4 := Res4 + BufI;
       for BufI := 1 to 4 do
       begin
        case BufI of
         1 : Hexa := IntToHex(Res1, 4);
         2 : Hexa := IntToHex(Res2, 4);
         3 : Hexa := IntToHex(Res3, 4);
         4 : Hexa := IntToHex(Res4, 4);
        end;
        Hexa1 := '$' + Hexa[1] + Hexa[2];
        Hexa2 := '$' + Hexa[3] + Hexa[4];
        if (Hexa1 = '$00') and (Hexa2 = '$00') then
        begin
         Hexa1 := '$FF';
         Hexa2 := '$FF';
        end;
        if Hexa1 = '$00' then Hexa1 := '$FE';
        if Hexa2 = '$00' then
        begin
         Hexa2 := Hexa1;
         Hexa1 := '$FD';
        end;
        BufS := BufS + Chr(StrToInt(Hexa1)) + Chr(StrToInt(Hexa2));
       end;
       until Sc >= Sl;
      Result := BufS;
     end;
     
     function Decrypt(Text : string; Key1, Key2, Key3, Key4 : Integer) : string;
     var
      BufS, Hexa1, Hexa2 : string;
      BufI, BufI2, Divzr, Sc, Sl, Num1, Num2, Num3, Num4, Res1, Res2, Res3, Res4 : Integer;
     begin
      Sl := Length(Text);
      Sc := 0;
      BufS := '';
      if (Key1 in [1 .. 120]) and (Key2 in [1 .. 120]) and (Key3 in [1 .. 120]) and (Key4 in [1 .. 120]) then
      begin
       Divzr := Key1 * Key4;
       BufI2 := Key3 * Key2;
       Divzr := Divzr - BufI2;
       if Divzr = 0 then
       begin
        Result := '';
        Exit;
       end;
      end
      else
      begin
       Result := '';
       Exit;
      end;
      repeat
       for BufI := 1 to 4 do
       begin
        Inc(Sc);
        Hexa1 := IntToHex(Ord(Text[Sc]), 2);
        Inc(Sc);
        Hexa2 := IntToHex(Ord(Text[Sc]), 2);
        if Hexa1 = 'FF' then
        begin
         Hexa1 := '00';
         Hexa2 := '00';
        end;
        if Hexa1 = 'FE' then Hexa1 := '00';
        if Hexa1 = 'FD' then
        begin
         Hexa1 := Hexa2;
         Hexa2 := '00';
        end;
        case BufI of
         1 : Res1 := StrToInt('$' + Hexa1 + Hexa2);
         2 : Res2 := StrToInt('$' + Hexa1 + Hexa2);
         3 : Res3 := StrToInt('$' + Hexa1 + Hexa2);
         4 : Res4 := StrToInt('$' + Hexa1 + Hexa2);
        end;
       end;
       BufI := Res1 * Key4;
       BufI2 := Res2 * Key3;
       Num1 := BufI - BufI2;
       Num1 := Num1 div Divzr;
       BufI := Res2 * Key1;
       BufI2 := Res1 * Key2;
       Num2 := BufI - BufI2;
       Num2 := Num2 div Divzr;
       BufI := Res3 * Key4;
       BufI2 := Res4 * Key3;
       Num3 := BufI - BufI2;
       Num3 := Num3 div Divzr;
       BufI := Res4 * Key1;
       BufI2 := Res3 * Key2;
       Num4 := BufI - BufI2;
       Num4 := Num4 div Divzr;
       BufS := BufS + Chr(Num1) + Chr(Num2) + Chr(Num3) + Chr(Num4);
       until Sc >= Sl;
      Result := BufS;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------

Вариант 9: (ДУБЛЬ???)

Шифрование:

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Шифрование строки
     
    Предназначена для простого шифрование строк и паролей, ключ 96 бит, шифрование
    симметричное.
     
    Зависимости: UBPFD.decrypt
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:   (c) Anatoly Podgoretsky, 1996
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    const
      StartKey = 471; // Start default key
      MultKey = 62142; // Mult default key
      AddKey = 11719; // Add default key
      // обязательно смените ключи до использования
     
    function Encrypt(const InString: string; StartKey, MultKey, AddKey: Integer):
      string;
    var
      I: Byte;
      // Если поменять тип переменной I на Integer, то будет возможно
      // шифрование текста длиной более 255 символом - VID.
    begin
      Result := '';
      for I := 1 to Length(InString) do
      begin
        Result := Result + CHAR(Byte(InString[I]) xor (StartKey shr 8));
        StartKey := (Byte(Result[I]) + StartKey) * MultKey + AddKey;
      end;
    end;

Пример использования: 

    if Encrypt(S, StartKey, MultKey, AddKey) <> OriginalPwd then
      ...

Расшифровка:

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Расшифровка строки
     
    Предназначена для расшифровки строки, ранее зашифрованной фукцией UBPFD.Encrypt
     
    Зависимости: UBPFD.Encrypt
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:   (c) Anatoly Podgoretsky, 1996
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    const
      StartKey = 471; // Start default key
      MultKey = 62142; // Mult default key
      AddKey = 11719; // Add default key
      // обязательно смените ключи до использования
     
    {$R-}
    {$Q-}
     
    function Decrypt(const InString: string; StartKey, MultKey, AddKey: Integer):
      string;
    var
      I: Byte;
      // Если поменять тип переменной I на Integer, то будет возможно
      // шифрование текста длиной более 255 символом - VID.
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

Вариант 10:

    const
      csCryptFirst = 20;
      csCryptSecond = 230;
      csCryptHeader = 'Crypted';
     
    type
      ECryptError = class(Exception);
     
    function CryptString(Str:String):String;
    var i,clen : Integer;
    begin
      clen := Length(csCryptHeader);
      SetLength(Result, Length(Str)+clen);
      Move(csCryptHeader[1], Result[1], clen);
      For i := 1 to Length(Str) do
       begin
        if i mod 2 = 0 then
         Result[i+clen] := Chr(Ord(Str[i]) xor csCryptFirst)
        else
         Result[i+clen] := Chr(Ord(Str[i]) xor csCryptSecond);
       end;
    end;
     
    function UnCryptString(Str:String):String;
    var i, clen : Integer;
    begin
      clen := Length(csCryptHeader);
      SetLength(Result, Length(Str)-clen);
      if Copy(Str, 1, clen) < > csCryptHeader then
       raise ECryptError.Create('UnCryptString failed');
     
      For i := 1 to Length(Str)-clen do
       begin
        if (i) mod 2 = 0 then
         Result[i] := Chr(Ord(Str[i+clen]) xor csCryptFirst)
        else
         Result[i] := Chr(Ord(Str[i+clen]) xor csCryptSecond);
       end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 11:

    unit EncodStr;
     
    interface
     
    uses
      Classes;
     
    type
      TEncodedStream = class (TFileStream)
      private
        FKey: Char;
      public
        constructor Create(const FileName: string; Mode: Word);
        function Read(var Buffer; Count: Longint): Longint; override;
        function Write(const Buffer; Count: Longint): Longint; override;
        property Key: Char read FKey write FKey default 'A';
      end;
     
    implementation
     
    constructor TEncodedStream.Create(
      const FileName: string; Mode: Word);
    begin
      inherited Create (FileName, Mode);
      FKey := 'A';
    end;
     
    function TEncodedStream.Write(const Buffer;
       Count: Longint): Longint;
    var
      pBuf, pEnc: PChar;
      I, EncVal: Integer;
    begin
      // allocate memory for the encoded buffer
      GetMem (pEnc, Count);
      try
        // use the buffer as an array of characters
        pBuf := PChar (@Buffer);
        // for every character of the buffer
        for I := 0 to Count - 1 do
        begin
          // encode the value and store it
          EncVal := ( Ord (pBuf[I]) + Ord(Key) ) mod 256;
          pEnc [I] := Chr (EncVal);
        end;
        // write the encoded buffer to the file
        Result := inherited Write (pEnc^, Count);
      finally
        FreeMem (pEnc, Count);
      end;
    end;
     
    function TEncodedStream.Read(var Buffer; Count: Longint): Longint;
    var
      pBuf, pEnc: PChar;
      I, CountRead, EncVal: Integer;
    begin
      // allocate memory for the encoded buffer
      GetMem (pEnc, Count);
      try
        // read the encoded buffer from the file
        CountRead := inherited Read (pEnc^, Count);
        // use the output buffer as a string
        pBuf := PChar (@Buffer);
        // for every character actually read
        for I := 0 to CountRead - 1 do
        begin
          // decode the value and store it
          EncVal := ( Ord (pEnc[I]) - Ord(Key) ) mod 256;
          pBuf [I] := Chr (EncVal);
        end;
      finally
        FreeMem (pEnc, Count);
      end;
      // return the number of characters read
      Result := CountRead;
    end;
     
    end.


    unit EncForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
      TFormEncode = class(TForm)
        Memo1: TMemo;
        Memo2: TMemo;
        OpenDialog1: TOpenDialog;
        SaveDialog1: TSaveDialog;
        Panel1: TPanel;
        BtnLoadPlain: TButton;
        BtnSaveEncoded: TButton;
        BtnLoadEncoded: TButton;
        Splitter1: TSplitter;
        procedure BtnSaveEncodedClick(Sender: TObject);
        procedure BtnLoadEncodedClick(Sender: TObject);
        procedure BtnLoadPlainClick(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      FormEncode: TFormEncode;
     
    implementation
     
    {$R *.DFM}
     
    uses
      EncodStr;
     
    procedure TFormEncode.BtnSaveEncodedClick(Sender: TObject);
    var
      EncStr: TEncodedStream;
    begin
      if SaveDialog1.Execute then
      begin
        EncStr := TEncodedStream.Create(
          SaveDialog1.Filename, fmCreate);
        try
          Memo1.Lines.SaveToStream (EncStr);
        finally
          EncStr.Free;
        end;
      end;
    end;
     
    procedure TFormEncode.BtnLoadEncodedClick(Sender: TObject);
    var
      EncStr: TEncodedStream;
    begin
      if OpenDialog1.Execute then
      begin
        EncStr := TEncodedStream.Create(
          OpenDialog1.FileName, fmOpenRead);
        try
          Memo2.Lines.LoadFromStream (EncStr);
        finally
          EncStr.Free;
        end;
      end;
    end;
     
    procedure TFormEncode.BtnLoadPlainClick(Sender: TObject);
    begin
      if OpenDialog1.Execute then
        Memo1.Lines.LoadFromFile (
          OpenDialog1.FileName);
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
