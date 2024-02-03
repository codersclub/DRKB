---
Title: Редактор диска своими руками
Date: 01.01.2005
---


Редактор диска своими руками
============================

::: {.date}
01.01.2005
:::

Версия v1.05

Многие помнят легендарный Norton DiskEditor - утилиту, дающую огромный
простор для исследовательской и прочей деятельности. И сейчас есть
множество аналогов. WinHex, например.

В этой статье я расскажу как написать свой простой редактор диска.
Нужную функциональность каждый сможет добавить сам, я покажу основы.

Для начала разберемся как происходит само чтение диска. Проще всего это
делать в Windows 2000/XP (с правами администратора, конечно). Работа с
жестким диском в этих операционных системах производится путем открытия
диска как файла с помощью функции CreateFile и указания диска или
раздела по схеме Device Namespace
(открывается физический диск - `\\.\\PHYSICALDRIVE<n>`),
полученный хэндл в дальнейшем
используется для работы с диском с помощью функций ReadFile, WriteFile и
DeviceIoControl.

      // Drive - номер диска (нумерация с нуля).
     
      hFile := CreateFile(PChar('\\.\\PhysicalDrive'+IntToStr(Drive)),
        GENERIC_READ, FILE_SHARE_READ or FILE_SHARE_WRITE,nil,OPEN_EXISTING,0,0);
      if hFile = INVALID_HANDLE_VALUE then Exit;

Таким образом, мы можем воспринимать физический диск как единый файл.
Второе важное, что стоит сделать - это получить информацию о геометрии
диска.

      const
        IOCTL_DISK_GET_DRIVE_GEOMETRY = $70000;
     
      type
        TDiskGeometry = packed record
          Cylinders: Int64;           // количество цилиндров
          MediaType: DWORD;           // тип носителя
          TracksPerCylinder: DWORD;   // дорожек на цилиндре
          SectorsPerTrack: DWORD;     // секторов на дорожке
          BytesPerSector: DWORD;      // байт в секторе
        end;
     
      Result := DeviceIoControl(hFile,IOCTL_DISK_GET_DRIVE_GEOMETRY,nil,0,
        @DiskGeometry,SizeOf(TDiskGeometry),junk,nil) and (junk = SizeOf(TDiskGeometry));

Функция возвращает True, если операция прошла успешно, и False в
противном случае.

Теперь уже можно приступить к определению местоположения логических
дисков на винчестере. Начать это нужно с чтения нулевого сектора
физического диска. Он содержит MBR (Master Boot Record), а также
Partition Table. Кстати, думаю, будет интересно сохранить содержимое MBR
в файл и посмотреть программу загрузки каким-нибудь дизасмом. Но в
данный момент нас интересует только Partition Table.

Эта таблица располагается в секторе по смещению $1be и состоит из
четырех одинаковых элементов, каждый из которых описывает один раздел:

      TPartitionTableEntry = packed record
        BootIndicator: Byte;          // $80, если активный (загрузочный) раздел
        StartingHead: Byte;
        StartingCylAndSect: Word;
        SystemIndicator: Byte;
        EndingHead: Byte;
        EndingCylAndSect: Word;
        StartingSector: DWORD;        // начальный сектор
        NumberOfSects: DWORD;         // количество секторов
      end;

Соответственно, саму Partition Table можно представить как массив:

TPartitionTable = packed array [0..3] of TPartitionTableEntry;

Подробнее остановлюсь на этой структуре. Как видно из описания структур,
Partition Table может содержать только четыре раздела. А так как,
возможно, пользователю необходимо большее количество, было введено
понятие "Extended Partition" (таким образом, разделы бывают Primary и
Extended). Extended Partition - это раздел, который имеет свою
собственную Partition Table (и, соответственно может содержать в себе
еще четыре раздела). Extended Partition содержит логические диски. Тип
раздела определяется полем SystemIndicator. Оно содержит информацию о
файловой системе логического диска, либо 5 (или $f), если это Extended
Partition.

Примеры значений поля SystemIndicator:

01 - FAT12

04 - FAT16

05 - EXTENDED   

06 - FAT16   

07 - NTFS

0B - FAT32

0F - EXTENDED

Теперь можно приступить к разбору структуры логических дисков. Сейчас
уже нам пригодится функция ReadSectors.

      // так как диск для нас - это единый файл, то для перемещения по нему
      // с помощью SetFilePointer понадобится 64хразрядная арифметика
     
      function __Mul(a,b: DWORD; var HiDWORD: DWORD): DWORD; // Result = LoDWORD
      asm
        mul edx
        mov [ecx],edx
      end;
     
      function ReadSectors(DriveNumber: Byte; StartingSector, SectorCount: DWORD;
        Buffer: Pointer; BytesPerSector: DWORD = 512): DWORD;
      var
        hFile: THandle;
        br,TmpLo,TmpHi: DWORD;
      begin
        Result := 0;
        hFile := CreateFile(PChar('\\.\PhysicalDrive'+IntToStr(DriveNumber)),
          GENERIC_READ,FILE_SHARE_READ,nil,OPEN_EXISTING,FILE_ATTRIBUTE_NORMAL,0);
        if hFile = INVALID_HANDLE_VALUE then Exit;
        TmpLo := __Mul(StartingSector,BytesPerSector,TmpHi);
        if SetFilePointer(hFile,TmpLo,@TmpHi,FILE_BEGIN) = TmpLo then
        begin
          SectorCount := SectorCount*BytesPerSector;
          if ReadFile(hFile,Buffer^,SectorCount,br,nil) then Result := br;
        end;
        CloseHandle(hFile);
      end;

