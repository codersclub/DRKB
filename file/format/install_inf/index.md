---
Title: Как инсталлировать INF файл?
Date: 01.01.2007
---


Как инсталлировать INF файл?
============================

::: {.date}
01.01.2007
:::

    uses 
      ShellAPI; 
     
    function InstallINF(const PathName: string; hParent: HWND): Boolean; 
    var 
      instance: HINST; 
    begin 
      instance := ShellExecute(hParent, 
        PChar('open'), 
        PChar('rundll32.exe'), 
        PChar('setupapi,InstallHinfSection DefaultInstall 132 ' + PathName), 
        nil, 
        SW_HIDE); 
     
      Result := instance > 32; 
    end; { InstallINF } 
     
    // Example: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      InstallINF('C:\XYZ.inf', 0); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
