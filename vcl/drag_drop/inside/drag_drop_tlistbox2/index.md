---
Title: Drag & Drop со списками
Date: 01.01.2007
---


Drag & Drop со списками
=======================

::: {.date}
01.01.2007
:::

    { 
     This example shows how to drag&drop within a TListBox. 
     The Demo Program also shows how to implement an autoscroll-feature. 
    }
     
     procedure TForm1.ListBox1DragOver(Sender, Source: TObject; X, Y: Integer;
       State: TDragState; var Accept: Boolean);
     begin
       Accept := Sender is TListBox;
     end;
     
     procedure TForm1.ListBox1DragDrop(Sender, Source: TObject; X, Y: Integer);
     var
       iTemp: Integer;
       ptTemp: TPoint;
       szTemp: string;
     begin
       { change the x,y coordinates into a TPoint record }
       ptTemp.x := x;
       ptTemp.y := y;
     
       { Use a while loop instead of a for loop due to items possible being removed 
       from listboxes this prevents an out of bounds exception }
       iTemp := 0;
        while iTemp <= TListBox(Source).Items.Count-1 do
       begin
         { look for the selected items as these are the ones we wish to move }
         if TListBox(Source).selected[iTemp] then
         begin
           { use a with as to make code easier to read }
           with Sender as TListBox do
           begin
           { need to use a temporary variable as when the item is deleted the 
            indexing will change }
             szTemp := TListBox(Source).Items[iTemp];
     
             { delete the item that is being dragged  }
             TListBox(Source).Items.Delete(iTemp);
     
           { insert the item into the correct position in the listbox that it 
           was dropped on }
             Items.Insert(itemAtPos(ptTemp, True), szTemp);
           end;
         end;
         Inc(iTemp);
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 

 
