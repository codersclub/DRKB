<h1>Как сохранить веб-страничку в JPG?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>
<pre>
procedure generateJPEGfromBrowser(browser: iWebBrowser2; jpegFQFilename: String;
srcHeight: Integer; srcWidth: Integer; tarHeight: Integer; tarWidth: Integer);
var
sourceDrawRect : TRect;
targetDrawRect: TRect;
sourceBitmap: TBitmap;
targetBitmap: TBitmap;
jpeg: TJPEGImage;
viewObject: IViewObject;
begin
sourceBitmap := TBitmap.Create ;
targetBitmap := TBitmap.Create ;
jpeg := TJPEGImage.Create ;
try
try
sourceDrawRect := Rect(0,0, srcWidth , srcHeight );
sourceBitmap.Width := srcWidth ;
sourceBitmap.Height := srcHeight ; viewObject := browser as IViewObject; if viewObject = nil then
Exit; OleCheck(viewObject.Draw(DVASPECT_CONTENT, 1, nil, nil, self.Handle,
sourceBitmap.Canvas.Handle, @sourceDrawRect, nil, nil, 0)); // Изменяем размер исходного битмапа для коне?ного битмапа
targetDrawRect := Rect(0,0, tarWidth, tarHeight);
targetBitmap.Height := tarHeight;
targetBitmap.Width := tarWidth;
targetBitmap.Canvas.StretchDraw(targetDrawRect, sourceBitmap); // Созда?м JPEG из Bitmap и сохраняем его
jpeg.Assign(targetBitmap) ;
makeFileWriteable(jpegFQFilename);
jpeg.SaveToFile (jpegFQFilename);
finally
jpeg.free;
sourceBitmap.free ;
targetBitmap.free;
end;
except
// Обработка ошибок
end;
end;
</pre>


<div class="author">Автор: Donall Burns</div>
