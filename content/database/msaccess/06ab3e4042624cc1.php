<h1>Проверить файл базы данных на возможность открытия в монопольном режиме</h1>
<div class="date">01.01.2007</div>


<pre>
function ApplicationUse(fName : string ) : boolean;
// проверка на занятость файла
var
  HFileRes : HFILE;
begin
  Result := false;
  if not FileExists(fName) then exit;
  HFileRes := CreateFile(pchar(fName), GENERIC_READ or GENERIC_WRITE,0, nil,
     OPEN_EXISTING,FILE_ATTRIBUTE_NORMAL, 0);
  Result := (HFileRes = INVALID_HANDLE_VALUE);
  if not Result then CloseHandle(HFileRes);
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

