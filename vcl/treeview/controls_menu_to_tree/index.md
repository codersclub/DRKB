---
Title: Поместить список контролов и пунктов меню в TTreeView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Поместить список контролов и пунктов меню в TTreeView
=====================================================

    uses
      ComCtrls, Menus, Classes, Forms, Controls, Windows, Messages;
     
    function GetControlCaption(Control: TWinControl): ShortString;
      //  Slightly modified version of Twister's Tip 
      // 
      //  function GetCaptionAtPoint(pt: TPoint): string; 
      // 
    var
      TextLength: Integer;
      Text: PChar;
    begin
      if not Boolean(Control.Handle) then Exit;
    
      Result := Control.Name;  //  if Control doesn't have Caption 
      //  Control.Name is returned 
     
      TextLength := SendMessage(Control.Handle, WM_GETTEXTLENGTH, 0, 0);
      if TextLength  0 then
      begin
        GetMem(Text, TextLength + 1);
        SendMessage(Control.Handle, WM_GETTEXT, TextLength + 1, Integer(Text));
        Result := Text;
        FreeMem(Text);
      end;
    end;
    
    //  function GetCaptionAtPoint(pt: TPoint): ShortString; 
    //  begin 
    //    Result:= GetControlCaption(FindVCLWindow(pt)); 
    //  end; 
     
     
    procedure FindAllMenuItems(AppTree: TTreeView; MenuItem: TMenuItem; Parent: TTreeNode);
    var
      loop: Integer;
      Node: TTreeNode;
      mItem: TMenuItem;
      Name: ShortString;
    begin
      for loop := 0 to MenuItem.Count - 1 do
      begin
        mItem := MenuItem.Items[loop];
        Name  := mItem.Caption;
        Node  := AppTree.Items.AddChildObject(Parent, Name, mItem);
        if mItem.Count  0 then findAllMenuItems(AppTree, mItem, Node);
      end;
    end;
    
    procedure FindAllControls(AppTree: TTreeView; Comp: TComponent; Parent: TTreeNode);
    var
      Child: TComponent;
      loop, start, Index: Integer;
      Name: ShortString;
      Node, Mnode: TTreeNode;
    begin
      start := 0;
      if Comp is TApplication then
      begin
        // Parent:= AppTree.Items.AddObjectFirst(Parent, 'Application', nil); 
       //  if you want to see the root ('Application') uncomment 
       start := 1;
      end;
    
      for loop := start to Comp.ComponentCount - 1 do
      begin
        Child := Comp.Components[loop];
        Name  := Child.Name;
    
        if Child is TControl then
        begin
          if Child is TWinControl then
          begin  //  does Child have Caption property?? 
           Name := GetControlCaption(TWinControl(Child));
          end;
          Node := AppTree.Items.AddChildObject(Parent, Name, Child);
          if Child.ComponentCount  0 then FindAllControls(AppTree, Child, Node);
        end;
    
        if Child is TMenu then
        begin
          Node := AppTree.Items.AddChildObject(Parent, Name, Child);
          for Index := 0 to TMenu(Child).Items.Count - 1 do
          begin
            Mnode := AppTree.Items.AddChildObject(Node, TMenu(Child).Items[Index].Caption,
              TMenu(Child).Items[Index]);
            FindAllMenuItems(AppTree, TMenu(Child).Items[Index], Mnode);
          end;
        end;
      end;
    end;

