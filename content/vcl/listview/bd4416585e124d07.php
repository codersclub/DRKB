<h1>Переместить элемент в TListView</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
