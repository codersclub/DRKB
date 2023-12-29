---
Title: Восстановление записи dBase
Date: 01.01.2007
---


Восстановление записи dBase
===========================

::: {.date}
01.01.2007
:::

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

Предположим, у вас на форме имеется кнопка (с именем \'butRecall\'),
восстанавливающая текущую отображаемую (или позиционируемую курсором)
запись, данный код, будучи расположенный в обработчике события кнопки
OnClick (вместе с опубликованным выше кодом), это демонстрирует
(продвигаясь в наших предположених дальше, имя вашего объекта TTable -
Table1 и имя текущей формы - Form1):

    procedure TForm1.butRecallClick(Sender: TObject);
    begin
      if dbRecall(Table1) <> DBIERR_NONE then
        ShowMessage('Не могу восстановить запись!');
    end;

- Loren Scott

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba

------------------------------------------------------------------------

    procedure RecordUndelete(aTable: TTable);
    begin
      aTable.UpdateCursorPos;
      try
        Check(DbiUndeleteRecord(aTable.Handle));
      except
        ShowMessage('No undelete performed.');
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
