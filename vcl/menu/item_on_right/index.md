---
Title: Как поместить TMenuItem справа у формы?
Date: 01.01.2007
---


Как поместить TMenuItem справа у формы?
=======================================

::: {.date}
01.01.2007
:::

Допустим, у Вас есть TMainMenu MainMenu1 и HelpMenuItem в конце панели
меню (Menubar). Если Вызвать следующий обработчик события OnCreate, то
HelpMenuItem сместится вправо.

    uses 
      Windows; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      ModifyMenu(MainMenu1.Handle, 0, mf_ByPosition or mf_Popup 
                 or mf_Help, HelpMenuItem1.Handle, '&Help'); 
    end;

Взято из <https://forum.sources.ru>
