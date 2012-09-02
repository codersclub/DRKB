<h1>Проверить, развернут ли или свернут полностью TTreeView</h1>
<div class="date">01.01.2007</div>


<pre>
function IsTreeviewFullyExpanded(tv: TTreeview): Boolean;
 var
   Node: TTreeNode;
 begin
   Assert(Assigned(tv));
   if tv.Items.Count &gt; 0 then
   begin
     Node   := tv.Items[0];
     Result := True;
     while Result and Assigned(Node) do
     begin
       Result := Node.Expanded or not Node.HasChildren;
       Node   := Node.GetNext;
     end; {While}
   end {If}
   else
     Result := False
 end;
 
 function IsTreeviewFullyCollapsed(tv: TTreeview): Boolean;
 var
   Node: TTreeNode;
 begin
   Assert(Assigned(tv));
   if tv.Items.Count &gt; 0 then
   begin
     Node   := tv.Items[0];
     Result := True;
     while Result and Assigned(Node) do
     begin
       Result := not (Node.Expanded and Node.HasChildren);
       Node   := Node.GetNext;
     end; {While}
   end {If}
   else
     Result := False
 end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
