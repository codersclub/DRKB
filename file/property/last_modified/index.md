---
Title: Как выяснить дату последнего изменения файла?
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Как выяснить дату последнего изменения файла?
=============================================

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

