---
Title: Как создать лупу для рабочего стола?
Author: Zarko Gajic
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как создать лупу для рабочего стола?
====================================

    // переменные
    var Srect,Drect,PosForme:TRect;
        iWidth,iHeight,DmX,DmY:Integer;
        iTmpX,iTmpY:Real;
        C:TCanvas;
        Kursor:TPoint;
    // Увеличиваем экран, если приложение не свёрнуто в иконку
    If not IsIconic(Application.Handle) then begin
      // Получаем координаты курсора
      GetCursorPos(Kursor);
     
      // PosForm представляет прямоугольник с
      // координатами Form (image control).
      PosForme:=Rect(Form1.Left,
                     Form1.Top,
                     Form1.Left+Form1.Width,
                     Form1.Top+Form1.Height);
     
      //Показываем magnified screen 
      //если курсор за пределами формы.
      If not PtInRect(PosForme,Kursor) then begin
     
      // Далее код можно использовать для увеличения выбранной
      // части экрана. С небольшими модификациями его можно
      // использовать для уменьшения
      // экрана
      iWidth:=Image1.Width;
      iHeight:=Image1.Height;
      Drect:=Bounds(0,0,iWidth,iHeight);
      iTmpX:=iWidth / (Slider.Position * 4);
      iTmpY:=iHeight / (Slider.Position * 4);
      Srect:=Rect(Kursor.x,Kursor.y,Kursor.x,Kursor.y);
      InflateRect(Srect,Round(iTmpX),Round(iTmpY));
     
      //Получаем обработчик(handle) окна рабочего стола.
      C:=TCanvas.Create;
      try
       C.Handle:=GetDC(GetDesktopWindow);
       //Передаём часть изображения окна в TImage.
       Image1.Canvas.CopyRect(Drect,C,Srect);
      finally
       C.Free;
      end;
     
    end;
     
    // Обязательно обрабатываем все сообщения Windows.
    Application.ProcessMessages;
     
    end; // IsIconic

