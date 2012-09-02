<h1>Печать повернутого текста</h1>
<div class="date">01.01.2007</div>


<pre>
procedure AngleTextOut(CV: TCanvas; const sText: string; x, y, angle: integer);
var
  LogFont: TLogFont;
  SaveFont: TFont;
begin
  SaveFont := TFont.Create;
  SaveFont.Assign(CV.Font);
  GetObject(SaveFont.Handle, sizeof(TLogFont), @LogFont);
  with LogFont do
    begin
      lfEscapement := angle * 10;
      lfPitchAndFamily := FIXED_PITCH or FF_DONTCARE;
    end; {with}
  CV.Font.Handle := CreateFontIndirect(LogFont);
  SetBkMode(CV.Handle, TRANSPARENT);
  CV.TextOut(x, y, sText);
  CV.Font.Assign(SaveFont);
  SaveFont.Free;
end;
</pre>


<hr />

<pre>
procedure TextOutVertical(var bitmap: TBitmap; x, y: Integer; s: string);
var b1, b2: TBitmap;
  i, j: Integer;
begin
  with bitmap.Canvas do
    begin
      b1 := TBitmap.Create;
      b1.Canvas.Font := lpYhFont;
      b1.Width := TextWidth(s) + 1;
      b1.Height := TextHeight(s) + 1;
      b1.Canvas.TextOut(1, 1, s);
      b2 := TPackedBitmap.Create;
      b2.Width := TextHeight(s);
      b2.Height := TextWidth(s);
      for i := 0 to b1.Width - 1 do
        for j := 0 to b1.Height do
          b2.Canvas.Pixels[j, b2.Height + 1 - i] := b1.Canvas.Pixels[i, j];
      Draw(x, y, b2);
      b1.Free;
      b2.Free;
    end
end;
</pre>

<hr />
<p>Некоторое время я делал так: я создавал шрифт, выбирал его в DC...</p>
<pre>
function CreateMyFont(degree: Integer): HFONT;
begin
  CreateMyFont := CreateFont(
    -30, 0, degree, 0, 0,
    0, 0, 0, 1, OUT_TT_PRECIS,
    0, 0, 0, szFontName);
end;
</pre>


<p>....и затем использовал любую функцию рисования для вывода текста.</p>

<hr />
<p>Приведенное выше решение(1)очень медленно, так как требует рисования текста и содержит, на мой взгляд, неэффективный метод вращения.Попробуйте взамен это:</p>

<pre>
procedure TForm1.TextUp(aRect: tRect; aTxt: string);
var LFont: TLogFont;
  hOldFont, hNewFont: HFont;
begin
  GetObject(Canvas.Font.Handle, SizeOf(LFont), Addr(LFont));
  LFont.lfEscapement := 900;
  hNewFont := CreateFontIndirect(LFont);
  hOldFont := SelectObject(Canvas.Handle, hNewFont);
  Canvas.TextOut(aRect.Left + 2, aRect.Top, aTxt);
  hNewFont := SelectObject(Canvas.Handle, hOldFont);
  DeleteObject(hNewFont);
end;
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

