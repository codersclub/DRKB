---
Title: How to implement a microsecond resolution Delay?
Date: 01.01.2007
---

How to implement a microsecond resolution Delay?
================================================

::: {.date}
01.01.2007
:::

    // Wait 0.2ms
     
    procedure PerformanceDelay;
    var
      hrRes, hrT1, hrT2, dif: Int64;
    begin
      if QueryPerformanceFrequency(hrRes) then
      begin
        QueryPerformanceCounter(hrT1);
        repeat
          QueryPerformanceCounter(hrT2);
          dif := (hrT2 - hrT1) * 10000000 div hrRes;
        until dif > 2;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
