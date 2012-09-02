<h1>Сохранение данных из ListView в *.xls</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Сохранение данных из ListView в *.xls
 
Сохранение данных из ListView в *.xls
 
Зависимости: ComObj
Автор:       dDan, ddan2002@mail.ru
Copyright:   dDan
Дата:        3 декабря 2003 г.
********************************************** }
 
procedure ListToExcel(ListView: TListView);
var
 row,i:integer;
 Range,Sheet:VAriant;
begin
 try
  Excel:=CreateOleObject('Excel.Application');
 except
  raise Exception.Create('Невозможно поключиться к серверу Excel');
 end;
 Screen.Cursor:=crHourGlass;
 Excel.SheetsInNewWorkBook:=1;
 Excel.WorkBooks.Add;
 Sheet:=Excel.Workbooks[1].Sheets[1];
 Range:=Sheet.Columns;
 Range.Columns[1].ColumnWidth:=30; //Количество Столбцов и их ширина
 Range.Columns[n].ColumnWidth:=30;
 Range.Columns[n+1].ColumnWidth:=30;
 Range.Columns.Font.Size:=8;
 Range:=Sheet.Range['a1:f1'];
 Range.Font.Size:=15;
 Range.Font.Bold:=True;
 Range.Columns.Interior.ColorIndex:=6;
 Range.HorizontalAlignment:=3;
 Sheet.Cells[1,2]:='Данные на '+DateToStr(Date);//Заголовок
 Range:=Sheet.Range['a2:f2'];
 Range.Font.Size:=10;
 Range.Font.Bold:=True;
 Sheet.Cells[2,1]:='АА';//Названия столбцов
 Sheet.Cells[2,n]:='ББ';
 Sheet.Cells[2,n+1]:='вв';;
 Row:=3;
 for i :=0 to List.Items.Count-1 do begin
  Sheet.Cells[Row,1]:=ListView.Items.Item[i].Caption;
  Sheet.Cells[Row,2]:=ListView.Items.Item[i].SubItems[n];
  Sheet.Cells[Row,3]:=ListView.Items.Item[i].SubItems[n+1];
  inc(Row);
 end;
 Screen.Cursor:=crDefault;
 if SaveDialog.Execute then Excel.WorkBooks[1].SaveAs(exs.FileName);//Сохраняем
 Excel.Visible:=True;//Показываем Excel
end;
</pre>

