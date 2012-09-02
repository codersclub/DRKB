<h1>Как TListView перевести в режим редактирования по нажатию на F2</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.ListView1KeyDown(Sender: TObject;
  var Key: Word; Shift: TShiftState);
begin
  if Ord(Key) = VK_F2 then
    ListView1.Selected.EditCaption;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
