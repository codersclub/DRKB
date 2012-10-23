<h1>Как получить TextRange страницы без фреймов?</h1>
<div class="date">01.01.2007</div>


<pre>
HTML_Doc := WebBrowser1.Document As IHTMLDocument2;
Window := HTML_Doc.parentWindow As IHTMLWindow2;
Body := HTML_Doc.get_body As IHTMLBodyElement;
Range := oBody.createTextRange;
</pre>
<p>Можно еще так:</p>
<pre>
var
a:IHTMLTxtRange;
a:=IHTMLDocument2(webbrowser1.Document).selection.createRange as IHTMLTxtRange;
</pre>

<div class="author">Автор: Good Man</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
