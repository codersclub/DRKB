---
Title: Модуль Packet.pas
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---


Packet.pas
==========

статья: [ICQ2000 - сделай сам](./)

    {* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Author:       Alexander Vaga
    EMail:        alexander_vaga@hotmail.com
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
     
    unit Packet;
    interface
    uses Types,SysUtils,Math,StdCtrls,
         Windows,Winsock;
     
    const OL : booLean = false;
     
    function  CreatePacket(ChID:byte; var SEQ:word) : PPack;
    function  PacketNew : PPack;
    procedure PacketDelete(p:PPack);
    procedure PacketAppend8(p : PPack; i : byte);
    procedure PacketAppend16(p : PPack; i : word);
    procedure PacketAppend32(p : PPack; i : longint);
    procedure SetLengthPacket(p : PPack);
    procedure TLVAppendStr(p : PPack; T:word;V:string);
    function  TLVReadStr(p : PPack; var V:string):word;
    procedure TLVAppendWord(p : PPack; T:word;V:word);
    procedure TLVAppendDWord(p : PPack; T:word;V:longint);
    function  TLVReadWord(p : PPack; var V:word):word;
    function  TLVReadDWord(p : PPack; var V:longint):word;
    procedure TLVAppend(p : PPack; T:word;L:word;V:pointer);
    procedure SNACAppend(p : PPack; FamilyID,SubTypeID:word);
    function  PacketRead8(p : PPack): byte;
    function  PacketRead16(p : PPack): word;
    function  PacketRead32(p : PPack): longint;
    procedure PacketAdvance(p:PPack; i : integer);
    procedure PacketAppendB_String(p:PPack; s:string);
    procedure PacketAppendString(p:PPack; s:string);
    procedure PacketAppendStringFE(p:PPack; s:string);
    procedure PacketAppend(p:PPack; what:pointer; len:integer);
    procedure PacketRead(p:PPack; Buf:pointer; length:integer);
    function  PacketReadString(p:PPack):string;
    function  PacketReadB_String(p:PPack):string;
    procedure PacketBegin(p:PPack);
    procedure PacketEnd(p:PPack);
    procedure PacketGoto(p:PPack; i:integer);
    function  PacketPos(p:PPack):word;
    function  Swap(InWord:word):word;
    function  DSwap(InLong:longint):longint;assembler;
    function  Dim2Hex(what:pointer;len:integer):string;
    function  Dim2Str(what:pointer;len:integer):string;
    procedure StrToIP(sIP:string; var aIP:IParray);
    function  IPtoStr(var aIP:IParray):string;
    function  UTC2LT(year,month,day,hour,min:integer) : TDateTime;
    function  Now2DateTime : TDateTime;
    function  SecsSince1970:longint;
    function Get_my_IP: string;
    function Calc_Pass(PassIN : string):string;
    function  s(i : longint) : string;
    procedure M(Memo:TMemo; s:string);
     
     
    implementation
     
    function CreatePacket(ChID:byte; var SEQ:word) : PPack;
    var p : PPack;
    begin
          p := PacketNew;
          PacketAppend8(p, $2A);
          PacketAppend8(p, ChID);
          PacketAppend16(p, swap(SEQ));  inc(SEQ);
          PacketAppend16(p, 0); // length - must be filled
          Result := p;
    end;
     
    function PacketNew : PPack;
    var p : PPack;
    begin
       New(p);
       fillchar(p^,sizeof(Pack),0);
       p^.cursor :=0;
       p^.length :=0;
       PacketNew := p;
    end;
     
    procedure PacketDelete(p:PPack);
    begin
         Dispose(p);
    end;
     
    procedure PacketAdvance(p:PPack; i : integer);
    begin
         p^.cursor := p^.cursor+i;
         if p^.cursor > p^.length then
            p^.length := p^.cursor;
    end;
     
    procedure PacketAppend8(p : PPack; i : byte);
    begin
         PBYTE(@(p^.data[p^.cursor]))^ := i;
         PacketAdvance(p,sizeof(byte));
    end;
     
    procedure PacketAppend16(p : PPack; i : word);
    begin
         PWORD(@(p^.data[p^.cursor]))^ := i;
         PacketAdvance(p,sizeof(word));
    end;
     
    procedure PacketAppend32(p : PPack; i : longint);
    begin
         PLONG(@(p^.data[p^.cursor]))^ := i;
         PacketAdvance(p,sizeof(longint));
    end;
     
    procedure SetLengthPacket(p : PPack);
    begin
          PFLAP_HDR(@(p^.data))^.Len := swap(p^.length-sizeof(FLAP_HDR));
    end;
     
    procedure TLVAppendStr(p : PPack; T:word;V:string);
    var i : integer;
    begin
         PacketAppend16(p,swap(T));  // add TYPE
         PacketAppend16(p,swap(length(V))); // add LEN
         for i:=1 to Length(V) do           // add VALUE (variable)
           PacketAppend8(p,byte(V[i]));
    end;
     
    function TLVReadStr(p : PPack; var V:string):word;
    var i,L : integer;
    begin
         V:='';
         Result := swap(PacketRead16(p));
         L := swap(PacketRead16(p));
         for i:=1 to L do  // add VALUE (variable)
           V:=V+char(PacketRead8(p));
    end;
     
     
    procedure TLVAppendWord(p : PPack; T:word;V:word);
    begin
         PacketAppend16(p,swap(T));  // add TYPE
         PacketAppend16(p,swap(sizeof(word)));  // add LEN
         PacketAppend16(p,swap(V)); // add VALUE
    end;
     
    function TLVReadWord(p : PPack; var V:word):word;
    begin
         Result := swap(PacketRead16(p));  // get TYPE
         if swap(PacketRead16(p))<>0 then  // xxxx LEN (word=2)
           V := swap(PacketRead16(p));  // get 16-VALUE
    end;
     
    procedure TLVAppendDWord(p : PPack; T:word;V:longint);
    begin
         PacketAppend16(p,swap(T));  // add TYPE
         PacketAppend16(p,swap(sizeof(longint)));  // add LEN
         PacketAppend32(p,dswap(V)); // add VALUE
    end;
     
    function TLVReadDWord(p : PPack; var V:longint):word;
    begin
         Result := swap(PacketRead16(p));  // get TYPE
         if swap(PacketRead16(p))<>0 then  // xxxx LEN (word=2)
           V := dswap(PacketRead32(p));  // get 32-VALUE
    end;
     
    procedure TLVAppend(p : PPack; T:word;L:word;V:pointer);
    begin
         PacketAppend16(p,swap(T));  // add TYPE
         PacketAppend16(p,swap(L));  // add LEN
         PacketAppend(p,V,L); // add VALUE (variable)
    end;
     
    procedure SNACAppend(p : PPack; FamilyID,SubTypeID:word);
    begin
         PacketAppend16(p, swap(FamilyID));
         PacketAppend16(p, swap(SubTypeID));
         PacketAppend16(p, swap($0000));
     
         PacketAppend16(p, Swap(random($FF))); // 00 4D 00 xx
         PacketAppend16(p, Swap(SubTypeID));
    end;
     
    function PacketRead8(p : PPack): byte;
    var val : byte;
    begin
                 val := PBYTE(@(p^.data[p^.cursor]))^;
            PacketAdvance(p, sizeof(byte));
            Result := val;
    end;
     
    function PacketRead16(p : PPack): word;
    var val : word;
    begin
              val := PWORD(@(p^.data[p^.cursor]))^;
            PacketAdvance(p, sizeof(word));
            Result := val;
    end;
     
    function PacketRead32(p : PPack): longint;
    var val : longint;
    begin
            val := PLONG(@(p^.data[p^.cursor]))^;
            PacketAdvance(p, sizeof(longint));
            Result := val;
    end;
     
    procedure PacketAppendB_String(p:PPack; s:string);
    var i : integer;
    begin
         PacketAppend8(p, length(s));
         for i:=1 to length(s) do
           PacketAppend8(p,byte(s[i]));
    end;
     
    procedure PacketAppendString(p:PPack; s:string);
    var len : word;
        sStr : string;
        i : integer;
    begin
        if s <> '' then begin
          sStr := s+#0;
          len := length(sStr);
          PacketAppend16(p, len);
          for i:=1 to len do begin
            PBYTE(@(p^.data[p^.cursor]))^ := byte(sStr[i]);
            PacketAdvance(p,sizeof(byte));
          end;
        end else begin
          PacketAppend16(p, 1);
          PacketAppend8(p,0);
        end;
    end;
     
    function PacketReadString(p:PPack):string;
    var length : word;
        sTemp : string;
        dTemp : TByteArray;
    begin
          length := PacketRead16(p);
          setlength(sTemp,length-1);
          PacketRead(p, @dTemp,length);
          if length = 1 then Result := ''
          else begin
            move(dTemp,sTemp[1],length-1); // -1 = without #00
            Result := sTemp;
          end;
    end;
     
    function PacketReadB_String(p:PPack):string;
    var length : byte;
        dTemp : TByteArray;
    begin
         length := PacketRead8(p);
         setlength(Result,length);
         PacketRead(p, @dTemp,length);
         move(dTemp,Result[1],length);
    end;
     
    procedure PacketAppend(p:PPack; what:pointer; len:integer);
    begin
         move(what^, PBYTE(@(p^.data[p^.cursor]))^, len);
         PacketAdvance(p, len);
    end;
     
    procedure PacketRead(p:PPack; Buf:pointer; length:integer);
    begin
         move(p^.data[p^.cursor],Buf^,length);
         PacketAdvance(p, length);
    end;
     
    procedure PacketAppendStringFE(p:PPack; s:string);
    var len : integer;
    begin
          if s <> '' then begin
            len := length(s);
             PacketAppend(p, PChar(s[1]), len);
          end;
          PacketAppend8(p, $FE);
    end;
     
    procedure PacketBegin(p:PPack);
    begin
         p^.cursor := 0;
    end;
     
    procedure PacketEnd(p:PPack);
    begin
         p^.cursor := p^.length;
    end;
     
    procedure PacketGoto(p:PPack; i:integer);
    begin
         PacketBegin(p);
         PacketAdvance(p, i);
    end;
     
    function PacketPos(p:PPack):word;
    begin
         result := p^.cursor;
    end;
     
    function Swap(InWord:word):word;
    begin
         Result := (lo(InWord)shl 8)+hi(InWord);
    end;
     
     
    function DSwap(InLong:longint):longint;assembler;
    asm
       MOV EAX,InLong
       BSWAP EAX
       MOV Result,EAX
    end;
     
    function Dim2Hex(what:pointer;len:integer):string;
    var i : integer;
        b : byte;
    begin
         Result:='';
         for i:=0 to len-1 do begin
           b:=PByteArray(what)^[i];
           Result := Result+inttohex(b,2)+' ';
         end;
    end;
     
    function Dim2Str(what:pointer;len:integer):string;
    var i : integer;
        b : byte;
    begin
         Result:='';
         for i:=0 to len-1 do begin
           b:=PByteArray(what)^[i];
           if b<32 then b:=byte('.');
           Result := Result+char(b)+'  ';
         end;
    end;
     
    (****************************************************************)
    procedure StrToIP(sIP:string; var aIP:IParray);
    var sTemp : string;
        aPos,bPos,cPos : integer;
    begin
         longint(aIP) := 0;  if sIP = '' then exit;
         sTemp := sIP;
         aPos := pos('.',sTemp); if aPos = 0 then exit;
         sTemp[aPos] := 'a';
         bPos := pos('.',sTemp); if bPos = 0 then exit;
         sTemp[bPos] := 'b';
         cPos := pos('.',sTemp); if cPos = 0 then exit;
         sTemp[cPos] := 'c';
         try aIP[0] := strtoint(copy(sTemp,1,aPos-1)); except end;
         try aIP[1] := strtoint(copy(sTemp,aPos+1,bPos-aPos-1)); except end;
         try aIP[2] := strtoint(copy(sTemp,bPos+1,cPos-bPos-1)); except end;
         try aIP[3] := strtoint(copy(sTemp,cPos+1,length(sTemp)-cPos)); except end;
    end;
     
    (****************************************************************)
    function IPtoStr(var aIP:IParray):string;
    begin
         IPtoStr := s(aIP[0])+'.'+s(aIP[1])+'.'+s(aIP[2])+'.'+s(aIP[3]);
    end;
     
    (****************************************************************)
    function UTC2LT(year,month,day,hour,min:integer) : TDateTime;
    var r : longword;
        Time : TDateTime;
        TimeStamp : TTimeStamp;
        TZ_INFO   : TIME_ZONE_INFORMATION;
    begin
        r := GetTimeZoneInformation(_Time_Zone_Information(TZ_INFO));
        TimeStamp := DateTimeToTimeStamp(EncodeDate(year,month,day)+EncodeTime(hour,min,0,0));
        Time := TimeStampToDateTime(TimeStamp);
        if r = TIME_ZONE_ID_UNKNOWN        then Result := Time
        else Result := Time-((TZ_INFO.Bias+60)/1440);
    end;
     
    (****************************************************************)
    function Now2DateTime : TDateTime;
    var Time : TDateTime;
        TimeStamp : TTimeStamp;
        year,month,day,hour,min,secs,msecs : word;
    begin
        DecodeDate(Now, Year, Month, Day);
        DecodeTime(Now,Hour,Min,Secs,Msecs);
        TimeStamp := DateTimeToTimeStamp(EncodeDate(year,month,day)+EncodeTime(hour,min,0,0));
        Time := TimeStampToDateTime(TimeStamp);
        Result := Time;
    end;
     
    function SecsSince1970:longint;
    var s1970, sNow : TTimeStamp;
    begin
         s1970 := DateTimeToTimeStamp(EncodeDate(1970,1,1));
         sNow := DateTimeToTimeStamp(Now);
         SecsSince1970 := Floor(TimeStampToMSecs(sNow)/1000 - TimeStampToMSecs(s1970)/1000);
    end;
     
    function Get_my_IP: string;
    var wVersionRequested : WORD;
        wsaData : TWSAData;
        p : PHostEnt;
        s : array[0..128] of char;
        p2 : pchar;
    begin
         Result := '127.0.0.1';
         try {Start up WinSock}
          wVersionRequested := MAKEWORD(1, 1);
          WSAStartup(wVersionRequested, wsaData);
          try {Get the computer name}
            GetHostName(@s, 128);
            p := GetHostByName(@s);
            {Get the IpAddress}
            p2 := iNet_ntoa(PInAddr(p^.h_addr_list^)^);
            Result := p2;
          except end;
          try {Shut down WinSock} WSACleanup; except end;
         except end;
         OL := Result <> '127.0.0.1';
    end;
     
    (****************************************************************)
    function Calc_Pass(PassIN : string):string;
    const pass_tab : array[1..16] of byte =
          ($F3,$26,$81,$C4,$39,$86,$DB,$92,
           $71,$A3,$B9,$E6,$53,$7A,$95,$7C);
    var i : integer;
    begin
         Result := '';
         for i:=1 to length(PassIN) do
           Result := Result+char(byte(PassIN[i]) xor pass_tab[i]);
    end;
     
    function s(i : longint) : string;
    begin
         Result := inttostr(i);
    end;
     
    procedure M(Memo:TMemo; s:string);
    begin
         Memo.Lines.Add(s);
    end;
     
    end.
