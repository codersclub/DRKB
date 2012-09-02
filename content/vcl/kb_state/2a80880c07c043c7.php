<h1>Как работать с ssShift и TShiftState?</h1>
<div class="date">01.01.2007</div>


<p>ssShift - это константа применяемая в типе TShiftState (являущемся типом Set) а не логическая, надо примерно так:</p>
<pre>
procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);

begin
  if (key=$97) and (ssShift in Shift) then
  begin
  {do something}
  end;
end;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

