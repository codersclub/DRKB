---
Title: Как получить статус принтера?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как получить статус принтера?
=============================

    function TestPrinterStatus(LPTPort: Word): Byte; 
    var 
      Status: byte; 
      CheckLPT: word; 
    begin 
      Status := 0; 
      if (LPTPort >= 1) and (LPTPort <= 3) then 
      begin 
        CheckLPT := LPTPort - 1; 
        asm 
          mov dx, CheckLPT; 
          mov al, 0; 
          mov ah, 2; 
          int 17h; 
          mov &Status, ah; 
        end; 
      end; 
      Result := Status; 
    end; 
     
     
    { 
      Pass in the LPT port number you want to check & get the following back: 
      01h - Timeout 
      08h - I/O Error 
      10h - Printer selected 
      20h - Out of paper 
      40h - Printer acknowledgement 
      80h - Printer not busy (0 if busy) 
     
      Note: 
      This function doesn't work under NT, it gives an access violation 
      from the DOS interrupt call. 
    } 

