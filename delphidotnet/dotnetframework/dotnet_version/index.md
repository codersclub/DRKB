---
Title: Определение установленных версий .NET Framework в системе
Author: Акжан Абдулин
Date: 01.01.2007
Source: <https://www.delphikingdom.ru/>
---


Определение установленных версий .NET Framework в системе
=========================================================

    /// <summary>
    /// Enumerates all installed Common Language Runtime Engines.
    /// </summary>
    /// <param name="Index">Zero-based index of looked runtime
    record.</param>
    /// <returns>True if runtime with specified index found.</returns>
     
    function EnumInstalledRuntimes(Index: Integer; out VersionName: String):
    Boolean;
    var
      hkey: Windows.HKEY;
      hsubkey: Windows.HKEY;
      I: Cardinal;
      J: Cardinal;
      NameBuf: array[0..MAX_PATH] of Char;
      CNameBuf: Cardinal;
      lwt: TFileTime;
      vt: DWORD;
      AnyFound: Boolean;
    begin
      Result := False;
      VersionName := '';
      if ERROR_SUCCESS = RegOpenKeyEx(HKEY_LOCAL_MACHINE,
      PChar('SOFTWARE\Microsoft.NETFramework\policy'), 0,
      KEY_ENUMERATE_SUB_KEYS, hkey) then
      try
        I := 0;
        while True do
        begin
          AnyFound := False;
          CNameBuf := MAX_PATH + 1;
          if ERROR_SUCCESS <> RegEnumKeyEx(hkey, I, @NameBuf[0], CNameBuf,nil, nil, nil, @lwt) then
          begin
            Break;
          end;
          if (NameBuf[0] = 'v') and (NameBuf[1] in ['1'..'9']) then
          begin
            VersionName := String(NameBuf);
            if ERROR_SUCCESS = RegOpenKeyEx(hkey, @NameBuf[0], 0,KEY_QUERY_VALUE, hsubkey) then
            try
              J := 0;
              while true do
              begin
                CNameBuf := MAX_PATH + 1;
                if ERROR_SUCCESS <> RegEnumValue(hsubkey, J, @NameBuf[0],CNameBuf, nil, @vt, nil, nil) then
                begin
                  Break;
                end;
                if (vt = REG_SZ) and (NameBuf[0] <> #0) then
                begin
                  VersionName := VersionName + '.' + String(NameBuf);
                  AnyFound := True;
                  Break;
                end;
                Inc(J);
              end;
            finally
              RegCloseKey(hsubkey);
            end;
          end;
          Inc(I);
          if AnyFound then
          begin
            if Index = 0 then
            begin
              Result := True;
              Break;
            end;
            Dec(Index);
          end;
        end;
      finally
        RegCloseKey(hkey);
      end;
    end;

