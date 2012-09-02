<h1>Как проверить является ли текущее соединение в TWebBrowser secure (SSL)?</h1>
<div class="date">01.01.2007</div>


<pre>
// You need a TWebbrowser, a TLabel 
 
procedure TForm1.WebBrowser1DocumentComplete(Sender: TObject; 
  const pDisp: IDispatch; var URL: OleVariant); 
begin 
  if Webbrowser1.Oleobject.Document.Location.Protocol = 'https:' then 
    label1.Caption := 'Sichere Verbindung' 
  else 
    label1.Caption := 'Unsichere Verbindung' 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
