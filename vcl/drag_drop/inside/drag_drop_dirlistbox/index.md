---
Title: Drag & Drop - как использовать ItemAtPos для получения элемента DirListBox
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Drag & Drop - как использовать ItemAtPos для получения элемента DirListBox
===========================================================================

Просто сохраните результат функции ItematPos в переменной формы, и затем
используйте эту переменную в обработчике ListBoxDragDrop.

Пример:

    FDragItem := ItematPos(X, Y, True);
    if FDragItem >= 0 then
      BeginDrag(false);
    ...
     
    procedure TForm1.ListBoxDragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      if Source is TDirectoryListBox then
        ListBox.Items.Add(TDirectoryListBox(Source).GetItemPath(FDragItem));
    end;


