<h1>Как загрузить потоковые (stream) данные в TWebBrowser, не прибегая к открытию файла?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm </p>

<pre>
function TForm1.LoadFromStream(const AStream: TStream): HRESULT;
begin
AStream.seek(0, 0);
Result := (WebBrowser1.Document as IPersistStreamInit).Load(TStreamAdapter.Create(AStream));
end;
</pre>


<p class="author">Автор: Per Larsen </p>

<p class="note">Примечание от Vit</p>

<p>1. В Uses добавить ActiveX</p>
<p>2. Если в TWebBrowser ничего не загружено то код выдаёт Access Violation</p>
<p>Исправляется следующим образом:</p>
<pre>
function TForm1.LoadFromStream(const AStream: TStream): HRESULT;

begin
  AStream.seek(0, soFromBeginning);
  WebBrowser1.Navigate('about:blank');
  Result := (WebBrowser1.Document as      IPersistStreamInit).Load(TStreamAdapter.Create(AStream));
end;
</pre>


<p class="author">Автор: Vit</p>

