---
Title: Печать с масштабированием
Author: Song
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Печать с масштабированием
=========================

    procedure TForm1.Button1Click(Sender: TObject);
    // © Song
    Var ScaleX, ScaleY: Integer;
    Begin
     Printer.BeginDoc;
     With Printer Do
      try
       ScaleX:=GetDeviceCaps(Handle,LogPixelsX) div PixelsPerInch;
       ScaleY:=GetDeviceCaps(Handle,LogPixelsY) div PixelsPerInch;
       Canvas.StretchDraw(Rect(0,0,Image1.Picture.Width*ScaleX,Image1.Picture.Height*ScaleY),Image1.Picture.Graphic);
      finally
       EndDoc;
      end;
    End;

