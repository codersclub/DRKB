---
Title: Копирование содержимого экрана на форму
Date: 01.01.2007
---


Копирование содержимого экрана на форму
=======================================

::: {.date}
01.01.2007
:::

    var
      Image3: TImage;
     
    procedure TSaverForm.CopyScreen;
    var
     
      DeskTopDC: HDc;
      DeskTopCanvas: TCanvas;
      DeskTopRect: TRect;
    begin
     
      Image3 := TImage.Create(SaverForm);
      with Image3 do
      begin
        Height := Screen.Height;
        Width := Screen.Width;
      end;
      Image3.Canvas.copymode := cmSrcCopy;
      DeskTopDC := GetWindowDC(GetDeskTopWindow);
      DeskTopCanvas := TCanvas.Create;
      DeskTopCanvas.Handle := DeskTopDC;
      Image3.Canvas.CopyRect(Image3.Canvas.ClipRect, DeskTopCanvas,
        DeskTopCanvas.ClipRect);
      Image2.Picture.Assign(Image3.Picture);
      {image2 расположен на целевой форме и выровнен по области клиента}
    end;
     
    procedure TSaverForm.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
     
      Image3.Free;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Попробуйте следующий HAX 244, взятый из Авг/Сен номера журнала Visual
Developer. Это работает, и работает хорошо.

    { смотри текстовое описание за последним END. }
    unit Scrncap;
     
    interface
    uses WinTypes, WinProcs, Forms, Classes, Graphics;
     
    function CaptureScreenRect(ARect: TRect): TBitmap;
    function CaptureScreen: TBitmap;
    function CaptureClientImage(Control: TControl): TBitmap;
    function CaptureControlImage(Control: TControl): TBitmap;
     
    implementation
     
    { используем следующий код для захвата прямоугольной области экрана }
     
    function CaptureScreenRect(ARect: TRect): TBitmap;
    var
      ScreenDC: HDC;
    begin
     
      Result := TBitmap.Create;
      with Result, ARect do
      begin
        Width := Right - Left;
        Height := Bottom - Top;
     
        ScreenDC := GetDC(0);
        try
          BitBlt(Canvas.Handle, 0, 0, Width, Height,
            ScreenDC, Left, Top, SRCCOPY);
        finally
          ReleaseDC(0, ScreenDC);
        end;
      end;
    end;
     
    { используем следующий код для захвата целого экрана }
     
    function CaptureScreen: TBitmap;
    begin
     
      with Screen do
        Result := CaptureScreenRect(Rect(0, 0, Width, Height));
    end;
     
    { используем следующий код для захвата клиентской области
    формы или элемента управления...}
     
    function CaptureClientImage(Control: TControl): TBitmap;
    begin
     
      with Control, Control.ClientOrigin do
        Result := CaptureScreenRect(Bounds(X, Y, ClientWidth,
     
          ClientHeight));
    end;
     
    { используйте следующий код для захвата целой формы
    или элемента управления  }
     
    function CaptureControlImage(Control: TControl): TBitmap;
    begin
     
      with Control do
        if Parent = nil then
          Result := CaptureScreenRect(Bounds(Left, Top, Width,
            Height))
        else
          with Parent.ClientToScreen(Point(Left, Top)) do
            Result := CaptureScreenRect(Bounds(X, Y, Width, Height));
    end;
     
    end.
     
    {
    Источник:  Visual Developer, HAX #244, Авг/Сент 1996
     
    захват экрана с помощью Delphi
     
    В Delphi, если вы хотите получить изображение клиентской области формы,
    необходимо вызвать GetFormlmage. Но иногда возникает необходимость
    получения снимка формы целиком, вместе с заголовком, контуром и всем
    содержимым. Или целиком всего экрана. Если бы у вас был дефицит времени,
    мы бы в этом случае посоветовали показывать диалоговое окно с надписью
    "Теперь нажмите кнопку Print Screen!", после чего работать с
    изображением, помещенным в буфер обмена.
     
    Но мы никуда не спешим. Комбинирование хостов Delphi с несколькими
    функциями GDI сводят задачу получения снимка экрана всего к одной
    строчке кода.
     
    CaptureScreenRect, в листинге 1, демонстрирует это. Код получает
    экранный контекст устройства с помощью GetDC(O), и затем копирует
    прямоугольную область этого DC на холст изображения (Bitmap). Для
    копирования используется BitBlt. Смысл использования BitBlt (и
    любой функции GDI) в том, что Delphi помнит, что дескриптор холста
    есть DC, необходимый Windows.
     
    Остальные функции копирования экрана в листинге 1 захватывают
    прямоугольник и отдает реальную работу на откуп CaptureScreenRect.
    CaptureScreen захватывает для прямоугольника целый экран.
    CaptureClientImage и CaptureControlImage захватывают прямоугольник
    области клиента и элемента управления, соответственно.
     
    Эти четыре функции могут быть использованы для захвата любой
    произвольной области экрана, а также экранных областей форм,
    кнопок, полей редактирования, ComboBox'ов и пр.. Не забывайте
    после работы освобождать используемые вами картинки (Bitmap). }
