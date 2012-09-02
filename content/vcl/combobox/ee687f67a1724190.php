<h1>Как опеделить состояние списка ComboBox, выпал / скрыт?</h1>
<div class="date">01.01.2007</div>


<p>Пошлите ComboBox сообщение CB_GETDROPPEDSTATE.</p>

<pre>
if SendMessage(ComboBox1.Handle, CB_GETDROPPEDSTATE, 0, 0) = 1 then
  begin {список ComboBox выпал}
 
  end;
</pre>


