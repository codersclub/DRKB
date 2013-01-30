---
Title: Прочитать boot-сектор
Author: startinger
Date: 01.01.2007
---


Прочитать boot-сектор
=====================

::: {.date}
01.01.2007
:::

Вообще-то загрузочный сектор можно прочитать вот так:

    type
      TSector = array[0..511] of Byte;
    var
      Boot: TSector;
    begin
      ReadBoot(Drive, Boot);

Но учитывая разницу платформ 95, 98, Me и NT, 2000, XP можно сделать 2
процедуры, а в главной части проги вызывать необходимую:

    //для 95, 98, Me
    type
       TDiocRegisters = record
         EBX, EDX, ECX, EAX, EDI, ESI, Flags: LongWord end;
     
       TVWin32CtlCode = (ccNone, ccVWin32IntIoctl, ccVWin32Int25,
         ccVWin32Int26, ccVWin32Int13);
     
     function VWin32(CtlCode: TVWin32CtlCode; 
       var Regs: TDiocRegisters): Boolean; // вспомогательная процедура
      var
         Device: THandle;
         Count: LongWord;
       begin
       Device := CreateFile('\.\VWIN32', 0, 0, nil, 0,
         FILE_FLAG_DELETE_ON_CLOSE, 0);
       if Device = INVALID_HANDLE_VALUE then
         raise Exception.Create(SysErrorMessage(GetLastError));
       try
         Result := DeviceIoControl(Device, Ord(CtlCode), @Regs,
           SizeOf(Regs), @Regs, SizeOf(Regs), Count, nil);
       finally
         CloseHandle(Device) end end;
     
    //само чтение
    procedure ReadBoot95(Drive: Char; var Boot: TSector);
       var
         Regs: TDiocRegisters;
       begin
       with Regs do begin
         EAX := Ord(UpCase(Drive)) - Ord('A');
         EBX := LongWord(@Boot);
         ECX := 1;
         EDX := 0 end;
       if not VWin32(ccVWin32Int25, Regs) then
         raise Exception.Create(SysErrorMessage(GetLastError)) end;
     
    //для NT, 2000, XP попроще
    type
       TSector = array[0..511] of Byte;
     procedure ReadBootNT(Drive: Char; var Boot: TSector);
       var
         BytesRead: Cardinal;
         H: THandle;
       begin
       H := CreateFile(PChar(Format('\.\%s:', [UpCase(Drive)])),
         GENERIC_READ, 0, nil, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
       if H = INVALID_HANDLE_VALUE then
         raise Exception.Create(SysErrorMessage(GetLastError));
       try
         if not ReadFile(H, Boot, SizeOf(Boot), BytesRead, nil)then
           raise Exception.Create(SysErrorMessage(GetLastError));
       finally
         CloseHandle(H) end end;
     
    // а юзать так
     
    var
         Boot: TSector;
       begin
       case Win32Platform of
         VER_PLATFORM_WIN32_WINDOWS:
           ReadBoot95(Drive, Boot);
         VER_PLATFORM_WIN32_NT:
           ReadBootNT(Drive, Boot) end;

Boot и есть необходимый массив.

Автор: startinger

Взято из <https://forum.sources.ru>
