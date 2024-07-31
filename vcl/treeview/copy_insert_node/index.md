---
Title: Как копировать и вставлять TreeNode?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как копировать и вставлять TreeNode?
====================================

    var
      SL : TStringList;
    
    procedure TForm1.CutBtnClick(Sender: TObject);
    var
      i, j, StartLevel : integer;
      TNSel : TTreeNode;
    begin
      TNSel := TreeView1.Selected;
      if TNSel <> nil then begin
        StartLevel := TNSel.Level;
        i := TNSel.AbsoluteIndex;
        j := i; // note for later deletion
        if SL = nil then
          SL := TStringList.Create
        else
          SL.Clear;
        SL.AddObject(TNSel.Text, pointer(0));
        inc(i);
        with TreeView1 do begin
          while Items[i].Level > StartLevel do begin
            {stop before next sibling to top node}
            SL.AddObject(Items[i].Text, pointer(Items[i].Level - StartLevel));
            inc(i);
          end; {while Items[i].Level > StartLevel}
          Items[j].Delete;
        end; {with TreeView1}
      end; {if TNSel <> nil}
    end;
    
    procedure TForm1.PasteBtnClick(Sender: TObject);
    var
      i, Level : integer;
      TNSel, TN : TTreeNode;
    begin
      with TreeView1 do begin
        TNSel := Selected;
        if TNSel <> nil then begin
          TN := Items.Insert(TNSel, SL.Strings[0]);
          Level := integer(SL.Objects[0]); // should be 0
          for i := 1 to SL.Count - 1 do begin
            if integer(SL.Objects[i]) < Level then begin
              {go up one level}
              TN := TN.Parent;
              Level := integer(SL.Objects[i]);
            end; {if integer(SL.Objects[i]) < Level}
            if Level = integer(SL.Objects[i]) then
              {same level}
              TN := Items.Add(TN, SL.Strings[i])
            else begin
              {go down one level}
              TN := Items.AddChild(TN, SL.Strings[i]);
              Level := integer(SL.Objects[i]);
            end; {if Level = integer(SL.Objects[i])}
          end; {for i := 1 to SL.Count - 1}
        end; {if TNSel <> nil}
      end; {with TreeView1}
    end;

