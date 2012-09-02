<h1>Выключение питания ATX коpпуса из-под DOS</h1>
<div class="date">01.01.2007</div>


<pre>
mov ax,5301h
sub bx,bx
int 15h
jb stop
mov ax,530eh
sub bx,bx
int 15h
jb stop
mov ax,5307h
mov bx,0001h
mov cx,0003h
int 15h
stop: int 20h
</pre>

<p>Код прислал Колесников Сергей Александрович [mailto:rovd@inbox.ru]</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

