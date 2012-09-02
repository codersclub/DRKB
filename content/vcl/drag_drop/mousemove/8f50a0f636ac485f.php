<h1>Как таскать форму за метку?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Label1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
  const SC_DragMove = $F012; { a magic number }

 
begin
  ReleaseCapture;
  Form1.perform(WM_SysCommand, SC_DragMove, 0);
end;
</pre>

<p class="author">Автор ответа: TAPAKAH</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

