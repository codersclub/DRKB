<h1>Перетаскивание файлов в приложение</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ: <a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Иногда очень полезно избавить пользователя от лишних операций при открытии файла.</p>
<p>Он должен нажать на кнопку " Открыть" , затем найти интересующий каталог, выбрать файл.</p>
<p>Проще перетащить мышкой файл сразу в окно приложения.</p>
<p>Рассмотрим пример перетаскивания Drag &amp; Drop в окно произвольного текстового файла,</p>
<p>который сразу же открывается в компоненте Memo1. Для начала в разделе Uses необходимо подключить модуль ShellAPI. В private области окна нужно вставить следующую строку:</p>
<p> procedure WMDropFiles(var Msg: TWMDropFiles); message WM_DROPFILES;//получение сообщений о переносе файла в окно приложения</p>
<p>Процедура обработки этого сообщения будет выглядеть следующим образом:</p>
<pre>
procedure TForm1.WMDropFiles(var Msg: TWMDropFiles);

var
  CFileName: array[0..MAX_PATH] of Char; // переменная, хранящая имя файла
begin
try
If DragQueryFile(Msg.Drop, 0, CFileName, MAX_PATH)&gt; 0 then
// получение пути файла
begin
  Form1.Caption:=CFileName; // имя файла в заголовок окна
  Memo1.Lines.LoadFromFile(CFileName); // открываем файл
  Msg.Result := 0;
end;
finally
  DragFinish(Msg.Drop); // отпустить файл
end;
end;
</pre>

<p>Для того, чтобы форма знала,</p>
<p>что может принимать такие файлы, необходимо в процедуре создания окна</p>
<p>указать:</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
 

 
begin
  DragAcceptFiles(Handle, True); 
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

