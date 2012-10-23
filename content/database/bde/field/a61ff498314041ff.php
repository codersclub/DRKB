<h1>Функции редактора полей во время выполнения программы</h1>
<div class="date">01.01.2007</div>


<p>Возможен ли вызов функций редактора полей (Fields Editor) во время выполнения программы?</p>

<p>Да. Если вы определили поля во время разработки приложения, то во время выполнения можно менять их свойства (например, Size).</p>

<p>Например, следующий код изменяет каждый размер поля TField.Size так, чтобы соответствовать фактическому размеру поля открываемого набора данных:</p>

<pre>
procedure SetupFieldsAndOpenDataset(DataSet: TDataSet);
var
  FieldNum, DefNum: Integer;
begin
  with DataSet do
  begin
    if Active then
      Close;
    FieldDefs.Update; {набор данных должен быть закрыт}
    {ищем каждое предопределенное TField в DataSet.FieldDefs:}
    for FieldNum := FieldCount - 1 downto 0 do
      with Fields[FieldNum] do
      begin
        DefNum := FieldDefs.IndexOf(FieldName);
        if DefNum &lt; 0 then
          raise Exception.CreateFmt(
            'Поле "%s" не найдено в наборе данных "%s"',
            [FieldName, Dataset.Name]);
        {устанавливаем свойство size:}
        Size := FieldDefs[DefNum].Size;
      end;
    Open;
  end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
