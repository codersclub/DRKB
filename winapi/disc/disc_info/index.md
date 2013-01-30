---
Title: Информация о дисках
Date: 01.01.2007
---


Информация о дисках
===================

::: {.date}
01.01.2007
:::

Часть информации о диске можно получить при помощи функции
GetVolumeInformation. Она позволяет узнать метку, тип файловой системы,
серийный номер, максимальную длину имен файлов, а также несколько
параметров, связанных с регистром букв в именах файлов, сжатием
информации и др.

Для определения типа диска используется функция GetDriveType. Для
определения объема диска и свободного пространства - GetDiskFreeSpaceEx.
Для определения размера кластера и сектора можно использовать
GetDiskFreeSpace. Здесь это не используется.

    procedure TForm1.Button1Click(Sender: TObject);
    const
      Flags: array [0..5] of cardinal = (
        FS_CASE_IS_PRESERVED,
        FS_CASE_SENSITIVE,
        FS_UNICODE_STORED_ON_DISK,
        FS_PERSISTENT_ACLS,
        FS_FILE_COMPRESSION,
        FS_VOL_IS_COMPRESSED);
     
    var
      c: char;
      s: string;
      li: TListItem;
      DriveType: integer;
      bufLabel, bufFileSystem: array [0..1027] of char;
      SerialNumber, MaxFileNameLength, FileSystemFlags: cardinal;
      i: integer;
      freeavalilable, totalspace, totalfree: int64;
     
      procedure AddSpace(value: int64);
      const onfiltered= 1024; onfiltered= 1024 * OneKB; onfiltered= 1024 * OneMB;
      var
        b, kb, mb, gb: integer;
        v: int64;
        s: string;
      begin
        gb := value div OneGb;
        v := value mod OneGb;
        mb := v div OneMb;
        v := v mod OneMb;
        kb := v div OneKb;
        b := v mod OneKb;
        if gb > 0
          then s := IntToStr(gb) + ' gb'
          else s := '';
        if mb > 0 then s := s + ' ' + IntToStr(mb) + ' mb';
        if kb > 0 then s := s + ' ' + IntToStr(kb) + ' kb';
        if b > 0 then s := s + ' ' + IntToStr(b) + ' b';
        if s = '' then s := '0';
        li.SubItems.Add(s);
      end;
     
    begin
      ListView1.Items.BeginUpdate;
      ListView1.Items.Clear;
     
      for c := 'A' to 'Z' do begin
        s := c + ':';
        DriveType := GetDriveType(PChar(s));
        if DriveType = 1 then continue;
     
        li := ListView1.Items.Add;
        li.Caption := s;
        case DriveType of
          0: li.SubItems.Add('unknown');
          DRIVE_REMOVABLE: li.SubItems.Add('removable');
          DRIVE_FIXED: li.SubItems.Add('fixed');
          DRIVE_REMOTE: li.SubItems.Add('remote');
          DRIVE_CDROM: li.SubItems.Add('cdrom');
          DRIVE_RAMDISK: li.SubItems.Add('ramdisk');
        end;
        if not GetVolumeInformation(PChar(s), bufLabel, sizeof(bufLabel),
          addr(SerialNumber), MaxFileNameLength, FileSystemFlags,
          bufFileSystem, sizeof(bufFileSystem)) then continue;
        li.SubItems.Add(bufLabel);
        li.SubItems.Add(bufFileSystem);
        li.SubItems.Add(IntToStr(SerialNumber));
        li.SubItems.Add(IntToStr(MaxFileNameLength));
     
        for i := low(flags) to high(flags) do
          if (FileSystemFlags and flags[i]) <> 0
            then li.SubItems.Add('yes')
            else li.SubItems.Add('no');
     
        GetDiskFreeSpaceEx(PChar(s), freeavalilable, totalspace, @totalfree);
        AddSpace(freeavalilable);
        AddSpace(totalspace);
        AddSpace(totalfree);
      end;
      ListView1.Items.EndUpdate;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    const
      FlagStrs: array [0..5] of string = (
        'Case preserved',
        'Case sensitive',
        'Unicode',
        'Preserve ACLs',
        'File Compression',
        'Volume Compression');
     
      procedure AddColumn(caption: string);
      var
        lc: TListColumn;
      begin
        lc := ListView1.Columns.Add;
        lc.Caption := caption;
        lc.Width := ColumnHeaderWidth;
      end;
     
    var
      i: integer;
    begin
      ListView1.ViewStyle := vsReport;
      AddColumn('root');
      AddColumn('type');
      AddColumn('label');
      AddColumn('file system');
      AddColumn('Serial Number');
      AddColumn('MaxFileNameLen');
      for i := low(FlagStrs) to high(FlagStrs) do
        AddColumn(FlagStrs[i]);
      AddColumn('FreeAvalilable');
      AddColumn('TotalSpace');
      AddColumn('TotalFree');
      Button1.Click;
    end;
