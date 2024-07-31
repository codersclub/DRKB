---
Title: Как отключать стили XP для отдельных контролов?
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как отключать стили XP для отдельных контролов?
===============================================

Темы должны быть включены и манифест лежать на форме:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ExtCtrls, StdCtrls, ComCtrls, XPMan;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        Button3: TButton;
        Button4: TButton;
        Button5: TButton;
        XPManifest1: TXPManifest;
        procedure FormCreate(Sender: TObject);
      private
        procedure Unload2Themes(var M:TMSG); message WM_USER+1;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    function SetWindowTheme(hwnd: HWND; pszSubAppName: LPCWSTR; 
                            pszSubIdList: LPCWSTR): HRESULT; stdcall;  external 'uxtheme.dll';
     
    procedure TForm1.Unload2Themes(var M: TMSG);
    begin
      SetWindowTheme(Button4.Handle, ' ', ' ');
      SetWindowTheme(Button5.Handle, ' ', ' ');
      SetWindowTheme(Form1.Handle, ' ', ' ');
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     PostMessage(Handle,WM_USER+1,0,0)
    end;
     
    end.

