<h1>Drag &amp; Drop несколько элементов в TListView</h1>
<div class="date">01.01.2007</div>


<pre>
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
      while CurrentItem &lt;&gt; nil do 
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
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
