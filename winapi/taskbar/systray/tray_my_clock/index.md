---
Title: Делаем свои часы в трее
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Делаем свои часы в трее
=======================

    uses
      windows, messages, ShellAPI;
     
    const
     ClassName = 'MyClockWndClass';
     
    var
     hTrayClock,Window:hWnd;
     idTM:cardinal;
     
    function SysDateToStr: string;
    const
      sDateFmt = 'dddd, d MMMM yyyy';
    var
     ST : TSystemTime;
    begin
     GetLocalTime(ST);
     SetLength(Result, MAX_PATH);
     GetDateFormat(LOCALE_USER_DEFAULT,0, @ST,pchar(sDateFmt), @Result[1], MAX_PATH);
    end;
     
    function SysTimeToStr:string;
    const
       sTimeFmt = 'HH:mm';
    var
     ST : TSystemTime;
    begin
     GetLocalTime(ST);
     SetLength(Result,15);
     GetTimeFormat(LOCALE_USER_DEFAULT,0,@st,sTimeFmt,@Result[1],15);
    end;
     
    procedure TimerProc(wnd:HWND;uMsg,idEvent,dwTime:UINT);stdcall;
    begin
     InvalidateRect(wnd,nil,true);
    end;
     
     
    procedure RecalcWndPos;
    var
     r:TRect;
     X,Y:integer;
    begin
     X:=GetSystemMetrics(SM_CXDLGFRAME);
     Y:=GetSystemMetrics(SM_CYDLGFRAME);
     GetWindowRect(hTrayClock,r);
     SetWindowPos(Window,0,r.Left+X,r.Top+Y, r.Right-r.Left,r.Bottom-r.Top-Y,0);
    end;
     
    function AppWndProc(wnd: HWND; uMsg:DWORD; wParam: WPARAM; lParam: LPARAM): Longint; stdcall;
    var
      DC      : HDC;
      ps      :TPaintStruct;
      pt      :TPoint;
      r       :TRect;
      Cmd     : LongBool;
      hm:HMenu;
    begin
      Result := 0;
    case uMsg of
     
     WM_SETTINGCHANGE: if wParam=SPI_SETWORKAREA then RecalcWndPos;
     WM_PAINT:
        begin
         DC:=BeginPaint(wnd,ps);
         GetClientRect(wnd,r);
         SetBkMode(DC,TRANSPARENT);
         SetTextColor(DC,RGB(255,255,0));
         DrawText(DC,PChar(SysTimeToStr),-1,r,DT_SINGLELINE or DT_CENTER or DT_VCENTER);
         EndPaint(wnd,ps);
         exit;
        end;
     WM_RBUTTONDOWN:
      begin
       hm:=CreatePopupMenu;
       pt.X:=LOWORD(lParam);
       pt.Y:=HIWORD(lParam);
       ClientToScreen(wnd,pt);
       Insertmenu(hm,0,MF_BYPOSITION or MF_STRING,$101,'Exit');
       Insertmenu(hm,0,MF_BYPOSITION or MF_SEPARATOR,0,nil);
       Insertmenu(hm,0,MF_BYPOSITION or MF_STRING,$102,'Date/Time Settings');
       Insertmenu(hm,0,MF_BYPOSITION or MF_SEPARATOR,0,nil);
       Insertmenu(hm,0,MF_BYPOSITION or MF_STRING,dword(-1),PChar(SysDateToStr));
       SetMenuDefaultItem(hm,0,1);
       Cmd:=TrackPopupMenu(hM,TPM_LEFTALIGN or TPM_RIGHTBUTTON or
                      TPM_RETURNCMD,pt.X,pt.Y,0,Window,nil);
        case longint(Cmd) of
        $101: SendMessage(wnd,wm_destroy,0,0);
        $102: ShellExecute(0,nil,'control.exe','date/time',nil,SW_SHOW);
        end;
       DestroyMenu(hm);
      end;
     WM_DESTROY:
         begin
          PostQuitMessage(wparam);
          KillTimer(wnd,idTM);
         end
      end;
    Result := DefWindowProc(wnd, uMsg, wParam, lParam);
    end;
     
    procedure InitInstance;
    var
      AppWinClass: TWndClass;
    begin
    with AppWinClass do
    begin
        style:= CS_VREDRAW or CS_HREDRAW;
        lpfnWndProc:= @AppWndProc;
        cbClsExtra:= 0;
        cbWndExtra:= 0;
        hInstance:= hInstance;
        hIcon:= LoadIcon(0,IDI_APPLICATION);
        hCursor:= LoadCursor(0,IDC_ARROW);
        hbrBackground:= GetStockObject(BLACK_BRUSH);
        lpszMenuName:= nil;
        lpszClassName:= ClassName;
    end;
    if RegisterClass(AppWinClass)=0 then Halt(1)
    end;
     
    procedure InitApplication;
    begin
     hTrayClock:=FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd',nil),0,'TrayNotifyWnd',nil),0,'TrayClockWClass',nil);
     Window := CreateWindow(ClassName,nil, WS_POPUP or WS_DLGFRAME, 0,0,0,0, hTrayClock,0,HInstance,nil);
     If Window=0 then halt(1);
     RecalcWndPos;
    end;
     
    procedure InitWindow;
    begin
     idTM:=SetTimer(Window,1,1000,@TimerProc);
     ShowWindow(Window, SW_SHOWNORMAL);
     UpdateWindow(Window);
     InvalidateRect(Window,nil,True)
    end;
     
    procedure MsgLoop;
    var
     Message:TMsg;
    begin
     while GetMessage(Message, 0, 0, 0) do
        begin
          TranslateMessage(Message);
          DispatchMessage(Message);
        end;
      Halt(Message.wParam)
    end;
     
    begin
     InitInstance;
     InitApplication;
     InitWindow;
     MsgLoop
    end.


но правильнее было бы внедриться в Explorer и сабклассировать
TrayClockWClass

