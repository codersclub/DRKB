---
Title: Использование WSAAsyncSelect в DLL
Author: Alex Konshin
Date: 01.01.2007
---


Использование WSAAsyncSelect в DLL
==================================

::: {.date}
01.01.2007
:::

Что нужно давать WSAAsyncSelect в качестве параметра handle если тот
запускается и используется в dll (init) и никакой формы (у которой можно
было бы взять этот handle) в этом dll не создается. Что бы такого
сделать чтобы работало?

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
     if FWndHandle<>0 then DeallocateHWnd(FWndHandle);
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

Hо pекомендую посмотpеть WinSock2, в котоpом можно:

WSAEventSelect( FSocket, FEventHandle, FD\_READ or FD\_CLOSE );

WSAWaitForMultipleEvents( ... );

WSAEnumNetworkEvents( FSocket, FEventHandle, lpNetWorkEvents );

То есть, обойтись без окон и без очеpеди сообщений windows, а заодно
иметь возможность pаботать и с IPX/SPX, и с netbios.

Свой winsock2.pas я вчеpа кинул в RU.DELPHI.DB, если кто имеет такой из
дpугих источников - свистните погpомче.

Автор: Alex Konshin

alexk\@msmt.spb.su

(2:5030/217)

Автор: StayAtHome

Взято с Vingrad.ru <https://forum.vingrad.ru>
