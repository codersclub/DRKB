---
Title: Проверить, развернут ли или свернут полностью TTreeView
Date: 01.01.2007
---


Проверить, развернут ли или свернут полностью TTreeView
=======================================================

::: {.date}
01.01.2007
:::

    function IsTreeviewFullyExpanded(tv: TTreeview): Boolean;
     var
       Node: TTreeNode;
     begin
       Assert(Assigned(tv));
       if tv.Items.Count > 0 then
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
       if tv.Items.Count > 0 then
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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
