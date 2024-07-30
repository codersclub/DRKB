---
Title: Обращение через свойство Controls
Author: Kiber\_rat
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Обращение через свойство Controls
=================================

    procedure TForm1.UpDown1Click(Sender: TObject; Button: TUDBtnType);

    var
      I: Integer;
      ChildControl: TControl;
    begin
      for I:= 0 to GroupBox1.ControlCount -1 do
      begin
        ChildControl := GroupBox1.Controls[I];
        ChildControl.Top := ChildControl.Top + 15
      end;
    end;

Проверить тип контрола надо оператором is:

    if edit1 is TEdit then....

Затем доступ ко всем свойствам путем приведения класса:

    (edit1 as TEdit).text:='';

