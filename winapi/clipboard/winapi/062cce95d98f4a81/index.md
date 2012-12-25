---
Title: Как копировать / менять clipboard text без использования VCL?
Date: 01.01.2007
---


Как копировать / менять clipboard text без использования VCL?
=============================================================

::: {.date}
01.01.2007
:::

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls...;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        function GetClipBoardText: string;
        procedure SetClipBoardText(const Value: string);
        procedure Open;
        procedure SetBuffer(Format: Word; var Buffer; Size: Integer);
        procedure Adding;
        procedure Clear;
        constructor CreateRes(Ident: Integer);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        FOpenRefCount: Integer;
        FClipboardWindow: HWND;
        FAllocated: Boolean;
        FEmptied: Boolean;
        FMessage: string;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    resourcestring
      SCannotOpenClipboard = 'Cannot open clipboard';
     
    implementation
     
     
    {$R *.dfm}
     
    //Create resource for resourceString
    constructor TForm1.CreateRes(Ident: Integer);
    begin
      FMessage := LoadStr(Ident);
    end;
     
    //Status: Adding
    procedure TForm1.Adding;
    begin
      if (FOpenRefCount <> 0) and not FEmptied then
      begin
        Clear;
        FEmptied := True;
      end;
    end;
     
    //Empty clipboard
    procedure TForm1.Clear;
    begin
      Open;
      try
        EmptyClipboard;
      finally
        Close;
      end;
    end;
     
    //Set buffer
    procedure TForm1.SetBuffer(Format: Word; var Buffer; Size: Integer);
    var
      Data: THandle;
      DataPtr: Pointer;
    begin
      Open;
      try
        Data := GlobalAlloc(GMEM_MOVEABLE + GMEM_DDESHARE, Size);
        try
          DataPtr := GlobalLock(Data);
          try
            Move(Buffer, DataPtr^, Size);
            Adding;
            SetClipboardData(Format, Data);
          finally
            GlobalUnlock(Data);
          end;
        except
          GlobalFree(Data);
          raise;
        end;
      finally
        Close;
      end;
    end;
     
    //Open the clipboard
    procedure TForm1.Open;
    begin
      if FOpenRefCount = 0 then
      begin
        FClipboardWindow := Application.Handle;
        if FClipboardWindow = 0 then
        begin
          {$IFDEF MSWINDOWS}
          FClipboardWindow := Classes.AllocateHWnd(MainWndProc);
          {$ENDIF}
          {$IFDEF LINUX}
          FClipboardWindow := WinUtils.AllocateHWnd(MainWndProc);
          {$ENDIF}
          FAllocated := True;
        end;
        if not OpenClipboard(FClipboardWindow) then
          raise Exception.CreateRes(@SCannotOpenClipboard);
        FEmptied := False;
      end;
      Inc(FOpenRefCount);
    end;
     
    //Get the clipboard text
    function TForm1.GetClipBoardText: string;
    var
      Data: THandle;
    begin
      Open;
      Data := GetClipboardData(CF_TEXT);
      try
        if Data <> 0 then
          Result := PChar(GlobalLock(Data))
        else
          Result := '';
      finally
        if Data <> 0 then GlobalUnlock(Data);
        Close;
      end;
    end;
     
    procedure TForm1.SetClipBoardText(const Value: string);
    begin
      //Set ClipboardText
      SetBuffer(CF_TEXT, PChar(Value)^, Length(Value) + 1);
    end;
     
    //Get the clipboard text
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(GetClipboardText);
    end;
     
    //Set the clipboard text
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      SetClipboardText('-> Big-X <-');
    end;
     
    end.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

    procedure CopyStringToClipboard(s: string);
    var
      hg: THandle;
      P: PChar;
    begin
      hg:=GlobalAlloc(GMEM_DDESHARE or GMEM_MOVEABLE, Length(S)+1);
      P:=GlobalLock(hg);
      StrPCopy(P, s);
      GlobalUnlock(hg);
      OpenClipboard(Application.Handle);
      SetClipboardData(CF_TEXT, hg);
      CloseClipboard;
      GlobalFree(hg);
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
