Как установить фокус на документе в TWebBrowser?
================================================

::: {.date}
01.01.2007
:::

WebBrowser1.SetFocus ставит фокус на компонент TWebBrowser, а это не
всегда то, что нужно. Если нужно поставить фокус на документ в
TWebBrowser\'е (чтобы, например, кнопки вверх/вниз скроллировали
документ, а не ставили фокус на другой компонент), то можно использовать
этот код:

    uses ActiveX; 
     
    with WebBrowser1 do 
     if Document <> nil then 
       with Application as IOleobject do 
         DoVerb(OLEIVERB_UIACTIVATE, nil, WebBrowser1, 0, Handle, 
           GetClientRect); 

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
