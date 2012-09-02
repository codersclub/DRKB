<h1>How to add alternative text to a Webbrowser image?</h1>
<div class="date">01.01.2007</div>


<pre>
{ Alternative Text for a image of a TWebBrowser }
 
procedure TForm1.Button1Click(Sender: TObject);
var
  HTMLDocument2Ifc: IHTMLDocument2;
  HTMLSelectionObjectIfc: IHTMLSelectionObject;
  HTMLTxtRangeIfc: IHTMLTxtRange;
begin
  HTMLDocument2Ifc := WebBrowser1.Document as IHTMLDocument2;
  HTMLDocument2Ifc.execCommand('InsertImage', False, '');
  HTMLSelectionObjectIfc := HTMLDocument2Ifc.selection;
  if HTMLSelectionObjectIfc.type_ = 'Control' then HTMLSelectionObjectIfc.Clear;
  HTMLTxtRangeIfc := HTMLSelectionObjectIfc.createRange as IHTMLTxtRange;
  HTMLTxtRangeIfc.pasteHTML('&lt;image alt="Hello" src="c:\test.gif"&gt; ');
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
