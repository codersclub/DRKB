<h1>Как удалить файл после перезагрузки Windows?</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: inko</div>

<p>Я использую функцию, которая заносит в ключ реестра RunOnce командную строку:</p>
<p>command.com /c del C:\Путь\Имя_файла</p>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<div class="author">Автор: VoL</div>

<p>В wininit добавляешь строку NUL={ПУТЬ УДАЛЯЕМОГО ФАЙЛА}</p>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<div class="author">Автор: p0s0l</div>

<p>Еще есть способ через реестр:</p>

<pre>
uses Registry;
 
procedure DeleteFileOnRestart (const FileName : String);
var Reg : TRegistry;
begin 
  Reg := TRegistry.Create;
  Reg.RootKey := HKEY_LOCAL_MACHINE;
  Reg.OpenKey ('Software\Microsoft\Windows\CurrentVersion\RunOnce', False);
  Reg.WriteString ('Selfdel9x','command.com /C del "' + FileName + '"');
  Reg.WriteString ('SelfdelNT','cmd /C del "' + FileName + '"');
  Reg.CloseKey;
  Reg.Free;
end;
</pre>
<p>Тут две команды добавляются, т.к. на XP с command.com не рабоает...</p>
<p>Одна из них сработает, а другая пройдет в холостую...</p>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
