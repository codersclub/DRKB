---
Title: Как узнать о переключении сессии в XP?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как узнать о переключении сессии в XP?
======================================

    {
      Typically, an application does not need to be notified when a session switch
      occurs. However, if the application needs to be aware when its desktop is
      current, it can register for session switch notifications. Applications that
      access the serial port or another shared resource on the computer should
      check for this. To register for a notification, use the following function:
    }
     
      function WTSRegisterSessionNotification(
          hWnd: HWND,    // Window handle
          dwFlags: DWORD  // Flags
          ): Bool; // Return value
     
    {
      The registered HWND receives the message WM_WTSSESSION_CHANGE
      through its WindowProc function.
     
      In dwFlags you can specify:
     
        a) NOTIFY_FOR_THIS_SESSION. A window is notified only about the session
          change events that affect the session to which window belongs.
     
        b) NOTIFY_FOR_ALL_SESSIONS. A window is notified for all session change
          events.
     
      The action happening on the session can be found in wParam code, which may
      contain one of the following flags.
     
      WTS_CONSOLE_CONNECT:        A session was connected to the console session.
      WTS_CONSOLE_DISCONNECT:     A session was disconnected from the console session.
      WTS_REMOTE_CONNECT:         A session was connected to the remote session.
      WTS_REMOTE_DISCONNECT:      A session was disconnected from the remote session.
      WTS_SESSION_LOGON:          A user has logged on to the session.
      WTS_SESSION_LOGOFF:         A user has logged off the session.
      WTS_SESSION_LOCK:           A session has been locked.
      WTS_SESSION_UNLOCK:         A session has been unlocked.
      WTS_SESSION_REMOTE_CONTROL: A session has changed its remote controlled status.
     
     
      lParam contains the sessionId for the session affected.
     
      When your process no longer requires these notifications or is terminating,
      it should call the following to unregister its notification.
     
    }
      function WTSUnRegisterSesssionNotification(
        hWnd: HWND // window handle.
        ): Boolean; // Result
     
    {
     
      The HWND values passed to WTSRegisterSessionNotification are reference
      counted, so you must call WTSUnRegisterSessionNotification exactly the same
      number of times that you call WTSRegisterSessionNotification.
     
      Applications can use the WTS_CONSOLE_CONNECT, WTS_CONSOLE_DISCONNECT,
      WTS_REMOTE_CONNECT, WTS_REMOTE_DISCONNECT messages to track their state, as
      well as to release and acquire console specific resources.
    }

    unit Wtsapi;
     
    interface
     
    { (c) By Thomas Stutz 10. April 02 }
     
    uses
      Windows;
     
    const
      // The WM_WTSSESSION_CHANGE message notifies applications of changes in session state.
      WM_WTSSESSION_CHANGE = $2B1;
     
      // wParam values:
      WTS_CONSOLE_CONNECT = 1;
      WTS_CONSOLE_DISCONNECT = 2;
      WTS_REMOTE_CONNECT = 3;
      WTS_REMOTE_DISCONNECT = 4;
      WTS_SESSION_LOGON = 5;
      WTS_SESSION_LOGOFF = 6;
      WTS_SESSION_LOCK = 7;
      WTS_SESSION_UNLOCK = 8;
      WTS_SESSION_REMOTE_CONTROL = 9;
     
      // Only session notifications involving the session attached to by the window
      // identified by the hWnd parameter value are to be received.
      NOTIFY_FOR_THIS_SESSION = 0;
      // All session notifications are to be received.
      NOTIFY_FOR_ALL_SESSIONS = 1;
     
     
    function RegisterSessionNotification(Wnd: HWND; dwFlags: DWORD): Boolean;
    function UnRegisterSessionNotification(Wnd: HWND): Boolean;
    function GetCurrentSessionID: Integer;
     
    implementation
     
    function RegisterSessionNotification(Wnd: HWND; dwFlags: DWORD): Boolean;
      // The RegisterSessionNotification function registers the specified window
      // to receive session change notifications.
      // Parameters:
      // hWnd: Handle of the window to receive session change notifications.
      // dwFlags: Specifies which session notifications are to be received:
      // (NOTIFY_FOR_THIS_SESSION, NOTIFY_FOR_ALL_SESSIONS)
    type
      TWTSRegisterSessionNotification = function(Wnd: HWND; dwFlags: DWORD): BOOL; stdcall;
    var
      hWTSapi32dll: THandle;
      WTSRegisterSessionNotification: TWTSRegisterSessionNotification;
    begin
      Result := False;
      hWTSAPI32DLL := LoadLibrary('Wtsapi32.dll');
      if (hWTSAPI32DLL > 0) then
      begin
        try @WTSRegisterSessionNotification :=
            GetProcAddress(hWTSAPI32DLL, 'WTSRegisterSessionNotification');
          if Assigned(WTSRegisterSessionNotification) then
          begin
            Result:= WTSRegisterSessionNotification(Wnd, dwFlags);
          end;
        finally
          if hWTSAPI32DLL > 0 then
            FreeLibrary(hWTSAPI32DLL);
        end;
      end;
    end;
     
    function UnRegisterSessionNotification(Wnd: HWND): Boolean;
      // The RegisterSessionNotification function unregisters the specified window
      // Parameters:
      // hWnd: Handle to the window
    type
      TWTSUnRegisterSessionNotification = function(Wnd: HWND): BOOL; stdcall;
    var
      hWTSapi32dll: THandle;
      WTSUnRegisterSessionNotification: TWTSUnRegisterSessionNotification;
    begin
      Result := False;
      hWTSAPI32DLL := LoadLibrary('Wtsapi32.dll');
      if (hWTSAPI32DLL > 0) then
      begin
        try @WTSUnRegisterSessionNotification :=
            GetProcAddress(hWTSAPI32DLL, 'WTSUnRegisterSessionNotification');
          if Assigned(WTSUnRegisterSessionNotification) then
          begin
            Result:= WTSUnRegisterSessionNotification(Wnd);
          end;
        finally
          if hWTSAPI32DLL > 0 then
            FreeLibrary(hWTSAPI32DLL);
        end;
      end;
    end;
     
    function GetCurrentSessionID: Integer;
     // Getting the session id from the current process
    type
      TProcessIdToSessionId = function(dwProcessId: DWORD; pSessionId: DWORD): BOOL; stdcall;
    var
      ProcessIdToSessionId: TProcessIdToSessionId;
      hWTSapi32dll: THandle;
      Lib : THandle;
      pSessionId : DWord;
    begin
      Result := 0;
      Lib := GetModuleHandle('kernel32');
      if Lib <> 0 then
      begin
        ProcessIdToSessionId := GetProcAddress(Lib, '1ProcessIdToSessionId');
        if Assigned(ProcessIdToSessionId) then
        begin
          ProcessIdToSessionId(GetCurrentProcessId(), DWORD(@pSessionId));
          Result:= pSessionId;
        end;
      end;
    end;
     
    end.

