<h1>Чтение из открытого файла</h1>
<div class="date">01.01.2007</div>


<p>Даже если файл открыт с низкими привелегиями (используя ReadOnly, ShareReadWrite) , иногда открытие уже открытого файла может приводить к ошибкам, особенно, если это файл интенсивно используется другим приложением. Самый простой способ решить эту проблемму - это использовать MemoryStream вместо непосредственного доступа к файлу: </p>
<pre>
var Memory: TMemoryStream;
 
begin
  Memory := TMemoryStream.Create;
  try
    Memory.LoadFromFile('busyfile.dat'); // это он!!
    ..
      Memory.Read(...); // Вы можете использовать методы чтения как у файлов
      Memory.Seek(...);
      FileSize := Memory.Size;
      ..
  finally
    Memory.Free;
  end;
end;
</pre>
<p>Данный способ никогда не открывает файл, а заместо этого создаёт копию его в памяти. Конечно Вы можете и записать в поток (Stream) в Памяти(Memory), но изменения не будут записаны на диск до тех пор, пока Вы не запишете их в файл (командой SaveToFile).</p>
<div class="author">Автор: neutrino</div>
<p>Комментарий от Vit</p>
<p>Решение хорошее, но накладно если файл большой... </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
var b:string[15];
begin
with TFileStream.create('c:\MyFile.doc', fmShareDenyNone) do
try
read(b,14);
showmessage(b);
finally
Free;
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<pre>
procedure TForm1.Button1Click(Sender: TObject);
type
AnyType = byte; // ??? ???? ?????
var
F: file of AnyType;
const
FName = 'D:/Exp.exe'; //?????????? ????
begin
begin
AssignFile(F, FName); { File selected in dialog }
FileMode:=fmOpenRead;
Reset(F);
// ...
// ...
CloseFile(F);
FileMode:=fmOpenReadWrite;
end;
end;
</pre>

<div class="author">Автор: PILOTIK</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
