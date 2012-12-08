---
Title: Как перехватить клавишу табуляции (Tab) в TEdit?
Date: 01.01.2007
---


Как перехватить клавишу табуляции (Tab) в TEdit?
================================================

::: {.date}
01.01.2007
:::

Это можно давольно легко сделать переопределив на форме процедуру
CMDialogKey. Чтобы посмотреть как это работает, поместите на форму Edit
и введите следующий код:

    procedure CMDialogKey(Var Msg: TWMKey); 
    message CM_DIALOGKEY;
    ...
    procedure TForma.CMDialogKey(Var Msg: TWMKEY);
    begin
      if (ActiveControl is TEdit) and
               (Msg.Charcode = VK_TAB) then
      begin
       ShowMessage('Нажата клавиша TAB?');
      end;
      inherited;
    end;

Взято из <https://forum.sources.ru>
