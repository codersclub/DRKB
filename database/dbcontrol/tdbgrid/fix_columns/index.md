---
Title: Как зафиксировать один или несколько столбцов в TDBGrid с возможностью навигации по этим столбцам?
Author: Ramil Galiev
Date: 01.01.2007
---


Как зафиксировать один или несколько столбцов в TDBGrid с возможностью навигации по этим столбцам?
==================================================================================================

::: {.date}
01.01.2007
:::

    procedure TDbGridEx.ColEnter;
     
    procedure ProcessColEnter;
    begin
     // -----------------------------------------------------------
     if (SelectedIndex  _Mark) then
       begin
         ColumnMoved(Columns.Count, StaticCol + 1);
         SelectedField := Fields[StaticCol];
       end;
       Exit;
     end;
     
     // -----------------------------------------------------------
     if (SelectedIndex > StaticCol) then
     begin
     
       if _LastSelectedIndex = StaticCol then
       begin
         if _Mark = Columns[SelectedIndex].Title.Caption then
     
         begin
           ColumnMoved(StaticCol + 1, Columns.Count);
           SelectedField := Fields[Columns.Count - 1];
         end
           else
         begin
           ColumnMoved(StaticCol + 1, Columns.Count);
           SelectedField := Fields[StaticCol];
         end;
       end;
     
     end;
    end;
     
    begin
     if (_EntryCol > 0) or _MouseDown or (StaticCol = 0) then
     begin
       _MouseDown := FALSE;
     end else
     begin
       inc(_EntryCol);
       ProcessColEnter;
       dec(_EntryCol);
     end;
     
     if Assigned(OnColEnter) then OnColEnter(Self);
     
     _LastSelectedIndex := SelectedIndex;
    end;

Автор: Ramil Galiev

(2:5085/33.11)

Автор: StayAtHome

Взято с Vingrad.ru <https://forum.vingrad.ru>
