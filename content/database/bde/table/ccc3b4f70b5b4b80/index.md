---
Title: Получение информации о таблице
Date: 01.01.2007
---


Получение информации о таблице
==============================

::: {.date}
01.01.2007
:::

Вам нужно воспользоваться свойством FieldDefs. В следующем примере
список полей и их соответствующий размер передается компоненту TMemo
(расположенному на форме) с именем Memo1:

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

Если вам просто нужны имена полей (FieldNames), то используйте метода
TTable GetFieldNames:

GetIndexNames для получения имен индексов:

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

Для получения информации об определенном поле вы должны использовать
FieldDef.

Взято с <https://delphiworld.narod.ru>
