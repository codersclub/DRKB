<h1>Как приложение оставить свернутым в иконку?</h1>
<div class="date">01.01.2007</div>


<p>Для этого необходимо обработать сообщение WMQUERYOPEN. Однако обработчик сообщения необходимо поместить в секции private - т.е. в объявлении TForm.</p>
<pre>
procedure WMQueryOpen(var Msg: TWMQueryOpen); message WM_QUERYOPEN; 
 
Реализация будет выглядеть следующим образом:
 
procedure WMQueryOpen(var Msg: TWMQueryOpen); 
begin 
  Msg.Result := 0; 
end;
</pre>


