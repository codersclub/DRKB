---
Title: Прокручивать TTreeView во время перемещения
Date: 01.01.2007
---


Прокручивать TTreeView во время перемещения
===========================================

::: {.date}
01.01.2007
:::

    procedure TForm1.TreeView1DragOver(Sender, Source: TObject; X, Y: Integer;
       State: TDragState; var Accept: Boolean);
     begin
       if (y < 15) then {On the upper edge - should scroll up }
         SendMessage(TreeView1.Handle, WM_VSCROLL, SB_LINEUP, 0)
       else if (TreeView1.Height - y < 15) then { On the lower edge - should scroll down }
         SendMessage(TreeView1.Handle, WM_VSCROLL, SB_LINEDOWN, 0);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
