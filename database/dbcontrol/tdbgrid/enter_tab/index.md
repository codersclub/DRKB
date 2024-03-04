---
Title: Использование Enter как Tab в TDBGrid
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Использование Enter как Tab в TDBGrid
=====================================

Приведу код, позволяющий использовать нажатие клавиши Enter как клавиши
Tab пока управление находится в табличной сетке.

Данный код включает обработку клавиши Enter для всего приложения,
включая поля и пр.. Код для работы с компонентом DBGrid заключен в блок
ELSE. Приведенный код не имитирует поведение клавиши Tab, связанное с
переходом на следующую запись когда курсор достигает последней колонки
табличной сетки, в нашем случае он перемещается на первую колонку.

    procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
    { Это обработчик события OnKeyPress для ФОРМЫ! }
    { Вы должны также установить свойство формы KeyPreview в True }
    begin
      if Key = #13 then { если это клавиша Enter }
        if not (ActiveControl is TDBGrid) then
        begin { если не на TDBGrid }
          Key := #0; { гасим клавишу Enter }
          Perform(WM_NEXTDLGCTL, 0, 0);
            { перемещаемя на следующий элемент управления }
        end
        else if (ActiveControl is TDBGrid) then { если это TDBGrid }
          with TDBGrid(ActiveControl) do
            if selectedindex < (fieldcount - 1) then { увеличиваем поле }
              selectedindex := selectedindex + 1
            else
              selectedindex := 0;
    end;

