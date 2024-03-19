---
Title: Проверить файл базы данных на возможность открытия в монопольном режиме
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Проверить файл базы данных на возможность открытия в монопольном режиме
=======================================================================

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

