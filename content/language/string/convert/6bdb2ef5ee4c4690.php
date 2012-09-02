<h1>Integer &gt; Bin</h1>
<div class="date">01.01.2007</div>


<pre>
function IntToBin1(Value: Longint; Digits: Integer): string;
 var
   i: Integer;
 begin
   Result := '';
   for i := Digits downto 0 do
     if Value and (1 shl i) &lt;&gt; 0 then
       Result := Result + '1'
   else
     Result := Result + '0';
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
 function IntToBin2(d: Longint): string;
 var
   x, p: Integer;
   bin: string;
 begin
   bin := '';
   for x := 1 to 8 * SizeOf(d) do
   begin
     if Odd(d) then bin := '1' + bin
     else
       bin := '0' + bin;
     d := d shr 1;
   end;
   Delete(bin, 1, 8 * ((Pos('1', bin) - 1) div 8));
   Result := bin;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
