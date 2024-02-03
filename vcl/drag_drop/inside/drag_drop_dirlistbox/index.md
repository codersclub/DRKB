---
Title: Drag & Drop - как использовать ItemAtPos для получения элемента DirListBox
Date: 01.01.2007
---


Drag & Drop - как использовать ItemAtPos для получения элемента DirListBox
===========================================================================

::: {.date}
01.01.2007
:::

Просто сохраните результат функции ItematPos в переменной формы, и затем
используйте эту переменную в обработчике ListBoxDragDrop. Пример:

    FDragItem := ItematPos(X, Y, True);
    if FDragItem >= 0 then
      BeginDrag(false);
    ...
     
    procedure TForm1.ListBoxDragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      if Source is TDirectoryListBox then
        ListBox.Items.Add(TDirectoryListBox(Source).GetItemPath(FDragItem));
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
