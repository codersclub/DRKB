---
Title: Прокрутка TreeView, чтобы держать выделение посередине
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Прокрутка TreeView, чтобы держать выделение посередине
======================================================

    procedure TMyForm.TreeChange(Sender: TObject; Node: TTreeNode);
    var
      i : integer;
      pp, cp : TTreeNode;
    begin
      if Assigned(Tree.Selected) then
        begin
          cp := Tree.Selected;
          pp := cp;
          for i := 1 to Round(Tree.Height/30) do
            if cp <> nil then
              begin
                pp := cp;
                cp := cp.GetPrevVisible;
              end;
          Tree.TopItem := pp;
        end;
    end;

