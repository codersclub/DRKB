---
Title: Как получить и изменить координаты иконок на столе?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как получить и изменить координаты иконок на столе?
===================================================

    //-------------------------------------------
    // For Win9x:
    //-------------------------------------------
     
    uses
      CommCtrl,
      IPCThrd; (from your Delphi\Demos\Ipcdemos directory)
     
    function GetDesktopListViewHandle: THandle;
    var
      S: String;
    begin
      Result := FindWindow('ProgMan', nil);
      Result := GetWindow(Result, GW_CHILD);
      Result := GetWindow(Result, GW_CHILD);
      SetLength(S, 40);
      GetClassName(Result, PChar(S), 39);
      if PChar(S) <> 'SysListView32' then Result := 0;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
     type
       PInfo = ^TInfo;
       TInfo = packed record
         infoPoint: TPoint;
         infoText: array[0..255] of Char;
         infoItem: TLVItem;
         infoFindInfo: TLVFindInfo;
       end;
    var
       r : TRect;
       hWnd : THandle;
       i, iCount : Integer;
     
       Info: PInfo;
       SharedMem: TSharedMem;
    begin
      hWnd := GetDesktopWindow();
      GetWindowRect(hWnd,r);
      Memo.Lines.Add('Bottom: ' +  IntToStr(r.Bottom));
      Memo.Lines.Add('Right: ' + IntToStr(r.Right));
     
      hWnd := GetDesktopListViewHandle;
      iCount := ListView_GetItemCount(hWnd);
      Memo.Lines.Add('# Icons: ' + IntToStr(iCount));
     
      SharedMem := TSharedMem.Create('', SizeOf(TInfo));
      Info := SharedMem.Buffer;
     
       with Info^ do
       try
         infoItem.pszText := infoText;
         infoItem.cchTextMax := 255;
         infoItem.mask := LVIF_TEXT;
         try
           begin
             for i := 0 to iCount - 1 do
             begin
               infoItem.iItem := i;
               try
                 ListView_GetItem(hWnd, infoItem);
                 ListView_GetItemPosition(hWnd, I, infoPoint);
                 Memo.Lines.Add('Icon: ' + infoText);
                 Memo.Lines.Add('   X: ' + IntToStr(infoPoint.X));
                 Memo.Lines.Add('   Y: ' + IntToStr(infoPoint.Y));
               except
               end;
             end;
           end;
         finally
         end;
       finally
         SharedMem.Free;
       end;
    end;

    //-------------------------------------------
    // For NT, Win2k, XP:
    //-------------------------------------------
    // Unit to save/restore the positions of desktop icons to/from the registry)
     
    unit dipsdef;
     
    interface
     
    uses
      Windows, CommCtrl;
     
    const
      RegSubKeyName = 'Software\LVT\Desktop Item Position Saver';
     
    procedure RestoreDesktopItemPositions;
    procedure SaveDesktopItemPositions;
     
    implementation
     
    uses
      uvirtalloc, registry;
     
    procedure SaveListItemPosition(LVH : THandle; RemoteAddr : Pointer);
    var
      lvi : TLVITEM;
      lenlvi : integer;
      nb : integer;
      buffer : array [0..MAX_PATH] of char;
      Base : Pointer;
      Base2 : PByte;
      i, ItemsCount : integer;
      Apoint : TPoint;
      key : HKEY;
      Dummy : integer;
    begin
      ItemsCount := SendMessage(LVH, LVM_GETITEMCOUNT, 0, 0);
      Base := RemoteAddr;
      lenlvi := SizeOf(lvi);
      FillChar(lvi, lenlvi, 0);
      lvi.cchTextMax := 255;
      lvi.pszText := Base;
      inc(lvi.pszText, lenlvi);
     
      WriteToRemoteBuffer(@lvi, Base, 255);
     
      Base2 := Base;
      inc(Base2, Lenlvi);
     
      RegDeleteKey(HKEY_CURRENT_USER, RegSubKeyName);
     
      RegCreateKeyEx(HKEY_CURRENT_USER,
        PChar(RegSUbKeyName),
        0,
        nil,
        REG_OPTION_NON_VOLATILE,
        KEY_SET_VALUE,
        nil,
        key,
        nil);
     
      for i := 0 to ItemsCount - 1 do
      begin
        nb := SendMessage(LVH, LVM_GETITEMTEXT, i, LParam(Base));
     
        ReadRemoteBuffer(Base2, @buffer, nb + 1);
        FillChar(Apoint, SizeOf(Apoint), 0);
     
        WriteToRemoteBuffer(@APoint, Base2, SizeOf(Apoint));
        SendMessage(LVH, LVM_GETITEMPOSITION, i, LParam(Base) + lenlvi);
     
        ReadRemoteBuffer(Base2, @Apoint, SizeOf(Apoint));
        RegSetValueEx(key, @buffer, 0, REG_BINARY, @Apoint, SizeOf(APoint));
      end;
      RegCloseKey(key);
    end;
     
     
    procedure RestoreListItemPosition(LVH : THandle; RemoteAddr : Pointer);
    type
      TInfo = packed record
        lvfi : TLVFindInfo;
        Name : array [0..MAX_PATH] of char;
      end;
    var
      SaveStyle : Dword;
      Base : Pointer;
      Apoint : TPoint;
      key : HKey;
      idx : DWord;
      info : TInfo;
      atype : Dword;
      cbname, cbData : Dword;
      itemidx : DWord;
    begin
      SaveStyle := GetWindowLong(LVH, GWL_STYLE);
      if (SaveStyle and LVS_AUTOARRANGE) = LVS_AUTOARRANGE then
        SetWindowLong(LVH, GWL_STYLE, SaveStyle xor LVS_AUTOARRANGE);
     
      RegOpenKeyEx(HKEY_CURRENT_USER, RegSubKeyName, 0, KEY_QUERY_VALUE, key);
     
      FillChar(info, SizeOf(info), 0);
      Base := RemoteAddr;
     
      idx := 0;
      cbname := MAX_PATH;
      cbdata := SizeOf(APoint);
     
      while (RegEnumValue(key, idx, info.Name, cbname, nil, @atype, @Apoint, @cbData) <>
        ERROR_NO_MORE_ITEMS) do
      begin
        if (atype = REG_BINARY) and (cbData = SizeOf(Apoint)) then
        begin
          info.lvfi.flags := LVFI_STRING;
          info.lvfi.psz := Base;
          inc(info.lvfi.psz, SizeOf(info.lvfi));
          WriteToRemoteBuffer(@info, Base, SizeOf(info.lvfi) + cbname + 1);
          itemidx := SendMessage(LVH, LVM_FINDITEM, - 1, LParam(Base));
          if itemidx > -1 then
            SendMessage(LVH, LVM_SETITEMPOSITION, itemidx, MakeLong(Apoint.x, Apoint.y));
        end;
        inc(idx);
        cbname := MAX_PATH;
        cbdata := SizeOf(APoint);
      end;
      RegCloseKey(key);
     
      SetWindowLong(LVH, GWL_STYLE, SaveStyle);
    end;
     
    function GetSysListView32: THandle;
    begin
      Result := FindWindow('Progman', nil);
      Result := FindWindowEx(Result, 0, nil, nil);
      Result := FindWindowEx(Result, 0, nil, nil);
    end;
     
    procedure SaveDesktopItemPositions;
    var
      pid : integer;
      rembuffer : PByte;
      hTarget : THandle;
    begin
      hTarget := GetSysListView32;
      GetWindowThreadProcessId(hTarget, @pid);
      if (hTarget = 0) or (pid = 0) then
        Exit;
      rembuffer := CreateRemoteBuffer(pid, $FFF);
      if Assigned(rembuffer) then
      begin
        SaveListItemPosition(hTarget, rembuffer);
        DestroyRemoteBuffer;
      end;
    end;
     
    procedure RestoreDesktopItemPositions;
    var
      hTarget : THandle;
      pid : DWord;
      rembuffer : PByte;
    begin
      hTarget := GetSysListView32;
      GetWindowThreadProcessId(hTarget, @pid);
      if (hTarget = 0) or (pid = 0) then
        Exit;
      rembuffer := CreateRemoteBuffer(pid, $FFF);
      if Assigned(rembuffer) then
      begin
        RestoreListItemPosition(hTarget, rembuffer);
        DestroyRemoteBuffer;
      end;
    end;
     
    end.

    unit uvirtalloc;
     
    interface
     
    uses
      Windows, SysUtils;
     
    function CreateRemoteBuffer(Pid : DWord; Size: Dword): PByte;
    procedure WriteToRemoteBuffer(Source : PByte;
                                   Dest : PByte;
                                   Count : Dword);
     
    function ReadRemoteBuffer (Source : PByte;
                                Dest : PByte;
                                Count : Dword): Dword;
     
    procedure DestroyRemoteBuffer;
     
    implementation
     
    var
      hProcess : THandle;
      RemoteBufferAddr: PByte;
      BuffSize : DWord;
     
    function CreateRemoteBuffer;
    begin
      RemoteBufferAddr := nil;
      hProcess := OpenProcess(PROCESS_ALL_ACCESS, FALSE, Pid);
      if (hProcess = 0) then
        RaiseLastWin32Error;
     
      Result := VirtualAllocEx(hProcess,
                                nil,
                                Size,
                                MEM_COMMIT,
                                PAGE_EXECUTE_READWRITE);
     
      Win32Check(Result <> nil);
      RemoteBufferAddr := Result;
      BuffSize := Size;
    end;
     
    procedure WriteToRemoteBuffer;
    var
      BytesWritten: Dword;
    begin
     if hProcess = 0 then
       Exit;
     Win32Check(WriteProcessMemory(hProcess,
                                    Dest,
                                    Source,
                                    Count,
                                    BytesWritten));
    end;
     
    function ReadRemoteBuffer;
    begin
      Result := 0;
      if hProcess = 0 then
         Exit;
     
      Win32Check(ReadProcessMemory(hProcess,
                                    Source,
                                    Dest,
                                    Count,
                                    Result));
    end;
     
    procedure DestroyRemoteBuffer;
    begin
       if (hProcess > 0)  then
         begin
           if Assigned(RemoteBufferAddr) then
             Win32Check(Boolean(VirtualFreeEx(hProcess,
                                              RemoteBufferAddr,
                                              0,
                                              MEM_RELEASE)));
           CloseHandle(hProcess);
         end;
    end;
     
    end.

Other Source for NT, Win2k, XP only:

https://www.luckie-online.de/programme/luckiedipssfx.exe

(Complete demo to save/restore the positions of desktop icons, nonVCL)

