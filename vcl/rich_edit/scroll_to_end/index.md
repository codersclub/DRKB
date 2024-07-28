---
Title: Как прокрутить TRichEdit в конец?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как прокрутить TRichEdit в конец?
=================================

Существует множество способов, включая и:

    with MainFrm.RichEdit1 do 
    begin 
      perform (WM_VSCROLL, SB_BOTTOM, 0); 
      perform (WM_VSCROLL, SB_PAGEUP, 0); 
    end; 

Вышеприведенный пример работает отлично в 9x и NT4, но не работает в
Windows 2000. Поэтому предлагаю воспользоваться следующим примером:

    with MainFrm.RichEdit1 do 
    begin 
      SelStart := Length(Text); 
      Perform(EM_SCROLLCARET, 0, 0); 
    end;

