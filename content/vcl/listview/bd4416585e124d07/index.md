---
Title: Переместить элемент в TListView
Date: 01.01.2007
---


Переместить элемент в TListView
===============================

::: {.date}
01.01.2007
:::

    // Move item 1 after item 4 
     
    function MoveListViewItem(listView: TListView; ItemFrom, ItemTo: Word): Boolean;
     var
       Source, Target: TListItem;
     begin
       Result := False;
       listview.Items.BeginUpdate;
       try
         Source := listview.Items[ItemFrom];
         Target := listview.Items.Insert(ItemTo);
         Target.Assign(Source);
         Source.Free;
         Result := True;
       finally
         listview.Items.EndUpdate;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       // Listview1.ViewStyle := vsReport; 
      if MoveListViewItem(Listview1, 1, 4) then
         ShowMessage('Moved!');
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
