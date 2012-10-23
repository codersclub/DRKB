<h1>Как узнать свободное место на диске?</h1>
<div class="date">01.01.2007</div>


<p>В коде используется функция ExecCmdine из статьи: <a href="z1000.htm">Как запустить консольное приложение и перехватить вывод?</a></p>
<pre>
function GetFreeSpace(Share:string):integer; {in Kb}
  var t:TstringList;
      i:integer;
      temp:string;
      mesure:char;
      multi:integer;
      f:real;
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
</pre>

<p>Использование:</p>
<p>function GetFreeSpace('/dev/hda5')</p>
<p class="note">Примечание</p>
<p>Под отладчиком Kylix код может не работать. Надо запускать приложение не под Kylix для того чтобы удостовериться что код работает.</p>
<p>Более подробную информацию можно получить запустив в консоле:</p>
<p>man df</p>
<div class="author">Автор: Vit</div>

