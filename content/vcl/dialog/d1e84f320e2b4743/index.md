---
Title: Как показать Choose Computer диалог?
Date: 01.01.2007
---


Как показать Choose Computer диалог?
====================================

::: {.date}
01.01.2007
:::

    { 
      The "Choose Computer" is a dialog provided by network services 
      (NTLANMAN.DLL) for Windows 2k/NT/XP 
      to display the servers and their computers. 
    } 
     
     
    type 
      TServerBrowseDialogA0 = function(hwnd: HWND; pchBuffer: Pointer; cchBufSize: DWORD): bool;  
      stdcall; 
     
     
    function ShowServerDialog(AHandle: THandle): string; 
    var 
      ServerBrowseDialogA0: TServerBrowseDialogA0; 
      LANMAN_DLL: DWORD; 
      buffer: array[0..1024] of char; 
      bLoadLib: Boolean; 
    begin 
      LANMAN_DLL := GetModuleHandle('NTLANMAN.DLL'); 
      if LANMAN_DLL = 0 then 
      begin 
        LANMAN_DLL := LoadLibrary('NTLANMAN.DLL'); 
        bLoadLib := True; 
      end; 
      if LANMAN_DLL <> 0 then 
      begin @ServerBrowseDialogA0 := GetProcAddress(LANMAN_DLL, 'ServerBrowseDialogA0'); 
        DialogBox(HInstance, MAKEINTRESOURCE(101), AHandle, nil); 
        ServerBrowseDialogA0(AHandle, @buffer, 1024); 
        if buffer[0] = '\' then 
        begin 
          Result := buffer; 
        end; 
        if bLoadLib then 
          FreeLibrary(LANMAN_DLL); 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      label1.Caption := ShowServerDialog(Form1.Handle); 
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
