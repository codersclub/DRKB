---
Title: Как TListView перевести в режим редактирования по нажатию на F2
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как TListView перевести в режим редактирования по нажатию на F2
===============================================================

    procedure TForm1.ListView1KeyDown(Sender: TObject;
      var Key: Word; Shift: TShiftState);
    begin
      if Ord(Key) = VK_F2 then
        ListView1.Selected.EditCaption;
    end;


