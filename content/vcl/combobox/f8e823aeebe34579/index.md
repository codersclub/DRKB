---
Title: Как можно отменить реакию ComboBox на F4?
Author: Vit
Date: 01.01.2007
---


Как можно отменить реакию ComboBox на F4?
=========================================

::: {.date}
01.01.2007
:::

    procedure TForm1.ComboBox1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);

    begin
    if key=vk_F4 then key:=0;
    end; 

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
