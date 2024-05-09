---
Title: Как узнать имя компьютера?
Author: Vit
Date: 01.01.2007
---


Как узнать имя компьютера?
==========================

    Uses Libc;
     
    Function GetPCName:string;
    var Name:PChar;
        Len:Cardinal;
    begin
      Len:=255;
      GetMem(Name, Len);
      gethostname(Name, Len);
      Result:=String(Name);
      FreeMem(Name);
    end;
