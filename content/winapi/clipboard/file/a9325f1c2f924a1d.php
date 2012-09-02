<h1>Получаем имена файлов, скопированных в буфер обмена</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  f: THandle; 
  buffer: array [0..MAX_PATH] of Char; 
  i, numFiles: Integer; 
begin 
  if not Clipboard.HasFormat(CF_HDROP) then Exit; 
  Clipboard.Open; 
  try 
    f := Clipboard.GetAsHandle(CF_HDROP); 
    if f &lt;&gt; 0 then 
    begin 
      numFiles := DragQueryFile(f, $FFFFFFFF, nil, 0); 
      memo1.Clear; 
      for i := 0 to numfiles - 1 do 
      begin 
        buffer[0] := #0; 
        DragQueryFile(f, i, buffer, SizeOf(buffer)); 
        memo1.Lines.Add(buffer); 
      end; 
    end; 
  finally 
    Clipboard.Close; 
  end; 
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
