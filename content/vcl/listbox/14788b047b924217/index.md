---
Title: Как сделать картинки из TImageList прозрачными?
Date: 01.01.2007
---


Как сделать картинки из TImageList прозрачными?
===============================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      bm: TBitmap;
      il: TImageList;
    begin
      bm := TBitmap.Create;
      bm.LoadFromFile('C:\DownLoad\TEST.BMP');
      il := TImageList.CreateSize(bm.Width, bm.Height);
      il.DrawingStyle := dsTransparent;
      il.Masked := true;
      il.AddMasked(bm, clRed);
      il.Draw(Form1.Canvas, 0, 0, 0);
      bm.Free;
      il.Free;
    end;
