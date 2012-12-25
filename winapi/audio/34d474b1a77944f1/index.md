---
Title: Как изменить громкость?
Date: 01.01.2007
---


Как изменить громкость?
=======================

::: {.date}
01.01.2007
:::

    procedure SetVolume(X: Word); 
    var 
      iErr : Integer; 
      i: integer; 
      a: TAuxCaps; 
    begin 
      for i := 0 to auxGetNumDevs do begin 
        auxGetDevCaps(i,Addr(a),SizeOf(a)); 
        If a.wTechnology = AUXCAPS_CDAUDIO Then break; 
      end; 
     
      // Устанавливаем одинаковую громкость для левого и правого каналов. 
      // VOLUME := LEFT*$10000 + RIGHT*1
     
      iErr:=auxSetVolume(i,(X*$10001)); 
      if (iErr‹›0) then ShowMessage('No audio devices are available!'); 
    end; 
     
    function GetVolume: Word; 
    var 
      iErr : Integer; 
      i: integer; 
      a: TAuxCaps; 
      vol: word; 
    begin 
      for i := 0 to auxGetNumDevs do begin 
        auxGetDevCaps(i,Addr(a),SizeOf(a)); 
        If a.wTechnology = AUXCAPS_CDAUDIO Then break; 
      end; 
      iErr:=auxGetVolume(i,addr(vol)); 
      GetVolume := vol; 
      if (iErr‹›0) then ShowMessage('No audio devices are available!'); 
    end; 

Взято из <https://forum.sources.ru>
