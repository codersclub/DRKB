---
Title: Как перейти к нужному ключу в RegEdit?
Date: 01.01.2007
---

Как перейти к нужному ключу в RegEdit?
======================================

::: {.date}
01.01.2007
:::

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, Classes, Controls, Forms, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure JumpToKey(Key: string);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      ShellAPI;
     
    procedure TForm1.JumpToKey(Key: string);
    var
      i, n: Integer;
      hWin: HWND;
      ExecInfo: ShellExecuteInfoA;
    begin
      hWin := FindWindowA(PChar('RegEdit_RegEdit'), nil);
      if hWin = 0 then
      {if Regedit doesn't run then we launch it}
      begin
        FillChar(ExecInfo, 60, #0);
        with ExecInfo do
        begin
          cbSize := 60;
          fMask  := SEE_MASK_NOCLOSEPROCESS;
          lpVerb := PChar('open');
          lpFile := PChar('regedit.exe');
          nShow  := 1;
        end;
        ShellExecuteExA(@ExecInfo);
        WaitForInputIdle(ExecInfo.hProcess, 200);
        hWin := FindWindowA(PChar('RegEdit_RegEdit'), nil);
      end;
      ShowWindow(hWin, SW_SHOWNORMAL);
      hWin := FindWindowExA(hWin, 0, PChar('SysTreeView32'), nil);
      SetForegroundWindow(hWin);
      i := 30;
      repeat
        SendMessageA(hWin, WM_KEYDOWN, VK_LEFT, 0);
        Dec(i);
      until i = 0;
      Sleep(500);
      SendMessageA(hWin, WM_KEYDOWN, VK_RIGHT, 0);
      Sleep(500);
      i := 1;
      n := Length(Key);
      repeat
        if Key[i] = '\' then
        begin
          SendMessageA(hWin, WM_KEYDOWN, VK_RIGHT, 0);
          Sleep(500);
        end
        else
          SendMessageA(hWin, WM_CHAR, Integer(Key[i]), 0);
        i := i + 1;
      until i = n;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      JumpToKey('HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Internet Explorer');
    end;
     
    end.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
