<h1>Как получить текст HTML-документа из TWebBrowser без тегов</h1>
<div class="date">01.01.2007</div>


<pre>
uses mshtml, activex;
 
procedure GetHtmlCode(WebBrowser: TWebBrowser; FileName: string);
var
 htmlDoc: IHtmlDocument2;
 PersistFile: IPersistFile;
begin
 htmlDoc := WebBrowser.document as IHtmlDocument2;
 PersistFile := HTMLDoc as IPersistFile;
 PersistFile.save(StringToOleStr(FileName), true);
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<hr />
<pre>
var
  Document: IHTMLDocument2;
begin
 Document := WB.Document as IHtmlDocument2;
 if Document &lt; &gt;  nil then
   Memo1.Text := (Document.all.Item(NULL, 0) as IHTMLElement).OuterHTML;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
