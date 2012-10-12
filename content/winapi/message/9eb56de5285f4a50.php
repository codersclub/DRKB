<h1>Как послать сообщение всем окнам Windows?</h1>
<div class="date">01.01.2007</div>


<pre>
Var
FM_FINDPHOTO: Integer;
// Для использовать hwnd_Broadcast нужно сперва
// зарегистрировать уникальное сообщение
Initialization
FM_FindPhoto:=RegisterWindowMessage('MyMessageToAll');
// Чтобы поймать это сообщение в другом приложении
//(приемнике) нужно перекрыть DefaultHandler
procedure TForm1.DefaultHandler(var Message);
begin
 with TMessage(Message) do
 begin
   if Msg = Fm_FindPhoto then MyHandler(WPARAM,LPARAM)  else
   Inherited DefaultHandler(Message);
 end;
 
end;
 
// А тепрь можно
SendMessage(HWND_BROADCAST,FM_FINDPHOTO,0,0);
</pre>

<p>Кстати, для посылки сообщения дочерним контролам некоего контрола можно использовать метод Broadcast.</p>

<p class="author">Автор: Andrey Burov</p>
<p>(2:463/238.19) </p>

<p class="author">Автор: StayAtHome</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

