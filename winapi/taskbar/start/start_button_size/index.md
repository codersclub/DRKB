---
Title: Изменить размер кнопки «Пуск»
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Изменить размер кнопки «Пуск»
=============================

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      MoveWindow(FindWindowEx(
                     FindWindow('Shell_TrayWnd', nil),
                     0, 'Button', nil),
                 300, 0, 80, 22, true);
    end;

