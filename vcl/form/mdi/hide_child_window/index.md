---
Title: Как спрятать окна MDI Child?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как спрятать окна MDI Child?
============================

    procedure TCustomForm.VisibleChanging;
    begin
      if (FormStyle = fsMDIChild) and Visible then
        raise EInvalidOperation.Create(SMDIChildNotVisible);
    end;

