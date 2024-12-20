---
Title: Как сделать Multi Screen Emulator?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как сделать Multi Screen Emulator?
==================================

    {** Building a multi screen emulator ***
     
      I want to present a simple multi-screen emulator written in Delphi.
      It consists in a little Form placing in the bottom-right corner of the screen,
      right above the traybar, which consists of 5 buttons.
      At the beginning the first button is down; then, when I press another button,
      a new fresh desktop is opened. In this new desktop I can open other programs
      and so on with the other buttons. When I go back to one of the buttons,
      I will see only the applications opened in that contest without the others.
      The trick is to make the following steps just before pressing another button:
     
      1)Get the handles of all the visible windows (except for Desktop,
      Taskbar and the application itself)
      2)Hiding all the windows detecting at step 1).
     
      After pressing the button we must:
     
      1)Show all the windows whose handles we got when we left
        the button itself by pressing another.
        Of course if a button is pressed for the first time we have no
        handles so we will have a new fresh desktop.
     
      I want to retrieve the handles of all the visible windows:
      the key is a call to the "EnumWindows" procedure
      passing as a parameter a callback function called for example "EnumWindowsProc".
      This callback function must be of the following type:
    }
     
    function EnumWindowsProc(hWnd: HWND; lParam: LPARAM): Bool;
     
    // The EnumWindows function is of type:
     
    BOOL EnumWindows(
         WNDENUMPROC lpEnumFunc, // pointer to callback function
                  LPARAM lParam  // application-defined value
         );
     
    {
      I will call EnumWindows(@EnumWindowsProc, 0);
     
      The "EnumWindows" function loop over all windows (visible or invisible):
      for each window there is a call to the callback function
      "EnumWindowsProc" wich must be implemented.
      The first param "hWnd" is the handle of the current window.
      A possible implementation of the "EnumWindowsProc" function may be the inserting
      of every handle in a list.
      According to our target we must insert in a list the handle of
      the following windows:
     
     
      1)Visible windows //(IsWindowVisible(hwnd) = True)
      2)Not my application window
      //var processed: DWORD;
      //GetWindowThreadProcessID( hwnd, @processID );
      //processID <> GetCurrentProcessID
      3)Not the taskbar window //hWnd <> FindWindow('Shell_TrayWnd', Nil)
      4)Not the desktop window //hWnd <> FindWindow('Progman', Nil)
    }
     
    // This is the code:
     
    unit ProcessView;
     
    interface
     
    uses
      Windows, Dialogs, SysUtils, Classes, ShellAPI, TLHelp32, Forms;
     
    var
      HandleList: TStringList;
     
    function EnumWindowsProc(hWnd: HWND; lParam: lParam): Bool; stdcall;
    
    procedure GetProcessList;
     
    implementation
     
    procedure GetProcessList;
    var
      i: integer;
    begin
      HandleList.Clear;
      EnumWindows(@EnumWindowsProc, 0);
    end;
     
    function EnumWindowsProc(hWnd: HWND; lParam: lParam): Bool;
    var
      processID: DWORD;
    begin
      GetWindowThreadProcessID(hwnd, @processID);
      if processID <> GetCurrentProcessID then
        if (hWnd <> FindWindow('Shell_TrayWnd', nil)) and
          (hWnd <> FindWindow('Progman', nil)) then
          if IsWindowVisible(hwnd) then
          begin
            HandleList.Add(IntToStr(HWnd));
            Result := True;
          end;
    end;
     
    initialization
      HandleList := TStringList.Create;
     
    finalization
      HandleList.Free;
    end.

    {
      In the main program I used a variable named Monitors of type
      "array of TstringList" whose dimension is given by the number of buttons
      (different monitors available) to keep in memory all the hanldes
      associated with every button. Another variable named CurrentMonitor
      keeps in memory the index of the actual monitor (the caption of the button).
      This is the code:
    }
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, ProcessView, StdCtrls, Buttons,
      abfComponents, Menus, ImgList, AppEvnts, TrayIcon;
     
    type
      TForm1 = class(TForm)
        //these are the buttons (1..5) to switch from a monitor to another ///
        SpeedButton1: TSpeedButton;
        SpeedButton2: TSpeedButton;
        SpeedButton3: TSpeedButton;
        SpeedButton4: TSpeedButton;
        SpeedButton5: TSpeedButton;
        ///////////////////////////////////////////////////////////////////////
     
        ImageList1: TImageList; //ImageList connected to the Popup menu
        PopupMenu1: TPopupMenu; //popup menu displayed by the trayicon
     
        //PopupMenu Items///////
        ShowApplication: TMenuItem; //Show the form
        HideApplication: TMenuItem; //Hide the form
        N1: TMenuItem; // -
        CloseApplication: TMenuItem; //Close the application
        ////////////////////////////////
     
        TrayIcon1: TTrayIcon; //my TrayIcon component; you can use yours
        procedure SpeedButton1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure FormShow(Sender: TObject);
        procedure ShowApplicationClick(Sender: TObject);
        //click on ShowApplication (TMenuItem)
        procedure HideApplicationClick(Sender: TObject);
        //click on HideApplication (TMenuItem)
        procedure FormCloseQuery(Sender: TObject; var CanClose: Boolean);
        procedure CloseApplicationClick(Sender: TObject);
        //click on CloseApplication (TMenuItem)
      private
        { Private declarations }
        Monitors: array[1..5] of TStringList;
        CurrentMonitor: Integer;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.SpeedButton1Click(Sender: TObject);
    var
      i: integer;
      Rect: TRect;
    begin
      //
      GetProcessList;
     
      Monitors[CurrentMonitor].Assign(HandleList);
     
      for i := 0 to HandleList.Count - 1 do
      begin
        ShowWindow(StrToInt(HandleList.Strings[i]), SW_HIDE);
      end;
     
      CurrentMonitor := StrToInt((Sender as TSpeedButton).Caption);
      for i := 0 to Monitors[CurrentMonitor].Count - 1 do
      begin
        ShowWindow(StrToInt(Monitors[CurrentMonitor].Strings[i]), SW_SHOW);
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      i: integer;
    begin
      //
      ShowWindow(Application.Handle, SW_HIDE);
      SetWindowLong(Application.Handle,
        GWL_EXSTYLE, GetWindowLong(Application.Handle, GWL_EXSTYLE) and
        not WS_EX_APPWINDOW or WS_EX_TOOLWINDOW);
      ShowWindow(Application.Handle, SW_SHOW);
     
      CurrentMonitor := 1;
      for i := Low(Monitors) to High(Monitors) do
        Monitors[i] := TStringList.Create;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    var
      i: integer;
    begin
      //
      for i := Low(Monitors) to High(Monitors) do
        Monitors[i].Free;
    end;
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    var
      i, j: integer;
    begin
      for i := Low(Monitors) to High(Monitors) do
      begin
        for j := 0 to Monitors[i].Count - 1 do
        begin
          ShowWindow(StrToInt(Monitors[i].Strings[j]), SW_SHOW);
        end;
      end;
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    begin
      //
      Height := 61;
      Width  := 173;
      Top := Screen.Height - Height - 30;
      Left := Screen.Width - Width;
    end;
     
    procedure TForm1.ShowApplicationClick(Sender: TObject);
    begin
      //
      Application.MainForm.Show;
    end;
     
    procedure TForm1.HideApplicationClick(Sender: TObject);
    begin
      //
      Application.MainForm.Hide;
    end;
     
    procedure TForm1.FormCloseQuery(Sender: TObject; var CanClose: Boolean);
    begin
      //
      if MessageDlg('Do you want to close Monitors?', mtConfirmation,
        [mbOK, mbCancel], 0) = mrCancel then
        CanClose := False;
    end;
     
    procedure TForm1.CloseApplicationClick(Sender: TObject);
    begin
      Close;
    end;
     
    end.

    {
      In order to prevent multiple instances of the application I inserted
      some lines of code inside the project source;
      this is the modified source:
    }
    program Project1;
     
    uses
      Forms,
      Windows,
      Unit1 in 'Unit1.pas' {Form1};
     
    {$R *.RES}
     
    var
      atom: integer;
    begin
      if GlobalFindAtom('Monitors_Procedure_Atom') = 0 then
        atom := GlobalAddAtom('Monitors_Procedure_Atom')
      else
        Exit;
     
      Application.Initialize;
      Application.CreateForm(TForm1, Form1);
      Application.Run;
     
      GlobalDeleteAtom(atom);
    end.

    {
      The GlobalAddAtom function adds a character string to the global atom table
      and returns a unique value (an atom) identifying the string.
     
      The GlobalFindAtom function searches the global atom table for the
      specified character string and retrieves the global atom associated with that string.
     
      If I have already run the programm then the GlobalFindAtom function returns a value
      <> 0 because the atom is already present: in this case I abort the execution of the program.
      Instead, if the GlobalFindAtom function returns 0 then this is the first time I run the
      program, so I create the atom. At the end I delete the atom.
     
      In order to remove the button on the taskbar I inserted the following code
      inside the OnCreate event of the form:
    }
     
    {...}
    ShowWindow( Application.handle, SW_HIDE );
    SetWindowLong( Application.handle,
                   GWL_EXSTYLE,
                   GetWindowLong( application.handle, GWL_EXSTYLE ) and
                   not WS_EX_APPWINDOW or WS_EX_TOOLWINDOW);
    ShowWindow( Application.handle, SW_SHOW );
    {...}
     
     
    {
      In order to have a tray icon in the traybar (wich display a menu containing showing,
      hiding and closing of the form), I used a component (TTrayIcon),
      I built a year ago; this is the source:
    }
     
    unit TrayIcon;
     
    interface
     
    uses
       Windows, Messages, SysUtils, Classes, Graphics, Controls,
       Forms, Dialogs,
       ShellAPI, extctrls, Menus;
     
    const
       WM_SYSTEM_TRAY_NOTIFY = WM_USER + 1;
     
    type TTrayIconMessage =(imClick, imDoubleClick, imMouseDown,
                            imMouseUp, imLeftClickUp, imLeftDoubleClick,
                            imRightClickUp, imRightDoubleClick, imNone);
     
    type
      TTrayIcon = class(TComponent)
      private
       { Private declarations }
       FData: TNotifyIconData;
       FIsClicked: Boolean;
       FIcon: TIcon;
       FIconList: TImageList;
       FPopupMenu: TPopupMenu;
       FTimer: TTimer;
       FHint: string;
       FIconIndex: integer;
       FVisible: Boolean;
       FHide: Boolean;
       FAnimate: Boolean;
       FAppRestore: TTrayIconMessage;
       FPopupMenuShow: TTrayIconMessage;
       FApplicationHook: TWindowHook;
     
       FOnMinimize: TNotifyEvent;
       FOnRestore: TNotifyEvent;
       FOnMouseMove: TMouseMoveEvent;
       FOnMouseExit: TMouseMoveEvent;
       FOnMouseEnter: TMouseMoveEvent;
       FOnClick: TNotifyEvent;
       FOnDblClick: TNotifyEvent;
       FOnMouseDown: TMouseEvent;
       FOnMouseUp: TMouseEvent;
       FOnAnimate: TNotifyEvent;
       FOnCreate: TNotifyEvent;
       FOnDestroy: TNotifyEvent;
       FOnActivate: TNotifyEvent;
       FOnDeactivate: TNotifyEvent;
     
       procedure SetHint(Hint: string);
       procedure SetHide(Value: Boolean);
       function GetAnimateInterval: integer;
       procedure SetAnimateInterval(Value: integer);
       function GetAnimate: Boolean;
       procedure SetAnimate(Value: Boolean);
       procedure EndSession;
     
       function ShiftState: TShiftState;
     
      protected
       { Protected declarations }
       procedure SetVisible(Value: Boolean); virtual;
     
       procedure DoMessage(var Message: TMessage);virtual;
       procedure DoClick; virtual;
       procedure DoDblClick; virtual;
       procedure DoMouseMove(Shift: TShiftState; X: integer; Y: integer); virtual;
       procedure DoMouseDown(Button: TMouseButton; Shift: TShiftState; X: integer; Y: integer); virtual;
       procedure DoMouseUp(Button: TMouseButton; Shift: TShiftState; X: integer; Y: integer); virtual;
       procedure DoOnAnimate(Sender: TObject); virtual;
       procedure Notification(AComponent: TComponent; Operation: TOperation); override;
     
       function ApplicationHookProc(var Message: TMessage): Boolean;
     
       procedure Loaded(); override;
     
       property Data: TNotifyIconData read FData;
     
      public
       { Public declarations }
       constructor Create(Owner: TComponent); override;
       destructor Destroy; override;
     
       procedure Minimize(); virtual;
       procedure Restore(); virtual;
       procedure Update(); virtual;
       procedure ShowMenu(); virtual;
       procedure SetIconIndex(Value: integer); virtual;
       procedure SetDefaultIcon(); virtual;
       function GetHandle():HWND;
     
      published
       { Published declarations }
       property Visible: Boolean  read FVisible write SetVisible default false;
       property Hint: string  read FHint write SetHint;
       property PopupMenu: TPopupMenu read FPopupMenu write FPopupMenu;
       property Hide: Boolean read  FHide write SetHide;
       property RestoreOn: TTrayIconMessage read FAppRestore write FAppRestore;
       property PopupMenuOn: TTrayIconMessage read FPopupMenuShow write FPopupMenuShow;
       property Icons: TImageList read FIconList write FIconList;
       property IconIndex: integer read FIconIndex write SetIconIndex default 0;
       property AnimateInterval: integer read GetAnimateInterval write SetAnimateInterval default 1000;
       property Animate: Boolean read GetAnimate write SetAnimate default false;
       property Handle: HWND read GetHandle;
     
       // Events
       property OnMinimize: TNotifyEvent read FOnMinimize write FOnMinimize;
       property OnRestore: TNotifyEvent read FOnRestore write FOnRestore;
       property OnClick: TNotifyEvent read FOnClick write FOnClick;
       property OnMouseEnter: TMouseMoveEvent read FOnMouseEnter write FOnMouseEnter;
       property OnMouseExit: TMouseMoveEvent read FOnMouseExit write FOnMouseExit;
       property OnMouseMove: TMouseMoveEvent read FOnMouseMove write FOnMouseMove;
       property OnMouseUp:TMouseEvent read FOnMouseUp write FOnMouseUp;
       property OnMouseDown: TMouseEvent read FOnMouseDown write FOnMouseDown;
       property OnAnimate: TNotifyEvent read FOnAnimate write FOnAnimate;
       property OnCreate: TNotifyEvent read FOnCreate write FOnCreate;
       property OnDestroy: TNotifyEvent read FOnDestroy write FOnDestroy;
       property OnActivate: TNotifyEvent read FOnActivate write FOnActivate;
       property OnDeactivate: TNotifyEvent read FOnDeactivate write FOnDeactivate;
     
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Carlo Pasolini', [TTrayIcon]);
    end;
     
    constructor TTrayIcon.Create(Owner: TComponent);
    begin
       inherited;
     
       FIcon := TIcon.Create();
       FTimer := TTimer.Create(nil);
     
       FIconIndex := 0;
       FIcon.Assign(Application.Icon);
       FAppRestore := imDoubleClick;
       FOnAnimate := DoOnAnimate;
       FPopupMenuShow := imNone;
       FVisible := false;
       FHide := true;
       FTimer.Enabled := false;
       FTimer.OnTimer := OnAnimate;
       FTimer.Interval := 1000;
     
       if not (csDesigning in ComponentState) then
          begin
               FillChar(FData, sizeof(TNotifyIconData), #0);
    //           memset(&FData, 0, sizeof(TNotifyIconData));
               FData.cbSize := sizeof(TNotifyIconData);
               FData.Wnd := AllocateHWnd(DoMessage);
               FData.uID := UINT(Self);
               FData.hIcon := FIcon.Handle;
               FData.uFlags := NIF_ICON or NIF_MESSAGE;
               FData.uCallbackMessage := WM_SYSTEM_TRAY_NOTIFY;
     
               FApplicationHook := ApplicationHookProc;
               Update;
          end;
     
    end;
     
    //---------------------------------------------------------------------------
    destructor TTrayIcon.Destroy();
    begin
       if not (csDesigning in ComponentState) then
          begin
               Shell_NotifyIcon(NIM_DELETE, @FData);  //booh forse @FData
               DeallocateHWnd(FData.Wnd);
          end;
     
       if (Assigned(FIcon)) then
          FIcon.Free;
     
       if (Assigned(FTimer)) then
          FTimer.Free;
     
       inherited;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.Notification(AComponent: TComponent; Operation: TOperation);
    begin
      inherited Notification(AComponent, Operation);
     
      if Operation = opRemove then
         begin
              if (AComponent = FIconList) then
                 FIconList := nil
              else
                 if (AComponent = FPopupMenu) then
                    FPopupMenu := nil;
         end;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.Loaded();
    begin
       inherited Loaded();
     
       if (not Assigned(FIconList)) then
          begin
               FAnimate := false;
               FIcon.Assign(Application.Icon);
          end
       else
          begin
               FTimer.Enabled := FAnimate;
               FIconList.GetIcon(FIconIndex, FIcon);
          end;
     
       Update();
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetVisible(Value: Boolean);
    begin
       FVisible := Value;
     
       if not (csDesigning in ComponentState) then
        begin
          if FVisible then
           begin
             if (not Shell_NotifyIcon(NIM_ADD, @FData)) then
                raise EOutOfResources.Create('Cannot Create System Shell Notification Icon');
     
             Hide := true;
             Application.HookMainWindow(FApplicationHook);
           end
     
          else
           begin
             if (not Shell_NotifyIcon(NIM_DELETE, @FData)) then
                raise EOutOfResources.Create('Cannot Remove System Shell Notification Icon');
     
             Hide := false;
             Application.UnhookMainWindow(FApplicationHook);
           end;
        end;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetHint(Hint: string);
    begin
       // The new hint must be different than the previous hint and less than
       // 64 characters to be modified. 64 is an operating system limit.
       if ((FHint <> Hint) and (Length(Hint) < 64)) then
        begin
          FHint := Hint;
          StrPLCopy(FData.szTip, Hint, sizeof(FData.szTip) - 1);
     
          // If there is no hint then there is no tool tip.
          if (Length(Hint) <> 0) then
             FData.uFlags := FData.uFlags or NIF_TIP
          else
             FData.uFlags := FData.uFlags and (not NIF_TIP);
     
          Update();
        end;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetHide(Value: Boolean);
    begin
       FHide := Value;
    end;
     
    //---------------------------------------------------------------------------
    function TTrayIcon.GetAnimateInterval(): integer;
    begin
       Result := FTimer.Interval;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetAnimateInterval(Value: integer);
    begin
       FTimer.Interval := Value;
    end;
     
    //---------------------------------------------------------------------------
    function TTrayIcon.GetAnimate(): Boolean;
    begin
       Result := FAnimate;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetAnimate(Value: Boolean);
    begin
       if (Assigned(FIconList) or (csLoading in ComponentState)) then
          FAnimate := Value;
     
       if (Assigned(FIconList) and (not (csDesigning in ComponentState))) then
          FTimer.Enabled := Value;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.EndSession();
    begin
       Shell_NotifyIcon(NIM_DELETE, @FData);
    end;
     
    //---------------------------------------------------------------------------
    function TTrayIcon.ShiftState(): TShiftState;
    var
       Res: TShiftState;
    begin
     
       Res := [];
     
       if (GetKeyState(VK_SHIFT) < 0) then
          Res := Res + [ssShift];
       if (GetKeyState(VK_CONTROL) < 0) then
          Res := Res + [ssCtrl];
       if (GetKeyState(VK_MENU) < 0) then
          Res := Res + [ssAlt];
     
       Result := Res;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoMessage(var Message: TMessage);
    var
       point: TPoint;
       shift: TShiftState;
    begin
     
       case (Message.Msg) of
        //begin
          WM_QUERYENDSESSION:
             Message.Result := 1;
             //break;
     
          WM_ENDSESSION:
             EndSession();
             //break;
     
          WM_SYSTEM_TRAY_NOTIFY:
             case (Message.LParam) of
              //begin
                WM_MOUSEMOVE:
                   if (Assigned(FOnClick)) then
                    begin
                      shift := ShiftState();
                      GetCursorPos(point);
                      DoMouseMove(shift, point.x, point.y);
                    end;
                   //break;
     
                WM_LBUTTONDOWN:
                 begin
                   shift := ShiftState();
                   shift := shift + [ssLeft];
                   GetCursorPos(point);
                   DoMouseDown(mbLeft, shift, point.x, point.y);
                   FIsClicked := true;
                   //break;
                 end;
     
                WM_LBUTTONUP:
                  begin
                   shift := ShiftState();
                   shift := shift + [ssLeft];
                   GetCursorPos(point);
                   if (Assigned(FOnClick)) then
                      DoClick();
     
                   DoMouseUp(mbLeft, shift, point.x, point.y);
     
                   if (FAppRestore = imLeftClickUp) then
                      Restore();
                   if (FPopupMenuShow = imLeftClickUp) then
                      ShowMenu();
                   //break;
                  end;
     
                WM_LBUTTONDBLCLK:
                  begin
                   DoDblClick();
     
                   if (FAppRestore = imLeftDoubleClick) then
                      Restore();
                   if (FPopupMenuShow = imLeftDoubleClick) then
                      ShowMenu();
                   //break;
                  end;
     
                WM_RBUTTONDOWN:
                  begin
                   shift := ShiftState();
                   shift := shift + [ssRight];
                   GetCursorPos(point);
                   DoMouseDown(mbRight, shift, point.x, point.y);
                   //break;
                  end;
     
                WM_RBUTTONUP:
                  begin
                   shift := ShiftState();
                   shift := shift + [ssRight];
                   GetCursorPos(point);
     
                   DoMouseUp(mbRight, shift, point.x, point.y);
     
                   if (FAppRestore = imRightClickUp) then
                      Restore();
                   if (FPopupMenuShow = imRightClickUp) then
                      ShowMenu();
                   //break;
                  end;
     
                WM_RBUTTONDBLCLK:
                  begin
                   DoDblClick();
     
                   if (FAppRestore = imRightDoubleClick) then
                      Restore();
                   if (FPopupMenuShow = imRightDoubleClick) then
                      ShowMenu();
                   //break;
                  end;
     
                WM_MBUTTONDOWN:
                  begin
                   shift := ShiftState();
                   shift := shift + [ssMiddle];
                   GetCursorPos(point);
     
                   DoMouseDown(mbMiddle, shift, point.x, point.y);
                   //break;
                  end;
     
                WM_MBUTTONUP:
                  begin
                   shift := ShiftState();
                   shift := shift + [ssMiddle];
                   GetCursorPos(point);
                   DoMouseUp(mbMiddle, shift, point.x, point.y);
                   //break;
                  end;
     
                WM_MBUTTONDBLCLK:
                   DoDblClick();
                   //break;
             end;
       end;
     
       inherited Dispatch(Message);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.ShowMenu();
    var
       point: TPoint;
    begin
       GetCursorPos(point);
     
       if (Screen.ActiveForm.Handle <> 0) then
          SetForegroundWindow(Screen.ActiveForm.Handle);
       FPopupMenu.Popup(point.x, point.y);
     
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoClick();
    begin
       if (FAppRestore = imClick) then
          Restore();
       if (FPopupMenuShow = imClick) then
          ShowMenu();
     
       if (Assigned(FOnClick)) then
          FOnClick(Self);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoDblClick();
    begin
       if (FAppRestore = imDoubleClick) then
          Restore();
       if (FPopupMenuShow = imDoubleClick) then
          ShowMenu();
     
       if (Assigned(FOnDblClick)) then
          FOnDblClick(Self);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoMouseMove(Shift: TShiftState;
                                    X:integer;
                                    Y: integer);
    begin
       if (Assigned(FOnMouseMove)) then
          FOnMouseMove(Self, Shift, X, Y);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoMouseDown(Button: TMouseButton;
                                    Shift: TShiftState;
                                    X: integer; Y: integer);
    begin
       if (FAppRestore = imMouseDown) then
          Restore();
       if (FPopupMenuShow = imMouseDown) then
          ShowMenu();
     
       if (Assigned(FOnMouseDown)) then
          FOnMouseDown(Self, Button, Shift, X, Y);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoMouseUp(Button: TMouseButton;
                                  Shift: TShiftState;
                                  X: integer; Y:integer);
    begin
       if (FAppRestore = imMouseDown) then
          Restore();
       if (FPopupMenuShow = imMouseDown) then
          ShowMenu();
     
       if (Assigned(FOnMouseUp)) then
          FOnMouseUp(Self, Button, Shift, X, Y);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.DoOnAnimate(Sender: TObject);
    begin
       if (IconIndex < FIconList.Count) then
          Inc(FIconIndex)
       else
          FIconIndex := 0;
     
       SetIconIndex(FIconIndex);
       Update();
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.Minimize();
    begin
       Application.Minimize();
       ShowWindow(Application.Handle, SW_HIDE);
     
       if (Assigned(FOnMinimize)) then
          FOnMinimize(Self);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.Restore();
    begin
       Application.Restore();
       ShowWindow(Application.Handle, SW_RESTORE);
       SetForegroundWindow(Application.Handle);
     
       if (Assigned(FOnRestore)) then
          FOnRestore(Self);
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.Update();
    begin
       if not (csDesigning in ComponentState) then
        begin
          FData.hIcon := FIcon.Handle;
     
          if (Visible = true) then
             Shell_NotifyIcon(NIM_MODIFY, @FData);
        end;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetIconIndex(Value: integer);
    begin
       FIconIndex := Value;
     
       if (Assigned(FIconList)) then
          FIconList.GetIcon(FIconIndex, FIcon);
     
       Update();
    end;
     
    //---------------------------------------------------------------------------
    function TTrayIcon.ApplicationHookProc(var Message: TMessage): Boolean;
    begin
       if (Message.Msg = WM_SYSCOMMAND) then
        begin
          if (Message.WParam = SC_MINIMIZE) then
             Minimize();
          if (Message.WParam = SC_RESTORE) then
             Restore();
        end;
     
       Result:= false;
    end;
     
    //---------------------------------------------------------------------------
    procedure TTrayIcon.SetDefaultIcon();
    begin
      FIcon.Assign(Application.Icon);
      Update();
    end;
     
    //---------------------------------------------------------------------------
    function TTrayIcon.GetHandle(): HWND;
    begin
       Result := FData.Wnd;
    end;
     
    //---------------------------------------------------------------------------
    end.

