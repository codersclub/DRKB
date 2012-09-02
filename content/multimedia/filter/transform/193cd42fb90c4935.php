<h1>Масштабирование для Canvas</h1>
<div class="date">01.01.2007</div>


<pre>
procedure SetCanvasZoomFactor(Canvas: TCanvas; AZoomFactor: Integer);
 var
   i: Integer;
 begin
   if AZoomFactor = 100 then
     SetMapMode(Canvas.Handle, MM_TEXT)
   else
   begin
     SetMapMode(Canvas.Handle, MM_ISOTROPIC);
     SetWindowExtEx(Canvas.Handle, AZoomFactor, AZoomFactor, nil);
     SetViewportExtEx(Canvas.Handle, 100, 100, nil);
   end;
 end;
 
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   bitmap: TBitmap;
 begin
   bitmap := TBitmap.Create;
   try
     bitmap.Assign(Form1.image1.Picture.Bitmap);
     SetCanvasZoomFactor(bitmap.Canvas, 70);
     Canvas.Draw(30, 30, bitmap);
   finally
     bitmap.Free
   end;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
<hr />

