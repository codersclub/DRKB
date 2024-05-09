---
Title: Как нарисовать повернутый текст?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как нарисовать повернутый текст?
================================

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

