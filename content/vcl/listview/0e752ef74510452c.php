<h1>Определить нажатие на CheckBox в TListView</h1>
<div class="date">01.01.2007</div>


<pre>
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
  if (Item &lt;&gt; nil) and (HitTest = [htOnStateIcon]) then
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
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
&nbsp;</p>
