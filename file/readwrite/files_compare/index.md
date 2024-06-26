---
Title: Как сравнить два файла?
Date: 01.01.2007
---


Как сравнить два файла?
=======================

Вариант 1:

Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

Первый пример:

    function Are2FilesEqual(const File1, File2: TFileName): Boolean; 
    var 
      ms1, ms2: TMemoryStream; 
    begin 
      Result := False; 
      ms1 := TMemoryStream.Create; 
      try 
        ms1.LoadFromFile(File1); 
        ms2 := TMemoryStream.Create; 
        try 
          ms2.LoadFromFile(File2); 
          if ms1.Size = ms2.Size then 
            Result := CompareMem(ms1.Memory, ms2.memory, ms1.Size); 
        finally 
          ms2.Free; 
        end; 
      finally 
        ms1.Free; 
      end 
    end; 

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if Opendialog1.Execute then 
        if Opendialog2.Execute then 
          if Are2FilesEqual(Opendialog1.FileName, Opendialog2.FileName) then 
            ShowMessage('Files are equal.'); 
    end; 


Второй пример:


    function FilesAreEqual(const File1, File2: TFileName): Boolean; 
    const   
      BlockSize = 65536; 
    var   
      fs1, fs2: TFileStream;   
      L1, L2: Integer;   
      B1, B2: array[1..BlockSize] of Byte; 
    begin   
      Result := False;   
      fs1 := TFileStream.Create(File1, fmOpenRead or fmShareDenyWrite); 
      try     
        fs2 := TFileStream.Create(File2, fmOpenRead or fmShareDenyWrite); 
        try       
          if fs1.Size = fs2.Size then  
          begin         
            while fs1.Position < fs1.Size do  
            begin           
              L1 := fs1.Read(B1[1], BlockSize); 
              L2 := fs2.Read(B2[1], BlockSize); 
              if L1 <> L2 then  
              begin             
                Exit; 
              end;           
              if not CompareMem(@B1[1], @B2[1], L1) then Exit;         
            end;         
            Result := True;       
          end;     
        finally       
          fs2.Free;     
        end;   
      finally     
        fs1.Free;   
      end; 
    end; 


------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    function CompareFiles(Filename1,FileName2:string):longint;
    {
      Сравнение файлов
     
      возвращает номер несовпадающего байта,
      (байты отсчитываются с 1)или:
      0 - не найдено отличий,
      -1 - ошибка файла 1
      -2 - ошибка файла 2
      -3 - другие ошибки
    }
    const
      Buf_Size=16384;
    var
      F1,F2:TFileStream;
      i:longint;
      Buff1,Buff2:PByteArray;
      BytesRead1,BytesRead2:integer;
    begin
      Result:=0;
      try
        F1:=TFileStream.Create(FileName1,fmShareDenyNone);
      except
        Result:=-1;
        exit;
      end;
      try
        F2:=TFileStream.Create(FileName2,fmShareDenyNone);
      except
        Result:=-2;
        F1.Free;
        exit;
      end;
      GetMem(Buff1,Buf_Size);
      GetMem(Buff2,Buf_Size);
      try
        if F1.Size> F2.Size then Result:=F2.Size+1
        else if F1.SizeF1.Position) and (Result=0) do begin
          BytesRead1 :=F1.Read(Buff1^,Buf_Size);
          BytesRead2 :=F2.Read(Buff2^,Buf_Size);
          if (BytesRead1=BytesRead2) then begin
            for i:= 0 to BytesRead1-1 do begin
              if Buff1^[i]< > Buff2^[i]
              then begin
                result:=F1.Position-BytesRead1+i+1;
                break;
              end;
            end;
          end else begin
            Result:=-3;
            break;
          end;
        end;
      end;
      except
        Result:=-3;
      end;
      F1.Free;
      F2.Free;
      FreeMem(Buff1,Buf_Size);
      FreeMem(Buff2,Buf_Size);
    end;


------------------------------------------------------------------------

