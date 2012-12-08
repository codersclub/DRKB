---
Title: Как работать с ssShift и TShiftState?
Author: Vit
Date: 01.01.2007
---


Как работать с ssShift и TShiftState?
=====================================

::: {.date}
01.01.2007
:::

ssShift - это константа применяемая в типе TShiftState (являущемся типом
Set) а не логическая, надо примерно так:

    procedure TForm1.FormKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);

    begin
      if (key=$97) and (ssShift in Shift) then
      begin
      {do something}
      end;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
