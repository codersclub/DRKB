---
Title: Как заставить форму не разворачиваться из иконки?
Date: 01.01.2007
---

Как заставить форму не разворачиваться из иконки?
=================================================

::: {.date}
01.01.2007
:::

    procedure WMQueryOpen(var Msg: TWMQueryOpen);
      message WM_QUERYOPEN;
     
    // ... и ее реализация
    procedure TMainForm.WMQueryOpen(var Msg: TWMQueryOpen);
    begin
      Msg.Result := 0;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
