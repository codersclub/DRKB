---
Title: Рекурсивные механизмы спуска по дереву
Date: 01.01.2007
---


Рекурсивные механизмы спуска по дереву
======================================

::: {.date}
01.01.2007
:::

Нужно использовать рекурсивные механизмы спуска по дереву и иметь метод
определения наличия child узлов у текущего узла.

    function  TDBTreeView.RecurseChilds(node: TTreeNode): double;
    begin
      while node <> nil do begin
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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
