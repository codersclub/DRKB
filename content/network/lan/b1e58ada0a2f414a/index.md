---
Title: Как получить primary domain controller (PDC)?
Date: 01.01.2007
---


Как получить primary domain controller (PDC)?
=============================================

::: {.date}
01.01.2007
:::

    {
      The NetGetDCName function returns the name of the primary domain controller (PDC).
      It does not return the name of the backup domain controller (BDC) for the specified domain.
      Also, you cannot remote this function to a non-PDC server.
      Windows 2000/XP: Applications that support DNS-style names should call the  function.
      Domain controllers in this type of environment have a multi-master
      directory replication relationship.
      Therefore, it may be advantageous for your application to use a DC that is not the PDC.
      You can call the DsGetDcName function to locate any DC in the domain;
      NetGetDCName returns only the name of the PDC.
    }
     
    type
      EAccessDenied = Exception;
      EInvalidOwner = Exception;
      EInsufficientBuffer = Exception;
      ELibraryNotFound = Exception;
     
      NET_API_STATUS = Integer;
     
    const
      NERR_Success = 0;
     
    var
      NTNetGetDCName: function (Server, Domain: pWideChar; var DC: pWideChar): NET_API_STATUS; stdcall;
      NTNetGetDCNameA: function (Server, Domain: PChar; var DC: PChar): NET_API_STATUS; stdcall;
      NTNetApiBufferFree: function (lpBuffer: Pointer): NET_API_STATUS; stdcall;
     
    procedure NetCheck(ErrCode: NET_API_STATUS);
    begin
      if ErrCode <> NERR_Success then
      begin
        case ErrCode of
          ERROR_ACCESS_DENIED:
            raise EAccessDenied.Create('Access is Denied');
          ERROR_INVALID_OWNER:
            raise EInvalidOwner.Create('Cannot assign the owner of this object.');
          ERROR_INSUFFICIENT_BUFFER:
            raise EInsufficientBuffer.Create('Buffer passed was too small');
          else
            raise Exception.Create('Error Code: ' + IntToStr(ErrCode) + #13 +
              SysErrorMessage(ErrCode));
        end;
      end;
    end;
     
    function GetPDC(szSystem: string): string;
      { if szSystem = '' return the PDC else return DC for that domain }
    const
      NTlib = 'NETAPI32.DLL';
      Win95lib = 'RADMIN32.DLL';
    var
      pAnsiDomain: PChar;
      pDomain: PWideChar;
      System: array[1..80] of WideChar;
      ErrMode: Word;
      LibHandle: THandle;
    begin
      Result := '';
      LibHandle := 0;
      try
        if Win32Platform = VER_PLATFORM_WIN32_NT then
        begin
          ErrMode := SetErrorMode(SEM_NOOPENFILEERRORBOX);
          LibHandle := LoadLibrary(NTlib);
          SetErrorMode(ErrMode);
          if LibHandle = 0 then
            raise ELibraryNotFound.Create('Unable to map library: ' +
              NTlib); @NTNetGetDCName := GetProcAddress(Libhandle, 'NetGetDCName');
            @NTNetApiBufferFree       := GetProcAddress(Libhandle,
            'NetApiBufferFree');
          try
            if szSystem <> '' then
              NetCheck(NTNetGetDCName(nil, StringToWideChar(szSystem, @System, 80), pDomain))
            else
              NetCheck(NTNetGetDCName(nil, nil, pDomain));
            Result := WideCharToString(pDomain);
          finally
            NetCheck(NTNetApiBufferFree(pDomain));
          end;
        end
        else
        begin
          ErrMode := SetErrorMode(SEM_NOOPENFILEERRORBOX);
          LibHandle := LoadLibrary(Win95lib);
          SetErrorMode(ErrMode);
          if LibHandle = 0 then
            raise ELibraryNotFound.Create('Unable to map library: ' +
              Win95lib); @NTNetGetDCNameA := GetProcAddress(Libhandle, 'NetGetDCNameA');
            @NTNetApiBufferFree := GetProcAddress(LibHandle, 'NetApiBufferFree');
          try
            if szSystem <> '' then
              NetCheck(NTNetGetDCNameA(nil, PChar(szSystem), pAnsiDomain))
            else
              NetCheck(NTNetGetDCNameA(nil, nil, pAnsiDomain));
            Result := StrPas(pAnsiDomain);
          finally
            NetCheck(NTNetApiBufferFree(pAnsiDomain));
          end;
        end;
      finally
        if LibHandle <> 0 then
        begin
          FreeLibrary(Libhandle); // free handle if it has been allocated
        end;
      end;
    end;
     
    // Example call, Beispielaufruf:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      try
        Screen.Cursor  := crHourGlass;
        label1.Caption := GetPDC('');
      finally
        Screen.Cursor := crDefault;
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
