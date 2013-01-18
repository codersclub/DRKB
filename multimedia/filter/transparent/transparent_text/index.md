---
Title: Как поместить прозрачный текст на Canvas bitmap
Author: Олег Кулабухов
Date: 01.01.2007
---


Как поместить прозрачный текст на Canvas bitmap
===============================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      OldBkMode: integer;
    begin
      Image1.Picture.Bitmap.Canvas.Font.Color := clBlue;
      OldBkMode := SetBkMode(Image1.Picture.Bitmap.Canvas.Handle, TRANSPARENT);
      Image1.Picture.Bitmap.Canvas.TextOut(10, 10, 'Hello');
      SetBkMode(Image1.Picture.Bitmap.Canvas.Handle, OldBkMode);
    end;

Автор: Олег Кулабухов

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
