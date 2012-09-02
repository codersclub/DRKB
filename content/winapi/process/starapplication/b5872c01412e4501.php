<h1>Отследить завершение работы, перезагрузку, смену пользователя в Windows</h1>
<div class="date">01.01.2007</div>


<p> &nbsp; &nbsp; &nbsp; &nbsp;Очень часто мы сталкиваемся с проблемой, когда наша программа будучи запущенная в фоне и/или свёрнутая, например, в панель задач должна что-то сделать, когда Windows выключается, перезагружается или просто меняется пользователь.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Если мы не будем отслеживать такую ситуацию, то в худшем случае у нас могут просто потеряться какие-либо данные или Windows просто не сможет выполнить перезагрузку до конца. Ей будет мешать наша программа. Не нужно думать, что Windows перед перезагрузкой рассылает приложениям сообщения о закрытии, так чтобы у тех выпаолнились обработчкики TForm.onCloseQuery/onClose.</p>
<p>ОС Windows отсылает перед перезагрузкой, выключением или сменой пользователя сообщения WM_QUERYENDSESSION, а потом по его успешному завершению WM_ENDSESSION. Наше приложение должно поймать эти сообщения и отреагировать так чтобы дать понять, что мы согласны перезагружаться. В частности на сообщение WM_QUERYENDSESSION мы должны вернуть не 0:</p>The WM_QUERYENDSESSION message is sent when the user chooses to end the Windows session or when an application calls the ExitWindows function. If any application returns zero, the Windows session is not ended. Windows stops sending WM_QUERYENDSESSION messages as soon as one application returns zero.  &nbsp; &nbsp; &nbsp; 
<p>Практически мы уже здесь можем завершить свою программу.</p>
<p>В случае если те действия, которые выполняются при наступлении перезагрузки не велики по величине времени их выполнения, можно не обрабатывать WM_QUERYENDSESSION, а обойтись просто сообещением WM_ENDSESSION. В параметре WParam этого сообщения поступает как раз тот результат, который мы вернули (или не вернули) из сообщения WM_QUERYENDSESSION:</p>
<pre>
protected procedure IsWindowsShutDown(var Msg: TMessage);WM_ENDSESSION;
..
 
 
 
procedure TForm1.IsWindowsShutDown(var Msg: TMessage);
begin 
  inherited;
  if Msg.WParam = 1 then MainForm.Close; // выгружаем приложение 
End;
</pre>



<p>Если нам нужно что-то сделать ещё (например удалить какой-либо файл или записать какую-нибудь информацию), применительно для вышеприведённого примера это можно сделать в обработчиках onCloseQuery/onClose формы.</p>
<p>Процедуру IsWindowsShutDown() мы должны описать в классе того окна, которое будет принимать данное сообщение т.е. формы.</p>

<p class="author">Автор: Song</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

