---
Title: Как послать данные другому приложению используя Auto Drag & Drop?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как послать данные другому приложению используя Auto Drag & Drop?
=================================================================

    uses
      ShellAPI;
     
    function MakeDrop(const FileNames: array of string): THandle;
    // Creates a hDrop Object
    var
      I, Size: Integer;
      Data: PDragInfoA;
      P: PChar;
    begin
      // Calculate memory size needed
      Size := SizeOf(TDragInfoA) + 1;
      for I := 0 to High(FileNames) do
        Inc(Size, Length(FileNames[I]) + 1);
      // allocate the memory
      Result := GlobalAlloc(GHND or GMEM_SHARE, Size);
      if Result <> 0 then
      begin
        Data := GlobalLock(Result);
        if Data <> nil then
          try
            // fill up with data
            Data.uSize := SizeOf(TDragInfoA);
            P  := PChar(@Data.grfKeyState) + 4;
            Data.lpFileList := P;
            // filenames at the at of the header (separated with #0)
            for I := 0 to High(FileNames) do
            begin
              Size := Length(FileNames[I]);
              Move(Pointer(FileNames[I])^, P^, Size);
              Inc(P, Size + 1);
            end;
          finally
            GlobalUnlock(Result);
          end
        else
        begin
          GlobalFree(Result);
          Result := 0;
        end;
      end;
    end;
     
    function MyEnum(Wnd: hWnd; Res: PInteger): Bool; stdcall;
    // search for a edit control with classname 'TEditControl'
    var
      N: string;
    begin
      SetLength(N, MAX_PATH);
      SetLength(N, GetClassName(Wnd, Pointer(N), Length(N)));
      Result := AnsiCompareText('TEditControl', N) <> 0;
      if not Result then Res^ := Wnd;
    end;
     
    // Example: Open msdos.sys in Delphi's Editor window
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Wnd: HWnd;
      Drop: hDrop;
    begin
      // search for Delphi's Editor
      EnumChildWindows(FindWindow('TEditWindow', nil), @MyEnum, Integer(@Wnd));
      if IsWindow(Wnd) then
      begin
        // Delphi's Editor found. Open msdos.sys
        Drop := MakeDrop(['c:\msdos.sys']);
        if Drop <> 0 then PostMessage(Wnd, wm_DropFiles, Drop, 0);
        // Free the memory?
        GlobalFree(Drop);
      end;
    end;

