---
Title: Модуль MessForm.pas
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---

MessForm.pas
============

статья: [ICQ2000 - сделай сам](./)

    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Author:       Alexander Vaga
    EMail:        primary:   icq2000cc@hobi.ru
                  secondary: alexander_vaga@hotmail.com
    Web:          http://icq2000cc.hobi.ru
    Creation:     May, 2002
    Legal issues: Copyright (C) 2002 by Alexander Vaga
                  Kyiv, Ukraine
     
                  This software is provided 'as-is', without any express or
                  implied warranty.  In no event will the author be held liable
                  for any  damages arising from the use of this software.
     
                  Permission is granted to anyone to use this software for any
                  purpose, including commercial applications, and to alter it
                  and redistribute it freely.
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *}
     
    unit MessFrom;
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics,
      Controls, Forms, Dialogs,  StdCtrls,
      ComCtrls, ToolWin, AppEvnts, ExtCtrls,
      Types,Packet,Main,SendMess;
     
    type
      TMessageFrom = class(TForm)
        MsgMemo: TMemo;
        ApplicationEvents1: TApplicationEvents;
        Panel1: TPanel;
        NextButton: TButton;
        ReplyButton: TButton;
        CancelButton: TButton;
        Panel2: TPanel;
        ToolBar1: TToolBar;
        UINi: TToolButton;
        NNEd: TEdit;
        Label1: TLabel;
        Label2: TLabel;
        Label3: TLabel;
        ICQEd: TEdit;
        DateEd: TEdit;
        procedure CancelButtonClick(Sender: TObject);
        procedure ApplicationEvents1Message(var Msg: tagMSG;
          var Handled: Boolean);
        procedure SendTimerTimer(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure FormShow(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure NextButtonClick(Sender: TObject);
        procedure ReplyButtonClick(Sender: TObject);
        procedure MsgMemoEnter(Sender: TObject);
      private
        { Private declarations }
      public
        User : PListRecord;
        FromWhom : longint;
        Find : PMsgItem;
        { Public declarations }
      end;
     
    implementation
     
    {$R *.DFM}
     
    procedure TMessageFrom.CancelButtonClick(Sender: TObject);
    begin
         Close;
    end;
     
    procedure TMessageFrom.ApplicationEvents1Message(var Msg: tagMSG;
      var Handled: Boolean);
    begin
         if Msg.message = msg_NextOFF then begin
           if (Msg.wParam = msg_NextOFF)and(Msg.lParam = User^.UIN) then begin
             Handled := true;
             NextButton.Enabled := false;
             NextButton.Caption := 'Next';
           end;
         end;
         if Msg.message = msg_NextON then begin
           if (Msg.lParam = User^.UIN) then begin
             Handled := true;
             NextButton.Enabled := true;
             NextButton.Caption := 'Next > ('+s(Msg.wParam)+')';
           end;
         end;
    end;
     
    procedure TMessageFrom.SendTimerTimer(Sender: TObject);
    begin
         Close;
    end;
     
    procedure TMessageFrom.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
         if Find<>nil then begin
           FreeMem(Find^.Text,Find^.Len);
           Dispose(Find);
         end;
         Destroy;
    end;
     
    procedure TMessageFrom.FormShow(Sender: TObject);
    var  sTmp : string;
    var  node : TTReeNode;
         i,CntMsg : integer;
         Count : PMsgItem;
    begin
         NextButton.Enabled := false;
         if User^.EXTRA.ICON_INDEX = simply_icq then
           UINi.ImageIndex := offline else
           UINi.ImageIndex := User^.EXTRA.ICON_INDEX;
     
         // Get First Msg
         if User^.PMSG = nil then exit;
         Find := User^.PMSG;
         if User^.PMSG^.Next=nil then User^.PMSG := nil
         else User^.PMSG := User^.PMSG^.Next;
     
         // Count ALL other messages
         CntMsg:=0;
         Count:=User^.PMSG;
         while Count<>nil do begin
           inc(CntMsg);
           if Count^.Next<>nil then
             Count:=Count^.Next
           else Count:=nil;
         end;
         //
         if CntMsg>0then PostMessage(Handle,msg_NextON,CntMsg,User^.UIN)
         else begin
           User^.EXTRA.MES_IS := false; //Blink OFF
           for i:=0 to Form1.CL.Items.Count-1 do begin
             node:=Form1.CL.Items.Item[i];
             if PListRecord(node.Data)^.UIN=User^.UIN  then begin
                 node.ImageIndex := PListRecord(node.Data)^.EXTRA.ICON_INDEX;
                 node.SelectedIndex := node.ImageIndex;
                 PostMessage(Handle,msg_NextOFF,msg_NextOFF,User^.UIN);
             end;
           end;
         end;
     
         // Get & Put Data
         setlength(sTmp,Find^.Len);
         move(Find^.Text^,sTmp[1],Find^.Len);
         MsgMemo.Clear;
         MsgMemo.Color := StringToColor(Find^.BG);
         MsgMemo.Font.Color := StringToColor(Find^.FG);
         MsgMemo.Text := sTmp;
         ICQed.Text := s(Find^.FromUIN);
         DateED.Text := Find^.DateTime;
         NNed.Text := User^.NICK;
    end;
     
    procedure TMessageFrom.FormCreate(Sender: TObject);
    begin
         Find := nil;
    end;
     
    procedure TMessageFrom.NextButtonClick(Sender: TObject);
    begin
         FormShow(self);
    end;
     
    procedure TMessageFrom.ReplyButtonClick(Sender: TObject);
    var TSM : TMessageTo;
        i : integer;
        s : string;
    begin
         Application.CreateForm(TMessageTo,TSM);
         TSM.ICQEd.Text :=ICQEd.Text;
         TSM.NNEd.Text := NNEd.Text;
         TSM.User := User;
         TSM.FromWhom := UIN; // it is MY UIN
         TSM.Caption := 'Send Message To '+NNEd.Text;
     
         s:='';
         for i:=0 to MsgMemo.Lines.Count-1 do
           s:=s+'[>] '+MsgMemo.Lines[i]+#13#10;
         TSM.SendMemo.Text :='on '+DateED.Text+', You wrote:'#13#10+s;
         TSM.SendMemo.Selstart := Length (TSM.SendMemo.Text);
         TSM.Show;
         Close;
    end;
     
    procedure TMessageFrom.MsgMemoEnter(Sender: TObject);
    begin
         ReplyButton.SetFocus;
    end;
     
    end.
