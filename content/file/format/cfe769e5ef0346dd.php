<h1>WMF &gt; BMP</h1>
<div class="date">01.01.2007</div>


<pre>
procedure ConvertWMF2BMP
(const WMFFileName, BMPFileName: TFileName); 
var 
  MetaFile : TMetafile; 
  Bitmap : TBitmap; 
begin 
  Metafile := TMetaFile.Create; 
  Bitmap := TBitmap.Create; 
  try 
    MetaFile.LoadFromFile(WMFFileName); 
    with Bitmap do 
    begin 
      Height := Metafile.Height; 
      Width  := Metafile.Width; 
      Canvas.Draw(0, 0, MetaFile); 
      SaveToFile(BMPFileName); 
    end; 
  finally
                Bitmap.Free; 
    MetaFile.Free; 
  end; 
end;
</pre>

<p>Использование:</p>
<pre>
ConvertWMF2BMP('c:\mypic.wmf','c:\mypic.bmp')
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

