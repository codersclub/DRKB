---
Title: Перехват (Hook) клавиатуры (программа Sendkeys)
Author: Bogachev
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перехват (Hook) клавиатуры (программа Sendkeys)
===============================================

    program Project1;
     
    uses
      Forms,
      Unit1 in '..\Hooks1\Unit1.pas' {Form1};
     
    {$R *.RES}
     
    begin
      Application.Initialize;
      Application.CreateForm(TForm1, Form1);
      Application.Run;
    end.
     
    // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* //

    library SendKey;
     
    uses
     
      SysUtils, Classes, Windows, Messages;
     
    const
     
      {пользовательские сообщения}
      wm_LeftShow_Event = wm_User + 133;
      wm_RightShow_Event = wm_User + 134;
      wm_UpShow_Event = wm_User + 135;
      wm_DownShow_Event = wm_User + 136;
     
      {handle для ловушки}
      HookHandle: hHook = 0;
     
    var
     
      SaveExitProc: Pointer;
     
      {собственно ловушка}
     
    function Key_Hook(Code: integer; wParam: word;
      lParam: Longint): Longint; stdcall; export;
    var
      H: HWND;
    begin
     
      {если Code>=0, то ловушка может обработать событие}
      if (Code >= 0) and (lParam and $40000000 = 0) then
      begin
        {ищем окно по имени класса и по заголовку
        (Caption формы управляющей программы должен быть равен 'XXX' !!!!)}
        H := FindWindow('TForm1', 'XXX');
     
        {это те клавиши?}
        case wParam of
          VK_Left: SendMessage(H, wm_LeftShow_Event, 0, 0);
          VK_Right: SendMessage(H, wm_RightShow_Event, 0, 0);
          VK_Up: SendMessage(H, wm_UpShow_Event, 0, 0);
          VK_Down: SendMessage(H, wm_DownShow_Event, 0, 0);
        end;
        {если 0, то система должна дальше обработать это событие}
        {если 1 - нет}
        Result := 0;
      end
     
      else if Code < 0 {если Code<0, то нужно вызвать следующую ловушку} then
        Result := CallNextHookEx(HookHandle, Code, wParam, lParam);
    end;
     
    {при выгрузке DLL надо снять ловушку}
     
    procedure LocalExitProc; far;
    begin
     
      if HookHandle <> 0 then
      begin
        UnhookWindowsHookEx(HookHandle);
        ExitProc := SaveExitProc;
      end;
    end;
     
    exports Key_Hook;
     
    {инициализация DLL при загрузке ее в память}
    begin
      {устанавливаем ловушку}
     
      HookHandle := SetWindowsHookEx(wh_Keyboard, @Key_Hook,
        hInstance, 0);
      if HookHandle = 0 then
        MessageBox(0, 'Unable to set hook!', 'Error', mb_Ok)
      else
      begin
        SaveExitProc := ExitProc;
        ExitProc := @LocalExitProc;
      end;
    end.

    // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* //
     
    object Form1: TForm1
      Left = 200
      Top = 104
      Width = 544
      Height = 375
      Caption = 'XXX'
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      PixelsPerInch = 96
      TextHeight = 13
      object Label1: TLabel
        Left = 128
        Top = 68
        Width = 32
        Height = 13
        Caption = 'Label1'
      end
    end

    // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-* //
     
    unit Unit1;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls;
     
    {пользовательские сообщения}
     
    const
     
      wm_LeftShow_Event = wm_User + 133;
      wm_RightShow_Event = wm_User + 134;
      wm_UpShow_Event = wm_User + 135;
      wm_DownShow_Event = wm_User + 136;
     
    type
     
      TForm1 = class(TForm)
        Label1: TLabel;
     
        procedure FormCreate(Sender: TObject);
     
      private //Обработчики сообщений
     
        procedure WM_LeftMSG(var M: TMessage);
          message wm_LeftShow_Event;
     
        procedure WM_RightMSG(var M: TMessage);
          message wm_RightShow_Event;
     
        procedure WM_UpMSG(var M: TMessage);
          message wm_UpShow_Event;
     
        procedure WM_DownMSG(var M: TMessage);
          message wm_DownShow_Event;
      end;
     
    var
     
      Form1: TForm1;
      P: Pointer;
     
    implementation
     
    {$R *.DFM}
     
    //Загрузка DLL
     
    function Key_Hook(Code: integer; wParam: word;
      lParam: Longint): Longint; stdcall; external 'SendKey' name 'Key_Hook';
     
    procedure TForm1.WM_LefttMSG(var M: TMessage);
    begin
      Label1.Caption := 'Left';
    end;
     
    procedure TForm1.WM_RightMSG(var M: TMessage);
    begin
      Label1.Caption := 'Right';
    end;
     
    procedure TForm1.WM_UptMSG(var M: TMessage);
    begin
      Label1.Caption := 'Up';
    end;
     
    procedure TForm1.WM_DownMSG(var M: TMessage);
    begin
      Label1.Caption := 'Down';
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {если не использовать вызов процедуры из DLL в программе,
      то компилятор удалит загрузку DLL из программы}
      P := @Key_Hook;
    end;
     
    end.


