---
Title: Как TListView перевести в режим редактирования по нажатию на F2
Date: 01.01.2007
---


Как TListView перевести в режим редактирования по нажатию на F2
===============================================================

::: {.date}
01.01.2007
:::

    procedure TForm1.ListView1KeyDown(Sender: TObject;
      var Key: Word; Shift: TShiftState);
    begin
      if Ord(Key) = VK_F2 then
        ListView1.Selected.EditCaption;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
