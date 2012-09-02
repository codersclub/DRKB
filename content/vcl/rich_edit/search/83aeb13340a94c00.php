<h1>TRichEdit &ndash; замена текста</h1>
<div class="date">01.01.2007</div>


<pre>
// This example doesn't use TReplaceDialog 
// Ohne Benutzung von TReplaceDialog 
 
function Search_And_Replace(RichEdit: TRichEdit; 
  SearchText, ReplaceText: string): Boolean; 
var 
  startpos, Position, endpos: integer; 
begin 
  startpos := 0; 
  with RichEdit do 
  begin 
    endpos := Length(RichEdit.Text); 
    Lines.BeginUpdate; 
    while FindText(SearchText, startpos, endpos, [stMatchCase])&lt;&gt;-1 do 
    begin 
      endpos   := Length(RichEdit.Text) - startpos; 
      Position := FindText(SearchText, startpos, endpos, [stMatchCase]); 
      Inc(startpos, Length(SearchText)); 
      SetFocus; 
      SelStart  := Position; 
      SelLength := Length(SearchText); 
      richedit.clearselection; 
      SelText := ReplaceText; 
    end; 
    Lines.EndUpdate; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Search_And_Replace(Richedit1, 'OldText', 'NewText'); 
end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
