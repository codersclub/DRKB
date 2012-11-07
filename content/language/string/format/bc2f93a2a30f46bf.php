<h1>Удаление ненужных подстрок из строки</h1>
<div class="date">01.01.2007</div>


<pre>
procedure RemoveInvalid(what, where: string): string;
// what - удаляемая подстрока, where - обрабатываемая строка
var
  tstr: string;
begin
  tstr:=where;
  while pos(what, tstr)&gt;0 do
    tstr:=copy(tstr,1,pos(what,tstr)-1) +
  copy(tstr,pos(what,tstr)+length(tstr),length(tstr));
  Result:=tstr;
end; 
 
 
 
 
//Применение: 
 
 
 
NewStr:=RemoveInvalid('&lt;брак&gt;','Этот &lt;брак&gt; в моей строке, и я хочу
удалить из нее этот &lt;брак&gt;');
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
<hr /><p>Используйте стандартную функцию Pascal DELETE...</p>
<p>Пользуясь тем же примером, вы можете сделать так....</p>
<pre>Target:='&lt;брак&gt;';
While POS(Target,string)&gt;0 do
begin
  P := POS(Target,string);
  DELETE(string,P,Length(Target));
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
<hr />
<p>Всё даже проще:</p>
<pre>

Result:=StringReplace(ИсходнаяСтрока,ТоЧтоНадоУдалить,'',[rfReplaceAll])
</pre>

<div class="author">Автор: Vit</div>


