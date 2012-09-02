<h1>Byte &gt; Bin</h1>
<div class="date">01.01.2007</div>


<pre>
function ByteToBinStr(a_bByte: byte): string;
var
 i: integer;
begin
 SetLength(Result, 8);
 for i := 8 downto 1 do
 begin
   Result[i] := chr($30 + (a_bByte and 1));
   a_bByte := a_bByte shr 1;
 end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
