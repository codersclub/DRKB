---
Title: Как узнать расход памяти процессом?
Author: Vit
Date: 01.01.2007
---


Как узнать расход памяти процессом?
===================================

::: {.date}
01.01.2007
:::

Расход памяти можно прочитать из виртуального файла

/proc/Pid/status

где Pid - номер процесса

    function ReadProcData(Pid:string; var VmSize, VmLck, VmRSS, VmData, VmStk, VmExe, VmLib, ProcName:string):boolean;
      var f:TextFile;
          s, stat:string;
          i:integer;
     
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
      Result:=False;
      FileMode:=0;
      VmSize:='-1'; VmLck:='-1'; VmRSS:='-1'; VmData:='-1'; VmStk:='-1'; VmExe:='-1'; VmLib:='-1'; ProcName:='';
      try
        try
          try
            assignFile(f,'/proc/'+Pid+'/status');
            reset(f);
            while not eof(f) do
              begin
                readln(f, s);
                if pos('VmSize', s)>0 then VmSize:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('VmLck', s)>0 then VmLck:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('VmRSS', s)>0 then VmRSS:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('VmData', s)>0 then VmData:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('VmStk', s)>0 then VmStk:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('VmExe', s)>0 then VmExe:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('VmLib', s)>0 then VmLib:=GetBefore(' ',trim(GetAfter(':',s)));
                if pos('Name', s)>0 then ProcName:=trim(GetAfter(':',s));
              end;
          finally
            closefile(f);
          end;
        finally
          FileMode:=2;
        end;
        Result:=True;
      except
      end;
    end;

Примечание

Функция может и не сработать, какие-то мгновения файл недоступен по
чтению, выход - повторить процедуру.

Более подробную информацию можно получить запустив в консоле:

man proc

Автор: Vit
