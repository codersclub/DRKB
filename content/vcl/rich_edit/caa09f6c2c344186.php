<h1>Подсветить HTML-теги в TRichEdit</h1>
<div class="date">01.01.2007</div>


<pre>
procedure HTMLSyntax(RichEdit: TRichEdit; TextCol,
  TagCol, DopCol: TColor); 
var  
  i, iDop: Integer; 
  s: string; 
  Col: TColor; 
  isTag, isDop: Boolean; 
begin 
  iDop := 0; 
  isDop := False; 
  isTag := False; 
  Col := TextCol; 
  RichEdit.SetFocus; 
 
  for i := 0 to Length(RichEdit.Text) do 
  begin 
    RichEdit.SelStart := i; 
    RichEdit.SelLength := 1; 
    s := RichEdit.SelText; 
 
    if (s = '&lt;') or (s = '{') then isTag := True; 
 
    if isTag then 
      if (s = '"') then 
        if not isDop then 
        begin 
          iDop  := 1; 
          isDop := True; 
        end  
        else 
          isDop := False; 
 
    if isTag then 
      if isDop then 
      begin 
        if iDop &lt;&gt; 1 then Col := DopCol; 
      end  
      else 
        Col := TagCol 
    else 
      Col := TextCol; 
 
    RichEdit.SelAttributes.Color := Col; 
 
    iDop := 0; 
 
    if (s = '&gt;') or (s = '}') then isTag := False; 
  end; 
 
  RichEdit.SelLength := 0; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  RichEdit1.Lines.BeginUpdate; 
  HTMLSyntax(RichEdit1, clBlue, clRed, clGreen); 
  RichEdit1.Lines.EndUpdate; 
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
