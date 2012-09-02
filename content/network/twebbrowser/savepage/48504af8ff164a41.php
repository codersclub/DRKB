<h1>Как получить полный исходник HTML?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm </p>

<p>В IE5, можно получить исходник используя свойство outerHTML тэгов</p>
<p>HTML. В IE4 или IE3, Вам понадобится записать документ в файл, а затем</p>
<p>загрузить файл в TMemo, TStrings, и т.д. </p>
<pre>
var
  HTMLDocument: IHTMLDocument2;
  PersistFile: IPersistFile;
begin
...
  HTMLDocument := WebBrowser1.Document as IHTMLDocument2;
  PersistFile := HTMLDocument as IPersistFile;
  PersistFile.Save(StringToOleStr('test.htm'), True); 
  while HTMLDocument.readyState &lt; &gt; 'complete' do
    Application.ProcessMessages;
...
end;
</pre>


<p class="author">Автор: Ron Loewy Обратите внимание: Вам понадобится импортировать библиотеку</p>
<p>MSHTML и добавить MSHTML_TLB как ActiveX, в секцию Uses. </p>
