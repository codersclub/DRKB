<h1>Как убить задачу, зная только имя .exe?</h1>
<div class="date">01.01.2007</div>

nbsp;

<pre>
{Эта небольшая функция закрывает приложения, соответствующие заданному имени .exe. 
  Пример: KillTask('notepad.exe'); 
          KillTask('iexplore.exe'); } 
uses 
  Tlhelp32, Windows, SysUtils; 
 
function KillTask(ExeFileName: string): integer; 
const 
  PROCESS_TERMINATE=$0001; 
var 
  ContinueLoop: BOOL; 
  FSnapshotHandle: THandle; 
  FProcessEntry32: TProcessEntry32; 
begin 
  result := 0; 
 
  FSnapshotHandle := CreateToolhelp32Snapshot 
                     (TH32CS_SNAPPROCESS, 0); 
  FProcessEntry32.dwSize := Sizeof(FProcessEntry32); 
  ContinueLoop := Process32First(FSnapshotHandle, 
                                 FProcessEntry32); 
 
  while integer(ContinueLoop) &lt;&gt; 0 do 
  begin 
    if ((UpperCase(ExtractFileName(FProcessEntry32.szExeFile)) = 
         UpperCase(ExeFileName)) 
     or (UpperCase(FProcessEntry32.szExeFile) = 
         UpperCase(ExeFileName))) then 
      Result := Integer(TerminateProcess(OpenProcess( 
                        PROCESS_TERMINATE, BOOL(0), 
                        FProcessEntry32.th32ProcessID), 0)); 
    ContinueLoop := Process32Next(FSnapshotHandle, 
                                  FProcessEntry32); 
  end; 
 
  CloseHandle(FSnapshotHandle); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

