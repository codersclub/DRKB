<h1>PWideChar &gt; String</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Конвертация PWideChar в String
 
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Andre .v.d. Merwe
Дата:        18 июля 2002 г.
********************************************** }
 
function PWideToString(pw : PWideChar) : string;
var
  p : PChar;
  iLen : integer;
begin
   iLen := lstrlenw( pw ) + 1;
   GetMem( p, iLen );
 
   WideCharToMultiByte( CP_ACP, 0, pw, iLen, p, iLen * 2, nil, nil );
 
   Result := p;
   FreeMem( p, iLen );
end;
</pre>

