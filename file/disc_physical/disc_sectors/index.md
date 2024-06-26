---
Title: Модуль для работы с дисковыми драйверами (На уровне секторов)
Author: NikNet (NikNet@Yandex.ru)
Date: 01.01.2007
---


Модуль для работы с дисковыми драйверами (На уровне секторов)
=============================================================

    { Автор : NikNet
      MAIL   : NikNet@yandex.ru}
     
    Unit Disk;
     
    Interface
     
    Uses Windows,SysUtils;
     
    VAR
     dsBytePerSector : word = 512; // Установите размер сектора
     
    function ReadLogicalSector  (Drive: Byte; Sector: Int64; Count: Word; Var Buffer): Boolean;
    function WriteLogicalSector (Drive: Byte; Sector: Int64; Count: Word; Var Buffer): Boolean;
     
    function ReadPlysicalSector (HddNumber: Byte; Sector:Int64; Count:word;  Var Buffer): DWORD;
    function WritePlysicalSector(HddNumber: Byte; Sector:Int64; Count:word;  Var Buffer): DWORD;
     
     
    Implementation
     
     
      TYPE
       PDIOC_Registers = ^TDIOC_Registers;
       TDIOC_Registers = record
         case Byte of
          0: (EBX,EDX,ECX,EAX,EDI,ESI,Flags: DWord);
          1: (BX,BXE,DX,DXE,CX,CXE,AX,AXE,DI,DIE,SI,SIE: Word);
         end;
     
      TReadWritePacket = packed record
        StartSector: DWord;
        Sectors    : Word;
        Buffer     : Pointer;
      end;
     
    const
     
      VWIN32_DEVICE_NAME        = '\\.\VWIN32';
      VWIN32_DIOC_CLOSE         = 0; { Close the device.                           }
      VWIN32_DIOC_DOS_IOCTL     = 1; { MS-DOS device I/O control function,         }
                                     { interrupt 21h function 4400h through 4411h  }
      VWIN32_DIOC_DOS_INT25     = 2; { MS-DOS absolute disk read command,          }
                                     { interrupt 25h.                              }
      VWIN32_DIOC_DOS_INT26     = 3; { MS-DOS absolute disk write command,         }
                                     { interrupt 26h.                              }
      VWIN32_DIOC_DOS_INT13     = 4; { Low-level BIOS disk functions,              }
                                     { interrupt 13h.                              }
      VWIN32_DIOC_DOS_DRIVEINFO = 6; { MS-DOS Interrupt 21h new function 730x.     }
                                     { Supported only by Windows 95 OSR2 and later.}
     
      FLAG_CARRY = $00000001;
     
      // Error codes
      ERROR_NON                  = $0000; { no error                               }
      // MS-DOS/Windows error codes:
      ERROR_INVALID_FUNCTION     = $0001; { invalid function number                }
      ERROR_FILE_NOT_FOUND       = $0002; { file not found                         }
      ERROR_ACCESS_DENIED        = $0005; { specified access denied on drive       }
      ERROR_INVALID_DRIVE        = $000F; { invalid drive number                   }
      ERROR_MEDIA_NOT_LOCKED     = $00B0; { media is not locked in drive           }
      ERROR_MEDIA_LOCKED         = $00B1; { media is locked in drive               }
      ERROR_MEDIA_NOT_REMOVABLE  = $00B2; { media is not removable                 }
      ERROR_LOCKE_COUNT_EXCEEDED = $00B4; { media locke count exceeded             }
      ERROR_EJECT_REQUEST_FAILED = $00B5; { valid media eject request failed       }
     
      // Interrupt 13h/25h/26h error codes:
      ERROR_BAD_COMMAND          = $10001; { bad command                           }
      ERROR_BAD_ADDRESS_MARK     = $10002; { bad address mark                      }
      ERROR_WRITE_PROTECTED      = $10003; { write-protected disk                  }
      ERROR_SECTOR_NOT_FOUND     = $10004; { requested sector not found            }
      ERROR_RESET_FAILED         = $10005; { reset failed                          }
      ERROR_DISK_CHANGED         = $10006; { disk changed (floppy disk)            }
      ERROR_PARAMETER_FAILED     = $10007; { drive parameter activity failed       }
      ERROR_DMA_FAILURE          = $10008; { DMA failure/overrun                   }
      ERROR_DMA_SEGMENT_FAULT    = $10009; { attempted DMA across 64K boundary     }
      ERROR_BAD_SECTOR_DETECTED  = $1000A; { bad sector detected                   }
      ERROR_BAD_TRACK_DETECTED   = $1000B; { bad track detected                    }
      ERROR_INVALID_MEDIA        = $1000C; { invalid media or unsupported track    }
      ERROR_INVALID_SECTORS      = $1000D; { invalid number of sectors on format   }
      ERROR_CONTROL_DATA         = $1000E; { control data address mark detected    }
      ERROR_DMA_ARBITRATION      = $1000F; { DMA arbitration level out of range    }
      ERROR_DATA_ERROR           = $10010; { data error (uncorrectable CRC or ECC) }
      ERROR_DATA_ECC_CORRECTED   = $10011; { data ECC corrected                    }
      ERROR_CONTROLLER_FAILED    = $10020; { controller failed                     }
      ERROR_SEEK_FAILED          = $10040; { seek operation failed                 }
      ERROR_DEVICE_FAILED        = $10080; { device failed to respond (timeout)    }
      ERROR_DRIVE_NOT_READY      = $100AA; { drive not ready                       }
      ERROR_UNDEFINED            = $100BB; { undefined error                       }
      ERROR_WRITE_FAULT          = $100CC; { write fault                           }
      ERROR_STATUS_REGISTER      = $100E0; { status register error                 }
      ERROR_SENSE_FAILED         = $100FF; { sense operation failed                }
     
      // VWIN32 custom error codes:
      ERROR_UNKNOWN              = $00100000; { unknown error                      }
      ERROR_OPENING_DEVICE       = $00300000; { error trying to open device        }
     
      { Lock permission codes: }
      LOCK_ALLOW_WRITING  = $0001; { Allow write operations in level 1 lock. Write }
                                   { operations are always blocked in level 2 & 3  }
                                   { lock.                                         }
      LOCK_BLOCK_MAPPING  = $0002; { Block new file mappings in level 1 & 2 lock.  }
                                   { New file mappings are always blocked in level }
                                   { 3 lock.                                       }
                                   { Read operations are always allowed in level   }
                                   { 1 & 2 lock, and blocked in level 3 lock.      }
      LOCK_FOR_FORMATTING = $0004; { Locks the volume for formatting. Specified    }
                                   { when a level 0 lock is obtained for the second}
                                   { time.                                         }
     
    Var
     
      VWIN32Error: DWord;
      VWIN32Device : THandle;
     
     
    function VWIN32DIOC(ControlCode: Integer; Registers: PDIOC_Registers): Boolean;
    var
      BytesReturned : DWord;
     
      function OpenDevice: Boolean;
      begin
         VWIN32Error := ERROR_NON;
        if (VWIN32Device = INVALID_HANDLE_VALUE) or (VWIN32Device = 0) then
        begin
          VWIN32Device := CreateFile(VWIN32_DEVICE_NAME,0,0,nil,0,FILE_FLAG_DELETE_ON_CLOSE,0);
          if (VWIN32Device = INVALID_HANDLE_VALUE) then
          VWIN32Error := ERROR_OPENING_DEVICE;
        end;
         Result := VWIN32Error = ERROR_NON;
      end;
     
      procedure CloseDevice;
      begin
        if (VWIN32Device <> INVALID_HANDLE_VALUE) then CloseHandle(VWIN32Device);
        VWIN32Device := INVALID_HANDLE_VALUE;
        Result := true;
      end;
     
    begin
      VWIN32Error := ERROR_NON;
      if ControlCode = VWIN32_DIOC_CLOSE then CloseDevice
      else if OpenDevice then begin
        Result := DeviceIoControl(VWIN32Device,ControlCode,Registers,SizeOf(Registers^),
                                  Registers,SizeOf(Registers^),BytesReturned,nil);
        if not result then VWIN32Error := ERROR_UNKNOWN;
      end
      else Result := false;
    end;
     
     
    function LockLogicalVolume(Drive: Byte; Level, Permission: Byte): Boolean;
    var
      Registers: TDIOC_Registers;
    begin
      VWIN32Error := ERROR_NON;
      Result := false;
      if (Level > 1) then Permission := $00
      else Permission := Permission and $07;
        Registers.EAX := $440D;
        Registers.EBX := (Level shl 8) or Drive;
        Registers.ECX := $484A;
        Registers.EDX := Permission;
        Registers.Flags := $00000000;
        if (VWIN32DIOC(VWIN32_DIOC_DOS_IOCTL,@Registers)) then
          if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true;
      if not Result then
      begin
        Registers.EAX := $440D;
        Registers.EBX := (Level shl 8) or Drive;
        Registers.ECX := $084A;
        Registers.EDX := Permission;
        Registers.Flags := $00000000;
        if (VWIN32DIOC(VWIN32_DIOC_DOS_IOCTL,@Registers)) then begin
          if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true
          else VWIN32Error := Registers.AX;
        end;
      end;
    end;
     
    function UnlockLogicalVolume(Drive: Byte): Boolean;
    var
      Registers: TDIOC_Registers;
    begin
      VWIN32Error := ERROR_NON;
      Result := false;
        Registers.EAX := $440D;
        Registers.EBX := Drive;
        Registers.ECX := $486A;
        Registers.Flags := $00000000;
        if (VWIN32DIOC(VWIN32_DIOC_DOS_IOCTL,@Registers)) then
          if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true;
      if not Result then
      begin
        Registers.EAX := $440D;
        Registers.EBX := Drive;
        Registers.ECX := $086A;
        Registers.Flags := $00000000;
        if (VWIN32DIOC(VWIN32_DIOC_DOS_IOCTL,@Registers)) then
          if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true
          else VWIN32Error := Registers.AX;
      end;
    end;
     
     
    function ReadHDD9x(HDD: Byte; Sector: DWord; Count: Word; Var Buffer): Boolean;
    TYPE
     TPacket       = packed record
        PacketSize   : Byte;
        Unesed1      : Byte;
        NumSector    : Byte;
        Unesed2      : Byte;
        Buffer       : POINTER;
        Sector       : comp;
      end;
     
    var
      Registers        : TDIOC_Registers;
      Packet           : TPacket;
    begin
      Packet.PacketSize := 16   ; Packet.Unesed1 := 0;
      Packet.NumSector  := Count   ; Packet.Unesed2 := 0;
      Packet.Buffer     := @Buffer ; Packet.Sector  := Sector;
      VWIN32Error := ERROR_NON;
      Result := false;
      Registers.EAX := $4200; // Read one sector
      Registers.ECX := $0000; // Cyl 0; Sec 1
      Registers.EDX := $0080; // Head 0; Dev. Num 80h ( HDD0 )
      Registers.ESI := DWORD(@Buffer);     // Set ES:BX to Buffer
      VWIN32DIOC(VWIN32_DIOC_DOS_INT13,@Registers);
    end;
     
     
    function Read9xSector(Drive: Byte; Sector: DWord; Count: Word; Var Buffer): Boolean;
    var
      Registers        : TDIOC_Registers;
      ReadWritePacket  : TReadWritePacket;
    begin
      VWIN32Error := ERROR_NON;
      Result := false;
      ReadWritePacket.StartSector := Sector;
      ReadWritePacket.Sectors := Count;
      ReadWritePacket.Buffer := @Buffer;
   
      Registers.EAX   := $7305;
      Registers.EBX   := DWord(@ReadWritePacket);
      Registers.ECX   := $FFFFFFFF;
      Registers.EDX   := Drive;
      Registers.ESI   := $0000;
      Registers.Flags := $00000000;
   
      if VWIN32DIOC(VWIN32_DIOC_DOS_DRIVEINFO,@Registers) then
        if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true;
     
      if (not Result) then
      begin
        ReadWritePacket.StartSector := Sector;
        ReadWritePacket.Sectors := Count;
        ReadWritePacket.Buffer := @Buffer;
     
        Registers.EAX := Drive-1;
        Registers.EBX := DWord(@ReadWritePacket);
        Registers.ECX := $FFFFFFFF;
        Registers.Flags := $00000000;
     
        if VWIN32DIOC(VWIN32_DIOC_DOS_INT25,@Registers) then begin
          if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true
          else VWIN32Error := $10000 or (Registers.AX and $00FF);
        end;
      end;
    end;
     
     
    function Write9xSector(Drive: Byte; Sector: DWord; Count: Word; Var Buffer; Mode: Byte): Boolean;
    var
      Registers      : TDIOC_Registers;
      ReadWritePacket: TReadWritePacket;
    begin
      VWIN32Error := ERROR_NON;
      Result := false;
      if (LockLogicalVolume(Drive, 1, LOCK_ALLOW_WRITING)) then
      begin
          ReadWritePacket.StartSector := Sector;
          ReadWritePacket.Sectors := Count;
          ReadWritePacket.Buffer := @Buffer;
     
          Registers.EAX := $7305;
          Registers.EBX := DWord(@ReadWritePacket);
          Registers.ECX := $FFFFFFFF;
          Registers.EDX := Drive;
          Registers.ESI := $0001 or (Mode and $6000);
          Registers.Flags := $00000000;
          if (VWIN32DIOC(VWIN32_DIOC_DOS_DRIVEINFO,@Registers)) then
            if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true;
        if (not Result) then
        begin
          ReadWritePacket.StartSector := Sector;
          ReadWritePacket.Sectors := Count;
          ReadWritePacket.Buffer := @Buffer;
          Registers.EAX := Drive-1;
          Registers.EBX := DWord(@ReadWritePacket);
          Registers.ECX := $FFFFFFFF;
          Registers.Flags := $00000000;
          if (VWIN32DIOC(VWIN32_DIOC_DOS_INT26,@Registers)) then
          begin
            if ((Registers.Flags and FLAG_CARRY) = 0) then Result := true
            else VWIN32Error := $10000 or (Registers.AX and $00FF);
          end;
        end;
        UnlockLogicalVolume(Drive);
      end;
    end;
     
     
    function __Mul(a,b: DWORD; var HiDWORD: DWORD): DWORD; // Result = LoDWORD
    asm
      mul edx
      mov [ecx],edx
    end;
     
     
    function ReadNTSector(Drive: Byte; Sector,SectorCount: DWord; Var Buffer): Boolean;
    var
      hDrive: THandle;
      DriveRoot: string;
      br,TmpLo,TmpHi: DWORD;
    begin
      Result := False;
      TmpLo:=0;
      TmpHi:=TmpLo;
     
      DriveRoot := '\\.\' + Chr(64 + Drive) + ':';
      hDrive := CreateFile(
        PAnsiChar(DriveRoot), GENERIC_READ,
        FILE_SHARE_READ or FILE_SHARE_WRITE,
        nil, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
        if (hDrive = INVALID_HANDLE_VALUE) then Exit;
        TmpLo :=__Mul(Sector,dsBytePerSector,TmpHi);
        if SetFilePointer(hdrive,TmpLo,@TmpHi,FILE_BEGIN) = TmpLo then
        begin
         if ReadFile(hdrive,Buffer,dsBytePerSector*SectorCount,br,nil) then
         Result := BR = (dsBytePerSector*SectorCount);
      end;
          CloseHandle(hDrive);
    end;
     
     
    function WriteNTSector(Drive: Byte; Sector,SectorCount: DWord; Var Buffer): Boolean;
    var
      hDrive: THandle;
      DriveRoot: string;
      bw,TmpLo,TmpHi: DWORD;
    begin
      Result := False;
      DriveRoot := '\\.\' + Chr(64 + Drive) + ':';
      hDrive := CreateFile(
        PAnsiChar(DriveRoot), GENERIC_WRITE,
        FILE_SHARE_READ or FILE_SHARE_WRITE,
        nil, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
       if (hDrive = INVALID_HANDLE_VALUE) then Exit;
      TmpLo :=__Mul(Sector,dsBytePerSector,TmpHi);
      if SetFilePointer(hdrive,TmpLo,@TmpHi,FILE_BEGIN) = TmpLo then
      begin
       if not WriteFile(hdrive,Buffer,dsBytePerSector*SectorCount,bw,nil) then Exit;
       Result := bw = (dsBytePerSector*SectorCount);
      end;
       CloseHandle(hDrive);
    end;
     
    function ReadLogicalSector  (Drive: Byte; Sector: Int64; Count: Word; Var Buffer): Boolean;
    begin
     case Win32Platform of
      VER_PLATFORM_WIN32_WINDOWS: Result:= Read9xSector(Drive, Sector, Count, Buffer);
      VER_PLATFORM_WIN32_NT     : Result:= ReadNTSector(Drive, Sector, Count, Buffer);
     End;
    end;
     
    function WriteLogicalSector  (Drive: Byte; Sector: Int64; Count: Word; Var Buffer): Boolean;
    begin
     case Win32Platform of
      VER_PLATFORM_WIN32_WINDOWS: Result:= Write9xSector(Drive, Sector, Count, Buffer,1);
      VER_PLATFORM_WIN32_NT     : Result:= WriteNTSector(Drive, Sector, Count, Buffer);
     End;
    end;
     
    function ReadPlysicalSector (HddNumber: Byte; Sector:Int64; Count:word;  Var Buffer): DWORD;
    var
      hFile: THandle;
      br,TmpLo,TmpHi: DWORD;
    begin
      Result := 0;
      hFile := CreateFile(PChar('\\.\PhysicalDrive'+IntToStr(HddNumber)),
        GENERIC_READ,FILE_SHARE_READ,nil,OPEN_EXISTING,FILE_ATTRIBUTE_NORMAL,0);
      if hFile = INVALID_HANDLE_VALUE then Exit;
      TmpLo := __Mul(Sector,dsBytePerSector,TmpHi);
      if SetFilePointer(hFile,TmpLo,@TmpHi,FILE_BEGIN) = TmpLo then
      begin
        Count := Count*dsBytePerSector;
        if ReadFile(hFile,Buffer,Count,br,nil) then Result := br;
      end;
      CloseHandle(hFile);
    end;
     
    function WritePlysicalSector (HddNumber: Byte; Sector:Int64; Count:word;  Var Buffer): DWORD;
    var
      hFile: THandle;
      bw,TmpLo,TmpHi: DWORD;
    begin
      Result := 0;
      hFile := CreateFile(PChar('\\.\PhysicalDrive'+IntToStr(HddNumber)),
        GENERIC_WRITE,FILE_SHARE_READ,nil,OPEN_EXISTING,FILE_ATTRIBUTE_NORMAL,0);
      if hFile = INVALID_HANDLE_VALUE then Exit;
      TmpLo := __Mul(Sector,dsBytePerSector,TmpHi);
      if SetFilePointer(hFile,TmpLo,@TmpHi,FILE_BEGIN) = TmpLo then
      begin
        Count := Count*dsBytePerSector;
        if WriteFile(hFile,Buffer,Count,bw,nil) then Result := bw;
      end;
      CloseHandle(hFile);
    end;
     
     
      Function GetLogic(C,H,S,Hmax,Smax:Int64):comp;
      BEGIN
       GetLogic:=(C*Hmax+H)*Smax+S-1;
      END;
     
     
      Procedure GetPhysical(N,Hmax,Smax:Int64; var C,H,S:Int64);
      BEGIN
       C:=N div (Hmax*Smax);
       H:=(N-C*Hmax*Smax) div Smax;
       S:=N-(C*Hmax+H)*Smax+1;
      END;
     
      PROCEDURE UnPackCylSec(CSec:word; var Cyl,Sec: Word);
      Begin
        Cyl := (CSec and 192) shl 2+CSec shr 8;
        Sec := CSec and 63;
      end;
     
      FUNCTION PackCylSec(Cyl,Sec: Word): Word;
      BEGIN
       PackCylSec := Sec+(Cyl and $300) shr 2+(Cyl shl 8)
      END;
     
     
    end.
