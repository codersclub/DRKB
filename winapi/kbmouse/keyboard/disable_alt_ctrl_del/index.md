---
Title: Как запретить Ctrl-Alt-Del?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как запретить Ctrl-Alt-Del?
===========================

    var 
      i : integer; 
    begin 
      i := 0; 
      {запрещаем Ctrl-Alt-Del} 
      SystemParametersInfo( SPI_SCREENSAVERRUNNING, 1, @i, 0); 
    end. 
    // необходим unit WinProcs
    // для Alt-Tab: SPI_SETFASTTASKSWITCH 

