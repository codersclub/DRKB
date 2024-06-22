---
Title: Как получить handle на editbox в IE?
Date: 01.01.2007
---


Как получить handle на editbox в IE?
====================================

Вариант 1:

    var
      hndl: HWND;
      main: HWND;
    begin
      main := FindWindow('IEFrame', nil);
     
      if main <> 0 then
      begin
        hndl := findwindowex(main, 0, 'Worker', nil);
     
        if hndl <> 0 then
        begin
          hndl := findwindowex(hndl, 0, 'ReBarWindow32', nil);
     
          if hndl <> 0 then
          begin
            hndl := findwindowex(hndl, 0, 'ComboBoxEx32', nil);
     
            if hndl <> 0 then
            begin
              hndl := findwindowex(hndl, 0, 'ComboBox', nil);
     
              if hndl <> 0 then
              begin
                hndl := findwindowex(hndl, 0, 'Edit', nil);

------------------------------------------------------------------------

Вариант 2:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Label1: TLabel;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        procedure FindIEEditHandle;
      end;
     
    var
      Form1: TForm1;
      EditHandle: THandle;
     
    implementation
     
    {$R *.DFM}
     
    function EnumIEChildProc(AHandle: hWnd; AnObject: TObject): BOOL; stdcall;
    var
      tmpS: string;
      theClassName: string;
      theWinText: string;
    begin
      Result := True;
      SetLength(theClassName, 256);
      GetClassName(AHandle, PChar(theClassName), 255);
      SetLength(theWinText, 256);
      GetWindowText(AHandle, PChar(theWinText), 255);
      tmpS := StrPas(PChar(theClassName));
      if theWinText <> EmptyStr then
        tmpS := tmpS + '"' + StrPas(PChar(theWinText)) + '"'
      else
        tmpS := tmpS + '""';
      if Pos('Edit', tmpS) > 0 then
      begin
        EditHandle := AHandle;
      end;
    end;
     
    function IEWindowEnumProc(AHandle: hWnd; AnObject: TObject): BOOL; stdcall;
    {callback for EnumWindows.}
    var
      theClassName: string;
      theWinText: string;
      tmpS: string;
    begin
      Result := True;
      SetLength(theClassName, 256);
      GetClassName(AHandle, PChar(theClassName), 255);
      SetLength(theWinText, 256);
      GetWindowText(AHandle, PChar(theWinText), 255);
      tmpS := StrPas(PChar(theClassName));
      if theWinText <> EmptyStr then
        tmpS := tmpS + '"' + StrPas(PChar(theWinText)) + '"'
      else
        tmpS := tmpS + '""';
      if Pos('IEFrame', tmpS) > 0 then
      begin
        EnumChildWindows(AHandle, @EnumIEChildProc, longInt(0));
      end;
    end;
     
    procedure TForm1.FindIEEditHandle;
    begin
      Screen.Cursor := crHourGlass;
      try
        EnumWindows(@IEWindowEnumProc, LongInt(0));
      finally
        Screen.Cursor := crDefault;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      FindIEEditHandle;
      if EditHandle > 0 then
        Label1.Caption := IntToStr(EditHandle)
      else
        label1.Caption := 'Not Found';
    end;
     
    end.

