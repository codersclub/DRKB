<h1>Как выяснить дату последнего изменения файла?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetFileDate(FileName: string): string;
  var FHandle: Integer;
begin
  FHandle := FileOpen(FileName, 0);
try
  Result := DateTimeToStr(FileDateToDateTime(FileGetDate(FHandle)));
finally
  FileClose(FHandle);
end;
end;
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
