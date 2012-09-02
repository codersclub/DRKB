<h1>Bin &gt; Integer</h1>
<div class="date">01.01.2007</div>


<pre>
function BinToInt(Value: string): Integer;
 var
   i, iValueSize: Integer;
 begin
   Result := 0;
   iValueSize := Length(Value);
   for i := iValueSize downto 1 do
     if Value[i] = '1' then Result := Result + (1 shl (iValueSize - i));
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />
<pre>
{by Andre Fritzsche}
 
 unit BinConvert;
 
 interface
 
   //Wandelt Bytewert (Value) zu Binarwert und trennt mit Splitter Hi- und Lo-Bits 
function ToBin(Value: Byte; Splitter: Char): string; overload;
 
   //Wandelt Wordwert (Value) zu Binarwert und trennt mit Splitter Hi- und Lo-Byte 
function ToBin(Value: Word; Splitter: Char): string; overload;
 
   //Wandelt Binarwert (String) zu Zahl (Cardinal) 
function BinTo(Value: string): Cardinal;
 
 implementation
 {------------------------------------------------------------------------------}
 
 function ToBin(Value: Byte; Splitter: Char): string;
 var
   val, bit, intX: Byte;
 begin
   val := Value;
   for intX := 0 to 7 do
   begin   //Alle 8 Bits durchlaufen 
    bit := 48;    //48 (='0') zu bit 
    val := val shr 1; //Value um 1 Bit nach rechts verschieben 
    asm
    adc bit,0   //CarryFlag zu bit addieren 
  end;
     if intX = 4 then Result := Splitter + Result;
     Result := Chr(bit) + Result;   //zu Result hinzufugen 
  end;
 end;
 {------------------------------------------------------------------------------}
 
 function ToBin(Value: Word; Splitter: Char): string;
 begin
   Result := ToBin(Byte(Hi(Value)), Splitter) + Splitter + ToBin(Byte(Lo(Value)), Splitter);
 end;
 {------------------------------------------------------------------------------}
 
 function BinTo(Value: string): Cardinal;
 var
   intX, PosCnt: Byte;
 begin
   Result := 0;
   PosCnt := 0;
   for intX := Length(Value) - 1 downto 0 do //zeichen von rechts durchlaufen 
    case Value[intX + 1] of   //prufen, ob 0 oder 1 
      '0': Inc(PosCnt);  //bei 0 nur Pos-Zahler erhohen 
      '1':
         begin  //bei 1 Bit an Position einfugen 
          Result := Result or (1 shl PosCnt);
           Inc(PosCnt); //und Zahler erhohen 
        end;
     end;
 end;
 {------------------------------------------------------------------------------}
 
 end.
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
