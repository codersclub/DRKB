---
Title: Изменить размер кнопки «Пуск»
Date: 01.01.2007
---

Изменить размер кнопки «Пуск»
=============================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
     begin
       MoveWindow(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'Button', nil),
                  300, 0, 80, 22, true);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
