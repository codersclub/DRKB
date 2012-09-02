<h1>Как поместить битмап в метафайл?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует рисование битмапа в метафайле.</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  m : TmetaFile;
  mc : TmetaFileCanvas;
  b : tbitmap;
begin
  m := TMetaFile.Create;
  b := TBitmap.create;
  b.LoadFromFile('C:\SomePath\SomeBitmap.BMP');
  m.Height := b.Height;
  m.Width := b.Width;
  mc := TMetafileCanvas.Create(m, 0);
  mc.Draw(0, 0, b);
  mc.Free;
  b.Free;
  m.SaveToFile('C:\SomePath\Test.emf');
  m.Free;
  Image1.Picture.LoadFromFile('C:\SomePath\Test.emf');
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

