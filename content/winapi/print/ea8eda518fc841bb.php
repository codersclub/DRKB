<h1>Печать изображения</h1>
<div class="date">01.01.2007</div>


<pre>
{
Печать изображения. Использует модуль Printers.
Должно работать со всеми типами графики: битмепами, метафайлами и иконками.
(c) Alexey Torgashin, 2007
&nbsp;
Последняя версия функции всегда доступна в исходниках компонента ATViewer:
http://atorg.net.ru/delphi/atviewer.htm
&nbsp;
Параметры:
- AImage: TImage объект.
- ACopies: число копий (можно задать 0 для одной копии).
- AFitToPage: умещать картинку в страницу принтера. Если картинка меньше
  страницы и AFitOnlyLarger=False, то картинка будет растянута.
- AFitOnlyLarger: разрешает умещать только картинки, бОльшие размера страницы.
- ACenter: центрировать картинку по странице.
- APixelsPerInch: число точек на дюйм на экране. Передавайте сюда значение
  св-ва PixelsPerInch Вашей формы или объекта Screen.
- ACaption: заголовок задания печати в Print Manager.
&nbsp;
-----------------------------------
&nbsp;
Image printing. Uses Printers unit.
Should work with all graphics: bitmaps, metafiles and icons.
&nbsp;
Parameters:
- AImage: TImage object.
- ACopies: number of copies (you may set 0 for a single copy).
- AFitToPage: fit image to a printer page. If image is smaller than a page and
  AFitOnlyLarger=False then image will be stretched up to a page.
- AFitOnlyLarger: allows to stretch images smaller than a page.
- ACenter: center image on a page.
- APixelsPerInch: pass here value of PixelsPerInch property of your form or
  of a Screen object (Screen.PixelsPerInch).
- ACaption: print job caption in Print Manager.
}
&nbsp;
function ImagePrint(
  AImage: TImage;
  ACopies: word;
  AFitToPage,
  AFitOnlyLarger,
  ACenter: boolean;
  APixelsPerInch: integer;
  const ACaption: string): boolean;
var
  bmp: TBitmap;
begin
  bmp:= TBitmap.Create;
  try
 &nbsp;&nbsp; bmp.PixelFormat:= pf24bit;
&nbsp;
 &nbsp;&nbsp; {$ifdef ADV_IMAGE_CONV}
 &nbsp;&nbsp; if not CorrectImageToBitmap(AImage, bmp, clWhite) then
 &nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp; Result:= false;
 &nbsp;&nbsp;&nbsp;&nbsp; Exit
 &nbsp;&nbsp; end;
 &nbsp;&nbsp; {$else}
 &nbsp;&nbsp; with AImage.Picture do
 &nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp; bmp.Width:= Graphic.Width;
 &nbsp;&nbsp;&nbsp;&nbsp; bmp.Height:= Graphic.Height;
 &nbsp;&nbsp;&nbsp;&nbsp; bmp.Canvas.Draw(0, 0, Graphic);
 &nbsp;&nbsp; end;
 &nbsp;&nbsp; {$endif}
&nbsp;
 &nbsp;&nbsp; Result:= BitmapPrint( //Declared below
 &nbsp;&nbsp;&nbsp;&nbsp; bmp,
 &nbsp;&nbsp;&nbsp;&nbsp; ACopies,
 &nbsp;&nbsp;&nbsp;&nbsp; AFitToPage,
 &nbsp;&nbsp;&nbsp;&nbsp; AFitOnlyLarger,
 &nbsp;&nbsp;&nbsp;&nbsp; ACenter,
 &nbsp;&nbsp;&nbsp;&nbsp; APixelsPerInch,
 &nbsp;&nbsp;&nbsp;&nbsp; ACaption);
&nbsp;
  finally
 &nbsp;&nbsp; bmp.Free;
  end;
end;
&nbsp;
&nbsp;
function BitmapPrint(
  ABitmap: TBitmap;
  ACopies: word;
  AFitToPage,
  AFitOnlyLarger,
  ACenter: boolean;
  APixelsPerInch: integer;
  const ACaption: string): boolean;
var
  Scale, ScalePX, ScalePY, ScaleX, ScaleY: Double;
  SizeX, SizeY,
  RectSizeX, RectSizeY, RectOffsetX, RectOffsetY: integer;
  i: integer;
Begin
  Result:= true;
&nbsp;
  Assert(
 &nbsp;&nbsp; Assigned(ABitmap) and (ABitmap.Width&gt;0) and (ABitmap.Height&gt;0),
 &nbsp;&nbsp; 'BitmapPrint: bitmap is empty.');
&nbsp;
  if ACopies = 0 then
 &nbsp;&nbsp; Inc(ACopies);
&nbsp;
  with Printer do
  begin
 &nbsp;&nbsp; SizeX:= PageWidth;
 &nbsp;&nbsp; SizeY:= PageHeight;
&nbsp;
 &nbsp;&nbsp; ScalePX:= GetDeviceCaps(Handle, LOGPIXELSX) / APixelsPerInch;
 &nbsp;&nbsp; ScalePY:= GetDeviceCaps(Handle, LOGPIXELSY) / APixelsPerInch;
&nbsp;
 &nbsp;&nbsp; ScaleX:= SizeX / ABitmap.Width / ScalePX;
 &nbsp;&nbsp; ScaleY:= SizeY / ABitmap.Height / ScalePY;
&nbsp;
 &nbsp;&nbsp; if ScaleX &lt; ScaleY then
 &nbsp;&nbsp;&nbsp;&nbsp; Scale:= ScaleX
 &nbsp;&nbsp; else
 &nbsp;&nbsp;&nbsp;&nbsp; Scale:= ScaleY;
&nbsp;
 &nbsp;&nbsp; if (not AFitToPage) or (AFitOnlyLarger and (Scale &gt; 1.0)) then
 &nbsp;&nbsp;&nbsp;&nbsp; Scale:= 1.0;
&nbsp;
 &nbsp;&nbsp; RectSizeX:= Trunc(ABitmap.Width * Scale * ScalePX);
 &nbsp;&nbsp; RectSizeY:= Trunc(ABitmap.Height * Scale * ScalePY);
&nbsp;
 &nbsp;&nbsp; if ACenter then
 &nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp; RectOffsetX:= (SizeX - RectSizeX) div 2;
 &nbsp;&nbsp;&nbsp;&nbsp; RectOffsetY:= (SizeY - RectSizeY) div 2;
 &nbsp;&nbsp; end
 &nbsp;&nbsp; else
 &nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp; RectOffsetX:= 0;
 &nbsp;&nbsp;&nbsp;&nbsp; RectOffsetY:= 0;
 &nbsp;&nbsp; end;
&nbsp;
 &nbsp;&nbsp; Title:= ACaption;
&nbsp;
 &nbsp;&nbsp; try
 &nbsp;&nbsp;&nbsp;&nbsp; BeginDoc;
 &nbsp;&nbsp;&nbsp;&nbsp; try
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; for i:= 1 to ACopies do
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; begin
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Canvas.StretchDraw(
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rect(
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RectOffsetX,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RectOffsetY,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RectOffsetX + RectSizeX,
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RectOffsetY + RectSizeY),
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ABitmap
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; );
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if i &lt; ACopies then
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NewPage;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; end;
 &nbsp;&nbsp;&nbsp;&nbsp; finally
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EndDoc;
 &nbsp;&nbsp;&nbsp;&nbsp; end;
 &nbsp;&nbsp; except
 &nbsp;&nbsp;&nbsp;&nbsp; Result:= false;
 &nbsp;&nbsp; end;
  end;
end;
</pre>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
