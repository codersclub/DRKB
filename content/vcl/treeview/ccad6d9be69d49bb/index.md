---
Title: В TreeView текущий Node выделяется другим шрифтом
Date: 01.01.2007
---


В TreeView текущий Node выделяется другим шрифтом
=================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.TreeView1CustomDrawItem(Sender: TCustomTreeView;
    Node: TTreeNode; State: TCustomDrawState; var DefaultDraw: Boolean);
    begin
      if cdsSelected in State then
        Sender.Canvas.Font.Style := Sender.Canvas.Font.Style + [fsUnderline];
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
