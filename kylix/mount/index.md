---
Title: Как сделать mount?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как сделать mount?
==================

    {  The following example shows a Linux-Console application,
       which mount the floppy. 
    } 
     
    program Project1; 
     
    {$APPTYPE CONSOLE} 
    uses 
      Libc; 
     
    begin 
      if mount('/dev/fd0', '/mnt/floppy', 'vfat', MS_RDONLY, nil) = -1 then 
        WriteLn('Mount return : ', Errno, '(', strerror(errno), ')') 
      else 
        WriteLn('Floppy mounted'); 
    end. 

