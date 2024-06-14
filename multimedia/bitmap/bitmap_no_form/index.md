---
Title: Bitmap без формы
Author: Mike Scott
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Bitmap без формы
================

> Как мне загрузить изображение (BMP) и отобразить это на рабочем столе
> без использования формы? (Я хочу отображать это из DLL).

Существует один способ сделать это: создать холст TCanvas, получить
контекст устройства для рабочего стола и назначить его дескриптору
холста. После рисования на холсте десктоп отобразит ваше творение. Вот
пример:

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

Вы можете создать TBitmap и загрузить в него BMP-файл. Единственная
гнустная вещь может произойти, если вы используете изображение с
256-цветной палитрой при работе в режиме с 256 цветами. Обойти это
припятствие можно так: создать форму без границ и заголовка, установить
ее высоту и ширину в ноль, поместить на нее компонент TImage и загрузить
в него необходимое изображение. VCL реализует для вас нужную палитру.

