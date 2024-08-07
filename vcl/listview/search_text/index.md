---
Title: Искать текст в TListView
Author: P. Below
Date: 14.10.2001
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Искать текст в TListView
========================

    // Call FindCaption Method to search for a list view item labeled by the 
    // string specified as the Value parameter 
     
    // Syntax: 
     
    function FindCaption(StartIndex: Integer; Value: string; 
      Partial, Inclusive, Wrap: Boolean): TListItem; 
     
    // Example, Beispiel: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      lvItem: TListItem; 
    begin 
      lvItem := ListView1.FindCaption(0,      // StartIndex: Integer; 
                                      '99',   // Search string: string; 
                                      True,   // Partial, 
                                      True,   // Inclusive 
                                      False); // Wrap  : boolean; 
      if lvItem <> nil then 
      begin 
        ListView1.Selected := lvItem; 
        lvItem.MakeVisible(True); 
        ListView1.SetFocus; 
      end; 
    end; 
     
     
    // To search for a list view subitem (also for items), use this function: 
     
    { 
      Search for text in a listview item 
      @Param lv is the listview, supposed to be in vaReport mode 
      @Param S is the text to search for 
      @Param column is the column index for the column to search, 0-based 
      @Returns the found listview item, or Nil if none was found 
      @Precondition  lv  nil, lv in report mode if column  0, S not empty 
      @Desc The search is case-insensitive and will only match on the 
      complete column content. Use AnsiContainsText instead of AnsiCompareText 
      to match on a substring in the columns content. 
      Created 14.10.2001 by P. Below 
    } 
     
    function FindListViewItem(lv: TListView; const S: string; column: Integer): TListItem; 
    var 
      i: Integer; 
      found: Boolean; 
    begin 
      Assert(Assigned(lv)); 
      Assert((lv.viewstyle = vsReport) or (column = 0)); 
      Assert(S <> ''); 
      for i := 0 to lv.Items.Count - 1 do 
      begin 
        Result := lv.Items[i]; 
        if column = 0 then 
          found := AnsiCompareText(Result.Caption, S) = 0 
        else if column > 0 then 
          found := AnsiCompareText(Result.SubItems[column - 1], S) = 0 
        else 
          found := False; 
        if found then 
          Exit; 
      end; 
      // No hit if we get here 
      Result := nil; 
    end; 
     
    // Example call: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      lvItem: TListItem; 
    begin 
      // Search subitem[0] for text from edit1 
      // in der Spalte subitem[0] den Text aus Edit1 suchen 
      lvItem := FindListViewItem(ListView1, Edit1.Text, 1); 
      // if found, then show the item 
      // falls item gefunden, dann anzeigen 
      if lvItem <> nil then 
      begin 
        ListView1.Selected := lvItem; 
        lvItem.MakeVisible(True); 
        ListView1.SetFocus; 
      end; 
    end; 
     
     
    // Function to search items and select if found 
     
    procedure LV_FindAndSelectItems(lv: TListView; const S: string; column: Integer); 
    var 
      i: Integer; 
      found: Boolean; 
      lvItem: TListItem; 
    begin 
      Assert(Assigned(lv)); 
      Assert((lv.ViewStyle = vsReport) or (column = 0)); 
      Assert(S <> ''); 
      for i := 0 to lv.Items.Count - 1 do 
      begin 
        lvItem := lv.Items[i]; 
        if column = 0 then 
          found := AnsiCompareText(lvItem.Caption, S) = 0 
        else if column > 0 then 
        begin 
          if lvItem.SubItems.Count >= Column then 
            found := AnsiCompareText(lvItem.SubItems[column - 1], S) = 0 
          else  
            found := False; 
        end 
        else 
          found := False; 
        if found then 
        begin 
          lv.Selected := lvItem; 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      lvItem: TListItem; 
    begin 
      // in der Spalte subitem[0] den Text aus Edit1 suchen 
      LV_FindAndSelectItems(ListView1, Edit1.Text, 1); 
      ListView1.SetFocus; 
    end;

