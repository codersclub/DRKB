---
Title: Как узнать, по какой колонке был клик в TListView?
Date: 01.01.2007
---


Как узнать, по какой колонке был клик в TListView?
==================================================

Вариант 1:

Source: <https://forum.sources.ru>

Метод GetItemAt позволяет получить координаты ListItem, по которой был
клик, но только для первой колонки TListView. Если нужно узнать по
какому элементу из другой колонки кликнул пользователь, то прийдётся
объявить новый метод в наследованном классе:

    uses ComCtrls;
     
    type
      TListViewX = class(TListView)
      public
        function GetItemAtX(X, Y: integer; var Col: integer): TListItem;
      end;
     
    implementation
     
    function TListViewX.GetItemAtX(X, Y: integer;
        var Col: integer): TListItem;
    var
      i, n, RelativeX, ColStartX: Integer;
      ListItem: TlistItem;
    begin
      Result := GetItemAt(X, Y);
      if Result <> nil then begin
        Col := 0; // Первая колонка
      end else if (ViewStyle = vsReport)
          and (TopItem <> nil) then begin
        // Первая, попробуем найти строку
        ListItem := GetItemAt(TopItem.Position.X, Y);
        if ListItem <> nil then begin
          // Теперь попробуем найти колонку
          RelativeX := X-ListItem.Position.X-BorderWidth;
          ColStartX := Columns[0].Width;
          n := Columns.Count - 1;
          for i := 1 to n do begin
            if RelativeX < ColStartX then break;
            if RelativeX <= ColStartX +
                StringWidth(ListItem.SubItems[i-1]) then
            begin
              Result := ListItem;
              Col := i;
              break;
            end;//if
            Inc(ColStartX, Columns[i].Width);
          end;//for
        end;//if
      end;//if
    end;

А вот так выглядит событие MouseDown:

    procedure TForm1.ListView1MouseDown(Sender: TObject;
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    var
      col: integer;
      li: TListItem;
    begin
      li := TListViewX(ListView1).GetItemAtX(x, y, col);
      if li <> nil then
        ShowMessage('Column #' + IntToStr(col));
    end;


------------------------------------------------------------------------

Вариант 2:

    function acGetItemAt(lsv: TListView; X, Y: integer; var Col: integer): TListItem;
    // Получение по координатам элемента, над которым пользователь щелкнул.
    {  Пример использования:
    procedure TForm1.ListView1MouseDown(Sender: TObject;
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    var
      col: Integer;
      li: TListItem;
    begin
      li:= acGetItemAt(ListView1, x, y, col);
      if li <> nil then ShowMessage('Column #' + IntToStr(col));
    end;
    }
    var
      i, RelativeX, ColStartX: Integer;
      ListItem: TlistItem;
      HTI: TLVHitTestInfo;
    begin
      Result:= lsv.GetItemAt(X, Y);
      if Result <> nil then begin
        Col:= 0; // Первая колонка
      end
      else if (lsv.ViewStyle = vsReport) and (lsv.TopItem <> nil) then begin
        HTI.pt.x:= X;
        HTI.pt.y:= Y;
        lsv.Perform(LVM_SUBITEMHITTEST, 0, Integer(@HTI));
        Col:= HTI.iSubItem;
        Result:= lsv.Items[HTI.iItem];
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    procedure TFormMain.Listview1ColumnClick(Sender: TObject; Column: TListColumn);
     var
       ColumnNr: Integer;
     begin
       ColumnNr := Listview1.Column[Column.Index].Index;
       ShowMessage(IntToStr(ColumnNr));
     end;

