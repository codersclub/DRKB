---
Title: Как поместить прозрачную фоновую картинку на компонент TCoolBar?
Date: 01.01.2007
---


Как поместить прозрачную фоновую картинку на компонент TCoolBar?
===============================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Bm1: TBitmap;
      Bm2: TBitmap;
    begin
      Bm1 := TBitmap.Create;
      Bm2 := TBitmap.Create;
      Bm1.LoadFromFile('c:\download\test.bmp');
      Bm2.Width := Bm1.Width;
      Bm2.Height := Bm1.Height;
      bm2.Canvas.Brush.Color := CoolBar1.Color;
      bm2.Canvas.BrushCopy(Rect(0, 0, bm2.Width, bm2.Height), Bm1,
        Rect(0, 0, Bm1.width, Bm1.Height), ClWhite);
      bm1.Free;
      CoolBar1.Bitmap.Assign(bm2);
      bm2.Free;
    end;
