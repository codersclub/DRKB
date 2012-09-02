<h1>How to render a TRichEdit text onto a canvas?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure RichEditToCanvas(RichEdit: TRichEdit; Canvas: TCanvas; PixelsPerInch: Integer);
var
  ImageCanvas: TCanvas;
  fmt: TFormatRange;
begin
  ImageCanvas := Canvas;
  with fmt do
  begin
    hdc:= ImageCanvas.Handle;
    hdcTarget:= hdc;
    // rect needs to be specified in twips (1/1440 inch) as unit
    rc:=  Rect(0, 0,
                ImageCanvas.ClipRect.Right * 1440 div PixelsPerInch,
                ImageCanvas.ClipRect.Bottom * 1440 div PixelsPerInch
              );
    rcPage:= rc;
    chrg.cpMin := 0;
    chrg.cpMax := RichEdit.GetTextLen;
  end;
  SetBkMode(ImageCanvas.Handle, TRANSPARENT);
  RichEdit.Perform(EM_FORMATRANGE, 1, Integer(@fmt));
  // next call frees some cached data
  RichEdit.Perform(EM_FORMATRANGE, 0, 0);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
   RichEditToCanvas(RichEdit1, Image1.Canvas, Self.PixelsPerInch);
   Image1.Refresh;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

