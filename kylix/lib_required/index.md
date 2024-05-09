---
Title: Как посмотреть требуемые библиотеки для бинарника?
Date: 01.01.2007
---


Как посмотреть требуемые библиотеки для бинарника?
==================================================

Допустим, бинарник называется `helloworld`,
тогда в консоли набираем:

    [root@hostname]# ldd helloworld

В результате получим примерно такой результат:

    /lib/libNoVersion.so.1 => /lib/libNoVersion.so.1 (0x40018000)
    libpthread.so.0 => /lib/i686/libpthread.so.0 (0x4002f000)
    libdl.so.2 => /lib/lib/libdl.so.2 (0x40044000)
    libc.so.6 => /lib/i686/libc.so.6 (0x40048000)
    /lib/ld-linux.so.2 => /lib/ld-linux.so.2 (0x40000000)
