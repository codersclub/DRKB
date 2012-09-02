<h1>Как защитить запись в TDBGrid от удаления?</h1>
<div class="date">01.01.2007</div>


<p>Поместите следующий код в событие OnKeyDown в DBGrid.</p>
<pre>
procedure TForm1.DBGrid1KeyDown(Sender: TObject; var Key: Word; 
  Shift: TShiftState); 
begin 
  if (ssctrl in shift) and (key=vk_delete) then key:=0; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

