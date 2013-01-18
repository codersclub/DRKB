---
Title: Нажатия клавиши и звук
Author: Smike
Date: 01.01.2007
---


Нажатия клавиши и звук
======================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      PlaySound('wmpaud7.wav', 0, SND_NOSTOP + SND_ASYNC);
    end;
     
    procedure TForm1.Button1MouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      PlaySound(nil, 0, 0);
    end;



Автор: Smike

Взято из <https://forum.sources.ru>
