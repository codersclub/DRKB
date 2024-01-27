---
Title: Как узнать существует ли страница (worksheet)?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как узнать существует ли страница (worksheet)?
==============================================

    { ... }
    WB := Excel.Workbooks[1];
    for Idx := 1 to WB.Worksheets.Count do
      if WB.Worksheets[Idx].Name = 'first' then
        Showmessage('Found the worksheet');
    { ... }

