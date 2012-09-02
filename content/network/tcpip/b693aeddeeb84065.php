<h1>Как узнать IP клиента и IP сервера для активного RAS-подключения?</h1>
<div class="date">01.01.2007</div>


<pre>
uses Ras, RasError;
 

 
type
 TRASIP = record
   dwSize: DWORD;
   dwError: DWORD;
   szIpAddress: packed array[0..RAS_MaxIpAddress] of AnsiChar;
   szServerIpAddress: packed array[0..RAS_MaxIpAddress] of AnsiChar;
 end;
 
procedure GetDialUpIpAddress(var server, client: string);
var
 RASPppIp: TRASIP;
 lpcp: DWORD;
 ConnClientIP: array[0..RAS_MaxIpAddress] of Char;
 ConnServerIP: array[0..RAS_MaxIpAddress] of Char;
 
 Entries: PRasConn;
 BufSize, NumberOfEntries, Res: DWORD;
 RasConnHandle: THRasConn;
begin
 New(Entries);
 BufSize := Sizeof(Entries^);
 ZeroMemory(Entries, BufSize);
 Entries^.dwSize := Sizeof(Entries^);
 
 Res := RasEnumConnections(Entries, BufSize, NumberOfEntries);
 if Res = ERROR_BUFFER_TOO_SMALL then
 begin
   ReallocMem(Entries, BufSize); 
   ZeroMemory(Entries, BufSize); 
   Entries^.dwSize := Sizeof(Entries^); 
   Res := RasEnumConnections(Entries, BufSize, NumberOfEntries); 
 end; 
 try 
   if (Res = 0) and (NumberOfEntries &gt; 0) then RasConnHandle := Entries.hrasconn else exit
 finally 
   FreeMem(Entries); 
 end; 
 
 FillChar(RASPppIp, SizeOf(RASPppIp), 0);
 RASPppIp.dwSize := SizeOf(RASPppIp);
 lpcp := RASPppIp.dwSize;
 if RasGetProjectionInfo(RasConnHandle,
   RASP_PppIp, @RasPppIp, lpcp) = 0 then
 begin
 
   Move(RASPppIp.szServerIpAddress,
     ConnServerIP,
     SizeOf(ConnServerIP));
   Server := ConnServerIP;
   Move(RASPppIp.szIpAddress,
     ConnClientIP,
     SizeOf(ConnClientIP));
   client := ConnClientIP;
 end;
end;
</pre>

<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
