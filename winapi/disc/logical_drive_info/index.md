---
Title: Информация о логических дисках
Author: Serious
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Информация о логических дисках
==============================

Теперь об информации о дисках:

исчерпывающую информацию по этому поводу дает функция
GetVolumeInformation,

посмотри help, там все понятно (там и серийный номер диска, и тип
файловой системы, и прочее и прочее).

Вот параметры FileSysFlags:

- FS\_CASE\_IS\_PRESERVED - (при записи на диск сохраняется регистр букв в его имени)
- FS\_CASE\_SENSITIVE - (поддерживается поиск файлов с учетом регистра букв)
- FS\_UNICODE\_STORED\_ON\_DISK - (поддерживается сохранение имен файлов в UniCode)
- FS\_PERSISTENT\_ACLS - (поддерживаются списки контроля доступа (ACL). Только для NTFS)
- FS\_FILE\_COMPRESSION - (поддерживается сжатие файлов на уровне системы)
- FS\_VOL\_IS\_COMPRESSED - (устройство представляет собой сжатый диск)

Определение типа диска:

    function GetDriveType (Drive : byte) : string;
      var
        DriveLetter : Char;
        DriveType : uInt;
    begin
    DriveLetter := Char (Drive + $41);
    DriveType := GetDriveType (PChar(DriveLetter + ':\'));
    case DriveType of
    0: Result := '?';
    1: Result := 'Path does not exists';
    Drive_Removable: Result := 'Removable';
    Drive_Fixed: Result := 'Fixed';
    Drive_Remote: Result := 'Remote';
    Drive_CDROM: Result := 'CD-ROM';
    Drive_RamDisk: Result := 'RAMDisk'
    else Result := 'Unknown';
    end;
    end;

Может так попробовать:

    procedure TMainForm.btnGetHandleClick(Sender: TObject);
    var DriveHandle : HWND;
    begin
      case Win32Platform of
        VER_PLATFORM_WIN32_NT:
          begin
            DriveHandle := CreateFile ('\\.\Scsi0:', GENERIC_READ+GENERIC_WRITE,
                                      FILE_SHARE_READ+FILE_SHARE_WRITE, nil, 
                                      OPEN_EXISTING, 0, 0);
            if DriveHandle <> INVALID_HANDLE_VALUE then
              MessageBox (MainForm.Handle, PChar(IntToStr(DriveHandle)),
                         PChar('Here is your handle:'), MB_ICONINFORMATION)
            else
               MessageBox (MainForm.Handle, PChar('Error!'), PChar('Error'), 
                           MB_ICONERROR);
          end;
        VER_PLATFORM_WIN32_WINDOWS:
          begin
            DriveHandle := CreateFile ('\\.\SMARTVSD', 0, 0, nil, CREATE_NEW, 0, 0 );
            if DriveHandle <> INVALID_HANDLE_VALUE then
              MessageBox (MainForm.Handle, PChar(IntToStr(DriveHandle)), 
                          PChar('Here is your handle:'), MB_ICONINFORMATION)
            else
              MessageBox (MainForm.Handle, PChar('Error!'), PChar('Error'), MB_ICONERROR);
          end;
      end; // case
    end;

