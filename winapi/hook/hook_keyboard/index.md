---
Title: Установка ловушки для клавиатуры
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Установка ловушки для клавиатуры
================================

1) Library Code for a Key Hook DLL 
     

    library HookLib;
     
    uses
      madExcept,
      Windows,
      Messages,
      SysUtils;
    
    type
      PHookRec = ^THookRec;
      THookRec = record
        AppHnd: Integer;
        MemoHnd: Integer;
      end;
    
    var
      Hooked: Boolean;
      hKeyHook, hMemo, hMemFile, hApp: HWND;
      PHookRec1: PHookRec;
    
    function KeyHookFunc(Code, VirtualKey, KeyStroke: Integer): LRESULT; stdcall;
    var
      KeyState1: TKeyBoardState;
      AryChar: array[0..1] of Char;
      Count: Integer;
    begin
      Result := 0;
      if Code = HC_NOREMOVE then Exit;
      Result := CallNextHookEx(hKeyHook, Code, VirtualKey, KeyStroke);
      {I moved the CallNextHookEx up here but if you want to block 
      or change any keys then move it back down}
      if Code < 0 then
        Exit;
    
      if Code = HC_ACTION then
      begin
        if ((KeyStroke and (1 shl 30)) <> 0) then
          if not IsWindow(hMemo) then
          begin
           {I moved the OpenFileMapping up here so it would not be opened 
           unless the app the DLL is attatched to gets some Key messages}
            hMemFile  := OpenFileMapping(FILE_MAP_WRITE, False, 'Global7v9k');
            PHookRec1 := MapViewOfFile(hMemFile, FILE_MAP_WRITE, 0, 0, 0);
            if PHookRec1 <> nil then
            begin
              hMemo := PHookRec1.MemoHnd;
              hApp  := PHookRec1.AppHnd;
            end;
          end;
        if ((KeyStroke and (1 shl 30)) <> 0) then
        begin
          GetKeyboardState(KeyState1);
          Count := ToAscii(VirtualKey, KeyStroke, KeyState1, AryChar, 0);
          if Count = 1 then
          begin
            SendMessage(hMemo, WM_CHAR, Ord(AryChar[0]), 0);
            {I included 2 ways to get the Charaters, a Memo Hnadle and 
            a WM_USER+1678 message to the program}
            PostMessage(hApp, WM_USER + 1678, Ord(AryChar[0]), 0);
          end;
        end;
      end;
    end;
    
    
    function StartHook(MemoHandle, AppHandle: HWND): Byte; export;
    begin
      Result := 0;
      if Hooked then
      begin
        Result := 1;
        Exit;
      end;
      if not IsWindow(MemoHandle) then
      begin
        Result := 4;
        Exit;
      end;
      hKeyHook := SetWindowsHookEx(WH_KEYBOARD, KeyHookFunc, hInstance, 0);
      if hKeyHook > 0 then
      begin
        {you need to use a mapped file because this DLL attatches to every app 
        that gets windows messages when it's hooked, and you can't get info except 
        through a Globally avaiable Mapped file}
        hMemFile := CreateFileMapping($FFFFFFFF, // $FFFFFFFF gets a page memory file 
         nil,                // no security attributes 
         PAGE_READWRITE,     // read/write access 
         0,                  // size: high 32-bits 
         SizeOf(THookRec),   // size: low 32-bits 
         //SizeOf(Integer), 
         'Global7v9k');    // name of map object 
       PHookRec1 := MapViewOfFile(hMemFile, FILE_MAP_WRITE, 0, 0, 0);
        hMemo := MemoHandle;
        PHookRec1.MemoHnd := MemoHandle;
        hApp := AppHandle;
        PHookRec1.AppHnd := AppHandle;
        {set the Memo and App handles to the mapped file}
        Hooked := True;
      end
      else
        Result := 2;
    end;
    
    function StopHook: Boolean; export;
    begin
      if PHookRec1 <> nil then
      begin
        UnmapViewOfFile(PHookRec1);
        CloseHandle(hMemFile);
        PHookRec1 := nil;
      end;
      if Hooked then
        Result := UnhookWindowsHookEx(hKeyHook)
      else
        Result := True;
      Hooked := False;
    end;
    
    procedure EntryProc(dwReason: DWORD);
    begin
      if (dwReason = Dll_Process_Detach) then
      begin
        if PHookRec1 <> nil then
        begin
          UnmapViewOfFile(PHookRec1);
          CloseHandle(hMemFile);
        end;
        UnhookWindowsHookEx(hKeyHook);
      end;
    end;
    
    exports
      StartHook,
      StopHook;
    
    begin
      PHookRec1 := nil;
      Hooked := False;
      hKeyHook := 0;
      hMemo := 0;
      DLLProc := @EntryProc;
      EntryProc(Dll_Process_Attach);
    end.

2) Code from the calling Program

    {this program get's the Char from the DLL in 2 ways,
     as a Char message to a Memo and as a DLLMessage WM_USER+1678}

    unit Unit1;
    
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
    
    type
      TForm1 = class(TForm)
        but_StartHook: TButton;
        but_StopHook: TButton;
        label1: TLabel;
        Memo1: TMemo;
        procedure but_StartHookClick(Sender: TObject);
        procedure but_StopHookClick(Sender: TObject);
      private
        { Private declarations }
        hLib2: THandle;
        DllStr1: string;
        procedure DllMessage(var Msg: TMessage); message WM_USER + 1678;
      public
        { Public declarations }
      end;
    
    var
      Form1: TForm1;
    
    implementation
    
    {$R *.dfm}
    
    procedure TForm1.DllMessage(var Msg: TMessage);
    begin
      if (Msg.wParam = 8) or (Msg.wParam = 13) then Exit;
      {the 8 is the Backspace and the 13 if the Enter key, You'll need to 
     do some special handleing for a string}
      DllStr1 := DllStr1 + Chr(Msg.wParam);
      label1.Caption := DllStr1;
    end;
    
    procedure TForm1.but_StartHookClick(Sender: TObject);
    type
      TStartHook = function(MemoHandle, AppHandle: HWND): Byte;
    var
      StartHook1: TStartHook;
      SHresult: Byte;
    begin
      hLib2 := LoadLibrary('HookLib.dll');
      @StartHook1 := GetProcAddress(hLib2, 'StartHook');
      if @StartHook1 = nil then Exit;
      SHresult := StartHook1(Memo1.Handle, Handle);
      if SHresult = 0 then ShowMessage('the Key Hook was Started, good');
      if SHresult = 1 then ShowMessage('the Key Hook was already Started');
      if SHresult = 2 then ShowMessage('the Key Hook can NOT be Started, bad');
      if SHresult = 4 then ShowMessage('MemoHandle is incorrect');
    end;
    
    procedure TForm1.but_StopHookClick(Sender: TObject);
    type
      TStopHook = function: Boolean;
    var
      StopHook1: TStopHook;
      hLib21: THandle;
    begin
      @StopHook1 := GetProcAddress(hLib2, 'StopHook');
      if @StopHook1 = nil then
      begin
        ShowMessage('Stop Hook DLL Mem Addy not found');
        Exit;
      end;
      if StopHook1 then
        ShowMessage('Hook was stoped');
      FreeLibrary(hLib2);
      {for some reason in Win XP you need to call FreeLibrary twice 
     maybe because you get 2 functions from the DLL? ?}
      FreeLibrary(hLib2);
    end;
    
    
    end.

