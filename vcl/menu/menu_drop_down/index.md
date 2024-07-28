---
Title: Как программно заставить выпасть меню?
Author: InSAn
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как программно заставить выпасть меню?
======================================

В примере показано как показать меню и выбрать в нем какой-то пункт,
эмулируя нажатие "быстрой кдавиши" пункта меню. Если у Вашего пункта
меню нет "быстрой клавиши" Вы можете посылать комбинации VK\_MENU,
VK\_LEFT, VK\_DOWN, и VK\_RETURN, чтобы программно "путешествовать" по
меню.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      //Allow button to finish painting in response to the click
      Application.ProcessMessages;
      {Alt Key Down}
      keybd_Event(VK_MENU, 0, 0, 0);
      {F Key Down - Drops the menu down}
      keybd_Event(ord('F'), 0, 0, 0);
      {F Key Up}
      keybd_Event(ord('F'), 0, KEYEVENTF_KEYUP, 0);
      {Alt Key Up}
      keybd_Event(VK_MENU, 0, KEYEVENTF_KEYUP, 0);
      {F Key Down}
      keybd_Event(ord('S'), 0, 0, 0);
      {F Key Up}
      keybd_Event(ord('S'), 0, KEYEVENTF_KEYUP, 0);
    end;

