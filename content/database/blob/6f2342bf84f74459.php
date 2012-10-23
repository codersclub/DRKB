<h1>Извлечение изображения из BLOB-поля</h1>
<div class="date">01.01.2007</div>



<p>Извлечение изображения из BLOB-поля таблицы dBASE или Paradox -- без первой записи изображения в файл -- простейший процесс использования метода Assign для сохранения содержимого BLOB-поля в объекте, имеющим тип TBitmap. Отдельный объект TBitmap или свойство Bitmap объекта Picture, в свою очередь являющегося свойством компонента TIMage, могут служить примером совместимой цели для данной операции.</p>

<p>Вот пример кода, демонстрирующего использование метода Assign для копирования изображения из BLOB-поля в компонент TImage.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Image1.Picture.Bitmap.Assign(Table1Bitmap);
end;
</pre>


<p>В данном примере, объект Table1Bitmap типа TBLOBField - BLOB-поле таблицы dBASE. Данный TBLOBField-объекты был создан с помощью редактора полей (Fields Editor). Если редактор полей для создания TFields для полей таблицы не используется, получить доступ к полям можно с помощью метода FieldByName или свойства Fields, оба они являются членами компонентов TTable или TQuery. В случае ссылки на BLOB-поле таблицы с помощью одного из приведенных членов, перед использованием метода Assign указатель на поле должен быть прежде приведен к типу объекта TBLOBField. Для примера:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Image1.Picture.Bitmap.Assign(TBLOBField(Table1.Fields[1]));
end;
</pre>


<p>Изображение, хранящееся в BLOB-поле, может быть скопировано непосредственно в отдельный TBitmap объект. Ниже приведен пример, демонстрирующий создание объекта TBitmap и сохранения в нем изображения из BLOB-поля.</p>
<pre>
procedure TForm1.Button2Click(Sender: TObject);
var
  B: TBitmap;
begin
  B := TBitmap.Create;
  try
    B.Assign(Table1Bitmap);
    Image1.Picture.Bitmap.Assign(B);
  finally
    B.Free;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

