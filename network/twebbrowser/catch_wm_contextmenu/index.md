---
Title: Перехватить WM\_CONTEXTMENU в TWebBrowser
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
ID: 03472
---


Перехватить WM\_CONTEXTMENU в TWebBrowser
=========================================

Перехват меню (ТОЛЬКО БЛОКИРОВКА):

    var
     HookID: THandle;
     
    function MouseProc(nCode: Integer; wParam, lParam: Longint): Longint; stdcall; 
    var 
     szClassName: array[0..255] of Char; 
    const 
     ie_name = 'Internet Explorer_Server'; 
    begin 
     case nCode < 0 of 
       True: 
         Result := CallNextHookEx(HookID, nCode, wParam, lParam) 
         else 
           case wParam of 
             WM_RBUTTONDOWN, 
             WM_RBUTTONUP: 
               begin 
                 GetClassName(PMOUSEHOOKSTRUCT(lParam)^.HWND, szClassName, SizeOf(szClassName)); 
                 if lstrcmp(@szClassName[0], @ie_name[1]) = 0 then 
                   Result := HC_SKIP 
                 else 
                   Result := CallNextHookEx(HookID, nCode, wParam, lParam); 
               end 
               else 
                 Result := CallNextHookEx(HookID, nCode, wParam, lParam); 
           end; 
     end; 
    end; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
     HookID := SetWindowsHookEx(WH_MOUSE, MouseProc, 0, GetCurrentThreadId()); 
    end; 
     
    procedure TForm1.FormDestroy(Sender: TObject); 
    begin 
     if HookID <> 0 then 
       UnHookWindowsHookEx(HookID); 
    end; 

Здесь по замыслу автора меню подменяется своим, но у меня не сработало
(почему, не  разбирался):

    // Для преобразования кликов правой кнопкой в клики левой,  раскомментировать
     
    // {$DEFINE __R_TO_L}
     
    implementation
     
    uses Windows,Controls,Messages,ShDocVw;
     
    var
     HMouseHook:THandle;
     
    function MouseProc(
       nCode: Integer;     // hook code
       WP: wParam; // message identifier
       LP: lParam  // mouse coordinates
      ):Integer;stdcall;
    var MHS:TMOUSEHOOKSTRUCT;
       WC:TWinControl;
    {$ifdef __R_TO_L}
       P:TPoint;
    {$endif}
    begin
     Result:=CallNextHookEx(HMouseHook,nCode,WP,LP);
     if nCode=HC_ACTION then
      begin
        MHS:=PMOUSEHOOKSTRUCT(LP)^;
        if ((WP=WM_RBUTTONDOWN) or (WP=WM_RBUTTONUP)) then
         begin
           WC:=FindVCLWindow(MHS.pt);
           if (WC is TWebBrowser) then
           begin
             Result:=1;
    {$ifdef __R_TO_L}
             P:=WC.ScreenToClient(MHS.pt);
             if WP=WM_RBUTTONDOWN 
             then PostMessage(MHS.hwnd,WM_LBUTTONDOWN,0,P.x + P.y shl 16);
     
             if WP=WM_RBUTTONUP 
             then PostMessage(MHS.hwnd,WM_LBUTTONUP,0,P.x + P.y shl 16);
    {$endif}
             if (TWebBrowser(WC).PopupMenu<>nil) and  (WP=WM_RBUTTONUP) then
              begin
               TWebBrowser(WC).PopupMenu.PopupComponent:=WC;
               TWebBrowser(WC).PopupMenu.Popup(MHS.pt.x,MHS.pt.y);
              end;
           end;
         end;
      end;
    end;
     
    initialization
     
     
    HMouseHook:=SetWindowsHookEx(WH_MOUSE,@MouseProc,HInstance,GetCurrentThreadID);
     
    finalization
     
     CloseHandle(HMouseHook);
     
    end.

Предлагаю свой вариант, взято с Королевства, но немного переделано из-за
глюкавости. Для использования достаточно подключить юнит в Uses и все
(Исправлены глюки, которые досаждали)!

    unit WbPopup;
     
    interface
     
    implementation
     
    uses Windows,Controls,Messages,ShDocVw, Forms, frmMain;
     
    var
     HMouseHook:THandle;
     Pop: Boolean;
     
    function MouseProc(
       nCode: Integer;     // hook code
       WP: wParam; // message identifier
       LP: lParam  // mouse coordinates
      ):Integer;stdcall;
    var MHS:TMOUSEHOOKSTRUCT;
       WC:TWinControl;
    begin
     Result:=CallNextHookEx(HMouseHook,nCode,WP,LP);
     if nCode=HC_ACTION then
      begin
        MHS:=PMOUSEHOOKSTRUCT(LP)^;
        if ((WP=WM_RBUTTONDOWN) or (WP=WM_RBUTTONUP)) then
         begin
           WC:=FindVCLWindow(MHS.pt);
           if (WC is TWebBrowser) then
           begin
             Result:=1;
             if (TWebBrowser(WC).PopupMenu<>nil) and (WP=WM_RBUTTONUP) then
              begin
               if Pop then Exit;
               Pop := True;
               TWebBrowser(WC).PopupMenu.Popup(MHS.pt.x,MHS.pt.y);
               Pop := False;
              end;
           end;
         end;
      end;
    end;
     
    initialization
     
     
    HMouseHook:=SetWindowsHookEx(WH_MOUSE,@MouseProc,HInstance,GetCurrentThreadID);
     
    finalization
    try
     UnhookWindowsHookEx(HMouseHook);
     Sleep(100);
     CloseHandle(HMouseHook);
    except
     
    end;
    end.

