---
Title: Как скопировать страницу?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как скопировать страницу?
=========================

    { ... }
    var
      After: OleVariant;
      Sh: _Worksheet;
    begin
      Sh := Excel.Worksheets['Sheet1'] as _Worksheet;
      After := Excel.Workbooks[1].Sheets[3];
      Sh.Copy(EmptyParam, After, lcid);
      { ... }

