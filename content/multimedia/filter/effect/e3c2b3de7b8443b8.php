<h1>Эффект плавного перехода</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: David C. Ullrich </div>
<p>...существует ли для этого эффекта какой-либо алгоритм генерации изображений вместо использования кисточки? </p>

<p>Я был скептически настроен к механизму использования кистей, чтобы получить что-либо похожее на эффект перехода/ухода ("fade") по сравнению со стеркой ("wipe"), но вчера вечером я нашел следующее решение, которое делает невероятное - осуществляет плавный переход от одного изображения к другому:</p>

<pre>
procedure WaitAWhile(n: longint);
var
  StartTime: longint;
begin
  StartTime := timeGetTime;
  while timeGetTime &lt; StartTime + n do
    ;
end;
 
procedure TForm1.Image1Click(Sender: TObject);
var
  BrushBmp, BufferBmp, Buffer2Bmp, ImageBmp, Image2Bmp: TBitmap;
  j, k, row, col: longint;
begin
  row := 0;
  col := 0;
  BrushBmp := TBitmap.Create;
  with BrushBmp do
  begin
    Monochrome := false;
    Width := 8;
    Height := 8;
  end;
  imageBmp := TBitmap.create;
  imagebmp.loadfromfile('c:\huh.bmp');
  image2bmp := TBitmap.Create;
  image2bmp.LoadFromFile('c:\whatsis.bmp');
  {При 256 цветах лучше иметь ту же самую палитру!}
  BufferBmp := TBitmap.Create;
  with BufferBmp do
  begin
    Height := 200;
    Width := 200;
    canvas.brush.bitmap := TBitmap.Create;
  end;
  Buffer2Bmp := TBitmap.Create;
  with Buffer2Bmp do
  begin
    Height := 200;
    Width := 200;
    canvas.brush.bitmap := TBitmap.Create;
  end;
  for k := 1 to 16 do
  begin
    WaitAWhile(0); {Для пентиума необходимо добавить задержку}
    for j := 0 to 3 do
    begin
      row := (row + 5) mod 8;
      col := (col + 1) mod 8;
      if row = 0 then
        col := (col + 1) mod 8;
      BrushBmp.canvas.Pixels[row, col] := clBlack;
    end;
    with BufferBmp do
    begin
      canvas.copymode := cmSrcCopy;
      canvas.brush.bitmap.free;
      canvas.brush.style := bsClear;
      canvas.brush.bitmap := TBitmap.Create;
      canvas.brush.bitmap.Assign(BrushBmp);
      canvas.Rectangle(0, 0, 200, 200);
      canvas.CopyMode := cmMergeCopy;
      canvas.copyrect(rect(0, 0, 200, 200), imageBmp.canvas,
        rect(0, 0, 200, 200));
    end;
    with Buffer2Bmp do
    begin
      canvas.copymode := cmSrcCopy;
      canvas.brush.bitmap.free;
      canvas.brush.style := bsClear;
      canvas.brush.bitmap := TBitmap.Create;
      canvas.brush.bitmap.Assign(BrushBmp);
      canvas.Rectangle(0, 0, 200, 200);
      canvas.copymode := cmSrcErase;
      canvas.copyrect(rect(0, 0, 200, 200), image2bmp.canvas,
        rect(0, 0, 200, 200));
    end;
    BufferBmp.Canvas.CopyMode := cmSrcPaint;
    BufferBmp.Canvas.Copyrect(rect(0, 0, 200, 200),
      Buffer2Bmp.Canvas, rect(0, 0, 200, 200));
    canvas.copymode := cmSrcCopy;
    canvas.copyrect(rect(0, 0, 200, 200), BufferBmp.Canvas,
      rect(0, 0, 200, 200));
  end;
 
  BufferBmp.canvas.brush.bitmap.free;
  Buffer2Bmp.canvas.brush.bitmap.free;
  BrushBmp.Free;
  BufferBmp.Free;
  Buffer2Bmp.Free;
  ImageBmp.Free;
  image2Bmp.Free;
end;
</pre>




<p>Комментарии: На Pentium I я реально использую 64 кисточки, изменив приведенные выше строки на следующие:</p>

<pre>
for k:= 1 to 64 do
begin
  WaitAWhile(50);
  for j:=0 to 0 do
</pre>




<p>При организации указанной задержки возможно получение плавного перехода. </p>

<p>Заполняя кисть в другом порядке, вы можете получить ряд других эффектов, но приведенная выше версия единственная, которую мне удалось получить максимально похожей на эффект перехода, но вы можете, скажем, написать:</p>

<pre>
begin
  row:=(row+1) mod 8;
  (*col:=(col+1) mod 8;*)
  if row=0 then
    col:=(col+1) mod 8;
</pre>




<p>и получить своего рода эффект перехода типа "venetian-blind wipe" (дословно - стерка венецианского хрусталя). </p>

<p>Вопрос: Я чуствую, что я делаю что-то неправильно, существует какая-то хитрость с кистью. Мне нужно все четыре строчки:</p>

<pre>
canvas.brush.bitmap.free;
canvas.brush.style:=bsClear;
canvas.brush.bitmap:=TBitmap.Create;
canvas.brush.bitmap.Assign(BrushBmp);
</pre>




<p>чтобы все работало правильно; но я совсем не понимаю, почему первые три строки являются обязательными, но если я их выкидываю, Assign сработывает только один раз(!?!?!). Это реально работает? Есть способ другого быстрого назначения brush.bitmaps? (В документации в качестве примера указано на Brush.Bitmap.LoadFromFile, но должно быть лучшее решение. Хорошо, допустим приведенный способ лучший, но он кажется неправильным...)</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
