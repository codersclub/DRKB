<h1>Получить из регистров информацию о временной зоне (DST)</h1>
<div class="date">01.01.2007</div>

HKEYLocalMachine/Software/Microsoft/Windows/CurrentVersion/TimeZones/ - место, где в регистре хранится информация о временных зонах (Timezone). Двоичный код 'TZI' хранит информацию о начале и конце летнего времени. Есть какие-нибудь идеи насчет извлечения этих дат из этой двоичной величины? </p>
<p>Ок, попробую здесь описать бинарную структуру значения TZI:</p>
<pre>
int32 Bias;             // Минуты от GMT
                        // (Сидней -600; 0xfffffda8;
                        // или a8, fd, ff, ff)
int32 StandardBias;     // Смещение для стандартного времени (0)
int32 DaylightBias;     // Смещение для летнего времени (-60
                        // или 0xffffffc4 )
int16 ??                          // 0
int16 StandardStartMonth;         // 3 =&gt; Март
int16 StandardStartDayOfWeek??;   // 0 =&gt; Воскресенье
int16 StandardStartDOWoccurrence; // 1 =&gt; 1-й
int16 StandardStartHour;          // 2 =&gt; 02:00:00.00
int16 StandardStartMins??;        // 0 =&gt; 02:00:00.00
int16 StandardStartSecs??;        // 0 =&gt; 02:00:00.00
int16 StandardStartHunds??;       // 0 =&gt; 02:00:00.00
int16 ??                          // 0
int16 DaylightStartMonth;         // 0x0a (10) =&gt; Октябрь
int16 DaylightStartDayOfWeek??;   // 0 =&gt; Воскресенье
int16 DaylightStartDOWoccurrence; // 5 =&gt; последний
int16 DaylightStartHour;          // 2 =&gt; 02:00:00.00
int16 DaylightStartMins??;        // 0 =&gt; 02:00:00.00
int16 DaylightStartSecs??;        // 0 =&gt; 02:00:00.00
int16 DaylightStartHunds??;       // 0 =&gt; 02:00:00.00
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

