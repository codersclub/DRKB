---
Title: Как перемещать строки и колонки в TStringGrid?
Date: 01.01.2007
---


Как перемещать строки и колонки в TStringGrid?
==============================================

::: {.date}
01.01.2007
:::

Пользователь может перемещать строки и колонки StringGrid при помощи
мышки. Можно ли это сделать программно? В описании TCustomGrid можно
увидеть методы MoveColumn и MoveRow, однако они скрыты в TStringGrid. Но
нам ничего не мешает просабклассить TStringGrid и объявить эти методы
как public:

    type
      TStringGridX = class(TStringGrid)
      public
        procedure MoveColumn(FromIndex, ToIndex: Longint);
        procedure MoveRow(FromIndex, ToIndex: Longint);
      end;

Чтобы воспользоваться этими методами, достаточно вызвать соответствующий
метод предка:

    procedure TStringGridX.MoveColumn(FromIndex, ToIndex: Integer);
    begin
      inherited;
    end;
     
    procedure TStringGridX.MoveRow(FromIndex, ToIndex: Integer);
    begin
      inherited;
    end;

Этот компонент не нужно регистрировать в палитре компонентов. Просто
используйте потомка TStringGrid или любого TCustomGrid, и вызывайте его
методы:

      procedure TForm1.Button1Click(Sender: TObject); 
      begin 
        TStringGridX(StringGrid1).MoveColumn(1, 3); 
      end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Примечание от Vit: код можно написать значительно компактнее:

     type TFake = class(TStringGrid);
    ...
     
      procedure TForm1.Button1Click(Sender: TObject); 

      begin 
        TFake(StringGrid1).MoveColumn(1, 3); 
      end;

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Перестановка строки в StringGrid в другую позицию
     
    Передвигает строку StringGrid из позиции FromRow в позицию ToRow, сдвигая остальные
     
    Зависимости: Grids
    Автор:       Борис Новгородов (MBo), mbo@mail.ru, Новосибирск
    Copyright:   MBo
    Дата:        28 апреля 2002 г.
    ***************************************************** }
     
    procedure SGMoveRow(SG: TStringGrid; FromRow, ToRow: Integer);
    var
      TempList: TStringList;
      i: Integer;
    begin
      with SG do
        if (FromRow in [0..RowCount - 1]) and (ToRow in [0..RowCount - 1]) then
        begin
          TempList := TStringList.Create;
          TempList.Assign(Rows[FromRow]);
          if FromRow > ToRow then
            for i := FromRow downto ToRow + 1 do
              Rows[i].Assign(Rows[i - 1])
          else
            for i := FromRow to ToRow - 1 do
              Rows[i].Assign(Rows[i + 1]);
          Rows[ToRow].Assign(TempList);
          TempList.Free;
        end;
    end;
     
