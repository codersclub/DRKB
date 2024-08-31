---
Title: Как скрыть программу от Alt+Tab?
Author: Song
Date: 01.01.2007
---


Как скрыть программу от Alt+Tab?
================================

Вариант 1:

Source: Song

Source: <https://forum.sources.ru>

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowWindow(Handle, SW_HIDE);
      ShowWindow(Application.Handle, SW_HIDE);
    end;

------------------------------------------------------------------------

Вариант 2:

Source: Stavros

Source: <https://forum.sources.ru>

    with Application do
      begin
        ShowWindow(Handle, SW_HIDE);
        SetWindowLong(Handle, GWL_EXSTYLE, GetWindowLong(handle, GWL_EXSTYLE) or WS_EX_TOOLWINDOW);
      end; {With}
    SetWindowLong(Handle, GWL_EXSTYLE, GetWindowLong(Handle, GWL_EXSTYLE) or WS_EX_TOOLWINDOW);

