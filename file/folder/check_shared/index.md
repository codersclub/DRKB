---
Title: Как проверить папку на shared?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как проверить папку на shared?
==============================

    {Following code needs to use ShlObj, ComObj, ActiveX Units}
     
    function TForm1.IfFolderShared(FullFolderPath: string): Boolean;
     
      //Convert TStrRet to string
      function StrRetToString(PIDL: PItemIDList; StrRet: TStrRet; Flag: string = ''): string;
      var
        P: PChar;
      begin
        case StrRet.uType of
          STRRET_CSTR:
            SetString(Result, StrRet.cStr, lStrLen(StrRet.cStr));
          STRRET_OFFSET:
            begin
              P := @PIDL.mkid.abID[StrRet.uOffset - SizeOf(PIDL.mkid.cb)];
              SetString(Result, P, PIDL.mkid.cb - StrRet.uOffset);
            end;
          STRRET_WSTR:
            if Assigned(StrRet.pOleStr) then
              Result := StrRet.pOleStr
            else
              Result := '';
        end;
        { This is a hack bug fix to get around Windows Shell Controls returning
          spurious "?"s in date/time detail fields }
        if (Length(Result) > 1) and (Result[1] = '?') and (Result[2] in ['0'..'9']) then
          Result := StringReplace(Result, '?', '', [rfReplaceAll]);
      end;
     
      //Get Desktop's IShellFolder interface
      function DesktopShellFolder: IShellFolder;
      begin
        OleCheck(SHGetDesktopFolder(Result));
      end;
     
      //delete the first ID from IDList
      function NextPIDL(IDList: PItemIDList): PItemIDList;
      begin
        Result := IDList;
        Inc(PChar(Result), IDList^.mkid.cb);
      end;
     
      //get the length of IDList
      function GetPIDLSize(IDList: PItemIDList): Integer;
      begin
        Result := 0;
        if Assigned(IDList) then
        begin
          Result := SizeOf(IDList^.mkid.cb);
          while IDList^.mkid.cb <> 0 do
          begin
            Result := Result + IDList^.mkid.cb;
            IDList := NextPIDL(IDList);
          end;
        end;
      end;
     
      //get ID count from IDList
      function GetItemCount(IDList: PItemIDList): Integer;
      begin
        Result := 0;
        while IDList^.mkid.cb <> 0 do
        begin
          Inc(Result);
          IDList := NextPIDL(IDList);
        end;
      end;
     
      //create an ItemIDList object
      function CreatePIDL(Size: Integer): PItemIDList;
      var
        Malloc: IMalloc;
      begin
        OleCheck(SHGetMalloc(Malloc));
     
        Result := Malloc.Alloc(Size);
        if Assigned(Result) then
          FillChar(Result^, Size, 0);
      end;
     
      function CopyPIDL(IDList: PItemIDList): PItemIDList;
      var
        Size: Integer;
      begin
        Size   := GetPIDLSize(IDList);
        Result := CreatePIDL(Size);
        if Assigned(Result) then
          CopyMemory(Result, IDList, Size);
      end;
     
      //get the last ItemID from AbsoluteID
      function RelativeFromAbsolute(AbsoluteID: PItemIDList): PItemIDList;
      begin
        Result := AbsoluteID;
        while GetItemCount(Result) > 1 do
          Result := NextPIDL(Result);
        Result := CopyPIDL(Result);
      end;
     
      //remove the last ID from IDList
      procedure StripLastID(IDList: PItemIDList);
      var
        MarkerID: PItemIDList;
      begin
        MarkerID := IDList;
        if Assigned(IDList) then
        begin
          while IDList.mkid.cb <> 0 do
          begin
            MarkerID := IDList;
            IDList   := NextPIDL(IDList);
          end;
          MarkerID.mkid.cb := 0;
        end;
      end;
     
      //if Flag include Element
      function IsElement(Element, Flag: Integer): Boolean;
      begin
        Result := Element and Flag <> 0;
      end;
    var
      P: Pointer;
      NumChars, Flags: LongWord;
      ID, NewPIDL, ParentPIDL: PItemIDList;
      ParentShellFolder: IShellFolder;
    begin
      Result := False;
      NumChars := Length(FullFolderPath);
      P  := StringToOleStr(FullFolderPath);
      //get the folder's full ItemIDList
      OleCheck(DesktopShellFolder.ParseDisplayName(0, nil, P, NumChars, NewPIDL, Flags));
      if NewPIDL <> nil then
      begin
        ParentPIDL := CopyPIDL(NewPIDL);
        StripLastID(ParentPIDL);      //get the folder's parent object's ItemIDList
     
        ID := RelativeFromAbsolute(NewPIDL);  //get the folder's relative ItemIDList
     
        //get the folder's parent object's IShellFolder interface
        OleCheck(DesktopShellFolder.BindToObject(ParentPIDL, nil, IID_IShellFolder,
          Pointer(ParentShellFolder)));
     
        if ParentShellFolder <> nil then
        begin
          Flags := SFGAO_SHARE;
          //get the folder's attributes
          OleCheck(ParentShellFolder.GetAttributesOf(1, ID, Flags));
          if IsElement(SFGAO_SHARE, Flags) then Result := True;
        end;
      end;
    end;
     
    {How to use the function?
     The parameter in is the full path of a folder}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if IfFolderShared('C:\My Documents\WinPopup') then ShowMessage('shared')
      else
        ShowMessage('not shared');
    end;

