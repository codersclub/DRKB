<h1>Bin &gt; Byte</h1>
<div class="date">01.01.2007</div>


<pre>
function BinStrToByte(a_sBinStr: string): byte;
var
 i: integer;
begin
 Result := 0;
 for i := 1 to length(a_sBinStr) do
   Result := (Result shl 1) or byte(a_sBinStr[i] = '1');
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
