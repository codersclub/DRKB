<h1>При использовании DOS DBF файлов &ndash; перекодировка между форматами</h1>
<div class="date">01.01.2007</div>


<p>При использовании DOS DBF файлов можно сделать небольшую программку (или процедурку), которая произведет перекодировку между форматами. что-то типа:</p>

<pre>
function update_dos(s:string):string;
var c:STRING;
    I:INTEGeR;
    l:byte;
    dd:char;
begin
 i:=1;
 c:='';
 while i&lt; length(s)+1 do
 begin
   l:=ord(s[i]);
   inc(i);
   if (l&gt;=128) and (l&lt;=192)then l:=l+64 else
   if (l&gt;=224) and (l&lt;240) then l:=l+16 else
   if l=241 then l:=184 else
   if l=240 then l:=168;
   dd:=chr(l);
   c:=c+dd;
 end;
update_dos:=c;
end;
 
function update_win(s:string):string;
var c:STRING;
    I:INTEGeR;
    l:byte;
    dd:char;
begin
 i:=1;
 c:='';
 while i&lt; length(s)+1 do
 begin
   l:=ord(s[i]);
   inc(i);
   if (l&gt;=192) and (l&lt;240)then l:=l-64 else
   if (l&gt;=240) and (l&lt;256) then l:=l-16 else
   if l=184 then l:=241 else    
   if l=168 then l:=240;
   dd:=chr(l);
   c:=c+dd;
 end;
update_win:=c;
end;
</pre>


<p>это и туда и обратно, у меня работает на старых DBF. Осталось только вызвать в нужный момент.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
