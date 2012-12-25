---
Title: Как узнать имя файла текущего процесса?
Date: 01.01.2007
---

Как узнать имя файла текущего процесса?
=======================================

::: {.date}
01.01.2007
:::

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

Взято из <https://forum.sources.ru>
