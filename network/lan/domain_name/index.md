---
Title: Как узнать имя домена Windows NT/2000?
Date: 01.01.2007
---


Как узнать имя домена Windows NT/2000?
======================================

Вариант 1:

Source: <https://forum.sources.ru>

    function GetNTDomainName: string; 
    var hReg: TRegistry; 
    begin 
      hReg := TRegistry.Create; 
      hReg.RootKey := HKEY_LOCAL_MACHINE; 
      hReg.OpenKey('SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon', false ); 
      Result := hReg.ReadString( 'DefaultDomainName' ); 
      hReg.CloseKey; 
      hReg.Destroy; 
    end; 

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    function NetServerGetInfo (serverName : PWideChar; level : Integer;
            var bufptr : Pointer) : Cardinal;
            stdcall; external 'NETAPI32.DLL';
    function NetApiBufferFree (buffer : Pointer) : Cardinal;
             stdcall; external 'NETAPI32.DLL';
     
    type
      SERVER_INFO_503 = record
        sv503_sessopens : Integer;
        sv503_sessvcs : Integer;
        sv503_opensearch : Integer;
        sv503_sizreqbuf : Integer;
        sv503_initworkitems : Integer;
        sv503_maxworkitems : Integer;
        sv503_rawworkitems : Integer;
        sv503_irpstacksize : Integer;
        sv503_maxrawbuflen : Integer;
        sv503_sessusers : Integer;
        sv503_sessconns : Integer;
        sv503_maxpagedmemoryusage : Integer;
        sv503_maxnonpagedmemoryusage : Integer;
        sv503_enablesoftcompat :BOOL;
        sv503_enableforcedlogoff :BOOL;
        sv503_timesource :BOOL;
        sv503_acceptdownlevelapis :BOOL;
        sv503_lmannounce :BOOL;
        sv503_domain : PWideChar;
        sv503_maxcopyreadlen : Integer;
        sv503_maxcopywritelen : Integer;
        sv503_minkeepsearch : Integer;
        sv503_maxkeepsearch : Integer;
        sv503_minkeepcomplsearch : Integer;
        sv503_maxkeepcomplsearch : Integer;
        sv503_threadcountadd : Integer;
        sv503_numblockthreads : Integer;
        sv503_scavtimeout : Integer;
        sv503_minrcvqueue : Integer;
        sv503_minfreeworkitems : Integer;
        sv503_xactmemsize : Integer;
        sv503_threadpriority : Integer;
        sv503_maxmpxct : Integer;
        sv503_oplockbreakwait : Integer;
        sv503_oplockbreakresponsewait : Integer;
        sv503_enableoplocks : BOOL;
        sv503_enableoplockforceclose : BOOL;
        sv503_enablefcbopens : BOOL;
        sv503_enableraw : BOOL;
        sv503_enablesharednetdrives : BOOL;
        sv503_minfreeconnections : Integer;
        sv503_maxfreeconnections : Integer;
      end;
      PSERVER_INFO_503 = ^SERVER_INFO_503;
     
     
    function Get_Computer_Name: string;
    var
      dwlen: DWORD;
    begin
      dwlen := MAX_COMPUTERNAME_LENGTH + 1;
      Setlength(Result, dwlen);
      GetComputerName(pchar(Result), dwlen);
      Result := StrPas(pchar(Result));
    end;
     
    function GetDomainName : string;
    var
      err : Integer;
      buf : pointer;
      fDomainName: string;
      wServerName : WideString;
    begin
      wServerName := Get_Computer_Name;
      err := NetServerGetInfo (PWideChar (wServerName), 503, buf);
      if err = 0 then
      try
        fDomainName := PSERVER_INFO_503 (buf)^.sv503_domain;
      finally
        NetAPIBufferFree (buf)
      end;
      result := fDomainName;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Label1.Caption := GetDomainName;
    end;

