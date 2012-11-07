<h1>Динамическое создание полей</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
var
  I: Integer;
  Field: TField;
begin
  { Поля можно добавлять только к неактивному набору данных. }
  Table1.Active := False;
 
  { Распределяем определенные поля если набор данных еще не был активным. }
  Table1.FieldDefs.Update;
 
  { Создаем все поля из определений и добавляем к набору данных. }
  for I := 0 to Table1.FieldDefs.Count - 1 do
  begin
    { Вот где мы действительно сообщаем набору данных о необходимости создания поля. }
    { Поле "назначается", но нам нужно не это, нам нужна просто ссылка на новое поле. }
    Field := Table1.FieldDefs[I].CreateField(Table1);
  end;
 
  { Вот пример того, как вы можете добавить дополнительные, вычисленные поля }
  Field := TStringField.Create(Table1);
  Field.FieldName := 'Total';
  Field.Calculated := True;
  Field.DataSet := Table1;
 
  { Теперь мы можем увидеть наши поля. }
  Table1.Active := True;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
