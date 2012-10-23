<h1>Как гарантированно сделать backup?</h1>
<div class="date">01.01.2007</div>


<p>Как гарантированно сделать backup/restore БД InterBase с опцией 'Replace existing database' и записями протоколов в файлы с гарантированным отстрелом пользователей?</p>

<p>Att.bat:</p>
<p>at 01:00 /INTERACTIVE "e:\IB_DATA\BR.BAT"</p>
<p>BR.bat:</p>
<p>del e:\IB_DATA\b.txt</p>
<p>del e:\IB_DATA\r.txt</p>
<p>del e:\ib_data\AR_IB.PRV</p>
<p>del e:\IB_DATA\AR_IB.GBK</p>
<p>d:\ib_42\bin\gfix -shut -force 1 e:\ib_data\AR_IB.GDB -user "SYSDBA" -password "oooo"</p>
<p>net stop "InterBase Server"</p>
<p>copy e:\ib_data\AR_IB.GDB e:\ib_data\AR_IB.PRV</p>
<p>net start "InterBase Server"</p>
<p>d:\ib_42\bin\gbak e:\ib_data\AR_IB.GDB e:\ib_data\AR_IB.GBK -user "SYSDBA" -password "oooo" -B -L -Y "e:\IB_DATA\b.txt"</p>
<p>d:\ib_42\bin\gbak e:\ib_data\AR_IB.GBK e:\ib_data\AR_IB.GDB -user "SYSDBA" -password "oooo" -P 4096 -V -R -Y "e:\IB_DATA\r.txt"</p>
<p>Sergey Klochkovski</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
