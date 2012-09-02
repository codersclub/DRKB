<h1>Проверить, можно ли отменить последнее действие в TMemo</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 begin
   if Memo1.Perform(EM_CANUNDO, 0, 0) &lt;&gt; 0 then
     ShowMessage('Undo is possible')
   else
     ShowMessage('Undo is not possible');
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
