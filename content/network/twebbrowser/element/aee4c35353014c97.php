<h1>Как добраться до конкретного фрейма?</h1>
<div class="date">01.01.2007</div>


<pre>
var
 
  HTML_Doc: IHTMLDocument2;
  Window: IHTMLWindow2;
  oRange1: variant;
  name_frame: OleVariant;
 
  HTML_Doc := WebBrowser1.Document as IHTMLDocument2;
  Window := HTML_Doc.parentWindow as IHTMLWindow2;
  name_frame := 'mainFrame';
  oRange1 := Window.frames.item(name_frame).document.body.createTextRange;
</pre>
<p class="author">Автор ответа: Good Man</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
