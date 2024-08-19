---
Title: Как включить / выключить спикер?
Date: 01.01.2007
Source: Delphi and Windows API Tips\'n\'Tricks (https://www.chat.ru/\~olmal)
Author: Alexey Lesovik (olmal@mail.ru)
---


Как включить / выключить спикер?
================================

Это выключит спикеp:

    SyStemParametersInfo(SPI_SETBEEP,0,nil,SPIF_UPDATEINIFILE);

Это включит:

    SyStemParametersInfo(SPI_SETBEEP,1,nil,SPIF_UPDATEINIFILE);


Alexey Lesovik  
olmal@mail.ru  
(2:5020/898.15)

