---
Title: Ускорить удаление элементов из TListView
Date: 01.01.2007
---


Ускорить удаление элементов из TListView
========================================

::: {.date}
01.01.2007
:::

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

Взято с сайта: <https://www.swissdelphicenter.ch>
