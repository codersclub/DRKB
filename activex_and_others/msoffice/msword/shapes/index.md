---
Title: Как работать с Shapes
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как работать с Shapes
=====================


    { ... }
    var
      Pic: Word2000.Shape;
      Left, Top: OleVariant;
      { ... }
     
    {To add a pic and make it appear behind text}
    Left := 100;
    Top := 100;
    Pic := Doc.Shapes.AddPicture('C:\Small.bmp', EmptyParam, EmptyParam, Left, Top,
      EmptyParam, EmptyParam, EmptyParam);
    Pic.WrapFormat.Type_ := wdWrapNone;
    Pic.ZOrder(msoSendBehindText);
    {To get a watermark effect}
    Pic.PictureFormat.Brightness := 0.75;
    Pic.PictureFormat.Contrast := 0.20;
    {To make any white in a picture transparent}
    Pic.PictureFormat.TransparencyColor := clWhite;
    Pic.PictureFormat.TransparentBackground := msoTrue;
    Pic.Fill.Visible := msoFalse;
    { ... }

