---
Title: Программно нажимаем Print Screen
Author: Simon Carter
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Программно нажимаем Print Screen
================================

Совместимость: Delphi 3.x (или выше)

Приведённая здесь функция делает копию изображения экрана и сохраняет её
в буфере обмена (Clipboard). Так же необходимо включить в Ваш проект
файл ClipBrd.pas.

    procedure SendScreenImageToClipboard; 
    var 
      bmp: TBitmap; 
    begin 
      bmp := TBitmap.Create; 
      try 
        bmp.Width := Screen.Width; 
        bmp.Height := Screen.Height; 
        BitBlt(bmp.Canvas.Handle, 0, 0, Screen.Width, Screen.Height, 
        GetDC(GetDesktopWindow), 0, 0, SRCCopy); 
        Clipboard.Assign(bmp); 
      finally 
        bmp.Free; 
      end; 
    end; 

Следующая функция скопирует изображение экрана в в bitmap. Переменная
bitmap *должна* быть инициализирована до вызова этой функции.

    procedure GetScreenImage(bmp: TBitmap); 
    begin 
      bmp.Width := Screen.Width; 
      bmp.Height := Screen.Height; 
      BitBlt(bmp.Canvas.Handle, 0, 0, Screen.Width, Screen.Height, 
      GetDC(GetDesktopWindow), 0, 0, SRCCopy); 
    end; 

