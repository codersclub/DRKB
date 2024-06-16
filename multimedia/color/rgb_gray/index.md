---
Title: Преобразование RGB -> Gray
Date: 01.01.2007
---


Преобразование RGB -> Gray
===========

    Function RgbToGray(RGBColor: TColor): TColor;
    var
      Gray: byte;
    begin
      Gray := Round((0.30 * GetRValue(RGBColor)) +
                    (0.59 * GetGValue(RGBColor)) +
                    (0.11 * GetBValue(RGBColor)));
      Result := RGB(Gray, Gray, Gray);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Shape1.Brush.Color := RGB(255, 64, 64);
      Shape2.Brush.Color := RgbToGray(Shape1.Brush.Color);
    end;
