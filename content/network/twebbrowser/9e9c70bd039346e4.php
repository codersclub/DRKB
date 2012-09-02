<h1>Как загрузить строковые данные в TWebBrowser, не прибегая к открытию файла?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm </p>

<p>Загрузите строку массив Variant, а затем запишите в документ (Document): </p>

<pre>
...
var
  v: Variant;
  HTMLDocument: IHTMLDocument2;
begin
  HTMLDocument := WebBrowser1.Document as IHTMLDocument2;
  v := VarArrayCreate([0, 0], varVariant);
  v[0] := HTMLString; // Это Ваша HTML строка
  HTMLDocument.Write(PSafeArray(TVarData(v).VArray));
  HTMLDocument.Close; ...
end;
...
</pre>

