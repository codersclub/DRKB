<h1>ActiveControl имеет DataSet</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: OAmiry (Borland)</div>

<p>Для успешного кодирования необходимо включить typinfo в список используемых модулей. Код данного примера инвертирует логическое свойство Active набора данных, связанного с активным элементом управления при каждом нажатии пользователем клавиши ESC.</p>
<pre>
procedure TForm1.FormKeyUp(Sender: TObject; var Key: Word;
  Shift: TShiftState);
var
  PropInfo: PPropInfo;
  PropValue: TObject;
  ds: TDataSource;
begin
  if Key = VK_ESCAPE then
    { Основной код ниже }
  try
    ds := nil;
    { Проверяем, имеет ли компонент свойство DataSource }
    PropInfo := GetPropInfo(ActiveControl.ClassInfo, 'DataSource');
    if PropInfo &lt;&gt; nil then
      { Свойство компонента datasource типа class (например, TDataSource) }
      if PropInfo^.PropType^.Kind = tkClass then
      begin
        PropValue := TObject(GetOrdProp(ActiveControl, PropInfo));
        { Создаем слепок найденного TDataSource }
        ds := (PropValue as DB.TDataSource);
        { Используем dataset, связанный с datasource }
        if not (ds.DataSet.State in dsEditModes) then
          ds.DataSet.Active := not ds.DataSet.Active;
      end;
  except
    on E: EInvalidCast do
      ShowMessage('Ошибка. Ожидался DataSource');
  end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
