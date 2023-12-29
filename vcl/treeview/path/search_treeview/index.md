---
Title: Поиск в TreeView по тексту
Author: Song
Date: 01.01.2007
---


Поиск в TreeView по тексту
==========================

::: {.date}
01.01.2007
:::

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

Example: Search for Wasserfall in TreeView1 and select item

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Node: TTreeNode;
    begin
      //either - entweder so
      Node := TreeItemSuchen(TreeView1, 'Wasserfall');
      TreeView1.Selected := Node;
      //or - oder so
      TreeView1.Selected := TreeItemSuchen(TreeView1, 'Wasserfall ');
    end;
     

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

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

Взято из <https://forum.sources.ru>

Автор: Song

 

------------------------------------------------------------------------

Автор: Peter Kane

Небольшие хитрости для работы с узлами TreeView:

Если вы хотите производить поиск по дереву, может быть для того, чтобы
найти узел, соответствующий определенному критерию, то НЕ ДЕЛАЙТЕ ЭТО
ТАКИМ ОБРАЗОМ:

    for i := 0 to pred(MyTreeView.Items.Count) do
    begin
      if MyTreeView.Items[i].Text = 'Банзай' then
        break;
    end;

...если вам не дорого время обработки массива узлов.

Значительно быстрее будет так:

    Noddy := MyTreeView.Items[0];
    Searching := true;
    while (Searching) and (Noddy <> nil) do
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

В моей системе приведенный выше код показал скорость 33 милисекунды при
работе с деревом, имеющим 171 узел. Первый поиск потребовал 2.15 секунд.

Оказывается, процесс индексирования очень медленный. Я подозреваю, что
при каждой индексации свойства Items, вы осуществляете линейный поиск,
но это нигде не засвидетельствовано, поэтому я могу ошибаться.

Вам действительно не нужно просматривать все дерево, чтобы найти что вам
нужно - получить таким образом доступ к MyTreeView.Items[170] займет
много больше времени, чем получения доступа к MyTreeView.Items[1].

Как правило, для отслеживания позиции в дереве TreeView, нужно
использовать временную переменную TTreeNode, а не использовать
целочисленные индексы. Возможно, свойство ItemId как раз и необходимо
для такого применения, но, к сожалению, я никак не могу понять абзац в
электронной документации, касающийся данного свойства:

   "Свойство ItemId является дескриптором TTreeNode типа HTreeItem 

   и однозначно идентифицирует каждый элемент дерева. Используйте

   это свойство, если вам необходимо получить доступ к элементам

   дерева из внешнего по отношению к TreeView элемента управления."

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
