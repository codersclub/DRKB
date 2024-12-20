---
Title: Как получить версию Windows?
Date: 01.01.2007
---

Как получить версию Windows?
============================

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

    type TOSVersion=(
      osUnknown,
      osUnknown9x,
      osUnknownNT,
      osWin95,
      osWin98,
      osWin98SE,
      osWinME,
      osWinNT,
      osWin2000,
      osXP
    );
     
    function GetOSVersion : TOSVersion;
    var
      osVerInfo : TOSVersionInfo;
      majorVer, minorVer : Integer;
    begin
      result := OsUnknown;
      osVerInfo.dwOSVersionInfoSize := SizeOf(TOSVersionInfo);
      if GetVersionEx(osVerInfo) then
      begin
        majorVer := osVerInfo.dwMajorVersion;
        minorVer := osVerInfo.dwMinorVersion;
        case osVerInfo.dwPlatformId of
          VER_PLATFORM_WIN32_NT :
            Case majorVer of
              4: result := OsWinNT;
              5: if minorVer=0 then
                   result := OsWin2000
                 else 
                   if minorVer=1 then
                     result := OsXP
                   else
                     result := osUnknownNT;
              else
                 result := osUnknownNT;
            end; {Case majorVer of}
          VER_PLATFORM_WIN32_WINDOWS :
            case majorVer of
              4: Case minorVer of
                   0:  result := OsWin95;
                   10: if osVerInfo.szCSDVersion[1] = 'A' then
                         result := OsWin98SE
                       else
                         result := OsWin98;
                   90: result := OsWinME;
                   else result := osUnknown9x;
                 end;{Case minorVer of}
              else result := osUnknown9x;
            end{case majorVer of}
          else result := OsUnknown;
        end;{case osVerInfo.dwPlatformId of}
      end;{if GetVersionEx(osVerInfo) then}
    end;
    
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      case GetOSVersion of
        osUnknown: Showmessage('Unknown');
        osWin95: Showmessage('Win95');
        osWin98: Showmessage('Win98');
        osWin98SE: Showmessage('Win98SE');
        osWinME: Showmessage('WinME');
        osWinNT: Showmessage('WinNT');
        osWin2000: Showmessage('Win2000');
        osXP: Showmessage('XP');
      end;
    end;

------------------------------------------------------------------------

Вариант 2:

Author: inko

Source: Vingrad.ru <https://forum.vingrad.ru>

    procedure TForm1.WinVer;
    var WinV: Word;
    begin
      WinV := GetVersion AND $0000FFFF;
      Edit6.Text := IntToStr(Lo(WinV))+'.'+IntToStr(Hi(WinV));
    end;

Функция выдает следующее - 4.10

Как можно таким же простым способом получить полную версию - 4.10.222

------------------------------------------------------------------------

Вариант 3:

Author: Pegas

Source: Vingrad.ru <https://forum.vingrad.ru>

