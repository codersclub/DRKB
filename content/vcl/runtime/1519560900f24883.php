<h1>Как создать контрол в runtime?</h1>
<div class="date">01.01.2007</div>


<pre>
var Butt:TButton;

begin
  Butt:=TButton.Create(Self);
  Butt.Parent:=self;
  Butt.Visible:=true;
end;
</pre>

<div class="author">Автор: Fantasist</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

