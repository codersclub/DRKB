---
Title: Как читать REG\_MULTI\_SZ значение?
Date: 01.01.2007
---

Как читать REG\_MULTI\_SZ значение?
===================================

Вариант 1:

    uses
      Registry;

    procedure ReadREG_MULTI_SZ(const CurrentKey: HKey; const Subkey, ValueName: string;
      Strings: TStrings);
    var
      valueType: DWORD;
      valueLen: DWORD;
      p, buffer: PChar;
      key: HKEY;
    begin
      // Clear TStrings
      Strings.Clear;
      // open the specified key
      if RegOpenKeyEx(CurrentKey,
                      PChar(Subkey),
                      0, KEY_READ, key) = ERROR_SUCCESS then
      begin
        // retrieve the type and data for a specified value name
        SetLastError(RegQueryValueEx(key,
                     PChar(ValueName),
                     nil,
                     @valueType,
                     nil,
                     @valueLen));
        if GetLastError = ERROR_SUCCESS then
          if valueType = REG_MULTI_SZ then
          begin
            GetMem(buffer, valueLen);
            try
              // receive the value's data (in an array).
              RegQueryValueEx(key,
                              PChar(ValueName),
                              nil,
                              nil,
                              PBYTE(buffer),
                              @valueLen);
              // Add values to stringlist
              p := buffer;
              while p^ <> #0 do
              begin
                Strings.Add(p);
                Inc(p, lstrlen(p) + 1)
              end
            finally
              FreeMem(buffer)
            end
          end
          else
            raise ERegistryException.Create('Stringlist expected/ String Liste erwartet...')
        else
          raise ERegistryException.Create('Cannot Read MULTI_SZ Value/'+
            'Kann den MULTI_SZ Wert nicht lesen...');
      end;
    end;

    // Test it:

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ReadREG_MULTI_SZ(HKEY_CURRENT_USER, 'Software\XYZ', 'Test44', Memo1.Lines);
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Ralph Friedman

    {******************************************}
    {2. by Ralph Friedman }
     
    {
     Question:
     I want to read out the binary-value "problems" of the path
     HKEY_DYN_DATA\Config Manager\Enum[add the key of a hardware component] to
     detect if a hardware component is troubled and not working right.
     But I cannot handle the ReadBinaryData-Method of TRegistry correct.
     Everytime I use it, it always returns "4" as content of the buffer.
     How do I detect if the content of the binary-key "problems" is
     not "00 00 00 00" but something else like "16 00 00 00" or such?
    }
     
    {Answer: Here's an example of ReadBinaryData }
    
     
    procedure TFrmReadBinary.Button1Click(Sender: TObject);
    const
      CKeyName: string = 'System\Setup';
      CValName: string = 'NetcardDlls';
    var
      keyGood: boolean;
      p: integer;
      regKey: TRegistry;
      tmpStr: string;
      vSize: integer;
    begin
      regKey := TRegistry.Create;
      try
        regKey.RootKey := HKEY_LOCAL_MACHINE;
        keyGood  := regKey.OpenKey(CKeyName, False);
     
        if (keyGood) then
        begin
          vSize := regKey.GetDataSize(CValName);
     
          if (vSize > 0) then
          begin
            SetLength(tmpStr, vSize);
            regKey.ReadBinaryData(CValName, tmpstr[1], vSize);
     
            repeat
              p := Pos(#0, tmpStr);
     
              if p <> 0 then
              begin
                Delete(tmpStr, p, 1);
                Insert(#13#10, tmpStr, p);
              end;
            until p = 0;
     
            (*StringReplace(tmpStr, #0, #13#10, [rfReplaceAll]); *)
     
            ListBox1.Items.Text := tmpStr;
          end;
        end;
      finally
        regKey.Free;
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Author: Michael Winter

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    {******************************************}
    {3. by Michael Winter }
     
    procedure RaiseWin32Error(Code: Cardinal);
    var
      Error: EWin32Error;
    begin
      Error := EWin32Error.CreateResFmt(@SWin32Error, [Code,
        SysErrorMessage(Code)]);
      Error.ErrorCode := Code;
      raise Error;
    end;
     
    // Write REG_MULTI_SZ
    procedure TForm1.Button1Click(Sender: TObject);
    const
      Str = 'multiple'#0'strings'#0'in one'#0'registry'#0'value'#0;
    var
      Reg: TRegistry;
      Res: Integer;
    begin
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_CURRENT_USER;
        if not Reg.OpenKey('\Software\Test\RegMultiSzTest', true) then
          raise Exception.Create('Can''t open key');
        Res := RegSetValueEx(
          Reg.CurrentKey,     // handle of key to set value for
          'TestValue',        // address of value to set
          0,                  // reserved
          REG_MULTI_SZ,       // flag for value type
          PChar(Str),         // address of value data
          Length(Str) + 1);   // size of value data
        if Res <> ERROR_SUCCESS then
          RaiseWin32Error(Res);
      finally
        Reg.Free;
      end;
    end;
     
    // Read REG_MULTI_SZ
    procedure TForm1.Button2Click(Sender: TObject);
    var
      Reg: TRegistry;
      DataType: Cardinal;
      DataSize: Cardinal;
      Res: Integer;
      Str: String;
      i: Integer;
    begin
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_CURRENT_USER;
        if not Reg.OpenKeyReadOnly('\Software\Test\RegMultiSzTest') then
          raise Exception.Create('Can''t open key');
        DataSize := 0;
        Res := RegQueryValueEx(
          Reg.CurrentKey,     // handle of key to query
          'TestValue',        // address of name of value to query
          nil,                // reserved
          @DataType,          // address of buffer for value type
          nil,                // address of data buffer
          @DataSize);         // address of data buffer size
        if Res <> ERROR_SUCCESS then
          RaiseWin32Error(Res);
        if DataType <> REG_MULTI_SZ then
          raise Exception.Create('Wrong data type');
        SetLength(Str, DataSize - 1);
        if DataSize > 1 then begin
          Res := RegQueryValueEx(
            Reg.CurrentKey,     // handle of key to query
            'TestValue',        // address of name of value to query
            nil,                // reserved
            @DataType,          // address of buffer for value type
            PByte(Str),         // address of data buffer
            @DataSize);         // address of data buffer size
          if Res <> ERROR_SUCCESS then
            RaiseWin32Error(Res);
        end;
     
        for i := Length(Str) downto 1 do
          if Str[i] = #0 then
            Str[i] := #13;
        ShowMessage(Str);
      finally
        Reg.Free;
      end;
    end;

------------------------------------------------------------

Вариант 4:

Author: Александр (Rouse\_) Багель

Source: <https://forum.sources.ru>

    type
     
      TExRegistry = class(TRegistry)
      public
        function ReadStrings(const ValueName: String): String;
      end;
     
    function TExRegistry.ReadStrings(const ValueName: String): String;
    var
      ValueType : DWORD;
      ValueLen  : DWORD;
      P, Buffer : PChar;
    begin
      Result := '';
      SetLastError(RegQueryValueEx(CurrentKey, PChar (ValueName), nil,
        @ValueType, nil, @ValueLen));
      if GetLastError = ERROR_SUCCESS then
      begin
        if ValueType = REG_MULTI_SZ then
        begin
          GetMem(Buffer, ValueLen);
          try
            RegQueryValueEx(CurrentKey, PChar(ValueName), nil, nil, PBYTE(Buffer), @ValueLen);
            P := Buffer;
            while P^ <> #0 do
            begin
              if Result <> '' then 
                Result := Result + sLineBreak;
              Result := Result + P;
              Inc(P, lstrlen(P) + 1);
            end;
          finally
            FreeMem (Buffer);
          end;
        end
        else
          raise ERegistryException.Create ('String list expected');
      end
      else
        raise Exception.Create ('Unable read MULTI_SZ value');
    end;

