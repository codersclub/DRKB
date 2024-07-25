---
Title: Как узнать, была ли перемещена форма?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать, была ли перемещена форма?
=====================================

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

