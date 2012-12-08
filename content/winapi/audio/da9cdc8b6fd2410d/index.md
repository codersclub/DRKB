---
Title: Как включить / выключить спикер?
Date: 01.01.2007
---


Как включить / выключить спикер?
================================

::: {.date}
01.01.2007
:::

Это выключит спикеp:

SyStemParametersInfo(SPI\_SETBEEP,0,nil,SPIF\_UPDATEINIFILE);

Это включит:

SyStemParametersInfo(SPI\_SETBEEP,1,nil,SPIF\_UPDATEINIFILE);

Alexey Lesovik

(2:5020/898.15)

Взято из FAQ:

Delphi and Windows API Tips\'n\'Tricks

olmal\@mail.ru

https://www.chat.ru/\~olmal
