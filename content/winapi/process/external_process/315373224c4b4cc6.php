<h1>Как, зная Handle окна программы, определить имя exe?</h1>
<div class="date">01.01.2007</div>


<pre>
function ExeNameByHandle(aWinHandle:HWND):string;
{исправлено для ©Drkb v.3(2007): www.drkb.ru}
 
// Для начала определяешь какому процессу принадлежит окно:
var pProcID: ^DWORD;
begin
  GetMem(pProcID, SizeOf(DWORD));
  GetWindowThreadProcessId(aWinHandle, pProcID);
  result:=GetExeNameByProcID(pProcID^);
  FreeMem(pProcID);
end;
        // а после этого используешь TProcessEntry32 примерно так:
function GetExeNameByProcID(ProcID: DWord): string;
var
ContinueLoop: BOOL;
FSnapshotHandle: THandle;
FProcessEntry32: TProcessEntry32;
begin
FSnapshotHandle := CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
FProcessEntry32.dwSize := Sizeof(FProcessEntry32);
ContinueLoop := Process32First(FSnapshotHandle, FProcessEntry32);
Result := '';
while (Integer(ContinueLoop) &lt;&gt; 0) and (Result = '') do
        begin
        if FProcessEntry32.th32ProcessID = ProcID then
                Result := FProcessEntry32.szExeFile;
        ContinueLoop := Process32Next(FSnapshotHandle, FProcessEntry32);
        end;
CloseHandle(FSnapshotHandle);
end;
 
// Не забудь в uses добавить Tlhelp32
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p>Код исправлен Мыш</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


