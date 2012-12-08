---
Title: Как выделить цветом текущую строку в TDBGrid?
Date: 01.01.2007
---


Как выделить цветом текущую строку в TDBGrid?
=============================================

::: {.date}
01.01.2007
:::

    procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect:
     TRect;
       Field: TField; State: TGridDrawState);
     begin
       if gdFocused in State then
       with (Sender as TDBGrid).Canvas do
       begin
         Brush.Color := clRed;
         FillRect(Rect);
         TextOut(Rect.Left, Rect.Top, Field.AsString);
       end;
     end;

Взято с <https://delphiworld.narod.ru>
