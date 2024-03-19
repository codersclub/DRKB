---
Title: Как гарантированно сделать backup?
Date: 01.01.2007
Author: Sergey Klochkovski
Source: <https://delphiworld.narod.ru>
---


Как гарантированно сделать backup?
==================================

>Как гарантированно сделать backup/restore БД InterBase с опцией
>\'Replace existing database\' и записями протоколов в файлы с
>гарантированным отстрелом пользователей?

Att.bat:

```cmd
at 01:00 /INTERACTIVE "e:\IB_DATA\BR.BAT"
```
BR.bat:

```cmd
del e:\IB_DATA\b.txt
del e:\IB_DATA\r.txt
del e:\ib_data\AR_IB.PRV
del e:\IB_DATA\AR_IB.GBK
d:\ib_42\bin\gfix -shut -force 1 e:\ib_data\AR_IB.GDB -user "SYSDBA" -password "oooo"
net stop "InterBase Server"
copy e:\ib_data\AR_IB.GDB e:\ib_data\AR_IB.PRV
net start "InterBase Server"
d:\ib_42\bin\gbak e:\ib_data\AR_IB.GDB e:\ib_data\AR_IB.GBK -user "SYSDBA" -password "oooo" -B -L -Y "e:\IB_DATA\b.txt"
d:\ib_42\bin\gbak e:\ib_data\AR_IB.GBK e:\ib_data\AR_IB.GDB -user "SYSDBA" -password "oooo" -P 4096 -V -R -Y "e:\IB_DATA\r.txt"
```

