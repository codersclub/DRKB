---
Title: Доступ к ScrollBars от TTreeView
Date: 01.01.2007
---


Доступ к ScrollBars от TTreeView
================================

    with treeview do begin
      perform( WM_HSCROLL, SB_LINERIGHT, 0 );
      perform( WM_HSCROLL, SB_ENDSCROLL, 0 );
    end;
