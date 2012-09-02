<h1>Hex &gt; Integer</h1>
<div class="date">01.01.2007</div>



<pre>
var
  i: integer
  s: string;
begin
  s := '$' + ThatHexString;
  i := StrToInt(a);
end;
</pre>

<hr />
<pre>
const HEX: array['A'..'F'] of INTEGER = (10, 11, 12, 13, 14, 15);
var str: string;
    Int, i: integer;
begin
  READLN(str);
  Int := 0;
  for i := 1 to Length(str) do
    if str[i] &lt; 'A' then
      Int := Int * 16 + ORD(str[i]) - 48
    else
      Int := Int * 16 + HEX[str[i]];
  WRITELN(Int);
  READLN;
end.
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

