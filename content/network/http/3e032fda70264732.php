<h1>HTTP кодирование строки</h1>
<div class="date">01.01.2007</div>


<pre>
function HTTPEncode(const AStr: string): string;
 const
   NoConversion = ['A'..'Z', 'a'..'z', '*', '@', '.', '_', '-'];
 var
   Sp, Rp: PChar;
 begin
   SetLength(Result, Length(AStr) * 3);
   Sp := PChar(AStr);
   Rp := PChar(Result);
   while Sp^ &lt;&gt; #0 do
   begin
     if Sp^ in NoConversion then
       Rp^ := Sp^
     else if Sp^ = ' ' then
       Rp^ := '+'
     else
     begin
       FormatBuf(Rp^, 3, '%%%.2x', 6, [Ord(Sp^)]);
       Inc(Rp, 2);
     end;
     Inc(Rp);
     Inc(Sp);
   end;
   SetLength(Result, Rp - PChar(Result));
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   Edit1.Text := HTTPEncode(Edit1.Text);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
