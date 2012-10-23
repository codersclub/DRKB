<h1>Запись потока в BLOB-поле</h1>
<div class="date">01.01.2007</div>


<p>Вся хитрость заключается в использовании StrPcopy (помещения вашей строки в PChar) и записи буфера в поток. Вы не сможете передать это в PChar непосредственно, поскольку ему нужен буфер, поэтому для получения необходимого размера буфера используйте &lt;BufferName&gt;[0] и StrLen().</p>

<p>Вот пример использования TMemoryStream и записи его в Blob-поле:</p>
<pre>
var
  cString: string;
  oMemory: TMemoryStream;
  Buffer: PChar;
begin
  cString := 'Ну, допустим, хочу эту строку!';
 
  { СОздаем новый поток памяти }
  oMemory := TMemoryStream.Create;
 
  {!! Копируем строку в PChar }
  StrPCopy(Buffer, cString);
 
  { Пишем =буфер= и его размер в поток }
  oMemory.Write(Buffer[0], StrLen(Buffer));
 
  {Записываем это в поле}
  &lt; Blob / Memo / GraphicFieldName &gt; .LoadFromStream(oMemory);
 
  { Необходимо освободить ресурсы}
  oMemory.Free;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


