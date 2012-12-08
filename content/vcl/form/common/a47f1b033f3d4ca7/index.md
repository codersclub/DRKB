---
Title: Как имитировать появление формы как нового приложения?
Date: 01.01.2007
---


Как имитировать появление формы как нового приложения?
======================================================

::: {.date}
01.01.2007
:::

How i can create a form and this form stay in another icon in task bar ?
(Looks like a new aplication).

In private clause:

    type
      TForm1 = class(TForm)
      private
        { Private declarations }
        procedure CreateParams(var Params: TCreateParams); override;

And, in the implementation:

    procedure TForm1.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      with params do
        ExStyle := ExStyle or WS_EX_APPWINDOW;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
