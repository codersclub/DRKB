<h1>Dec &gt; Hex</h1>
<div class="date">01.01.2007</div>


<pre>
function dec2hex(value: dword): string[8];
const
  hexdigit = '0123456789ABCDEF';
begin
  while value &lt;&gt; 0 do
  begin
    dec2hex := hexdigit[succ(value and $F)];
    value := value shr 4;
  end;
  if dec2hex = '' then dec2hex := '0';
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
