<h1>Как восстановить индексы?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Table.Close;
  Table.Exclusive := True;
  Table.Open;
  DbiRegenIndexes(Table.Handle);
  Table.Close;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
