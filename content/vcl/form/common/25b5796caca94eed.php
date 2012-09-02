<h1>Привлечение внимания к окну</h1>
<div class="date">01.01.2007</div>


<p>Часто возникает проблема - в многооконном приложении необходимо обратить внимание пользователя на то, что какое-то из окон требует внимания (например, к нему пришло сообщение по DDE, в нем завершился какой-либо процесс, произошла ошибка ...). Это легко сделать, используя команду API FlashWindow:</p>
<pre>
procedure TForm1.Timer1Timer(Sender: TObject);
begin
 FlashWindow(Handle,true);
end;
</pre>


<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
