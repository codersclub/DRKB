---
Title: Алгоритм расчета контрольного числа страхового номера ПФ
Author: Камбалов А.Н., ACampball@mail.ru
Date: 03.06.2002
---


Алгоритм расчета контрольного числа страхового номера ПФ
========================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Алгоритм расчета контрольного числа страхового номера ПФ
     
    Зависимости: System, Sysutils
    Автор:       Камбалов А.Н., ACampball@mail.ru, Вологда
    Copyright:   Камбалов А.Н.
    Дата:        3 июня 2002 г.
    ********************************************** }
     
    // ===========================================
    // Алгоритм расчета контрольного числа
    // страхового номера ПФ
    // ===========================================
    function CheckPFCertificate(const PF: string): Boolean;
    var
      sum: Word;
      i: Byte;
    begin
      Result := False;
      sum := 0;
      if Length(PF) <> 11 then Exit;
     
      try
        for i:=1 to 9 do
          sum := sum + StrToInt(PF[i])*(9-i+1);
        sum := sum mod 101;
        Result := StrToInt(Copy(PF, 10, 2)) = sum;
      except
        Result := False;
      end; // try
    end;
