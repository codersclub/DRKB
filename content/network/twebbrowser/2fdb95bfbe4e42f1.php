<h1>Как установить фокус на документе в TWebBrowser?</h1>
<div class="date">01.01.2007</div>


<p>WebBrowser1.SetFocus ставит фокус на компонент TWebBrowser, а это не всегда то, что нужно. Если нужно поставить фокус на документ в TWebBrowser'е (чтобы, например, кнопки вверх/вниз скроллировали документ, а не ставили фокус на другой компонент), то можно использовать этот код:</p>
<pre>
uses ActiveX; 
 
with WebBrowser1 do 
 if Document &lt;&gt; nil then 
   with Application as IOleobject do 
     DoVerb(OLEIVERB_UIACTIVATE, nil, WebBrowser1, 0, Handle, 
       GetClientRect); 
</pre>

<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
