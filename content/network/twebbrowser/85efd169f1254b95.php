<h1>Как загрузить HTML-код непосредственно в TWebBrowser?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ActiveX; 
 
procedure WB_LoadHTML(WebBrowser: TWebBrowser; HTMLCode: string); 
var 
  sl: TStringList; 
  ms: TMemoryStream; 
begin 
  WebBrowser.Navigate('about:blank'); 
  while WebBrowser.ReadyState &lt; READYSTATE_INTERACTIVE do 
   Application.ProcessMessages; 
 
  if Assigned(WebBrowser.Document) then 
  begin 
    sl := TStringList.Create; 
    try 
      ms := TMemoryStream.Create; 
      try 
        sl.Text := HTMLCode; 
        sl.SaveToStream(ms); 
        ms.Seek(0, 0); 
        (WebBrowser.Document as IPersistStreamInit).Load(TStreamAdapter.Create(ms)); 
      finally 
        ms.Free; 
      end; 
    finally 
      sl.Free; 
    end; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  WB_LoadHTML(WebBrowser1,'SwissDelphiCenter'); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
