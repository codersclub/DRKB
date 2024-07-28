---
Title: Получить все выделенные элементы TListView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить все выделенные элементы TListView
==========================================

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