И, заодно, функция для записи:

      function WriteSectors(DriveNumber: Byte; StartingSector, SectorCount: DWORD;
        Buffer: Pointer; BytesPerSector: DWORD = 512): DWORD;
      var
        hFile: THandle;
        bw,TmpLo,TmpHi: DWORD;
      begin
        Result := 0;
        hFile := CreateFile(PChar('\\.\PhysicalDrive'+IntToStr(DriveNumber)),
          GENERIC_WRITE,FILE_SHARE_READ,nil,OPEN_EXISTING,FILE_ATTRIBUTE_NORMAL,0);
        if hFile = INVALID_HANDLE_VALUE then Exit;
        TmpLo := __Mul(StartingSector,BytesPerSector,TmpHi);
        if SetFilePointer(hFile,TmpLo,@TmpHi,FILE_BEGIN) = TmpLo then
        begin
          SectorCount := SectorCount*BytesPerSector;
          if WriteFile(hFile,Buffer^,SectorCount,bw,nil) then Result := bw;
        end;
        CloseHandle(hFile);
      end;

Функции возвращает количество прочитаных (или записаных) байт. Для
хранения информации о разделах объявим дополнительную структуру:

      PDriveInfo = ^TDriveInfo;
      TDriveInfo = record
        PartitionTable: TPartitionTable;
        LogicalDrives: array [0..3] of PDriveInfo;
      end;

Ну а теперь сам код разбора структуры диска:

      const
        PartitionTableOffset = $1be;
        ExtendedPartitions = [5,$f];
     
      var
        MainExPartOffset: DWORD = 0;
     
      function GetDriveInfo(DriveNumber: Byte; DriveInfo: PDriveInfo;
        StartingSector: DWORD; BytesPerSector: DWORD = 512): Boolean;
      var
        buf: array of Byte;
        CurExPartOffset: DWORD;
        i: Integer;
      begin
        SetLength(buf,BytesPerSector);
        // читаем сектор в буфер
        if ReadSectors(DriveNumber,MainExPartOffset+StartingSector,1,@buf[0]) = 0 then
        begin
          Result := False;
          Exit;
        end;
        // заполняем структуру DriveInfo.PartitionTable
        Move(buf[PartitionTableOffset],DriveInfo.PartitionTable,SizeOf(TPartitionTable));
        Finalize(buf); // буфер больше не нужен
     
        Result := True;
        for i := 0 to 3 do // для каждой записи в Partition Table
          if DriveInfo.PartitionTable[i].SystemIndicator in ExtendedPartitions then
          begin
            New(DriveInfo.LogicalDrives[I]);
            if MainExPartOffset = 0 then
            begin
              MainExPartOffset := DriveInfo.PartitionTable[I].StartingSector;
              CurExPartOffset := 0;
            end else CurExPartOffset := DriveInfo.PartitionTable[I].StartingSector;
            Result := Result and GetDriveInfo(DriveNumber,DriveInfo.LogicalDrives[I],
              CurExPartOffset);
          end else DriveInfo.LogicalDrives[I] := nil;
      end;

Функция заполняет структуру DriveInfo и возвращает True, если операция
прошла успешно, или False в противном случае.

Теперь у нас есть такая полезная информация о разделах как начальный
сектор, общее количество секторов, а также файловая система.

В нулевом секторе каждого основного раздела находится BIOS Parameter
Block, содержаший такую информацию как название файловой системы,
количество секторов в кластере и т.д. А также программа-загрузчик
(сохраняем сектор в файл и смотрим дизасмом).

Теперь, когда мы закончили с теоретической частью, можно приступить к
реализации редактора.

С чтением и записью информации мы уже разобрались. Теперь займемся ее
отображением. Отображать содержимое выбранного сектора удобнее всего в
компоненте TStringGrid.

Так как TStringGrid отображает в своих ячейках текст, а мы имеем в
буфере двоичные данные, нам понадобятся функции для преобразования.

К счастью, в Delphi они уже есть (IntToHex и StrToInt) и остается их
только правильно использовать. StrToInt можно использовать для
преобразования строки, содержащей шестнадцатиричное число в Integer,
если дописать впереди символ $.

Например, StrToInt(\'$FF\');

Полный код программы, демонстирующей описанное в статье прилагается.
Программа умеет показывать структуру логических дисков, выводить на
экран содержимое указанного сектора, а также позволяет сохранять дамп
выделенного сектора в файл. Реализация возможности редактирования диска
в программе особого труда не составит.

P.S.

Для получения доступа к физическому диску мы открывали устройство
`\\.\\PHYSICALDRIVE<n>`, далее разбирали его структуру. Можно было
поступить проще - открывать сразу логические диски
(`\\.\\C:,\\.\\D:` и т.д.), но при таком варианте мы бы упустили из виду некоторые области
диска, такие как, MBR и неразмеченные области. Какой вариант
предпочтительнее, зависит от задачи.

(с) 2005, Kerk

При перепечатке ссылка на сайт http://kladovka.net.ru обязательна.
