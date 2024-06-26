---
Title: Как преобразовать http://192.168.1.2 в http://3232235778?
Author: Roni Havas
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как преобразовать http://192.168.1.2 в http://3232235778?
=========================================================

Функция, представленная в этом примере может быть и не очень элегантна,
зато работает. Функция получает в качестве параметра строку, содержащую
IP адрес, и возвращает строку с IP адресом в виде DWord значения.
Результат легко можно проверить командой "Ping".

Совместимость: Delphi (все версии)

Обратите внимание, что необходимо добавить "Math" в "Uses" для
функции "IntPower";

    function IP2HEX(OrgIP: string): string;
    var OrgVal: string; // Сохраняем оригинальное значение IP адреса
      O1, O2, O3, O4: string; // части оригинального IP
      H1, H2, H3, H4: string; // шестнадцатиричные части
      HexIP: string; // Здесь будут собраны все шестнадцатиричные части
      XN: array[1..8] of Extended;
      Flt1: Extended;
      Xc: Integer;
    begin
     
      // Сохраняем в обратном порядке для простого случая
      Xn[8] := IntPower(16, 0);
      Xn[7] := IntPower(16, 1);
      Xn[6] := IntPower(16, 2);
      Xn[5] := IntPower(16, 3);
      Xn[4] := IntPower(16, 4);
      Xn[3] := IntPower(16, 5);
      Xn[2] := IntPower(16, 6);
      Xn[1] := IntPower(16, 7);
     
      // Сохраняем оригинальный IP адрес
      OrgVal := OrgIP;
      O1 := Copy(OrgVal, 1, Pos('.', OrgVal) - 1); Delete(OrgVal, 1, Pos('.', OrgVal));
      O2 := Copy(OrgVal, 1, Pos('.', OrgVal) - 1); Delete(OrgVal, 1, Pos('.', OrgVal));
      O3 := Copy(OrgVal, 1, Pos('.', OrgVal) - 1); Delete(OrgVal, 1, Pos('.', OrgVal));
      O4 := OrgVal;
     
      H1 := IntToHex(StrToInt(O1), 2); H2 := IntToHex(StrToInt(O2), 2);
      H3 := IntToHex(StrToInt(O3), 2); H4 := IntToHex(StrToInt(O4), 2);
     
      // Получаем шестнадцатиричное значение IP адреса
      HexIP := H1 + H2 + H3 + H4;
     
      // Преобразуем это большое шестнадцатиричное значение в переменную Float
      Flt1 := 0;
      for Xc := 1 to 8 do
        begin
          case HexIP[Xc] of
            '0'..'9': Flt1 := Flt1 + (StrToInt(HexIP[XC]) * Xn[Xc]);
            'A': Flt1 := Flt1 + (10 * Xn[Xc]);
            'B': Flt1 := Flt1 + (11 * Xn[Xc]);
            'C': Flt1 := Flt1 + (12 * Xn[Xc]);
            'D': Flt1 := Flt1 + (13 * Xn[Xc]);
            'E': Flt1 := Flt1 + (14 * Xn[Xc]);
            'F': Flt1 := Flt1 + (15 * Xn[Xc]);
          end;
        end;
      Result := FloatToStr(Flt1);
    end;

