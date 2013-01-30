---
Title: Как программно реализовать Cut, Copy и Paste?
Date: 01.01.2007
---


Как программно реализовать Cut, Copy и Paste?
=============================================

::: {.date}
01.01.2007
:::

Следущие операции производятся с активным контролом на форме:

    procedure TForm1.Cut1Click(Sender: TObject);
    begin
      SendMessage (ActiveControl.Handle, WM_Cut, 0, 0);
    end;
     
     
    procedure TForm1.Copy1Click(Sender: TObject);
    begin
      SendMessage (ActiveControl.Handle, WM_Copy, 0, 0);
    end;
     
    procedure TForm1.Paste1Click(Sender: TObject);
    begin
      SendMessage (ActiveControl.Handle, WM_Paste, 0, 0);
    end;

Если Вы разрабатываете приложение MDI, то необходимо отправлять
сообщение в активное дочернее окно, т.е. использовать:
ActiveMDIChild.ActiveControl.Handle

Взято из <https://forum.sources.ru>
