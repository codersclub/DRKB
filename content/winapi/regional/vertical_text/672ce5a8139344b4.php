<h1>Как сделать фон у текста прозрачным?</h1>
<div class="date">01.01.2007</div>


<p>Для этого можно воспользоваться API функцией SetBkMode().</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  OldBkMode : integer;
begin
  with Form1.Canvas do begin
    Brush.Color := clRed;
    FillRect(Rect(0, 0, 100, 100));
    Brush.Color := clBlue;
    TextOut(10, 20, 'Not Transparent!');
    OldBkMode := SetBkMode(Handle, TRANSPARENT);
    TextOut(10, 50, 'Transparent!');
    SetBkMode(Handle, OldBkMode);
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

