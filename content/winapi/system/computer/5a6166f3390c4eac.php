<h1>Как узнать имя компьютера?</h1>
<div class="date">01.01.2007</div>


<pre>
Function ReadComputerName:string;

 
var
i:DWORD; 
p:PChar;
begin
i:=255;
GetMem(p, i);
GetComputerName(p, i);
Result:=String(p);
FreeMem(p);
end;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Получение локального имени компьютера
 
Зависимости: Winsock
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Gua
Дата:        23 июля 2002 г.
***************************************************** }
 
function GetLocalName: string;
var
  WSAData: TWSAData;
  Namebuf: array[0..255] of char;
begin
  WSAStartup($101, WSAData);
  GetHostname(namebuf, sizeof(namebuf));
  Result := NameBuf;
  WSACleanup;
end;
 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
