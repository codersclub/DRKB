<h1>Как сделать отступ в TMemo?</h1>
<div class="date">01.01.2007</div>


<p>С помощью API-функции SendMessage можно задать поля в Memo-компоненте. Если необходимо, например, сделать отступ в 20 пикселей слева то можно это сделать следующим образом: </p>

<pre>
var Rect: TRect; 
begin 
  SendMessage( Memo1.Handle, EM_GETRECT, 0, LongInt(@Rect)); 
  Rect.Left:= 20; 
  SendMessage(Memo1.Handle, EM_SETRECT, 0, LongInt(@Rect)); 
  Memo1.Refresh; 
end; 
</pre>


<p>действует до первого изменения размеров компонента TMemo, поэтому указанный код необходимо поместить в обработчик OnResize компонента владельца - формы или панели. Приводит к дополнительной перерисовке TMemo при отправке сообщения. </p>
