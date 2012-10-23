<h1>Как работать со всеми ячейками &lt;table&gt;?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>

<p>Пример показывает как добавить содержимое каждой ячейки в TMemo:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  i, j: integer;
  ovTable: OleVariant;
begin
// Я использовал первую таблицу на странице в ка?естве примера
  ovTable := WebBrowser1.OleObject.Document.all.tags('TABLE').item(0); for i := 0 to (ovTable.Rows.Length - 1) do
    begin
      for j := 0 to (ovTable.Rows.Item(i).Cells.Length - 1) do
        begin
          Memo1.Lines.Add(ovTable.Rows.Item(i).Cells.Item(j).InnerText;
        end;
    end;
end;
</pre>

