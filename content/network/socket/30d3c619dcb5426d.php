<h1>Определить, занят ли порт сокета</h1>
<div class="date">01.01.2007</div>


<pre>
var SockAddrIn : TSockAddrIn;
    FSocket    : TSocket;
 
  ...
 
  If  bind(FSocket, SockAddrIn, SizeOf(SockAddrIn)) &lt;&gt; 0 Then
  begin
    обрабатываем WSAGetLastError
  end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
