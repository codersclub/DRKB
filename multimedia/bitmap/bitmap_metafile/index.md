---
Title: Как поместить битмап в метафайл?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить битмап в метафайл?
================================

Следующий пример демонстрирует рисование битмапа в метафайле.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      m : TmetaFile;
      mc : TmetaFileCanvas;
      b : tbitmap;
    begin
      m := TMetaFile.Create;
      b := TBitmap.create;
      b.LoadFromFile('C:\SomePath\SomeBitmap.BMP');
      m.Height := b.Height;
      m.Width := b.Width;
      mc := TMetafileCanvas.Create(m, 0);
      mc.Draw(0, 0, b);
      mc.Free;
      b.Free;
      m.SaveToFile('C:\SomePath\Test.emf');
      m.Free;
      Image1.Picture.LoadFromFile('C:\SomePath\Test.emf');
    end;

