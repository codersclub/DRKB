---
Title: Как перетаскивать компоненты в runtime?
Date: 01.01.2007
---


Как перетаскивать компоненты в runtime?
=======================================

::: {.date}
01.01.2007
:::

Возьмите форму, бросьте на нее панель, на onMouseDown панели прицепите
код:

    procedure TForm1.Panel1MouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);

    begin
      ReleaseCapture;
      Panel1.Perform(WM_SYSCOMMAND, $F012, 0);
    end;

Теперь в run-time панель можно таскать как в дизайне...

Взято с Vingrad.ru <https://forum.vingrad.ru>
