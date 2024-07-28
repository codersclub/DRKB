---
Title: Прокрутка для TListView или TTreeView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Прокрутка для TListView или TTreeView
=====================================

    // KEYWORDS:  SendMessage, WM_HSCROLL, WM_VSCROLL
     
    // scroll a ListView vertically down
    SendMessage(ListView1->Handle, WM_VSCROLL, SB_LINEDOWN, 0);
     
    // scroll a TreeView vertically up
    SendMessage(TreeView1->Handle, WM_VSCROLL, SB_LINEUP, 0);
     
    // Here are some other scroll parameters that can be sent...
     
    {
    SB_BOTTOM      Scrolls to the lower right.
    SB_ENDSCROLL   Ends scroll.
    SB_LINEDOWN    Scrolls one line down.
    SB_LINEUP      Scrolls one line up.
    SB_PAGEDOWN    Scrolls one page down.
    SB_PAGEUP      Scrolls one page up.
    SB_TOP         Scrolls to the upper left.
    }
     

