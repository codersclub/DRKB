---
Title: Как мне избавиться от выскакивающего окна CPU при ошибках?
Date: 01.01.2007
Source: <https://www.delphifaq.com>
---


Как мне избавиться от выскакивающего окна CPU при ошибках?
==========================================================

1. Зайти в реестр:

        HKEY_CURRENT_USER\Software\Borland\Delphi\4.0\Debugging

2. Поменять значение:

        ViewCPUOnException=0

