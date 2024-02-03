---
Title: Конфликт IDAPI German и English
Author: Walter Schell
Date: 01.01.2007
---


Конфликт IDAPI German и English
===============================

::: {.date}
01.01.2007
:::

Я просто установил DtopicsP v1.20 и DtopicsD (03-29-96). При запуске
dtopics.exe возникает ошибка DB-Error $3E05 (\'cannot load driver\')
(не могу загрузить драйвер).

Я нашел ответ в German Borland Forum. Ошибка происходит, если установлен
German BDE. В этом случае в систему устанавливается вместо IDR10009.DLL
(который присутствует в английской версии) файл IDR10007.DLL. После
установки данного файла в каталог IDAPI все заработало как часы.

Это означает, что приложения, разработанные под English Delphi не будут
работать под German или French Delphi.

Автор: Walter Schell

Взято с <https://delphiworld.narod.ru>
