---
Title: Как прикрепить свою форму к другому приложению?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как прикрепить свою форму к другому приложению?
===============================================

Для этого вам понадобится переопределить процедуру CreateParams у
желаемой формы. А в ней установить `params.WndParent` в дескриптор окна, к
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

