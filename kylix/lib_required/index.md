---
Title: Как посмотреть требуемые библиотеки для бинарника?
Date: 01.01.2007
---


Как посмотреть требуемые библиотеки для бинарника?
==================================================

::: {.date}
01.01.2007
:::

[root\@snoppy hello]# ldd helloworld

  /lib/libNoVersion.so.1 =\> /lib/libNoVersion.so.1 (0x40018000)

  libpthread.so.0 =\> /lib/i686/libpthread.so.0 (0x4002f000)

  libdl.so.2 =\> /lib/lib/libdl.so.2 (0x40044000)

  libc.so.6 =\> /lib/i686/libc.so.6 (0x40048000)

  /lib/ld-linux.so.2 =\> /lib/ld-linux.so.2 (0x40000000)
