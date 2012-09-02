<h1>Как использовать протокол about?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm </p>

<pre>
procedure TForm1.LoadHTMLString(sHTML: String);
var
  Flags, TargetFrameName, PostData, Headers: OleVariant;
begin
  WebBrowser1.Navigate('about:' + sHTML, Flags, TargetFrameName, PostData, Headers)
end; 
</pre>

