---
Title: Как перевести монитор в режим standby?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как перевести монитор в режим standby?
======================================

Если монитор поддерживает режим Stand by, то его можно программно
перевести в этот режим. Данная возможность доступна на Windows95 и выше.

Чтобы перевести монитор в режим Stand by:

    SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, 0);

Чтобы вывести его из этого режима:

    SendMessage(Application.Handle, wm_SysCommand, SC_MonitorPower, -1);


