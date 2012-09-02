<h1>Предпросмотр / печать TRichEdit</h1>
<div class="date">01.01.2007</div>


<p>Чтобы вывести Rich Edit на любой канвас, нужно использовать стандартное сообщение EM_FORMATRANGE.</p>
<p>lParam пареметр этого сообщения содержит указатель на структуру TFormatRange.</p>
<p>Перед посылкой сообщения нужно заполнить эту структуру:</p>
<p>hdc - контекст устройства, на который будет выводиться Rich Edit</p>
<p>hdcTarget - контекст устройства, в соответствии с которым будет производиться форматирование текста</p>
<p>rc - область, в которую будет выводиться Rich Edit. Единицы измерения - твипсы (twips). Twips = 1/1440 дюйма.</p>
<p>rcPage - полная область вывода устройства (в твипсах)</p>
<p>chrg - указывает диапазон выводимого текста</p>
<p>chrg.cpMin и chrg.cpMax - позиции символов, определяющие кусок текста (не включая сами cpMin и cpMax)...</p>
<pre>
function  PrintRTFToBitmap(ARichEdit : TRichEdit; ABitmap : TBitmap) : Longint;
var
  range    : TFormatRange;
begin
FillChar(Range, SizeOf(TFormatRange), 0);
// Rendering to the same DC we are measuring.
Range.hdc        := ABitmap.Canvas.handle;
Range.hdcTarget  := ABitmap.Canvas.Handle;
 
// Set up the page.
Range.rc.left    := 0;
Range.rc.top     := 0;
Range.rc.right   := ABitmap.Width * 1440 div Screen.PixelsPerInch;
Range.rc.Bottom  := ABitmap.Height * 1440 div Screen.PixelsPerInch;
 
// Default the range of text to print as the entire document.
Range.chrg.cpMax := -1;
Range.chrg.cpMin := 0;
 
// format the text
Result := SendMessage(ARichedit.Handle, EM_FORMATRANGE, 1, Longint(@Range));
 
// Free cached information
SendMessage(ARichEdit.handle, EM_FORMATRANGE, 0,0);
end;
</pre>
<p>Следующий пример покажет, как вывести Rich Edit не только на любой канвас, но и также, как вывести только определённый кусок текста...</p>
<pre>
function PrintToCanvas(ACanvas : TCanvas; FromChar, ToChar : integer;
                     ARichEdit : TRichEdit; AWidth, AHeight : integer) : Longint;
var
  Range    : TFormatRange;
begin
FillChar(Range, SizeOf(TFormatRange), 0);
Range.hdc        := ACanvas.handle;
Range.hdcTarget  := ACanvas.Handle;
Range.rc.left    := 0;
Range.rc.top     := 0;
Range.rc.right   := AWidth * 1440 div Screen.PixelsPerInch;
Range.rc.Bottom  := AHeight * 1440 div Screen.PixelsPerInch;
Range.chrg.cpMax := ToChar;
Range.chrg.cpMin := FromChar;
Result := SendMessage(ARichedit.Handle, EM_FORMATRANGE, 1, Longint(@Range));
SendMessage(ARichEdit.handle, EM_FORMATRANGE, 0,0);
end; 
</pre>
<p>А как вывести Rich-текст с фоновым рисунком ?</p>
<p>Рисуем по-отдельности фоновый рисунок и содержимое TRichEdit, а потом их соединяем...</p>
<pre>
procedure TForm1.Button2Click(Sender: TObject);
  var Bmp : TBitmap;
begin
Bmp := TBitmap.Create;
bmp.Width := 300;
bmp.Height := 300;
PrintToCanvas(bmp.Canvas,2,5,RichEdit1,300,300);
BitBlt(Image1.Picture.Bitmap.Canvas.Handle, 0, 0, Bmp.Width, Bmp.Height,
       bmp.Canvas.Handle, 0, 0, srcAND);
Image1.Repaint;
bmp.Free;
end; 
</pre>

<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
