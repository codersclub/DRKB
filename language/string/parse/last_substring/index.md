---
Title: Нахождение последнего вхождения подстроки в строку
Date: 01.01.2007
---


Нахождение последнего вхождения подстроки в строку
==================================================

Вариант 1:

Author: Федоровских Николай (Fenik,) chook_nu@uraltc.ru

Date: 16.06.2002


    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Нахождение последнего вхождения подстроки в строку
     
    Функция возвращает начало последнего вхождения
    подстроки FindS в строку SrcS, т.е. первое с конца.
    Если возвращает ноль, то подстрока не найдена.
    Можно использовать в текстовых редакторах
    при поиске текста вверх от курсора ввода.
     
    Зависимости: System
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор: Федоровских Николай
    Дата:        16 июня 2002 г.
    ***************************************************** }
     
    function PosR2L(const FindS, SrcS: string): Integer;
    {Функция возвращает начало последнего вхождения
     подстроки FindS в строку SrcS, т.е. первое с конца.
     Если возвращает ноль, то подстрока не найдена.
     Можно использовать в текстовых редакторах
     при поиске текста вверх от курсора ввода.}
     
      function InvertS(const S: string): string;
        {Инверсия строки S}
      var
        i, Len: Integer;
      begin
        Len := Length(S);
        SetLength(Result, Len);
        for i := 1 to Len do
          Result[i] := S[Len - i + 1];
      end;
     
    var
      ps: Integer;
    begin
      {Например: нужно найти последнее вхождение
       строки 'ро' в строке 'пирожок в коробке'.
       Инвертируем обе строки и получаем
         'ор' и 'екборок в кожорип',
       а затем ищем первое вхождение с помощью стандартной
       функции Pos(Substr, S: string): string;
       Если подстрока Substr есть в строке S, то
       эта функция возвращает позицию первого вхождения,
       а иначе возвращает ноль.}
      ps := Pos(InvertS(FindS), InvertS(SrcS));
      {Если подстрока найдена определяем её истинное положение
       в строке, иначе возвращаем ноль}
      if ps <> 0 then
        Result := Length(SrcS) - Length(FindS) - ps + 2
      else
        Result := 0;
    end;
    Пример использования: 
     
    p := PosR2L('са', 'Мой сапог догнал самолёт.'); // p:=18;

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    { 
      Letzte Position von SubStr in S ermitteln. 
      Returns the last occurence of SubStr in S. 
    }
     
     function LastPos(SubStr, S: string): Integer;
     var
       Found, Len, Pos: integer;
     begin
       Pos := Length(S);
       Len := Length(SubStr);
       Found := 0;
       while (Pos > 0) and (Found = 0) do
       begin
         if Copy(S, Pos, Len) = SubStr then
           Found := Pos;
         Dec(Pos);
       end;
       LastPos := Found;
     end;

------------------------------------------------------------------------

Вариант 3:

Author: Manuel Wiersch 

Source: <https://www.swissdelphicenter.ch>

     // by Manuel Wiersch 
     
     function LastPos(const SubStr: AnsiString; const S: AnsiString): LongInt;
     asm
            TEST    EAX,EAX         // EAX auf 0 prufen (d.h. SubStr = nil) 
            JE      @@noWork        // wenn EAX = 0 dann Sprung zu noWork 
            TEST    EDX,EDX
            // Test ob S = nil 
            JE      @@stringEmpty   // bei Erfolg -> Sprung zum Label 'stringEmpty' 
            PUSH    EBX
            PUSH    ESI
            PUSH    EDI             // Register auf dem Stack sichern  Grund: OH 
                                    // OH: "In einer asm-Anweisung mu? der Inhalt 
                                    // der Register EDI, ESI, ESP, EBP und EBX 
                                    // erhalten bleiben (dh. vorher auf dem Stack 
                                    // speichern)         MOV     ESI, EAX 
                                    // ESI = Sourceindex      -> Adresse vom SubStr 
            MOV     EDI, EDX        // EDI = Destinationindex -> Adresse von S 
            MOV     ECX,[EDI-4]     // Lange von S  ins Zahlregister 
            MOV     EDX,[ESI-4]     // Lange des SubStr in EDX 
            DEC     EDX             // Length(SubStr) - 1 
            JS      @@fail
            // Vorzeichenbedingter Sprung (JumpIfSign) 
                                    // d.h. (EDX < 0) -> Sprung zu 'fail' 
            STD;                    // SetDirectionFlag -> Stringroutinen von hinten 
                                    // abarbeiten 
            ADD     ESI, EDX        // Pointer auf das letzte Zeichen vom SubStr 
            ADD     EDI, ECX
            DEC     EDI             // Pointer auf das letzte Zeichen von S 
            MOV     AL, [ESI]       // letztes Zeichen des SubStr in AL laden 
            DEC     ESI             // Pointer auf das vorletzte Zeichen setzen. 
            SUB     ECX, EDX        // Anzahl der Stringdurchlaufe 
                                    // = Length(s) - Length(substr) + 1 
            JLE     @@fail          // Sprung zu 'fail' wenn ECX <= 0 
    @@loop:
            REPNE   SCASB           // Wdh. solange ungleich (repeat while not equal) 
                                    // scan string for byte 
            JNE     @@fail
            MOV     EBX,ECX         { Zahleregister, ESI und EDI sichern, da nun der 
                                      Vergleich durchgefuhrt wird ob die nachfolgenden 
                                      Zeichen von SubStr in S vorhanden sind }
            PUSH    ESI
            PUSH    EDI
            MOV     ECX,EDX         // Lange des SubStrings in ECX 
            REPE    CMPSB           // Solange (ECX > 0) und (Compare string fo byte) 
                                    // dh. solange S[i] = SubStr[i] 
            POP     EDI
            POP     ESI             // alten Source- und Destinationpointer vom Stack holen 
            JE      @@found         // Und schon haben wir den Index da ECX = 0 
                                    // dh. alle Zeichen wurden gefunden 
            MOV     ECX, EBX        // ECX wieder auf alte Anzahl setzen und 
            JMP     @@loop          // Start bei 'loop' 
    @@fail:
            XOR     EAX,EAX         // EAX auf 0 setzen 
            JMP     @@exit @@stringEmpty:
            XOR     EAX,EAX
            JMP     @@noWork @@found:
            MOV     EAX, EBX        // in EBX steht nun der aktuelle Index 
            INC     EAX             // um 1 erhohen, um die Position des 1. Zeichens zu 
                                    // bekommen 
    @@exit:
            POP     EDI
            POP     ESI
            POP     EBX
    @@noWork:         CLD;          // DirectionFlag loschen 
    end;

