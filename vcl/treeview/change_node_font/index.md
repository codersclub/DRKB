---
Title: В TreeView текущий Node выделяется другим шрифтом
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


В TreeView текущий Node выделяется другим шрифтом
=================================================

    procedure TForm1.TreeView1CustomDrawItem(Sender: TCustomTreeView;
      Node: TTreeNode; State: TCustomDrawState; var DefaultDraw: Boolean);
    begin
      if cdsSelected in State then
        Sender.Canvas.Font.Style := Sender.Canvas.Font.Style + [fsUnderline];
    end;

