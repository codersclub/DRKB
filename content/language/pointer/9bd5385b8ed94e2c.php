<h1>Пример работы с указателями</h1>
<div class="date">01.01.2007</div>


<pre>

var
  p1 : ^String;
  s1 : String;
begin
  s1 := 'NotTest';
  new (p1);
  p1 := @s1;
  p1^ := 'Test';
  Label1.Caption := s1
</pre>
&nbsp;</p>
&nbsp;</p>
<div class="author">Автор: Baa</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
&nbsp;</p>
