---
Title: Как получить информацию о BIOS в Windows 9x?
Date: 01.01.2007
---


Как получить информацию о BIOS в Windows 9x?
============================================

::: {.date}
01.01.2007
:::

    with Memo1.Lines do 
    begin 
      Add('MainBoardBiosName:'+^I+string(Pchar(Ptr($FE061)))); 
      Add('MainBoardBiosCopyRight:'+^I+string(Pchar(Ptr($FE091)))); 
      Add('MainBoardBiosDate:'+^I+string(Pchar(Ptr($FFFF5)))); 
      Add('MainBoardBiosSerialNo:'+^I+string(Pchar(Ptr($FEC71)))); 
    end;

Взято из <https://forum.sources.ru>