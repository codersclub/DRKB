---
Title: Конвертируем TDateTime в Unix Timestamp
Date: 01.01.2007
---


Конвертируем TDateTime в Unix Timestamp
=======================================

::: {.date}
01.01.2007
:::

    {
      Sometimes you want to communicate with mySQL or other databases using
      the unix timestamp. To solve this difference you may want to convert your
      TDateTime to the unix timestamp format and vice versa.
     
    }
     
    unit unix_utils;
     
    interface
     
    implementation
     
    const
      // Sets UnixStartDate to TDateTime of 01/01/1970
      UnixStartDate: TDateTime = 25569.0;
     
    function DateTimeToUnix(ConvDate: TDateTime): Longint;
    begin
      //example: DateTimeToUnix(now);
      Result := Round((ConvDate - UnixStartDate) * 86400);
    end;
     
    function UnixToDateTime(USec: Longint): TDateTime;
    begin
      //Example: UnixToDateTime(1003187418);
      Result := (Usec / 86400) + UnixStartDate;
    end;
     
    end.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
