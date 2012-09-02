<h1>Перебор всех компонентов на форме</h1>
<div class="date">01.01.2007</div>


<p>Например, надо найти все TCheckBox на форме и установить из все в положение checked:</p>
<pre>
var i: integer;
begin

 
  for i := 0 to ComponentCount - 1 do
    if Components[i] is TCheckBox then
      (Components[i] as TCheckBox).Checked := true;
end;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

