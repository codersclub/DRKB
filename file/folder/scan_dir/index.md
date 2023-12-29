---
Title: Проход дерева каталогов
Author: Vit
Date: 01.01.2007
---


Проход дерева каталогов
=======================

::: {.date}
01.01.2007
:::

Вариант 1:

    Procedure ScanDir(Dir:string);
    var SearchRec:TSearchRec;
    begin
      if Dir<>'' then if Dir[length(Dir)]<>'\' then Dir:=Dir+'\';
      if FindFirst(Dir+'*.*', faAnyFile, SearchRec)=0 then
      repeat
        if (SearchRec.name='.') or (SearchRec.name='..') then continue;
        if (SearchRec.Attr and faDirectory)<>0 then
          ScanDir(Dir+SearchRec.name) //we found Directory: "Dir+SearchRec.name"
        else
          Showmessage(Dir+SearchRec.name); //we found File: "Dir+SearchRec.name"
      until FindNext(SearchRec)<>0;
      FindClose(SearchRec);
    end;

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ScanDir('c:');
    end;

Автор: Vit

-----------------------------
Вариант 2:

Ненамного сложнее, но возможностей поболе будет.

    procedure ScanDir (Path:string;SearchMask:TStrings;ScanSub:boolean);
    var
      SearchRec:TSearchrec;
      a,i:integer;
    begin
      if ScanSub then
      begin
        FindFirst(path+'*.*',faDirectory,SearchRec);{. found}
        FindNext(SearchRec); {.. found}
        a:=FindNext(SearchRec);
        while a=0 do
        begin
          if (SearchRec.Attr and faDirectory)>0 then 
            ScanDir(Path+'\'+SearchRec.Name,SearchMask,ScanSub);
          a:=FindNext(SearchRec);
        end;{while}
        FindClose(SearchRec);
      end;{if}
       
      for i:=0 to SearchMask.Count-1 do
      begin
        a:=FindFirst(Path+'\'+SearchMask[i],faAnyFile,SearchRec);
        while a=0 do
        begin
          {operation on file}
          a:=FindNext(SearchRec);
        end;{while}
        FindClose(SearchRec);
      end;{for}
     
    end; {ScanDir}

Автор: December

Взято с Vingrad.ru <https://forum.vingrad.ru>
