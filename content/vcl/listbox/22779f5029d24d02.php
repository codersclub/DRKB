<h1>Сортировать список по алфавиту</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
 You need a TListBox and a TButton. 
 With a few modifications, you can use it with any variable 
 compatible with a TStringList. 
 If you change the operator "&lt;"  for a "&gt;" in the 'if' clause 
 below, the order will be reversed 
}
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   i, x: Integer;
 begin
   for i := 0 to (ListBox1.Items.Count - 1) do
     for x := 0 to (ListBox1.Items.Count - 1) do
       if (ListBox1.Items[x] &lt; ListBox1.Items[i]) and (x &gt; i) then
       begin
         ListBox1.Items.Insert(i, ListBox1.Items[x]);
         ListBox1.Items.Delete(x + 1);
       end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>
