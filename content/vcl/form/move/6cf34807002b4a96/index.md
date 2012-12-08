---
Title: Как прикрепить свою форму к другому приложению?
Date: 01.01.2007
---


Как прикрепить свою форму к другому приложению?
===============================================

::: {.date}
01.01.2007
:::

Для этого Вам понадобится переопределить процедуру CreateParams у
желаемой формы. А в ней установить params.WndParent в дескриптор окна, к
которому Вы хотите прикрепить форму.

    ... = class(TForm) 
      ... 
      protected 
        procedure CreateParams( var params: TCreateParams ); override; 
    ... 
     
    procedure TForm2.Createparams(var params: TCreateParams); 
    var 
       aHWnd : HWND; 
    begin 
      inherited; 
    {как-нибудь получаем существующий дескриптор}
      ahWnd := GetForegroundWindow; 
    {а теперь:}
      params.WndParent := ahWnd; 
    end; 

Взято из <https://forum.sources.ru>
