---
Title: Как узнать имя файла текущего процесса?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как узнать имя файла текущего процесса?
=======================================

Для этого существует функция GetModuleFileName, которая возвращает имя
файла текущего процесса.

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

