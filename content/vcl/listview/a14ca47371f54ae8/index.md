---
Title: Двоичный поиск для TListView
Date: 01.01.2007
---


Двоичный поиск для TListView
============================

::: {.date}
01.01.2007
:::

    {+------------------------------------------------------------ 
    | Function ListviewBinarySearch 
    | 
    | Parameters : 
    | listview: listview to search, assumed to be sorted, must 
    | be <> nil. 
    | Item : item caption to search for, cannot be empty 
    | index : returns the index of the found item, or the 
    | index where the item should be inserted if it is not 
    | already in the list. 
    | Returns : True if there is an item with the passed caption 
    | in the list, false otherwise. 
    | Description: 
    | Uses a binary search and assumes that the listview is sorted 
    | ascending on the caption of the listitems. The search is 
    | case-sensitive, like the default alpha-sort routine used by 
    | the TListview class. 
    | Note: 
    | We use the lstrcmp function for string comparison since it 
    | is the function used by the default alpha sort routine. If 
    | the listview is sorted by another means (e.g. OnCompare event) 
    | this needs to be changed, the comparison method used must 
    | always be the same one used to sort the listview, or the 
    | search will not work! 
    | Error Conditions: none 
    | Created: 31.10.99 by P. Below 
    +------------------------------------------------------------}
     
     function ListviewBinarySearch(listview: TListview; const Item: string;
       var Index: Integer): Boolean;
     var
       First, last, pivot, res: Integer;
     begin
       Assert(Assigned(listview));
       Assert(Length(item) > 0);
     
       Result := False;
       Index  := 0;
       if listview.Items.Count = 0 then Exit;
     
       First := 0;
       last  := listview.Items.Count - 1;
       repeat
         pivot := (First + last) div 2;
         res   := lstrcmp(PChar(item), PChar(listview.Items[pivot].Caption));
         if res = 0 then
         begin
           { Found the item, return its index and exit. }
           Index  := pivot;
           Result := True;
           Break;
         end { If }
         else if res > 0 then
         begin
           { Item is larger than item at pivot }
           First := pivot + 1;
         end { If }
         else
         begin
           { Item is smaller than item at pivot }
           last := pivot - 1;
         end;
       until last < First;
       Index := First;
     end; { ListviewBinarySearch }

Взято с сайта: <https://www.swissdelphicenter.ch>
