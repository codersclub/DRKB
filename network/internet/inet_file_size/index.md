---
Title: Как узнать размер файла в интернете?
Author: P.O.D.
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать размер файла в интернете?
====================================

    uses wininet;
    ...
    function GetUrlSize(const URL:string):integer;//результат в байтах
    var
      hSession,hFile:hInternet;
      dwBuffer:array[1..20] of char;
      dwBufferLen,dwIndex:DWORD;
    begin
     Result:=0;
     hSession:=InternetOpen('GetUrlSize',INTERNET_OPEN_TYPE_PRECONFIG,nil,nil,0);
     if Assigned(hSession) then begin
      hFile:=InternetOpenURL(hSession,PChar(URL),nil,0,INTERNET_FLAG_RELOAD,0);
      dwIndex:=0;
      dwBufferLen:=20;
      if HttpQueryInfo(hFile,HTTP_QUERY_CONTENT_LENGTH,@dwBuffer,dwBufferLen,dwIndex) then Result:=StrToInt(StrPas(@dwBuffer));
      if Assigned(hFile) then InternetCloseHandle(hFile);
      InternetCloseHandle(hsession);
     end;
    end;

