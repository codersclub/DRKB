---
Title: Как удалить строку из TStringGrid в runtime?
Date: 01.01.2007
---


Как удалить строку из TStringGrid в runtime?
============================================

Вариант 1:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

Можно сделать наследника от TCustomGrid. А у последнего есть метод -
DeleteRow.

------------------------------------------------------------------------

Вариант 2:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

Например удаление текущей строки:

    Type TFakeGrid=class(TCustomGrid);

     
    procedure TForm1.MyDelete(Sender: TObject);
    begin
      TFakeGrid(Grid).DeleteRow(Grid.row);
    end;

**Примечание от bur80 (Sources.ru):**

Предлагаю в разделе VCL -\> StringGrid внести корректировочку в статью
"Как удалить строку в StringGrid в run-time", о том, что данный метод (!)
будет работать только в случае если форма создаётся вот так:

    ...
    Form1.ShowModal;
    ...


а не так:

    ...
    var
    fr1 : TForm1;
    begin
    fr1 := Tform1.Create(Application);
    fr1.Show;
    ...



------------------------------------------------------------------------

Вариант 3:

Author: Борис Новгородов (MBo), mbo@mail.ru

Date: 27.04.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Удаление строки из StringGrid
     
    Удаляет из StringGrid указанную строку, сдвигая остальные.
     
    Зависимости: Grids
    Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
    Copyright:   MBo
    Дата:        27 апреля 2002 г.
    ***************************************************** }
     
    procedure SGDeleteRow(SG: TStringGrid; RowToDelete: Integer);
    var
      i: Integer;
    begin
      with SG do
      begin
        if (RowToDelete >= 0) and (RowToDelete < RowCount) then
        begin
          for i := RowToDelete to RowCount - 2 do
            Rows[i].Assign(Rows[i + 1]);
          RowCount := RowCount - 1;
        end;
      end;
    end;

------------------------------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

    procedure GridDeleteRow(RowNumber: Integer; Grid: TstringGrid);
     var
       i: Integer;
     begin
       Grid.Row := RowNumber;
       if (Grid.Row = Grid.RowCount - 1) then
         { On the last row}
         Grid.RowCount := Grid.RowCount - 1
       else
       begin
         { Not the last row}
         for i := RowNumber to Grid.RowCount - 1 do
           Grid.Rows[i] := Grid.Rows[i + 1];
         Grid.RowCount := Grid.RowCount - 1;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       GridDeleteRow(3, stringGrid1);
     end;

