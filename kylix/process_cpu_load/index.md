---
Title: Как узнать загрузку CPU определенным процессом?
Author: Vit
Date: 01.01.2007
---


Как узнать загрузку CPU определенным процессом?
===============================================

В коде используется функция ExecCmdine из статьи:
[Как запустить консольное приложение и перехватить вывод?](/kylix/capture_console_output/)

    Procedure ReadProcLoad(Pid:string; var CPU, Mem:string);
      var t:TStringList;
          s:string;
     
      Function GetLine:string;
        var i:integer;
      begin
        For i:=0 to t.Count-1 do
          if (pos(Pid, t[i])<10) and (pos(Pid, t[i])>0) then Result:=t[i];
      end;
     
    begin
      t:=TStringList.Create;
      try
        ExecCmdine('top -n1 p '+PID, t);
        try
          s:=GetLine;
          s:=GetBefore(':',s);
          s:=trim(copy(s,1,lastDelimiter(' ',s)));
          Mem:=trim(copy(s,lastDelimiter(' ',s), length(s)));
          s:=trim(copy(s,1,lastDelimiter(' ',s)));
          CPU:=trim(copy(s,lastDelimiter(' ',s), length(s)));
        except
          CPU:='-1';
          Mem:='-1';
        end
      finally
        t.Free;
      end;
    end;

В процедуру передаётся PID процесса, а возвращается использование CPU и
памяти процессом. Более подробную информацию можно получить запустив в
консоли:

    man top

**Примечание**

Под отладчиком Kylix код может не работать. Надо запускать приложение не
под Kylix для того чтобы удостовериться что код работает. Кроме того
некоторые консольные приложения, типа top не совсем стандартно
используют консоль, поэтому я наблюдала такое явление, что  top можно
запустить только если запускать готовое приложение в терминале.

