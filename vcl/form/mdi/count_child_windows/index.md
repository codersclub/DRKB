---
Title: Сколько открыто дочерних окон?
Date: 01.01.2007
---


Сколько открыто дочерних окон?
==============================

::: {.date}
01.01.2007
:::

    Form1.MDIChildCount

Закрыть все окна:

    with Form1 do  
      For i := MDIChildCount-1 DownTo 0 Do
          if Assigned(MDIChildren[i]) then
          begin
            MDIChildren[i].Close;
          end;

Взято с <https://delphiworld.narod.ru>

Исправлено Bose

Взято с Vingrad.ru <https://forum.vingrad.ru>
