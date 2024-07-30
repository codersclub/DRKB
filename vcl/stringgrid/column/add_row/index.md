---
Title: Вставка строки в TStringGrid
Author: Борис Новгородов (MBo), mbo@mail.ru
Date: 27.04.2002
---


Вставка строки в TStringGrid
============================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Вставка строки в StringGrid
     
    Вставляет новую строку в указанную позицию StringGrid
     
    Зависимости: Grids
    Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
    Copyright:   MBo
    Дата:        27 апреля 2002 г.
    ***************************************************** }
     
    procedure SGInsertRow(SG: TStringGrid; NewRow: Integer);
    var
      i: Integer;
    begin
      if NewRow < 0 then
        NewRow := 0; // либо 1, задайте нужное вам поведение
      with SG do
      begin
        RowCount := RowCount + 1;
        if NewRow < RowCount - 1 then
        begin
          for i := RowCount - 1 downto NewRow + 1 do
            Rows[i].Assign(Rows[i - 1]);
        end;
        Rows[NewRow].Clear;
      end;
    end;
