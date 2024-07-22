---
Title: Drag & Drop в TTreeView
Date: 01.01.2007
---


Drag & Drop в TTreeView
=======================

Вариант 1:

Author: Smike

Source: <https://forum.sources.ru>

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      ComCtrls;
     
    type
      TForm1 = class(TForm)
        TreeView1: TTreeView;
        procedure TreeView1DragDrop(Sender, Source: TObject; X, Y: Integer);
        procedure TreeView1DragOver(Sender, Source: TObject; X, Y: Integer;
          State: TDragState; var Accept: Boolean);
      private
        procedure MoveNode(TargetNode, SourceNode: TTreeNode);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.MoveNode(TargetNode, SourceNode: TTreeNode);
    var
      NodeTmp: TTreeNode;
      I: Integer;
    begin
      with TreeView1 do
      begin
        // проверяем, является ли целевой элемент предком перетаскиваемого
        NodeTmp := TargetNode.Parent;
        while Assigned(NodeTmp) do
          if NodeTmp = SourceNode then
            Abort
          else
            NodeTmp := NodeTmp.Parent;
     
        // копируем перетаскиваемый элемент в новосозданный
        NodeTmp := Items.AddChild(TargetNode, SourceNode.Text);
        NodeTmp.Data := SourceNode.Data;
     
        for I := 0 to SourceNode.Count - 1 do
          MoveNode(NodeTmp, SourceNode.Item[I]);
     
        Selected := NodeTmp;
        TopItem := NodeTmp.getPrev;
        TargetNode.Expand(True);
      end;
    end;
     
    procedure TForm1.TreeView1DragDrop(Sender, Source: TObject; X, Y: Integer);
    var
      TargetNode, SourceNode: TTreeNode;
    begin
      with TreeView1 do
      begin
        TargetNode := GetNodeAt(X, Y);
        SourceNode := Selected;
     
        if (TargetNode = SourceNode) or (TargetNode = nil) then
        begin
          EndDrag(False);
          Exit;
        end;
        MoveNode(TargetNode, SourceNode);
        SourceNode.Free;
      end;
    end;
     
    procedure TForm1.TreeView1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    var
      SourceNode, TargetNode, NodeTmp: TTreeNode;
    begin
      if Sender = TreeView1 then
      try
        // скроллинг дерева при перетаскивании
        if Y > TreeView1.Height - 10 then
        begin
          TreeView1.TopItem := TreeView1.TopItem.getNext;
          Sleep(100); // пауза
        end else
          if Y < 10 then
          begin
            TreeView1.TopItem := TreeView1.TopItem.getPrev;
            Sleep(100); // пауза
          end;
     
        TargetNode := TreeView1.GetNodeAt(X, Y);
        SourceNode := TreeView1.Selected;
     
        if (TargetNode = nil) or (TargetNode = SourceNode) then Abort;
     
        Accept := True;
        // проверяем, является ли целевой элемент предком перетаскиваемого
        NodeTmp := TargetNode.Parent;
        while Assigned(NodeTmp) do
          if NodeTmp = SourceNode then
            Abort
          else
            NodeTmp := NodeTmp.Parent;
      except
        Accept := False;
      end;
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    unit Unit1;
     
     interface
     
     uses
       Windows, Messages, SysUtils, Variants, Classes, Controls, Forms,
       Dialogs, StdCtrls, ComCtrls;
     
     type
       TForm1 = class(TForm)
         TreeView1: TTreeView;
         Label1: TLabel;
         procedure TreeView1DragDrop(Sender, Source: TObject; X, Y: Integer);
         procedure TreeView1DragOver(Sender, Source: TObject; X, Y: Integer;
           State: TDragState; var Accept: Boolean);
       private
         { Private declarations }
         Procedure MoveNode(TargetNode, SourceNode : TTreeNode);
       public
         { Public declarations }
       end;
     
     var
       Form1: TForm1;
     
     implementation
     
     {$R *.dfm}
     
     // 
    // Procedure which will move node and its subnodes 
    // 
    Procedure TForm1.MoveNode(TargetNode, SourceNode : TTreeNode);
     var
       nodeTmp : TTreeNode;
       i : Integer;
     begin
       with TreeView1 do
       begin
         nodeTmp := Items.AddChild(TargetNode,SourceNode.Text);
         for i := 0 to SourceNode.Count -1 do
         begin
           MoveNode(nodeTmp,SourceNode.Item[i]);
         end;
       end;
     end;
     
     
     procedure TForm1.TreeView1DragDrop(Sender, Source: TObject; X, Y: Integer);
     var
       TargetNode, SourceNode : TTreeNode;
     begin
       with TreeView1 do
       begin
         TargetNode := GetNodeAt(X,Y); // Get target node 
        SourceNode := Selected;
         if (TargetNode = nil) then
         begin
           EndDrag(False);
           Exit;
         end;
         MoveNode(TargetNode,SourceNode);
         SourceNode.Free;
       end;
     end;
     
     procedure TForm1.TreeView1DragOver(Sender, Source: TObject; X, Y: Integer;
       State: TDragState; var Accept: Boolean);
     begin
       if (Sender = TreeView1) then // If TRUE than accept the draged item 
      begin
         Accept := True;
       end;
     end;
     
     end.

