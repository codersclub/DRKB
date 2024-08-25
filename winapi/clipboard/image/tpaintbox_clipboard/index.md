---
Title: TPaintBox в буфер обмена
Author: Xavier Pacheco
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


TPaintBox в буфер обмена
========================

    var
      pbRect: TRect;
    begin
      pbRect := Rect(0, 0, PaintBox1.Width, PaintBox1.Height);
      BitMap := TBitMap.Create;
      try
        Bitmap.Width := PaintBox1.Width;
        Bitmap.Height := PaintBox1.Height;
        BitMap.Canvas.CopyRect(pbRect, PaintBox1.Canvas, pbRect);
        ClipBoard.Assign(BitMap);
      finally
        BitMap.Free;
      end;
    end;

