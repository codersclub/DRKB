---
Title: Как показать диалог Choose Domain?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как показать диалог Choose Domain?
==================================

    {
      If you are developing network software for Windows NT,
      you usually need to ask the user to select a computer or domain
      he wants to connect/login.
    }
     
    const
      FOCUSDLG_DOMAINS_ONLY = 1;
      FOCUSDLG_SERVERS_ONLY = 2;
      FOCUSDLG_SERVERS_DOMAINS = 3;
      FOCUSDLG_BROWSE_LOGON_DOMAIN = $00010000;
      FOCUSDLG_BROWSE_WKSTA_DOMAIN = $00020000;
      FOCUSDLG_BROWSE_OTHER_DOMAINS = $00040000;
      FOCUSDLG_BROWSE_TRUSTING_DOMAINS = $00080000;
      FOCUSDLG_BROWSE_WORKGROUP_DOMAINS = $00100000;
      FOCUSDLG_BROWSE_ALL_DOMAINS = FOCUSDLG_BROWSE_LOGON_DOMAIN or
        FOCUSDLG_BROWSE_WKSTA_DOMAIN or FOCUSDLG_BROWSE_OTHER_DOMAINS or
        FOCUSDLG_BROWSE_TRUSTING_DOMAINS or FOCUSDLG_BROWSE_WORKGROUP_DOMAINS;
     
     
    function SystemFocusDialog(hwndOwner: HWND; dwSelectionFlag: UINT;
      wszName: PWideChar; dwBufSize: DWORD; var bOKPressed: Boolean;
      wszHelpFile: PWideChar; dwContextHelpId: DWORD): DWORD; stdcall;
      external 'ntlanman.dll' Name 'I_SystemFocusDialog';
     
    function ComputerBrowser(hWndParent: HWND; wCompName: PWideChar;
      dwBufLen: DWORD): Boolean;
    var
      dwError: DWORD;
    begin
      Result := False;
      dwError := SystemFocusDialog(hWndParent, FOCUSDLG_SERVERS_DOMAINS or
        FOCUSDLG_BROWSE_ALL_DOMAINS,
        wCompName, dwBufLen, Result, nil, 0);
      if dwError <> NO_ERROR then Exit;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      wCompName: array [0..MAX_COMPUTERNAME_LENGTH + 1] of WideChar;
    begin
      if ComputerBrowser(0, wCompName, MAX_COMPUTERNAME_LENGTH + 1) then
        ShowMessage(wCompName)
      else
        ShowMessage('no computer selected');
    end;
     
    {***************************}
     
    // Show the ServerBrowseDialogA0 Dialog
     
    type
      TServerBrowseDialogA0 = function(hwnd: HWND; pchBuffer: Pointer;
        cchBufSize: DWORD): bool;
      stdcall;
     
    function ShowServerDialog(AHandle: THandle): string;
    var
      ServerBrowseDialogA0: TServerBrowseDialogA0;
      LANMAN_DLL: DWORD;
      buffer: array[0..1024] of char;
      bLoadLib: Boolean;
    begin
      LANMAN_DLL := GetModuleHandle('NTLANMAN.DLL');
      if LANMAN_DLL = 0 then
      begin
        LANMAN_DLL := LoadLibrary('NTLANMAN.DLL');
        bLoadLib := True;
      end;
      if LANMAN_DLL <> 0 then
      begin @ServerBrowseDialogA0 := GetProcAddress(LANMAN_DLL, 'ServerBrowseDialogA0');
        DialogBox(HInstance, MAKEINTRESOURCE(101), AHandle, nil);
        ServerBrowseDialogA0(AHandle, @buffer, 1024);
        if buffer[0] = '\' then
        begin
          Result := buffer;
        end;
        if bLoadLib then
          FreeLibrary(LANMAN_DLL);
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      label1.Caption := ShowServerDialog(Form1.Handle);
    end;

