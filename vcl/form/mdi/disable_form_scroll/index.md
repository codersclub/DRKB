---
Title: Избавление от скроллов в MDI-форме
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Избавление от скроллов в MDI-форме
==================================

    { Избавление от ScrollBar-ов в MDI-форме. (С) Peter Below (TeamB) }
    { Не надо VCL переписывать :-)                                    }
     
    unit MainForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Menus;
     
    type
      TfMain = class(TForm)
        MainMenu1: TMainMenu;
        Newchild1: TMenuItem;
        Newchild2: TMenuItem;
        procedure Newchild2Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      fMain: TfMain;
     
    implementation
     
    uses ChildForm;
     
    {$R *.DFM}
     
    procedure TfMain.Newchild2Click(Sender: TObject);
    begin
      with TfChild.Create(Application) do
        Show();
    end;
     
    function ClientWindowProc( wnd: HWND; msg: Cardinal; wparam, lparam: Integer ): Integer; stdcall;
    var
      f: Pointer;
    begin
      f := Pointer( GetWindowLong( wnd, GWL_USERDATA ));
      case msg of
      WM_NCCALCSIZE:
        if ( GetWindowLong( wnd, GWL_STYLE ) and
                           (WS_HSCROLL or WS_VSCROLL)) <> 0 then
          SetWindowLong( wnd, GWL_STYLE, GetWindowLong( wnd, GWL_STYLE )
                                       and not (WS_HSCROLL or WS_VSCROLL));
      end;
      Result := CallWindowProc( f, wnd, msg, wparam, lparam );
    end;
     
    procedure TfMain.FormCreate(Sender: TObject);
    begin
      if ClientHandle <> 0 then begin
        if GetWindowLong( ClientHandle, GWL_USERDATA ) <> 0 then
          Exit;  {cannot subclass client window, userdata already in use}
        SetWindowLong(ClientHandle, GWL_USERDATA, SetWindowLong( ClientHandle,
                                    GWL_WNDPROC, integer( @ClientWindowProc)));
    end;
     
    end;
     
    end.

