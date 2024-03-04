---
Title: Как выделить цветом текущую строку в TDBGrid?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как выделить цветом текущую строку в TDBGrid?
=============================================

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

