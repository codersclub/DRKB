<h1>Загрузка изображений в BLOB-поля</h1>
<div class="date">01.01.2007</div>



<p>Имеется несколько способов загрузки изображения в BLOB-поле таблицы dBASE или Paradox. Три самых простых метода включают в себя:</p>

<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">1.</td><td>копирование данных из буфера обмена Windows в компонент TDBImage, связанный с BLOB-полем</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">2.</td><td>использование метода LoadFromFile компонента TBLOBField</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">3.</td><td>использование метода Assign для копирования объекта типа TBitmap в значение свойства Picture компонента TBDBImage.</td></tr></table></div>
<p>Первый способ, когда происходит копирование изображения из буфера обмена, вероятно, наиболее удобен в случае, когда необходимо добавить изображение в таблицу при использовании приложения конечным пользователем. В этом случае компонент TDBImage используется в роли интерфейса между BLOB-полем таблицы и изображением, хранящимся в буфере обмена. Метод PasteFromClipboard компонента TDBImage как раз и занимается тем, что копирует изображение из буфера обмена в TDBImage. При сохранении записи изображение записывается в BLOB-поле таблицы.</p>
<p>Поскольку буфер обмена Windows может содержать данные различных форматов, то желательно перед вызовом метода CopyFromClipboard осуществлять проверку формата хранящихся в нем данных. Для этого необходимо создать объект TClipboard и использовать его метод HasFormat, позволяющий определить формат хранящихся в буфере данных. Имейте в виду, что для создания объекта TClipboard вам необходимо добавить модуль Clipbrd в секцию uses того модуля, в котором будет создаваться экземпляр объекта.</p>

<p>Вот исходный код примера, копирующий содержание буфера обмена в компонент TDBImage, если содержащиеся в буфере данные имеют формат изображения:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  C: TClipboard;
begin
  C := TClipboard.Create;
  try
    if Clipboard.HasFormat(CF_BITMAP) then
      DBImage1.PasteFromClipboard
    else
      ShowMessage('Буфер обмена не содержит изображения!');
  finally
    C.Free;
  end;
end;
</pre>

<p>Второй способ заполнения BLOB-поля заключается в загрузке изображения непосредственно из файла в BLOB-поле. Данный способ одинаково хорош как при создании приложения (формирование данных), так и при его использовании.</p>

<p>Этот способ использует метод LoadFromFile компонента TBLOBField, который применяется в Delphi для работы с dBASE-таблицами и двоичными Windows полями или таблицами Paradox и графическими Windows полями; в обоих случаях с помощью данного метода возможно загрузить изображение и сохранить его в таблице.</p>

<p>Методу LoadFromFile компонента TBLOBField необходим единственный параметр типа String: имя загружаемого файла с изображением. Значение данного параметра может быть получено при выборе файла пользователем с помощью компонента TOpenDialog и его свойства FileName.</p>

<p>Вот пример, демонстрирующий работу метода LoadFromFile компонента TBLOBField с именем Table1Bitmap (поле с именем Bitmap связано с таблицей TTable, имеющей имя Table1):</p>
<pre>
procedure TForm1.Button2Clicck(Sender: TObject);
begin
  Table1Bitmap.LoadFromFile(
    'c:\delphi\images\splash\16color\construc.bmp');
end;
</pre>

<p>Третий способ для копирования содержимого объекта типа TBitmap в свойство Picture компонента TDBImage использует метод Assign. Объект типа TBitmap может быть как свойством Bitmap свойства-объекта Picture компонента TImage, так и отдельного объекта TBitmap. Как и в методе, копирующем данные из буфера обмена в компонент TDBImage, данные изображения компонента TDBImage сохраняются в BLOB-поле после успешного сохранения записи.</p>

<p>Ниже приведен пример, использующий метод Assign. В нашем случае используется отдельный объект TBitmap. Для помещения изображения в компонент TBitmap был вызван его метод LoadFromFile.</p>
<pre>
procedure TForm1.Button3Click(Sender: TObject);
var
  B: TBitmap;
begin
  B := TBitmap.Create;
  try
    B.LoadFromFile('c:\delphi\images\splashh\16color\athena.bmp');
    DBImage1.Picture.Assign(B);
  finally
    B.Free;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

