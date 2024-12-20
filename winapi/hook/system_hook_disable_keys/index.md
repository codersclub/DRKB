---
Title: Отключить клавиши при системном Hook\'e
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Отключить клавиши при системном Hook\'e
=======================================

    { 
      ** What is a Hook? ** 
     
      A hook is a point in the system message-handling mechanism where an 
      application can install a subroutine to monitor the message traffic in 
      the system and process certain types of messages before they reach the target window procedure. 
     
      To use the Windows hook mechanism, a program calls the SetWindowsHookEx() API function, 
      passing the address of a hook procedure that is notified when the specified 
      event takes place. SetWindowsHookEx() returns the address of the previously installed 
      hook procedure for the same event type. This address is important, 
      because hook procedures of the same type form a kind of chain. 
      Windows notifies the first procedure in the chain when an event occurs, 
      and each procedure is responsible for passing along the notification. 
      To do so, a hook procedure must call the CallNextHookEx() API function, 
      passing the previous hook procedure's address. 
     
      --> All system hooks must be located in a dynamic link library. 
     
      ** The type of Hook used in this Example Code: ** 
     
      The WH_GETMESSAGE hook enables an application to monitor/intercept messages 
      about to be returned by the GetMessage or PeekMessage function. 
    }
     
     
    { 
     
    ** Hook Dll - WINHOOK.dll ** 
    WINHOOK.dpr 
           |-----WHookInt.pas 
     
    ** Interface unit ** WHookDef.dpr 
     
    }
     
    {********** Begin WHookDef.dpr **************}
    
    { Interface unit for use with WINHOOK.DLL }
    
    unit WHookDef;
    
    interface
    
    uses
      Windows;
    
    function SetHook(WinHandle: HWND; MsgToSend: Integer): Boolean; stdcall;
    function FreeHook: Boolean; stdcall;
    
    implementation
    
    function SetHook; external 'WINHOOK.DLL' Index 1;
    function FreeHook; external 'WINHOOK.DLL' Index 2;
    
    end.
    
    {********** End WHookDef.dpr **************}

    {********** Begin Winhook.dpr **************}
    
    { The project file }
    
    { WINHOOK.dll }
    library Winhook;
    
    uses
      WHookInt in 'Whookint.pas';
    
    exports
      SetHook index 1,
      FreeHook index 2;
    end.
    
    {********** End Winhook.dpr **************}

    {********** Begin WHookInt.pas **************}
    
    unit WHookInt;
    
    interface
    
    uses
      Windows, Messages, SysUtils;
    
    function SetHook(WinHandle: HWND; MsgToSend: Integer): Boolean; stdcall; export;
    function FreeHook: Boolean; stdcall; export;
    function MsgFilterFunc(Code: Integer; wParam, lParam: Longint): Longint stdcall; export;
    
    implementation
    
    
    // Memory map file stuff 
     
    { 
      The CreateFileMapping function creates unnamed file-mapping object 
      for the specified file. 
    }
     
    function CreateMMF(Name: string; Size: Integer): THandle;
    begin
      Result := CreateFileMapping($FFFFFFFF, nil, PAGE_READWRITE, 0, Size, PChar(Name));
      if Result <> 0 then
      begin
        if GetLastError = ERROR_ALREADY_EXISTS then
        begin
          CloseHandle(Result);
          Result := 0;
        end;
      end;
    end;
    
    { The OpenFileMapping function opens a named file-mapping object. }
    
    function OpenMMF(Name: string): THandle;
    begin
      Result := OpenFileMapping(FILE_MAP_ALL_ACCESS, False, PChar(Name));
      // The return value is an open handle to the specified file-mapping object. 
    end;
     
    { 
    The MapViewOfFile function maps a view of a file into 
    the address space of the calling process. 
    }
     
    function MapMMF(MMFHandle: THandle): Pointer;
    begin
      Result := MapViewOfFile(MMFHandle, FILE_MAP_ALL_ACCESS, 0, 0, 0);
    end;
    
    { 
      The UnmapViewOfFile function unmaps a mapped view of a file 
      from the calling process's address space. 
    }
     
    function UnMapMMF(P: Pointer): Boolean;
    begin
      Result := UnmapViewOfFile(P);
    end;
    
    function CloseMMF(MMFHandle: THandle): Boolean;
    begin
      Result := CloseHandle(MMFHandle);
    end;
    
    
    // Actual hook stuff 
     
    type
      TPMsg = ^TMsg;
    
    const
      VK_D = $44;
      VK_E = $45;
      VK_F = $46;
      VK_M = $4D;
      VK_R = $52;
    
      MMFName = 'MsgFilterHookDemo';
    
    type
      PMMFData = ^TMMFData;
      TMMFData = record
        NextHook: HHOOK;
        WinHandle: HWND;
        MsgToSend: Integer;
      end;
    
    // global variables, only valid in the process which installs the hook. 
    var
      MMFHandle: THandle;
      MMFData: PMMFData;
    
    function UnMapAndCloseMMF: Boolean;
    begin
      Result := False;
      if UnMapMMF(MMFData) then
      begin
        MMFData := nil;
        if CloseMMF(MMFHandle) then
        begin
          MMFHandle := 0;
          Result := True;
        end;
      end;
    end;
    
    { 
      The SetWindowsHookEx function installs an application-defined 
      hook procedure into a hook chain. 
     
      WH_GETMESSAGE Installs a hook procedure that monitors messages 
      posted to a message queue. 
      For more information, see the GetMsgProc hook procedure. 
    }
     
    function SetHook(WinHandle: HWND; MsgToSend: Integer): Boolean; stdcall;
    begin
      Result := False;
      if (MMFData = nil) and (MMFHandle = 0) then
      begin
        MMFHandle := CreateMMF(MMFName, SizeOf(TMMFData));
        if MMFHandle <> 0 then
        begin
          MMFData := MapMMF(MMFHandle);
          if MMFData <> nil then
          begin
            MMFData.WinHandle := WinHandle;
            MMFData.MsgToSend := MsgToSend;
            MMFData.NextHook := SetWindowsHookEx(WH_GETMESSAGE, MsgFilterFunc, HInstance, 0);
    
            if MMFData.NextHook = 0 then
              UnMapAndCloseMMF
            else
              Result := True;
          end
          else
          begin
            CloseMMF(MMFHandle);
            MMFHandle := 0;
          end;
        end;
      end;
    end;
    
    
    { 
      The UnhookWindowsHookEx function removes the hook procedure installed 
      in a hook chain by the SetWindowsHookEx function. 
    }
     
    function FreeHook: Boolean; stdcall;
    begin
      Result := False;
      if (MMFData <> nil) and (MMFHandle <> 0) then
        if UnHookWindowsHookEx(MMFData^.NextHook) then
          Result := UnMapAndCloseMMF;
    end;
    
    
    
    (*
        GetMsgProc(
        nCode: Integer;  {the hook code}
        wParam: WPARAM;  {message removal flag}
        lParam: LPARAM  {a pointer to a TMsg structure}
        ): LRESULT;  {this function should always return zero}
    
        { See help on ==> GetMsgProc}
    *)
    
    function MsgFilterFunc(Code: Integer; wParam, lParam: Longint): Longint;
    var
      MMFHandle: THandle;
      MMFData: PMMFData;
      Kill: boolean;
    begin
      Result := 0;
      MMFHandle := OpenMMF(MMFName);
      if MMFHandle <> 0 then
      begin
        MMFData := MapMMF(MMFHandle);
        if MMFData <> nil then
        begin
          if (Code < 0) or (wParam = PM_NOREMOVE) then
            { 
             The CallNextHookEx function passes the hook information to the 
             next hook procedure in the current hook chain. 
            }
            Result := CallNextHookEx(MMFData.NextHook, Code, wParam, lParam)
          else
          begin
            Kill := False;
    
            { Examples }
            with TMsg(Pointer(lParam)^) do
            begin
              // Kill Numbers 
              if (wParam >= 48) and (wParam <= 57) then Kill := True;
              // Kill Tabulator 
              if (wParam = VK_TAB) then Kill := True;
            end;
    
            { Example to disable all the start-Key combinations }
            case TPMsg(lParam)^.message of
              WM_SYSCOMMAND: // The Win Start Key (or Ctrl+ESC) 
               if TPMsg(lParam)^.wParam = SC_TASKLIST then Kill := True;
    
              WM_HOTKEY:
                case ((TPMsg(lParam)^.lParam and $00FF0000) shr 16) of
                 VK_D,      // Win+D        ==> Desktop 
                 VK_E,      // Win+E        ==> Explorer 
                 VK_F,      // Win+F+(Ctrl) ==> Find:All (and Find: Computer) 
                 VK_M,      // Win+M        ==> Minimize all 
                 VK_R,      // Win+R        ==> Run program. 
                 VK_F1,     // Win+F1       ==> Windows Help 
                 VK_PAUSE:  // Win+Pause    ==> Windows system properties 
                   Kill := True;
                end;
            end;
            if Kill then TPMsg(lParam)^.message := WM_NULL;
            Result := CallNextHookEx(MMFData.NextHook, Code, wParam, lParam)
          end;
          UnMapMMF(MMFData);
        end;
        CloseMMF(MMFHandle);
      end;
    end;
    
    
    initialization
      begin
        MMFHandle := 0;
        MMFData   := nil;
      end;
    
    finalization
      FreeHook;
    end.
    
    {********** End WHookInt.pas **************}

    { *******************************************}
    { ***************** Demo   ******************}
    { *******************************************}
    
    { 
     
    ** HostApp.Exe ** 
    HostApp.dpr 
           |-----FrmMainU.pas 
     
    }
     
    {********** Begin HostApp.dpr **************}
    
    { Project file }
    
    program HostApp;
    
    uses
      Forms,
      FrmMainU in 'FrmMainU.pas' {FrmMain};
    
    {$R *.RES}
    
    begin
      Application.Initialize;
      Application.CreateForm(TFrmMain, FrmMain);
      Application.Run;
    end.
    
    {********** End HostApp.dpr **************}

    {********** Begin FrmMainU.pas **************}
    
    unit FrmMainU;
    
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
    
    const
      HookDemo = 'WINHOOK.dll';
    
    const
      WM_HOOKCREATE = WM_USER + 300;
    
    type
      TFrmMain = class(TForm)
        Panel1: TPanel;
        BtnSetHook: TButton;
        BtnClearHook: TButton;
        procedure BtnSetHookClick(Sender: TObject);
        procedure BtnClearHookClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        FHookSet: Boolean;
        procedure EnableButtons;
      public
    
      end;
    
    var
      FrmMain: TFrmMain;
    
    function SetHook(WinHandle: HWND; MsgToSend: Integer): Boolean; stdcall;
      external HookDemo;
    
    function FreeHook: Boolean; stdcall; external HookDemo;
    
    implementation
    
    {$R *.DFM}
    
    procedure TFrmMain.EnableButtons;
    begin
      BtnSetHook.Enabled   := not FHookSet;
      BtnClearHook.Enabled := FHookSet;
    end;
    
    // Start the Hook 
    procedure TFrmMain.BtnSetHookClick(Sender: TObject);
    begin
      FHookSet := LongBool(SetHook(Handle, WM_HOOKCREATE));
      EnableButtons;
    end;
    
    // Stop the Hook 
    procedure TFrmMain.BtnClearHookClick(Sender: TObject);
    begin
      FHookSet := FreeHook;
      EnableButtons;
      BtnClearHook.Enabled := False;
    end;
    
    procedure TFrmMain.FormCreate(Sender: TObject);
    begin
      EnableButtons;
    end;
    
    end.
    
    {********** End FrmMainU.pas **************}

