<h1>Автоматическая регистрация серверов из своей программы</h1>
<div class="date">01.01.2007</div>


<p>Удобно в своей программе автоматически регистрировать все необходимые серверы. Это можно сделать при помощи следующей процедуры:</p>
<pre class="delphi">
procedure CheckComServerInstalled(const CLSID: TGUID; const DllName: String);
var
  Size: Integer;
  DllHandle: THandle;
  FileName: String;
begin
  Size := MAX_PATH;
  SetLength(FileName, Size);
  try
    if RegQueryValue(HKEY_CLASSES_ROOT,
         PChar(Format('CLSID\%s\InProcServer32',
        [GUIDToString(CLSID)])), PChar(FileName), Size) = ERROR_SUCCESS then
    begin
      SetLength(FileName, Size);
      DllHandle := LoadLibrary(PChar(FileName));
      FreeLibrary(DllHandle);
      if DllHandle = 0 then begin
        RegDeleteKey(HKEY_CLASSES_ROOT,
          PChar(Format('CLSID\%s',[GUIDToString(CLSID)])));
        RegisterComServer(DllName);
      end;
    end else begin
      RegisterComServer(DllName);
    end;
  except
    raise Exception.CreateFmt('Не могу зарегистрировать %s.', [DllName]);
  end;
end;
</pre>

<p>В процедуре осуществляется дополнительная проверка наличия на диске файла с зарегистрированным сервером. Если файл не найден по указанному в реестре месту - данные о регистрации удаляются и предпринимается попытка зарегистрировать сервер заново. Такая проверка очень полезна при переносе DLL с сервером в другую папку на диске.</p>


