<h1>Работа с ячейкой листа Microsoft Excel</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Работа с ячейкой листа Microsoft Excel
 
Получает и заносит число типа double в ячейку листа Microsoft Excel
 
Зависимости: ComObj
Автор:       lookin, lookin@mail.ru, Екатеринбург
Copyright:   lookin
Дата:        30 апреля 2002 г.
********************************************** }
 
//ВНИМАНИЕ: ОБЯЗАТЕЛЬНОЕ условие работы - наличие запущенного Excel 
 
//получение double из заданной ячейки первого листа в заданной рабочей книге
function DoubleValueFromExcelCell(ExcelWorkBook,ExcelCell: string): double;
var i: integer;
    Excel,v: Variant;
begin
  Excel:=GetActiveOleObject('Excel.Application');
  for i:=1 to Excel.Application.Workbooks.Count do
  if Excel.Application.Workbooks[i].FullName=ExcelWorkBook then begin
  v:=Excel.Application.Workbooks[i].Sheets[1].Range[ExcelCell];
  DoubleValueFromExcelCell:=VarAsType(v,varDouble); v:=0; Excel:=0; end;
end;
 
//занесение double в заданную ячейку первого листа в заданной рабочей книге
procedure DoubleValueToExcelCell(Value: double; ExcelWorkBook,ExcelCell: string);
var i: integer;
    Excel,v: Variant;
begin
  Excel:=GetActiveOleObject('Excel.Application');
  for i:=1 to Excel.Application.Workbooks.Count do
  if Excel.Application.Workbooks[i].FullName=ExcelWorkBook then begin
  Excel.Application.EditDirectlyInCell:=false; v:=Value;
  Excel.Application.Workbooks[i].Sheets[1].Range[ExcelCell]:=v; end;
end;
</pre>

