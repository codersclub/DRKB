---
Title: Как сделать прозрачное окно родными средствами Windows2000?
Date: 01.01.2007
---


Как сделать прозрачное окно родными средствами Windows2000?
===========================================================

Вариант 1:

Source: <https://forum.sources.ru>

В Windows2000 есть для этого функция SetLayeredWindowAttributes, вот пример
её использования:

    unit Win2k;
    interface
    uses Graphics, Windows;
     
    function SetLayeredWindowAttributes(
      hwnd : HWND; // handle to the layered window
      crKey : TColor; // specifies the color key
      bAlpha : byte; // value for the blend function
      dwFlags : DWORD // action
    ): BOOL; stdcall;
     
    function SetLayeredWindowAttributes; external 'user32.dll';
    implementation
     
    end.
     
    program WinLayer;
     
    uses
    Windows, SysUtils,
    Win2k in 'Win2k.pas';
     
    const
    WS_EX_LAYERED= $80000;
    LWA_COLORKEY = 1;
    LWA_ALPHA = 2;
     
    var
    Hndl : THandle;
    Transp : Byte;
     
    begin
      Writeln('Windows2000 Layer <- build by AK ->');
      Writeln(' Usage: WINLAYER.EXE [window name] [Transp (0-255)]');
      Writeln(' Example: WINLAYER "Calculator" 200');
      Writeln;
      if ParamCount <> 2 then exit;
      Hndl := FindWindow(nil, PChar(ParamStr(1)));
      Transp := StrToIntDef(ParamStr(2), 128);
      if SetWindowLong(Hndl, GWL_EXSTYLE, GetWindowLong(Hndl, GWL_EXSTYLE) or WS_EX_LAYERED) = 0 then
        Writeln('Error !');
       
      if not SetLayeredWindowAttributes(Hndl, 0, Transp, LWA_ALPHA) then
        // ^^^ степень прозрачности
        // 0 - полная прозрачность
        // 255 - полная непрозрачность
        Writeln('Error !');
    end.


------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    SetWindowTransp(hndl: THandle; Perc: byte);

hndl - Hanle окна, которое надо сделать полупрозрачным.

Perc - Число от 1 до 100, указывающее уровень прозрачности.

------------------------------------------------------------------------

Вариант 3:

Source: <https://delphiworld.narod.ru>

Есть более продвинутые возможности (например, альфа-канал в битмапе)

https://msdn.microsoft.com/isapi/msdnlib.idc?theURL=/library/techart/layerwin.htm

    unit TransparentWnd;
     
    interface
     
    uses
      Windows, Messages, Classes, Controls, Forms;
     
    type
      _Percentage = 0..100;
     
      TTransparentWnd = class(TComponent)
      private
        { Private declarations }
      protected
        { Protected declarations }
        _percent: _Percentage;
        _auto: boolean;
        User32: HMODULE;
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
     
        //These work on a Handle
        //It doesn't change the Percent Property Value!
        procedure SetTransparentHWND(hwnd: THandle; percent : _Percentage);
     
        //These work on the Owner (a TWinControl decendant is the Minumum)
        //They don't change the Percent Property Value!
        procedure SetTransparent; overload;
        procedure SetTransparent(percent : _Percentage); overload;
     
        procedure SetOpaqueHWND(hwnd : THandle);
        procedure SetOpaque;
      published
        { Published declarations }
        //This works on the Owner (a TWinControl decendant is the Minumum)
        property Percent: _Percentage read _percent write _percent default 0;
     
        property AutoOpaque: boolean read _auto write _auto default false;
    end;
     
    procedure register;
     
    implementation
     
    const LWA_ALPHA = $2;
    const GWL_EXSTYLE = (-20);
    const WS_EX_LAYERED = $80000;
    const WS_EX_TRANSPARENT = $20;
     
    var
      SetLayeredWindowAttributes: function (hwnd: LongInt; crKey: byte;
        bAlpha: byte; dwFlags: LongInt): LongInt; stdcall;
     
    constructor TTransparentWnd.Create(AOwner: TComponent);
    begin
      inherited;
     
      User32 := LoadLibrary('USER32.DLL');
      if User32 <> 0 then
        @SetLayeredWindowAttributes := GetProcAddress(User32, 'SetLayeredWindowAttributes')
      else
        SetLayeredWindowAttributes := nil;
    end;
     
    destructor TTransparentWnd.Destroy;
    begin
      if User32 <> 0 then
        FreeLibrary(User32);
     
      inherited;
    end;
     
    procedure TTransparentWnd.SetOpaqueHWND(hwnd: THandle);
    var
      old: THandle;
    begin
      if IsWindow(hwnd) then
      begin
        old := GetWindowLongA(hwnd,GWL_EXSTYLE);
        SetWindowLongA(hwnd, GWL_EXSTYLE, old and ((not 0)-WS_EX_LAYERED));
      end;
    end;
     
    procedure TTransparentWnd.SetOpaque;
    begin
      Self.SetOpaqueHWND((Self.Owner as TWinControl).Handle);
    end;
     
    procedure TTransparentWnd.SetTransparent;
    begin
      Self.SetTransparentHWND((Self.Owner as TWinControl).Handle, Self._percent);
    end;
     
    procedure TTransparentWnd.SetTransparentHWND(hwnd: THandle; percent : _Percentage);
    var
      old: THandle;
    begin
      if (User32 <> 0) and (Assigned(SetLayeredWindowAttributes)) and (IsWindow(hwnd)) then
        if (_auto=true) and (percent=0) then
          SetOpaqueHWND(hwnd)
        else
        begin
          percent := 100 - percent;
          old := GetWindowLongA(hwnd, GWL_EXSTYLE);
          SetWindowLongA(hwnd, GWL_EXSTYLE, old or WS_EX_LAYERED);
          SetLayeredWindowAttributes(hwnd, 0, (255 * percent) div 100, LWA_ALPHA);
        end;
    end;
     
    procedure TTransparentWnd.SetTransparent(percent: _Percentage);
    begin
      Self.SetTransparentHWND((Self.Owner as TForm).Handle, percent);
    end;
     
    procedure register;
    begin
      RegisterComponents('Win32', [TTransparentWnd]);
    end;
     
    end.

