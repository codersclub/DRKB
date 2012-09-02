<h1>Работа с System Menu</h1>
<div class="date">01.01.2007</div>


<p>Добавить новый пункт меню в системное меню диалога:</p>
<pre>
AppendMenu(GetSystemMenu(Self.Handle,FALSE),MF_ENABLED,1001,'&amp;Help'); 
</pre>

<p class="author">Автор ответа: Sheff</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Отловить клик по меню можно следующим образом:</p>
<pre>
private
 
procedure WhetherUserPressesHelp(var Msg: TMessage); message WM_SYSCOMMAND;
 
....
 
  procedure TForm1.WhetherUserPressesHelp(var Msg: TMessage);
  begin
    if Msg.WParam = 1001 then
      HelpForm.ShowModal
    else
      inherited; // к примеру вызываем форму на которой будет помощь
  end;
</pre>

<p class="author">Автор: Song</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

