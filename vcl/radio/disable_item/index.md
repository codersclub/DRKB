---
Title: Можно ли отключить определенный элемент в RadioGroup?
Date: 01.01.2007
---


Можно ли отключить определенный элемент в RadioGroup?
=====================================================

В примере показано как получить доступ к отдельным элементам компонента
TRadioGroup.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TRadioButton(RadioGroup1.Controls[1]).Enabled := False;
    end;
