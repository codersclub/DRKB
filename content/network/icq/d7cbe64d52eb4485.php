<h1>Как послать сообщение?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  You need 3 TEdits, 1 TMemo and 1 TClientSocket. 
  Set the  TClientsocket's Port to 80 and the Host to wwp.mirabilis.com. 
} 
 
var 
  Form1: TForm1; 
  csend: string; 
 
implementation 
 
{$R *.dfm} 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  cSend := 'POST http://wwp.icq.com/scripts/WWPMsg.dll HTTP/2.0' + chr(13) + chr(10); 
  cSend := cSend + 'Referer: http://wwp.mirabilis.com' + chr(13) + chr(10); 
  cSend := cSend + 'User-Agent: Mozilla/4.06 (Win95; I)' + chr(13) + chr(10); 
  cSend := cSend + 'Connection: Keep-Alive' + chr(13) + chr(10); 
  cSend := cSend + 'Host: wwp.mirabilis.com:80' + chr(13) + chr(10); 
  cSend := cSend + 'Content-type: application/x-www-form-urlencoded' + chr(13) + chr(10); 
  cSend := cSend + 'Content-length:8000' + chr(13) + chr(10); 
  cSend := cSend + 'Accept: image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*' + 
    chr(13) + chr(10) + chr(13) + chr(10); 
  cSend := cSend + 'from=' + edit1.Text + ' &amp;fromemail=' + edit2.Text + 
    ' &amp;fromicq:110206786' + ' &amp;body=' + memo1.Text + ' &amp;to=' + edit3.Text + '&amp;Send='; 
  clientsocket1.Active := True; 
end; 
 
procedure TForm1.ClientSocket1Connect(Sender: TObject; 
  Socket: TCustomWinSocket); 
begin 
  clientsocket1.Socket.SendText(csend); 
  clientsocket1.Active := False; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
