<h1>Сортировка TListView</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ: <a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Сортировка ListView в режиме vsReport при нажатии на заголовок колонки</p>
<pre>
function CustomDateSortProc(Item1, Item2: TListItem; ParamSort: integer): integer; stdcall;

begin
result:=0;
if strtodatetime(item1.SubItems[0])&gt; strtodatetime(item2.SubItems[0]) then
  Result :=1 
else
  if strtodatetime(item1.SubItems[0])&lt; strtodatetime(item2.SubItems[0]) then
    Result :=-1;
end; 
 
procedure TForm1.lv1ColumnClick(Sender: TObject; Column: TListColumn);
begin
if column =lv1.columns[0] then
  LV1.CustomSort(@CustomNameSortProc, 0)
else 
  LV1.CustomSort(@CustomDateSortProc, 0)
end; 
</pre>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Сортировка по первой колонке</p>
<p>Сортировка по первой колонке TListView делается так:</p>
<pre>
ListView1.SortType := stText;
</pre>

<p>Установка SortType в stText аналогична установке Sorted в True в объекте TListBox. Список будет оставаться отсортированным даже после добавления или изменения элементов, до тех пор, пока не установить SortType обратно в stNone:</p>
<pre>
ListView1.SortType := stNone;
</pre>

<p>В TListBox это аналогично установке Sorted в False.</p>
<p>Сортировка по другим колонкам</p>
<p>Чтобы отсортировать TListView по другой колонке, потребуется написать событие OnCompare, либо функцию сортировки, которая будет использоваться в методе CustomSort.</p>
<p>Для начала рассмотрим сортировку при помощи события OnCompare.</p>
<pre>
procedure(Sender: TObject; Item1, Item2: TListItem;Data: Integer; var Compare: Integer) of object;
</pre>

<p>Параметр Compare может иметь три значения: 1, -1 или 0. Единица означает, что первый элемент больше (или должен быть размещён после) второго элемента. Минус одни означает, что первый элемент меньше чем (или должен быть размещён перед) второй элемент. Ноль означает, что два элемента равны.</p>
<p>В следующем примере мы сортируем TListView по четвёртой колонке (которая представлена целыми значениями) в порядке убывания:</p>
<pre>
procedure TForm1.ListView1Compare(Sender: TObject; Item1,
  Item2: TListItem; Data: Integer; var Compare: Integer);
var
  n1, n2: integer;
begin
  n1 := StrToInt(Item1.SubItems[2]);
  n2 := StrToInt(Item2.SubItems[2]);
  if n1 &gt; n2 then
    Compare := -1
  else if n1 &lt; n2 then
    Compare := 1
  else
    Compare := 0;
end;
</pre>

<p>Теперь достаточно установить SortType в stBoth (вместо stText, который сортирует по первой колонке не используя метод OnCompare):</p>
<p>ListView1.SortType := stBoth; </p>
<p>Теперь, чтобы сделать временную сортировку, проделайте следующее:</p>
<p>ListView1.SortType := stBoth;</p>
<p>ListView1.SortType := stNone;</p>
<p>или ещё:</p>
<p>ListView1.CustomSort(nil, 0);</p>
<p>Сортировка при помощи функции сортировки</p>
<p>Функция сортировки используется для быстрой сортировки. Эта функция должна возвращать 1, -1 или 0 (как параметр Compare в событии OnCompare). Например:</p>
<pre>
function ByFourth(Item1, Item2: TListItem; Data: integer):
  integer; stdcall;
var
  n1, n2: cardinal;
begin
  n1 := StrToInt(Item1.SubItems[2]);
  n2 := StrToInt(Item2.SubItems[2]);
  if n1 &gt; n2 then
    Result := -1
  else if n1 &lt; n2 then
    Result := 1
  else
    Result := 0;
end;
</pre>

