---
Title: Как запретить кнопку Close в любом окне?
Date: 01.01.2007
---

Как запретить кнопку Close в любом окне?
========================================

::: {.date}
01.01.2007
:::

Следующий пример запрещает кнопку закрытия (и пункт \"закрыть\" (close)
в системном меню) нужного нам окна (в данном случае Notepad).

    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      hwndHandle : THANDLE; 
      hMenuHandle : HMENU; 
    begin 
      hwndHandle := FindWindow(nil, 'Untitled - Notepad'); 
      if (hwndHandle <> 0) then begin 
        hMenuHandle := GetSystemMenu(hwndHandle, FALSE); 
        if (hMenuHandle <> 0) then 
          DeleteMenu(hMenuHandle, SC_CLOSE, MF_BYCOMMAND); 
      end; 
    end; 

Взято из <https://forum.sources.ru>
