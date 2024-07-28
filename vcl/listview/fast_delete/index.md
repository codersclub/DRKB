---
Title: Ускорить удаление элементов из TListView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Ускорить удаление элементов из TListView
========================================

    procedure AddNewListViewItems;
    var
      oldViewStyle: TViewStyle;
    begin
      odlViewStyle := ListView1.ViewStyle;
      ListView1.ViewStyle := vsList;
      ListView1.Items.Clear;
      { Add new Listitems here }
      { An dieser werden die neuen ListItems eingefugt }
      ListView1.ViewStyle := oldViewStyle;
    end;

