<h1>Поиск в TreeView по тексту</h1>
<div class="date">01.01.2007</div>


<pre>
// Search a TreeItem through its Text property
// Return value is a TreeNodeObject
function Form1.TreeItemSearch(TV: TTreeView; SucheItem: string): TTreeNode;
var
  i: Integer;
  iItem: string;
begin
  if (TV = nil) or (SucheItem = '') then Exit;
  for i := 0 to TV.Items.Count - 1 do 
  begin
    iItem := TV.Items[i].Text;
    if SucheItem = iItem then 
    begin
      Result := TV.Items[i];
      Exit;
    end 
    else 
    begin
      Result := nil;
    end;
  end;
end;
</pre>
<p>Example: Search for Wasserfall in TreeView1 and select item</p>
<pre>procedure TForm1.Button1Click(Sender: TObject);
var
  Node: TTreeNode;
begin
  //either - entweder so
  Node := TreeItemSuchen(TreeView1, 'Wasserfall');
  TreeView1.Selected := Node;
  //or - oder so
  TreeView1.Selected := TreeItemSuchen(TreeView1, 'Wasserfall ');
end;
 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />
<pre>
Function FindNode(Tree: TTreeView; Node: TTreeNode; S: String): TTreeNode;
Var t:Integer;
Begin
 Result:=nil;
  { Если поиск идёт в корне }
 IF not Assigned(Node) then
  Begin
   Node:=Tree.Items.GetFirstNode;
   While Assigned(Node) Do
    Begin
     IF Node.Text = S then
      Begin
       Result:=Node;
       Break;
      End; {IF}
     Node:=Node.GetNextSibling;
    End; {While}
   { или если в другой ветви }
  End else For t:=0 to Node.Count - 1 Do IF Node[t].Text = S then
  Begin
   Result:=Node[t];
   Break;
  End; {else}
End;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Song</div>
</p>
<hr />
<div class="author">Автор: Peter Kane</div>
<p>Небольшие хитрости для работы с узлами TreeView:</p>
<p>Если вы хотите производить поиск по дереву, может быть для того, чтобы найти узел, соответствующий определенному критерию, то НЕ ДЕЛАЙТЕ ЭТО ТАКИМ ОБРАЗОМ:</p>
<pre>
for i := 0 to pred(MyTreeView.Items.Count) do
begin
  if MyTreeView.Items[i].Text = 'Банзай' then
    break;
end;
</pre>
<p>...если вам не дорого время обработки массива узлов.</p>
<p>Значительно быстрее будет так:</p>
<pre>
Noddy := MyTreeView.Items[0];
Searching := true;
while (Searching) and (Noddy &lt;&gt; nil) do
begin
  if Noddy.text = SearchTarget then
  begin
    Searching := False;
    MyTreeView.Selected := Noddy;
    MyTreeView.SetFocus;
  end
  else
  begin
    Noddy := Noddy.GetNext
  end;
end;
</pre>
<p>В моей системе приведенный выше код показал скорость 33 милисекунды при работе с деревом, имеющим 171 узел. Первый поиск потребовал 2.15 секунд.</p>
<p>Оказывается, процесс индексирования очень медленный. Я подозреваю, что при каждой индексации свойства Items, вы осуществляете линейный поиск, но это нигде не засвидетельствовано, поэтому я могу ошибаться.</p>
<p>Вам действительно не нужно просматривать все дерево, чтобы найти что вам нужно - получить таким образом доступ к MyTreeView.Items[170] займет много больше времени, чем получения доступа к MyTreeView.Items[1].</p>
<p>Как правило, для отслеживания позиции в дереве TreeView, нужно использовать временную переменную TTreeNode, а не использовать целочисленные индексы. Возможно, свойство ItemId как раз и необходимо для такого применения, но, к сожалению, я никак не могу понять абзац в электронной документации, касающийся данного свойства:</p>
<p>    "Свойство ItemId является дескриптором TTreeNode типа HTreeItem</p>
<p>    и однозначно идентифицирует каждый элемент дерева. Используйте</p>
<p>    это свойство, если вам необходимо получить доступ к элементам</p>
<p>    дерева из внешнего по отношению к TreeView элемента управления."</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
