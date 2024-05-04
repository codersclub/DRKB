---
Title: Cколько файлов есть в определенной папке?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Cколько файлов есть в определенной папке?
=========================================

> Как наиболее быстрым способом узнать, сколько файлов с определенным
> расширением есть в определенной папке?

Например для HTM файлов:

    Function GetFileCount(Dir:string):integer;
     
    var fs:TSearchRec;
    begin
      Result:=0;
      if FindFirst(Dir+'*.htm',faAnyFile-faDirectory-faVolumeID, fs)=0 then
        repeat
          inc(Result);
        until FindNext(fs)<>0;
      FindClose(fs);
    end;

