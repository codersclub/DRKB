---
Title: Определить, сейчас до или после полудня
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Определить, сейчас до или после полудня
=======================================

    procedure AM_or_PM;
    begin
      if Frac(Time) = 0 then
        ShowMessage('AM')
      else
        ShowMessage('PM');
    end;

