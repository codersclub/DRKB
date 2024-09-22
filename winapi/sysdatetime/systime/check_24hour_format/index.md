---
Title: Проверить, используется ли формат времени в 24 часа
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Проверить, используется ли формат времени в 24 часа
===================================================

    function Is24HourTimeFormat: Boolean;
     var
       DefaultLCID: LCID;
     begin
       DefaultLCID := GetThreadLocale;
       Result := 0 <> StrToIntDef(
                        GetLocaleStr(DefaultLCID,LOCALE_ITIME,'0'),
                        0);
     end;

