---
Title: Пример получения информации о NETBIOS именах компьютера
Date: 01.01.2007
Author: Rouse_
Source: <https://rouse.drkb.ru>
---


Пример получения информации о NETBIOS именах компьютера
=======================================================

(аналог nbtstat -a).


    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Unit Name : Unit1
    //  * Purpose   : Демо получение информации NETBIOS именах компьютера
    //                (аналог nbtstat -a)
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, Nb30, StdCtrls;
     
    type
      TNetbiosInfo = record
        AdapterStatus: TAdapterStatus;
        NameBuffer: Array [0..30] of TNameBuffer;
      end;
     
      TForm1 = class(TForm)
        Edit1: TEdit;
        Button1: TButton;
        Memo1: TMemo;
        procedure Button1Click(Sender: TObject);
      private
        procedure GetNetBiosNames(const Addr: String);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.GetNetBiosNames(const Addr: String);
    var
      NCB: TNCB;
      Enum: TLanaEnum;
      NetbiosInfo: TNetbiosInfo;
      I, A: Integer;
      Ends: Byte;
    begin
      FillChar(NCB, SizeOf(TNCB), #0);
      NCB.ncb_command := Char(NCBENUM);
      NCB.ncb_buffer := @Enum;
      NCB.ncb_length := SizeOf(TLanaEnum);
      if Netbios(@NCB) = Char(NRC_GOODRET) then
        for I := 0 to Integer(Enum.length) - 1 do
        begin
          FillChar(NCB, SizeOf(TNCB), #0);
          NCB.ncb_lana_num := Enum.lana[I];
          NCB.ncb_command := Char(NCBRESET);
          if Netbios(@NCB) = Char(NRC_GOODRET) then
          begin
            FillChar(NetbiosInfo, SizeOf(TNetbiosInfo), #0);
            NCB.ncb_command := Char(NCBASTAT);
            Move(Addr[1], NCB.ncb_callname[0], Length(Addr));
            NCB.ncb_buffer := @NetbiosInfo;
            NCB.ncb_length := SizeOf(TNetbiosInfo);
            if Netbios(@NCB) = Char(NRC_GOODRET) then
              for A := 0 to NetbiosInfo.AdapterStatus.name_count - 1 do
              begin
                Ends := Byte(NetbiosInfo.NameBuffer[A].name[NCBNAMSZ - 1]);
                NetbiosInfo.NameBuffer[A].name[NCBNAMSZ - 1] := #32;
                Memo1.Lines.Add(Format('%s <%s>',
                  [String(NetbiosInfo.NameBuffer[A].name),
                    IntToHex(Ends, 2)]));
              end;
          end;
        end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      GetNetBiosNames(Edit1.Text);
    end;
     
    end.



Скачать демонстрационный пример: [nbstat.zip](nbstat.zip) 2K

