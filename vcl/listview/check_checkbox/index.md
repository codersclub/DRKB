---
Title: Определить нажатие на CheckBox в TListView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Определить нажатие на CheckBox в TListView
==========================================

    procedure TForm1.ListView1MouseUp(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
     var
       Item: TListItem;
       HitTest: THitTests;
     begin
       // Welchem Item gehцrt die CheckBox 
       // Which item belongs to the checkbox 
       Item := ListView1.GetItemAt(x, y);
     
       // Was wurde vom Item genau angeklickt 
       // What kind of thing was hit on the item 
       HitTest := ListView1.GetHitTestInfoAt(x, y);
     
       // Falls ein Item angeklickt wurde und davon die Checkbox 
       // If an Item was hit and exactly his checkbox 
       if (Item <> nil) and (HitTest = [htOnStateIcon]) then
       begin
         //////////////////////////////// 
         // Hier das OnCheck behandeln // 
         // Handle OnCheck here        // 
         //////////////////////////////// 
         // Beispiel 
         // Example 
         // 
         //  if Item.Checked = False then 
         //  begin 
         //    if (Item.Index = 0) or (ListView1.Items.Item[Item.Index - 1].Checked = True) then 
         //      Item.Checked := True else Item.Checked := False; 
         //  end else 
         //    begin 
         //    if (Item.Index = ListView1.Items.Count - 1) or (ListView1.Items.Item[Item.Index + 1].Checked = False) then Item.Checked := False else 
         //      Item.Checked := True; 
         //  end; 
       end;
     end;

