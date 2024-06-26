---
Title: Использование SMTP Relay Server
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Использование SMTP Relay Server
===============================

Использование SMTP Relay Server - отсылка письма напрямую минуя любые
промежуточные сервера (пример взят из библиотеки Indy). Для отсылки
письма с использованием компонентов Indy. Пример для Delphi 7 (скорее
всего будет работать и в Delphi 6), для Kylix 3 нужны небольшие
исправления для перевода в CLX приложение (сама функциональность та же).

Пример модуля:

    unit fMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      IdTCPConnection, IdTCPClient, IdMessageClient, IdSMTP, IdComponent,
      IdUDPBase, IdUDPClient, IdDNSResolver, IdBaseComponent, IdMessage,
      StdCtrls, ExtCtrls, ComCtrls, IdAntiFreezeBase, IdAntiFreeze;
     
    type
      TfrmMain = class(TForm)
        IdMessage: TIdMessage;
        IdDNSResolver: TIdDNSResolver;
        IdSMTP: TIdSMTP;
        Label1: TLabel;
        sbMain: TStatusBar;
        Label2: TLabel;
        edtDNS: TEdit;
        Label3: TLabel;
        Label4: TLabel;
        edtSender: TEdit;
        Label5: TLabel;
        edtRecipient: TEdit;
        Label6: TLabel;
        edtSubject: TEdit;
        Label7: TLabel;
        mmoMessageText: TMemo;
        btnSendMail: TButton;
        btnExit: TButton;
        IdAntiFreeze: TIdAntiFreeze;
        Label8: TLabel;
        edtTimeOut: TEdit;
        Label9: TLabel;
        Label10: TLabel;
        procedure btnExitClick(Sender: TObject);
        procedure btnSendMailClick(Sender: TObject);
      public
      fMailServers : TStringList;
      Function PadZero(s:String):String;
      Function GetMailServers:Boolean;
      Function ValidData : Boolean;
      Procedure SendMail; OverLoad;
      Function SendMail(aHost : String):Boolean; OverLoad;
      Procedure LockControls;
      procedure UnlockControls;
      Procedure Msg(aMessage:String);
      end;
     
    var
      frmMain: TfrmMain;
     
    implementation
     
    {$R *.DFM}
     
    procedure TfrmMain.btnExitClick(Sender: TObject);
    begin
    application.terminate;
    end;
     
    procedure TfrmMain.btnSendMailClick(Sender: TObject);
    begin
    Msg('');
    LockControls;
    if ValidData then SendMail;
    UnlockControls;
    Msg('');
    end;
     
    function TfrmMain.GetMailServers: Boolean;
    var
      i,x : integer;
      LDomainPart : String;
      LMXRecord : TMXRecord;
    begin
    if not assigned(fmailServers) then fMailServers := TStringList.Create;
    fmailServers.clear;
      Result := true;
      with IdDNSResolver do
      begin
      QueryResult.Clear;
      QueryRecords := [qtMX];
      Msg('Setting up DNS query parameters');
      Host := edtDNS.text;
      ReceiveTimeout := StrToInt(edtTimeOut.text);
      // Extract the domain part from recipient email address
      LDomainPart := copy(edtRecipient.text,pos('@',edtRecipient.text)+1,length(edtRecipient.text)); 
      // the domain name to resolve
      try
      Msg('Resolving DNS');
      Resolve(LDomainPart);
      if QueryResult.Count > 0 then
        begin
          for i := 0 to QueryResult.Count - 1 do
            begin
            LMXRecord := TMXRecord(QueryResult.Items[i]);
            fMailServers.Append(PadZero(IntToStr(LMXRecord.Preference)) + '=' + LMXRecord.ExchangeServer);
            end;
        // sort in order of priority and then remove extra data
        fMailServers.Sorted := false;
        for i := 0 to fMailServers.count - 1 do
          begin
          x := pos('=',fMailServers.Strings[i]);
          if x > 0 then fMailServers.Strings[i] :=
            copy(fMailServers.Strings[i],x+1,length(fMailServers.Strings[i]));
          end;
        fMailServers.Sorted := true;
        fMailServers.Duplicates := dupIgnore;
        Result := true;
        end
      else
        begin
        Msg('No response from DNS server');
        MessageDlg('There is no response from the DNS server !', mtInformation, [mbOK], 0);
        Result := false;
        end;
      except
      on E : Exception do
        begin
        Msg('Error resolving domain');
        MessageDlg('Error resolving domain: ' + e.message, mtInformation, [mbOK], 0);
        Result := false;
        end;
      end;
      end;
    end;
     
    // Used in DNS preferance sorting
    procedure TfrmMain.LockControls;
    var i : integer;
    begin
    edtDNS.enabled := false;
    edtSender.enabled := false;
    edtRecipient.enabled := false;
    edtSubject.enabled := false;
    mmoMessageText.enabled := false;
    btnExit.enabled := false;
    btnSendMail.enabled := false;
    end;
     
    procedure TfrmMain.UnlockControls;
    begin
    edtDNS.enabled := true;
    edtSender.enabled := true;
    edtRecipient.enabled := true;
    edtSubject.enabled := true;
    mmoMessageText.enabled := true;
    btnExit.enabled := true;
    btnSendMail.enabled := true;
    end;
     
    function TfrmMain.PadZero(s: String): String;
    begin
    if length(s) < 2 then s := '0' + s;
    Result := s;
    end;
     
    procedure TfrmMain.SendMail;
    var i : integer;
    begin
    if GetMailServers then
      begin
      with IdMessage do
        begin
        Msg('Assigning mail message properties');
        From.Text := edtSender.text;
        Sender.Text := edtSender.text;
        Recipients.EMailAddresses := edtRecipient.text;
        Subject := edtSubject.text;
        Body := mmoMessageText.Lines;
        end;
      for i := 0 to fMailServers.count -1 do
        begin
        Msg('Attempting to send mail');
        if SendMail(fMailServers.Strings[i]) then
          begin
          MessageDlg('Mail successfully sent and available for pickup by recipient !', 
                     mtInformation, [mbOK], 0);
          Exit;
          end;
        end;
      // if we are here then something went wrong ..
      // ie there were no available servers to accept our mail!
      MessageDlg('Could not send mail to remote server - please try again later.',
                  mtInformation, [mbOK], 0);
      end;
    if assigned(fMailServers) then FreeAndNil(fMailServers);
    end;
     
    function TfrmMain.SendMail(aHost: String): Boolean;
    begin
    Result := false;
    with IdSMTP do
      begin
      Caption := 'Trying to sendmail via: ' + aHost;
      Msg('Trying to sendmail via: ' + aHost);
      Host := aHost;
      try
      Msg('Attempting connect');
      Connect;
      Msg('Successful connect ... sending message');
      Send(IdMessage);
      Msg('Attempting disconnect');
      Disconnect;
      msg('Successful disconnect');
      Result := true;
      except on E : Exception do
        begin
        if connected then try disconnect; except end;
        Msg('Error sending message');
        result := false;
        ShowMessage(E.Message);
        end;
      end;
      end;
    Caption := '';
    end;
     
     
    function TfrmMain.ValidData: Boolean;
    var ErrString:string;
    begin
    Result := True;
    ErrString := '';
    if trim(edtDNS.text) = '' then
      ErrString := ErrString +  #13 + #187 + 'DNS server not filled in';
    if trim(edtSender.text) = '' then
      ErrString := ErrString + #13 + #187 + 'Sender email not filled in';
    if trim(edtRecipient.text) = '' then
      ErrString := ErrString +  #13 + #187 + 'Recipient not filled in';
    if ErrString <> '' then
      begin
      MessageDlg('Cannot proceed due to the following errors:'+#13+#10+ ErrString,
                 mtInformation, [mbOK], 0);
      Result := False;
      end;
    end;
     
    procedure TfrmMain.Msg(aMessage: String);
    begin
    sbMain.SimpleText := aMessage;
    application.ProcessMessages;
    end;
     
    end.

