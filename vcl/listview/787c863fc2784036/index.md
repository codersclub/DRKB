---
Title: Цветные строки для TListView
Date: 01.01.2007
---


Цветные строки для TListView
============================

::: {.date}
01.01.2007
:::

    procedure TForm1.ListView1CustomDrawItem(Sender: TCustomListView;
       Item: TListItem; State: TCustomDrawState; var DefaultDraw: Boolean);
     begin
       with ListView1.Canvas.Brush do
       begin
         case Item.Index of
           0: Color := clYellow;
           1: Color := clGreen;
           2: Color := clRed;
         end;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
