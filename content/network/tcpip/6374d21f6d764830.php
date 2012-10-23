<h1>Преобразуем доменное имя в IP адрес</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Lutfi Baran</div>
<p>Описывается функция, которая показывает, как вычислить IP адрес компьютера в интернете по его доменному имени.</p>
<p>Совместимость: Delphi 3.x (или выше)</p>
<p>Объявляем Winsock, для использования в функции </p>
<pre>
function HostToIP(Name: string; var Ip: string): Boolean; 
var 
  wsdata : TWSAData; 
  hostName : array [0..255] of char; 
  hostEnt : PHostEnt; 
  addr : PChar; 
begin 
  WSAStartup ($0101, wsdata); 
  try 
    gethostname (hostName, sizeof (hostName)); 
    StrPCopy(hostName, Name); 
    hostEnt := gethostbyname (hostName); 
    if Assigned (hostEnt) then 
      if Assigned (hostEnt^.h_addr_list) then begin 
        addr := hostEnt^.h_addr_list^; 
        if Assigned (addr) then begin 
          IP := Format ('%d.%d.%d.%d', [byte (addr [0]), 
          byte (addr [1]), byte (addr [2]), byte (addr [3])]); 
          Result := True; 
        end 
        else 
          Result := False; 
      end 
      else 
        Result := False 
    else begin 
      Result := False; 
    end; 
  finally 
    WSACleanup; 
  end 
end; 
</pre>
<p>Вы можете разметстить на форме EditBox, Кнопку и Label и добавить к кнопке следующий обработчик события OnClick: </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
IP: string; 
begin 
if HostToIp(Edit1.Text, IP) then Label1.Caption := IP; 
 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
