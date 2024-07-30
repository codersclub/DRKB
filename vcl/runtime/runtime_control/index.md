---
Title: Как создать контрол в runtime?
Author: Fantasist
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как создать контрол в runtime?
==============================

    var Butt:TButton;

    begin
      Butt:=TButton.Create(Self);
      Butt.Parent:=self;
      Butt.Visible:=true;
    end;
