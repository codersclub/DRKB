---
Title: Получить информацию о BIOSе материнской платы и видеокарты
Author: Andrey Sorokin (anso@mail.ru)
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Получить информацию о BIOSе материнской платы и видеокарты
===========================

Вот пример, как можно даты БИОС материнской платы и видеокарты выдрать.

То же самое можно с названием производителя и версией.

В WinNT приходится читать не из ПЗУ, а из реестра но это достаточно надежно -
соответствующие ключи WinNT закрывает на запись и обновляет при каждом старте (?).

Для Win9x можешь хоть весь БИОС напрямую читать.

Получить заводской номер винчестера (не тот, что getvolumeinfo дает)
ИМХО невозможно - порты IDE даже Win9x блокирует.

    type
    TRegistryRO = class (TRegistry)
       function OpenKeyRO (const Key: string): Boolean;
      end;
    { это уже ветхая история - был один глюк у D3}
     
    implementation
     
    uses WAPIInfo, Windows, SysUtils, StrUtils;
     
    function TRegistryRO.OpenKeyRO (const Key: string): Boolean;
    function
    IsRelative(const Value: string): Boolean;
      begin Result := not ((Value <> '') and (Value[1] = '\')) end;
    var
      TempKey: HKey;
      S: string;
      Relative: Boolean;
    begin
      S := Key;
      Relative := IsRelative(S);
      if not Relative then Delete(S, 1, 1);
      TempKey := 0;
        Result := RegOpenKeyEx(GetBaseKey(Relative), PChar(S), 0,
          KEY_READ, TempKey) = ERROR_SUCCESS;
       if Result then begin
         if (CurrentKey <> 0) and Relative then S := CurrentPath + '\' + S;
         ChangeKey(TempKey, S);
        end;
    end;
     
    function GetBIOSDate : string;
    const
      BIOSDatePtr = $0ffff5;
      SystemKey = 'HARDWARE\DESCRIPTION\System';
      BiosDateParam = 'SystemBiosDate';
    var
      p : pointer;
      s : string[128];
    begin
      if OSisNT then begin
         with TRegistryRO.Create do try
           RootKey := HKEY_LOCAL_MACHINE;
           if OpenKeyRO (SystemKey) then begin
             s := ReadString (BiosDateParam);
            end;
           finally Free;
          end; { of try}
        end
       else try
          s[0] := #8;
          p := Pointer(BIOSDatePtr);
          Move (p^, s[1], 8);
         except FillChar (s[1], 8, '9');
        end; { of try}
      Result := copy (s, 1, 2) + copy (s, 4, 2) + copy (s, 7, 2);
    end;
     
    function GetVideoDate : string;
    const
      VideoDatePtr = $0C0000;
      SystemKey = 'HARDWARE\DESCRIPTION\System';
      VideoDateParam = 'VideoBiosDate';
    var
      p : pointer;
      s : string[255];
    begin
      if OSisNT then begin
         with TRegistryRO.Create do try
           RootKey := HKEY_LOCAL_MACHINE;
           if OpenKeyRO (SystemKey)
            then s := ReadString (VideoDateParam)
            else s := 'NT/de/tected';
           finally Free;
          end; { of
    try}
        end
       else try
          s[0] := #255;
          p := Pointer(VideoDatePtr + 60); { первые $60 - строка CopyRight}
          Move (p^, s[1], 255);
          if pos('/', s) > 2 then s := copy (s, pos('/', s) - 2, 8)
           else begin
             p := Pointer(VideoDatePtr + 60 + 250);
             Move (p^, s[1], 255);
             if pos('/', s) > 2 then s := copy (s, pos('/', s) - 2, 8);
            end;
         except FillChar (s[1], 8, '9');
        end; { of try}
      Result := copy (s, 1, 2) + copy (s, 4, 2) + copy (s, 7, 2);
    end;

    unit WAPIInfo;
     
    interface
     
    uses
    Registry, SysUtils, Windows;
     
    procedure GetOSVerInfo (var OSID : DWORD; var OSStr : string);
    function OSisNT : boolean;
    procedure GetCPUInfo (var CPUID : DWORD; var CPUStr : string);
    procedure GetMemInfo (var MemStr : string);
     
    implementation
     
    procedure GetOSVerInfo (var OSID : DWORD; var OSStr : string);
    var
      OSVerInfo : TOSVersionInfo;
      Reg : TRegistry;
      s : string;
    begin
      OSVerInfo.dwOSVersionInfoSize := SizeOf (OSVerInfo);
      GetVersionEx (OSVerInfo);
      OSID := OSVerInfo.dwPlatformID;
      case OSID of
        VER_PLATFORM_WIN32S : OSStr := 'Windows 3+';
        VER_PLATFORM_WIN32_WINDOWS : OSStr := 'Windows 95+';
       VER_PLATFORM_WIN32_NT : begin
          OSStr := 'Windows NT';
          Reg := TRegistry.Create;
          Reg.RootKey := HKEY_LOCAL_MACHINE;
          if Reg.OpenKey ('SYSTEM\CurrentControlSet\Control\', False)
            then try
             s := Reg.ReadString ('ProductOptions')
            except s := ''
           end;
          if s = 'WINNT' then OSStr := OSStr + ' WorkStation'
          else if s = 'SERVERNT' then OSStr := OSStr + ' Server 3.5 & hi'
          else if s = 'LANMANNT' then OSStr := OSStr + ' Advanced server 3.1';
          Reg.Free;
     
      end;
       end;
      with OSVerInfo do OSStr := OSStr + Format (' %d.%d (выпуск %d)',
       [dwMajorVersion, dwMinorVersion, LoWord(dwBuildNumber)]);
    end;
     
    function OSisNT : boolean;
    var
      s : string;
      i : DWORD;
    begin
      GetOSVerInfo (i, s);
      Result := (i = VER_PLATFORM_WIN32_NT);
    end;
     
    procedure GetCPUInfo (var CPUID : DWORD; var CPUStr : string);
    var SI : TSystemInfo;
    begin
      GetSystemInfo (SI);
      CPUID := SI.dwProcessorType;
      case CPUID of
        386: CPUStr := '80386-совместимый процессор';
        486: CPUStr := '80486-совместимый процессор';
        586: CPUStr := 'Pentium-совместимый процессор';
     
     else CPUStr := 'Неизвестный процессор';
       end;
    {  case SI.wProcessorArchitecture of
        PROCESSOR_ARCHITECTURE_INTEL: ;
        MIPS
        ALPHA
        PPC
        UNKNOWN
       end;}
    end;
     
    procedure GetMemInfo (var MemStr : string);
    var MemInfo : TMemoryStatus;
    begin
      MemInfo.dwLength := SizeOf (MemInfo);
      GlobalMemoryStatus (MemInfo);
      with MemInfo do MemStr := Format ('ОЗУ: %0.2f M (свободно %0.2f M)'#$d+
       ' Файл подкачки: %0.2f M (свободно: %0.2f M)'#$d,
       [(dwTotalPhys div 1024) / 1024,
        (dwAvailPhys div 1024) / 1024,
        (dwTotalPageFile div 1024) / 1024,
        (dwAvailPageFile div 1024) / 1024]);
    end;
     
    end.


**PS.**  
Возможно, эти процедуры не всегда дату возвращают,
но то что практически всегда для разных материнских/видео плат
возвращаются разные значения - проверено,
что мне собственно и требовалось.

Andrey Sorokin from sunny  
Saint-Petersburg anso@mail.ru  
Russian Technology http://attend.to/rt  
anso@rt.spb.ru

