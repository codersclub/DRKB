<h1>Конвертация арабских цифр в римские</h1>
<div class="date">01.01.2007</div>


<pre>
function IntToRoman(num: Cardinal): String;  {returns num in capital roman digits}
const
  Nvals = 13;
  vals: array [1..Nvals] of word = (1, 4, 5, 9, 10, 40, 50, 90, 100, 400, 500, 900, 1000);
  roms: array [1..Nvals] of string[2] = ('I', 'IV', 'V', 'IX', 'X', 'XL', 'L', 'XC', 'C', 'CD', 'D', 'CM', 'M');
var
  b: 1..Nvals;
begin
  result := '';
  b := Nvals;
  while num &gt; 0 do
  begin
    while vals[b] &gt; num do
      dec(b);
    dec (num, vals[b]);
    result := result + roms[b]
  end;
end;
</pre>

<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
