<h1>Прозрачный bitmap</h1>
<div class="date">01.01.2007</div>


<p>Вам необходимо две копии вашего изображения. Маску и само изображение. Маска является ничем иным, как изображением, состоящим из двух цветов. Черного для тех областей, которые вы хотите показать, и белого для прозрачных. Для Windows 3.1 маска изображения может быть черно-белой, и предназначена для определения размеров изображения. В Win95 черно-белая маска ни при каких обстоятельствах не работает, т.к. у нее должна быть та же глубина цветов, что и у самого изображения, которое вы хотите показать.</p>

<p>Изображение, которое вы хотите показать, должно содержать в прозрачных областях значение цвета, равное 0. Метод помещения изображения на экран такой же, как и в DOS. Маска AND экран, изображение OR или XOR с той же областью.</p>

<p>Ниже приведен код Delphi, позволяя сделать вышеописанное с помощью двух TBitmap.</p>

<pre>
Canvas.CopyMode := cmSrcAnd;
Canvas.CopyRect(TitleRect, BMask.Canvas, TitleRect);
{заполняем "пробелы" изображением}
Canvas.CopyMode := cmSrcPaint;
Canvas.CopyRect(TitleRect, BTitle.Canvas, TitleRect);
</pre>

<hr />
<pre>
procedure DrawTransparentBmp(Cnv: TCanvas; x,y: Integer; Bmp: TBitmap; clTransparent: TColor);
var
  bmpXOR, bmpAND, bmpINVAND, bmpTarget: TBitmap;
  oldcol: Longint;
begin
  try
    bmpAND := TBitmap.Create;
    bmpAND.Width := Bmp.Width;
    bmpAND.Height := Bmp.Height;
    bmpAND.Monochrome := True;
    oldcol := SetBkColor(Bmp.Canvas.Handle, ColorToRGB(clTransparent));
    BitBlt(bmpAND.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, Bmp.Canvas.Handle, 0, 0, SRCCOPY);
    SetBkColor(Bmp.Canvas.Handle, oldcol);
 
    bmpINVAND := TBitmap.Create;
    bmpINVAND.Width := Bmp.Width;
    bmpINVAND.Height := Bmp.Height;
    bmpINVAND.Monochrome := True;
    BitBlt(bmpINVAND.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, bmpAND.Canvas.Handle, 0, 0, NOTSRCCOPY);
 
    bmpXOR := TBitmap.Create;
    bmpXOR.Width := Bmp.Width;
    bmpXOR.Height := Bmp.Height;
    BitBlt(bmpXOR.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, Bmp.Canvas.Handle, 0, 0, SRCCOPY);
    BitBlt(bmpXOR.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, bmpINVAND.Canvas.Handle, 0, 0, SRCAND);
 
    bmpTarget := TBitmap.Create;
    bmpTarget.Width := Bmp.Width;
    bmpTarget.Height := Bmp.Height;
    BitBlt(bmpTarget.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, Cnv.Handle, x, y, SRCCOPY);
    BitBlt(bmpTarget.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, bmpAND.Canvas.Handle, 0, 0, SRCAND);
    BitBlt(bmpTarget.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height, bmpXOR.Canvas.Handle, 0, 0, SRCINVERT);
    BitBlt(Cnv.Handle, x, y, Bmp.Width, Bmp.Height, bmpTarget.Canvas.Handle, 0, 0, SRCCOPY);
  finally
    bmpXOR.Free;
    bmpAND.Free;
    bmpINVAND.Free;
    bmpTarget.Free;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

