<h1>Убиваем активное приложение</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Dale Berry</div>

<p>Данная функция позволяет завершить выполнение любой активной программы по её classname или заголовку окна.</p>
<pre>
procedure KillProgram(Classname : string; WindowTitle : string); 
const 
  PROCESS_TERMINATE = $0001; 
var 
  ProcessHandle : THandle; 
  ProcessID: Integer; 
  TheWindow : HWND; 
begin 
  TheWindow := FindWindow(Classname, WindowTitle); 
  GetWindowThreadProcessID(TheWindow, @ProcessID); 
  ProcessHandle := OpenProcess(PROCESS_TERMINATE, FALSE, ProcessId); 
  TerminateProcess(ProcessHandle,4); 
end;
</pre>


<p>  Комментарии</p>

<p>Xianguang Li (22 Октября 2000)</p>

<p>В Delphi 5, при компиляции получается следующая ошибка :</p>
<p>  Incompatible types: 'String' and 'PChar'.</p>
<p>После изменения выражения</p>
<p>  TheWindow := FindWindow(ClassName, WindowTitle)</p>
<p>на</p>
<p>  TheWindow := FindWindow(PChar(ClassName), PChar(WindowTitle)) ,</p>
<p>Нормально откомпилировалось.</p>
<p>И ещё: если мы не знаем ClassName или WindowTitle программы, которую мы хотим убить,</p>
<p>то мы не сможем её завершить. Причина в том, что нельзя вызвать функцию в виде:</p>
<p>  KillProgram(nil, WindowTitle)</p>
<p>  или</p>
<p>  KillProgram(ClassName, nil).</p>
<p>Компилятор не позволяет передать nil в переменную типа String.</p>
<p>Итак, я изменил объявление</p>
<p>  KillProgram(ClassName: string; WindowTitle: string)</p>
<p>на</p>
<p>  KillProgram(ClassName: PChar; WindowTitle: PChar),</p>
<p>вот теперь функция действительно может завершить любое приложение, если вы не знаете</p>
<p>ClassName или WindowTitle этого приложения.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


