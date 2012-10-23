<h1>Размер bitmap</h1>
<div class="date">01.01.2007</div>


<pre>
function PictureSize: TSize;
var
  ResHandle: HWND;
  ResData: HWND;
  BMI: PBitmapInfo;
begin
  Result.cx := 0;
  Result.cy := 0;
  ResHandle := FindResource(HInstance,
    MAKEINTRESOURCE(200), RT_BITMAP);
  if ResHandle &lt;&gt; 0 then
  begin
    ResData := LoadResource(HInstance, ResHandle);
    if ResData &lt;&gt; 0 then
    try
      BMI := LockResource(ResData);
      if Assigned(BMI) then
      try
        Result.cx := BMI.bmiHeader.biWidth;
        Result.cy := BMI.bmiHeader.biHeight;
        // размер картинки вот тут: BMI.bmiHeader.biSizeImage
      finally
        UnlockResource(ResData);
      end;
    finally
      FreeResource(ResData);
    end;
  end;
end;
</pre>
<div class="author">Автор: Rouse_ </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
