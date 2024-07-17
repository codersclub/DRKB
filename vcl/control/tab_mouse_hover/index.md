---
Title: Над какой закладкой курсор в TTabControl
Author: YoungHacker
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Над какой закладкой курсор в TTabControl
========================================

Получение позиции мышиного курсора для TabControl - над какой закладкой
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


