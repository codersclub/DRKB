<h1>Create a TWebBrowser at runtime?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
 wb: TWebBrowser;
begin
  wb := TWebBrowser.Create(Form1);
  TWinControl(wb).Name := 'MyWebBrowser';
  TWinControl(wb).Parent := Form1;
  wb.Align := alClient;
  // TWinControl(wb).Parent := TabSheet1; ( To put it on a TabSheet )
  wb.Navigate('http://www.swissdelphicenter.ch');
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
