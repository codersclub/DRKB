<h1>Как изменить заголовок кнопки «Пуск»</h1>
<div class="date">01.01.2007</div>

Для начала создайте какой-нибудь Bitmap, который вы будете натягивать на кнопку [т.к. такого понятия как "заголовок кнопки ПУСК" в действительности не существует], а та надпись, что находится на стартовой кнопке, является рисунком. Создавая рисунок, учитывайте размеры и то, что левая сторона должна быть "плоской", как у нас на рисунке слева, это связано с особенностями наложения. </p>
<p>Далее займёмся проектом. Сначала объявляем глобальные переменные </p>
<pre>
StartButton: hWnd;
OldBitmap: THandle;
NewImage: TPicture;
</pre>
<p>Затем описываем событие по создания окна [OnCreate]: </p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  NewImage := TPicture.create;
  NewImage.LoadFromFile('C:\Windows\delphi.BMP'); //здесь укажите путь к нужному файлу
  StartButton := FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'Button', nil);
  OldBitmap := SendMessage(StartButton, BM_SetImage, 0, NewImage.Bitmap.Handle);
end;
</pre>
<p>Если вы делаете это на своей машине, то можете всё восстанавливать по событию OnDestroy: </p>
<pre>
procedure TForm1.FormDestroy(Sender: TObject);
begin
  SendMessage(StartButton, BM_SetImage, 0, OldBitmap);
  NewImage.Free;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

