<h1>Получить или установить задний фон в TWebBrowser</h1>
<div class="date">01.01.2007</div>


<pre>
//You need a TWebbrowser and 3 TButtons 
 
// First load a page 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  WebBrowser1.Navigate('www.SwissDelphiCenter.com'); 
end; 
 
// Show the background color 
// Hintergrundfarbe herausfinden 
procedure TForm1.Button2Click(Sender: TObject); 
begin 
  ShowMessage(WebBrowser1.OleObject.Document.bgColor); 
end; 
 
// Set the background color 
procedure TForm1.Button3Click(Sender: TObject); 
begin 
  WebBrowser1.OleObject.Document.bgColor := '#000000'; 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
