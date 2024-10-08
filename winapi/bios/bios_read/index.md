---
Title: Как прочитать ROM-BIOS?
Date: 2003-02-15
Author: Nico Bendlin <nicode@gmx.net>
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как прочитать ROM-BIOS?
=======================

Пример этого модуля доступен для скачивания в виде демо-версии.


    ////////////////////////////////////////////////////////////////////////////////
    //
    //                            BIOS Helper for Delphi
    //
    //               BIOS related utilities for Win9x and WinNT(i386)
    //
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  The Original Code is:
    //   BiosHelp.pas, released 2001-09-02.
    //
    //  The Initial Developer of the Original Code is Nico Bendlin.
    //
    //  Portions created by Nico Bendlin are
    //   Copyright (C) 2001-2003 Nico Bendlin. All Rights Reserved.
    //
    //  Contributor(s):
    //   Nico Bendlin<nicode@gmx.net>
    //
    //  The contents of this file are subject to the Mozilla Public License Version
    //  1.1 (the "License"); you may not use this file except in compliance with the
    //  License. You may obtain a copy of the License at http://www.mozilla.org/MPL/
    //
    //  Software distributed under the License is distributed on an "AS IS" basis,
    //  WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
    //  the specific language governing rights and limitations under the License.
    //
    //  Alternatively, the contents of this file may be used under the terms of
    //  either the GNU General Public License Version 2 or later (the "GPL"), or
    //  the GNU Lesser General Public License Version 2.1 or later (the "LGPL"),
    //  in which case the provisions of the GPL or the LGPL are applicable instead
    //  of those above. If you wish to allow use of your version of this file only
    //  under the terms of either the GPL or the LGPL, and not to allow others to
    //  use your version of this file under the terms of the MPL, indicate your
    //  decision by deleting the provisions above and replace them with the notice
    //  and other provisions required by the GPL or the LGPL. If you do not delete
    //  the provisions above, a recipient may use your version of this file under
    //  the terms of any one of the MPL, the GPL or the LGPL.
    //
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  Revision:
    //
    //    2003-02-15  2.00 [NicoDE]
    //                     - generic dump method completely rewritten
    //                     - default range is now E000:0000-F000:FFFF
    //
    ////////////////////////////////////////////////////////////////////////////////
     
    {$IFDEF CONDITIONALEXPRESSIONS}
      {$DEFINE DELPHI6UP}
      {$IF NOT DEFINED(VER140)}
        {$DEFINE DELPHI7UP}
      {$IFEND}
    {$ENDIF}
     
    unit BiosHelp {$IFDEF DELPHI6UP} platform {$ENDIF};
     
    {$MINENUMSIZE 4}
    {$WEAKPACKAGEUNIT}
    {$IFDEF DELPHI7UP}
      {$WARN UNSAFE_TYPE OFF}
      {$WARN UNSAFE_CODE OFF}
    {$ENDIF}
     
    interface
     
    uses
      Windows;
     
    const
      RomBiosDumpBase = $000E0000;
      RomBiosDumpEnd  = $000FFFFF;
      RomBiosDumpSize = RomBiosDumpEnd - RomBiosDumpBase + 1;
     
    type
      PRomBiosDump = ^TRomBiosDump;
      TRomBiosDump = array [RomBiosDumpBase..RomBiosDumpEnd] of Byte;
     
    type
      TRomDumpMethod = (rdmAutomatic,  // Autodetect OS type and use proper method
        rdmGeneric,    // Use 16-bit EXE program to dump the BIOS
        rdmMemory,     // Dump from process's address space (Win9x)
        rdmPhysical    // Dump from physical memory object (WinNT)
        );
     
    function DumpRomBios(out Dump: TRomBiosDump;
      Method: TRomDumpMethod = rdmAutomatic; Timeout: DWORD = 5000): Boolean;
    function DumpRomBiosEx(RomBase: Pointer; RomSize: Cardinal; out Dump;
      Method: TRomDumpMethod = rdmAutomatic; Timeout: DWORD = 5000): Boolean;
     
    procedure ReadRomDumpBuffer(const Dump: TRomBiosDump; Addr: Pointer;
      var Buffer; Size: Cardinal);
    procedure ReadRomDumpBufferEx(const Dump; Base, Addr: Pointer;
      var Buffer; Size: Cardinal);
     
    function GetRomDumpAddr(const Dump: TRomBiosDump; Addr: Pointer): Pointer;
    function GetRomDumpAddrEx(const Dump; Base, Addr: Pointer): Pointer;
     
    implementation
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  DumpRomBios16 (rdmGeneric)
    //
    //    Creates an 16-bit EXE program in TEMP and runs it redirected to an file.
    //
    //    WARNING: One day 16-bit code will not run on future Windows.
    //    WARNING: You are dumping the BIOS inside the MS-DOS 'emulator'.
    //
     
    function _RomDumpCode(RomBase: Pointer; RomSize: Cardinal;
      out Code: Pointer; out Size: Cardinal): Boolean;
    const
      BlockSize = $1000;
    type                                     // ; RomDump (dumps mem to STDOUT)
      PRomDumpCode = ^TRomDumpCode;          // ; BlockSize MUST be multiple of 10h.
      TRomDumpCode = packed record           //
        _header: TImageDosHeader;            //
        _notice: array[0..$4F] of AnsiChar;  // @@note: db      'RomDump 2.0', ...
        init: packed record                  // @@init:
          _mov_44: array[0..2] of Byte;      //         mov     ax, 4400h
          _mov_bx: array[0..2] of Byte;      //         mov     bx, 0001h
          _dos_21: array[0..1] of Byte;      //         int     21h
          _jcf_18: array[0..1] of Byte;      //         jc      @@code
          _and_dx: array[0..3] of Byte;      //         and     dx, 0082h
          _cmp_dx: array[0..3] of Byte;      //         cmp     dx, 0082h
          _jne_0E: array[0..1] of Byte;      //         jne     @@code
          _psh_cs: Byte;                     //         push    cs
          _pop_ds: Byte;                     //         push    ds
          _mov_dx: array[0..2] of Byte;      //         mov     dx, offset @@note
          _mov_09: array[0..1] of Byte;      //         mov     ah, 09h
          _int_21: array[0..1] of Byte;      //         int     21h
          _mov_4C: array[0..2] of Byte;      //         mov     ax, 4C01h
          _int_20: array[0..1] of Byte;      //         int     21h
        end;                                 //
        code: packed record                  // @@code:
          _mov_cx: Byte; 
          BlockCount: Word;   //         mov     cx, <BlockCount>
          _mov_dx: Byte; 
          DatSegment: Word;   //         mov     dx, <DatSegment>
          _jcx_1C: array[0..1] of Byte;      //         jcxz    @@rest
        end;                                 //
        loop: packed record                  // @@loop:
          _psh_cx: Byte;                     //         push    cx
          _psh_dx: Byte;                     //         push    dx
          _mov_ds: array[0..1] of Byte;      //         mov     ds, dx
          _mov_dx: Byte; 
          DatOffset: Word;    //         mov     dx, <DatOffset>
          _mov_cx: array[0..2] of Byte;      //         mov     cx, <BlockSize>
          _mov_bx: array[0..2] of Byte;      //         mov     bx, 0001h
          _mov_ax: array[0..2] of Byte;      //         mov     ax, 4000h
          _int_21: array[0..1] of Byte;      //         int     21h
          _pop_dx: Byte;                     //         pop     dx
          _pop_cx: Byte;                     //         pop     cx
          _jcf_1C: array[0..1] of Byte;      //         jc      @@exit
          _add_dx: array[0..3] of Byte;      //         add     dx, <BlockSize/10h>
          _lop_E4: array[0..1] of Byte;      //         loop    @@loop
        end;                                 //
        rest: packed record                  // @@rest:
          _mov_ds: array[0..1] of Byte;      //         mov     ds, dx
          _mov_dx: Byte; 
          DatOffset: Word;    //         mov     dx, <DatOffset>
          _mov_cx: Byte; 
          LenghtMod: Word;    //         mov     cx, <LenghtMod>
          _mov_bx: array[0..2] of Byte;      //         mov     bx, 0001h
          _mov_ax: array[0..2] of Byte;      //         mov     ax, 4000h
          _jcx_06: array[0..1] of Byte;      //         jcxz    @@exit
          _int_21: array[0..1] of Byte;      //         int     21h
          _jcf_02: array[0..1] of Byte;      //         jc      @@exit
          _mov_al: array[0..1] of Byte;      //         mov     al, 00h
        end;                                 //
        Exit: packed record                  // @@exit:
          _mov_ah: array[0..1] of Byte;      //         mov     ah, 4Ch
          _int_21: array[0..1] of Byte;      //         int     21h
        end;                                 //
      end;
    const
      RomDumpCodeSize = SizeOf(TRomDumpCode) - SizeOf(TImageDosHeader);
      RomDumpCode: TRomDumpCode = (_header: (e_magic: IMAGE_DOS_SIGNATURE;
        e_cblp: Word(RomDumpCodeSize) and $1FF;
        e_cp: Word((RomDumpCodeSize - 1) shr 9) + 1;
        e_crlc: $0000;
        e_cparhdr: SizeOf(TImageDosHeader) shr 4;
        e_minalloc: $0000;
        e_maxalloc: $FFFF;
        e_ss: $0000;
        e_sp: $1000;
        e_csum: $0000;
        e_ip: SizeOf(RomDumpCode._notice);
        e_cs: $0000;
        e_lfarlc: SizeOf(TImageDosHeader);
        e_ovno: $0000;
        e_res: ($0000, $0000, $0000, $0000);
        e_oemid: $0000;
        e_oeminfo: $0000;
        e_res2: ($0000, $0000, $0000, $0000, $0000, $0000, $0000, $0000,
        $0000, $0000);
        _lfanew: $00000000
        );
        _notice: #13#10 +
        'RomDump 2.0'#13#10 +
        'Copyright (c) 2003 Nico Bendlin'#13#10 +
        #13#10 +
        'Usage: RomDump > filename'#13#10 +
        #13#10'$';
        init: (_mov_44: ($B8, $00, $44);
        _mov_bx: ($BB, $01, $00);
        _dos_21: ($CD, $21);
        _jcf_18: ($72, $18);
        _and_dx: ($81, $E2, $82, $00);
        _cmp_dx: ($81, $FA, $82, $00);
        _jne_0E: ($75, $0E);
        _psh_cs: $0E;
        _pop_ds: $1F;
        _mov_dx: ($BA, $00, $00);
        _mov_09: ($B4, $09);
        _int_21: ($CD, $21);
        _mov_4C: ($B8, $01, $4C);
        _int_20: ($CD, $21);
        );
        code: (_mov_cx: $B9; BlockCount: $0010;
        _mov_dx: $BA; DatSegment: $F000;
        _jcx_1C: ($E3, $1C)
        );
        loop: (_psh_cx: $51;
        _psh_dx: $52;
        _mov_ds: ($8E, $DA);
        _mov_dx: $BA; DatOffset: $0000;
        _mov_cx: ($B9, Lo(BlockSize), Hi(BlockSize));
        _mov_bx: ($BB, $01, $00);
        _mov_ax: ($B8, $00, $40);
        _int_21: ($CD, $21);
        _pop_dx: $5A;
        _pop_cx: $59;
        _jcf_1C: ($72, $1C);
        _add_dx: ($81, $C2, Lo(BlockSize shr 4), Hi(BlockSize shr 4));
        _lop_E4: ($E2, $E4)
        );
        rest: (_mov_ds: ($8E, $DA);
        _mov_dx: $BA; DatOffset: $0000;
        _mov_cx: $B9; LenghtMod: $0000;
        _mov_bx: ($BB, $01, $00);
        _mov_ax: ($B8, $00, $40);
        _jcx_06: ($E3, $06);
        _int_21: ($CD, $21);
        _jcf_02: ($72, $02);
        _mov_al: ($B0, $00)
        );
        Exit: (_mov_ah: ($B4, $4C);
        _int_21: ($CD, $21)
        )
        );
    begin
      Result := False;
      if (RomSize > 0) and (RomSize <= $100000) and
        (Cardinal(RomBase) < $100000) and
        (Cardinal(RomBase) + RomSize <= $100000) then
      begin
        Size := SizeOf(TRomDumpCode);
        Code := Pointer(LocalAlloc(LPTR, Size));
        if Code <> nil then
          try
            PRomDumpCode(Code)^ := RomDumpCode;
            with PRomDumpCode(Code)^ do
            begin
              code.BlockCount := Word(RomSize div BlockSize);
              code.DatSegment := Word(Cardinal(RomBase) shr 4);
              loop.DatOffset  := Word(Cardinal(RomBase)) and $000F;
              rest.DatOffset  := loop.DatOffset;
              rest.LenghtMod  := Word(RomSize mod BlockSize);
            end;
            Result := True;
          except
            LocalFree(HLOCAL(Code));
            Code := nil;
            Size := 0;
          end;
      end;
    end;
     
    function _SaveRomDumpCodeToFile(RomBase: Pointer; RomSize: Cardinal;
      const FileName: string): Boolean;
    var
      Code: Pointer;
      Size: Cardinal;
      Hand: THandle;
      Num: DWORD;
    begin
      Result := False;
      if _RomDumpCode(RomBase, RomSize, Code, Size) then
        try
          Hand := CreateFile(PChar(FileName), GENERIC_WRITE, FILE_SHARE_READ, nil,
            CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, 0);
          if Hand <> INVALID_HANDLE_VALUE then
            try
              Result := WriteFile(Hand, Code^, Size, Num, nil) and (Num = Size);
              if not Result then
                DeleteFile(PChar(FileName));
            finally
              CloseHandle(Hand);
            end;
        finally
          LocalFree(HLOCAL(Code));
        end;
    end;
     
    function _ExecuteRomDumpCode(const Code, Dump: string; Timeout: DWORD): Boolean;
    var
      ComSpec: string;
      StartInfo: TStartupInfo;
      ProcInfo: TProcessInformation;
      ErrorMode: Cardinal;
    begin
      Result := False;
      SetLength(ComSpec, MAX_PATH + 1);
      SetLength(ComSpec,
        GetEnvironmentVariable('ComSpec', PChar(@ComSpec[1]), MAX_PATH));
      if Length(ComSpec) <= 0 then
        Exit;
      FillChar(StartInfo, SizeOf(TStartupInfo), 0);
      StartInfo.cb := SizeOf(TStartupInfo);
      StartInfo.dwFlags := STARTF_USESHOWWINDOW;
      StartInfo.wShowWindow := SW_HIDE;
      ErrorMode := SetErrorMode(SEM_FAILCRITICALERRORS or SEM_NOGPFAULTERRORBOX or
        SEM_NOALIGNMENTFAULTEXCEPT or SEM_NOOPENFILEERRORBOX);
      try
        if CreateProcess(nil, PChar(ComSpec + ' /C ' + Code + ' > ' + Dump),
          nil, nil, False, HIGH_PRIORITY_CLASS, nil, nil, StartInfo, ProcInfo) then
          try
            Result :=
              (WaitForSingleObject(ProcInfo.hProcess, Timeout) <> WAIT_TIMEOUT);
            if not Result then
              TerminateProcess(ProcInfo.hProcess, STATUS_TIMEOUT);
          finally
            CloseHandle(ProcInfo.hThread);
            CloseHandle(ProcInfo.hProcess);
          end;
      finally
        SetErrorMode(ErrorMode);
      end;
    end;
     
    function DumpRomBios16(RomBase: Pointer; RomSize: Cardinal; var Dump;
      Timeout: DWORD): Boolean;
    var
      Tmp: array [0..MAX_PATH] of Char;
      Dmp: array [0..MAX_PATH] of Char;
      Exe: array [0..MAX_PATH] of Char;
      Hnd: THandle;
      Num: DWORD;
    begin
      Result := False;
      if GetTempPath(MAX_PATH, Tmp) > 0 then
        GetShortPathName(Tmp, Tmp, MAX_PATH)
      else
        lstrcpy(Tmp, '.');
      if GetTempFileName(Tmp, 'rom', 0, Dmp) > 0 then
        try
          lstrcpy(Exe, Dmp);
          lstrcat(Exe, '.exe');  // Win9x requires .EXE extention
          if _SaveRomDumpCodeToFile(RomBase, RomSize, Exe) then
            try
              if _ExecuteRomDumpCode(Exe, Dmp, Timeout) then
              begin
                Hnd := CreateFile(Dmp, GENERIC_READ, FILE_SHARE_READ or
                  FILE_SHARE_WRITE, nil, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
                if Hnd <> INVALID_HANDLE_VALUE then
                  try
                    Result := ReadFile(Hnd, Dump, RomSize, Num, nil) and (Num = RomSize);
                  finally
                    CloseHandle(Hnd);
                  end;
              end;
            finally
              DeleteFile(Exe);
            end;
        finally
          DeleteFile(Dmp);
        end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  DumpRomBios9x (rdmMemory)
    //
    //    Win9x maps the BIOS into every process - therefore it's directly accessed.
    //
     
    function DumpRomBios9x(RomBase: Pointer; RomSize: Cardinal; var Dump): Boolean;
    begin
      Result := False;
      try
        Move(RomBase^, Dump, RomSize);
        Result := True;
      except
        // ignore exeptions
      end
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  DumpRomBiosNt (rdmPhysical)
    //
    //    On WinNT the BIOS is accessable through section '\Device\PhysicalMemory'.
    //    This object can only be opened by members of local 'Adminstrators' group.
    //    ZwOpenSection and RtlNtStatusToDosError are documented in newer MSDN/DDK.
    //
     
    type
      NTSTATUS = Integer;
     
      PUnicodeString = ^TUnicodeString;
      TUnicodeString = packed record
        Length: Word;
        MaximumLength: Word;
        Buffer: PWideChar;
      end;
     
      PObjectAttributes = ^TObjectAttributes;
      TObjectAttributes = record
        Length: ULONG;
        RootDirectory: THandle;
        ObjectName: PUnicodeString;
        Attributes: ULONG;
        SecurityDescriptor: PSecurityDescriptor;
        SecurityQualityOfService: PSecurityQualityOfService;
      end;
     
      TFNZwOpenSection = function(out Section: THandle; Access: ACCESS_MASK;
        Attributes: PObjectAttributes): NTSTATUS; 
      stdcall;
      TFNRtlNtStatusToDosError = function(Status: NTSTATUS): DWORD; 
      stdcall;
     
    const
      PhysMemDevName = '\Device\PhysicalMemory';
      PhysMemName: TUnicodeString = (Length: Length(PhysMemDevName) * SizeOf(WideChar);
        MaximumLength: Length(PhysMemDevName) * SizeOf(WideChar) + SizeOf(WideChar);
        Buffer: PhysMemDevName;
        );
      PhysMemMask: ACCESS_MASK = SECTION_MAP_READ;
      PhysMemAttr: TObjectAttributes = (Length: SizeOf(TObjectAttributes);
        RootDirectory: 0;
        ObjectName: @PhysMemName;
        Attributes: $00000040;  // OBJ_CASE_INSENSITIVE
        SecurityDescriptor: nil;
        SecurityQualityOfService: nil;
        );
     
    var
      ZwOpenSection: TFNZwOpenSection;
      RtlNtStatusToDosError: TFNRtlNtStatusToDosError;
     
    function DumpRomBiosNt(RomBase: Pointer; RomSize: Cardinal; var Dump): Boolean;
    var
      HMod: HMODULE;
      Stat: NTSTATUS;
      Sect: THandle;
      View: Pointer;
    begin
      Result := False;
      HMod   := GetModuleHandle('ntdll.dll');
      if HMod = 0 then
        SetLastError(ERROR_CALL_NOT_IMPLEMENTED)
      else
      begin
        if not Assigned(ZwOpenSection) then
          ZwOpenSection := GetProcAddress(HMod, 'ZwOpenSection');
        if not Assigned(RtlNtStatusToDosError) then
          RtlNtStatusToDosError := GetProcAddress(HMod, 'RtlNtStatusToDosError');
        if not Assigned(ZwOpenSection) or not Assigned(RtlNtStatusToDosError) then
          SetLastError(ERROR_CALL_NOT_IMPLEMENTED)
        else
        begin
          Stat := ZwOpenSection(Sect, PhysMemMask, @PhysMemAttr);
          if Stat >= 0 then
            try
              View := MapViewOfFile(Sect, PhysMemMask, 0, Cardinal(RomBase), RomSize);
              if View <> nil then
                try
                  Move(View^, Dump, RomSize);
                  Result := True;
                finally
                  UnmapViewOfFile(View);
                end;
            finally
              CloseHandle(Sect);
            end
          else
            SetLastError(RtlNtStatusToDosError(Stat));
        end;
      end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  DumpRomBios(Ex)
    //
    //    Public functions to call OS-dependent implementations.
    //
     
    function DumpRomBios(out Dump: TRomBiosDump;
      Method: TRomDumpMethod = rdmAutomatic; Timeout: DWORD = 5000): Boolean;
    begin
      Result := DumpRomBiosEx(Pointer(RomBiosDumpBase), RomBiosDumpSize, Dump,
        Method, Timeout);
    end;
     
    function DumpRomBiosEx(RomBase: Pointer; RomSize: Cardinal; out Dump;
      Method: TRomDumpMethod = rdmAutomatic; Timeout: DWORD = 5000): Boolean;
    begin
      Result := False;
      case Method of
        rdmAutomatic:
          if (GetVersion() and $80000000) <> 0 then
            Result := DumpRomBios9x(RomBase, RomSize, Dump)
          else
            begin
              Result := DumpRomBiosNt(RomBase, RomSize, Dump);
              if not Result then
                DumpRomBios16(RomBase, RomSize, Dump, DWORD(Timeout));
            end;
          rdmGeneric:
          Result := DumpRomBios16(RomBase, RomSize, Dump, DWORD(Timeout));
        rdmMemory:
          Result := DumpRomBios9x(RomBase, RomSize, Dump);
        rdmPhysical:
          Result := DumpRomBiosNt(RomBase, RomSize, Dump);
        else
          SetLastError(ERROR_INVALID_PARAMETER);
      end;
    end;
     
    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ReadRomDumpBuffer(Ex) / GetRomDumpAddr(Ex)
    //
    //    Utilities to simplify the access to dumps.
    //
     
    procedure ReadRomDumpBuffer(const Dump: TRomBiosDump; Addr: Pointer;
      var Buffer; Size: Cardinal);
    begin
      Move(Dump[Cardinal(Addr)], Buffer, Size);
    end;
     
    procedure ReadRomDumpBufferEx(const Dump; Base, Addr: Pointer;
      var Buffer; Size: Cardinal);
    begin
      Move(Pointer(Cardinal(@Dump) + Cardinal(Addr) - Cardinal(Base))^,
        Buffer, Size);
    end;
     
    function GetRomDumpAddr(const Dump: TRomBiosDump; Addr: Pointer): Pointer;
    begin
      Result := @Dump[Cardinal(Addr)];
    end;
     
    function GetRomDumpAddrEx(const Dump; Base, Addr: Pointer): Pointer;
    begin
      Result := Pointer(Cardinal(@Dump) + Cardinal(Addr) - Cardinal(Base));
    end;
     
    end.

