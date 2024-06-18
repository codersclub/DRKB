---
Title: Как разместить прозрачную надпись на TBitmap?
Date: 01.01.2007
Author: Aziz (JINX)
Source: Королевство Дельфи (https://delphi.vitpc.com/)
---


Как разместить прозрачную надпись на TBitmap?
=============================================

    procedure TForm1.Button1Click(Sender: TObject);
    var
            OldBkMode : integer;
    begin
            Image1.Picture.Bitmap.Canvas.Font.Color := clBlue;
            OldBkMode := SetBkMode(Image1.Picture.Bitmap.Canvas.Handle,TRANSPARENT);
            Image1.Picture.Bitmap.Canvas.TextOut(10, 10, 'Hello');
            SetBkMode(Image1.Picture.Bitmap.Canvas.Handle,OldBkMode);
    end;

Взято из "DELPHI VCL FAQ Перевод с английского"

Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)
