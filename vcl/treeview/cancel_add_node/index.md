---
Title: Отмена вставки нового узла в TreeView по нажатию кнопки Esc
Date: 01.01.2007
---


Отмена вставки нового узла в TreeView по нажатию кнопки Esc
===========================================================

    unit BetterTreeView;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ComCtrls, CommCtrl;
     
    type
      TTVNewEditCancelEvent = procedure( Sender: TObject;
        Node: TTreeNode; var Delete: Boolean) of object;
      TBetterTreeView = class(TTreeView)
      protected
        FIsEditingNew: Boolean;
        FOnEditCancel: TTVChangedEvent;
     
        FOnNewEditCancel: TTVNewEditCancelEvent;
        procedure Edit(const Item: TTVItem); override;
      public
        function NewChildAndEdit(Node: TTreeNode; const S: String)
          : TTreeNode;
      published
        property IsEditingNew: Boolean read FIsEditingNew;
        property OnEditCancel: TTVChangedEvent
          read FOnEditCancel write FOnEditCancel;
        property OnNewEditCancel: TTVNewEditCancelEvent
          read FOnNewEditCancel write FOnNewEditCancel;
      end;
     
    implementation
     
    procedure TBetterTreeView.Edit(const Item: TTVItem);
    var
      Node: TTreeNode;
      Action: Boolean;
    begin
      with Item do begin
        { Get the node }
        if (state and TVIF_PARAM) <> 0 then
          Node := Pointer(lParam)
        else
          Node := Items.GetNode(hItem);
     
        if pszText = nil then begin
          if FIsEditingNew then begin
            Action := True;
            if Assigned(FOnNewEditCancel) then
              FOnNewEditCancel(Self, Node, Action);
            if Action then
     
              Node.Destroy
          end
          else
            if Assigned(FOnEditCancel) then
              FOnEditCancel(Self, Node);
        end
        else
          fFinherited;
      end;
      FIsEditingNew := False;
    end;
     
    function TBetterTreeView.NewChildAndEdit
      (Node: TTreeNode; const S: String): TTreeNode;
    begin
      SetFocus;
      Result := Items.AddChild(Node, S);
      FIsEditingNew := True;
      Node.Expand(False);
      Result.EditText;
      SetFocus;
    end;
     
    end.
