---
Title: Проверка правильности даты
Date: 01.01.2007
---


Проверка правильности даты
==========================

::: {.date}
01.01.2007
:::

    function DateExists(Date: string; Separator: char): Boolean;
    var
      OldDateSeparator: Char;
    begin
      Result := True;
      OldDateSeparator := DateSeparator;
      DateSeparator := Separator;
      try
        try
          StrToDate(Date);
        except
          Result := False;
        end;
      finally
        DateSeparator := OldDateSeparator;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      if DateExists('35.3.2001', '.') then
      begin
        {your code}
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

    function ValidDate(const S: String): Boolean;
    BEGIN
      Result := True;
      try
        StrToDate(S);
      except
        ON EConvertError DO
          Result := False;
      end;
    END
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
