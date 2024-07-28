---
Title: Как поместить TMenuItem справа у формы?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить TMenuItem справа у формы?
=======================================

Допустим, у Вас есть TMainMenu MainMenu1 и HelpMenuItem в конце панели
меню (Menubar). Если вызвать следующий обработчик события OnCreate, то
HelpMenuItem сместится вправо.

    uses 
      Windows; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      ModifyMenu(MainMenu1.Handle, 0, mf_ByPosition or mf_Popup 
                 or mf_Help, HelpMenuItem1.Handle, '&Help'); 
    end;

