---
Title: Копирование содержимого TStringGrid в буфер обмена
Author: Борис Новгородов (MBo), mbo@mail.ru
Date: 30.04.2002
---


Копирование содержимого TStringGrid в буфер обмена
==================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Копирование содержимого StringGrid в буфер обмена
     
    Копирует содержимое ячеек StringGrid в ClipBoard в формате, позволяющем
    вставку, например, в Word или Excel. При CopySel=True копирует выделение,
    иначе всю таблицу или указанный диапазон (CL - левый столбец и т.д.).
     
    Зависимости: Grids
    Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
    Copyright:   MBo
    Дата:        30 апреля 2002 г.
    ***************************************************** }
     
    procedure SGCopyToCLP(SG: TStringGrid; CopySel: Boolean; CL: integer = -1;
      RT: integer = -1; CR: integer = -1; RB: integer = -1);
    var
      i, j: Integer;
      s: string;
    begin
      s := '';
      with SG do
      begin
        if CopySel then
        begin
          CL := Selection.Left;
          CR := Selection.Right;
          RT := Selection.Top;
          RB := Selection.Bottom;
        end;
        //при необходимости FixedRows и FixedCols можно заменить на 0
        if (CL < FixedCols) or (CL > CR) or (CL >= ColCount) then
          CL := FixedCols;
        if (CR < FixedCols) or (CL > CR) or (CR >= ColCount) then
          CR := ColCount - 1;
        if (RT < FixedRows) or (RT > RB) or (RT >= RowCount) then
          RT := FixedRows;
        if (RB < FixedCols) or (RT > RB) or (RB >= RowCount) then
          RB := RowCount - 1;
        for i := RT to RB do
        begin
          for j := CL to CR do
          begin
            s := s + Cells[j, i];
            if j < CR then
              s := s + #9;
          end;
          s := s + #13#10;
      end;
      end;
      ClipBoard.AsText := s;
    end;
     
    // Пример использования:
    SGCopyToCLP(StringGrid1, True); //выделение
    SGCopyToCLP(StringGrid1, False); //все ячейки
    SGCopyToCLP(StringGrid1, False, 1, 1, 3, 2); //диапазон, 6 ячеек
