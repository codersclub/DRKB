<h1>Прокручивать TTreeView во время перемещения</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.TreeView1DragOver(Sender, Source: TObject; X, Y: Integer;
   State: TDragState; var Accept: Boolean);
 begin
   if (y &lt; 15) then {On the upper edge - should scroll up }
     SendMessage(TreeView1.Handle, WM_VSCROLL, SB_LINEUP, 0)
   else if (TreeView1.Height - y &lt; 15) then { On the lower edge - should scroll down }
     SendMessage(TreeView1.Handle, WM_VSCROLL, SB_LINEDOWN, 0);
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
