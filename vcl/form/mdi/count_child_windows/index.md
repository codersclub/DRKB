---
Title: Сколько открыто дочерних окон?
Author: Bose
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Сколько открыто дочерних окон?
==============================

Можно использовать `Form1.MDIChildCount`.

Закрыть все окна:

    with Form1 do  
      For i := MDIChildCount-1 DownTo 0 Do
          if Assigned(MDIChildren[i]) then
          begin
            MDIChildren[i].Close;
          end;

[Исправлено Bose]
