---
Title: Как быстро нарисовать тень в заданном регионе?
Date: 01.01.2007
---


Как быстро нарисовать тень в заданном регионе?
==============================================

::: {.date}
01.01.2007
:::

    procedure TForm2.DrawShadows(WDepth, HDepth : Integer); 
    var 
      Dst, RgnBox  : TRect; 
      hOldDC         : HDC; 
      OffScreen      : TBitmap; 
      Pattern          : TBitmap; 
      Bits               : array[0..7] of WORD; 
    begin 
      Bits[0]:=$0055; 
      Bits[1]:=$00aa; 
      Bits[2]:=$0055; 
      Bits[3]:=$00aa; 
      Bits[4]:=$0055; 
      Bits[5]:=$00aa; 
      Bits[6]:=$0055; 
      Bits[7]:=$00aa; 
     
      hOldDC:=Canvas.Handle; 
      Canvas.Handle:=GetWindowDC(Form1.Handle); 
     
     
      OffsetRgn(ShadeRgn, WDepth, HDepth); 
      GetRgnBox(ShadeRgn, RgnBox); 
     
      Pattern:=TBitmap.Create; 
      Pattern.ReleaseHandle; 
      Pattern.Handle:=CreateBitmap(8, 8, 1, 1, @(Bits[0])); 
      Canvas.Brush.Bitmap:=Pattern; 
     
      OffScreen:=TBitmap.Create; 
      OffScreen.Width:=RgnBox.Right-RgnBox.Left; 
      OffScreen.Height:=RgnBox.Bottom-RgnBox.Top; 
      Dst:=Rect(0, 0, OffScreen.Width, OffScreen.Height); 
     
      OffsetRgn(ShadeRgn, 0, -RgnBox.Top); 
      FillRgn(OffScreen.Canvas.Handle, ShadeRgn, Canvas.Brush.Handle); 
     
      OffsetRgn(ShadeRgn, 0, RgnBox.Top); 
     
    //  BitBlt работает быстрее CopyRect 
      BitBlt(OffScreen.Canvas.Handle, 0, 0, OffScreen.Width, OffScreen.Height, 
             Canvas.Handle, RgnBox.Left, RgnBox.Top, SRCAND); 
     
      Canvas.Brush.Color:=clBlack; 
      FillRgn(Canvas.Handle, ShadeRgn, Canvas.Brush.Handle); 
     
      BitBlt(Canvas.Handle, RgnBox.Left, RgnBox.Top, OffScreen.Width, 
       OffScreen.Height, OffScreen.Canvas.Handle, 0, 0, SRCPAINT); 
     
      OffScreen.Free; 
      Pattern.Free; 
     
      OffsetRgn(ShadeRgn, -WDepth, -HDepth); 
     
      ReleaseDC(Form1.Handle, Canvas.Handle); 
      Canvas.Handle:=hOldDC; 
    end; 

Комментарии :

Функция рисует тень сложной формы на форме Form2.

Для определения формы тени используется регион ShadeRgn, который был
создан где-то раньше (например в OnCreate). Относительно регионов см.
Win32 API.

Титов Игорь Евгеньевич

infos@obninsk.ru
