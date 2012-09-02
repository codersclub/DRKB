<h1>Как узнать имя файла текущего процесса?</h1>
<div class="date">01.01.2007</div>


<p>Для этого существует функция GetModuleFileName, которая возвращает имя файла текущего процесса.</p>
<pre>
function GetModName: String;
var
  fName: String;
  nsize: cardinal;
begin
  nsize := 128;
  SetLength(fName,nsize);
  SetLength(fName,
            GetModuleFileName(
              hinstance,
              pchar(fName),
              nsize));
  Result := fName;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

