---
Title: Получение уровня процессора
Date: 01.01.2007
---

Получение уровня процессора
===========================

::: {.date}
01.01.2007
:::

    function GettingProcLevel: string;  //Win95 or later and NT3.1 or later
    var
      Struc:    _SYSTEM_INFO;
    begin
      GetSystemInfo(Struc);
      Case Struc.wProcessorLevel of
        3:  Result:='Intel 80386';
        4:  Result:='Intel 80486';
        5:  Result:='Intel Pentium';
        6:  Result:='Intel Pentium II or better';
      end;
    end;
