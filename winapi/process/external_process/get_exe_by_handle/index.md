---
Title: Как, зная Handle окна программы, определить имя exe?
Date: 01.01.2007
Author: Мыш
Source: <https://forum.sources.ru>
---

Как, зная Handle окна программы, определить имя exe?
====================================================

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
    while (Integer(ContinueLoop) <> 0) and (Result = '') do
            begin
            if FProcessEntry32.th32ProcessID = ProcID then
                    Result := FProcessEntry32.szExeFile;
            ContinueLoop := Process32Next(FSnapshotHandle, FProcessEntry32);
            end;
    CloseHandle(FSnapshotHandle);
    end;
     
    // Не забудь в uses добавить Tlhelp32

