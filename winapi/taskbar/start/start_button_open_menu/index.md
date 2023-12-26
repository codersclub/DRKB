---
Title: Как открыть меню кнопки «Пуск»?
Date: 01.01.2007
---

Как открыть меню кнопки «Пуск»?
===============================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      SendMessage(Self.Handle, WM_SYSCOMMAND, SC_TASKLIST, 0); 
    end;

Взято из <https://forum.sources.ru>
