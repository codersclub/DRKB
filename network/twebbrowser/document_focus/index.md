---
Title: Как установить фокус на документе в TWebBrowser?
Author: p0s0l
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как установить фокус на документе в TWebBrowser?
================================================

`WebBrowser1.SetFocus` ставит фокус на компонент TWebBrowser, а это не
всегда то, что нужно.

Если нужно поставить фокус на документ в
TWebBrowser\'е (чтобы, например, кнопки вверх/вниз скроллировали
документ, а не ставили фокус на другой компонент), то можно использовать
этот код:

    uses ActiveX; 
     
    with WebBrowser1 do 
     if Document <> nil then 
       with Application as IOleobject do 
         DoVerb(OLEIVERB_UIACTIVATE, nil, WebBrowser1, 0, Handle, 
           GetClientRect); 

