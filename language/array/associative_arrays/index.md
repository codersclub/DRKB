---
Title: Использование ассоциативных массивов
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Использование ассоциативных массивов
====================================

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


