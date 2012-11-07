<h1>Умножение больших целых чисел</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
type
   IntNo = record
     Low32, Hi32: DWORD;
   end;
 
 function Multiply(p, q: DWORD): IntNo;
 var
   x: IntNo;
 begin
   asm
     MOV EAX,[p]
     MUL [q]
     MOV [x.Low32],EAX
     MOV [x.Hi32],EDX
   end;
   Result := x
 end;
 
 
 // Test the above with: 
// So kannst du es testen 
 
var
   r: IntNo;
 begin
    r := Multiply(40000000, 80000000);
    ShowMessage(IntToStr(r.Hi32) + ', ' + IntToStr(r.low32))
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
