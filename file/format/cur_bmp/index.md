---
Title: CUR -> BMP
Date: 01.01.2007
---


CUR -> BMP
==========

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      hCursor: LongInt;
      Bitmap: TBitmap;
    begin
      Bitmap := TBitmap.Create;
      Bitmap.Width := 32;
      Bitmap.Height := 32;
      hCursor := LoadCursorFromFile('test.cur');
      DrawIcon(Bitmap.Canvas.Handle, 0, 0, hCursor);
      Bitmap.SaveToFile('test.bmp');
      Bitmap.Free;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
