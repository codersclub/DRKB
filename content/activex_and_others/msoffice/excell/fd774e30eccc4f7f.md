Как вставить картинку
=====================

::: {.date}
01.01.2007
:::

Answer:

If WS is your worksheet:

    { ... }
    WS.Shapes.AddPicture('C:\Pictures\Small.Bmp', EmptyParam, EmptyParam, 10, 160,
      EmptyParam, EmptyParam);

or

    { ... }
    var
      Pics: Excel2000.Pictures; {or whichever Excel}
      Pic: Excel2000.Picture;
      Pic: Excel2000.Shape;
      Left, Top: integer;
    { ... }
    Pics := (WS.Pictures(EmptyParam, 0) as Pictures);
    Pic := Pics.Insert('C:\Pictures\Small.Bmp', EmptyParam);
    Pic.Top := WS.Range['D4', 'D4'].Top;
    Pic.Left := WS.Range['D4', 'D4'].Left;
    { ... }

EmptyParam a special variant (declared in Variants.pas in D6+). However
in later versions of Delphi some conversions cause problems. This should
work:

    uses
      OfficeXP;
     
    { ... }
    WS.Shapes.AddPicture('H:\Pictures\Game\Hills.bmp', msoFalse, msoTrue, 10, 160, 100,
      100);

But you may have to use a TBitmap to find out how large the picture
should be.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
