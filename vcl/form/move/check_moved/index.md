---
Title: Как узнать, была ли перемещена форма?
Date: 01.01.2007
---


Как узнать, была ли перемещена форма?
=====================================

::: {.date}
01.01.2007
:::

    type
      TfrmMain = class(TForm)
      private
        procedure OnMove(var Msg: TWMMove); message WM_MOVE;
      end;
     
      (...)
     
    procedure TfrmMain.OnMove(var Msg: TWMMove);
    begin
      inherited;
      (...)
    end;
     
    (...)

Взято из <https://forum.sources.ru>
