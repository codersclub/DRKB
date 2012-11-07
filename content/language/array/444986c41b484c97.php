<h1>Array of Byte &gt; TMemoryStream</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button2Click(Sender: TObject);

const
  Start = 49;
  AnEnd = 57;
  ArLen = AnEnd - Start + 1;
var
  M: TMemoryStream;
  Buff: array of Byte;
  I: Integer;
begin
  SetLength(Buff, ArLen);
  for I := 0 to ArLen - 1 do
    Buff[I] := Start + I;
 
  M := TMemoryStream.Create;
  try
    M.Write(Buff[0], ArLen);
    M.SaveToFile('c:\test.txt');    
  finally
    M.Free;
  end;
end;
</pre>
<p> <br>
<p>В результате должен получится файл c:\test.txt такого содержания:</p>
<p>123456789</p>
<p> <br>
<p>поскольку числа с 49 до 51 являются ASCII-кодами этих чисел, а соответственно и являются их символьным представлением.</p>

<p></p>
<div class="author">Автор: s-mike</div>
<p></p>
