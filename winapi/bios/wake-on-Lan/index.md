---
Title: Разбудить компьютер по сети, Использование Bios Wake-on-Lan
Author: Song
Source: <https://forum.sources.ru>
Date: 01.01.2007
---


Разбудить компьютер по сети, Использование Bios Wake-on-Lan
===========================================================

    {$APPTYPE CONSOLE}
     
    uses
      SysUtils,
      Classes,
      IdBaseComponent,
      IdComponent,
      IdUDPBase,
      IdUDPClient;
     
    function HexStringToBinString(const HexStr: string): string;
    var
      i, l: integer;
    begin
      Result := '';
      l := length(HexStr);
      l := l div 2;
      SetLength(Result, l);
      for i := 1 to l do
        if HexToBin(PChar(Copy(HexStr, (i - 1) * 2 + 1, 2)),
          PChar(@Result[i]), 1) = 0 then
          raise Exception.Create('Invalid hex value');
    end;
     
    procedure SendMagicPacket(MACAddress: string);
    var
      s, packet: string;
      i: integer;
    begin
      if Length(MACAddress) <> 12 then
        raise Exception.CreateFmt('Invalid MAC Address: %s', [MACAddress]);
      packet := HexStringToBinString('FFFFFFFFFFFF');
      s := HexStringToBinString(MACAddress);
      for i := 1 to 16 do
        packet := packet + s;
      with TIdUDPClient.Create(nil) do
      try
        Active := true;
        BroadcastEnabled := true;
        Broadcast(packet, 9);
      finally
        Free;
      end;
    end;
     
    begin
      if ParamCount <> 1 then
        WriteLn('usage: WakeOnLan MACAddress' + #10 + #13 + 'exmple: WakeOnLan 000102030405')
      else
        SendMagicPacket(ParamStr(1));
    end.

