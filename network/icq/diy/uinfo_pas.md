---
Title: Модуль UInfo.pas
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---


UInfo.pas
=========

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
     
    unit UInfo;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, ComCtrls, Buttons,
      ExtCtrls, Animate,inifiles,
      typess,main,util,packet,
      AppEvnts;
     
    type
      TUserInfo = class(TForm)
        UserInfoDoneBtn: TButton;
        UserInfoRetrieveBtn: TButton;
        InfoPage: TPageControl;
        MainTab: TTabSheet;
        HomeTab: TTabSheet;
        MoreTab: TTabSheet;
        WorkTab: TTabSheet;
        InfoAboutTab: TTabSheet;
        Panel1: TPanel;
        UIAnime: TAnimatedImage;
        GroupBox1: TGroupBox;
        Label1: TLabel;
        Label2: TLabel;
        Label6: TLabel;
        Label9: TLabel;
        uinEd: TEdit;
        ipEd: TEdit;
        realipEd: TEdit;
        verEd: TEdit;
        GroupBox2: TGroupBox;
        Label3: TLabel;
        Label4: TLabel;
        Label7: TLabel;
        Label8: TLabel;
        firstEd: TEdit;
        lastEd: TEdit;
        displayEd: TEdit;
        nickEd: TEdit;
        GroupBox3: TGroupBox;
        Label5: TLabel;
        priEd: TEdit;
        Label10: TLabel;
        Label11: TLabel;
        secEd: TEdit;
        oldEd: TEdit;
        GroupBox4: TGroupBox;
        cityEd: TEdit;
        zipEd: TEdit;
        stateEd: TEdit;
        Label12: TLabel;
        Label13: TLabel;
        Label14: TLabel;
        Label15: TLabel;
        streetMemo: TMemo;
        Label16: TLabel;
        GroupBox5: TGroupBox;
        Label17: TLabel;
        Label18: TLabel;
        Label19: TLabel;
        phoneEd: TEdit;
        cellularEd: TEdit;
        faxEd: TEdit;
        GroupBox6: TGroupBox;
        Label20: TLabel;
        Label21: TLabel;
        Label22: TLabel;
        tzEd: TEdit;
        Edit20: TEdit;
        Edit21: TEdit;
        GroupBox7: TGroupBox;
        Label23: TLabel;
        Label24: TLabel;
        Label25: TLabel;
        homepageEd: TEdit;
        ageEd: TEdit;
        GroupBox8: TGroupBox;
        Label26: TLabel;
        Label27: TLabel;
        Label28: TLabel;
        GroupBox9: TGroupBox;
        GroupBox10: TGroupBox;
        Label29: TLabel;
        Label30: TLabel;
        Label31: TLabel;
        Label32: TLabel;
        Label33: TLabel;
        wcityEd: TEdit;
        wzipEd: TEdit;
        wstateEd: TEdit;
        wstreetMemo: TMemo;
        GroupBox11: TGroupBox;
        Label34: TLabel;
        Label36: TLabel;
        wphoneEd: TEdit;
        wfaxEd: TEdit;
        GroupBox12: TGroupBox;
        Label38: TLabel;
        Label39: TLabel;
        companyEd: TEdit;
        jobEd: TEdit;
        departmentEd: TEdit;
        Label35: TLabel;
        Label37: TLabel;
        whomepageEd: TEdit;
        Label40: TLabel;
        GroupBox13: TGroupBox;
        aboutMemo: TMemo;
        AuthLabel: TLabel;
        Label43: TLabel;
        GroupBox15: TGroupBox;
        interMemo: TMemo;
        countryCombo: TComboBox;
        wcountryCombo: TComboBox;
        genderCombo: TComboBox;
        monthCombo: TComboBox;
        lang1Combo: TComboBox;
        lang2Combo: TComboBox;
        lang3Combo: TComboBox;
        occupationCombo: TComboBox;
        dayCombo: TComboBox;
        yearCombo: TComboBox;
        ApplicationEvents1: TApplicationEvents;
        procedure Request_Meta_Info(UIN : longint);
        procedure Set_Meta_Info;
        procedure UserInfoDoneBtnClick(Sender: TObject);
        procedure UserInfoRetrieveBtnClick(Sender: TObject);
        procedure FormShow(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure SetCountry(Combo:TComboBox; Country:word);
        function GetCountry(Combo:TComboBox):word;
        procedure SetGender(Combo:TComboBox; Gender:byte);
        function GetGender(Combo:TComboBox):byte;
        procedure SetMonth(Combo:TComboBox; Month:byte);
        function GetMonth(Combo:TComboBox):byte;
        procedure SetLanguage(Combo:TComboBox; Lang:byte);
        function GetLanguage(Combo:TComboBox):byte;
        procedure SetOccupation(Combo:TComboBox; Occupation:word);
        function GetOccupation(Combo:TComboBox):word;
        procedure SetCombo(Combo:TComboBox; min,max,Value:word);
        function GetCombo(Combo:TComboBox; min,max:byte):word;
        procedure ApplicationEvents1Message(var Msg: tagMSG;
          var Handled: Boolean);
      private
        { Private declarations }
      public
        AutoRetrieve : boolean;
        UIRecord : TListRecord;
        Cookie : word;
      end;
     
     
    implementation
    {$R *.DFM}
     
    procedure TUserInfo.UserInfoDoneBtnClick(Sender: TObject);
    begin
         Close;
    end;
     
    procedure TUserInfo.Request_Meta_Info(UIN : longint);
    var p,a : pPack;
    begin
         a := PacketNew;
         PacketGoto(a,2);// a[0..1] = len
         PacketAppend32(a,main.UIN);
         PacketAppend16(a,swap($D007));
         Cookie := random($FF) shl 8;
         PacketAppend16(a,swap(Cookie));
         PacketAppend16(a,swap($B204));
         PacketAppend32(a,UIN);
         PacketBegin(a);
         PacketAppend16(a,a.length-2);
     
         P:=CreatePacket(2,SEQ);
         SNACAppend(p,$15,$2);
         TLVAppend(p,1,a.length,@a.data);
         PacketDelete(a);
         Form1.PacketSend(p);
         M(Form1.Memo,'>Request Full Info: '+s(UIN)+'   '+
                      'Cookie:$'+inttohex(Cookie,4));
         UIAnime.Active := true;
    end;
     
    procedure TUserInfo.UserInfoRetrieveBtnClick(Sender: TObject);
    begin
         if (OL and isLogged)then
           Request_Meta_Info(UIRecord.UIN);
    end;
     
     
    procedure TUserInfo.FormShow(Sender: TObject);
    begin
         InfoPage.ActivePageIndex :=0;
         with UIRecord do begin
           uinEd.Text := s(UIN);
           ipEd.Text := IPtoStr(IP);
           realipEd.Text := IPtoStr(REAL_IP);
           verEd.Text := s(VER);
           firstEd.Text := FIRST;
           lastEd.Text := LAST;
           nickEd.Text := NICK;
           displayEd.Text := NICK;
           priEd.Text := PRI_E_MAIL;
           secEd.Text := SEC_E_MAIL;
           oldEd.Text := OLD_E_MAIL;
           cityEd.Text := CITY;
           stateEd.Text := STATE;
           phoneEd.Text := PHONE;
           faxEd.Text := FAX;
           cellularEd.Text := CELLULAR;
           M(streetMemo,STREET);
           SetCountry(countryCombo,COUNTRY);
           SetGender(genderCombo,GENDER);
           ageEd.Text := s(AGE);
           homepageEd.Text := HOMEPAGE;
           SetCombo(yearCombo,1,99,BYEAR);
           SetMonth(monthCombo,BMONTH);
           SetCombo(dayCombo,1,31,BDAY);
           case AUTH of
             0: AuthLabel.Caption := 'Authorize';
             1: AuthLabel.Caption := 'Always';
             else AuthLabel.Caption := 'unknown';
           end;
           SetLanguage(lang1Combo,LANG1);
           SetLanguage(lang2Combo,LANG2);
           SetLanguage(lang3Combo,LANG3);
           M(aboutMemo,ABOUT);
           M(interMemo,INTERESTS);
     
           companyEd.Text :=COMPANY;
           departmentEd.Text := DEPARTMENT;
           jobEd.Text := JOB;
           SetOccupation(occupationCombo,Occupation);
           wcityEd.Text := WCITY;
           wstateEd.Text := WSTATE;
           wphoneEd.Text := WPHONE;
           wfaxEd.Text := WFAX;
           wstreetMemo.Clear;
           M(wstreetMemo,WSTREET);
           SetCountry(wcountryCombo,WCOUNTRY);
           whomepageEd.Text := WHOMEPAGE;
         end;
         if AutoRetrieve then begin
           if (OL and isLogged)then
             Request_Meta_Info(UIRecord.UIN);
         end;
    end;
     
     
    procedure TUserInfo.FormClose(Sender: TObject; var Action: TCloseAction);
    var i : integer;
    begin
         if not AutoRetrieve then begin
           for i:=0 to CLNum-1 do with ContactList[i] do begin
             if UIN = UIRecord.UIN then begin
               ContactList[i] := UIRecord;
               if NICK = '' then begin
                 if FIRST <> '' then NICK := FIRST
                 else if LAST <> '' then NICK := LAST
                      else NICK := s(UIN);
               end; // if
               Form1.WriteToContactList(ContactList[i]);
               break;
             end;
           end; //for
           for i:=0 to Form1.CL.Items.Count-1 do
             if Form1.CL.Items[i].Text <> PListRecord(Form1.CL.Items[i].Data)^.NICK then
               Form1.CL.Items[i].Text := PListRecord(Form1.CL.Items[i].Data)^.NICK;
         end;
         Destroy;
    end;
     
     
    procedure TUserInfo.Set_Meta_Info;
    begin
         // это еще старый кусок из протокола icqv5 (UDP) 
         // CMD_META_USER  + META_CMD_SET_INFO
    (*
         p:=main.UDPCreateStdPacket(CMD_META_USER);
         PacketAppend16(p,META_CMD_SET_INFO);
     
         Cookie := main.UDPSeqNum2-1;
         MetaUIN := main.UIN;
     
         PacketAppendString(p,nickEd.Text);
         PacketAppendString(p,firstEd.Text);
         PacketAppendString(p,lastEd.Text);
         PacketAppendString(p,priEd.Text);
         PacketAppendString(p,secEd.Text);
         PacketAppendString(p,oldEd.Text);
         PacketAppendString(p,cityEd.Text);
         PacketAppendString(p,stateEd.Text);
         PacketAppendString(p,phoneEd.Text);
         PacketAppendString(p,faxEd.Text);
         PacketAppendString(p,streetMemo.Lines[0]);
         PacketAppendString(p,cellularEd.Text);
         try PacketAppend32(p,longint(strtoint(zipEd.Text)));
         except PacketAppend32(p,-1); end;
         PacketAppend16(p,GetCountry(countryCombo));
         PacketAppend8(p,0);  // 250 = +03:00 TimeZone
         PacketAppend8(p,0);  // ????
         main.SendUDPCmd(p,'META_USER+SET_INFO: ['+s(main.UIN)+'] ===>');
     
         // CMD_META_USER  + META_CMD_SET_WORK
         p:=main.UDPCreateStdPacket(CMD_META_USER);
         PacketAppend16(p,META_CMD_SET_WORK);
         PacketAppendString(p,wcityEd.Text);
         PacketAppendString(p,wstateEd.Text);
         PacketAppendString(p,wphoneEd.Text);
         PacketAppendString(p,wfaxEd.Text);
         PacketAppendString(p,wstreetMemo.Lines[0]);
         try PacketAppend32(p,longint(strtoint(wzipEd.Text)));
         except PacketAppend32(p,-1); end;
         PacketAppend16(p,GetCountry(wcountryCombo));
         PacketAppendString(p,companyEd.Text);
         PacketAppendString(p,departmentEd.Text);
         PacketAppendString(p,jobEd.Text);
         PacketAppend16(p,GetOccupation(occupationCombo));
         PacketAppendString(p,whomepageEd.Text);
         main.SendUDPCmd(p,'META_USER+SET_WORK: ['+s(main.UIN)+'] ===>');
     
         // CMD_META_USER  + META_CMD_SET_MORE
         p:=main.UDPCreateStdPacket(CMD_META_USER);
         PacketAppend16(p,META_CMD_SET_MORE);
         try PacketAppend16(p,word(strtoint(ageEd.Text)));
         except PacketAppend16(p,0); end;
         PacketAppend8(p,GetGender(genderCombo));
         PacketAppendString(p,homepageEd.Text);
         PacketAppend8(p,GetCombo(yearCombo,0,99));
         PacketAppend8(p,GetMonth(monthCombo));
         PacketAppend8(p,GetCombo(dayCombo,1,31));
         PacketAppend8(p,GetLanguage(lang1Combo));
         PacketAppend8(p,GetLanguage(lang2Combo));
         PacketAppend8(p,GetLanguage(lang3Combo));
         main.SendUDPCmd(p,'META_USER+SET_MORE: ['+s(main.UIN)+'] ===>');
     
         // CMD_META_USER  + META_CMD_SET_ABOUT
         p:=main.UDPCreateStdPacket(CMD_META_USER);
         PacketAppend16(p,META_CMD_SET_ABOUT);
         PacketAppendString(p,aboutMemo.lines[0]);
         main.SendUDPCmd(p,'META_USER+SET_ABOUT: ['+s(main.UIN)+'] ===>');
     
         // CMD_META_USER  + META_CMD_SET_SECURE
         p:=main.UDPCreateStdPacket(CMD_META_USER);
         PacketAppend16(p,META_CMD_SET_SECURE);
         PacketAppend8(p,1);  //  0-autor required; 1-all users
         PacketAppend8(p,0);  //  0-not allow web;  1-allow web aware
         PacketAppend8(p,0);  //  0-hide IP;    1-show IP
         main.SendUDPCmd(p,'META_USER+SET_SECURE: ['+s(main.UIN)+'] ===>');
    /////
    *)
         UIAnime.Active := true;
    end;
     
    procedure TUserInfo.SetCountry(Combo:TComboBox; Country:word);
    var i : integer;
    begin
          Combo.Clear;
          for i:=0 to 121 do begin
            Combo.Items.Add(Countries[i].Text);
            if Countries[i].Code = Country then Combo.Text := Countries[i].Text;
          end;
          if Combo.Text = '' then Combo.Text := Countries[121].Text;
    end;
     
    function TUserInfo.GetCountry(Combo:TComboBox):word;
    var i : integer;
    begin
         Result := $FFFF;
          for i:=0 to 121 do begin
            if Countries[i].Text = Combo.Text then begin
               Result := Countries[i].Code;
               break;
            end;
          end;
    end;
     
    procedure TUserInfo.SetGender(Combo:TComboBox; Gender:byte);
    begin
          Combo.Clear;
          Combo.Items.Add('Not specified');
          Combo.Items.Add('Female');
          Combo.Items.Add('Male');
          case Gender of
            0: Combo.Text := 'Not specified';
            1: Combo.Text := 'Female';
            2: Combo.Text := 'Male';
            else Combo.Text := 'Not specified';
          end;
    end;
     
    function TUserInfo.GetGender(Combo:TComboBox):byte;
    begin
         Result := 0;
         if Combo.Text = 'Female' then Result := 1
         else if Combo.Text = 'Male' then Result := 2;
    end;
     
    procedure TUserInfo.SetMonth(Combo:TComboBox; Month:byte);
    var i : integer;
    begin
          Combo.Clear;
          for i:=0 to 12 do begin
            Combo.Items.Add(MetaMonth[i].Text);
            if MetaMonth[i].Code = Month then Combo.Text := MetaMonth[i].Text;
          end;
          if Combo.Text = '' then Combo.Text := MetaMonth[12].Text;
    end;
     
    function TUserInfo.GetMonth(Combo:TComboBox):byte;
    var i : integer;
    begin
         Result := 0;
          for i:=0 to 12 do begin
            if MetaMonth[i].Text = Combo.Text then begin
               Result := MetaMonth[i].Code;
               break;
            end;
          end;
    end;
     
    procedure TUserInfo.SetLanguage(Combo:TComboBox; Lang:byte);
    var i : integer;
    begin
          Combo.Clear;
          for i:=0 to 67 do begin
            Combo.Items.Add(MetaLanguages[i].Text);
            if MetaLanguages[i].Code = Lang then Combo.Text := MetaLanguages[i].Text;
          end;
          if Combo.Text = '' then Combo.Text := MetaLanguages[0].Text;
    end;
     
    function TUserInfo.GetLanguage(Combo:TComboBox):byte;
    var i : integer;
    begin
         Result := 0;
          for i:=0 to 67 do begin
            if MetaLanguages[i].Text = Combo.Text then begin
               Result := MetaLanguages[i].Code;
               break;
            end;
          end;
    end;
     
    procedure TUserInfo.SetOccupation(Combo:TComboBox; Occupation:word);
    var i : integer;
    begin
          Combo.Clear;
          for i:=0 to 28 do begin
            Combo.Items.Add(MetaOccupation[i].Text);
            if MetaOccupation[i].Code = Occupation then Combo.Text := MetaOccupation[i].Text;
          end;
          if Combo.Text = '' then Combo.Text := MetaOccupation[28].Text;
    end;
     
    function TUserInfo.GetOccupation(Combo:TComboBox):word;
    var i : integer;
    begin
         Result := 0; // not specified
          for i:=0 to 27 do begin
            if MetaOccupation[i].Text = Combo.Text then begin
               Result := MetaOccupation[i].Code;
               break;
            end;
          end;
    end;
     
    procedure TUserInfo.SetCombo(Combo:TComboBox; min,max,Value:word);
    var i : integer;
    begin
          Combo.Clear;
          for i:=min to max do begin
            Combo.Items.Add(s(i));
            if i=Value then Combo.Text := s(i);
          end;
          Combo.Items.Add('Not specified');
          if Combo.Text = '' then Combo.Text := 'Not specified';
    end;
     
    function TUserInfo.GetCombo(Combo:TComboBox; min,max:byte):word;
    begin
         Result := 0;
         if Combo.Text = 'Not specified' then exit
         else
         try Result := strtoint(Combo.Text) except Result := 0; end;
         if (Result >= min) and (Result<=max) then exit else Result := 0;
    end;
     
     
    procedure TUserInfo.ApplicationEvents1Message(var Msg: tagMSG;
      var Handled: Boolean);
    var  PBuff : PInfoRec;
    begin
         if Msg.message = msg_UInfo then begin
           if (Msg.wParam = Cookie)then begin
             Handled := false;
             PBuff := PInfoRec(Msg.lParam);
             case PBuff^.f of
              dEND: begin
                       M(Form1.Memo,'The END.');
                       UIAnime.Active := false;
                     end;
              dNick: begin
                       UIRecord.NICK := PBuff^.s;
                       NickEd.Text := PBuff^.s;
                     end;
              dFirst: begin
                       UIRecord.FIRST := PBuff^.s;
                       FirstEd.Text := PBuff^.s;
                     end;
              dLast: begin
                       UIRecord.LAST := PBuff^.s;
                       LastEd.Text := PBuff^.s;
                     end;
              dE_Mail: begin
                       UIRecord.PRI_E_MAIL := PBuff^.s;
                       priEd.Text := PBuff^.s;
                     end;
              dSec_E_Mail: begin
                       UIRecord.SEC_E_MAIL := PBuff^.s;
                       secEd.Text := PBuff^.s;
                     end;
              dOld_E_Mail: begin
                       UIRecord.OLD_E_MAIL := PBuff^.s;
                       oldEd.Text := PBuff^.s;
                     end;
              dIP: begin
                       strtoip(PBuff^.s,UIRecord.IP);
                       ipEd.Text := PBuff^.s;
                     end;
              dReal_IP: begin
                       strtoip(PBuff^.s,UIRecord.REAL_IP);
                       realipEd.Text := PBuff^.s;
                     end;
              dVer: begin
                       UIRecord.VER := strtoint(PBuff^.s);
                       verEd.Text := PBuff^.s;
                     end;
              dAuth: begin
                       UIRecord.AUTH := strtoint(PBuff^.s);
                       case UIRecord.AUTH of
                         0: AuthLabel.Caption := 'Authorize';
                         1: AuthLabel.Caption := 'Always';
                         else AuthLabel.Caption := 'unknown';
                       end;
                     end;
              dCity: begin
                       UIRecord.CITY := PBuff^.s;
                       cityEd.Text := PBuff^.s;
                     end;
              dState: begin
                       UIRecord.STATE := PBuff^.s;
                       stateEd.Text := PBuff^.s;
                     end;
              dPhone: begin
                       UIRecord.Phone := PBuff^.s;
                       PhoneEd.Text := PBuff^.s;
                     end;
              dFax: begin
                       UIRecord.Fax := PBuff^.s;
                       FaxEd.Text := PBuff^.s;
                     end;
              dCellular: begin
                       UIRecord.Cellular := PBuff^.s;
                       CellularEd.Text := PBuff^.s;
                     end;
              dZip: begin
                       UIRecord.Zip := PBuff^.s;
                       ZipEd.Text := PBuff^.s;
                     end;
              dStreet: begin
                       UIRecord.Street := PBuff^.s;
                       streetMemo.Clear;
                       M(streetMemo,PBuff^.s);
                     end;
              dCountry: begin
                       UIRecord.Country := strtoint(PBuff^.s);
                       SetCountry(countryCombo,UIRecord.COUNTRY);
                     end;
              dTimeZone: begin
                       UIRecord.TimeZone := strtoint(PBuff^.s);
                       tzEd.Text := PBuff^.s;
                     end;
              dWebAware: begin
        //               UIRecord.WebAware := strtoint(PBuff^.s);
        //               webawareEd.Text := PBuff^.s;
                     end;
              dHideIP: begin
        //               UIRecord.HideIP := PBuff^.s;
        //               HideIPEd.Text := PBuff^.s;
                     end;
              dAge: begin
                       UIRecord.Age := strtoint(PBuff^.s);
                       AgeEd.Text := PBuff^.s;
                     end;
              dGender: begin
                       UIRecord.Gender := strtoint(PBuff^.s);
                       SetGender(genderCombo,UIRecord.GENDER);
                     end;
              dHomepage: begin
                       UIRecord.Homepage := PBuff^.s;
                       HomepageEd.Text := PBuff^.s;
                     end;
              dByear: begin
                       UIRecord.Byear := strtoint(PBuff^.s);
                       if UIRecord.Byear<>0 then dec(UIRecord.Byear,1900);
                       SetCombo(yearCombo,1,99,UIRecord.Byear);
                     end;
              dBmonth: begin
                       UIRecord.BMonth := strtoint(PBuff^.s);
                       SetMonth(monthCombo,UIRecord.BMonth);
                     end;
              dBday: begin
                       UIRecord.Bday := strtoint(PBuff^.s);
                       SetCombo(dayCombo,1,31,UIRecord.Bday);
                     end;
              dAbout: begin
                       UIRecord.ABOUT := PBuff^.s;
                       AboutMemo.Clear;
                       M(AboutMemo,PBuff^.s);
                     end;
              dLang1: begin
                       UIRecord.LANG1 := strtoint(PBuff^.s);
                       SetLanguage(lang1Combo,UIRecord.LANG1);
                     end;
              dLang2: begin
                       UIRecord.LANG2 := strtoint(PBuff^.s);
                       SetLanguage(lang2Combo,UIRecord.LANG2);
                     end;
              dLang3: begin
                       UIRecord.LANG3 := strtoint(PBuff^.s);
                       SetLanguage(lang3Combo,UIRecord.LANG3);
                     end;
              dInterests: begin
                       UIRecord.INTERESTS := PBuff^.s;
                       interMemo.Clear;
                       M(interMemo,PBuff^.s);
                     end;
              dFailure: begin
        ///////////////////////////// ?????
                     end;
              dMeta_Srv_Res: begin
                       UIAnime.Active := false;
                     end;
              dwCity: begin
                       UIRecord.WCITY := PBuff^.s;
                       wcityEd.Text := PBuff^.s;
                      end;
              dwState:begin
                       UIRecord.WSTATE := PBuff^.s;
                       wstateEd.Text := PBuff^.s;
                      end;
              dwPhone:begin
                       UIRecord.WPHONE := PBuff^.s;
                       wphoneEd.Text := PBuff^.s;
                      end;
              dwFax:begin
                       UIRecord.WFAX := PBuff^.s;
                       wfaxEd.Text := PBuff^.s;
                      end;
              dwStreet:begin
                       UIRecord.WSTREET := PBuff^.s;
                       wstreetMemo.Clear;
                       M(wstreetMemo,PBuff^.s);
                      end;
              dwZip:begin
                       UIRecord.WZIP := PBuff^.s;
                       wzipEd.Text := PBuff^.s;
                      end;
              dwCountry:begin
                       UIRecord.WCOUNTRY := strtoint(PBuff^.s);
                       SetCountry(wcountryCombo,UIRecord.WCOUNTRY);
                      end;
              dCompany:begin
                       UIRecord.COMPANY := PBuff^.s;
                       companyEd.Text := PBuff^.s;
                      end;
              dDepartment:begin
                       UIRecord.DEPARTMENT := PBuff^.s;
                       departmentEd.Text := PBuff^.s;
                      end;
              dJob:begin
                       UIRecord.JOB := PBuff^.s;
                       jobEd.Text := PBuff^.s;
                      end;
              dOccupation:begin
                       UIRecord.OCCUPATION := strtoint(PBuff^.s);
                       SetOccupation(occupationCombo,UIRecord.Occupation);
                      end;
              dWhomepage:begin
                       UIRecord.WHOMEPAGE := PBuff^.s;
                       whomepageEd.Text := PBuff^.s;
                      end;
              end; // case
              Dispose(PBuff);
           end;
         end;
    end;
     
    end.
