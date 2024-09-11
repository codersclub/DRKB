---
Title: Печать содержимого TMemo / TListbox
Date: 01.01.2007
---

Печать содержимого TMemo / TListbox
===================================

> Как мне вывести на печать все строки компонента TMemo или TListbox?

Вариант 1:

Нижеприведенная функция в качестве параметра акцептует объект TStrings и
распечатывает все строки на принтере, установленном в системе по
умолчанию.Поскольку функция использует TStrings, то она может работать с
любыми типами компонентов, имеющими свойство типа TStrings, например
TDBMemo или TOutline.

    uses Printers;
     
    procedure PrintStrings(Strings: TStrings);
    var
     
      Prn: TextFile;
      i: word;
    begin
     
      AssignPrn(Prn);
      try
        Rewrite(Prn);
        try
          for i := 0 to Strings.Count - 1 do
            writeln(Prn, Strings.Strings[i]);
        finally
          CloseFile(Prn);
        end;
      except
        on EInOutError do
          MessageDlg('Ошибка печати текста.', mtError, [mbOk], 0);
      end;
    end;

------------------------------------------------------------------------
Вариант 2:

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba

Для печати содержимого TMemo или TListbox используйте следующий код:

    PrintStrings(Memo1.Lines);

или

    PrintStrings(Listbox1.Items);

