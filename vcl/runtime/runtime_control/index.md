---
Title: Как создать контрол в runtime?
Author: Fantasist
Date: 01.01.2007
---


Как создать контрол в runtime?
==============================

::: {.date}
01.01.2007
:::

    var Butt:TButton;

    begin
      Butt:=TButton.Create(Self);
      Butt.Parent:=self;
      Butt.Visible:=true;
    end;

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>
