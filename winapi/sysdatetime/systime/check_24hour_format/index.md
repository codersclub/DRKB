---
Title: Проверить, используется ли формат времени в 24 часа
Date: 01.01.2007
---

Проверить, используется ли формат времени в 24 часа
===================================================

::: {.date}
01.01.2007
:::

    function Is24HourTimeFormat: Boolean;
     var
       DefaultLCID: LCID;
     begin
       DefaultLCID := GetThreadLocale;
       Result := 0 <> StrToIntDef(GetLocaleStr(DefaultLCID,
         LOCALE_ITIME,'0'), 0);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
