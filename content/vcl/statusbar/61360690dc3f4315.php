<h1>OwnerDraw в компоненте TStatusBar</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.StatusBar1DrawPanel(StatusBar: TStatusBar;
Panel: TStatusPanel; const Rect: TRect);
begin
  with statusbar1.Canvas do
  begin
    Brush.Color := clRed;
    FillRect(Rect);
    TextOut(Rect.Left, Rect.Top, 'Панель '+IntToStr(Panel.Index));
  end;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
