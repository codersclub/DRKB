---
Title: Как производить печать?
Date: 01.01.2007
---


Как производить печать?
=======================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

Есть два способа вывода на печать. Первый пример работает в IE 4.x и
выше,

в то время как второй пример расчитан на IE 3.x:

    var
    vaIn, vaOut: OleVariant; 
     
    ... WebBrowser.ControlInterface.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER, vaIn, vaOut); либо 
     
    procedure TForm1.PrintIE;
    var
    CmdTarget : IOleCommandTarget;
    vaIn, vaOut: OleVariant;
    begin
    if WebBrowser1.Document < > nil then
    try
    WebBrowser1.Document.QueryInterface(IOleCommandTarget, CmdTarget);
    if CmdTarget < > nil then
    try
      CmdTarget.Exec( PGuid(nil), OLECMDID_PRINT,
      OLECMDEXECOPT_DONTPROMPTUSER, vaIn, vaOut);
    finally
      CmdTarget._Release;
    end;
    except
      // Ничего
    end;
    end;

Обратите внимание: Если версия Delphi ниже чем 3.02, то необходимо
заменить PGuid(nil) на PGuid(nil)^.
А лучше всего проапгрейдить до 3.02 (если Вы пользуетесь версиями 3.0
или 3.01).
