---
Title: Как заставить форму не разворачиваться из иконки?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Как заставить форму не разворачиваться из иконки?
=================================================

    procedure WMQueryOpen(var Msg: TWMQueryOpen); message WM_QUERYOPEN;
     
    // ... и ее реализация
    procedure TMainForm.WMQueryOpen(var Msg: TWMQueryOpen);
    begin
      Msg.Result := 0;
    end;


