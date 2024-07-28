---
Title: Сортировка строк в TMemo
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Сортировка строк в TMemo
========================

    procedure TForm1.Button3Click(Sender: TObject);
    var
      t: TStringList;
    begin
      // создаем
      t:=TStringList.Create;
      // присваиваем переменной t строки из Memo
      t.AddStrings(memo1.lines);
      // сортируем
      t.Sort;
      memo1.Clear;
      // присваиваем memo уже отсортированные строки
      memo1.Lines.AddStrings(t);
    end;
