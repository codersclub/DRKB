---
Title: Определение параметров принтера через API
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Определение параметров принтера через API
=========================================

Для определения информации о принтере (плоттере, экране) необходимо
знать Handle этого принтера, а его можно узнать объекта TPrinter -
Printer.Handle. Далее вызывается функция API (unit WinProcs):

    GetDevice(Handle:HDC; Index:integer):integer;

Index - код параметра, который необходимо вернуть.
Для Index существует ряд констант:

- DriverVersion - вернуть версию драйвера

- Texnology - Технология вывода, их много, основные

    * dt\_Plotter - плоттер
    * dt\_RasPrinter - растровый принтер
    * dt\_Display - дисплей

- HorzSize - Горизонтальный размер листа (в мм)

- VertSize - Вертикальный размер листа (в мм)

- HorzRes - Горизонтальный размер листа (в пикселах)

- VertRes - Вертикальный размер листа (в пикселах)

- LogPixelX - Разрешение по оси Х в dpi (пиксел /дюйм)

- LogPixelY - Разрешение по оси Y в dpi (пиксел /дюйм)

Кроме перечисленных еще около сотни, они позволяют узнать о принтере
практически все.

Параметры, возвращаемые по LogPixelX и LogPixelY очень важны - они
позволяют произвести пересчет координат из миллиметров в пиксели для
текущего разрешения принтера. Пример таких функций:

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

Данную методику можно с успехом применять для печати картинок - зная
размер картинки можно пересчитать ее размеры в пикселах для текущего
разрешения принтера, масштабировать, и затем уже распечатать. Иначе на
матричном принтере (180 dpi) картинка будет огромной, а на качественном
струйнике (720 dpi) - микроскопической.

