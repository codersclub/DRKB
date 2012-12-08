---
Title: Как сохранить содержимое таблицы в текстовый файл?
Date: 01.01.2007
---


Как сохранить содержимое таблицы в текстовый файл?
==================================================

::: {.date}
01.01.2007
:::

Эти небольшие функции анализирую таблицу и записывают её содержимое в
TStringList. А затем просто сохраняют в файл.

    procedure DatasetRecordToInfFile(aDataset: TDataSet; aStrList: TStrings);
    var
      i: integer;
    begin
      for i := 0 to (aDataset.FieldCount-1) do
        aStrList.Add(aDataset.Fields[i].FieldName + '=' +
        aDataset.Fields[i].AsString);
    end;
     
    procedure DatasetToInfFile(aDataset: TDataSet; aStrList: TStrings);
    begin
      aDataSet.First;
      while not aDataSet.EOF do
      begin
        DatasetRecordToInfFile(aDataset,aStrList);
        aDataSet.Next;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      DatasetRecordToInfFile(Table1,Memo1.Lines);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      DatasetToInfFile(Table1,Memo1.Lines);
    end;

Взято с <https://delphiworld.narod.ru>
