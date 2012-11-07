<h1>Выделить строку в TMemo</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TfrmMain.Memo1Click(Sender: TObject); 
var 
  Line: Integer; 
begin 
  with (Sender as TMemo) do 
  begin 
    Line      := Perform(EM_LINEFROMCHAR, SelStart, 0); 
    SelStart  := Perform(EM_LINEINDEX, Line, 0); 
    SelLength := Length(Lines[Line]); 
  end; 
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
</p>
