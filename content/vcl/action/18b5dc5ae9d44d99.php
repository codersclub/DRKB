<h1>Как в runtime добавить TAction в TActionList?</h1>
<div class="date">01.01.2007</div>


<pre>
var

  NewAction : TAction;
begin
  NewAction := TAction.Create(self);
  NewAction.ActionList := ActionList1;
end; 
</pre>
<p class="author">Автор ответа: Dayana </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
