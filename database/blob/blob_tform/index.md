---
Title: Сохранение TForm и её свойств в BLOB-поле
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Сохранение TForm и её свойств в BLOB-поле
=========================================

    procedure SaveToField(FField: TBlobField; Form: TComponent);
    var
      Stream: TBlobStream;
      FormName: string;
    begin
      FormName := Copy(Form.ClassName, 2, 99);
      Stream := TBlobStream.Create(FField, bmWrite);
      try
        Stream.WriteComponentRes(FormName, Form);
      finally
        Stream.Free;
      end;
    end;
     
    procedure LoadFromField(FField: TBlobField; Form: TComponent);
    var
      Stream: TBlobStream;
      I: integer;
    begin
      try
        Stream := TBlobStream.Create(FField, bmRead);
        try
          {удаляем все компоненты}
          for I := Form.ComponentCount - 1 downto 0 do
            Form.Components[I].Free;
          Stream.ReadComponentRes(Form);
        finally
          Stream.Free;
        end;
      except
        on EFOpenError do
          {ничего};
      end;
    end;

