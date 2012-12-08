---
Title: Над какой закладкой курсор в TTabControl
Author: YoungHacker
Date: 01.01.2007
---


Над какой закладкой курсор в TTabControl
========================================

::: {.date}
01.01.2007
:::

Автор: YoungHacker

Получение позиции мышиного курсора для TabControl над какой закладкой
находится курсор.

    function Form1.ItemAtPos(TabControlHandle : HWND; X, Y : Integer) : Integer;
    var
      HitTestInfo : TTCHitTestInfo;
      HitIndex : Integer;
    begin
      HitTestInfo.pt.x := X;
      HitTestInfo.pt.y := Y;
      HitTestInfo.flags := 0;
      HitIndex := SendMessage(TabControlHandle, TCM_HITTEST, 0, Longint(@HitTestInfo));
      Result := HitIndex;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
