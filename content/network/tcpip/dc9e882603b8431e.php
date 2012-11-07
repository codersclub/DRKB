<h1>Как узнать IP-адрес?</h1>
<div class="date">01.01.2007</div>


<p>HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\Class\NetTrans\ (для 98-винды)</p>
<p>   Ищем параметр IPAddress</p>
<p>   Программно можно определить следующим образом:</p>

<pre>
var
  WSAData: TWSAData;
  p: PHostEnt;
  Name: array[0..$FF] of Char;
begin
  WSAStartup($0101, WSAData);
  GetHostName(name, $FF);
  p := GetHostByName(Name);
  showmessage(inet_ntoa(PInAddr(p.h_addr_list^)^));
  WSACleanup;
end;
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
