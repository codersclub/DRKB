---
Title: Чем отличаются «версионники» от «блокировочников»?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Чем отличаются «версионники» от «блокировочников»?
==================================================

Классические «блокировочники» не дают возможности разным транзакциям
одновременно изменять одни и те же записи, блокируя их на время
транзакции. В результате, при попытке изменить заблокированную запись,
другая транзакция будет простаивать, пока не завершится первая.

В свою очередь, «версионники» позволяют одновременно модифицировать одни
и те же записи, создавая при этом разные версии одной записи.


