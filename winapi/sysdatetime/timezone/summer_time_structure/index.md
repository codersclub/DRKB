---
Title: Получить из регистров информацию о временной зоне (DST)
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Получить из регистров информацию о временной зоне (DST)
=======================================================

> HKEYLocalMachine/Software/Microsoft/Windows/CurrentVersion/TimeZones/ -
> место, где в регистре хранится информация о временных зонах (Timezone).
> Двоичный код \'TZI\' хранит информацию о начале и конце летнего времени.
> Есть какие-нибудь идеи насчет извлечения этих дат из этой двоичной
> величины?

Ок, попробую здесь описать бинарную структуру значения TZI:

    int32 Bias;             // Минуты от GMT
                            // (Сидней -600; 0xfffffda8;
                            // или a8, fd, ff, ff)
    int32 StandardBias;     // Смещение для стандартного времени (0)
    int32 DaylightBias;     // Смещение для летнего времени (-60
                            // или 0xffffffc4 )
    int16 ??                          // 0
    int16 StandardStartMonth;         // 3 => Март
    int16 StandardStartDayOfWeek??;   // 0 => Воскресенье
    int16 StandardStartDOWoccurrence; // 1 => 1-й
    int16 StandardStartHour;          // 2 => 02:00:00.00
    int16 StandardStartMins??;        // 0 => 02:00:00.00
    int16 StandardStartSecs??;        // 0 => 02:00:00.00
    int16 StandardStartHunds??;       // 0 => 02:00:00.00
    int16 ??                          // 0
    int16 DaylightStartMonth;         // 0x0a (10) => Октябрь
    int16 DaylightStartDayOfWeek??;   // 0 => Воскресенье
    int16 DaylightStartDOWoccurrence; // 5 => последний
    int16 DaylightStartHour;          // 2 => 02:00:00.00
    int16 DaylightStartMins??;        // 0 => 02:00:00.00
    int16 DaylightStartSecs??;        // 0 => 02:00:00.00
    int16 DaylightStartHunds??;       // 0 => 02:00:00.00



