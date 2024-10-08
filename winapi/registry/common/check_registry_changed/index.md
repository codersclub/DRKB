---
Title: Как получить событие о смене реестра?
Date: 01.01.2007
---

Как получить событие о смене реестра?
=====================================

Вариант 1:

Author: Александр (Rouse\_) Багель

Source: <https://forum.sources.ru>

    function RegNotifyChangeKeyValue(hKey: HKEY; bWatchSubtree: Boolean;
        dwNotifyFilter: DWORD; hEvent: THandle; fAsynchronus: Boolean): Longint;
        stdcall;
        external 'advapi32.dll' name 'RegNotifyChangeKeyValue';

     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      dwFilter = REG_NOTIFY_CHANGE_NAME or
                 REG_NOTIFY_CHANGE_ATTRIBUTES or
                 REG_NOTIFY_CHANGE_LAST_SET or
                 REG_NOTIFY_CHANGE_SECURITY;
    var
      hMainKey, hSubKey: HKEY;
      hNotifyEvent: THandle;
      ErrorCode: Longint;
    begin
      hMainKey := HKEY_CURRENT_USER;
      ErrorCode := RegOpenKeyEx(hMainKey,
        'Software\Microsoft\Windows\CurrentVersion\Run', 0, KEY_ALL_ACCESS, hSubKey);
      if ErrorCode = ERROR_SUCCESS then
      try
        hNotifyEvent := CreateEvent(nil, True, False, nil);
        if hNotifyEvent <> 0 then
        try
          ErrorCode := RegNotifyChangeKeyValue(hSubKey, True, dwFilter, hNotifyEvent, True);
          if ErrorCode = ERROR_SUCCESS then
            case WaitForSingleObject(hNotifyEvent, INFINITE) of
              WAIT_FAILED: ShowMessage(SysErrorMessage(GetLastError));
              WAIT_OBJECT_0: ShowMessage('Произошли изменения в реестре.');
            end;
        finally
          CloseHandle(hNotifyEvent);
        end
        else
          ShowMessage(SysErrorMessage(GetLastError));
      finally
        RegCloseKey(hSubKey);
      end;
      if ErrorCode <> ERROR_SUCCESS then
        ShowMessage(SysErrorMessage(ErrorCode));
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    {
      An application can be notified of changes in the data stored in the
      Windows clipboard by registering itself as a Clipboard Viewer.
     
      Clipboard viewers use two API calls and several messages to communicate
      with the Clipboard viewer chain. SetClipboardViewer adds a window to the
      beginning of the chain and returns a handle to the next viewer in the chain.
      ChangeClipboardChain removes a window from the chain. When a clipboard change occurs,
      the first window in the clipboard viewer chain is notified via the WM_DrawClipboard
      message and must pass the message on to the next window. To do this, our application
      must store the next window along in the chain to forward messages to and also respond
      to the WM_ChangeCBChain message which is sent whenever any other clipboard viewer on
      the system is added or removed to ensure the next window along is valid.
    }
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, Forms, Classes, Controls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender : TObject);
        procedure Button2Click(Sender : TObject);
        procedure FormCreate(Sender : TObject);
        procedure FormDestroy(Sender : TObject);
      private
        FNextClipboardViewer: HWND;
        procedure WMChangeCBChain(var Msg : TWMChangeCBChain); message WM_CHANGECBCHAIN;
        procedure WMDrawClipboard(var Msg : TWMDrawClipboard); message WM_DRAWCLIPBOARD;
      end;
     
    var
      Form1 : TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender : TObject);
    begin
      { Initialize variable }
      FNextClipboardViewer := 0;
    end;
     
     
    procedure TForm1.Button1Click(Sender : TObject);
    begin
      if FNextClipboardViewer <> 0 then
        MessageBox(0, 'This window is already registered!', nil, 0)
      else
        { Add to clipboard chain }
        FNextClipboardViewer := SetClipboardViewer(Handle);
    end;
     
     
    procedure TForm1.Button2Click(Sender : TObject);
    begin
      { Remove from clipboard chain }
      ChangeClipboardChain(Handle, FNextClipboardViewer);
      FNextClipboardViewer := 0;
    end;
     
     
    procedure TForm1.WMChangeCBChain(var Msg : TWMChangeCBChain);
    begin
      inherited;
      { mark message as done }
      Msg.Result := 0;
      { the chain has changed }
      if Msg.Remove = FNextClipboardViewer then
        { The next window in the clipboard viewer chain had been removed. We recreate it. }
        FNextClipboardViewer := Msg.Next
      else
        { Inform the next window in the clipboard viewer chain }
        SendMessage(FNextClipboardViewer, WM_CHANGECBCHAIN, Msg.Remove, Msg.Next);
    end;
     
     
    procedure TForm1.WMDrawClipboard(var Msg : TWMDrawClipboard);
    begin
      inherited;
      { Clipboard content has changed }
      try
        MessageBox(0, 'Clipboard content has changed!', 'Clipboard Viewer', MB_ICONINFORMATION);
      finally
        { Inform the next window in the clipboard viewer chain }
        SendMessage(FNextClipboardViewer, WM_DRAWCLIPBOARD, 0, 0);
      end;
    end;
     
     
    procedure TForm1.FormDestroy(Sender : TObject);
    begin
      if FNextClipboardViewer <> 0 then
      begin
        { Remove from clipboard chain }
        ChangeClipboardChain(Handle, FNextClipboardViewer);
        FNextClipboardViewer := 0;
      end;
    end;
     
    end.

