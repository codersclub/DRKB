---
Title: Предпросмотр / печать TRichEdit
Author: p0s0l
Date: 01.01.2007
---


Предпросмотр / печать TRichEdit
===============================

::: {.date}
01.01.2007
:::

Чтобы вывести Rich Edit на любой канвас, нужно использовать стандартное
сообщение EM\_FORMATRANGE.

lParam пареметр этого сообщения содержит указатель на структуру
TFormatRange.

Перед посылкой сообщения нужно заполнить эту структуру:

hdc - контекст устройства, на который будет выводиться Rich Edit

hdcTarget - контекст устройства, в соответствии с которым будет
производиться форматирование текста

rc - область, в которую будет выводиться Rich Edit. Единицы измерения -
твипсы (twips). Twips = 1/1440 дюйма.

rcPage - полная область вывода устройства (в твипсах)

chrg - указывает диапазон выводимого текста

chrg.cpMin и chrg.cpMax - позиции символов, определяющие кусок текста
(не включая сами cpMin и cpMax)\...

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

Следующий пример покажет, как вывести Rich Edit не только на любой
канвас, но и также, как вывести только определённый кусок текста\...

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

А как вывести Rich-текст с фоновым рисунком ?

Рисуем по-отдельности фоновый рисунок и содержимое TRichEdit, а потом их
соединяем\...

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

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
