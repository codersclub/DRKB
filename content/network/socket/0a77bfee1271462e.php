<h1>Использование WSAAsyncSelect в DLL</h1>
<div class="date">01.01.2007</div>


<p>Что нужно давать WSAAsyncSelect в качестве параметра handle если тот запускается и используется в dll (init) и никакой формы (у которой можно было бы взять этот handle) в этом dll не создается. Что бы такого сделать чтобы работало?</p>

<pre>
const
 WM_ASYNCSELECT = WM_USER+0;
type
 TNetConnectionsManager = class(TObject)
protected
 FWndHandle : HWND;
 procedure WndProc( var MsgRec : TMessage );
 ...
end;
 
constructor TNetConnectionsManager.Create
begin
 inherited Create;
 FWndHandle := AllocateHWnd(WndProc);
 ...
end;
 
destructor TNetConnectionsManager.Destroy;
begin
 ...
 if FWndHandle&lt;&gt;0 then DeallocateHWnd(FWndHandle);
 inherited Destroy;
end;
 
procedure TNetConnectionsManeger.WndProc( var MsgRec : TMessage );
begin
 with MsgRec do
   if Msg=WM_ASYNCSELECT then
     WMAsyncSelect(MsgRec)
   else
     DefWindowProc( FWndHandle, Msg, wParam, lParam );
end;
</pre>


<p>Hо pекомендую посмотpеть WinSock2, в котоpом можно:</p>

<p>WSAEventSelect( FSocket, FEventHandle, FD_READ or FD_CLOSE );</p>
<p>WSAWaitForMultipleEvents( ... );</p>
<p>WSAEnumNetworkEvents( FSocket, FEventHandle, lpNetWorkEvents );</p>

<p>То есть, обойтись без окон и без очеpеди сообщений windows, а заодно иметь возможность pаботать и с IPX/SPX, и с netbios.</p>
<p>Свой winsock2.pas я вчеpа кинул в RU.DELPHI.DB, если кто имеет такой из дpугих источников - свистните погpомче.</p>

<div class="author">Автор: Alex Konshin</div>
<p>alexk@msmt.spb.su</p>
<p>(2:5030/217)</p>

<div class="author">Автор: StayAtHome</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

