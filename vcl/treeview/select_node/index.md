---
Title: Выделять узел TTreeView правой кнопкой мыши
Date: 01.01.2007
---


Выделять узел TTreeView правой кнопкой мыши
===========================================

::: {.date}
01.01.2007
:::

    procedure TForm1.TreeView1ContextPopup(Sender: TObject; MousePos: TPoint;
       var Handled: Boolean);
     var
       tmpNode: TTreeNode;
     begin
       tmpNode := (Sender as TTreeView).GetNodeAt(MousePos.X, MousePos.Y);
       if tmpNode <> nil then
         TTreeView(Sender).Selected := tmpNode;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
