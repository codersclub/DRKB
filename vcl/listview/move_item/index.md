---
Title: Переместить элемент в TListView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Переместить элемент в TListView
===============================

Переместить элемент номер 1 после элемента номер 4

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

