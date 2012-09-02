<h1>Автозаполнение формы для нового письма</h1>
<div class="date">01.01.2007</div>


<p>А вот пример автозаполнения формы для нового письма в почтовой программе установленной по умолчанию:</p>
<pre>uses shellapi;
 

 
...
procedure TForm1.Button1Click(Sender: TObject);
begin
shellexecute(handle,
'Open',
'mailto:someone@somewhere.ru?subject=Regarding your advice&amp;Body=First%20Line%0D%0ASecond%20line&amp;CC=somebodyelse@somewhere.ru',
nil, nil, sw_restore);
end;
</pre>

<p>Немного пояснений:</p>
<p>1) Пробелы в тексте желательно заполнять сочетанием %20</p>
<p>2) Конец строки обозначать как %0D%0A</p>
<p>3) Поля отделять друг от друга символом &amp;</p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

