---
Title: Как гарантированно сделать backup?
Date: 01.01.2007
---


Как гарантированно сделать backup?
==================================

::: {.date}
01.01.2007
:::

Как гарантированно сделать backup/restore БД InterBase с опцией
\'Replace existing database\' и записями протоколов в файлы с
гарантированным отстрелом пользователей?

Att.bat:

at 01:00 /INTERACTIVE "e:\\IB\_DATA\\BR.BAT"

BR.bat:

del e:\\IB\_DATA\\b.txt

del e:\\IB\_DATA\\r.txt

del e:\\ib\_data\\AR\_IB.PRV

del e:\\IB\_DATA\\AR\_IB.GBK

d:\\ib\_42\\bin\\gfix -shut -force 1 e:\\ib\_data\\AR\_IB.GDB -user
"SYSDBA" -password "oooo"

net stop "InterBase Server"

copy e:\\ib\_data\\AR\_IB.GDB e:\\ib\_data\\AR\_IB.PRV

net start "InterBase Server"

d:\\ib\_42\\bin\\gbak e:\\ib\_data\\AR\_IB.GDB e:\\ib\_data\\AR\_IB.GBK
-user "SYSDBA" -password "oooo" -B -L -Y "e:\\IB\_DATA\\b.txt"

d:\\ib\_42\\bin\\gbak e:\\ib\_data\\AR\_IB.GBK e:\\ib\_data\\AR\_IB.GDB
-user "SYSDBA" -password "oooo" -P 4096 -V -R -Y
"e:\\IB\_DATA\\r.txt"

Sergey Klochkovski

Взято с <https://delphiworld.narod.ru>
