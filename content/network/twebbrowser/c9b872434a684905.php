<h1>Как перевести TWebBrowser в режим редактирования (дизайна)?</h1>
<div class="date">01.01.2007</div>


<pre>
{
  You can use the designMode property to put the Webbrowser
  into a mode where you can edit the current document.
}
 
uses
  MSHTML_TLB;
 
procedure TForm1.WebBrowser1DocumentComplete(Sender: TObject;
  const pDisp: IDispatch; var URL: OleVariant);
var
  CurrentWB: IWebBrowser;
begin
  CurrentWB := pDisp as IWebBrowser;
  (CurrentWB.Document as IHTMLDocument2).DesignMode := 'On';
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  WebBrowser1.Navigate('http://wp.netscape.com/assist/net_sites/example1-F.html')
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
