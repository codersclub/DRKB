---
Title: Об ускорении работы с графикой
Date: 01.01.2007
---


Об ускорении работы с графикой
==============================

Сегодня поговорим о том, как по-другому можно ускорить работу с
графикой.

Иногда нужные точки изображения не находятся в одной строке, например,
при повороте. Для увеличения скорости в этом случае выгодно поместить
всю картинку в доступную память. Для этого используется функция GetDIB.
Она копирует изображение в выделенную для этого память. А дальше, чтобы
узнать цвет точки (x,y) изображения WxH нужно воспользоваться следующей
"формулой":

    PRGBTriple(integer(p) + (H - y - 1) * (3 * W + dw) + x * 3)

Эта "формула" возвращает цвет в формате TRGBTriple. TRGBTriple - это
запись с тремя полями: красная, зеленая и синяя составляющие цвета. dw -
это `w mod 4` и нужен он для того, чтобы создавать сдвиг, связанный с шириной
изображения.

Эта программа "размывает" изображение, просто находя среднее
арифметическое для каждой составляющей цвета близлежащих точек. При
нажатии на Button1 изображение "размывается" с использованием GetDIB,
а при нажатии на Button2 используется свойство Pixels. Время работы
алгоритма в миллисекундах выводится в заголовок окна.

    const
      d = 5;
     
    procedure TForm1.Button1Click(Sender: TObject);
    type
      PRGBTripleArray = ^TRGBTripleArray;
      TRGBTripleArray = array [0..0] of TRGBTriple;
    var
      bi: PBitmapInfo;
      InfoSize, ImageSize: cardinal;
      bmS, bmD: TBitmap;
      p: pointer;
      line: PRGBTripleArray;
      t: cardinal;
      r, g, b: integer;
      w, h, x, y, x1, y1: integer;
      left, right, top, bottom: integer;
      dw, norm: integer;
    begin
      bmS := TBitmap.Create;
      bmS.LoadFromFile('ex.bmp');
      bmS.PixelFormat := pf24bit;
      w := bmS.Width; h := bmS.Height;
      bmD := TBitmap.Create;
      bmD.Width := w; bmD.Height := h;
      bmD.PixelFormat := pf24bit;
      t := GetTickCount;
      dw := w mod 4;
      GetDIBSizes(bmS.Handle, InfoSize, ImageSize);
      GetMem(p, ImageSize);
      GetMem(bi, InfoSize);
      GetDIB(bmS.Handle, 0, bi^, p^);
      for y := 0 to h - 1 do begin
        line := bmD.ScanLine[y];
        if y > d then top := y - d else top := 0;
        if y + d < h - 1 then bottom := y + d else bottom := h - 1;
        for x := 0 to w - 1 do begin
          r := 0; g := 0; b := 0;
          if x > d then left := x - d else left := 0;
          if x + d < w - 1 then right := x + d else right := w - 1;
          for y1 := top to bottom do
            for x1 := left to right do with PRGBTriple(integer(p) +
              (h - y1 - 1) * (3 * w + dw) + x1 * 3)^ do begin
              r := r + rgbtRed;
              g := g + rgbtGreen;
              b := b + rgbtBlue;
            end;
          norm := (bottom - top + 1) * (right - left + 1);
          with line^[x] do begin
            rgbtRed := r div norm;
            rgbtGreen := g div norm;
            rgbtBlue := b div norm;
          end;
        end;
      end;
      Form1.Caption := IntToStr(GetTickCount - t);
      Form1.Canvas.Draw(0, 0, bmS);
      Form1.Canvas.Draw(0, h + 5, bmD);
      bmS.Destroy; bmD.Destroy;
      FreeMem(p, ImageSize);
      FreeMem(bi, InfoSize);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    type
      PRGBTripleArray = ^TRGBTripleArray;
      TRGBTripleArray = array [0..0] of TRGBTriple;
    var
      bmS, bmD: TBitmap;
      t: cardinal;
      r, g, b: integer;
      w, h, x, y, x1, y1: integer;
      left, right, top, bottom: integer;
      norm: integer;
      c: TColor;
    begin
      bmS := TBitmap.Create;
      bmS.LoadFromFile('ex.bmp');
      bmS.PixelFormat := pf24bit;
      w := bmS.Width; h := bmS.Height;
      bmD := TBitmap.Create;
      bmD.Width := w; bmD.Height := h;
      bmD.PixelFormat := pf24bit;
      t := GetTickCount;
      for y := 0 to h - 1 do begin
        if y > d then top := y - d else top := 0;
        if y + d < h - 1 then bottom := y + d else bottom := h - 1;
        for x := 0 to w - 1 do begin
          r := 0; g := 0; b := 0;
          if x > d then left := x - d else left := 0;
          if x + d < w - 1 then right := x + d else right := w - 1;
          for y1 := top to bottom do
            for x1 := left to right do begin
              c := bmS.Canvas.Pixels[x1,y1];
              r := r + GetRValue(c);
              g := g + GetGValue(c);
              b := b + GetBValue(c);
            end;
          norm := (bottom - top + 1) * (right - left + 1);
          bmD.Canvas.Pixels[x,y] := rgb(r div norm, g div norm, b div norm);
        end;
      end;
      Form1.Caption := IntToStr(GetTickCount - t);
      Form1.Canvas.Draw(0, 0, bmS);
      Form1.Canvas.Draw(0, h + 5, bmD);
      bmS.Destroy; bmD.Destroy;
    end;
