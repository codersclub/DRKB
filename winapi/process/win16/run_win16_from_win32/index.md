---
Title: Как вызывать функцию 16-битной DLL из 32-битного приложения?
Author: Quality freeware from Sight&Sound, Slovenia,
Date: 01.01.2007
---

Как вызывать функцию 16-битной DLL из 32-битного приложения?
============================================================

Вариант 1:

Author: Андрей Гусев (Andrey Gusev)

Source: Akzhan\'s Delphi-related VCL&WinAPI Tips\'n\'Tricks

Надо использовать Thunks.

Кусок работающего только под Windows 95 кода:

    const
      Gfsr_SystemResources = 0;
      Gfsr_GdiResources = 1;
      Gfsr_UserResources = 2;
    var
      hInst16: THandle;
      GFSR: Pointer;
    { Undocumented Kernel32 calls. }
    function LoadLibrary16(LibraryName: PChar): THandle;
             stdcall; external kernel32 index 35;
    procedure FreeLibrary16(HInstance: THandle);
              stdcall; external kernel32 index 36;
    function GetProcAddress16(Hinstance: THandle; ProcName: PChar): Pointer;
             stdcall; external kernel32 index 37;
    procedure QT_Thunk; cdecl; external kernel32 name 'QT_Thunk';
    { QT_Thunk needs a stack frame. }
    {$StackFrames On}
    { Thunking call to 16-bit USER.EXE. The ThunkTrash argument
    allocates space on the stack for QT_Thunk. }
    function NewGetFreeSystemResources(SysResource: Word): Word;
    var
      ThunkTrash: array[0..$20] of Word;
    begin
      { Prevent the optimizer from getting rid of ThunkTrash. }
      ThunkTrash[0] := hInst16;
      hInst16 := LoadLibrary16('user.exe');
      if hInst16 < 32 then
        raise Exception.Create('Cannot load USER.EXE!');
      { Decrement the usage count. This doesn't really free the
        library, since USER.EXE is always loaded. }
      FreeLibrary16(hInst16);
      { Get the function pointer for the 16-bit function in USER.EXE. }
      GFSR := GetProcAddress16(hInst16, 'GetFreeSystemResources');
      if GFSR = nil then
        raise Exception.Create('Cannot get address of GetFreeSystemResources!');
      { Thunk down to USER.EXE. }
      asm
        push SysResource { push arguments }
        mov edx, GFSR { load 16-bit procedure pointer }
        call QT_Thunk { call thunk }
        mov Result, ax { save the result }
      end;
    end;

Автор: Quality freeware from Sight&Sound, Slovenia,
http://www.sight-sound.si

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

Посылаю код для определения системных ресурсов (как в "Индикаторе
ресурсов"). Использовалась статья "Calling 16-bit code from 32-bit in
Windows 95".

    { GetFeeSystemResources routine for 32-bit Delphi.
     
    Works only under Windows 9x }
     
    unit SysRes32;
     
    interface
     
    const
      //Constants whitch specifies the type of resource to be checked
       
      GFSR_SYSTEMRESOURCES = $0000;
      GFSR_GDIRESOURCES    = $0001;
      GFSR_USERRESOURCES   = $0002;
     
    // 32-bit function exported from this unit
     
    function GetFeeSystemResources(SysResource: Word):Word;
     
    implementation
     
    uses
      SysUtils, Windows;
     
    type
     
      //Procedural variable for testing for a nil
      TGetFSR = function(ResType: Word): Word; stdcall;
       
      //Declare our class exeptions
       
      EThunkError = class(Exception);
      EFOpenError = class(Exception);
     
    var
      User16Handle : THandle = 0;
      GetFSR       : TGetFSR = nil;
     
    //Prototypes for some undocumented API
     
    function LoadLibrary16(LibFileName: PAnsiChar): THandle;
             stdcall; external kernel32 index 35;
     
    function FreeLibrary16(LibModule: THandle): THandle;
             stdcall; external kernel32 index 36;
     
    function GetProcAddress16(Module: THandle; ProcName: LPCSTR): TFarProc;
             stdcall; external kernel32 index 37;
     
    procedure QT_Thunk; cdecl;
              external 'kernel32.dll' name 'QT_Thunk';
     
    {$StackFrames On}
     
    function GetFeeSystemResources(SysResource: Word):Word;
    var
      EatStackSpace: String[$3C];
    begin
      // Ensure buffer isn't optimised away
      EatStackSpace := '';
      @GetFSR:=GetProcAddress16(User16Handle,'GETFREESYSTEMRESOURCES');
      if  Assigned(GetFSR) then  //Test result for nil
        asm
          //Manually push onto the stack type of resource to be checked first
          push  SysResource
          //Load routine address into EDX
          mov   edx, [GetFSR]
          //Call routine
          call  QT_Thunk
          //Assign result to the function
          mov   @Result, ax
        end
      else
        raise EFOpenError.Create('GetProcAddress16 failed!');
    end;
     
    initialization
     
    //Check Platform for Windows 9x
    if Win32Platform <> VER_PLATFORM_WIN32_WINDOWS then
      raise EThunkError.Create('Flat thunks only supported under Windows 9x');
     
    //Load 16-bit DLL (USER.EXE)
    User16Handle:= LoadLibrary16(PChar('User.exe'));
     
    if User16Handle < 32 then
      raise EFOpenError.Create('LoadLibrary16 failed!');
     
    finalization
     
    //Release 16-bit DLL when done
    if User16Handle <> 0 then
      FreeLibrary16(User16Handle);
     
    end.

