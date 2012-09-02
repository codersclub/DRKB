<h1>Получить слово под курсором в TRichEdit</h1>
<div class="date">01.01.2007</div>

<pre>
uses 
 RichEdit; 
 
procedure TForm1.RichEdit1MouseMove(Sender: TObject; Shift: TShiftState; 
  X, Y: Integer); 
var 
  iCharIndex, iLineIndex, iCharOffset, i, j: Integer; 
  Pt: TPoint; 
  s: string; 
begin 
  with TRichEdit(Sender) do 
  begin 
    Pt := Point(X, Y); 
    // Get Character Index from word under the cursor 
    iCharIndex := Perform(Messages.EM_CHARFROMPOS, 0, Integer(@Pt)); 
    if iCharIndex &lt; 0 then Exit; 
    // Get line Index 
    iLineIndex  := Perform(EM_EXLINEFROMCHAR, 0, iCharIndex); 
    iCharOffset := iCharIndex - Perform(EM_LINEINDEX, iLineIndex, 0); 
    if Lines.Count - 1 &lt; iLineIndex then Exit; 
    // store the current line in a variable 
    s := Lines[iLineIndex]; 
    // Search the beginning of the word 
    i := iCharOffset + 1; 
    while (i &gt; 0) and (s[i] &lt;&gt; ' ') do Dec(i); 
    // Search the end of the word 
    j := iCharOffset + 1; 
    while (j &lt;= Length(s)) and (s[j] &lt;&gt; ' ') do Inc(j); 
    // Display Text under Cursor 
    Caption := Copy(s, i, j - i); 
  end; 
end;  
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
