<h1>Как вычислить IP-адрес по доменному имени?</h1>
<div class="date">01.01.2007</div>


<pre>
uses winsock 
------- 
function IPAddrToName(IPAddr : String): String; 
var 
  SockAddrIn: TSockAddrIn; 
  HostEnt: PHostEnt; 
  WSAData: TWSAData; 
begin 
  WSAStartup($101, WSAData); 
  SockAddrIn.sin_addr.s_addr:= inet_addr(PChar(IPAddr)); 
  HostEnt:= gethostbyaddr(@SockAddrIn.sin_addr.S_addr, 4, AF_INET); 
  if HostEnt&lt;&gt;nil then 
  begin 
    result:=StrPas(Hostent^.h_name) 
  end 
  else 
  begin 
    result:=''; 
  end; 
end; 
</pre>
<p>Пример использования:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Label1.Caption:=IPAddrToName(Edit1.Text); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
