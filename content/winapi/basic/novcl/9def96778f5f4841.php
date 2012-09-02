<h1>Альтернатива для Sleep(), но чтобы приложение не зависало</h1>
<div class="date">01.01.2007</div>


<p>Часто требуется организовать задержку в выполнении кода, но что бы при этому приложение не зависало, могло реагировать на сообщения Windows, в часности могло перерисовываться..</p>
<pre>
procedure Delay(ATimeout: Integer);

 
var
  t: Cardinal;
begin
  while ATimeout &gt; 0 do
  begin
    t := GetTickCount;
    if MsgWaitForMultipleObjects(0, nil^, False, ATimeOut, QS_ALLINPUT) = WAIT_TIMEOUT then
      Exit;
    Application.ProcessMessages;  // Пришли новые сообщения Windwos , обрабатываем их..
    dec(ATimeout, GetTickCount - t);
  end;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p class="author">Автор: jack128 </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
