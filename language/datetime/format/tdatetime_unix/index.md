---
Title: Конвертируем TDateTime в Unix Timestamp
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Конвертируем TDateTime в Unix Timestamp
=======================================

    {
      Иногда вам нужно взаимодействовать с MySQL или другими базами данных,
      используя временную метку unix.
      Чтобы устранить эту разницу, вы можете преобразовать TDateTime
      в формат метки времени unix и обратно.
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

