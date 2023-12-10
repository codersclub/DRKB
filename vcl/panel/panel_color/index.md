---
Title: Не устанавливается цвет панели
Author: Smike
Date: 01.01.2007
---


Не устанавливается цвет панели
==============================

::: {.date}
01.01.2007
:::

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ExtCtrls, XPMan;
     
    type
      TForm1 = class(TForm)
        Panel1: TPanel;
        XPManifest: TXPManifest;
        procedure FormCreate(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      Themes;
     
    type
      TMyPanel = class(TPanel)
      public
        constructor Create(AOwner: TComponent); override;
      end;
     
    { TMyPanel }
     
    constructor TMyPanel.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
     
      if ThemeServices.ThemesEnabled then
        ControlStyle := ControlStyle - [csParentBackground] + [csOpaque];
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      R: TRect;
    begin
      with TMyPanel.Create(Self) do
      begin
        Parent := Self;
        Color := clGreen;
        R := Panel1.BoundsRect;
        R.Left := R.Left + 300;
        R.Right := R.Right + 300;
        BoundsRect := R;
      end;
    end;
     
    end.

Автор: Smike

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Можно отключать стили XP и для отдельных контролов (темы должны быть
включены и манифест лежать на форме):

 

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

Автор: Krid

Взято из <https://forum.sources.ru>
