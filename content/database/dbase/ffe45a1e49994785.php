<h1>Восстановление записи dBase</h1>
<div class="date">01.01.2007</div>


<pre>
function GetTableCursor(oTable: TTable): hDBICur;
var
  szTable: array[0..78] of Char;
begin
  StrPCopy(szTable, oTable.TableName);
  DbiGetCursorForTable(oTable.DBHandle, szTable, nil, Result);
end;
 
function dbRecall(oTable: TTable): DBIResult;
begin
  Result := DbiUndeleteRecord(GetTableCursor(oTable)));
end;
</pre>

<p>Предположим, у вас на форме имеется кнопка (с именем 'butRecall'), восстанавливающая текущую отображаемую (или позиционируемую курсором) запись, данный код, будучи расположенный в обработчике события кнопки OnClick (вместе с опубликованным выше кодом), это демонстрирует (продвигаясь в наших предположених дальше, имя вашего объекта TTable - Table1 и имя текущей формы - Form1):</p>
<pre>
procedure TForm1.butRecallClick(Sender: TObject);
begin
  if dbRecall(Table1) &lt;&gt; DBIERR_NONE then
    ShowMessage('Не могу восстановить запись!');
end;
</pre>


<p>- Loren Scott</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>


<hr />
<pre>
procedure RecordUndelete(aTable: TTable);
begin
  aTable.UpdateCursorPos;
  try
    Check(DbiUndeleteRecord(aTable.Handle));
  except
    ShowMessage('No undelete performed.');
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>


