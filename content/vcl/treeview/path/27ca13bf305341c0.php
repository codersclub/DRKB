<h1>Рекурсивные механизмы спуска по дереву</h1>
<div class="date">01.01.2007</div>

Нужно использовать рекурсивные механизмы спуска по дереву и иметь метод определения наличия child узлов у текущего узла.</p>
<pre>
function  TDBTreeView.RecurseChilds(node: TTreeNode): double;
begin
  while node &lt;&gt; nil do begin
    if node.HasChildren then
       Result := RecurseChilds(node.GetFirstChild);
    Result := Result + GetResultForNode(node));
    node := node.GetNextSibling;
  end;
end;
 
function  TDBTreeView.GetResult(curnode: TTreeNode;): double;
begin
  Result := 0;
  if curnode = nil then Exit;
  Result := RecurseChilds(curnode.GetFirstChild);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

