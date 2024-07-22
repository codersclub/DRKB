---
Title: Как перетаскивать компоненты в runtime?
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как перетаскивать компоненты в runtime?
=======================================

Возьмите форму, бросьте на нее панель, на onMouseDown панели прицепите
код:

    procedure TForm1.Panel1MouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);

    begin
      ReleaseCapture;
      Panel1.Perform(WM_SYSCOMMAND, $F012, 0);
    end;

Теперь в run-time панель можно таскать как в дизайне...

