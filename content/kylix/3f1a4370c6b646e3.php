<h1>Как узнать расход памяти процессом?</h1>
<div class="date">01.01.2007</div>


<p>Расход памяти можно прочитать из виртуального файла</p>
<p>/proc/Pid/status</p>
<p>где Pid - номер процесса</p>
<pre>
function ReadProcData(Pid:string; var VmSize, VmLck, VmRSS, VmData, VmStk, VmExe, VmLib, ProcName:string):boolean;
  var f:TextFile;
      s, stat:string;
      i:integer;
 
  function getbefore(substr, str:string):string;
  begin
    if pos(substr,str)&gt;0 then result:=copy(str,1,pos(substr,str)-1)
    else result:='';
  end;
 
  function getafter(substr, str:string):string;
  begin
    if pos(substr,str)&gt;0 then result:=copy(str,pos(substr,str)+length(substr),length(str))
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
            if pos('VmSize', s)&gt;0 then VmSize:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('VmLck', s)&gt;0 then VmLck:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('VmRSS', s)&gt;0 then VmRSS:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('VmData', s)&gt;0 then VmData:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('VmStk', s)&gt;0 then VmStk:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('VmExe', s)&gt;0 then VmExe:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('VmLib', s)&gt;0 then VmLib:=GetBefore(' ',trim(GetAfter(':',s)));
            if pos('Name', s)&gt;0 then ProcName:=trim(GetAfter(':',s));
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
</pre>

<p class="note">Примечание</p>
<p>Функция может и не сработать, какие-то мгновения файл недоступен по чтению, выход - повторить процедуру.</p>
<p>Более подробную информацию можно получить запустив в консоле:</p>
<p>man proc</p>
<div class="author">Автор: Vit</div>
