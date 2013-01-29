---
Title: Как очистить все окошки редактирования на форме?
Date: 01.01.2007
---


Как очистить все окошки редактирования на форме?
================================================

::: {.date}
01.01.2007
:::

    procedure ClearEdits;
     var i : Integer;
    begin
    for i := 0 to ComponentCount-1 do
      if (Components[i] is TEdit) then
        (Components[i] as TEdit).Text := '';
    end;

Взято из <https://forum.sources.ru>
