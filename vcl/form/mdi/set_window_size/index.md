---
Title: Открытие MDI-окон определенного размера
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Открытие MDI-окон определенного размера
=======================================

    var
      ProjectWindow: TWndProject;
    begin
      If ProjectActive=false then 
      begin
        LockWindowUpdate(ClientHandle);
        ProjectWindow:=TWndProject.Create(self);
        ProjectWindow.Left:=10;
        ProjectWindow.Top:=10;
        ProjectWindow.Width:=373;
        ProjecTwindow.Height:=222;
        ProjectWindow.Show;
        LockWindowUpdate(0);
      end;
    end;

Используйте LockWindowUpdate перед созданием окна и после того, как
создание будет завершено.

