---
Title: Drag & Drop несколько элементов в TListView
Date: 01.01.2007
---


Drag & Drop несколько элементов в TListView
===========================================

::: {.date}
01.01.2007
:::

    { ListView1.DragMode := dmAutomatic } 
     
    procedure TForm1.ListView1DragDrop(Sender, Source: TObject; X, Y: Integer); 
    var 
      DragItem, DropItem, CurrentItem, NextItem: TListItem; 
    begin 
      if Sender = Source then 
        with TListView(Sender) do 
        begin 
          DropItem    := GetItemAt(X, Y); 
          CurrentItem := Selected; 
          while CurrentItem <> nil do 
          begin 
            NextItem := GetNextItem(CurrentItem, SdAll, [IsSelected]); 
            if DropItem = nil then DragItem := Items.Add 
            else 
              DragItem := Items.Insert(DropItem.Index); 
            DragItem.Assign(CurrentItem); 
            CurrentItem.Free; 
            CurrentItem := NextItem; 
          end; 
        end; 
    end; 
     
    procedure TForm1.ListView1DragOver(Sender, Source: TObject; X, Y: Integer; 
      State: TDragState; 
      var Accept: Boolean); 
    begin 
      Accept := Sender = ListView1; 
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
