---
Title: Как среагировать на минимизацию / максимизацию формы перед тем, как произойдет изменение?
Date: 01.01.2007
---


Как среагировать на минимизацию / максимизацию формы перед тем, как произойдет изменение?
=========================================================================================

Перехватывать сообщение WM\_SYSCOMMAND.
Если это сообщение говорит о минимизации или максимизации формы - пищит динамик.

    type
      TForm1 = class(TForm)
      private
      {Private declarations}
        procedure WMSysCommand(var Msg: TWMSysCommand);
          message WM_SYSCOMMAND;
      public
      {Public declarations}
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.WMSysCommand;
    begin
      if (Msg.CmdType = SC_MINIMIZE) or (Msg.CmdType = SC_MAXIMIZE) then
        MessageBeep(0)
      else
        inherited;
    end;
