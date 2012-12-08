---
Title: Обмен строк TStringGrid
Date: 01.01.2007
---


Обмен строк TStringGrid
=======================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Обмен строк StringGrid
     
    Обмен содержимого указанных строк StringGrid.
    Варианты без копирования связанных с ячейками объектов и вместе с ними.
     
    Зависимости: Grids
    Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
    Copyright:   MBo
    Дата:        27 апреля 2002 г.
    ***************************************************** }
     
    procedure SGExchangeRows(SG: TStringGrid; Row1, Row2: Integer);
    var
      TempString: string;
    begin
      if (Row1 in [0..SG.RowCount - 1]) and (Row2 in [0..SG.RowCount - 1]) then
      begin
        TempString := SG.Rows[Row1].Text;
        SG.Rows[Row1].Assign(SG.Rows[Row2]);
        SG.Rows[Row2].Text := TempString;
      end;
    end;
     
    procedure SGExchRowsWithObj(SG: TStringGrid; Row1, Row2: Integer);
    var
      TempList: TStringList;
    begin
      with SG do
        if (Row1 in [0..RowCount - 1]) and (Row2 in [0..RowCount - 1]) then
        begin
          TempList := TStringList.Create;
          TempList.Assign(Rows[Row1]);
          Rows[Row1].Assign(Rows[Row2]);
          Rows[Row2].Assign(TempList);
          TempList.Free;
        end;
    end;
