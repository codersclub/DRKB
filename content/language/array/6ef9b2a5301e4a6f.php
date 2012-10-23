<h1>TMemoryStream &gt; Array of Byte</h1>
<div class="date">01.01.2007</div>


<p>Для преобразования TMemoryStream в array of Byte можно использовать следующий код:<br>
<p>&nbsp;</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);

var
  M: TMemoryStream;
  Buff: array of Byte;
begin
  M := TMemoryStream.Create;
  try
    M.LoadFromFile('c:\test.htm');
    SetLength(Buff, M.Size);
    M.Position := 0;
    M.Read(Buff[0], M.Size);
  finally
    M.Free;
  end;
end;
</pre>
&nbsp;<br>

<p>&nbsp;<br>
<div class="author">Автор: Rouse_ </div>


