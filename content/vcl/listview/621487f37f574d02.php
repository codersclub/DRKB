<h1>Как узнать, по какой колонке был клик в TListView?</h1>
<div class="date">01.01.2007</div>


<p>Метод GetItemAt позволяет получить координаты ListItem, по которой был клик, но только для первой колонки TListView. Если нужно узнать по какому элементу из другой колонки кликнул пользователь, то прийдётся объявить новый метод в наследованном классе:</p>
<pre>
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
  if Result &lt;&gt; nil then begin
    Col := 0; // Первая колонка
  end else if (ViewStyle = vsReport)
      and (TopItem &lt;&gt; nil) then begin
    // Первая, попробуем найти строку
    ListItem := GetItemAt(TopItem.Position.X, Y);
    if ListItem &lt;&gt; nil then begin
      // Теперь попробуем найти колонку
      RelativeX := X-ListItem.Position.X-BorderWidth;
      ColStartX := Columns[0].Width;
      n := Columns.Count - 1;
      for i := 1 to n do begin
        if RelativeX &lt; ColStartX then break;
        if RelativeX &lt;= ColStartX +
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
</pre>

<p>А вот так выглядит событие MouseDown:</p>

<pre>
procedure TForm1.ListView1MouseDown(Sender: TObject;
  Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
var
  col: integer;
  li: TListItem;
begin
  li := TListViewX(ListView1).GetItemAtX(x, y, col);
  if li &lt;&gt; nil then
    ShowMessage('Column #' + IntToStr(col));
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
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
  if li &lt;&gt; nil then ShowMessage('Column #' + IntToStr(col));
end;
}
var
  i, RelativeX, ColStartX: Integer;
  ListItem: TlistItem;
  HTI: TLVHitTestInfo;
begin
  Result:= lsv.GetItemAt(X, Y);
  if Result &lt;&gt; nil then begin
    Col:= 0; // Первая колонка
  end
  else if (lsv.ViewStyle = vsReport) and (lsv.TopItem &lt;&gt; nil) then begin
    HTI.pt.x:= X;
    HTI.pt.y:= Y;
    lsv.Perform(LVM_SUBITEMHITTEST, 0, Integer(@HTI));
    Col:= HTI.iSubItem;
    Result:= lsv.Items[HTI.iItem];
  end;
end;
</pre>

<hr />
<pre>
procedure TFormMain.Listview1ColumnClick(Sender: TObject; Column: TListColumn);
 var
   ColumnNr: Integer;
 begin
   ColumnNr := Listview1.Column[Column.Index].Index;
   ShowMessage(IntToStr(ColumnNr));
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
