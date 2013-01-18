---
Title: Плавно превратить один рисунок в другой
Date: 01.01.2007
---


Плавно превратить один рисунок в другой
=======================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    const
      count = 100;
    var
      i: integer;
      x, y: integer;
      bm, bm1, bm2: TBitMap;
      p1, p2, p: PByteArray;
      c: integer;
      k: integer;
    begin
      bm := TBitMap.Create;
      bm1 := TBitMap.Create;
      bm2 := TBitMap.Create;
      bm1.LoadFromFile('Bitmap1.bmp');
      bm2.LoadFromFile('Bitmap2.bmp');
      if bm1.Height < bm2.Height then
      begin
        bm.Height := bm1.Height;
        bm2.Height := bm1.Height;
      end
      else
      begin
        bm.Height := bm2.Height;
        bm1.Height := bm2.Height;
      end;
      if bm1.Width < bm2.Width then
      begin
        bm.Width := bm1.Width;
        bm2.Width := bm1.Width;
      end
      else
      begin
        bm.Width := bm2.Width;
        bm1.Width := bm2.Width;
      end;
      bm.PixelFormat := pf24bit;
      bm1.PixelFormat := pf24bit;
      bm2.PixelFormat := pf24bit;
     
      Form1.Canvas.Draw(0, 0, bm1);
      for i := 1 to count - 1 do
      begin
        for y := 0 to bm.Height - 1 do
        begin
          p := bm.ScanLine[y];
          p1 := bm1.ScanLine[y];
          p2 := bm2.ScanLine[y];
          for x := 0 to bm.Width * 3 - 1 do
            p^[x] := round((p1^[x] * (count - i) + p2^[x] * i) / count);
        end;
        Form1.Canvas.Draw(0, 0, bm);
        Form1.Caption := IntToStr(round(i / count * 100)) + '%';
        Application.ProcessMessages;
        if Application.Terminated then
          break;
      end;
      Form1.Canvas.Draw(0, 0, bm2);
      Form1.Caption := 'done';
      bm1.Destroy; bm2.Destroy; bm.Destroy;
    end;

Взято с <https://delphiworld.narod.ru>
