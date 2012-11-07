<h1>Выделение некоторых узлов другим шрифтом</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  CommCtrl; 
 
procedure SetNodeBoldState(Node: TTreeNode; Value: Boolean); 
var 
  TVItem: TTVItem; 
begin 
  if not Assigned(Node) then Exit; 
  with TVItem do 
  begin 
    mask := TVIF_STATE or TVIF_HANDLE; 
    hItem := Node.ItemId; 
    stateMask := TVIS_BOLD; 
    if Value then state := TVIS_BOLD  
    else  
      state := 0; 
    TreeView_SetItem(Node.Handle, TVItem); 
  end; 
end; 
 
// Example: Make the first node bold. 
// Beispiel: Erster Eintrag fett machen. 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SetNodeBoldState(TreeView1.Items[0], True); 
end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>
<hr />
<pre>
uses CommCtrl;
...
procedure SetNodeState(node :TTreeNode; Flags: Integer);
var
  tvi: TTVItem;
begin
  FillChar(tvi, Sizeof(tvi), 0);
  tvi.hItem := node.ItemID;
  tvi.mask := TVIF_STATE;
  tvi.stateMask := TVIS_BOLD or TVIS_CUT;
  tvi.state := Flags;
  TreeView_SetItem(node.Handle, tvi);
end;
 
//И вызываем: 
 
SetNodeState(TreeView1.Selected, TVIS_BOLD); // Текст жиpным
SetNodeState(TreeView1.Selected, TVIS_CUT); // Иконкy бледной (Ctrl+X)
SetNodeState(TreeView1.Selected, TVIS_BOLD or TVIS_CUT); // Текст жиpным
SetNodeState(TreeView1.Selected, 0); // Ни того, ни дpyгого
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
