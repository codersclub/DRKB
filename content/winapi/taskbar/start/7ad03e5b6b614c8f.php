<h1>Как изменить изображение кнопки «Пуск»?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Misha Moellner</div>
<p>Пример из серии "Что можно сделать с рабочим столом". В общем, это обычный трюк с кнопкой "Пуск" (Start).</p>
<pre>
{ объявляем глобальные переменные } 
 
var 
  Form1: TForm1; 
  StartButton: hWnd; 
  OldBitmap: THandle; 
  NewImage: TPicture; 
 
{ добавляем следующий код в событие формы OnCreate } 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  NewImage := TPicture.create; 
  NewImage.LoadFromFile('C:\Windows\Circles.BMP'); 
  StartButton := FindWindowEx 
                 (FindWindow( 
                    'Shell_TrayWnd', nil), 
                     0,'Button', nil); 
  OldBitmap := SendMessage(StartButton, 
                           BM_SetImage, 0, 
                           NewImage.Bitmap.Handle); 
end; 
 
{ Событие OnDestroy } 
 
procedure TForm1.FormDestroy(Sender: TObject); 
begin 
  SendMessage(StartButton,BM_SetImage,0,OldBitmap); 
  NewImage.Free; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
