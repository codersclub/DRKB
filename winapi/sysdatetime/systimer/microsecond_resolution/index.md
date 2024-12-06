---
Title: Как реализовать задержку с микросекундным разрешением?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как реализовать задержку с микросекундным разрешением?
================================================

    // Wait 0.2ms ( = 0.000200s)
     
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

