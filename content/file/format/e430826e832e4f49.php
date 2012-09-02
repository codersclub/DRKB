<h1>BMP &gt; JPG</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Jpeg, ClipBrd; 
 
procedure TfrmMain.ConvertBMP2JPEG; 
  // converts a bitmap, the graphic of a TChart for example, to a jpeg 
var  
  jpgImg: TJPEGImage; 
begin 
  // copy bitmap to clipboard 
  chrtOutputSingle.CopyToClipboardBitmap; 
  // get clipboard and load it to Image1 
  Image1.Picture.Bitmap.LoadFromClipboardFormat(cf_BitMap, 
    ClipBoard.GetAsHandle(cf_Bitmap), 0); 
  // create the jpeg-graphic 
  jpgImg := TJPEGImage.Create; 
  // assign the bitmap to the jpeg, this converts the bitmap 
  jpgImg.Assign(Image1.Picture.Bitmap); 
  // and save it to file 
  jpgImg.SaveToFile('TChartExample.jpg'); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

