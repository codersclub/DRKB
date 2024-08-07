---
Title: Копировать узлы с поддеревом TTreeView во второй TTreeView
Author: P. Below
Date: 09.04.2003
Source: <https://www.swissdelphicenter.ch>
---


Копировать узлы с поддеревом TTreeView во второй TTreeView
==========================================================

    {type
    {: Callback to use to copy the data of a treenode when the 
       node itself is copied by CopySubtree. 
       @param oldnode is the old node 
       @param newnode is the new node 
       @Desc Use a callback of this type to implement your own algorithm 
             for a node copy. The default just uses the Assign method, which 
             produces a shallow copy of the nodes Data property. }
       TCopyDataProc = procedure(oldnode, newnode : TTreenode);
     
    {: The default operation is to do a shallow copy of the node, via 
       Assign. }
    procedure DefaultCopyDataProc(oldnode, newnode : TTreenode);
    begin
      newnode.Assign(oldnode);
    end;
     
    {-- CopySubtree 
    -------------------------------------------------------}
    {: Copies the source node with all child nodes to the target treeview. 
    @Param sourcenode is the node to copy 
    @Param target is the treeview to insert the copied nodes into 
    @Param targetnode is the node to insert the copy under, can be nil to 
      make the copy a top-level node. 
    @Param CopyProc is the (optional) callback to use to copy a node. 
      If Nil is passed for this parameter theDefaultCopyDataProc will be 
      used. 
    @Precondition  sourcenode <> nil, target <> nil, targetnode is either 
      nil or a node of target 
    @Raises Exception if targetnode happens to be in the subtree rooted in 
      sourcenode. Handling that special case is rather complicated, so we 
      simply refuse to do it at the moment. 
    }
    { Created 2003-04-09 by P. Below
    -----------------------------------------------------------------------}
    procedure CopySubtree(sourcenode : TTreenode; target : TTreeview;
      targetnode : TTreenode; CopyProc : TCopyDataProc = nil);
    var
      anchor : TTreenode;
      child : TTreenode;
    begin { CopySubtree }
      Assert(Assigned(sourcenode),
        'CopySubtree:sourcenode cannot be nil');
      Assert(Assigned(target),
        'CopySubtree: target treeview cannot be nil');
      Assert((targetnode = nil) or (targetnode.TreeView = target),
        'CopySubtree: targetnode has to be a node in the target treeview.');
    
      if (sourcenode.TreeView = target) and
        (targetnode.HasAsParent(sourcenode) or
        (sourcenode = targetnode)) then
        raise
          Exception.Create('CopySubtree cannot copy a subtree to one of the ' +
            'subtrees nodes.');
    
      if not Assigned(CopyProc) then
        CopyProc := DefaultCopyDataProc;
    
      anchor := target.Items.AddChild(targetnode, sourcenode.Text);
      CopyProc(sourcenode, anchor);
      child := sourcenode.GetFirstChild;
      while Assigned(child) do
      begin
        CopySubtree(child, target, anchor, CopyProc);
        child := child.getNextSibling;
      end; { While }
    end; { CopySubtree }
    
    
    procedure TForm1.Button1Click(Sender : TObject);
    begin
      if assigned(treeview1.selected) then
        CopySubtree(treeview1.selected, treeview2, nil);
    end;

