---
Title: Как нарисовать повернутый текст?
Date: 01.01.2007
---


Как нарисовать повернутый текст?
================================

::: {.date}
01.01.2007
:::

    uses 
      QT; 
     
    procedure TForm1.RotatedText(Cnv: TCanvas; Wkl: Integer; Pxy: TPoint; Txt: string); 
    var 
      PrPoint: TPoint; 
    begin 
      // Rotate Canvas 
      QPainter_rotate(Cnv.Handle, Wkl); 
      // Convert Device Coord. to Modell-Coord. 
      QPainter_xFormDev(Cnv.Handle, PPoint(@PrPoint), 
        PPoint(@Pxy)); 
      // Write text. 
      Canvas.TextOut(PrPoint.X, PrPoint.Y, 'Txt'); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
