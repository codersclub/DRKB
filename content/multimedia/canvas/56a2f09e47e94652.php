<h1>Перемещать объект на сложном фоне</h1>
<div class="date">01.01.2007</div>


<p>Написать графический редактор, как Paint Brush, в Delphi очень просто. Но встает одна проблема. Чтобы нарисовать линию, пользователь нажимает мышью на поле, двигает ее, и отпускает кнопку. Во время движения мыши линия все время перерисовывается. Причем фон, после того, как линия переместилась, должен восстановиться. Для этого можно использовать логическую операцию XOR. Важное свойство этой операции заключается в том, что при любых A и B, A XOR B XOR B = A. Это означает, что если воспользоваться этой операцией для рисования линии, то при повторном ее рисовании на этом месте этим же цветом она сотрется, оставив за собой прежний фон. </p>

<pre>
procedure TForm1.XORLine;
begin
  Form1.Canvas.MoveTo(xo, yo);
  Form1.Canvas.LineTo(lx, ly);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Form1.Color := clWhite;
  Form1.Canvas.Pen.Color := clRed;
  Form1.Canvas.Pen.Width := 3;
end;
 
procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
Shift: TShiftState; X, Y: Integer);
begin
  Form1.Tag := 1;
  xo := X;
  yo := Y;
  lx := X;
  ly := Y;
  Form1.Canvas.Pen.Mode := pmNotXor;
  XORLine;
end;
 
procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
Y: Integer);
begin
  if ssLeft in Shift then
  begin
    XORLine;
    lx := X;
    ly := Y;
    XORLine;
  end;
end;
 
procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
Shift: TShiftState; X, Y: Integer);
begin
  Form1.Canvas.Pen.Mode := pmCopy;
  Form1.Canvas.MoveTo(xo, yo);
  Form1.Canvas.LineTo(X, Y);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
