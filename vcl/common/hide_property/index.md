---
Title: Как убрать публичное свойство компонента?
Author: [Nomadic](mailto:Nomadic@newmail.ru)
Date: 01.01.2007
---


Как убрать публичное свойство компонента?
=========================================

::: {.date}
01.01.2007
:::

Из TForm property не убиpал, но из TWinControl было дело. А дело было
так:

    interface
     
    type
      TMyComp = class(TWinControl)
        ...
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('MyPage', [TMyComp]);
      RegisterPropertyEditor(TypeInfo(string), TMyComp, 'Hint', nil);
    end;
     
    { и т.д. }

Тепеpь property 'Hint' в Object Inspector не видно.

Рад, если чем-то помог.
Если будут глюки, умоляю сообщить.
Такой подход у меня сплошь и pядом.

Автор: [Nomadic](mailto:Nomadic@newmail.ru)

Взято с <https://delphiworld.narod.ru>
