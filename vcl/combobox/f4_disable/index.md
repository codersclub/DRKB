---
Title: Как можно отменить реакию ComboBox на F4?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как можно отменить реакию ComboBox на F4?
=========================================

    procedure TForm1.ComboBox1KeyDown(Sender: TObject;
              var Key: Word;
              Shift: TShiftState);
    begin
      if key=vk_F4 then key:=0;
    end; 

