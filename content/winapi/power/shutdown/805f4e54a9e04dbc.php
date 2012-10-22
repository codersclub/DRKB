<h1>Узнать о завершении работы Windows</h1>
<div class="date">01.01.2007</div>


<p>Если текст в Memo1 был изменен, то программа не разрешает завершения сеанса Windows.</p>
<pre>
...
private
    procedure WMQueryEndSession(var Msg: TWMQueryEndSession); message WM_QUERYENDSESSION;
...
procedure TForm1.WMQueryEndSession(var Msg: TWMQueryEndSession);
begin
  Msg.Result := integer(not Memo1.Modified);
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>


<hr>

<p class="author">Автор: Nomadic</p>

<b>Как корректно перехватить сигнал выгрузки операционной системы, если в моей программе нет окна </b>

<p>Используй GetMessage(), в качестве HWND окна пиши NULL (на Паскале - 0). Если в очереди сообщений следующее - WM_QUIT, то эта функция фозвращает FALSE. Если ты пишешь программу для Win32, то запихни это в отдельный поток, организующий выход из программы. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
