---
Title: Позиционирование TSaveDialog
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
---


Позиционирование TSaveDialog
============================

Вариант 1:

Author: Александр (Rouse\_) Багель

Source: <https://forum.sources.ru>

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, CommDlg;
     
    type
      TMySaveDialog = class(TSaveDialog)
      protected
        procedure WndProc(var Message: TMessage); override;
      end;
     
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TMySaveDialog.WndProc(var Message: TMessage);
    const
      X = 10;
      Y = 30;
    begin
      with Message do
      begin
        if ((Msg = WM_NOTIFY) and (POFNotify(LParam)^.hdr.code = CDN_INITDONE)) or
           ((Msg = WM_UPDATEUISTATE) and (WParamLo = UIS_SET)) then
        begin
          if Owner is TForm then
            SetWindowPos(GetParent(Handle), HWND_TOP, X, Y, 0, 0, SWP_NOSIZE);
        end
        else
          inherited;
      end
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      TMySaveDialog.Create(Self).Execute;
    end;
     
    end.


------------------------------------------------------------------------

Вариант 2:

Author: Krid

Source: <https://forum.sources.ru>

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        SaveDialog1: TSaveDialog;
        Button1: TButton;
        procedure SaveDialog1Show(Sender: TObject);
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
     
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    { TForm1 }
     
     
    function NewSaveDlgProc(wnd:HWND; uMsg:DWORD; wParam:Integer; lParam:integer):integer; stdcall;
    begin
     if uMsg=WM_SHOWWINDOW then MoveWindow(wnd, 10, 30, 500, 100, True) ;
     result:=CallWindowProc(Pointer(GetWindowLong(wnd,GWL_USERDATA)),wnd,uMsg,wParam,lParam)
    end;
     
    procedure TForm1.SaveDialog1Show(Sender: TObject);
    begin
      SetWindowLong(GetParent(SaveDialog1.Handle),GWL_USERDATA,
         SetWindowLong(GetParent(SaveDialog1.Handle),DWL_DLGPROC,DWORD(@NewSaveDlgProc)));
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     SaveDialog1.Execute
    end;
     
    end.


