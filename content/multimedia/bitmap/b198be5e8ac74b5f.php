<h1>Bitmap без формы</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Mike Scott </div>
<p>Как мне загрузить изображение (BMP) и отобразить это на рабочем столе без использования формы? (Я хочу отображать это из DLL). </p>
<p>Существует один способ сделать это: создать холст TCanvas, получить контекст устройства для рабочего стола и назначить его дескриптору холста. После рисования на холсте десктоп отобразит ваше творение. Вот пример:</p>
<pre>
var
  DesktopCanvas: TCanvas;
begin
  DesktopCanvas := TCanvas.Create;
  try
    DesktopCanvas.Handle := GetDC(0);
    try
      DesktopCanvas.MoveTo(0, 0);
      DesktopCanvas.LineTo(Screen.Width, Screen.Height);
    finally
      ReleaseDC(0, DesktopCanvas.Handle);
      DesktopCanvas.Handle := 0;
    end;
  finally
    DesktopCanvas.Free;
  end;
end;
</pre>
<p>Вы можете создать TBitmap и загрузить в него BMP-файл. Единственная гнустная вещь может произойти, если вы используете изображение с 256-цветной палитрой при работе в режиме с 256 цветами. Обойти это припятствие можно так: создать форму без границ и заголовка, установить ее высоту и ширину в ноль, поместить на нее компонент TImage и загрузить в него необходимое изображение. VCL реализует для вас нужную палитру.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
