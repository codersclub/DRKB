---
Title: Как форматировать диск?
Author: Baa
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как форматировать диск?
=======================

    unit Unit1;

     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TUndocSHFormat = class(TForm)
        Label1: TLabel;
        Combo1: TComboBox;
        cmdSHFormat: TButton;
        cmdEnd: TButton;
        lbMessage: TLabel;
        procedure FormCreate(Sender: TObject);
        procedure cmdSHFormatClick(Sender: TObject);
        procedure cmdEndClick(Sender: TObject);
      private
        procedure LoadAvailableDrives;
      public
      end;
     
    var
      UndocSHFormat: TUndocSHFormat;
     
    implementation
     
    {$R *.DFM}
     
    type POSVERSIONINFO = ^TOSVERSIONINFO;
      TOSVERSIONINFO = record
        dwOSVersionInfoSize: Longint;
        dwMajorVersion: Longint;
        dwMinorVersion: Longint;
        dwBuildNumber: Longint;
        dwPlatformId: Longint;
        szCSDVersion: PChar;
      end;
     
    function GetVersionEx(lpVersionInformation: POSVERSIONINFO): Longint;
             stdcall; external 'kernel32.dll' name 'GetVersionExA';
     
    const VER_PLATFORM_WIN32s = 0;
    const VER_PLATFORM_WIN32_WINDOWS = 1;
    const VER_PLATFORM_WIN32_NT = 2;
     
     
    function SHFormatDrive(hwndOwner: longint; iDrive: Longint; iCapacity: LongInt;
      iFormatType: LongInt): Longint;
      stdcall; external 'shell32.dll';
     
    const SHFD_CAPACITY_DEFAULT = 0;
    const SHFD_CAPACITY_360 = 3;
    const SHFD_CAPACITY_720 = 5;
     
    //Win95
    //Const SHFD_FORMAT_QUICK = 0;
    //Const SHFD_FORMAT_FULL = 1;
    //Const SHFD_FORMAT_SYSONLY = 2;
     
    //WinNT
    //Public Const SHFD_FORMAT_FULL = 0
    //Public Const SHFD_FORMAT_QUICK = 1
     
    const SHFD_FORMAT_QUICK: LongInt = 0;
    const SHFD_FORMAT_FULL: LongInt = 1;
    const SHFD_FORMAT_SYSONLY: LongInt = 2;
     
    function GetLogicalDriveStrings(nBufferLength: LongInt; lpBuffer: PChar): LongInt;
      stdcall; external 'kernel32.dll' name 'GetLogicalDriveStringsA';
     
    function GetDriveType(nDrive: PChar): LongInt;
      stdcall; external 'kernel32.dll' name 'GetDriveTypeA';
     
    const DRIVE_REMOVABLE = 2;
    const DRIVE_FIXED = 3;
    const DRIVE_REMOTE = 4;
    const DRIVE_CDROM = 5;
    const DRIVE_RAMDISK = 6;
     
    function IsWinNT: Boolean;
    var osvi: TOSVERSIONINFO;
    begin
      osvi.dwOSVersionInfoSize := SizeOf(osvi);
      GetVersionEx(@osvi);
      IsWinNT := (osvi.dwPlatformId = VER_PLATFORM_WIN32_NT);
    end;
     
     
    function GetDriveDisplayString(currDrive: PChar): pchar;
    begin
      GetDriveDisplayString := nil;
      case GetDriveType(currDrive) of
        0, 1: GetDriveDisplayString := ' - Undetermined Drive Type -';
        DRIVE_REMOVABLE:
          case currDrive[1] of
            'A', 'B': GetDriveDisplayString := 'Floppy drive';
          else
            GetDriveDisplayString := 'Removable drive';
          end;
        DRIVE_FIXED: GetDriveDisplayString := 'Fixed (Hard) drive';
        DRIVE_REMOTE: GetDriveDisplayString := 'Remote drive';
        DRIVE_CDROM: GetDriveDisplayString := 'CD ROM';
        DRIVE_RAMDISK: GetDriveDisplayString := 'Ram disk';
      end;
    end;
     
    procedure TUndocSHFormat.LoadAvailableDrives;
    var
      a, r: LongInt;
      lpBuffer: array[0..256] of char;
      currDrive: array[0..256] of char;
      lpDrives: pchar;
     
    begin
      getmem(lpDrives, 256);
      fillchar(lpBuffer, 64, #32);
     
      r := GetLogicalDriveStrings(255, lpBuffer);
     
      if r <> 0 then
        begin
          strlcopy(lpBuffer, lpBuffer, r);
          for a := 0 to r do
            lpDrives[a] := lpBuffer[a];
          lpBuffer[r + 1] := #0;
          repeat
            strlcopy(currDrive, lpDrives, 3);
            lpDrives := @lpDrives[4];
            Combo1.Items.Add(strpas(currDrive) + ' ' + GetDriveDisplayString(currDrive));
          until lpDrives[0] = #0;
        end;
    end;
     
     
    procedure TUndocSHFormat.FormCreate(Sender: TObject);
    begin
      lbMessage.caption := '';
      LoadAvailableDrives;
      Combo1.ItemIndex := 0;
      if IsWinNT then
        begin
          SHFD_FORMAT_FULL := 0;
          SHFD_FORMAT_QUICK := 1;
        end
      else //it's Win95
        begin
          SHFD_FORMAT_QUICK := 0;
          SHFD_FORMAT_FULL := 1;
          SHFD_FORMAT_SYSONLY := 2;
        end;
    end;
     
    procedure TUndocSHFormat.cmdSHFormatClick(Sender: TObject);
    var
      resp: Integer;
      drvToFormat: Integer;
      prompt: string;
    begin
      drvToFormat := Combo1.ItemIndex;
      prompt := 'Are you sure you want to run the Format dialog against ' + Combo1.Text;
     
      if drvToFormat > 0 then
        resp := MessageDLG(prompt, mtConfirmation, [mbYes, mbNo], 0)
      else
        resp := mrYes;
     
      if resp = mrYes then
        begin
          lbMessage.Caption := 'Checking drive for disk...';
          Application.ProcessMessages;
          SHFormatDrive(handle, drvToFormat, SHFD_CAPACITY_DEFAULT, SHFD_FORMAT_QUICK);
          lbMessage.caption := '';
        end;
    end;
     
    procedure TUndocSHFormat.cmdEndClick(Sender: TObject);
    begin
      close;
    end;
     
    end.

