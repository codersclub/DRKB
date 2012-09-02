<h1>Как поменять цвет фона в TRichEdit?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  RichEdit;
 
procedure RE_SetSelBgColor(RichEdit: TRichEdit; AColor: TColor);
var
  Format: CHARFORMAT2;
begin
  FillChar(Format, SizeOf(Format), 0);
  with Format do
  begin
    cbSize := SizeOf(Format);
    dwMask := CFM_BACKCOLOR;
    crBackColor := AColor;
    Richedit.Perform(EM_SETCHARFORMAT, SCF_SELECTION, Longint(@Format));
  end;
end;
 
// Example: Set clYellow background color for the selected text.
procedure TForm1.Button1Click(Sender: TObject);
begin
  RE_SetSelBgColor(RichEdit1, clYellow);
end;
</pre>
<p>взято с www.swissdelphicenter.ch</p>

