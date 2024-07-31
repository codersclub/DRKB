---
Title: Отображаются ли полосы прокрутки для TStringGrid?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Отображаются ли полосы прокрутки для TStringGrid?
=================================================

    if (GetWindowlong(Stringgrid1.Handle, GWL_STYLE) and WS_VSCROLL) <> 0 then
       ShowMessage('Vertical scrollbar is visible!');
     
     if (GetWindowlong(Stringgrid1.Handle, GWL_STYLE) and WS_HSCROLL) <> 0 then
       ShowMessage('Horizontal scrollbar is visible!');

