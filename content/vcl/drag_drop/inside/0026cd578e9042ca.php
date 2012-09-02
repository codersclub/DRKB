<h1>Как перетаскивать компоненты в runtime?</h1>
<div class="date">01.01.2007</div>


<p>Возьмите форму, бросьте на нее панель, на onMouseDown панели прицепите код:</p>
<pre>
procedure TForm1.Panel1MouseDown(Sender: TObject; Button: TMouseButton;
Shift: TShiftState; X, Y: Integer);

begin
  ReleaseCapture;
  Panel1.Perform(WM_SYSCOMMAND, $F012, 0);
end;
</pre>
<p>Теперь в run-time панель можно таскать как в дизайне...</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
