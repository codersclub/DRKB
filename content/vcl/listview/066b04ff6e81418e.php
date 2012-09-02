<h1>Получить все выделенные элементы TListView</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 var
   i: integer;
 begin
   with Listview1 do
     // MultiSelect := True; 
    // ViewStyle := vsReport; 
    for i := 0 to Items.Count - 1 do
       if Items[i].Selected then
         Items[i].Caption := Items[i].Caption + ' - Selected!';
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
