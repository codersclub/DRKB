<h1>Как реализовать Drag &amp; Drop в TTreeView?</h1>
<div class="date">01.01.2007</div>

Автор: Васильев Василий </p>
<pre>
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
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
