---
Title: Как использовать TImageList для рисования прозрачных картинок?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как использовать TImageList для рисования прозрачных картинок?
==============================================================

Следующий пример демонстрирует динамическое создание компонента
TImageList, используемого для рисования прозрачного битмапа.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      bm : TBitmap;
      il : TImageList;
    begin
      bm := TBitmap.Create;
      bm.LoadFromFile('C:\DownLoad\TEST.BMP');
      il := TImageList.CreateSize(bm.Width,
                                  bm.Height);
      il.DrawingStyle := dsTransparent;
      il.Masked := true;
      il.AddMasked(bm, clRed);
      il.Draw(Form1.Canvas, 0, 0, 0);
      bm.Free;
      il.Free;
    end;

