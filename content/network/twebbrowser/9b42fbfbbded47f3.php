<h1>Как сделать TWebBrowser плоским вместо 3D?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>

<p>Следующий пример устанавливает borderStyle:</p>
<pre>
procedure TForm1.WBDocumentComplete(Sender: TObject;
  const pDisp: IDispatch; var URL: OleVariant);
var
  Doc : IHTMLDocument2;
  Element : IHTMLElement;
begin
Doc := IHTMLDocument2(TWebBrowser(Sender).Document);
if Doc = nil then Exit;
Element := Doc.body;
if Element = nil then Exit;
case Make_Flat of
TRUE : Element.style.borderStyle := 'none';
FALSE : Element.style.borderStyle := '';
end;
end;
</pre>


<div class="author">Автор: Donovan J. Edye </div>
