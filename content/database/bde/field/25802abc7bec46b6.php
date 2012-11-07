<h1>Как создать вычисляемые поля во время исполнения программы</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Nomadic</div>

<p>Смотрите книгу "Developing Custom Delphi Components" от Рэя Конопки.</p>
<p>Здесь немного исправленный пример из этой книги:</p>

<pre class="delphi">
function TMyClass.CreateCalcField(const AFieldName: string;
  AFieldClass: TFieldClass; ASize: Word): TField;
begin
  Result := FDataSet.FindField(AFieldName); // Field may already exists!
  if Result &lt;&gt; nil then
    Exit;
  if AFieldClass = nil then
  begin
    DBErrorFmt(SUnknownFieldType, [AFieldName]);
  end;
  Result := FieldClass.Create(Owner);
  with Result do
  try
    FieldName := AFieldName;
    if (Result is TStringField) or (Result is TBCDField) or
      (Result is TBlobField) or (Result is TBytesField) or
      (Result is TVarBytesField) then
    begin
      Size := ASize;
    end;
    Calculated := True;
    DataSet := FDataset;
    Name := FDataSet.Name + AFieldName;
  except
    Free; // We must release allocated memory on error!
    raise;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
