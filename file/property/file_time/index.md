---
Title: TFileTime -> TDateTime
Date: 01.01.2007
---


TFileTime -> TDateTime
======================

::: {.date}
01.01.2007
:::

    function FileTimeToDateTime(FileTime: TFileTime): TDateTime;
     var
       ModifiedTime: TFileTime;
       SystemTime: TSystemTime;
     begin
       Result := 0;
       if (FileTime.dwLowDateTime = 0) and (FileTime.dwHighDateTime = 0) then
         Exit;
       try
         FileTimeToLocalFileTime(FileTime, ModifiedTime);
         FileTimeToSystemTime(ModifiedTime, SystemTime);
         Result := SystemTimeToDateTime(SystemTime);
       except
         Result := Now;  // Something to return in case of error 
      end;
     end;
     
     function DateTimeToFileTime(FileTime: TDateTime): TFileTime;
     var
       LocalFileTime, Ft: TFileTime;
       SystemTime: TSystemTime;
     begin
       Result.dwLowDateTime  := 0;
       Result.dwHighDateTime := 0;
       DateTimeToSystemTime(FileTime, SystemTime);
       SystemTimeToFileTime(SystemTime, LocalFileTime);
       LocalFileTimeToFileTime(LocalFileTime, Ft);
       Result := Ft;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
