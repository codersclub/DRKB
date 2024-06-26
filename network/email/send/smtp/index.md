---
Title: Пример работы с SMTP
Author: Vit
Date: 01.01.2007
---


Пример работы с SMTP
====================

Вариант 1:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils,
      Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls, ComCtrls, Psock, NMsmtp;
    
    type
    TForm1 = class(TForm)
      Memo: TRichEdit;
      Panel1: TPanel;
      SMTP: TNMSMTP;
      Panel2: TPanel;
      FromAddress: TEdit;
      predefined: TLabel;
      FromName: TEdit;
      Subject: TEdit;
      LocalProgram: TEdit;
      ReplyTo: TEdit;
      islog: TCheckBox;
      Host: TEdit;
      Port: TEdit;
      userid: TEdit;
      Button1: TButton;
      procedure Button1Click(Sender: TObject);
    private
      Procedure CleanContext;
      procedure PerformConnection;
      procedure AddMessage(msg:string; color:integer);
      procedure log(inpt :string);
      Procedure SetSMTP;
    public
      function SendEmail(_to, cc, bcc, Subject, body, attachment:string; HTMLFormat:boolean):boolean;
    end;
     
    var Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    Procedure TForm1.SetSMTP;
    begin
      SMTP.Host:=Host.Text;
      SMTP.Port:=strtoint(Port.text);
      SMTP.UserID:=userid.text;
    end;
     
    Function GetEmailDateTime:string;
    var
      tz:_time_Zone_information;
      s:string;
    begin
      GetTimeZoneInformation(tz);
      if (tz.Bias*100 div 60)<1000 then
        s:=format(' -0%d',[tz.Bias*100 div 60])
      else
        s:=format(' -%d',[tz.Bias*100 div 60]);
      result:=formatdatetime('ddd, dd mmm yyyy hh:nn:ss',now)+s;
    end;
     
    Procedure TForm1.CleanContext;
    {set default values, some of them comes from "Setup" form}
    begin
      SMTP.PostMessage.FromAddress:=FromAddress.text;
      SMTP.PostMessage.FromName:=FromName.text;
      SMTP.PostMessage.ToAddress.Clear;
      SMTP.PostMessage.ToCarbonCopy.clear;
      SMTP.PostMessage.ToBlindCarbonCopy.clear;
      SMTP.PostMessage.Body.clear;
      SMTP.PostMessage.Attachments.clear;
      SMTP.PostMessage.Subject:=Subject.text;
      SMTP.PostMessage.LocalProgram:=LocalProgram.text;
      (*Mon, 27 Nov 2000 12:37:46 -0700*)
      SMTP.PostMessage.Date:=GetEmailDateTime;
      SMTP.PostMessage.ReplyTo:=ReplyTo.Text;
    end;
     
    procedure TForm1.log(inpt :string);
    var outf:textfile;
    begin  {writing in the log file}
      if not islog.checked then exit;
      assignfile(outf, changefileext(paramstr(0), '.log'));
      if fileexists(changefileext(paramstr(0), '.log')) then
        append(outf)
      else
        rewrite(outf);
      writeln(outf, datetimetostr(now)+'|'+inpt);
      closefile(outf);
    end;
     
    procedure TForm1.AddMessage(msg:string; color:integer);
    begin {showing in the memo field progress...}
      while memo.lines.Count>2000 do
        memo.lines.Delete(0);
      memo.sellength:=0;
      memo.selstart:=length(memo.text);
      memo.selattributes.Color:=Color;
      memo.seltext:=#13#10+DateTimeTostr(now)+' '+msg;
      memo.perform($00B7,0,0);
      Application.ProcessMessages;
      if color<>clRed then
        log(DateTimeTostr(now)+' '+msg)
      else
        log('Error: '+DateTimeTostr(now)+' '+msg);
    end;
     
    procedure TForm1.PerformConnection;
    begin
    while (not SMTP.connected) do
      begin
        SetSMTP;
        AddMessage('Connecting to SMTP',clBlue);
        application.processmessages;
        try
          SMTP.Connect;
          AddMessage('No Errors',clBlue);
        except
          on e:exception do AddMessage('Error conection: '+e.message,clBlue);
        end;
      end;
    end;
     
    Function TForm1.SendEmail(_to, cc, bcc, Subject, body,  attachment:string; HTMLFormat:boolean):boolean;
    begin
      PerformConnection;
      result:=true;
      CleanContext;
      try
        if (attachment<>'') and (not Fileexists(attachment)) then
          begin
            AddMessage('Attachment is not ready yet ('+ attachment+') ', clNavy);
            sleep(300);
            result:=false;
            exit;
          end;
        SMTP.PostMessage.ToAddress.text:=StringReplace(_to, ';',#13#10, [rfReplaceAll, rfIgnoreCase]);
        if cc<>'' then SMTP.PostMessage.ToCarbonCopy.text:=StringReplace(cc, ';',#13#10, [rfReplaceAll, rfIgnoreCase]);
        if bcc<>'' then SMTP.PostMessage.ToBlindCarbonCopy.text:=StringReplace(bcc, ';',#13#10, [rfReplaceAll, rfIgnoreCase]);
        if Subject<>'' then SMTP.PostMessage.Subject:=Subject;
        if HTMLFormat then SMTP.SubType:=mtPlain else SMTP.SubType:=mtHtml;
        SMTP.PostMessage.Body.Text:=Body;
        if attachment<>'' then SMTP.PostMessage.Attachments.add(attachment);
        AddMessage('Sending to '+ _to, clGreen);
        SMTP.SendMail;
        AddMessage('Complete.'+#13#10, clGreen);
      except
        on e:sysutils.exception do
          begin
            AddMessage(e.message, clRed);
            result:=false;
          end;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SendEmail('somewhere@somedomain.ru', '', '', 'test', 'body',  '', False);
    end;
     
    end.

А это форма для этого примера:

    object Form1: TForm1
      Left = 278
      Top = 108
      Width = 539
      Height = 480
      Caption = 'Form1'
      Color = clBtnFace
      Font.Charset = DEFAULT_CHARSET
      Font.Color = clWindowText
      Font.Height = -11
      Font.Name = 'MS Sans Serif'
      Font.Style = []
      OldCreateOrder = False
      PixelsPerInch = 96
      TextHeight = 13
      object Memo: TRichEdit
        Left = 0
        Top = 0
        Width = 346
        Height = 420
        Align = alClient
        Lines.Strings = ('Memo')
        TabOrder = 0
      end
      object Panel1: TPanel
        Left = 0
        Top = 420
        Width = 531
        Height = 33
        Align = alBottom
        Caption = 'Panel1'
        TabOrder = 1
        object Button1: TButton
          Left = 440
          Top = 8
          Width = 75
          Height = 25
          Caption = 'Button1'
          TabOrder = 0
          OnClick = Button1Click
        end
      end
      object Panel2: TPanel
        Left = 346
        Top = 0
        Width = 185
        Height = 420
        Align = alRight
        Caption = 'Panel2'
        TabOrder = 2
        object predefined: TLabel
          Left = 8
          Top = 8
          Width = 87
          Height = 13
          Caption = 'predefined values:'
        end
        object FromAddress: TEdit
          Left = 24
          Top = 32
          Width = 121
          Height = 21
          TabOrder = 0
          Text = 'FromAddress'
        end
        object FromName: TEdit
          Left = 24
          Top = 56
          Width = 121
          Height = 21
          TabOrder = 1
          Text = 'FromName'
        end
        object Subject: TEdit
          Left = 24
          Top = 80
          Width = 121
          Height = 21
          TabOrder = 2
          Text = 'Subject'
        end
        object LocalProgram: TEdit
          Left = 24
          Top = 104
          Width = 121
          Height = 21
          TabOrder = 3
          Text = 'LocalProgram'
        end
        object ReplyTo: TEdit
          Left = 24
          Top = 128
          Width = 121
          Height = 21
          TabOrder = 4
          Text = 'ReplyTo'
        end
        object islog: TCheckBox
          Left = 32
          Top = 168
          Width = 97
          Height = 17
          Caption = 'islog'
          TabOrder = 5
        end
        object Host: TEdit
          Left = 24
          Top = 240
          Width = 121
          Height = 21
          TabOrder = 6
          Text = 'Host'
        end
        object Port: TEdit
          Left = 24
          Top = 264
          Width = 121
          Height = 21
          TabOrder = 7
          Text = 'Port'
        end
        object userid: TEdit
          Left = 24
          Top = 288
          Width = 121
          Height = 21
          TabOrder = 8
          Text = 'userid'
        end
      end
      object SMTP: TNMSMTP
        Port = 25
        ReportLevel = 0
        EncodeType = uuMime
        ClearParams = True
        SubType = mtPlain
        Charset = 'us-ascii'
        Left = 296
        Top = 32
      end
    end 

------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

В следующем примере E-mail отправляется автоматически сразу после
нажатия кнопки.

**ЗАМЕЧАНИЕ:**  
Вам потребуется компонент `TNMSMTP`.  
Этот компонент входит в поставляется с Delphi 4 и 5 и его можно найти на закладке `Fastnet`.

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      NMSMTP1.Host := 'smtp.mailserver.com'; 
      NMSMTP1.UserID := 'h.abdullah'; 
      NMSMTP1.Connect; 
      NMSMTP1.PostMessage.FromAddress := 'hasan@excite.com'; 
      NMSMTP1.PostMessage.ToAddress.Text := 'someone@xmail.com'; 
      NMSMTP1.PostMessage.Body.Text := 'Текст письма';
      NMSMTP1.PostMessage.Subject := 'Тема письма';
      NMSMTP1.SendMail; 
    end;

