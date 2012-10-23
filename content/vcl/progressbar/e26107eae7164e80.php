<h1>Вставить TProgressBar в TStatusBar</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  with ProgressBar1 do
  begin
    Parent := StatusBar1;
    Position := 100;
    Top := 2;
    Left := 0;
    Height := StatusBar1.Height - Top;
    Width := StatusBar1.Panels[0].Width - Left;
  end;
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<p>pgProgress положить на форму как Visible := false;</p>
<p>StatusPanel надо OwnerDraw сделать и pефpешить, если Position меняется.</p>
<pre>
procedure TMainForm.stStatusBarDrawPanel(StatusBar: TStatusBar;
Panel: TStatusPanel; const Rect: TRect);
begin
  if Panel.index = pnProgress then
  begin
    pgProgress.BoundsRect := Rect;
    pgProgress.PaintTo(stStatusBar.Canvas.Handle, Rect.Left, Rect.Top);
  end;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
