---
Title: Как имитировать появление формы как нового приложения?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как имитировать появление формы как нового приложения?
======================================================

> Как я могу создать форму, и эта форма останется в другом значке на панели задач?
> (Похоже на новое приложение).

В разделе private:

    type
      TForm1 = class(TForm)
      private
        { Private declarations }
        procedure CreateParams(var Params: TCreateParams); override;

И в секции implementation:

    procedure TForm1.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      with params do
        ExStyle := ExStyle or WS_EX_APPWINDOW;
    end;

