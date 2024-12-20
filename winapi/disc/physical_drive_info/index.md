---
Title: Информация о физических дисках
---


Информация о физических дисках
==============================

Вариант 1:

Author: AntonSaburov

Date: 30.12.2002

Source: Vingrad.ru <https://forum.vingrad.ru>

Посмотри функцию DeviceIoControl - может там что получиться. Я ее мало
использовал, но что-то там было.

Там есть ссылка на CreateFile - эта функция под NT может действительно
вернуть хэндл на физический диск.

> You can use the CreateFile function to open a disk drive or a partition
> on a disk drive. The function returns a handle to the disk device; that
> handle can be used with the DeviceIOControl function.

------------------------------------------------------------------------

Вариант 2:

Author: Alex Konshin, akonshin@earthlink.net

    { **** UBPFD *********** by delphibase.endimus.com ****
      >> Получение серийного номера IDE диска.

    Функция получает серийный номер первого физического диска IDE (не
    серийный номер тома!).

    Используется S.M.A.R.T. API, а под Windows NT/2K/XP запрос производится
    не напрямую к диску, а через miniport драйвер контроллера, что позволяет
    читать серийный номер не имея прав администратора.

    Функция может не работать, если первый контролер в системе не ATA или
    если первое устройство не является винчестером, который поддерживает
    SMART (современные винчестеры поддерживают).

    Если Вы хотите получить другие параметры диска/других дисков, то
    смотрите пример IdeInfo2 с моего сайта.

    На Windows 9x требует наличия драйвера smartvsd.vxd (должен быть в
    стандартной поставке), просто скопируйте его в
    \windows\system\iosubsys и перезагрузите компьютер.

    Зависимости: Windows, SysUtils

    Автор:       Alex Konshin, akonshin@earthlink.net, Boston, USA
    Copyright:   http://home.earthlink.net/\~akonshin/index.htm
    Дата:        30 декабря 2002 г.
    }
         
    function GetIdeDiskSerialNumber : String;
    type
      TSrbIoControl = packed record
        HeaderLength : ULONG;
        Signature : Array[0..7] of Char;
        Timeout : ULONG;
        ControlCode : ULONG;
        ReturnCode : ULONG;
        Length : ULONG;
      end;
      SRB_IO_CONTROL = TSrbIoControl;
      PSrbIoControl = ^TSrbIoControl;
     
      TIDERegs = packed record
        bFeaturesReg : Byte; // Used for specifying SMART "commands".
        bSectorCountReg : Byte; // IDE sector count register
        bSectorNumberReg : Byte; // IDE sector number register
        bCylLowReg : Byte; // IDE low order cylinder value
        bCylHighReg : Byte; // IDE high order cylinder value
        bDriveHeadReg : Byte; // IDE drive/head register
        bCommandReg : Byte; // Actual IDE command.
        bReserved : Byte; // reserved for future use. Must be zero.
      end;
      IDEREGS = TIDERegs;
      PIDERegs = ^TIDERegs;
     
      TSendCmdInParams = packed record
        cBufferSize : DWORD; // Buffer size in bytes
        irDriveRegs : TIDERegs; // Structure with drive register values.
        bDriveNumber : Byte; // Physical drive number to send command to (0,1,2,3).
        bReserved : Array[0..2] of Byte; // Reserved for future expansion.
        dwReserved : Array[0..3] of DWORD; // For future use.
        bBuffer : Array[0..0] of Byte; // Input buffer.
      end;
      SENDCMDINPARAMS = TSendCmdInParams;
      PSendCmdInParams = ^TSendCmdInParams;
     
      TIdSector = packed record
        wGenConfig : Word;
        wNumCyls : Word;
        wReserved : Word;
        wNumHeads : Word;
        wBytesPerTrack : Word;
        wBytesPerSector : Word;
        wSectorsPerTrack : Word;
        wVendorUnique : Array[0..2] of Word;
        sSerialNumber : Array[0..19] of Char;
        wBufferType : Word;
        wBufferSize : Word;
        wECCSize : Word;
        sFirmwareRev : Array[0..7] of Char;
        sModelNumber : Array[0..39] of Char;
        wMoreVendorUnique : Word;
        wDoubleWordIO : Word;
        wCapabilities : Word;
        wReserved1 : Word;
        wPIOTiming : Word;
        wDMATiming : Word;
        wBS : Word;
        wNumCurrentCyls : Word;
        wNumCurrentHeads : Word;
        wNumCurrentSectorsPerTrack : Word;
        ulCurrentSectorCapacity : ULONG;
        wMultSectorStuff : Word;
        ulTotalAddressableSectors : ULONG;
        wSingleWordDMA : Word;
        wMultiWordDMA : Word;
        bReserved : Array[0..127] of Byte;
      end;
      PIdSector = ^TIdSector;
     
    const
      IDE_ID_FUNCTION = $EC;
      IDENTIFY_BUFFER_SIZE = 512;
      DFP_RECEIVE_DRIVE_DATA = $0007c088;
      IOCTL_SCSI_MINIPORT = $0004d008;
      IOCTL_SCSI_MINIPORT_IDENTIFY = $001b0501;
      DataSize = sizeof(TSendCmdInParams)-1+IDENTIFY_BUFFER_SIZE;
      BufferSize = SizeOf(SRB_IO_CONTROL)+DataSize;
      W9xBufferSize = IDENTIFY_BUFFER_SIZE+16;
    var
      hDevice : THandle;
      cbBytesReturned : DWORD;
      pInData : PSendCmdInParams;
      pOutData : Pointer; // PSendCmdInParams;
      Buffer : Array[0..BufferSize-1] of Byte;
      srbControl : TSrbIoControl absolute Buffer;
     
      procedure ChangeByteOrder( var Data; Size : Integer );
      var ptr : PChar;
          i : Integer;
          c : Char;
      begin
        ptr := @Data;
        for i := 0 to (Size shr 1)-1 do
        begin
          c := ptr^;
          ptr^ := (ptr+1)^;
          (ptr+1)^ := c;
          Inc(ptr,2);
        end;
      end;
     
    begin
      Result := '';
      FillChar(Buffer,BufferSize,#0);
      if Win32Platform=VER_PLATFORM_WIN32_NT then
        begin // Windows NT, Windows 2000
          // Get SCSI port handle
          hDevice := CreateFile( '\\.\Scsi0:', GENERIC_READ or GENERIC_WRITE,
            FILE_SHARE_READ or FILE_SHARE_WRITE, nil, OPEN_EXISTING, 0, 0 );
          if hDevice=INVALID_HANDLE_VALUE then Exit;
          try
            srbControl.HeaderLength := SizeOf(SRB_IO_CONTROL);
            System.Move('SCSIDISK',srbControl.Signature,8);
            srbControl.Timeout := 2;
            srbControl.Length := DataSize;
            srbControl.ControlCode := IOCTL_SCSI_MINIPORT_IDENTIFY;
            pInData := PSendCmdInParams(PChar(@Buffer)+SizeOf(SRB_IO_CONTROL));
            pOutData := pInData;
            with pInData^ do
            begin
              cBufferSize := IDENTIFY_BUFFER_SIZE;
              bDriveNumber := 0;
              with irDriveRegs do
              begin
                bFeaturesReg := 0;
                bSectorCountReg := 1;
                bSectorNumberReg := 1;
                bCylLowReg := 0;
                bCylHighReg := 0;
                bDriveHeadReg := $A0;
                bCommandReg := IDE_ID_FUNCTION;
              end;
            end;
            if not DeviceIoControl( hDevice, IOCTL_SCSI_MINIPORT, @Buffer,
              BufferSize, @Buffer, BufferSize, cbBytesReturned, nil ) then Exit;
          finally
            CloseHandle(hDevice);
          end;
        end
      else
        begin // Windows 95 OSR2, Windows 98
          hDevice := CreateFile( '\\.\SMARTVSD', 0, 0, nil, CREATE_NEW, 0, 0 );
          if hDevice=INVALID_HANDLE_VALUE then Exit;
          try
            pInData := PSendCmdInParams(@Buffer);
            pOutData := PChar(@pInData^.bBuffer);
            with pInData^ do
            begin
              cBufferSize := IDENTIFY_BUFFER_SIZE;
              bDriveNumber := 0;
              with irDriveRegs do
              begin
                bFeaturesReg := 0;
                bSectorCountReg := 1;
                bSectorNumberReg := 1;
                bCylLowReg := 0;
                bCylHighReg := 0;
                bDriveHeadReg := $A0;
                bCommandReg := IDE_ID_FUNCTION;
              end;
            end;
            if not DeviceIoControl( hDevice, DFP_RECEIVE_DRIVE_DATA, pInData, 
               SizeOf(TSendCmdInParams)-1, pOutData, W9xBufferSize,
               cbBytesReturned, nil ) then Exit;
          finally
            CloseHandle(hDevice);
          end;
        end;
        with PIdSector(PChar(pOutData)+16)^ do
        begin
          ChangeByteOrder(sSerialNumber,SizeOf(sSerialNumber));
          SetString(Result,sSerialNumber,SizeOf(sSerialNumber));
        end;
    end;

Пример использования:

    var s : String;
        rc : DWORD;
    begin
      s := GetIdeDiskSerialNumber;
      if s='' then
        begin
          rc := GetLastError;
          if rc=0 then WriteLn('IDE drive is not support SMART feature')
          else WriteLn(SysErrorMessage(rc));
        end
      else WriteLn('Disk serial number: ''', s,'''');
    end. 

