<h1>Выделять узел TTreeView правой кнопкой мыши</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.TreeView1ContextPopup(Sender: TObject; MousePos: TPoint;
   var Handled: Boolean);
 var
   tmpNode: TTreeNode;
 begin
   tmpNode := (Sender as TTreeView).GetNodeAt(MousePos.X, MousePos.Y);
   if tmpNode &lt;&gt; nil then
     TTreeView(Sender).Selected := tmpNode;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
