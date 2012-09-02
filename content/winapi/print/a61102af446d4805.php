<h1>Печать текста в обход Windows</h1>
<div class="date">01.01.2007</div>


<p>Откройте файл типа TextFile и пишите в него напрямую:</p>
<pre>
var
  Lst: TextFile;
 
begin
  AssignFile(Lst, 'LPT1');
  Rewrite(Lst);
  WriteLn(Lst, 'Здравствуй, мир!');
  Close(Lst);
end.
</pre>

<p>При этом вы должны помнить, что при данной технологии вы не можете в это же время печатать из другой программы, иначе наступит конец света, а ваша распечатка будет похожа на "запутанный беспорядк".</p>

<p>Если вы планируете посылать на принтер управляющие коды, вызывайте следующую функцию немедленно после перезаписи файла:</p>

<pre>
procedure SetBinaryMode(var F: Text); assembler;
asm
mov ax,$4400
les di,F
mov bx,word ptr es:[di]
int $21
or dl,$20
xor dh,dh
mov ax,$4401
int $21
end;
</pre>


<p>-Steve</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

