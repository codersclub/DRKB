---
Title: Как получить количество файлов в корзине и их размер?
Date: 01.01.2007
---

Как получить количество файлов в корзине и их размер?
=====================================================

    type
      PSHQueryRBInfo = ^TSHQueryRBInfo;
      TSHQueryRBInfo = packed record
        cbSize: DWORD;
        // Size of the structure, in bytes.
        // This member must be filled in prior to calling the function.
        i64Size: Int64;
        // Total size of all the objects in the specified Recycle Bin, in bytes.
        i64NumItems: Int64;
        // Total number of items in the specified Recycle Bin.
      end;
     
    const
      shell32 = 'shell32.dll';
     
    function SHQueryRecycleBin(szRootPath: PChar; SHQueryRBInfo: PSHQueryRBInfo): HResult;
      stdcall; external shell32 Name 'SHQueryRecycleBinA';
     
    function GetDllVersion(FileName: string): Integer;
    var
      InfoSize, Wnd: DWORD;
      VerBuf: Pointer;
      FI: PVSFixedFileInfo;
      VerSize: DWORD;
    begin
      Result   := 0;
      InfoSize := GetFileVersionInfoSize(PChar(FileName), Wnd);
      if InfoSize <> 0 then
      begin
        GetMem(VerBuf, InfoSize);
        try
          if GetFileVersionInfo(PChar(FileName), Wnd, InfoSize, VerBuf) then
            if VerQueryValue(VerBuf, '\', Pointer(FI), VerSize) then
              Result := FI.dwFileVersionMS;
        finally
          FreeMem(VerBuf);
        end;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      DllVersion: integer;
      SHQueryRBInfo: TSHQueryRBInfo;
      r: HResult;
    begin
      DllVersion := GetDllVersion(PChar(shell32));
      if DllVersion >= $00040048 then
      begin
        FillChar(SHQueryRBInfo, SizeOf(TSHQueryRBInfo), #0);
        SHQueryRBInfo.cbSize := SizeOf(TSHQueryRBInfo);
        R := SHQueryRecycleBin(nil, @SHQueryRBInfo);
        if r = s_OK then
        begin
          label1.Caption := Format('Size:%d Items:%d',
            [SHQueryRBInfo.i64Size, SHQueryRBInfo.i64NumItems]);
        end
        else
          label1.Caption := Format('Err:%x', [r]);
      end;
    end;
     
    {
     
    The SHQueryRecycleBin API used in this method is
    only available on systems with the latest shell32.dll installed with IE4 /
    Active Desktop.
     
    }
