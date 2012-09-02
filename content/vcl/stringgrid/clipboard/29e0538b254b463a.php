<h1>Копирование содержимого TStringGrid в буфер обмена</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Копирование содержимого StringGrid в буфер обмена
 
Копирует содержимое ячеек StringGrid в ClipBoard в формате, позволяющем
вставку, например, в Word или Excel. При CopySel=True копирует выделение,
иначе всю таблицу или указанный диапазон (CL- левый столбец и т.д.).
 
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
    if (CL &lt; FixedCols) or (CL &gt; CR) or (CL &gt;= ColCount) then
      CL := FixedCols;
    if (CR &lt; FixedCols) or (CL &gt; CR) or (CR &gt;= ColCount) then
      CR := ColCount - 1;
    if (RT &lt; FixedRows) or (RT &gt; RB) or (RT &gt;= RowCount) then
      RT := FixedRows;
    if (RB &lt; FixedCols) or (RT &gt; RB) or (RB &gt;= RowCount) then
      RB := RowCount - 1;
    for i := RT to RB do
    begin
      for j := CL to CR do
      begin
        s := s + Cells[j, i];
        if j &lt; CR then
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
</pre>

