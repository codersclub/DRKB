---
Title: Как конвертировать RFC дату и обратно?
Date: 01.01.2007
---


Как конвертировать RFC дату и обратно?
======================================

Вариант 1:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

    function DateTimeToRfcTime(
      dt: TDateTime;
      iDiff: integer;
      blnGMT: boolean = false): string;
    {*
    Explanation:
    iDiff is the local offset to GMT in minutes
    if blnGMT then Result is UNC time else local time
    e.g. local time zone: ET = GMT - 5hr = -300 minutes
        dt is TDateTime of 3 Jan 2001 5:45am
          blnGMT = true  -> Result = 'Wed, 03 Jan 2001 05:45:00 GMT'
          blnGMT = false -> Result = 'Wed, 03 Jan 2001 05:45:00 -0500'
    *}
    const
      Weekday: array[1..7] of string =
      ('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
      Month: array[1..12] of string = (
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    var
      iDummy: Word;
      iYear: Word;
      iMonth: Word;
      iDay: Word;
      iHour: Word;
      iMinute: Word;
      iSecond: Word;
      strZone: string;
    begin
      if blnGMT then
      begin
        dt := dt - iDiff / 1440;
        strZone := 'GMT';
      end
      else
      begin
        iDiff := (iDiff div 60) * 100 + (iDiff mod 60);
        if iDiff < 0 then
          strZone := Format('-%.4d', [-iDiff])
        else
          strZone := Format('+%.4d', [iDiff]);
      end;
      DecodeDate(dt, iYear, iMonth, iDay);
      DecodeTime(dt, iHour, iMinute, iSecond, iDummy);
      Result := Format('%s, %.2d %s %4d %.2d:%.2d:%.2d %s', [
        Weekday[DayOfWeek(dt)], iDay, Month[iMonth], iYear,
          iHour, iMinute, iSecond, strZone]);
    end;
     
    function RfcTimeToDateTime(
      strTime: string;
      blnGMT: boolean = true): TDateTime;
    {*
    Explanation:
    if blnGMT then Result is UNC time else local time
    e.g. local time zone: ET = GMT - 5hr = -0500
        strTime = 'Wed, 03 Jan 2001 05:45:00 -0500'
          blnGMT = true  -> FormatDateTime('...', Result) = '03.01.2001 10:45:00'
          blnGMT = false -> FormatDateTime('...', Result) = '03.01.2001 05:45:00'
    *}
    const
      wd = 'sun#mon#tue#wed#thu#fri#sat';
      month = 'janfebmaraprmayjunjulaugsepoctnovdec';
    var
      s: string;
      dd: Word;
      mm: Word;
      yy: Word;
      hh: Word;
      nn: Word;
      ss: Word;
    begin
      s := LowerCase(Copy(strTime, 1, 3));
      if Pos(s, wd) > 0 then
        Delete(strTime, 1, Pos(' ', strTime));
      s := Trim(Copy(strTime, 1, Pos(' ', strTime)));
      Delete(strTime, 1, Length(s) + 1);
      dd := StrToIntDef(s, 0);
      s := LowerCase(Copy(strTime, 1, 3));
      Delete(strTime, 1, 4);
      mm := (Pos(s, month) div 3) + 1;
      s := Copy(strTime, 1, 4);
      Delete(strTime, 1, 5);
      yy := StrToIntDef(s, 0);
      Result := EncodeDate(yy, mm, dd);
      s := strTime[1] + strTime[2];
      hh := StrToIntDef(strTime[1] + strTime[2], 0);
      nn := StrToIntDef(strTime[4] + strTime[5], 0);
      ss := StrToIntDef(strTime[7] + strTime[8], 0);
      Delete(strTime, 1, 9);
      Result := Result + EncodeTime(hh, nn, ss, 0);
      if (CompareText(strTime, 'gmt') <> 0) and blnGMT then
      begin
        hh := StrToIntDef(strTime[2] + strTime[3], 0);
        nn := StrToIntDef(strTime[4] + strTime[5], 0);
        if strTime[1] = '+' then
          Result := Result - EncodeTime(hh, nn, 0, 0)
        else
          Result := Result + EncodeTime(hh, nn, 0, 0);
      end;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    function RFC1123ToDateTime(Date: string): TDateTime; 
    var 
      day, month, year: Integer; 
      strMonth: string; 
      Hour, Minute, Second: Integer; 
    begin 
      try 
        day      := StrToInt(Copy(Date, 6, 2)); 
        strMonth := Copy(Date, 9, 3); 
        if strMonth = 'Jan' then month := 1  
        else if strMonth = 'Feb' then month := 2  
        else if strMonth = 'Mar' then month := 3  
        else if strMonth = 'Apr' then month := 4  
        else if strMonth = 'May' then month := 5  
        else if strMonth = 'Jun' then month := 6  
        else if strMonth = 'Jul' then month := 7  
        else if strMonth = 'Aug' then month := 8  
        else if strMonth = 'Sep' then month := 9  
        else if strMonth = 'Oct' then month := 10  
        else if strMonth = 'Nov' then month := 11  
        else if strMonth = 'Dec' then month := 12; 
        year   := StrToInt(Copy(Date, 13, 4)); 
        hour   := StrToInt(Copy(Date, 18, 2)); 
        minute := StrToInt(Copy(Date, 21, 2)); 
        second := StrToInt(Copy(Date, 24, 2)); 
        Result := 0; 
        Result := EncodeTime(hour, minute, second, 0); 
        Result := Result + EncodeDate(year, month, day); 
      except 
        Result := now; 
      end; 
    end; 
     
     
    function DateTimeToRFC1123(aDate: TDateTime): string; 
    const 
      StrWeekDay: string = 'MonTueWedThuFriSatSun'; 
      StrMonth: string = 'JanFebMarAprMayJunJulAugSepOctNovDec'; 
    var 
      Year, Month, Day: Word; 
      Hour, Min, Sec, MSec: Word; 
      DayOfWeek: Word; 
    begin 
      DecodeDate(aDate, Year, Month, Day); 
      DecodeTime(aDate, Hour, Min, Sec, MSec); 
      DayOfWeek := ((Trunc(aDate) - 2) mod 7); 
      Result    := Copy(StrWeekDay, 1 + DayOfWeek * 3, 3) + ', ' + 
        Format('%2.2d %s %4.4d %2.2d:%2.2d:%2.2d', 
        [Day, Copy(StrMonth, 1 + 3 * (Month - 1), 3), 
        Year, Hour, Min, Sec]); 
    end; 

