---
Title: Обновление файла после перезагрузки системы
Author: Dimka Maslov, mainbox@endimus.ru
Date: 18.11.2002
---


Обновление файла после перезагрузки системы
===========================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Обновление файла после перезагрузки системы
     
    Данная процедура настраивает систему для обновления файлов после перезагрузки.
    TargetFileName - имя файла, содержимое которого при перезагрузке будет 
    заменено на содержимое файла, имя которого укзаывается в параметре SourceFileName. 
    Если первый аргумент процедуры представляет собой пустую строку, при 
    перезагрузке файл SourceFileName будет удалён.
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        18 ноября 2002 г.
    ********************************************** }
     
    procedure BootReplaceFile(TargetFileName, SourceFileName: string)
    var
     WinInitName: string;
     P: PChar;
     
    procedure InternalGetShortPathName(var S: string);
    begin
     UniqueString(S);
     GetShortPathName(PChar(S), PChar(S), Length(S));
     SetLength(S, StrLen(@S[1]));
     CharToOEM(PChar(S), PChar(S));
    end;
     
    begin
     if Win32Platform = VER_PLATFORM_WIN32_NT then begin
      if TargetFileName <> '' 
       then P:=PChar(TargetFileName)
       else P:=nil;
      MoveFileEx(PChar(SourceFileName), P,
       MOVEFILE_DELAY_UNTIL_REBOOT or MOVEFILE_REPLACE_EXISTING);
     end else begin
      SetLength(WinInitName, MAX_PATH);
      GetWindowsDirectory(@WinInitName[1], MAX_PATH);
      SetLength(WinInitName, StrLen(@WinInitName[1]));
      WinInitName:=IncludeTrailingBackslash(WinInitName)+'WININIT.INI';
      if TargetFileName = '' 
       then TargetFileName:='NUL'
       else InternalGetShortPathName(TargetFileName);
      InternalGetShortPathName(SourceFileName);
      WritePrivateProfileString('Rename', PChar(TargetFileName),
       PChar(SourceFileName), PChar(WinInit));
     end;
    end; 

Пример использования:

    BootReplaceFile('c:\Program Files\proga.exe', 'c:\temp\proga.exe'); // После перезагрузки содержимое первого файла будет заменено на содержимое второго файла, а второй файл будет удалён
     
    BootReplaceFile('', 'c:\temp\proga.exe'); // Указанный файл будет удалён после перезагрузки 
