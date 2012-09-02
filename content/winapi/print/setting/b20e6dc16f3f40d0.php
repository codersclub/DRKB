<h1>Определение параметров принтера через API</h1>
<div class="date">01.01.2007</div>


<p>Для определения информации о принтере (плоттере, экране) необходимо знать Handle этого принтера, а его можно узнать объекта TPrinter - Printer.Handle. Далее вызывается функция API (unit WinProcs) : </p>

<p>GetDevice(Handle:HDC; Index:integer):integer;</p>

<p>Index - код параметра, который необходимо вернуть. Для Index существует ряд констант : </p>

<p>DriverVersion - вернуть версию драйвера </p>
<p>Texnology - Технология вывода, их много, основные </p>
<p>dt_Plotter - плоттер </p>
<p>dt_RasPrinter - растровый принтер </p>
<p>dt_Display - дисплей </p>
<p>HorzSize - Горизонтальный размер листа (в мм) </p>
<p>VertSize - Вертикальный размер листа (в мм) </p>
<p>HorzRes - Горизонтальный размер листа (в пикселах) </p>
<p>VertRes - Вертикальный размер листа (в пикселах) </p>
<p>LogPixelX - Разрешение по оси Х в dpi (пиксел /дюйм) </p>
<p>LogPixelY - Разрешение по оси Y в dpi (пиксел /дюйм) </p>
<p>Кроме перечисленных еще около сотни, они позволяют узнать о принтере практически все. </p>

<p>Параметры, возвращаемые по LogPixelX и LogPixelY очень важны - они позволяют произвести пересчет координат из миллиметров в пиксели для текущего разрешения принтера. Пример таких функций: </p>

<pre>
{ Получить информацию о принтере }
Procedure TForm1.GetPrinterInfo;
begin
  PixelsX:=GetDeviceCaps(printer.Handle,LogPixelsX);
  PixelsY:=GetDeviceCaps(printer.Handle,LogPixelsY);
end;
 
{ переводит координаты из мм в пиксели }
Function TForm1.PrinterCoordX(x:integer):integer;
begin
 PrinterCoordX:=round(PixelsX/25.4*x);
end;
 
{ переводит координаты из мм в пиксели }
Function TForm1.PrinterCoordY(Y:integer):integer;
begin
 PrinterCoordY:=round(PixelsY/25.4*Y);
end;
 
...
 
GetPrinterInfo;
Printer.Canvas.TextOut(PrinterCoordX(30), PrinterCoordY(55),
 'Этот текст печатается с отступом 30 мм от левого края и '+
 '55 мм от верха при любом разрешении принтера');
</pre>




<p>Данную методику можно с успехом применять для печати картинок - зная размер картинки можно пересчитать ее размеры в пикселах для текущего разрешения принтера, масштабировать, и затем уже распечатать. Иначе на матричном принтере (180 dpi) картинка будет огромной, а на качественном струйнике (720 dpi) - микроскопической. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
