---
Title: Как создать вычисляемые поля во время исполнения программы
Author: Nomadic
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как создать вычисляемые поля во время исполнения программы
==========================================================

Смотрите книгу _"Developing Custom Delphi Components"_ от Рэя Конопки.

Здесь немного исправленный пример из этой книги:

    function TMyClass.CreateCalcField(const AFieldName: string;
      AFieldClass: TFieldClass; ASize: Word): TField;
    begin
      Result := FDataSet.FindField(AFieldName); // Field may already exists!
      if Result <> nil then
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

