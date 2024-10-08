---
Title: Как получить инфу о SCSI дисках?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как получить инфу о SCSI дисках?
================================

    program ScsiSN;
     
    // PURPOSE: Simple console application that display SCSI harddisk serial number
     
    {$APPTYPE CONSOLE}
     
    uses
      Windows, SysUtils;
     
    //-------------------------------------------------------------
     
    function GetDeviceHandle(sDeviceName: string): THandle;
    begin
      Result := CreateFile(PChar('\\.\' + sDeviceName),
        GENERIC_READ or GENERIC_WRITE,
        FILE_SHARE_READ or FILE_SHARE_WRITE,
        nil, OPEN_EXISTING, 0, 0)
    end;
     
    //-------------------------------------------------------------
     
    function ScsiHddSerialNumber(DeviceHandle: THandle): string;
    {$ALIGN ON}
    type
      TScsiPassThrough = record
        Length: Word;
        ScsiStatus: Byte;
        PathId: Byte;
        TargetId: Byte;
        Lun: Byte;
        CdbLength: Byte;
        SenseInfoLength: Byte;
        DataIn: Byte;
        DataTransferLength: ULONG;
        TimeOutValue: ULONG;
        DataBufferOffset: DWORD;
        SenseInfoOffset: ULONG;
        Cdb: array[0..15] of Byte;
      end;
      TScsiPassThroughWithBuffers = record
        spt: TScsiPassThrough;
        bSenseBuf: array[0..31] of Byte;
        bDataBuf: array[0..191] of Byte;
      end;
      {ALIGN OFF}
    var
      dwReturned: DWORD;
      len: DWORD;
      Buffer: array[0..SizeOf(TScsiPassThroughWithBuffers) +
      SizeOf(TScsiPassThrough) - 1] of Byte;
      sptwb: TScsiPassThroughWithBuffers absolute Buffer;
    begin
      Result := '';
      FillChar(Buffer, SizeOf(Buffer), #0);
      with sptwb.spt do
      begin
        Length := SizeOf(TScsiPassThrough);
        CdbLength := 6; // CDB6GENERIC_LENGTH
        SenseInfoLength := 24;
        DataIn := 1; // SCSI_IOCTL_DATA_IN
        DataTransferLength := 192;
        TimeOutValue := 2;
        DataBufferOffset := PChar(@sptwb.bDataBuf) - PChar(@sptwb);
        SenseInfoOffset := PChar(@sptwb.bSenseBuf) - PChar(@sptwb);
        Cdb[0] := $12; // OperationCode := SCSIOP_INQUIRY;
        Cdb[1] := $01; // Flags := CDB_INQUIRY_EVPD;  Vital product data
        Cdb[2] := $80; // PageCode            Unit serial number
        Cdb[4] := 192; // AllocationLength
      end;
      len := sptwb.spt.DataBufferOffset + sptwb.spt.DataTransferLength;
      if DeviceIoControl(DeviceHandle, $0004D004, @sptwb, SizeOf(TScsiPassThrough),
        @sptwb, len, dwReturned, nil)
        and ((PChar(@sptwb.bDataBuf) + 1)^ = #$80) then
        SetString(Result, PChar(@sptwb.bDataBuf) + 4,
          Ord((PChar(@sptwb.bDataBuf) + 3)^));
    end;
     
    /=============================================================
    var
      hDevice: THandle = 0;
      sSerNum, sDeviceName: string;
     
    begin
      sDeviceName := ParamStr(1);
      if sDeviceName = '' then
      begin
        WriteLn;
        WriteLn('Display SCSI-2 device serial number.');
        WriteLn;
        WriteLn('Using:');
        WriteLn;
        if Win32Platform = VER_PLATFORM_WIN32_NT then // Windows NT/2000
          WriteLn('  ScsiSN PhysicalDrive0')
        else
          WriteLn('  ScsiSN C:');
        WriteLn('  ScsiSN Cdrom0');
        WriteLn('  ScsiSN Tape0');
        WriteLn;
        Exit;
      end;
      hDevice := GetDeviceHandle(sDeviceName);
      if hDevice = INVALID_HANDLE_VALUE then
        WriteLn('Error on GetDeviceHandle: ', SysErrorMessage(GetLastError))
      else
      try
        sSerNum := ScsiHddSerialNumber(hDevice);
        if sSerNum = '' then
          WriteLn('Error on DeviceIoControl: ',
            SysErrorMessageGetLastError))
    else
      WriteLn('Device ' + sDeviceName
        + ' serial number = "', sSerNum, '"');
      finally
      CloseHandle(hDevice);
    end;
    end.

For more information about SCSI commands:

ftp://ftp.t10.org/t10/drafts/scsi-1/

ftp://ftp.t10.org/t10/drafts/spc/

ftp://ftp.t10.org/t10/drafts/spc2/

