---
Title: Как предотвратить Shutdown?
Date: 01.01.2007
---


Как предотвратить Shutdown?
===========================

::: {.date}
01.01.2007
:::

    {
    The WM_QUERYENDSESSION message is sent to all applications
    when the user chooses to end the session or when an application calls the
    ExitWindows function.
    If any application returns zero, the session is not ended.
    The system stops sending WM_QUERYENDSESSION messages as soon as one application
    returns zero.
    After processing this message, the system sends the WM_ENDSESSION message with the
    wParam parameter set to the results of the WM_QUERYENDSESSION message.
     
    Windows NT/2000/XP: When an application returns TRUE for this message,
    it receives the WM_ENDSESSION message and it is terminated,
    regardless of how the other applications respond to the WM_QUERYENDSESSION message.
     
    Windows 95/98/Me: After all applications return TRUE for this message,
    they receive the WM_ENDSESSION and they are terminated.
    }
     
    private
      procedure WMQueryEndSession (var Msg : TWMQueryEndSession); message WM_QueryEndSession;
    end;
     
    Implementation
     
    procedure TForm1.WMQueryEndSession (var Msg : TWMQueryEndSession);
    begin
      if MessageDlg('Close Windows now/ Windows beenden?',
                    mtConfirmation,
                    [mbYes,mbNo], 0) = mrNo then
          Msg.Result := 0
       else
          Msg.Result := 1;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
