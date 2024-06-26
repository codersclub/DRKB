---
Title: Создаем собственный UnRar, используя unrar.dll
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Создаем собственный UnRar, используя unrar.dll
==============================================

    // Объявления

    function RAROpenArchive(ArchiveData : Pointer): Integer; stdcall;
      external 'unrar.dll' name 'RAROpenArchive'; 
     
    function RARCloseArchive(hArcData : Integer): Integer; stdcall;
      external 'unrar.dll' name 'RARCloseArchive';
     
    function RARReadHeader(hArcData : Integer; HeaderData : Pointer): Integer; stdcall;
      external 'unrar.dll' name 'RARReadHeader';
     
    function RARProcessFile(hArcData : Integer; Operation : Integer; DestPath : Pointer;
      DestName : Pointer): Integer; stdcall;
      external 'unrar.dll' name 'RARProcessFile';
     
     
    const
      ERAR_END_ARCHIVE = 10;
      ERAR_NO_MEMORY = 11;
      ERAR_BAD_DATA = 12;
      ERAR_BAD_ARCHIVE = 13;
      ERAR_UNKNOWN_FORMAT = 14;
      ERAR_EOPEN = 15;
      ERAR_ECREATE = 16;
      ERAR_ECLOSE = 17;
      ERAR_EREAD = 18;
      ERAR_EWRITE = 19;
      ERAR_SMALL_BUF = 20;
     
      RAR_OM_LIST = 0;
      RAR_OM_EXTRACT = 1;
      RAR_SKIP = 0;
      RAR_TEST = 1;
      RAR_EXTRACT = 2;
      RAR_VOL_ASK = 0;
      RAR_VOL_NOTIFY = 1;
     
     
    type
      Char260 = Array [1..260] of Char;
     
      TRAROpenArchiveData = record
       ArcName : PChar; // в C++ это будет выглядеть как: char *ArcName
       OpenMode : Cardinal;
       OpenResult : Cardinal;
       CmtBuf : PChar;
       CmtBufSize : Cardinal;
       CmtSize : Cardinal;
       CmtState : Cardinal;
      end;
     
      TRARHeaderData = record
       ArcName : Char260;
       FileName : Char260;
       Flags : Cardinal;
       PackSize : Cardinal;
       UnpSize : Cardinal;
       HostOS : Cardinal;
       FileCRC : Cardinal;
       FileTime : Cardinal;
       UnpVer : Cardinal;
       Method : Cardinal;
       FileAttr : Cardinal;
       CmtBuf : PChar;
       CmtBufSize : Cardinal;
       CmtSize : Cardinal;
       CmtState : Cardinal;
      end;
     
     
    var
      RARExtract : boolean;
      RAROpenArchiveData : TRAROpenArchiveData;
      RARComment : array [1..256] of Char;
      RARHeaderData : TRARHeaderData;
     
      ...
     
    procedure ExtractRARArchive;
    var
      sDir : string;
      s : string;
      sTest : string;
      iTest : integer;
      bTestDone : boolean;
      RARhnd : Integer;
      RARrc : Integer;
      PDestPath : Char260;
     
    begin
      RARExtract:=TRUE;
      lKBWritten:=0;
      ProgressBar2.Position := 0;
      ProgressBar2.Max := lTotalSize;
      RARStartTime:=Time;
     
      RAROpenArchiveData.OpenResult:=99;
      RAROpenArchiveData.OpenMode := RAR_OM_EXTRACT; // открываем для распаковки
      RAROpenArchiveData.ArcName:= @RARFileName;
      RAROpenArchiveData.CmtBuf := @RARComment; 
      RAROpenArchiveData.CmtBufSize := 255; 
     
      // Открываем RAR архив и выделяем память
      RARhnd := RAROpenArchive (@RAROpenArchiveData);
      If RAROpenArchiveData.OpenResult <> 0 then
      begin
       case RAROpenArchiveData.OpenResult of
        ERAR_NO_MEMORY : s:='Not enough memory to initialize data structures';
        ERAR_BAD_DATA : s:='Archive header broken';
        ERAR_BAD_ARCHIVE : s:='File is not valid RAR archive';
        ERAR_EOPEN : s:='File open error';
       end;
       MessageDlg('Unable to open rar archive: ' + s + '!',mtError, [mbOK], 0);
      end;
     
      RARSetProcessDataProc(RARhnd,@Form.OnRarStatus);
      StrPCopy(@PDestPath, EInstallPath.Text);
     
      repeat
       RARrc := RARReadHeader (RARhnd, @RARHeaderData);// Читаем заголовок
       if RARrc <> ERAR_END_ARCHIVE then
       begin
        ProgressBar1.Position := 0;
        ProgressBar1.Max := RARHeaderData.UnpSize;
        s:=RARHeaderData.FileName;
        lblCurrentFile.Caption := s;
        lKBytesDone := 0;
       end;
     
       if RARrc = 0 then
       RARrc:=RARProcessFile (RARhnd, RAR_EXTRACT, @PDestPath, nil);
       if (RARrc <> 0) and (RARrc <> ERAR_END_ARCHIVE) then
       begin
        MessageDlg('An Error occured during extracting of ' + sTest+'!' + #13#10 +
        'RARProcessFile: ' + MakeItAString(RARrc),mtError, [mbOK], 0);
       end;
      until RARrc <> 0;
     
      // закрываем RAR архив и освобождаем память
      If RARCloseArchive(RARhnd) <> 0 then
      begin
       MessageDlg('Unable to close rar archive!',mtError, [mbOK], 0);
      end;
    end; // ExtractRARArchive

