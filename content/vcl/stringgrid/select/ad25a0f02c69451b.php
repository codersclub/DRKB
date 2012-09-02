<h1>Сменить цвет выделения в TStringGrid</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer; 
  Rect: TRect; State: TGridDrawState); 
const 
  SelectedColor = Clblue; 
begin 
  if (state = [gdSelected]) then 
    with TStringGrid(Sender), Canvas do 
    begin 
      Brush.Color := SelectedColor; 
      FillRect(Rect); 
      TextRect(Rect, Rect.Left + 2, Rect.Top + 2, Cells[aCol, aRow]); 
    end; 
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
