---
Title: Как защитить запись в TDBGrid от удаления?
Date: 01.01.2007
---


Как защитить запись в TDBGrid от удаления?
==========================================

::: {.date}
01.01.2007
:::

Поместите следующий код в событие OnKeyDown в DBGrid.

    procedure TForm1.DBGrid1KeyDown(Sender: TObject; var Key: Word; 
      Shift: TShiftState); 
    begin 
      if (ssctrl in shift) and (key=vk_delete) then key:=0; 
    end;

Взято из <https://forum.sources.ru>
