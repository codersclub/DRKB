<h1>Как найти и выделить текст TWebBrowser?</h1>
<div class="date">01.01.2007</div>


<pre>
{....}
 
private
  procedure SearchAndHighlightText(aText: string);
 
{....}
 
uses mshtml;
 
{ .... }
 
 
procedure TForm1.SearchAndHighlightText(aText: string);
var
  tr: IHTMLTxtRange; //TextRange Object
begin
  if not WebBrowser1.Busy then
  begin
    tr := ((WebBrowser1.Document as IHTMLDocument2).body as IHTMLBodyElement).createTextRange;
    //Get a body with IHTMLDocument2 Interface and then a TextRang obj. with IHTMLBodyElement Intf.
 
    while tr.findText(aText, 1, 0) do //while we have result
    begin
      tr.pasteHTML('&lt;span style="background-color: Lime; font-weight: bolder;"&gt;' +
        tr.htmlText + '&lt;/span&gt;');
      //Set the highlight, now background color will be Lime
      tr.scrollIntoView(True);
      //When IE find a match, we ask to scroll the window... you dont need this...
    end;
  end;
end;
 
// Example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  SearchAndHighlightText('delphi');
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
