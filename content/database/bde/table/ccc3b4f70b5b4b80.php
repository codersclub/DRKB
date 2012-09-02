<h1>Получение информации о таблице</h1>
<div class="date">01.01.2007</div>


<p>Вам нужно воспользоваться свойством FieldDefs. В следующем примере список полей и их соответствующий размер передается компоненту TMemo (расположенному на форме) с именем Memo1:</p>
<pre>
procedure TForm1.ShowFields;
var
  i: Word;
begin
  Memo1.Lines.Clear;
  Table1.FieldDefs.Update;                     
  { должно быть вызвано, если Table1 не активна }
  for i := 0 to Table1.FieldDefs.Count - 1 do
    With Table1.FieldDefs.Items[i] do
      Memo1.Lines.Add(Name + ' - ' + IntToStr(Size));
end;
</pre>


<p>Если вам просто нужны имена полей (FieldNames), то используйте метода TTable GetFieldNames:</p>
<p>GetIndexNames для получения имен индексов:</p>
<pre>
var 
  FldNames, IdxNames : TStringList;
begin
  FldNames := TStringList.Create;
  IdxNames := TStringList.Create;
  If Table1.State = dsInactive then 
    Table1.Open;
  Table1.GetFieldNames(FldNames);
  Table1.GetIndexNames(IdxNames);
  {...... используем полученную информацию ......}
  FldNames.Free; {освобождаем stringlist}
  IdxNames.Free;
end;
</pre>


<p>Для получения информации об определенном поле вы должны использовать FieldDef. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
