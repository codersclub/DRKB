<h1>Растягивание иконки</h1>
<div class="date">01.01.2007</div>

StretchDraw не работает с иконками. В данной ситуации я бы поступил так: рисовал бы иконку в Timage и затем назначал изображение другому, большему Timage. </p>
<p>Пример кода:</p>
<pre>
procedure TForm1.StringGrid1Click(Sender: TObject);
begin
  Image1.Canvas.FillRect(Image1.Canvas.ClipRect);
  Image1.Canvas.Draw(0, 0,
  TIcon(StringGrid1.Objects
  [StringGrid1.Col, StringGrid1.Row]));
  Form2.Image1.Picture := Image1.Picture;
end;
{Примечание. Form2.Image1 имеет Stretch установленный
в True и размер, бОльший размера иконки в 4 раза}
</pre>
<p>Дополнение </p>
<p>Андрей Бреслав пишет: </p>
<p>предложенный способ не работает, ибо компонента TImage использует тот же метод StretchDraw, что и спрашивающий. Растянуть иконку можно так:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  Bmp: TBitMap;
begin
  Bmp:= TBitMap.Create;
  Bmp.Height:= GetSystemMetrics(SM_CYICON);
  Bmp.Width:= GetSystemMetrics(SM_CXICON);
  Bmp.Canvas.Draw(0,0, Image1.Picture.Icon);
  Image1.Picture.Bitmap:= Bmp;
  Bmp.Free;
end;
</pre>
<p>Есть более человечный способ, чем просто рисовать в Image: функция DrawIconEx Win32 API:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  DrawIconEx(Canvas.Handle, 5, 5, LoadIcon(0, IDI_APPLICATION),
    16, 32, 0, 0, DI_NORMAL);
end;
</pre>
<p>Кстати, думаю, людям будет полезно знать по подробнее о DrawIconEx: Рисует иконку или курсор в соответствии с заданными занчениями.</p>
<pre>
function DrawIconEx(hdc: HDC; xLeft, yTop: Integer; hIcon: HICON;
  cxWidth, cyWidth: Integer; istepIfAniCur: UINT;
  hbrFlickerFreeDraw: HBRUSH; diFlags: UINT): BOOL; stdcall;
</pre>
<p>hdc - контекст устройства (TCanvas.Handle)</p>
<p>  xLeft, yTop - координаты левого верхнего угла</p>
<p>  hIcon - дескриптор объекта Windows - Icon</p>
<p>  cxWidth, cyWidth - размеры</p>
<p>  istepIfAniCur - (!) номер отображаемого кадра в анимированном курсоре</p>
<p>  hbrFlickerFreeDraw - кисть</p>
<p>  diFlags - сумма след. занчений:</p>
<p>DI_COMPAT - буду благодарен, если объясните</p>
<p>DI_DEFAULTSIZE - если cxWidth, cyWidth равны 0, рисует в default размере</p>
<p>DI_IMAGE - применяет одну часть кисти</p>
<p>DI_MASK - применяет другую часть кисти</p>
<p>DI_NORMAL = DI_IMAGE and DI_MASK - применяет обе части кисти</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
