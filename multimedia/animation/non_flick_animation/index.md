---
Title: Как сделать анимацию немерцающей?
Date: 01.01.2007
---


Как сделать анимацию немерцающей?
=================================

::: {.date}
01.01.2007
:::

Мерцание возникает, когда цвет точки меняется два раза подряд. Например,
правильнее объект при его перемещении стирать и затем рисовать на новом
месте не на экране, а в памяти, и выводить на форму уже готовое
изображение поверх предыдущего. В таком случае смена цветов на экране
происходит только один раз.

    var
      bm: TBitMap;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      bm := TBitMap.Create;
      bm.Width := Form1.ClientWidth;
      bm.Height := Form1.ClientHeight;
      with bm.Canvas do
      begin
        Font.name := 'Arial';
        Font.Size := 50;
        Font.Color := clBlue;
      end;
      Timer1.Interval := 100;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      s: string;
      Hour, Min, Sec, MSec: Word;
    begin
      DecodeTime(Time, Hour, Min, Sec, MSec);
      with bm.Canvas do
      begin
        Brush.Style := bsSolid;
        Brush.Color := clWhite;
        FillRect(ClipRect);
        s := TimeToStr(Time);
        TextOut((bm.Width - TextWidth(s)) div 2,
        (bm.Height - TextHeight(s)) div 2, s);
        Pen.Mode := pmMask;
        Pen.Width := 20;
        Pen.Color := clLime;
        Brush.Style := bsClear;
        Rectangle(bm.Width div 2 - (MSec * bm.Width) div 5000,
        bm.Height div 2 - (MSec * bm.Height) div 5000,
        bm.Width div 2 + (MSec * bm.Width) div 5000,
        bm.Height div 2 + (MSec * bm.Height) div 5000);
      end;
      Form1.Canvas.Draw(0, 0, bm);
    end;

Взято с <https://delphiworld.narod.ru>
