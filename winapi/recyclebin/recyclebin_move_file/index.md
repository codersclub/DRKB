---
Title: Удаление файла в корзину
Author: Rouse_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Удаление файла в корзину
========================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ShellAPI;
     
    const
      SHERB_NOCONFIRMATION  =  $1;
      SHERB_NOPROGRESSUI    =  $2;
      SHERB_NOSOUND         =  $4;
     
    type
      TForm1 = class(TForm)
        btnGetRecicleBinFileCount: TButton;
        btnEmptyRecicleBin: TButton;
        btnDelToReciclebin: TButton;
        procedure btnGetRecicleBinFileCountClick(Sender: TObject);
        procedure btnEmptyRecicleBinClick(Sender: TObject);
        procedure btnDelToReciclebinClick(Sender: TObject);
      end;
     
    type
       TSHQueryRBInfo = packed record
         cbSize      : DWORD;
         i64Size,
         i64NumItems : TLargeInteger;
       end;
       PSHQueryRBInfo = ^TSHQueryRBInfo;
     
      function SHEmptyRecycleBin(hwnd: HWND; pszRootPath: PChar;
        dwFlags: DWORD): HRESULT; stdcall;
        external 'shell32.dll' name 'SHEmptyRecycleBinA';
     
      function SHQueryRecycleBin (pszRootPath: PChar;
        var SHQueryRBInfo: TSHQueryRBInfo): HRESULT; stdcall;
        external  'Shell32.dll' name 'SHQueryRecycleBinA';  
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    // Удаление файла в корзину...
    procedure TForm1.btnDelToReciclebinClick(Sender: TObject);
    var
      Struct: TSHFileOpStruct;
      Err: HRESULT;
    begin
      with Struct do
      begin
        Wnd := Handle;
        wFunc := FO_DELETE;
        pFrom := 'c:\1.txt';
        pTo := nil;
        fFlags := FOF_ALLOWUNDO;
        fAnyOperationsAborted := True;
        hNameMappings := nil;
        lpszProgressTitle := nil;
      end;
      Err := SHFileOperation(Struct);
      if Err <> S_OK then ShowMessage(SysErrorMessage(Err));
    end;
     
    end.

Пример работы с корзиной можно скачать здесь:

[rbin.zip](../rbin.zip) 2k

