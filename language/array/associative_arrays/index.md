---
Title: Использование ассоциативных массивов
Date: 01.01.2007
---


Использование ассоциативных массивов
====================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      DataField: TStrings;
    begin
      DataField := TStringList.Create; 
      DataField.Add(Format('%s=%s', ['Jonas', '15.03.1980'])); 
      ShowMessage(DataField.Values['Jonas']) 
      // will print the Birthday of Jonas 
      DataField.Free; 
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
