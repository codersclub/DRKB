---
Title: Как выяснить дату последнего изменения файла?
Date: 01.01.2007
---


Как выяснить дату последнего изменения файла?
=============================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://blackman.wp-club.net/>
