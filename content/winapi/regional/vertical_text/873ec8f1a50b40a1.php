<h1>Вертикальный текст</h1>
<div class="date">01.01.2007</div>



<pre>
var
  Hfont: Thandle;
  logfont: TLogFont;
  font: Thandle;
  count: integer;
begin
  LogFont.lfheight := 30;
  logfont.lfwidth := 10;
  logfont.lfweight := 900;
  LogFont.lfEscapement := -200;
  logfont.lfcharset := 1;
  logfont.lfoutprecision := out_tt_precis;
  logfont.lfquality := draft_quality;
  logfont.lfpitchandfamily := FF_Modern;
  font := createfontindirect(logfont);
  Selectobject(Form1.canvas.handle, font);
  SetTextColor(Form1.canvas.handle, rgb(0, 0, 200));
  SetBKmode(Form1.canvas.handle, transparent);
  {textout(form1.canvas.handle,10,10,'Повернутый',7);}
  for count := 1 to 100 do
  begin
    canvas.textout(Random(form1.width), Random(form1.height), 'Повернутый');
    SetTextColor(form1.canvas.handle, rgb(Random(255), Random(255),
      Random(255)));
  end;
  deleteobject(font);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
