---
Title: Как использовать IP Address Control у себя?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как использовать IP Address Control у себя?
===========================================

    {
      Microsoft® Internet Explorer Version 4.0 introduces the IP address control,
      a new control similar to an edit control that allows the user to enter a
      numeric address in Internet protocol (IP) format.
      This format consists of four three-digit fields.
      Each field is treated individually; the field numbers are zero-based and
      proceed from left to right as shown in this figure.
     
      Further informations
      http://msdn.microsoft.com/library/en-us/shellcc/platform/commctls/ipaddress/ipaddress.asp
    }
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, Classes, Forms, Controls, StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        IPAddress: TBevel;
        SetIP: TButton;
        ClearIP: TButton;
        procedure FormCreate(Sender: TObject);
        procedure SetIPClick(Sender: TObject);
        procedure ClearIPClick(Sender: TObject);
      private
        FIPAddress: Longint;
        HIPAddress: HWND;
        PrevWndProc: TWndMethod;
        procedure NewWindowProc(var Message: TMessage);
      public
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      CommCtrl;
     
    const
      IP_ADDRESS_ID: Longword = $0100;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      lpInitCtrls: TInitCommonControlsEx;
    begin
      lpInitCtrls.dwSize := SizeOf(TInitCommonControlsEx);
      lpInitCtrls.dwICC  := ICC_INTERNET_CLASSES;
      if InitCommonControlsEx(lpInitCtrls) then 
      begin
        PrevWndProc := WindowProc;
        WindowProc  := NewWindowProc;
     
        HIPAddress := CreateWindowEx(WS_EX_LEFT, WC_IPADDRESS, nil,
          WS_CHILD + WS_VISIBLE + WS_BORDER + WS_TABSTOP,
          IPAddress.Left, IPAddress.Top, IPAddress.Width, IPAddress.Height,
          Handle, IP_ADDRESS_ID, HInstance, nil);
        SendMessage(HIPAddress, IPM_SETFOCUS, 0, 0);
      end;
    end;
     
    procedure TForm1.NewWindowProc(var Message: TMessage);
    var
      nField: longint;
    begin
      case Message.Msg of
        WM_NOTIFY: 
          begin
            if PNMHDR(Ptr(Message.lParam)).idFrom = IP_ADDRESS_ID then 
            begin
              case PNMIPAddress(ptr(Message.lParam)).hdr.code of
                IPN_FIELDCHANGED: 
                  begin
                    if SendMessage(HIPAddress, IPM_ISBLANK, 0, 0) = 0 then
                      SendMessage(HIPAddress, IPM_GETADDRESS, 0, lParam(LPDWORD(@FIPAddress)));
                  end;
              end;
            end;
          end;
        WM_COMMAND: 
          begin
            if Message.WParamLo = IP_ADDRESS_ID then
              case Message.WParamHi of
                EN_SETFOCUS: 
                  begin
                    nField := SendMessage(HIPAddress, IPM_GETADDRESS, 0,
                      lParam(LPDWORD(@FIPAddress)));
                    if nField = 4 then nField := 0;
                    SendMessage(HIPAddress, IPM_SETFOCUS, wParam(nField), 0);
                  end;
                EN_KILLFOCUS: 
                  begin
                    if SendMessage(HIPAddress, IPM_ISBLANK, 0, 0) = 0 then
                      SendMessage(HIPAddress, IPM_GETADDRESS, 0, lParam(LPDWORD(@FIPAddress)));
                  end;
                EN_CHANGE: 
                  begin
                  end;
              end;
          end;
      end;
      if Assigned(PrevWndProc) then PrevWndproc(Message);
    end;
     
    procedure TForm1.SetIPClick(Sender: TObject);
    begin
      FIPAddress := MAKEIPADDRESS(127, 0, 0, 1);
      SendMessage(HIPAddress, IPM_SETADDRESS, 0, lParam(DWORD(FIPAddress)));
    end;
     
    procedure TForm1.ClearIPClick(Sender: TObject);
    begin
      SendMessage(HIPAddress, IPM_CLEARADDRESS, 0, 0);
    end;
     
    end.