Форма для модуля:

    object frmMain: TfrmMain
      Left = 243
      Top = 129
      Width = 448
      Height = 398
      Caption = 'INDY - SMTP Relay Demo'
      Color = clBtnFace
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      OldCreateOrder = False
      PixelsPerInch = 96
      TextHeight = 13
      object Label1: TLabel
        Left = 7
        Top = 8
        Width = 311
        Height = 26
        Caption = 
          'Demonstrates sending mail directly to a users mailbox on a remot' +
          'e mailserver - this negates the need for a local SMTP server'
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clGray
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        ParentFont = False
        WordWrap = True
      end
      object Label2: TLabel
        Left = 8
        Top = 64
        Width = 111
        Height = 13
        Caption = 'DNS server IP address:'
      end
      object Label3: TLabel
        Left = 8
        Top = 123
        Width = 104
        Height = 13
        Caption = 'Sender email address:'
      end
      object Label4: TLabel
        Left = 288
        Top = 64
        Width = 49
        Height = 13
        Caption = 'Required !'
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clGray
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        ParentFont = False
      end
      object Label5: TLabel
        Left = 8
        Top = 150
        Width = 115
        Height = 13
        Caption = 'Recipient email address:'
      end
      object Label6: TLabel
        Left = 8
        Top = 177
        Width = 72
        Height = 13
        Caption = 'Subject of mail:'
      end
      object Label7: TLabel
        Left = 8
        Top = 204
        Width = 66
        Height = 13
        Caption = 'Message text:'
      end
      object Label8: TLabel
        Left = 8
        Top = 91
        Width = 95
        Height = 13
        Caption = 'DNS server timeout:'
      end
      object Label9: TLabel
        Left = 336
        Top = 124
        Width = 49
        Height = 13
        Caption = 'Required !'
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clGray
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        ParentFont = False
      end
      object Label10: TLabel
        Left = 336
        Top = 148
        Width = 49
        Height = 13
        Caption = 'Required !'
        Font.Charset = DEFAULT_CHARSET
        Font.Color = clGray
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = []
        ParentFont = False
      end
      object sbMain: TStatusBar
        Left = 0
        Top = 352
        Width = 440
        Height = 19
        Panels = <>
      end
      object edtDNS: TEdit
        Left = 128
        Top = 60
        Width = 153
        Height = 21
        TabOrder = 1
      end
      object edtSender: TEdit
        Left = 128
        Top = 119
        Width = 205
        Height = 21
        TabOrder = 2
      end
      object edtRecipient: TEdit
        Left = 128
        Top = 146
        Width = 205
        Height = 21
        TabOrder = 3
      end
      object edtSubject: TEdit
        Left = 128
        Top = 173
        Width = 205
        Height = 21
        TabOrder = 4
      end
      object mmoMessageText: TMemo
        Left = 128
        Top = 200
        Width = 205
        Height = 113
        TabOrder = 5
      end
      object btnSendMail: TButton
        Left = 258
        Top = 321
        Width = 75
        Height = 25
        Caption = 'Send mail !'
        TabOrder = 6
        OnClick = btnSendMailClick
      end
      object btnExit: TButton
        Left = 356
        Top = 8
        Width = 75
        Height = 25
        Caption = 'E&xit'
        TabOrder = 7
        OnClick = btnExitClick
      end
      object edtTimeOut: TEdit
        Left = 128
        Top = 87
        Width = 61
        Height = 21
        TabOrder = 8
        Text = '5000'
      end
      object IdMessage: TIdMessage
        AttachmentEncoding = 'MIME'
        BccList = <>
        CCList = <>
        Encoding = meMIME
        Recipients = <>
        ReplyTo = <>
        Left = 12
        Top = 236
      end
      object IdDNSResolver: TIdDNSResolver
        Port = 53
        ReceiveTimeout = 60
        QueryRecords = []
        Left = 12
        Top = 268
      end
      object IdSMTP: TIdSMTP
        MaxLineAction = maException
        ReadTimeout = 0
        Port = 25
        AuthenticationType = atNone
        Left = 12
        Top = 204
      end
      object IdAntiFreeze: TIdAntiFreeze
        Left = 12
        Top = 300
      end
    end

