---
Title: Компонент на основе TImageList позволяет использовать в приложении анимированные иконки
Author: Вадим Исаенко (Inter) <https://v-isa.narod.ru>
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Компонент на основе TImageList позволяет использовать в приложении анимированные иконки
=======================================================================================

    unit AnimIcon;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls, ShellApi, TypInfo;
     
    const
      WM_FROMTRAYICON = WM_USER + 59;
     
    type
      TIconPlace = (ipAppIcon, ipAppMainFormIcon, ipFormIcon, ipImageCtrl,
        ipSysTray);
      TOnTimerEventOrder = (First, Second);
      TIconPlaceSet = set of TIconPlace;
      TTimerEvent = procedure(Sender: TObject) of object;
      TAnimIcon = class(TImageList)
     
      private
        { Private declarations }
        FIconPlaceSet: TIconPlaceSet;
        FEnabled: Boolean;
        FInterval: Cardinal;
        FNumIco: Integer;
        FOnTimer: TTimerEvent;
        FImage: TImage;
        FAuthor: string;
        FTip: string;
        FActionForIconOnSysTray: Byte;
        FOnTimerEventOrder: TOnTimerEventOrder;
        FhWnd: hWnd;
        procedure PlaceIcon;
      protected
        { Protected declarations }
        procedure Loaded; override;
        procedure SetEnabled(Value: Boolean);
        function GetEnabled: Boolean;
        procedure SetInterval(Value: Cardinal);
        function GetInterval: Cardinal;
        procedure OnAnimIconTimer(Sender: TObject);
        procedure SetImage(Value: TImage);
        function GetImage: TImage;
        procedure SetAuthor(Value: string);
      public
        { Public declarations }
      published
        { Published declarations }
        constructor Create(AOwner: Tcomponent); override; //Конструктор
        destructor Destroy; override;
        property IconPlace: TIconPlaceSet read FIconPlaceSet write FIconPlaceSet;
        property Enabled: Boolean read GetEnabled write SetEnabled;
        property Interval: Cardinal read GetInterval write SetInterval;
        property OnTimer: TTimerEvent read FOnTimer write FOnTimer;
        property ImageCtrl: TImage read GetImage write SetImage;
        property Author: string read FAuthor write SetAuthor;
        property SysTrayTip: string read FTip write FTip;
        property OnTimerEventOrder: TOnTimerEventOrder read FOnTimerEventOrder write
          FOnTimerEventOrder;
      end;
     
    var
      Timer: TTimer;
     
    procedure Register;
    function SysTrayIcon(hWindow: THandle; ID: Cardinal; ICON: hicon;
      CallbackMessage: Cardinal; Tip: string; Action: Byte): Boolean;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('MyComponents', [TAnimIcon]);
    end;
     
    function SysTrayIcon(hWindow: THandle; ID: Cardinal; Icon: hicon;
      CallbackMessage: Cardinal; Tip: string; Action: Byte): Boolean;
    var
      NID: TNotifyIconData;
    begin
      FillChar(NID, SizeOf(TNotifyIconData), 0);
      with NID do
      begin
        cbSize := SizeOf(TNotifyIconData);
        Wnd := hWindow;
        uID := ID;
        uFlags := NIF_MESSAGE or NIF_ICON or NIF_TIP;
        uCallbackMessage := CallbackMessage;
        hIcon := Icon;
        if Length(Tip) > 63 then
          SetLength(Tip, 63);
        StrPCopy(szTip, Tip);
      end;
      case Action of
        1: Result := Shell_NotifyIcon(NIM_ADD, @NID);
        2: Result := Shell_NotifyIcon(NIM_MODIFY, @NID);
        3: Result := Shell_NotifyIcon(NIM_DELETE, @NID);
      else
        Result := False;
      end;
    end;
     
    procedure TAnimIcon.PlaceIcon;
    var
      Icon: TIcon;
      CallbackMessage: Cardinal;
    begin
      Inc(FNumIco);
      if FNumIco > Count then
        FNumIco := 1;
      if ipAppIcon in FIconPlaceSet then
      begin
        GetIcon(FNumIco - 1, Application.Icon);
        Application.ProcessMessages;
      end;
      if ipFormIcon in FIconPlaceSet then
      begin
        GetIcon(FNumIco - 1, TForm(Owner).Icon);
        Application.ProcessMessages;
      end;
      if ipAppMainFormIcon in FIconPlaceSet then
      begin
        if Assigned(Application.MainForm) then
          GetIcon(FNumIco - 1, Application.MainForm.Icon);
        Application.ProcessMessages;
      end;
      if ipImageCtrl in FIconPlaceSet then
      begin
        if FImage <> nil then
          GetIcon(FNumIco - 1, FImage.Picture.Icon);
        Application.ProcessMessages;
      end;
      if ipSysTray in FIconPlaceSet then
      begin
        Icon := TIcon.Create;
        GetIcon(FNumIco - 1, Icon);
        CallbackMessage := WM_FROMTRAYICON;
        SysTrayIcon(FhWnd, 0, Icon.Handle, CallbackMessage, FTip,
          FActionForIconOnSysTray);
        Application.ProcessMessages;
        if FActionForIconOnSysTray = 1 then
          FActionForIconOnSysTray := 2;
      end;
    end;
     
    constructor TAnimIcon.Create(AOwner: TComponent);
    begin
      inherited create(AOwner);
      FAuthor := 'V-Isa aka Inter';
      FNumIco := 0;
      Timer := TTimer.Create(Self);
      Application.ProcessMessages;
      SetEnabled(False);
      SetInterval(1000);
      Timer.OnTimer := OnAnimIconTimer;
      FActionForIconOnSysTray := 0;
      FOnTimerEventOrder := First;
      if csDesigning in ComponentState then
        FTip := (Owner as TForm).Caption;
    end;
     
    destructor TAnimIcon.Destroy;
    var
      Icon: TIcon;
      CallbackMessage: Cardinal;
    begin
      if ipSysTray in FIconPlaceSet then
      begin
        Icon := TIcon.Create;
        CallbackMessage := WM_FROMTRAYICON;
        SysTrayIcon(FhWnd, 0, Icon.Handle, CallbackMessage, FTip, 3);
        Application.ProcessMessages;
      end;
      FNumIco := 0;
      FEnabled := False;
      Timer.Enabled := FEnabled;
      Application.ProcessMessages;
      inherited destroy;
    end;
     
    procedure TAnimIcon.OnAnimIconTimer(Sender: TObject);
    begin
      if Assigned(FOnTimer) and (FOnTimerEventOrder = First) then
        FOnTimer(Self);
      Application.ProcessMessages;
      if Count > 0 then
      begin
        PlaceIcon;
      end;
      Application.ProcessMessages;
      if Assigned(FOnTimer) and (FOnTimerEventOrder = Second) then
        FOnTimer(Self);
      Application.ProcessMessages;
    end;
     
    procedure TAnimIcon.SetEnabled(Value: Boolean);
    begin
      if (Value = True) and (csDesigning in ComponentState) then
      begin
        Value := False;
        FNumIco := 0;
        FEnabled := Value;
        Timer.Enabled := FEnabled;
        Application.ProcessMessages;
        ShowMessage('Изменение данного свойства возможно только' +
          #13'во время выполнения программы!!!');
        Exit;
      end;
      if (Value = True) and (Count > 0) then
      begin
        FActionForIconOnSysTray := 1;
        PlaceIcon;
      end;
      if Value = False then
      begin
        FActionForIconOnSysTray := 3;
        PlaceIcon;
      end;
      Application.ProcessMessages;
      if Value = False then
        FNumIco := 0;
      FEnabled := Value;
      Timer.Enabled := FEnabled;
      Application.ProcessMessages;
    end;
     
    function TAnimIcon.GetEnabled: Boolean;
    begin
      GetEnabled := FEnabled;
    end;
     
    procedure TAnimIcon.SetInterval(Value: Cardinal);
    begin
      FInterval := Value;
      Timer.Interval := FInterval;
      Application.ProcessMessages;
    end;
     
    function TAnimIcon.GetInterval: Cardinal;
    begin
      GetInterval := FInterval;
    end;
     
    procedure TAnimIcon.SetImage(Value: TImage);
    begin
      FImage := Value;
    end;
     
    function TAnimIcon.GetImage: TImage;
    begin
      GetImage := FImage;
    end;
     
    procedure TAnimIcon.SetAuthor(Value: string);
    begin
      FAuthor := 'V-Isa aka Inter';
    end;
     
    procedure TAnimIcon.Loaded;
    begin
      inherited Loaded;
      FhWnd := (Owner as TForm).Handle;
    end;
     
    end.

