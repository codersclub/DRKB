<h1>Можно ли изменить число колонок и их ширину в компоненте TFileListBox?</h1>
<div class="date">01.01.2007</div>


<p>В приведенном примере FileListBox приводится к типу TDirectoryListBox - таким образом можно добавиь дополнительные колонки.</p>
<pre>
with TDirectoryListBox(FileListBox1) do 
begin
  Columns := 2;
  SendMessage(Handle, LB_SETCOLUMNWIDTH, Canvas.TextWidth('WWWWWWWW.WWW'),0);
end;
</pre>

