---
Title: Как скопировать страницу?
Date: 01.01.2007
---


Как скопировать страницу?
=========================

::: {.date}
01.01.2007
:::

    { ... }
    var
      After: OleVariant;
      Sh: _Worksheet;
    begin
      Sh := Excel.Worksheets['Sheet1'] as _Worksheet;
      After := Excel.Workbooks[1].Sheets[3];
      Sh.Copy(EmptyParam, After, lcid);
      { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
