<h1>JPG &gt; BMP</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  JPEG; 
 
procedure JPEGtoBMP(const FileName: TFileName); 
var 
  jpeg: TJPEGImage; 
  bmp:  TBitmap; 
begin 
  jpeg := TJPEGImage.Create; 
  try 
    jpeg.CompressionQuality := 100; {Default Value} 
    jpeg.LoadFromFile(FileName); 
    bmp := TBitmap.Create; 
    try 
      bmp.Assign(jpeg); 
      bmp.SaveTofile(ChangeFileExt(FileName, '.bmp')); 
    finally 
      bmp.Free 
    end; 
  finally 
    jpeg.Free 
  end; 
end; 
 
 
{ 
  CompressionQuality (default 100): 
  Set a value between 1..100, depending on your need of quality and 
  image file size. 1 = Smallest file size, 100 = Best quality. 
} 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