Вариант 3:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

    unit findin;
     
    interface
     
    uses
      Windows, SysUtils, findstr;
     
    type
      TFindInFile = class;
     
      TFindIn = class
      protected
        FFindInFile: TFindInFile;
        FHandle: THandle;
        function GetPartNum: Integer; virtual; abstract;
        function GetPartLen(Index: Integer): Cardinal; virtual; abstract;
      public
        constructor Create(FindInFile: TFindInFile; FileName: string); virtual;
        destructor Destroy; override;
        function CanUseMem: Boolean; virtual; abstract;
        function UseMemSize: Cardinal; virtual; abstract;
        function GetPart(Index: Integer; Len: Cardinal): Pointer; virtual; abstract;
        property PartNum: Integer read GetPartNum;
        property PartLen[Index: Integer]: Cardinal read GetPartLen;
      end;
     
      TFindInClass = class of TFindIn;
     
      TBMSearchFunc = function(var Buffer; BufLength: Cardinal; var BT: TBMTbl;
        MatchString: PAnsiChar; var Pos: Cardinal): Boolean;
     
      TFindInFile = class
      protected
        FFindIn: TFindIn;
        FFindInClass: TFindInClass;
        FFindStrParams: PFindStrParams;
        FMemHandle: THandle;
        FMem: Pointer;
        FStrLen: Cardinal;
        FDriveTp: UINT;
        FBMSearchFunc: TBMSearchFunc;
        function GetDriveTp(Root: string): UINT;
      public
        constructor Create(FindStrParams: PFindStrParams);
        destructor Destroy; override;
        function Find(FileName: string): Cardinal;
        function SwitchToRoot(Root: string): Boolean; virtual;
      end;
     
      TFindInHDD = class(TFindIn)
      private
        FSize: Cardinal;
      protected
        FMapPtr: Pointer;
        function GetPartNum: Integer; override;
        function GetPartLen(Index: Integer): Cardinal; override;
      public
        constructor Create(FindInFile: TFindInFile; FileName: string); override;
        destructor Destroy; override;
        function CanUseMem: Boolean; override;
        function UseMemSize: Cardinal; override;
        function GetPart(Index: Integer; Len: Cardinal): Pointer; override;
      end;
     
      PIntArr = ^TIntArr;
      TIntArr = array[0..1] of Cardinal;
     
      TFindInRemovable = class(TFindIn)
      private
        FSize: Cardinal;
      protected
        FPartNum: Integer;
        function GetPartNum: Integer; override;
        function GetPartLen(Index: Integer): Cardinal; override;
      public
        constructor Create(FindInFile: TFindInFile; FileName: string); override;
        function CanUseMem: Boolean; override;
        function UseMemSize: Cardinal; override;
        function GetPart(Index: Integer; Len: Cardinal): Pointer; override;
      end;
     
    implementation
     
    resourcestring
      SInvalidDrive = 'Invalid drive - "%s".';
     
      { TFindIn }
     
    constructor TFindIn.Create(FindInFile: TFindInFile; FileName: string);
    begin
      inherited Create;
      FFindInFile := FindInFile;
      FHandle := CreateFile(PChar(FileName), GENERIC_READ, FILE_SHARE_READ,
        nil, OPEN_EXISTING, FILE_FLAG_SEQUENTIAL_SCAN, 0);
      if FHandle = INVALID_HANDLE_VALUE then
        RaiseLastWin32Error;
    end;
     
    destructor TFindIn.Destroy;
    begin
      if FHandle <> 0 then
        CloseHandle(FHandle);
      inherited Destroy;
    end;
     
    { TFindInHDD }
     
    constructor TFindInHDD.Create(FindInFile: TFindInFile; FileName: string);
    var
      hFile: THandle;
    begin
      inherited Create(FindInFile, FileName);
      FSize := GetFileSize(FHandle, nil);
      hFile := CreateFileMapping(FHandle, nil, PAGE_READONLY, 0, 0, nil);
      CloseHandle(FHandle);
      FHandle := hFile;
      if FHandle <> 0 then
      begin
        FMapPtr := MapViewOfFile(FHandle, FILE_MAP_READ, 0, 0, 0);
        if FMapPtr = nil then
          RaiseLastWin32Error;
      end
      else
        RaiseLastWin32Error;
    end;
     
    destructor TFindInHDD.Destroy;
    begin
      if FMapPtr <> nil then
        UnmapViewOfFile(FMapPtr);
      inherited Destroy;
    end;
     
    function TFindInHDD.GetPartNum: Integer;
    begin
      Result := 1;
    end;
     
    function TFindInHDD.GetPartLen(Index: Integer): Cardinal;
    begin
      Result := FSize;
    end;
     
    function TFindInHDD.GetPart(Index: Integer; Len: Cardinal): Pointer;
    begin
      Result := FMapPtr;
    end;
     
    function TFindInHDD.CanUseMem: Boolean;
    begin
      Result := False;
    end;
     
    function TFindInHDD.UseMemSize: Cardinal;
    begin
      Result := 0;
    end;
     
    { TFindInRemovable }
     
    constructor TFindInRemovable.Create(FindInFile: TFindInFile; FileName: string);
    var
      S: Cardinal;
    begin
      inherited Create(FindInFile, FileName);
      FSize := GetFileSize(FHandle, nil);
      if FSize = $FFFFFFFF then
        RaiseLastWin32Error;
      S := UseMemSize - Pred(FFindInFile.FStrLen);
      FPartNum := FSize div S;
      if FSize mod S <> 0 then
        Inc(FPartNum);
    end;
     
    function TFindInRemovable.GetPartNum: Integer;
    begin
      Result := FPartNum;
    end;
     
    function TFindInRemovable.GetPartLen(Index: Integer): Cardinal;
    begin
      Result := UseMemSize;
      if (Index = Pred(FPartNum)) and (FSize mod (Result - FFindInFile.FStrLen) <> 0) then
        Result := FSize - (Result - Pred(FFindInFile.FStrLen)) * Pred(FPartNum);
    end;
     
    function TFindInRemovable.GetPart(Index: Integer; Len: Cardinal): Pointer;
    var
      Dist: ULONG;
      Reading: DWORD;
    begin
      Result := FFindInFile.FMem;
      Dist := Index * (UseMemSize - Pred(FFindInFile.FStrLen));
      SetFilePointer(FHandle, Dist, nil, FILE_BEGIN);
      if not ReadFile(FHandle, Result^, Len, Reading, nil) then
        RaiseLastWin32Error;
    end;
     
    function TFindInRemovable.CanUseMem: Boolean;
    begin
      Result := True;
    end;
     
    function TFindInRemovable.UseMemSize: Cardinal;
    begin
      Result := 8; {512 * 1024;}
    end;
     
    { TFindInFile }
     
    function Max(V1, V2: Integer): Integer; assembler; register;
    asm
      CMP  EAX,EDX
      JG   @@1
      MOV  EAX,EDX
    @@1:
    end;
     
    constructor TFindInFile.Create(FindStrParams: PFindStrParams);
    var
      I: Integer;
    begin
      inherited Create;
      FDriveTp := $FFFFFFFF;
      FFindStrParams := FindStrParams;
      if FFindStrParams^.CaseSensitive then
        FBMSearchFunc := BMSearch
      else
        FBMSearchFunc := BMSearchUC;
      FStrLen := 0;
      for I := 0 to Pred(FFindStrParams^.Substr.Count) do
        FStrLen := Max(FStrLen, length(FFindStrParams^.Substr[I]));
    end;
     
    destructor TFindInFile.Destroy;
    begin
      if FMemHandle <> 0 then
      begin
        GlobalUnlock(FMemHandle);
        GlobalFree(FMemHandle);
      end;
      inherited Destroy;
    end;
     
    function TFindInFile.GetDriveTp(Root: string): UINT;
    begin
      Result := GetDriveType(PChar(ExtractFileDrive(Root) + '\'));
    end;
     
    function TFindInFile.Find(FileName: string): Cardinal;
    var
      I, J, K: Integer;
      L: Cardinal;
      P: Pointer;
      PI: PFindStrInfo;
      BMSFunc: TBMSFunc;
    begin
      Result := NotFound;
      FFindIn := FFindInClass.Create(Self, FileName);
      try
        if FFindIn.CanUseMem and (FMem = nil) then
        begin
          FMemHandle := GlobalAlloc(GMEM_MOVEABLE, FFindIn.UseMemSize);
          if FMemHandle = 0 then
            RaiseLastWin32Error;
          FMem := GlobalLock(FMemHandle);
        end;
        for I := 0 to Pred(FFindIn.PartNum) do
          for J := 0 to Pred(FFindStrParams^.Substr.Count) do
          begin
            L := FFindIn.PartLen[I];
            P := FFindIn.GetPart(I, L);
            Result := FindString(P^, L, J, FFindStrParams);
            PI := PFindStrInfo(FFindStrParams.Substr.Objects[J]);
            if FBMSearchFunc(P^, L, PI^.BMTbl, PI^.FindS, Result) then
            begin
              if I > 0 then
                for K := 1 to I - 1 do
                  Inc(Result, FFindIn.PartLen[K]);
              Exit;
            end;
          end;
      finally
        FFindIn.Free;
      end;
    end;
     
    function TFindInFile.SwitchToRoot(Root: string): Boolean;
    var
      Tp: UINT;
    begin
      Tp := GetDriveTp(Root);
      if Tp <> FDriveTp then
        case Tp of
          0, 1: Exception.CreateFmt(SInvalidDrive, [Root]);
          DRIVE_FIXED: FFindInClass := TFindInHDD;
        else
          {DRIVE_REMOVABLE:
           DRIVE_REMOTE:
           DRIVE_CDROM:
           DRIVE_RAMDISK:}
          FFindInClass := TFindInRemovable;
        end;
    end;
     
    end.