Example:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, {...},  Wtsapi;
     
    type
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
      private
      { Private declarations }
        FRegisteredSessionNotification : Boolean;
        procedure AppMessage(var Msg: TMSG; var HAndled: Boolean);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.AppMessage(var Msg: TMSG; var Handled: Boolean);
    var
      strReason: string;
    begin
      Handled := False;
      // Check for WM_WTSSESSION_CHANGE message
      if Msg.Message = WM_WTSSESSION_CHANGE then
      begin
         case Msg.wParam of
           WTS_CONSOLE_CONNECT:
               strReason := 'WTS_CONSOLE_CONNECT';
           WTS_CONSOLE_DISCONNECT:
               strReason := 'WTS_CONSOLE_DISCONNECT';
           WTS_REMOTE_CONNECT:
               strReason := 'WTS_REMOTE_CONNECT';
           WTS_REMOTE_DISCONNECT:
               strReason := 'WTS_REMOTE_DISCONNECT';
           WTS_SESSION_LOGON:
               strReason := 'WTS_SESSION_LOGON';
           WTS_SESSION_LOGOFF:
               strReason := 'WTS_SESSION_LOGOFF';
           WTS_SESSION_LOCK:
               strReason := 'WTS_SESSION_LOCK';
           WTS_SESSION_UNLOCK:
               strReason := 'WTS_SESSION_UNLOCK';
           WTS_SESSION_REMOTE_CONTROL:
               begin
                 strReason := 'WTS_SESSION_REMOTE_CONTROL';
                 // GetSystemMetrics(SM_REMOTECONTROL);
               end;
          else
            strReason := 'WTS_Unknown';
         end;
       // Write strReason to a Memo
       Memo1.Lines.Add(strReason + ' ' + IntToStr(msg.Lparam));
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      // register the window to receive session change notifications.
      FRegisteredSessionNotification := RegisterSessionNotification(Handle, NOTIFY_FOR_THIS_SESSION);
      Application.OnMessage := AppMessage;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      // unregister session change notifications.
      if FRegisteredSessionNotification then
        UnRegisterSessionNotification(Handle);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      // retrieve current session ID
      ShowMessage(Inttostr(GetCurrentSessionID));
    end;

