---
Title: Защита от копирования с CD
Date: 01.01.2007
---


Защита от копирования с CD
==========================

::: {.date}
01.01.2007
:::

    Procedure craye_file_inc;
    var j    : int64;
         buf : array[word] of byte;
         St  : TFileStream;
    begin
     for j:=0 to 32766 do
      buf[j]:=byte(j); // ne pas craye un fichier de moins de 32k
     st:=Tfilestream.create('Protection.dat',fmCreate);
     for j:=0 to 10 do
      st.write(Buf,Sizeof(Buf));
     st.free;
    end;

    // dans votre programme
    Function CheckIfOriginalCd:Boolean
    var f       : thandle;
          b      : array[0..500] of byte;
          lus    : integer;
         Totlus : Int64;
    begin
     result:=false;
     Totlus:=0;
     if not fileexist('Protection.dat') then exit;
     f:=Filecreate('Protection.dat',fmRead);
     while true do
      begin
       try
        Fileread(f,b,lus);
       exept
        break;
       end;
       totlus:=totlus+lus;
       if lus=0 then
         break;
      end;
     if filesize('Protection.dat')<>Totlus then
      if attributs, time etc etc... then
       result:=true;
    end;  
