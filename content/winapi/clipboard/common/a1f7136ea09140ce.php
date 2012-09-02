<h1>Как работать с буфером обмена (clipboard)?</h1>
<div class="date">01.01.2007</div>


<p>Этот пример использует картинку, кнопку и компонент shape на форме. Когда пользователь кликает по кнопке, то изображение формы сохраняется в в переменной FormImage и копируется в буфер обмена (Clipboard). Затем изображение формы копируется обратно в компонент картинки, тем самым создавая интересный эффект, особенно, если кнопку понажимать несколько раз.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  FormImage: TBitmap; 
begin 
  FormImage := GetFormImage; 
  try 
    Clipboard.Assign(FormImage); 
    Image1.Picture.Assign(Clipboard); 
  finally 
    FormImage.Free; 
  end; 
end; 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  Shape1.Shape := stEllipse; 
  Shape1.Brush.Color := clLime; 
  Image1.Stretch := True; 
end;
</pre>


<p>Следующий пример копирует содержимое экрана в буфер обмена:</p>
<pre>
procedure CopyScreenToClipboard; 
var dx,dy : integer;           
    hSourcDC,hDestDC,         
    hBM, hbmOld : THandle;     
 
begin 
  dx := screen.width;              
  dy := screen.height;              
  hSourcDC := CreateDC('DISPLAY',nil,nil,nil); 
  hDestDC  := CreateCompatibleDC(hSourcDC); 
  hBM := CreateCompatibleBitmap(hSourcDC, dx, dy); 
  hbmold:= SelectObject(hDestDC, hBM); 
  BitBlt(hDestDC, 0, 0, dx, dy, hSourcDC, 0, 0, SRCCopy); 
  OpenClipBoard(form1.handle); 
  EmptyClipBoard; 
  SetClipBoardData(CF_Bitmap, hBM); 
  CloseClipBoard; 
  SelectObject(hDestDC,hbmold); 
  DeleteObject(hbm); 
  DeleteDC(hDestDC); 
  DeleteDC(hSourcDC); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


