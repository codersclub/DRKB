---
Title: Получение количества установленных процессоров
Date: 01.01.2007
---

Получение количества установленных процессоров
==============================================

    function GettingProcNum: string;  //Win95 or later and NT3.1 or later
    var
      Struc:    _SYSTEM_INFO;
    begin
      GetSystemInfo(Struc);
      Result:=IntToStr(Struc.dwNumberOfProcessors);
    end;
