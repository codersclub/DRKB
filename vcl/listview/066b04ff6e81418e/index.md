---
Title: Получить все выделенные элементы TListView
Date: 01.01.2007
---


Получить все выделенные элементы TListView
==========================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
     var
       i: integer;
     begin
       with Listview1 do
         // MultiSelect := True; 
        // ViewStyle := vsReport; 
        for i := 0 to Items.Count - 1 do
           if Items[i].Selected then
             Items[i].Caption := Items[i].Caption + ' - Selected!';
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
