---
Title: Убрать ScrollBars от TTreeView
Date: 01.01.2007
---


Убрать ScrollBars от TTreeView
==============================

::: {.date}
01.01.2007
:::

    uses CommCtrl;
    procedure tNoScrollbarsTreeview.createparams(var params: TCreateParams);
    begin
      inherited;
      params.style := params.style or TVS_NOSCROLL;
    end;
