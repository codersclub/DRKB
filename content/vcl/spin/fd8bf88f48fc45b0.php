<h1>Отслеживаем позицию курсора в TEdit</h1>
<div class="date">01.01.2007</div>


<p>В форму добавляются TEditBox и TLabel, при этом TLabel постоянно показывает позицию курсора в элементе редактирования.</p>
<pre>
procedure TForm1.Edit1Change(Sender: TObject); 
begin 
  CurPos := Edit1.SelStart; 
  Label1.Caption := IntToStr(CurPos); 
end; 
 
procedure TForm1.Edit1KeyDown(Sender: TObject; var Key: Word; 
  Shift: TShiftState); 
begin 
  If Key = VK_LEFT then dec(CurPos); 
  if Key = VK_RIGHT then inc(CurPos);   
  Label1.Caption:= IntToStr(CurPos); 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

