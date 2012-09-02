<h1>TRichEdit &ndash; поиск текста</h1>
<div class="date">01.01.2007</div>


<pre>
function SearchForText_AndSelect(RichEdit: TRichEdit; SearchText: string): Boolean; 
var 
  StartPos, Position, Endpos: Integer; 
begin 
  StartPos := 0; 
  with RichEdit do 
  begin 
    Endpos := Length(RichEdit.Text); 
    Lines.BeginUpdate; 
    while FindText(SearchText, StartPos, Endpos, [stMatchCase])&lt;&gt;-1 do 
    begin 
      Endpos   := Length(RichEdit.Text) - startpos; 
      Position := FindText(SearchText, StartPos, Endpos, [stMatchCase]); 
      Inc(StartPos, Length(SearchText)); 
      SetFocus; 
      SelStart  := Position; 
      SelLength := Length(SearchText); 
    end; 
    Lines.EndUpdate; 
  end; 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SearchForText_AndSelect(RichEdit1, 'Some Text'); 
end;
 
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
