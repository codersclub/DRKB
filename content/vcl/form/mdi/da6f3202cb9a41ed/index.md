---
Title: Как спрятать окна MDI Child?
Date: 01.01.2007
---


Как спрятать окна MDI Child?
============================

::: {.date}
01.01.2007
:::

    procedure TCustomForm.VisibleChanging;
    begin
      if (FormStyle = fsMDIChild) and Visible then
        raise EInvalidOperation.Create(SMDIChildNotVisible);
    end;

Взято с <https://delphiworld.narod.ru>
