<h1>Перекодировка в Code 128</h1>
<div class="date">01.01.2007</div>


<pre>
/*
перекодировка символа Widows в code128
*/
CREATE FUNCTION dbo.Win2code128
(@winchar as varchar(1))
RETURNS int
 AS  
BEGIN 
 
DECLARE @code as int
DECLARE @T TABLE( a int, b VARCHAR(1) )
 
insert into @T
select 0 a,' ' b
union all
select 1 a,'!' b
union all
select 2 a,'"' b
union all
select 3 a,'#' b
union all
select 4 a,'$' b
union all
select 5 a,'%' b
union all
select 6 a,'&amp;' b
union all
select 7 a,'''' b
union all
select 8 a,'(' b
union all
select 9 a,')' b
union all
select 10 a,'*' b
union all
select 11 a,'+' b
union all
select 12 a,',' b
union all
select 13 a,'-' b
union all
select 14 a,'.' b
union all
select 15 a,'/' b
union all
select 16 a,'0' b
union all
select 17 a,'1' b
union all
select 18 a,'2' b
union all
select 19 a,'3' b
union all
select 20 a,'4' b
union all
select 21 a,'5' b
union all
select 22 a,'6' b
union all
select 23 a,'7' b
union all
select 24 a,'8' b
union all
select 25 a,'9' b
union all
select 26 a,':' b
union all
select 27 a,';' b
union all
select 28 a,'&lt;' b
union all
select 29 a,'=' b
union all
select 30 a,'&gt;' b
union all
select 31 a,'?' b
union all
select 32 a,'@' b
union all
select 33 a,'A' b
union all
select 34 a,'B' b
union all
select 35 a,'C' b
union all
select 36 a,'D' b
union all
select 37 a,'E' b
union all
select 38 a,'F' b
union all
select 39 a,'G' b
union all
select 40 a,'H' b
union all
select 41 a,'I' b
union all
select 42 a,'J' b
union all
select 43 a,'K' b
union all
select 44 a,'L' b
union all
select 45 a,'M' b
union all
select 46 a,'N' b
union all
select 47 a,'O' b
union all
select 48 a,'P' b
union all
select 49 a,'Q' b
union all
select 50 a,'R' b
union all
select 51 a,'S' b
union all
select 52 a,'T' b
union all
select 53 a,'U' b
union all
select 54 a,'V' b
union all
select 55 a,'W' b
union all
select 56 a,'X' b
union all
select 57 a,'Y' b
union all
select 58 a,'Z' b
union all
select 59 a,'[' b
union all
select 60 a,'\' b
union all
select 61 a,']' b
union all
select 62 a,'^' b
union all
select 63 a,'_' b
union all
select 64 a,'`' b
union all
select 65 a,'a' b
union all
select 66 a,'b' b
union all
select 67 a,'c' b
union all
select 68 a,'d' b
union all
select 69 a,'e' b
union all
select 70 a,'f' b
union all
select 71 a,'g' b
union all
select 72 a,'h' b
union all
select 73 a,'i' b
union all
select 74 a,'j' b
union all
select 75 a,'k' b
union all
select 76 a,'l' b
union all
select 77 a,'m' b
union all
select 78 a,'n' b
union all
select 79 a,'o' b
union all
select 80 a,'p' b
union all
select 81 a,'q' b
union all
select 82 a,'r' b
union all
select 83 a,'s' b
union all
select 84 a,'t' b
union all
select 85 a,'u' b
union all
select 86 a,'v' b
union all
select 87 a,'w' b
union all
select 88 a,'x' b
union all
select 89 a,'y' b
union all
select 90 a,'z' b
union all
select 91 a,'{' b
union all
select 92 a,'|' b
union all
select 93 a,'}' b
union all
select 94 a,'~' b
union all
select 95 a,char(161) b
union all
select 96 a,char(162) b
union all
select 97 a,char(163) b
union all
select 98 a,char(164) b
union all
select 99 a,char(165) b
union all
select 100 a,char(166) b
union all
select 101 a,char(167) b
union all
select 102 a,char(168) b
union all
select 103 a,char(169) b
union all
select 104 a,char(170) b
union all
select 105 a,char(171) b
union all
select 106 a,char(172) b
 
select @code=a
from @T
where ascii(b)=ascii(@winchar)
 
set @code=isnull(@code,0)
 
return (@code)
 
END 
</pre>
<p class="author">Автор: Sh@dow</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
