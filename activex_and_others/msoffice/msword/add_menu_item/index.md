---
Title: Как вставить свой пункт меню?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как вставить свой пункт меню?
=============================


    { ... }
    var
      CBar: CommandBar;
      MenuItem: OleVariant;
      { ... }
     
    { Add an item to the File menu }
      CBar := Word.CommandBars['File'];
      MenuItem := CBar.Controls.Add(msoControlButton, EmptyParam, EmptyParam,
        EmptyParam, True) as CommandBarButton;
      MenuItem.Caption := 'NewMenuItem';
      MenuItem.DescriptionText := 'Does nothing';
    {Note that a VB macro with the right name must exist before you assign it to the item!}
      MenuItem.OnAction := 'VBMacroName';
    { ... }

