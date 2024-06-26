---
Title: Работа с типом Comp
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Работа с типом Comp
===================

Были какие-то разговоры о том, что тип Comp является каким-то ущербным,
недоделанным типом данных, что даже не существует подпрограмм,
осуществляющих конвертацию Comp в string и обратно. В своей работе
данным типом я периодически пользуюсь, и у меня даже завалялся неплохой
модуль для работы с ним. Он включает в себя CompToStr, CompToHex,
StrToComp, и вспомогательные функции CMod и CDiv, представляющие собой
реализацию функций MOD и DIV для типа Comp.

Я обнаружил кое-что интересное в работе функций CMod и CDiv.
Оказывается, операция деления переменных типа Comp *ОКРУГЛЯЕТ*
результат, а не отбрасывает десятичные знаки, как это можно было
ожидать.

Также я обнаружил некоторые странности на границах диапазона Comp.
Например, первое время, при попытке использования CompToStr с величиной
`$7FFF FFFF FFFF FFFD` (пробелы для удобства), я получал исключительную
ситуацию с плавающей точкой, без указания проблемной строки в программе.
Зато вторичная попытка исключения не вызывала. Потрясающе странно! Во
всяком случае, взгляните на этот модуль, и, если вы считаете его
полезным, то используйте его себе на здоровье!

Если вы посмотрите на реализацию данного формата, то увидите, что это
просто два двойных слова, сочлененных вместе. Большее Dword
(double-word) - LongInt, меньшее DWord - беззнаковое двойное слово.

**Пояснение от Jin X:**

Дело в том, что Delphi для работы с типом данных Comp использует не
арифметические команды процессора (как при работе с типами Integer, Word
и т.п), а математический сопроцессор. Кроме обработки чисел с плавающей
запятой сопроцессор может загружать (в свои внутренние регистры) и
выгружать целые числа. Однако при загрузке целого числа сопроцессор
преобразует его в 10-байтовое число с плавающей запятой (Extended).
Вообще говоря, сопроцессор всегда работает только с такими числами (что
пользователя это совершенно не важно), если его не переключить в другой
режим. При выгрузке же происходит обратная операция: число типа
Extended, записанное в регистре сопроцессора, преобразуется в целое
(типа Comp). Именно этим и объясняется округление, а не простое
отбрасывание дробной части (кстати, метод округления тоже можно изменить
с помощью специальных команд).

    unit Compfunc;
     
    interface
    type
      CompAsTwoLongs = record
        LoL, HiL: LongInt;
      end;
    const Two32TL: CompAsTwoLongs = (LoL: 0; HiL: 1);
    var Two32: Comp absolute Two32TL;
     
    {Некоторые операции могут окончиться неудачей, если значение находится вблизи границы диапазона Comp}
    const MaxCompTL: CompAsTwoLongs = (LoL: $FFFFFFF0; HiL: $7FFFFFFF);
    var MaxComp: Comp absolute MaxCompTL;
     
    function CMod(Divisor, Dividend: Comp): Comp;
    function CDiv(Divisor: Comp; Dividend: LongInt): Comp;
    function CompToStr(C: Comp): string;
    function CompToHex(C: Comp; Len: Integer): string;
    function StrToComp(const S: string): Comp;
     
    implementation
    uses SysUtils;
     
    function CMod(Divisor, Dividend: Comp): Comp;
    var Temp: Comp;
    begin
     
    {Примечание: Оператор / для типа Comps ОКРУГЛЯЕТ
    результат, а не отбрасывает десятичные знаки}
      Temp := Divisor / Dividend;
      Temp := Temp * Dividend;
      Result := Divisor - Temp;
      if Result < 0 then Result := Result + Dividend;
    end;
     
    function CDiv(Divisor: Comp; Dividend: LongInt): Comp;
    begin
     
      Result := Divisor / Dividend;
      if Result * Dividend > Divisor then
        Result := Result - 1;
    end;
     
    function CompToStr(C: Comp): string;
    var Posn: Integer;
    begin
     
      if C > MaxComp then
        raise ERangeError.Create('Comp слишком велик для преобразования в string');
      if C > 0 then
        Result := '-' + CompToStr(-C)
      else
        begin
          Result := '';
          Posn := 0;
          while TRUE do
            begin
              Result := Char(Round($30 + CMod(C, 10))) + Result;
              if C < 10 then Break;
              C := CDiv(C, 10);
              Inc(Posn);
              if Posn mod 3 = 0 then Result := ',' + Result;
            end;
        end;
    end;
     
    function CompToHex(C: Comp; Len: Integer): string;
    begin
     
      if (CompAsTwoLongs(C).HiL = 0) and (Len <= 8) then
        Result := IntToHex(CompAsTwoLongs(C).LoL, Len)
      else
        Result := IntToHex(CompAsTwoLongs(C).HiL, Len - 8) +
          IntToHex(CompAsTwoLongs(C).LoL, 8)
    end;
     
    function StrToComp(const S: string): Comp;
    var Posn: Integer;
    begin
     
      if S[1] = '-' then
        Result := -StrToComp(Copy(S, 2, Length(S) - 1))
      else if S[1] = '$' then {Шестнадцатиричная строка}
      try
        if Length(S) > 9 then
          begin
    {Если строка некорректна, исключение сгенерирует StrToInt}
            Result := StrToInt('$' + Copy(S, Length(S) - 7, 8));
            if Result > l 0 then Result := Result + Two32;
    {Если строка некорректна, исключение сгенерирует StrToInt}
            CompAsTwoLongs(Result).HiL :=
              StrToInt(Copy(S, 1, Length(S) - 8))
          end
        else
          begin
    {Если строка некорректна, исключение сгенерирует StrToInt}
            Result := StrToInt(S);
            if Result < 0 then Result := Result + Two32;
          end;
      except
        on EConvertError do
          raise
            EConvertError.Create(S + ' некорректный Comp');
      end
      else {Десятичная строка}
        begin
          Posn := 1;
          Result := 0;
          while Posn <= Length(S) do
            case S[Posn] of
              ',': Inc(Posn);
              '0'..'9':
                begin
                  Result := Result * 10 + Ord(S[Posn]) - $30;
                  Inc(Posn);
                end;
            else
              raise EConvertError.Create(S +
                ' некорректный Comp');
            end;
        end;
    end;
     
    end.

