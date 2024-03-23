---
Title: Как на Oracle поменять compatible?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как на Oracle поменять compatible?
==================================

>Подскажите, как на Oracle 7.3.2.3 (Solaris x86) поменять compatible
>на 7.3.2.3 (c 7.1.0.0)?

Ставить в initmybase.ora:

    compatible = "7.3.2.3"

и после старта с новым параметром сделать

    ALTER DATABASE RESET COMPABILITY;

И рестартовать базу.

