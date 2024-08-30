---
Title: Как получить версию моей DLL?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как получить версию моей DLL?
=============================

    procedure GetFileVersion(FileName: string; var Major1, Major2, 
        Minor1, Minor2: Integer); 
      var 
        Info: Pointer; 
        InfoSize: DWORD; 
        FileInfo: PVSFixedFileInfo; 
        FileInfoSize: DWORD; 
        Tmp: DWORD; 
      begin 
        InfoSize := GetFileVersionInfoSize(PChar(FileName), Tmp); 
        if InfoSize = 0 then 
          //Файл не содержит информации о версии
        else 
        begin     
          GetMem(Info, InfoSize); 
          try 
            GetFileVersionInfo(PChar(FileName), 0, InfoSize, Info); 
            VerQueryValue(Info, '\', Pointer(FileInfo), FileInfoSize); 
            Major1 := FileInfo.dwFileVersionMS shr 16; 
            Major2 := FileInfo.dwFileVersionMS and $FFFF; 
            Minor1 := FileInfo.dwFileVersionLS shr 16; 
            Minor2 := FileInfo.dwFileVersionLS and $FFFF; 
          finally 
            FreeMem(Info, FileInfoSize); 
          end; 
        end; 
      end;

