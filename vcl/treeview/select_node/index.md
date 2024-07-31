---
Title: Выделять узел TTreeView правой кнопкой мыши
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Выделять узел TTreeView правой кнопкой мыши
===========================================

    procedure TForm1.TreeView1ContextPopup(Sender: TObject; MousePos: TPoint;
      var Handled: Boolean);
    var
      tmpNode: TTreeNode;
    begin
      tmpNode := (Sender as TTreeView).GetNodeAt(MousePos.X, MousePos.Y);
      if tmpNode <> nil then
        TTreeView(Sender).Selected := tmpNode;
    end;

