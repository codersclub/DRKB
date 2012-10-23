<h1>Как работать с GIF-файлами?</h1>
<div class="date">01.01.2007</div>

Этот код, делает следующее, загружаем в листбох список Gif файлов, затем это все дело обьединяетсяв один BMP файл,картинка к картинке, кто знает DirectX поймет для чего это надо (спрайты)</p>
<pre>
procedure TForm1.Button2Click(Sender: TObject);
begin
  if opendialog1.Execute then
  begin
    ListBox1.Items := opendialog1.Files;
    Edit2.Text := inttostr(ListBox1.Items.Count);
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  i, a: integer;
  bm: TBItmap;
begin
  a := 0;
  bm := TBItmap.Create;
  image1.Picture.LoadFromFile(listbox1.Items[0]);
  bm.Height := image1.Height;
  bm.Width := listbox1.Items.Count * image1.Picture.width;
  for i := 0 to listbox1.Items.Count - 1 do
  begin
    image1.Picture.LoadFromFile(listbox1.Items[i]);
    bm.Canvas.Draw(a, 0, image1.Picture.Graphic);
    a := a + image1.Picture.Height;
  end;
  //form1.Canvas.Draw(0,0,bm);
  bm.SaveToFile(Edit1.Text + '.bmp');
  bm.free;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
&nbsp;</p>
<p>из файловов GIF (анимированных) вытаскивает каждую картинку в отдельности, или записывает в отдельный BMP по очереди Для этих программок нужен всеми любимый RX Lib !!!</p>
<pre>
procedure TForm1.Button4Click(Sender: TObject);
var
  i, a: integer;
  bm: TBItmap;
begin
  a := 0;
  bm := TBItmap.Create;
  bm.Height := RxGIFAnimator1.Height;
  bm.Width := RxGIFAnimator1.Image.Count * RxGIFAnimator1.width;
  for i := 0 to RxGIFAnimator1.Image.Count - 1 do
  begin
    RxGIFAnimator1.FrameIndex := i;
    bm.Canvas.Draw(a, 0, RxGIFAnimator1.Image.Frames[i].Bitmap);
    a := a + RxGIFAnimator1.Height;
  end;
  //form1.Canvas.Draw(0,0,bm);
  bm.SaveToFile(Edit1.Text + '.bmp');
  bm.free;
end;
</pre>
<div class="author">Автор: МММ</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

