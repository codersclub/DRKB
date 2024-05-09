---
Title: Как узнать свободное место на диске?
Author: Vit
Date: 01.01.2007
---


Как узнать свободное место на диске?
====================================

В коде используется функция ExecCmdine из статьи:
[Как запустить консольное приложение и перехватить вывод?](/kylix/capture_console_output/)

    function GetFreeSpace(Share:string):integer; {in Kb}
      var t:TstringList;
          i:integer;
          temp:string;
          mesure:char;
          multi:integer;
          f:real;
      function getbefore(substr, str:string):string;
      begin
        if pos(substr,str)>0 then result:=copy(str,1,pos(substr,str)-1)
        else result:='';
      end;
     
      function getafter(substr, str:string):string;
      begin
        if pos(substr,str)>0 then result:=copy(str,pos(substr,str)+length(substr),length(str))
        else result:='';
      end;
    begin
      Result:=-1;
      t:=TstringList.Create;
      ExecCmdine('df -h', t);
      For i:=0 to t.Count-1 do
        if pos(Share, t[i])=1 then
          begin
            temp:=trim(GetAfter(Share, t[i]));
            temp:=trim(GetAfter(' ', temp));
            temp:=trim(GetAfter(' ', temp));
            temp:=trim(GetBefore(' ', temp));
            if temp='' then exit;
            mesure:=temp[length(temp)];
            Case mesure of
              'G','g':multi:=1024*1024;
              'M','m':multi:=1024;
              'K','k':multi:=1;
              else multi:=0;
            end;
            try
              f:=strtofloat(copy(temp,1,length(temp)-1));
            except
              f:=0;
            end;
            result:=Round(f*multi);
          end;
    end;

Использование:

    function GetFreeSpace('/dev/hda5')

**Примечание:**

Под отладчиком Kylix код может не работать.
Надо запускать приложение не под Kylix,
для того чтобы удостовериться что код работает.

Более подробную информацию можно получить запустив в консоли:

    man df
