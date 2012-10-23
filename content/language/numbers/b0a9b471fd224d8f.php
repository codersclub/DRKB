<h1>Как округлять до сотых в большую сторону?</h1>
<div class="date">01.01.2007</div>


<p>Прибавляешь 0.5 затем&nbsp; отбрасываешь дробную часть:</p>
<pre>
Uses Math;  

 
Function RoundMax(Num:real; prec:integer):real; 
begin 
  result:=roundto(num+Power(10, prec-1)*5, prec); 
end;
</pre>
<p>До сотых соответственно будет:</p>
<pre>
Function RoundMax100(Num:real):real; 

 
begin 
  result:=round(num*100+0.5)/100; 
end; 
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

