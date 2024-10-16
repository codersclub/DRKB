---
Title: Как открыть меню кнопки «Пуск»?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как открыть меню кнопки «Пуск»?
===============================

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SendMessage(Self.Handle, WM_SYSCOMMAND, SC_TASKLIST, 0); 
    end;

