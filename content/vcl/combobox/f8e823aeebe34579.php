<h1>Как можно отменить реакию ComboBox на F4?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.ComboBox1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);

begin
if key=vk_F4 then key:=0;
end; 
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

