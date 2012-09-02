<h1>Как уведомить все приложения, что реестр был изменен?</h1>
<div class="date">01.01.2007</div>


<p>Для этого можно послать в систему широковещательное сообщение WM_WININICHANGE, указав в нём, что изменения касаются реестра. Большинство приложений, работа которых связана с реестром, должны реагировать на сообщение WM_WININICHANGE.</p>

<p>Пример:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  SendMessage(HWND_BROADCAST,WM_WININICHANGE,0,LongInt(PChar('RegistrySection')));
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

