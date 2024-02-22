---
Title: Метод Гаусса решения системы линейных уравнений
Author: Mystic, mystic2000@newmail.ru
Date: 25.04.2002
---


Метод Гаусса решения системы линейных уравнений
===============================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Метод Гаусса решения системы линейных уравнений
     
    Рещение системы линейных уравнений (возможно переопределенной) методом Гаусса.
    Определяется ситуация, что система не имеет рещений. Ситуация, когда система 
    имеет более чем одно решение не рассматривается. В случае удачного завершения 
    возвращает нуль.
     
    Зависимости: System
    Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
    Copyright:   (C) Mystic
    Дата:        25 апреля 2002 г.
    ********************************************** }
     
    function LinGauss(M, N: Integer; Data: PExtended; X: PExtended): Cardinal;
    var
      PtrData: PExtended;
      PtrData1, PtrData2: PExtended;
      Temp: Extended;
      I, J, Row: Integer;
      Max: Extended;
      MaxR: Integer;
    begin
      Assert(M >= N, 'Invalid start data');
      for I := 0 to N-1 do // Для каждой переменной
      begin
     
        // 1. Поиск максимального элемента
        PChar(PtrData) := PChar(Data) + I*(N+2)*SizeOf(Extended);
        MaxR := I;
        Max := PtrData^;
        for J := I+1 to M-1 do
        begin
          PChar(PtrData) := PChar(PtrData) + (N+1)*SizeOf(Extended);
          if Abs(PtrData^) > Abs(Max) then
          begin
            Max := PtrData^;
            MaxR := J;
          end;
        end;
     
        // 2. А вдруг неразрешима?
        if Abs(Max) < 1.0E-10 then
        begin
          Result := $FFFFFFFF;
          Exit;
        end;
     
        // 3. Меняем местами строки
        if MaxR <> I then
        begin
          PChar(PtrData1) := PChar(Data) + MaxR*(N+1)*SizeOf(Extended);
          PChar(PtrData2) := PChar(Data) + I*(N+1)*SizeOf(Extended);
          for J := 0 to N do
          begin
            Temp := PtrData1^;
            PtrData1^ := PtrData2^;
            PtrData2^ := Temp;
            PChar(PtrData1) := PChar(PtrData1) + SizeOf(Extended);
            PChar(PtrData2) := PChar(PtrData2) + SizeOf(Extended);
          end;
        end;
     
        // 4. Пересчет направляющей строки
        PChar(PtrData) := PChar(Data) + I*(N+1)*SizeOf(Extended);
        for J := 0 to N do
        begin
          PtrData^ := PtrData^ / Max;
          PChar(PtrData) := PChar(PtrData) + SizeOf(Extended);
        end;
     
        // 5. Пересчет всей оставшйся части таблицы
        PtrData1 := Data;
        for Row := 0 to M-1 do
        begin
          if Row = I then
          begin
            PChar(PtrData1) := PChar(PtrData1) + (N+1)*SizeOf(Extended);
            Continue;
          end;
          PChar(PtrData2) := PChar(Data) + I*(N+1)*SizeOf(Extended);
          Temp := PExtended(PChar(PtrData1) + I*SizeOf(Extended))^;
          for J := 0 to N do
          begin
            PtrData1^ := PtrData1^ - Temp * PtrData2^;
            PChar(PtrData1) := PChar(PtrData1) + SizeOf(Extended);
            PChar(PtrData2) := PChar(PtrData2) + SizeOf(Extended);
          end;
        end;
      end;
     
      // 6. Проверка того, что система переопределена
      PChar(PtrData) := PChar(Data) + N*(N+1)*SizeOf(Extended);
      for I := N to M-1 do
        for J := 0 to N do
        begin
          if Abs(PtrData^) > 1.0E-10 then
          begin
            Result := $FFFFFFFF;
            Exit;
          end;
          PChar(PtrData) := PChar(PtrData) + SizeOf(Extended);
        end;
     
      // Все ОК
      PChar(PtrData) := PChar(Data) + N*SizeOf(Extended);
      for I := 0 to N-1 do
      begin
        X^ := PtrData^;
        PChar(X) := PChar(X) + SizeOf(Extended);
        PChar(PtrData) := PChar(PtrData) + (N+1) * SizeOf(Extended);
      end;
      Result := 0;
    end;
