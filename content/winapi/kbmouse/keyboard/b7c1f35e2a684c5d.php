<h1>Состояние кнопки Insert</h1>
<div class="date">01.01.2007</div>


<pre>
function InsertOn: Boolean;
begin
  
 
  Result:=LowOrderBitSet(GetKeyState(VK_INSERT));
end;
</pre>

<p>Источник: <a href="https://dmitry9.nm.ru/info/" target="_blank">https://dmitry9.nm.ru/info/</a></p>
<p>Исправлено by Vit</p>
