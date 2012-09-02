<h1>Как запустить любой апплет панели управления?</h1>
<div class="date">01.01.2007</div>


<p>Апплеты в панели управления можно запускать при помощи функции WinExec, запуская control.exe и передав ей в качестве параметра имя апплета. Файлы апплетов (.cpl) обычно находятся в системной директории Windows.</p>
<p>Некоторые из апплетов могут располагаться за пределами системной директории, поэтому их прийдётся запускать просто по имени.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  WinExec('C:\WINDOWS\CONTROL.EXE TIMEDATE.CPL', 
       sw_ShowNormal);
  WinExec('C:\WINDOWS\CONTROL.EXE MOUSE', 
       sw_ShowNormal);
  WinExec('C:\WINDOWS\CONTROL.EXE PRINTERS', 
       sw_ShowNormal);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
