---
Title: Как реализовать Drag & Drop в TTreeView?
Author: Васильев Василий
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как реализовать Drag & Drop в TTreeView?
========================================

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
        procedure MoveNode(TargetNode, SourceNode: TTreeNode);
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
     
    procedure TForm1.MoveNode(TargetNode, SourceNode: TTreeNode);
    var
      nodeTmp: TTreeNode;
      i: Integer;
    begin
      with TreeView1 do
      begin
        nodeTmp := Items.AddChild(TargetNode, SourceNode.Text);
        for i := 0 to SourceNode.Count - 1 do
        begin
          MoveNode(nodeTmp, SourceNode.Item[i]);
        end;
      end;
    end;
     
    procedure TForm1.TreeView1DragDrop(Sender, Source: TObject; X, Y: Integer);
    var
      TargetNode, SourceNode: TTreeNode;
    begin
      with TreeView1 do
      begin
        TargetNode := GetNodeAt(X, Y); // Get target node
        SourceNode := Selected;
        if (TargetNode = nil) then
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
    begin
      if (Sender = TreeView1) then // If TRUE than accept the draged item
      begin
        Accept := True;
      end;
    end;
     
    end.

