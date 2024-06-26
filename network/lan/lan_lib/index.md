---
Title: Библиотека для работы с LAN
Author: Alex
Date: 01.01.2007
Source: <https://www.delphikingdom.ru/>
---


Библиотека для работы с LAN
===========================

    unit NetProcs;
     
    interface
     
    uses Classes, Windows;
     
    type
    TAdapterStatus = record
                     adapter_address: array [0..5] of Char;
                     filler: array [1..4*SizeOf(Char)+19*SizeOf(Word)
                                    +3*SizeOf(DWORD)] of Byte;
                     end;
    THostInfo = record
                username: PWideChar;
                logon_domain: PWideChar;
                oth_domains: PWideChar;
                logon_server: PWideChar;
                end;{record}
     
      function IsNetConnect : Boolean;
      {Возвращает TRUE если компьютер подключен к сети, иначе - FALSE}
     
      function AdapterToString(Adapter: TAdapterStatus): string;
      {Преобразует MAC адес в привычный xx-xx-xx-xx}
     
      function GetMacAddresses(const Machine: string;
                               const Addresses: TStrings): Integer;
      {Заполняет Addresses MAC-адресами компьютера с сетевым именем  Machine.
       Возвращает число МАС адресов на компьютере}
     
      function GetNetUser(HostName: WideString): THostInfo;
      {Возвращает LOGIN текущего пользователя на HOSTNAME компьютере}
     
    implementation
     
    uses NB30, SysUtils;
     
    function IsNetConnect : Boolean;
    begin
      if GetSystemMetrics(SM_NETWORK) AND $01 = $01
      then Result:= True
      else Result:= False;
    end;{function}
     
    function AdapterToString(Adapter: TAdapterStatus): string;
    begin
      with Adapter do    Result :=
    Format('%2.2x-%2.2x-%2.2x-%2.2x-%2.2x-%2.2x', [
          Integer(adapter_address[0]), Integer(adapter_address[1]),
          Integer(adapter_address[2]), Integer(adapter_address[3]),
          Integer(adapter_address[4]), Integer(adapter_address[5])]);
    end;{function}
     
    function GetMacAddresses(const Machine: string;
                             const Addresses: TStrings): Integer;
    const  NCBNAMSZ    = 16;        // absolute length of a net name
           MAX_LANA    = 254;       // lana's in range 0 to MAX_LANA inclusive
           NRC_GOODRET = $00;       // good return
           NCBASTAT    = $33;       // NCB ADAPTER STATUS
           NCBRESET    = $32;       // NCB RESET
           NCBENUM     = $37;       // NCB ENUMERATE LANA NUMBERS
    type
    PNCB = ^TNCB;
    TNCBPostProc = procedure (P: PNCB); stdcall;
    TNCB = record
           ncb_command: Byte;
           ncb_retcode: Byte;
           ncb_lsn: Byte;
           ncb_num: Byte;
           ncb_buffer: PChar;
           ncb_length: Word;
           ncb_callname: array [0..NCBNAMSZ - 1] of Char;
           ncb_name: array [0..NCBNAMSZ - 1] of Char;
           ncb_rto: Byte;
           ncb_sto: Byte;
           ncb_post: TNCBPostProc;
           ncb_lana_num: Byte;
           ncb_cmd_cplt: Byte;
           ncb_reserve: array [0..9] of Char;
           ncb_event: THandle;
           end;
    PLanaEnum = ^TLanaEnum;
    TLanaEnum = record
                length: Byte;
                lana: array [0..MAX_LANA] of Byte;
                end;
    ASTAT = record
            adapt: TAdapterStatus;
            namebuf: array [0..29] of TNameBuffer;
            end;
    var
    NCB: TNCB;
    Enum: TLanaEnum;
    I: Integer;
    Adapter: ASTAT;
    MachineName: string;
    begin
      Result := -1;
      Addresses.Clear;
      MachineName := UpperCase(Machine);
      if MachineName = ''
      then    MachineName := '*';
      FillChar(NCB, SizeOf(NCB), #0);
      NCB.ncb_command := NCBENUM;
      NCB.ncb_buffer := Pointer(@Enum);
      NCB.ncb_length := SizeOf(Enum);
      if Word(NetBios(@NCB)) = NRC_GOODRET
      then  begin
            Result := Enum.Length;
            for I := 0 to Ord(Enum.Length) - 1
            do begin
                 FillChar(NCB, SizeOf(TNCB), #0);
                 NCB.ncb_command := NCBRESET;
                 NCB.ncb_lana_num := Enum.lana[I];
                 if Word(NetBios(@NCB)) = NRC_GOODRET
                 then begin
                      FillChar(NCB, SizeOf(TNCB), #0);
                      NCB.ncb_command := NCBASTAT;
                      NCB.ncb_lana_num := Enum.lana[i];
                      StrLCopy(NCB.ncb_callname, PChar(MachineName),NCBNAMSZ);
                      StrPCopy(@NCB.ncb_callname[Length(MachineName)],
                      StringOfChar(' ', NCBNAMSZ - Length(MachineName)));
                      NCB.ncb_buffer := PChar(@Adapter);
                      NCB.ncb_length := SizeOf(Adapter);
                      if Word(NetBios(@NCB)) = NRC_GOODRET
                      then Addresses.Add(AdapterToString(Adapter.adapt));
                      end;
               end;
            end;
    end;{function}
     
    function
    NetWkstaUserEnum(servername: PWideChar;
                         level : DWord;
                     var bufptr: Pointer;
                     prefmaxlen: DWord;
                var entriesread: PDWord;
               var totalentries: PDWord;
               var resumehandle: PDWord ): LongInt ;
                     stdcall; external 'netapi32.dll' name 'NetWkstaUserEnum';
     
    function GetNetUser(HostName: WideString): THostInfo;
    var
    Info: Pointer;
    ElTotal: PDWord;
    ElCount: PDWord;
    Resume: PDWord;
    Error: LongInt;
    begin
      Resume:=0;
               NetWkstaUserEnum(PWideChar(HostName),1, Info,0,
                                ElCount,ElTotal,Resume);
        Error:=NetWkstaUserEnum(PWideChar(HostName),1,Info,256*Integer(ElTotal),
                                ElCount,ElTotal,Resume);
        case    Error    of
        ERROR_ACCESS_DENIED: Result.UserName:= 'ERROR - ACCESS DENIED';
        ERROR_MORE_DATA: Result.UserName:= 'ERROR - MORE DATA';
        ERROR_INVALID_LEVEL: Result.UserName:= 'ERROR - INVALID LEVEL';
        else if Info <> nil
             then Result:=THostInfo(info^)
             else begin
                  Result.username:= '???';
                  Result.logon_domain:= '???';
                  Result.oth_domains:= '???';
                  Result.logon_server:= '???';
                  end;{if}
        end;{case}
    end; {function}
     
    end.

