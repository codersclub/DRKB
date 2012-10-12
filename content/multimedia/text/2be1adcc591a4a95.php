<h1>Как вывести полупрозрачный текст</h1>
<div class="date">01.01.2007</div>


<p>Пример вывода полупрозрачного текста.</p>
<pre>
procedure TForm1.FormPaint(Sender: TObject);
var
  x, y: integer;
  bm: TBitMap;
begin
  Form1.ClientWidth := 200;
  Form1.ClientHeight := 100;
  randomize;
  for x := 0 to 199 do
    for y := 0 to 99 do
      if random(3) = 1
        then Form1.Canvas.Pixels[x,y] := clGreen
        else Form1.Canvas.Pixels[x,y] := clLime;
  bm := TBitMap.Create;
  bm.Width := 200;
 
  bm.Height := 100;
  with bm.Canvas do begin
    Brush.Color := clGreen;
    FillRect(ClipRect);
    Font.Name := 'Arial';
    Font.Size := 50;
    Font.Color := clGray;
    Font.Style := [fsBold];
    TextOut((bm.Width - TextWidth('Text')) div 2,
      (bm.Height - TextHeight('Text')) div 2, 'Text');
  end;
  Form1.Canvas.CopyMode := cmSrcPaint;
  Form1.Canvas.CopyRect(bm.Canvas.ClipRect, bm.Canvas,
    bm.Canvas.ClipRect);
 
  bm.Destroy;
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p>Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>