Вот еще один пример. Мне он нравиться больше всего. Я его обычно
использую в своих программах. Он гибкий и предоставляет максимум
информации.

    {Объявление процедур и констант}
     
    function GetWindowsVersion1: string;
    function WhatWindowsIsInstalled : String;
    const
      VER_NT_WORKSTATION = 0;
      VER_NT_DOMAIN_CONTROLLER = 1;
      VER_NT_SERVER = 2;
       
      VER_SUITE_SMALLBUSINESS = 1;
      VER_SUITE_ENTERPRISE = 2;
      VER_SUITE_BACKOFFICE = 4;
      VER_SUITE_COMMUNICATIONS = 8;
      VER_SUITE_TERMINAL = $10;
      VER_SUITE_SMALLBUSINESS_RESTRICTED = $20;
      VER_SUITE_EMBEDDEDNT = $40;
      VER_SUITE_DATACENTER = $80;
      VER_SUITE_SINGLEUSERTS = $100;
      VER_SUITE_PERSONAL = $200;
      VER_SUITE_BLADE = $400;
     
    type
    
    TOsVersionInfoExA = packed record
      old : TOsVersionInfoA;
      wServicePackMajor : Word;
      wServicePackMinor : Word;
    
      {
      wSuiteMask           - Набор битовых флагов,
                             определяющих компоненты Windows:
      VER_SUITE_BACKOFFICE - Установлен компонент Microsoft BackOffice.
      VER_SUITE_BLADE      - Установлен компонент Windows .NET Web Server.
      VER_SUITE_DATACENTER - Установлена Windows 2000
                             или компонент Windows .NET Datacenter Server
      VER_SUITE_ENTERPRISE - Установлена Windows 2000 Advanced Server
                             или компонент Windows .NET Enterprise Server.
      VER_SUITE_PERSONAL   - Установлена Windows XP Home Edition.
      VER_SUITE_SMALLBUSINESS - Установлен Microsoft Small Business Server.
      VER_SUITE_SMALLBUSINESS_RESTRICTED - Установлен Microsoft Small Business Server
                              с ограничительной лицензией для клиентов
      VER_SUITE_TERMINAL   - Установлен компонент Terminal Services.
      }
      wSuiteMask : Word;
      
      {wProductType        - Дополнительная информация о типе операционной системы
      VER_NT_WORKSTATION   - Операционная система Windows NT 4.0 Workstation,
                             Windows 2000 Professional, Windows XP Home Edition,
                             или Windows XP Professional.
      VER_NT_DOMAIN_CONTROLLER - Операционная система является контроллером домена.
      VER_NT_SERVER - Операционная система является сервером.
      }
      wProductType : Byte;
      
      wReserved : Byte;
    end;
     
    ...
     
    {Реализация}
    function WhatWindowsIsInstalled : String;
    var
      VerInfo : TOsVersionInfoExA;
    begin
      FillChar(VerInfo, sizeof(VerInfo), 0);
      VerInfo.old.dwOSVersionInfoSize := Sizeof(TOsVersionInfoExA);
      if NOT GetVersionExA(VerInfo.old) then 
      begin
        VerInfo.old.dwOSVersionInfoSize := Sizeof(TOsVersionInfoA);
        GetVersionExA(VerInfo.old);
      end;
      case VerInfo.old.dwPlatformId of
        VER_PLATFORM_WIN32_WINDOWS:
          if (Verinfo.old.dwMajorVersion = 4) AND 
             (Verinfo.old.dwBuildNumber = 950) then
            Result := 'Windows 95'
          else 
          if (Verinfo.old.dwMajorVersion = 4) AND 
             (Verinfo.old.dwMinorVersion = 10) AND 
             (Verinfo.old.dwBuildNumber = 1998) then
            Result := 'Windows 98'
          else 
          if (Verinfo.old.dwMinorVersion = 90) then
            Result := 'Windows Me';
        VER_PLATFORM_WIN32_NT:
          if Verinfo.old.dwMajorVersion = 3 then
            Result := 'Windows NT 3.51' else 
          if Verinfo.old.dwMajorVersion = 4 then
            Result := 'Windows NT 4.0' else 
          if Verinfo.old.dwMajorVersion = 5 then 
            if Verinfo.old.dwMinorVersion = 0 then
              Result := 'Windows 2000'
            else 
            if Verinfo.old.dwMinorVersion = 1 then
              Result := 'Windows XP';
        VER_PLATFORM_WIN32s:
          Result := 'Win32s';
      end;
    end;
     
    function GetWindowsVersion1: string;
    {$IFDEF WIN32}
    const sWindowsVersion = '%.3d';
    var
      Ver: TOsVersionInfo;
      Platform: string[4];
    begin
      Ver.dwOSVersionInfoSize := SizeOf(Ver);
      GetVersionEx(Ver);
      with Ver do begin
        case dwPlatformId of
          VER_PLATFORM_WIN32s: Platform := '32s';
          VER_PLATFORM_WIN32_WINDOWS:
            begin
               dwBuildNumber := dwBuildNumber and $0000FFFF;
              if (dwMajorVersion > 4) or
                 ((dwMajorVersion = 4) and (dwMinorVersion >= 10)) then
                Platform := '98'
              else Platform := '95';
            end;
          VER_PLATFORM_WIN32_NT: Platform := 'NT';
        end;
        Result := Trim(Format(sWindowsVersion, [dwBuildNumber]));
      end;
    end;
    {$ELSE}
    const
      sWindowsVersion = 'Windows%s %d.%d';
      sNT: array[Boolean] of string[3] = ('', ' NT');
    var
      Ver: Longint;
    begin
      Ver := GetVersion;
      Result := Format(sWindowsVersion, [sNT[not Boolean(HiByte(LoWord(Ver)))],
      LoByte(LoWord(Ver)), HiByte(LoWord(Ver))]);
    end;
    {$ENDIF WIN32}

Пример вызова

    Label1.Caption := WhatWindowsIsInstalled+' (Build '+GetWindowsVersion1+')';        

------------------------------------------------------------------------

Вариант 4:

Source: <https://delphiworld.narod.ru>

Этот пример должен работать на всех версиях Windows

    {$IFDEF WIN32}
     
    function GetVersionEx(lpOs: pointer): BOOL; stdcall;
      external 'kernel32' name 'GetVersionExA';
    {$ENDIF}
     
    procedure GetWindowsVersion(var Major: integer; var Minor: integer);
    var
    {$IFDEF WIN32}
      lpOS, lpOS2: POsVersionInfo;
    {$ELSE}
      l: longint;
    {$ENDIF}
    begin
    {$IFDEF WIN32}
      GetMem(lpOS, SizeOf(TOsVersionInfo));
      lpOs^.dwOSVersionInfoSize := SizeOf(TOsVersionInfo);
      while getVersionEx(lpOS) = false do begin
        GetMem(lpos2, lpos^.dwOSVersionInfoSize + 1);
        lpOs2^.dwOSVersionInfoSize := lpOs^.dwOSVersionInfoSize + 1;
        FreeMem(lpOs, lpOs^.dwOSVersionInfoSize);
        lpOS := lpOs2;
      end;
      Major := lpOs^.dwMajorVersion;
      Minor := lpOs^.dwMinorVersion;
      FreeMem(lpOs, lpOs^.dwOSVersionInfoSize);
    {$ELSE}
      l := GetVersion;
      Major := LoByte(LoWord(l));
      Minor := HiByte(LoWord(l));
    {$ENDIF}
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Major: integer;
      Minor: integer;
    begin
      GetWindowsVersion(Major, Minor);
      Memo1.Lines.Add(IntToStr(Major));
      Memo1.Lines.Add(IntToStr(Minor));
    end;