<p>Теперь, каждый раз, как Вы захотите отсортировать список, достаточно будет вызвать метод CustomSort, передав ему адрес функции сортировки. Например:</p>
<p>ListView1.CustomSort(@ByFourth, 0);</p>
<p>Параметр Data в функции сортировки используется для указания номера колонки.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
unit SortedListView;
 
 interface
 
 uses
   Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
   ComCtrls;
 
 type
   TSortedListView = class(TListView)
   private
     FSortColumn: Integer;
     procedure SetSortColumn(const Value: Integer);
     procedure SortedListViewCompare(Sender: TObject; Item1, Item2: TListItem;
       Data: Integer; var Compare: Integer);
     procedure SortedListViewColumnClick(Sender: TObject; Column: TListColumn);
     { Private declarations }
   protected
     { Protected declarations }
   public
     constructor Create(AOwner: TComponent); override;
     { Public declarations }
   published
     { Published declarations }
     property SortColumn: Integer read FSortColumn write SetSortColumn;
   end;
 
 implementation
 
 {==============================================================================}
 { TSortedListView }
 {==============================================================================}
 constructor TSortedListView.Create(AOwner: TComponent);
 begin
   inherited;
 
   OnColumnClick := SortedListViewColumnClick;
   OnCompare := SortedListViewCompare;
 end;
 {==============================================================================}
 
 procedure TSortedListView.SetSortColumn(const Value: Integer);
 begin
   FSortColumn := Value;
   AlphaSort;
 end;
 {==============================================================================}
 
 procedure TSortedListView.SortedListViewColumnClick(Sender: TObject;
   Column: TListColumn);
 begin
   SortColumn := Column.Index;
 end;
 {==============================================================================}
 
 procedure TSortedListView.SortedListViewCompare(Sender: TObject;
   Item1, Item2: TListItem; Data: Integer; var Compare: Integer);
 begin
   if SortColumn = 0 then
     Compare := CompareText(Item1.Caption, Item2.Caption)
   else
     Compare := CompareText(Item1.SubItems[SortColumn - 1], Item2.SubItems[SortColumn - 1]);
 end;
 
 end.
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
<hr />
<pre>
{ 
  This example shows how to use the TListView's CustomSort method to 
  sort the items in the list using a ordering function. 
  This allows you to sort custom data in the correct order you want. 
 
  When the user clicks on a column header, the ListView will be sorted 
  by that column. 
  If the user clicks on the same column again, the sort order will be toggled. 
}
 
 { custom sort styles }
 
 type
   TCustomSortStyle = (cssAlphaNum, cssNumeric, cssDateTime);
 
 var
   { variable to hold the sort style }
   LvSortStyle: TCustomSortStyle;
   { array to hold the sort order }
   LvSortOrder: array[0..4] of Boolean; // High[LvSortOrder] = Number of Lv Columns 
 
implementation
 
 {$R *.DFM}
 
 function CustomSortProc(Item1, Item2: TListItem; SortColumn: Integer): Integer; stdcall;
 var
   s1, s2: string;
   i1, i2: Integer;
   r1, r2: Boolean;
   d1, d2: TDateTime;
 
   { Helper functions }
 
   function IsValidNumber(AString : string; var AInteger : Integer): Boolean;
   var
     Code: Integer;
   begin
     Val(AString, AInteger, Code);
     Result := (Code = 0);
   end;
 
   function IsValidDate(AString : string; var ADateTime : TDateTime): Boolean;
   begin
     Result := True;
     try
       ADateTime := StrToDateTime(AString);
     except
       ADateTime := 0;
       Result := False;
     end;
   end;
 
   function CompareDates(dt1, dt2: TDateTime): Integer;
   begin
     if (dt1 &gt; dt2) then Result := 1
     else
       if (dt1 = dt2) then Result := 0
     else
       Result := -1;
   end;
 
   function CompareNumeric(AInt1, AInt2: Integer): Integer;
   begin
     if AInt1 &gt; AInt2 then Result := 1
     else
       if AInt1 = AInt2 then Result := 0
     else
       Result := -1;
   end;
 
 begin
   Result := 0;
 
   if (Item1 = nil) or (Item2 = nil) then Exit;
 
   case SortColumn of
     -1 :
     { Compare Captions }
     begin
       s1 := Item1.Caption;
       s2 := Item2.Caption;
     end;
     else
     { Compare Subitems }
     begin
       s1 := '';
       s2 := '';
       { Check Range }
       if (SortColumn &lt; Item1.SubItems.Count) then
         s1 := Item1.SubItems[SortColumn];
       if (SortColumn &lt; Item2.SubItems.Count) then
         s2 := Item2.SubItems[SortColumn]
     end;
   end;
 
   { Sort styles }
 
   case LvSortStyle of
     cssAlphaNum : Result := lstrcmp(PChar(s1), PChar(s2));
     cssNumeric  : begin
                     r1 := IsValidNumber(s1, i1);
                     r2 := IsValidNumber(s2, i2);
                     Result := ord(r1 or r2);
                     if Result &lt;&gt; 0 then
                       Result := CompareNumeric(i2, i1);
                   end;
     cssDateTime : begin
                     r1 := IsValidDate(s1, d1);
                     r2 := IsValidDate(s2, d2);
                     Result := ord(r1 or r2);
                     if Result &lt;&gt; 0 then
                       Result := CompareDates(d1, d2);
                   end;
   end;
 
   { Sort direction }
 
   if LvSortOrder[SortColumn + 1] then
     Result := - Result;
 end;
 
 
 { The ListView's OnColumnClick event }
 
 procedure TForm1.ListView1ColumnClick(Sender: TObject; Column: TListColumn);
 begin
   { determine the sort style }
   if Column.Index = 0 then
     LvSortStyle := cssAlphaNum
   else
     LvSortStyle := cssNumeric;
 
   { Call the CustomSort method }
   ListView1.CustomSort(@CustomSortProc, Column.Index -1);
 
   { Set the sort order for the column}
   LvSortOrder[Column.Index] := not LvSortOrder[Column.Index];
 end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
