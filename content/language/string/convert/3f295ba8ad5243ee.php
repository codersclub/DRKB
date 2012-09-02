<h1>Hex &gt; Bin</h1>
<div class="date">01.01.2007</div>


<pre>
function HexToBin(Hexadecimal: string): string;
 const
   BCD: array [0..15] of string =
     ('0000', '0001', '0010', '0011', '0100', '0101', '0110', '0111',
     '1000', '1001', '1010', '1011', '1100', '1101', '1110', '1111');
 var
   i: integer;
 begin
   for i := Length(Hexadecimal) downto 1 do
     Result := BCD[StrToInt('$' + Hexadecimal[i])] + Result;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage(HexToBin('FFA1'));
   // Returns 1111111110100001 
end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
