---
Title: Как очистить все окошки редактирования на форме?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как очистить все окошки редактирования на форме?
================================================

    procedure ClearEdits;
     var i : Integer;
    begin
    for i := 0 to ComponentCount-1 do
      if (Components[i] is TEdit) then
        (Components[i] as TEdit).Text := '';
    end;

