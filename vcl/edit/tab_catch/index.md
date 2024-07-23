---
Title: Как перехватить клавишу табуляции (Tab) в TEdit?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как перехватить клавишу табуляции (Tab) в TEdit?
================================================

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

