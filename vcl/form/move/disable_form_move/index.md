---
Title: Как запретить перемещение формы?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как запретить перемещение формы?
================================

    type
      TyourForm = class(TForm)
      private
        { Private declarations }
        procedure WMNCHitTest(var Message: TWMNCHitTest); message WM_NCHITTEST;
      end;
     
    procedure TyourForm.WMNCHitTest(var Message: TWMNCHitTest);
    begin
      inherited;
     
      with Message do
        if Result = HTCAPTION then
          Result := HTNOWHERE;
    end;

