---
Title: Настройки всплывающих подсказок в TDBNavigator
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Настройки всплывающих подсказок в TDBNavigator
==============================================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      ix: integer;
    begin
      with DBNavigator1 do
        for ix := 0 to ControlCount - 1 do
          if Controls[ix] is TNavButton then
            with Controls[ix] as TNavButton do
              case index of
                nbFirst: Hint := 'Подсказка для кнопки First';
                nbPrior: Hint := 'Подсказка для кнопки Prior';
                nbNext: Hint := 'Подсказка для кнопки Next';
                nbLast: Hint := '';
                {......}
              end;
    end;

