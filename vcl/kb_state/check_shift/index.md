---
Title: Как работать с ssShift и TShiftState?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как работать с ssShift и TShiftState?
=====================================

ssShift - это константа, применяемая в типе TShiftState
(являющемся типом Set), а не логическая.

Надо сделать примерно так:

    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);

    begin
      if (key=$97) and (ssShift in Shift) then
      begin
      {do something}
      end;
    end;

