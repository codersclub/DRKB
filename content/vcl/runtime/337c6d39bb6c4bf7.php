<h1>Как найти компонент по имени?</h1>
<div class="date">01.01.2007</div>


<p>Обратится к компоненту по имени можно например так, если стоит 10 CheckBox - от CheckBox1 до CheckBox10 то</p>
<pre>

For i:=1 to 10 do
  (FindComponent(Format('CheckBox%d',[i])) as TCheckBox).checked:=true;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
