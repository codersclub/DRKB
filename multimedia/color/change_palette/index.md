---
Title: Изменение палитры при выводе изображения
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Изменение палитры при выводе изображения
========================================

Да, это не тривиальная задача! Палитра дочернего MDI-окна попортила
нервов не одному мне.

В обработчике сообщения WM\_PaletteChanged вы можете убедиться, что
видимая TImage.Picture.Bitmap.Palette всегда "реализована". Так..

    private
     
    procedure WMPaletteChanged(var Msg: TWMPaletteChanged);
      message WM_PaletteChanged;
     
    ...
     
    procedure Form1.WMPaletteChanged(var Msg: TWMPaletteChanged);
    begin
      if Msg.PalChg <> Form1.Handle then
      begin
        PaletteChanged(true);
        Msg.Result := 0;
      end;
    end;

Теперь вы можете масштабировать неотображенное изображение как вы хотите
и не иметь проблем. Единственное, о чем вам необходимо помнить, если вы
хотите вывести неотображенное изображение на видимый TImage, вам
необходимо вызвать PaletteChanged снова после того, как изображение
выведено. С кодом, который мы использовали...

    Image1.Picture.Bitmap := obitmap;
    PaletteChanged(true);

Если вы не делаете этот вызов, изображение отобразится с неправильной
палитрой.

