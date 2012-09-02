<h1>Арабские &gt; Римские</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Конвертация : Римские -&gt; арабские ; Арабские-&gt;Римские
 
Зависимости: 
Автор:       Gua, fbsdd@ukr.net, ICQ:141585495, Simferopol
Copyright:   
Дата:        03 мая 2002 г.
********************************************** }
 
Const
R: Array[1..13] of String[2] =
 ('I','IV','V','IX','X','XL','L','XC','C','CD','D','CM','M');
A: Array[1..13] of Integer=
 (1,4,5,9,10,40,50,90,100,400,500,900,1000);
 
..............
 
Function ArabicToRoman(N : Integer) : String; //Арабские в римские
Var
   i : Integer;
begin
 Result := '';
 i := 13;
 While N &gt;0 do
 begin
   While A[i] &gt;N do Dec(i);
   Result := Result + R[i];
   Dec(N, A[i]);
 end;
end;
</pre>

