<h1>Как вставить растровое изображение в компонент TListBox?</h1>
<div class="date">01.01.2007</div>


<p>Для этого необходимо установить в инспекторе объектов поле Style в lbOwnerDrawFixed, при фиксированной высоте строки, или в lbOwnerDrawVariable, при переменной, и установить собственный обработчик события для OnDrawItem. В этом обработчике и надо рисовать растровое изображение.</p>
<p>Пример:</p>
<p>Рисуются изображения размером 32*16 (размер стандартного глифа для Delphi). Очень полезно при поиске нужного изображения для кнопок!</p>
<p>Установить в инспекторе объектов для ListBox поле ItemHeight = 19, а поле Color = clBtnFace.</p>

<pre>
{ Загрузить список файлов в ListBox1 при нажатии на кнопку Load (например)}
procedure TForm1.bLoadClick(Sender: TObject);
VAR S : String; 
begin 
  ListBox1.Clear; {чистим список}
  S := '*.bmp'#0; {задаем шаблон}
  ListBox1.Perform(LB_DIR, DDL_ReadWrite, Longint(@S[1])); {заполняем список} 
end; 
          ............ 
 
{Отобразить изображения и имена файлов в ListBox}
procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer;
  Rect: TRect; State: DrawState);
var
  Bitmap: TBitmap;
  Offset: Integer;
  BMPRect: TRect;
begin
  with (Control as TListBox).Canvas do
    begin
      FillRect(Rect);
      Bitmap := TBitmap.Create;
      Bitmap.LoadFromFile(ListBox1.Items[Index]);
      Offset := 0;
      if Bitmap &lt;&gt; nil then
        begin
          BMPRect := Bounds(Rect.Left + 2, Rect.Top + 2,
            (Rect.Bottom - Rect.Top - 2) * 2, Rect.Bottom - Rect.Top - 2);
      {StretchDraw(BMPRect, Bitmap); Можно просто нарисовать, но лучше сначала убрать фон}
          BrushCopy(BMPRect, Bitmap, Bounds(0, 0, Bitmap.Width, Bitmap.Height),
            Bitmap.Canvas.Pixels[0, Bitmap.Height - 1]);
          Offset := (Rect.Bottom - Rect.Top + 1) * 2;
        end;
      TextOut(Rect.Left + Offset, Rect.Top, ListBox1.Items[Index]);
      Bitmap.Free;
    end;
end;
</pre>


<p>Данный пример работает медленно, но оптимизация, для ускорения, вызвала бы трудность в понимании общего принципа его работы.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />Сначала создайте bmp-файл, который вы будете помещать около каждого элемента списка, в примере это 'c:\file.bmp'. Для создания файла можете воспользоваться специальной графической утилитой ImageEditor, которая входит в пакет Delphi. Желательно, чтобы размер файлы был 16х16. После этого вынесите на форму компонент TListBox. Его свойство Style установите в lbOwnerDrawVariable - это позволит нам прорисовывать каждый элемент списка самостоятельно.</p>

<p>Далее объявляем переменную:</p>


<p>var</p>
<p>  Bit: TBitmap;</p>


<p>После этого задаём обработчику события OnDrawItem следующий вид:</p>

<pre>
procedure TForm1.ListBox1DrawItem(Control: TWinControl; index: Integer;
Rect: TRect; State: TOwnerDrawState);
var
  cc: TCanvas;
begin
  cc:=(Control as TListBox).Canvas;
  cc.FillRect(rect);
  cc.Draw(Rect.Left+Rect.Right-16,Rect.Top,Bit);
  cc.TextOut(Rect.Left,Rect.Top,ListBox1.Items[index]);
end;
</pre>




<p>а обработчику события OnMeasureItem такой:</p>

<pre>
procedure TForm1.ListBox1MeasureItem(Control: TWinControl;
index: Integer; var Height: Integer);
begin
  Height := 16;
end;
</pre>



<p>По созданию окна создаёт Bitmap и загружаем в него данные из файла:</p>

<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  Bit := TBitmap.Create;
  Bit.LoadFromFile('c:\file.bmp');
end;
</pre>



<p>По уничтожению окна - уничтожаем Bitmap</p>

<pre>
procedure TForm1.FormDestroy(Sender: TObject);
begin
  Bit.Destroy;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

