<h1>Как заставить TEdit не пикать при нажатии недопустимых клавиш?</h1>
<div class="date">01.01.2007</div>


<p>Перехватите событие KeyPress и установите key = #0 для недопустимых клавиш.</p>
<pre>
procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
begin
  if ((UpCase(Key) &lt; 'A') or (UpCase(Key) &gt; 'Z')) then Key := #0;
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
// Either disable the Beep in the OnKeyPress handler: 
 
procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
 begin
   if key = #13 then // #13 = Return 
  begin
     key := #0;
     // Code... 
  end;
 end;
 
 // Or in the OnKeyDown-Handler: 
 
procedure TForm1.Edit1KeyDown(Sender: TObject; var Key: Word;
   Shift: TShiftState);
 var
   Mgs: TMsg;
 begin
   if Key = VK_RETURN then
     PeekMessage(Mgs, 0, WM_CHAR, WM_CHAR, PM_REMOVE);
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

