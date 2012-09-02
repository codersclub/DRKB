<h1>Как по IP адресу получить Hostname (и обратно)?</h1>
<div class="date">01.01.2007</div>


<pre>
function TGenericNetTask.GetPeerOrigin( const ALogin : String ) : DWORD;
const AddressStrMaxLen = 256;
var len : DWORD;
       ptr : PChar;
       pHE : PHostEnt;
       addr : TSockAddr;
       buf : Array [0..AddressStrMaxLen-1] of Char;
begin
   if FNet=nil then raise ESocketError.Error(-1,ClassName+'.GetPeerAds: Net is
not defined',WSAHOST_NOT_FOUND);
   len := SizeOf(TSockAddr);
   if getpeername(FSocket,addr,len)&lt;&gt;0 then
RaiseLastSocketError(-1,ClassName+'.GetPeerAds: getpeername()');
   case addr.sin_family of
   AF_INET: // TCP/IP
 
       begin
           pHE := gethostbyaddr( PChar(@addr.sin_addr), SizeOf(TInAddr),
AF_INET );
           if pHE=nil then RaiseLastSocketError(-1,ClassName+'.GetPeerAds:
gethostbyaddr()');
           FPeerNodeName := pHE^.h_name;
           if FNet.NodeByName(FPeerNodeName)=nil then
           begin
               ptr := StrScan(pHE^.h_name,'.');
               if ptr&lt;&gt;nil then FPeerNodeName :=
Copy(pHE^.h_name,1,ptr-pHE^.h_name);
           end;
       end;
 
   else
       len := AddressStrMaxLen;
       if WSAAddressToStringA(sin,sinlen,nil,buf,len)&lt;&gt;0 then
RaiseLastSocketError(-1,ClassName+'.GetPeerAds: WSAAddressToStringA()');
       ptr := StrRScan(buf,':');
       if ptr&lt;&gt;nil then len := ptr-buf;
       FPeerNodeName := Copy(buf,1,len);
   end;
   Result :=
FNet.EncodeAddress(ALogin,FPeerNodeName,'',[bLoginIdRequired,bNodeIdREquired,bR
aiseError]);
end; {TGenericNetTask.GetPeerOrigin}
</pre>


<p>Alex Konshin</p>
<p>mailto:alexk@msmt.spb.su"</p>
<p>(2:5030/217)</p>

<p class="author">Автор: StayAtHome</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

