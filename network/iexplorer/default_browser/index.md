---
Title: Как узнать browser по умолчанию?
Date: 01.01.2007
---


Как узнать browser по умолчанию?
================================

Вариант 1:

    { 
      First we create a temporary file and call the 
      function FindExecutable to get the associated Application. 
    } 
     
     
    function GetAppName(Doc: string): string; 
    var 
      FN, DN, RES: array[0..255] of char; 
    begin 
      StrPCopy(FN, DOC); 
      DN[0]  := #0; 
      RES[0] := #0; 
      FindExecutable(FN, DN, RES); 
      Result := StrPas(RES); 
    end; 
     
    function GetTempFile(const Extension: string): string; 
    var 
      Buffer: array[0..MAX_PATH] of char; 
      aFile: string; 
    begin 
      GetTempPath(SizeOf(Buffer) - 1, Buffer); 
      GetTempFileName(Buffer, 'TMP', 0, Buffer); 
      SetString(aFile, Buffer, StrLen(Buffer)); 
      Result := ChangeFileExt(aFile, Extension); 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      f: System.Text; 
      temp: string; 
    begin 
      // get a unique temporary file name 
      // eine eindeutige Temporare Datei bekommen 
      temp := GetTempFile('.htm'); 
      // Create the file 
      // Datei erstellen 
      AssignFile(f, temp); 
      rewrite(f); 
      closefile(f); 
      // Show the path to the browser 
      // Pfad + Programmname zum Browser anzeigen. 
      ShowMessage(GetAppName(temp)); 
      // Finally delete the temporary file 
      // Temporaare Datei wieder loschen 
      Erase(f); 
    end; 

------------------------------------------------------------------------

Вариант 2:

    //Using the Registry: 
    //************************************************ 
     
    uses 
      Registry; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      Reg: TRegistry; 
      KeyName: string; 
      ValueStr: string; 
    begin 
      Reg := TRegistry.Create; 
      try 
        Reg.RootKey := HKEY_CLASSES_ROOT; 
        KeyName     := 'htmlfile\shell\open\command'; 
        if Reg.OpenKey(KeyName, False) then 
        begin 
          ValueStr := Reg.ReadString(''); 
          Reg.CloseKey; 
          ShowMessage(ValueStr); 
        end 
        else 
          ShowMessage('There is nоt a default browser'); 
      finally 
        Reg.Free; 
      end; 
    end; 

------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

    //************************************************ 
    {Copyright (c) by Code Central} 
     
    type 
      TBrowserInformation = record 
        Name: string; 
        Path: string; 
        Version: string; 
      end; 
     
    function LongPathName(ShortPathName: string): string; 
    var 
      PIDL: PItemIDList; 
      Desktop: IShellFolder; 
      WidePathName: WideString; 
      AnsiPathName: AnsiString; 
    begin 
      Result := ShortPathName; 
      if Succeeded(SHGetDesktopFolder(Desktop)) then 
      begin 
        WidePathName := ShortPathName; 
        if Succeeded(Desktop.ParseDisplayName(0, nil, PWideChar(WidePathName), 
          ULONG(nil^), PIDL, ULONG(nil^))) then 
     
          try 
            SetLength(AnsiPathName, MAX_PATH); 
            SHGetPathFromIDList(PIDL, PChar(AnsiPathName)); 
            Result := PChar(AnsiPathName); 
     
          finally 
            CoTaskMemFree(PIDL); 
          end; 
      end; 
    end; 
     
    function GetDefaultBrowser: TBrowserInformation; 
    var 
      tmp: PChar; 
      res: LPTSTR; 
      Version: Pointer; 
      VersionInformation: Pointer; 
      VersionInformationSize: Integer; 
      Dummy: DWORD; 
    begin 
      tmp := StrAlloc(255); 
      res := StrAlloc(255); 
      Version := nil; 
      try 
        GetTempPath(255, tmp); 
        if FileCreate(tmp + 'htmpl.htm') <> -1 then 
        begin 
          if FindExecutable('htmpl.htm', tmp, res) > 32 then 
          begin 
            Result.Name := ExtractFileName(res); 
            Result.Path := LongPathName(ExtractFilePath(res)); 
            // Try to determine the Browser Version 
            VersionInformationSize := GetFileVersionInfoSize(Res, Dummy); 
            if VersionInformationSize > 0 then 
            begin 
              GetMem(VersionInformation, VersionInformationSize); 
              GetFileVersionInfo(Res, 0, VersionInformationSize, VersionInformation); 
              VerQueryValue(VersionInformation, ('StringFileInfo040904E4ProductVersion'), 
                Pointer(Version), Dummy); 
              if Version <> nil then 
                Result.Version := PChar(Version); 
              FreeMem(VersionInformation); 
            end; 
          end 
          else 
            ShowMessage('Cannot determine the executable.'); 
          SysUtils.DeleteFile(tmp + 'htmpl.htm'); 
        end 
        else 
          ShowMessage('Cannot create temporary file.'); 
      finally 
        StrDispose(tmp); 
        StrDispose(res); 
      end; 
    end; 

