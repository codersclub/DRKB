---
Title: Перебор всех компонентов на форме
Author: Vit
Date: 01.01.2007
---


Перебор всех компонентов на форме
=================================

::: {.date}
01.01.2007
:::

Например, надо найти все TCheckBox на форме и установить из все в
положение checked:

    var i: integer;
    begin

     
      for i := 0 to ComponentCount - 1 do
        if Components[i] is TCheckBox then
          (Components[i] as TCheckBox).Checked := true;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
