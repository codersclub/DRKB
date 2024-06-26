---
Title: Модуль для работы с дисковыми драйверами (на уровне FAT)
Author: NikNet (NikNet@Yandex.ru)
Date: 01.01.2007
---


Модуль для работы с дисковыми драйверами (на уровне FAT)
========================================================

Архитектура файловой системы FAT фирмы Microsoft:

![](fat.gif)

 
    {
                       FAT/FAT16/FAT32

            Модуль для работы с дисковыми драйверами
    
                     Автор  : NikNet
                     E-MAIL : NikNet@Yandex.ru
                     Сайт   : NikNet.narod.ru [Скоро будет :)]
                            2006г
                   Версия 4.00 (Win9x/NT)
    }
    unit uFAT;
     
    Interface
     
    Uses Windows,SysUtils,DISK,CLASSES;
    TYPE
    {----------- Структура загрузочного сектора для FAT12 и FAT16 ---------------}
     PBoot  = ^TBoot;
     TBoot           {                                                             }= packed record
      bsJmpBoot      { Переход на код загрузки                                     }: array[1..3] of byte;
      bsOemname      { Имя пройзводителя                                           }: array[1..8] of char;
      bsBytePerSec   { Число байт в секторе                                        }: word;
      bsSecPerClus   { Число секторов в сластере                                   }: byte;
      bsRsvdSecCnt   { Начала FAT1 в секторах                                      }: word;
      bsNumFATs      { Число копий FAT                                             }: byte;
      bsRootEntCnt   { Количество элементов в корне                                }: word;
      bsToolSec12    { Общее количество секторов на диске                          }: word;
      bsMedia        { Тип носителя                                                }: byte;
      bsFATSz16      { Количество в одной  FAT                                     }: word;
      bsSecPerTrk    { Число секторов на одной дорожки                             }: word;
      bsNumHeads     { Число головок на одной дорожки                              }: word;
      bsNumHideSec   { Количество "скрытых" секторов                               }: LongInt;
      bsToolSec16    { Общее количество секторов на диске                          }: LongInt;
      bsDrvNum       { Номер дискавода                                             }: byte;
      bsReserved1    { Резервировано для WinNT                                     }: byte;
      bsBootSig      { Признак расширеной загрузочной записи (24h)                 }: byte;
      bsVolID        { Серийны номер диска                                         }: LongInt;
      bsVolLab       { Метка тома диска                                            }: array[1..11] of char;
      bsFSType       { Тип файловой системы                                        }: array[1..8]  of char;
      bsBoot         { Загрузочный код                                             }: array[1..448]of Byte;
      bsTrailSig     { Сигнатура AA55h                                             }: array[1..2] of char;
      end;
     
    {--------------- Структура загрузочного сектора для FAT32 -------------------}
     PBoot32 = ^TBoot32;
     TBoot32         {                                                             }=  packed record
      bsJmpBoot      { Переход на код загрузки                                     }: array[1..3] of byte;
      bsOemname      { Имя пройзводителя                                           }: array[1..8] of char;
      bsBytePerSec   { Число байт в секторе                                        }: word;
      bsSecPerClus   { Число секторов в сластере                                   }: byte;
      bsRsvdSecCnt   { Начала FAT1 в секторах                                      }: word;
      bsNumFATs      { Число копий FAT                                             }: byte;
      bsRootEntCnt   { Количество элементов в корне                                }: word;
      bsToolSec16    { Зарезервировано                                             }: word;
      bsMedia        { Тип носителя                                                }: byte;
      bsFATz16       { Зарезервировано                                             }: word;
      bsSecPerTrk    { Число секторов на одной дорожки                             }: word;
      bsNumHeads     { Число головок на одной дорожки                              }: word;
      bsHiddSec      { Число скрытых секторов                                      }: Longint;
      bsTolSec32     { Общее количество секторов на диске                          }: LongInt;
      bsFATSz32      { Количество сектаров для одной FAT                           }: LongInt;
      bsExtFlags     { Номер активой FAT                                           }: word;
      bsFSVer        { Номер версии: старший байт номер версии,младши номер ревизи }: word;
      bsRootClus     { Первый кластер обычно имеет номер 2                         }: LongInt;
      bsFSInfo       { Номер сектора структуры FSINFO                              }: word;
      bsBkBootSec    { Номер BootSector(Копия) обычно имеет номер 2                }: word;
      bsReserved     { Облость резервированная                                     }: array[1..12] of byte;
      bsDrvNum       { Номер дискавода                                             }: byte;
      bsReserved1    { Резервировано для WinNT                                     }: byte;
      bsBootSig      { Признак расширеной загрузочной записи (24h)                 }: byte;
      bsVolID        { Серийны номер диска                                         }: LongInt;
      bsVolLab       { Метка тома диска                                            }: array[1..11] of char;
      bsFSType       { Тип файловой системы                                        }: array[1..8]  of char;
      bsBoot         { Загрузочный код                                             }: array[1..420]of byte;
      bsTrailSig     { Сигнатура AA55h                                             }: array[1..2] of char;
      end;
     
    {-------------------------> Типы носителей информации <------------------------}const
     MediaType       {                                                             }:array[1..7] of byte= (
      $F0            { Гибкий диск, 2 стороны, 18 секторов на дорожке              },
      $F8            { Жесткий диск                                                },
      $F9            { Гибкий диск, 2 стороны, 15 секторов на дорожке              },
      $FC            { Гибкий диск, 1 стороны, 09 секторов на дорожке              },
      $FD            { Гибкий диск, 2 стороны, 09 секторов на дорожке              },
      $FE            { Гибкий диск, 1 стороны, 08 секторов на дорожке              },
      $FF            {  Гибкий диск, 2 стороны, 08 секторов на дорожке             }  );
     
    {----- Структура сектора FSInfo и резервного загрузочного сектора FAT32 -----}Type
     PFsInfo = ^TFsInfo;
     TFsInfo         {                                                             }= Record
      fsLeadSig      { Сигнатура 41615252h                                         }:LongInt;
      fsReserved1    { Зарезервировано                                             }:array[1..480] of byte;
      fsStrucSig     { Сигнатура 61417272h                                         }:LongInt;
      fsFree_Count   { Количество свободных кластеров                              }:LongInt;
      fsNxt_Free     { Обычно номер 2                                              }:LongInt;
      fsReserved2    { Зарезервировано                                             }:array[1..12] of byte;
      fsTrailSig     { Сигнатура AA550000h                                         }:array[1..4] of byte;
      end;
    {------------ Вид начальных фрагментов для FAT различных типов --------------}{
     
      Байт   00 01 02 03 04 05 06 07 08 09 10 11 12 13 14 15 16 17 18 19 20 21 22 23
      FS12 - FF 8F FF 00 30 04 00 5F FF 00 7F FF FF F0 0A 00 BF FF 00 D0 0E FF FF FF
      FS16 - FF F8 FF FF 00 03 00 04 00 05 FF FF 00 07 FF FF FF FF 00 0A 00 0B FF FF
      FS32 - 0F FF FF F8 0F FF FF FF 00 00 00 03 00 00 00 04 00 00 00 05 0F FF FF FF
     
              Резервные файлы                                          Конечный
                                                                        кластер
                                                                        файла
     
    {---------------- Значения специальных кодов элементов FAT ------------------}{
     
          Значение кода               FAT12      FAT16          FAT32
          Свободный кластер           0          0              0
          Дефектный кластер           $FF7       $FFF7         $FFFFFF7
          Последний кластер в списке  $FF8-$FFF $FFF8-$FFFF $FFFFFF8-$FFFFFFF}
     
    const
      FAT_Available    = 0;
      FAT_Reserved_Min = $FFFFFFF0;
      FAT_Reserved_Max = $FFFFFFF6;
      FAT_BAD          = $FFFFFFF7;
      FAT_EOF_Min      = $FFFFFFF8;
      FAT_EOF_Max      = $FFFFFFFF;
     
      FAT_MASK_12      = $FFF;
      FAT_MASK_16      = $FFFF;
      FAT_MASK_32      = $FFFFFFF;
     
    const
      ATTR_ARCHIVE     = $20;  // Архивный
      ATTR_DIRECTORY   = $10;  // Директория
      ATTR_VOLUME      = $08;  // Метка тома
      ATTR_SYSTEM      = $04;  // Системный
      ATTR_HIDDEN      = $02;  // Скрытый
      ATTR_READONLY    = $01;  // Только для чтение
     
    TYPE
    {----------------------- Структура элемента каталога ------------------------}
        PDIRENTRY = ^TDIRENTRY;
        TDIRENTRY = record
          Name         { Имя файла или директори                                     }:array[1..8] of char;
          EXT          { Расширение файла                                            }:array[1..3] of char;
          Attr         { Атрибуты файла                                              }:BYTE;
          NTRes        { Поле зарезервировано для WinNT должно содержать 0           }:BYTE;
          CrtTimeTenth { Поле, уточняющее время создание файла в милисикундах        }:BYTE;
          CrtTime      { Время создание файла                                        }:WORD;
          CrtDate      { Дата создание файла                                         }:WORD;
          LstAccDate   { Дата последнего обращения к файлу для I/O данных            }:WORD;
          FSIClasHi    { Старшее слово номера первого кластера файла                 }:WORD;
          WrtTime      { Время выпонения последней операции записи в файл            }:WORD;
          WrtDate      { Дата выпонения последней операции записи в файл             }:WORD;
          FSIClasLo    { Младшее слово номера первого кластера файла                 }:WORD;
          Size         { Размер файла в байтах (   32-разрядное  число   )           }:LONGINT;
        end;
     
    {--- Структура элемента каталога, хранящего фрагмент длинного имени файла ---}
        PLONGDIRENTRY = ^TLONGDIRENTRY;
        TLONGDIRENTRY = record
          Counter      { Номер фрагмента                                             }:Byte;
          LFN1         { Первый участок фрагмента имени                              }:array[1..5]of Wchar;
          Attr         { Атрибуты файла                                              }:BYTE;
          Flags        { Байт флагов                                                 }:BYTE;
          ChkSum       { Контроляная сумма << короткого имени >>                     }:BYTE;
          LFN2         { Второй участок фрагмента имени                              }:array[1..6]of Wchar;
          FirstClus    { Номер первого кластера ( должен быть равен 0 )              }:Word;
          LFN3         { Третий участок фрагмента имени                              }:array[1..2]of Wchar;
        end;
     
     
     
    {------------------------------------------------------------------------------}
    (******************************************************************************)
    {------------------------------------------------------------------------------}
    (******************************************************************************)
    {------------------------------------------------------------------------------}
     
     TYPE
      TFSType = (fsNone, fsFAT12, fsFAT16, fsFAT32);
      TDIR_Entry = record
          Name            : String;
          LongName        : String;
          Ext             : String;
          Attr            : Byte;
          StartCluster    : Longint;
          CreateTime      : Longint;
          CreateDate      : Longint;
          WriteLastDate   : Longint;
          WriteLastTime   : Longint;
          FileSize        : Longint;
          LastAccessDate  : Longint;
          Erased          : Boolean;
          CurrentSector   : Int64;
          StartByteNamePerSec : Integer;
        end;
      PDIR_Entry = ^TDIR_Entry;
     
     
     VAR
      PhysicalVolume    : word  = 0;              // Номер текущего Физичиского диска
      Volume            : Byte  = 0;              // Текущий логический диск
      VolumeSerial      : DWord = 0;              // Серийный номер тома
      BytesPerSector    : DWORD = 0;              // Количество байт в одном секторе
      LogicalSectors    : Int64 = 0;              // Количество секторов на лог. диске
     
      SectorsPerCluster : DWORD = 0;              // Количество секторов в одном кластере
      RootDirSector     : Int64 = 0;              // Начало корневого каталога
      RootDirCluster    : Int64 = 0;              // Начальный кластер корневого каталога
      RootDirEntries    : Int64 = 0;              // Количество элементов в корневом каталоге
      DataAreaSector    : Int64 = 0;              // Текущий кластер
     
      FATCount          : Byte  = 0;              // Количество копий FAT (Обычно 2)
      SectorsPerFAT     : Int64 = 0;              // Количеств секторов в одной FAT
      FATSize           : Int64 = 0;              // Размер FAT в кластерах
      FATSector         : Pointer = nil;          // Начало FAT
      FAT               : Pointer = nil;          // Буфер для файловых элементов
      ActiveFAT         : word;
      EndingCluster     : Int64 = 0;              // Последний кластер для одной FAT
     
     
      VolumeName        : array[1..11] of char;   // Метка тома
      FSName            : array [1..8] of Char;   // Название файловой системы
      FSType            : TFSType = fsNone;       // Тип файловой системы
     
     
     Function  Init         (Drive:byte):Boolean;
     Function  ReadSector  (Sector: Int64; Count: Word; Var Buffer; nSize:DWORD): Boolean;
     Function  WriteSector (Sector: Int64; Count: Word; Var Buffer; nSize:DWORD): Boolean;
     Function  GetFATCluster(FATIndex: LongInt): LongInt;
     Function  GetFATEntry  (Cluster: Int64): Longint;
     Procedure SetFATEntry  (Cluster: Int64; Value: Longint);
     
     Function  GetCluster(Sector: Int64):Int64;
     Function  ReadCluster  (Cluster: Int64; var Buffer; BufferSize: Longint): Boolean;
     Function  WriteCluster (Cluster: Int64; var Buffer; BufferSize: Longint): Boolean;
     Function  WriteClusterChain(StartCluster: Longint; Buffer: Pointer; BufferSize: Longint): Boolean;
     Function  ReadClusterChain(StartCluster: Int64; var Buffer: Pointer; var BufferSize: Longint): Boolean;
     Function  SeekForChainStart(Cluster: Int64): Longint;
     Function  ValidCluster (Cluster: Int64): Boolean;
     function  ReadDIR(Cluster: Longint; var DIR: PDIR_Entry; var Entries: Longint): Boolean;
     Procedure Done;
       // Дополнение...
     procedure ParseDOSTime (Time: Word; var Hour, Minute, Second: Word);
     procedure ParseDOSDate (Date: Word; var Day, Month, Year: Word);
     function  GetShortName (Name: String): String;
     function  FormatDiskSize (Value: TLargeInteger): string;
     function  DosToWin(St: string): string;
     
    implementation
     
     
    function ReadDIR(Cluster: Longint; var DIR: PDIR_Entry; var Entries: Longint): Boolean;
    label
        NextSector,
        LongNameComponent,
        ElementNotUsed,
        EndDIR;
     
    var P: Pointer;
        P1: PDIREntry;
        PL: PLONGDIRENTRY;
        Dir_Entry: TDIR_Entry;
        Size: Longint;
        ADIR: TMemoryStream;
        J: DWORD;
        s,s1,sTmp: String;
        L:DWORD;
        LFNErase:Boolean;
    begin
        s1:='';
       LFNErase:=False;
       Entries:=0;
       Result := False;
       if FSType = fsNone then Exit;
       if FAT = NIL then Exit;
       if FATSize = 0 then Exit;
       // Читаем ципочку кластеров в FAT пока не встретим $FFF
       Result := ReadClusterChain(Cluster, P, Size);
       // проверим нет ли ошибки с диском
       if not Result then Exit;
       // установим количество каталогов
       Size := Size div 32;
       // создаем поточный объект в памяти
       ADIR := TMemoryStream.Create;
       // P = начало каталога
       P1 := P;
     NextSector:
        s:='';
         FillChar(DIR_Entry, SizeOf(DIR_Entry), 0);
        // Проверить признак конца каталога
        if (Byte(Pointer(Longint(P1)+$00)^) = $00)  then
    //      if (Byte(Pointer(Longint(P1)+$0B)^) = $00)  then
          goto EndDir;
     
        // Проверить наличие данных в элементе каталга
         if Byte(Pointer(P1)^) = $e5 then
            DIR_Entry.Erased := True else
            DIR_Entry.Erased := False;
     
         // Обычный элемент или компонента длинного имени?
         if (Byte(Pointer(Longint(P1)+$0b)^) = $0F) then
         Begin
               Inc(Longint(P1), SizeOf(TDIRENTRY));
               Goto NextSector;
          end;
    {     if ((Byte(Pointer(P1)^) and $3F) = 37) then
         Begin
               Inc(Longint(P1), SizeOf(TDIRENTRY));
               Goto NextSector;
         end
         else
         Goto LongNameComponent;}
     
         // Проверить признак метки если "True" пропустим его...
         if Byte(Pointer(Longint(P1)+$0b)^) = ATTR_VOLUME then
         Begin
            Inc(Longint(P1), SizeOf(TDIRENTRY));
            Goto NextSector;
         end;
     
         Begin
         // Обрабатываем короткое имя
            if ((Byte(Pointer(Longint(P1)+$0b)^) and ATTR_DIRECTORY) = 0) and
            (P1^.Ext[1] <> chr($20))then
            s:=P1^.Name+'.'+P1^.Ext else
            s:=P1^.Name;
            for j:=1 to Length(s) do
              if (s[j] <> chr($20)) then
              Dir_Entry.Name:=Dir_Entry.Name+s[j];
            for j:=1 to 3 do
            Dir_Entry.Ext:=Dir_Entry.Ext+P1^.Ext[j];
            s:='';
        end;
        Goto ElementNotUsed;
     
     LongNameComponent:
            PL:=PLONGDIRENTRY(P1);
             if (PL.LFN1[1] <> WideChar(0)) and (PL.LFN1[1] <> WideChar($FFFF)) then
               For j:=1 to 5 do if (PL.LFN1[j]  <> #0) then s:=s+PL.LFN1[j];
             if (PL.LFN2[1] <> WideChar(0)) and (PL.LFN2[1] <> WideChar($FFFF)) then
               For j:=1 to 6 do if (PL.LFN2[j] <> #0) then s:=s+PL.LFN2[j];
             if (PL.LFN3[1] <> WideChar(0)) and (PL.LFN3[1] <> WideChar($FFFF)) then
               For j:=1 to 2 do if (PL.LFN3[j] <> #0) then s:=s+PL.LFN3[j];
             s1:=s+s1;
     
     
             if ((Byte(Pointer(P1)^) and $3F) <> 01) then
             Begin
               Inc(Longint(P1), SizeOf(TDIRENTRY));
               Goto NextSector;
             end;
     
           Inc(Longint(P1), SizeOf(TDIRENTRY));
            Dir_Entry.Name:=s1;
            LFNErase:=False;
           s1:='';
           s:='';
     
     ElementNotUsed:
           // Сохраним текущий сектор и смещение текущего элемента
           // Он будет нужен в будущем...
            Dir_Entry.CurrentSector:=(LongInt(P1)-LongInt(P)) div 512;
            l:=(LongInt(P1)-LongInt(P));
            l:=l-(512*Dir_Entry.CurrentSector);
            Dir_Entry.StartByteNamePerSec:=l;
            if Cluster <> 0 then
             Dir_Entry.CurrentSector:=Dir_Entry.CurrentSector+((Cluster-2)*
             SectorsPerCluster)+DataAreaSector else
             Dir_Entry.CurrentSector:=Dir_Entry.CurrentSector+RootDirSector;
            DIR_Entry.Attr := P1^.Attr;
            if  FSType = fsFAT32 then
            begin
             DIR_Entry.StartCluster  := P1^.FSIClasHi;
             DIR_Entry.StartCluster  := DIR_Entry.StartCluster shl 16;
             DIR_Entry.StartCluster  := DIR_Entry.StartCluster+P1^.FSIClasLo;
            end else
            DIR_Entry.StartCluster   := P1^.FSIClasLo;
            DIR_Entry.CreateTime     := P1^.CrtTime;
            DIR_Entry.CreateDate     := P1^.CrtDate;
            DIR_Entry.FileSize       := P1^.Size;
            DIR_Entry.LastAccessDate := P1^.LstAccDate;
            DIR_Entry.WriteLastTime := P1^.WrtTime;
            DIR_Entry.WriteLastDate := P1^.WrtDate;
     
            Inc(Longint(P1), SizeOf(TDIRENTRY));
            ADIR.Write(DIR_Entry, SizeOf(DIR_Entry));
            inc(Entries);
     Goto NextSector;
     
     EndDir:
       FreeMem(P);
       GetMem(DIR, ADIR.Size);
       ADIR.Seek(0, 0);
       ADIR.Read(DIR^, ADIR.Size);
       ADIR.Free;
       Result := True;
    end;
     
     
     
      function ReadSector  (Sector: Int64; Count: Word; Var Buffer; nSize:DWORD): Boolean;
      Var
       F:TMemoryStream;
       P:Pointer;
      Begin
       FillChar(Buffer, nSize, 0);
       Result:=False;
       if Volume = 0 Then Exit;
       F := TMemoryStream.Create;
       F.SetSize(Count*BytesPerSector);
       P:=F.Memory;
       Result:=ReadLogicalSector(Volume, Sector, Count,P^);
       F.Seek(0, 0);
       if nSize > F.Size then
       F.Read(Buffer, F.Size) else
       F.Read(Buffer, nSize);
       F.Free;
      end;
     
      function WriteSector (Sector: Int64; Count: Word; Var Buffer; nSize:DWORD): Boolean;
      Var
       F:TMemoryStream;
       P:Pointer;
      Begin
       Result:=False;
       if Volume = 0 Then Exit;
       F := TMemoryStream.Create;
       F.SetSize(Count*BytesPerSector);
       F.Seek(0, 0);
       F.Write(Buffer, F.Size);
       P := F.Memory;
       Result:=WriteLogicalSector(Volume, Sector, Count, P^);
       F.Seek(0, 0);
       if nSize > F.Size then F.Read(Buffer, F.Size)
                         else F.Read(Buffer, nSize);
       F.Free;
      end;
     
      function GetFATCluster(FATIndex: LongInt): LongInt;
      begin
         Result := 0;
         if FATCount=0 then Exit;
         if FATIndex<1 then FATIndex := 1;
         if FATIndex>FATCount then FATIndex := FATCount;
         Result := Longint(Pointer(Longint(FATSector)+(FATIndex-1)*4)^);
      end;
     
     Function Init(Drive:byte):Boolean;
      Var
        NumFreeClusters   : DWORD;   // количество свободных кластеров на диске
        TotalClusters     : DWORD;   // Количество кластеров}
      var
        P, P1, P2: Pointer;
        I, J: Longint;
        B1, B2: Byte;
        W: Word;
        L: Longint;
     Begin
     
      Result:=False;
      Volume := Drive;
      GetDiskFreeSpace(PChar(chr(drive+64)+':\'), SectorsPerCluster,BytesPerSector, NumFreeClusters, TotalClusters);
     
      GetMem(P, BytesPerSector);
      if not ReadLogicalSector(Volume,0,1,P^) then
      begin
        FreeMem(P);
        Exit;
      end;
     
      if PBoot32(P)^.bsFATz16 = 0 Then
      with PBoot32(P)^ do
      Begin
        for I := 1 to 8 do FSName[I] := bsFSType[I];
        for I := 1 to 11 do VolumeName[I] := bsVolLab[I];
        FSType            := fsFAT32;
        VolumeSerial      := bsVolID;
        PhysicalVolume    := bsDrvNum;
        LogicalSectors    := bsTolSec32;
        SectorsPerCluster := bsSecPerClus;
        BytesPerSector    := bsBytePerSec;
        FATCount          := bsNumFATs;
        GetMem(FATSector, FATCount*4);
        SectorsPerFAT     := bsFATSz32;
        I                 := bsRsvdSecCnt;
        If bsExtFlags and (1 shl 7) <> 0 Then
        ActiveFAT         := bsExtFlags and $F;
        RootDirCluster    := bsRootClus;
        DataAreaSector    := bsRsvdSecCnt + FATCount * SectorsPerFAT;
        RootDirSector     := DataAreaSector + (RootDirCluster-2) * SectorsPerCluster;
      end else
      Begin
       with PBoot(P)^ do
        Begin
        for I := 1 to 8 do FSName[I] := bsFSType[I];
        for I := 1 to 11 do VolumeName[I] := bsVolLab[I];
        if (TotalClusters > 4086) or (bsToolSec12 = 0) then
         Begin
          FSType := fsFAT16;
          LogicalSectors    := bsToolSec16;
         end else
         Begin
          FSType := fsFAT12;
          LogicalSectors    := bsToolSec12;
         end;
        VolumeSerial      := bsVolID;
        PhysicalVolume    := bsDrvNum;
        SectorsPerCluster := bsSecPerClus;
        BytesPerSector    := bsBytePerSec;
        FATCount          := bsNumFATs;
        GetMem(FATSector, FATCount*4);
        SectorsPerFAT     := bsFATSz16;
        I                 := bsRsvdSecCnt;
        ActiveFAT         := 0;
        RootDirEntries    := bsRootEntCnt;
        RootDirSector     := bsRsvdSecCnt+SectorsPerFAT*FATCount;
        RootDirCluster    := 0;
        DataAreaSector    := RootDirSector+((RootDirEntries*32+BytesPerSector-1) div BytesPerSector);
        end;
      end;
        // Заполняем адреса файловых структур 1/2
        // в FATSector
        Longint(FATSector^) := I;
        P1 := FATSector;
        Inc(Longint(P1), 4);
        if FATCount>1 then
        for J := 2 to FATCount do
        begin
          I := I+SectorsPerFAT;
          Longint(P1^) := I;
          Inc(Longint(P1), 4);
        end;
     
       dsBytePerSector:=BytesPerSector;
       EndingCluster :=((LogicalSectors-DataAreaSector) div SectorsPerCluster)+1;
       FreeMem(P);
       if FSType = fsNone then Exit;
     
       GetMem(P, SectorsPerFAT*FATCount*BytesPerSector);
       if not ReadSector(GetFATCluster(1), SectorsPerFAT*FATCount,
       P^, SectorsPerFAT*FATCount*BytesPerSector) then
          begin
             FreeMem(P);
             Exit;
          end;
       FATSize := EndingCluster-1;
       GetMem(FAT, FATSize*FATCount*4);
       FillChar(FAT^, FATSize*FATCount*4, 0);
       P2:= FAT;
       if FSType = fsFAT12 then
          begin
             for J := 0 to FATCount-1 do
                 begin
                    P1 := Pointer(Longint(P)+J*SectorsPerFAT*BytesPerSector+3);
                    for I := 1 to FATSize div 2 do
                        begin
                           B1 := Byte(P1^); Inc(Longint(P1));
                           B2 := Byte(P1^) and $0F;
                           W := B2; W := (W shl 8) or B1;
                           L := W;
                           Longint(P2^) := L and FAT_MASK_12;
                           Inc(Longint(P2), 4);
                           B1 := Byte(P1^) and $F0; Inc(Longint(P1));
                           B2 := Byte(P1^); Inc(Longint(P1));
                           W := B2; W := (W shl 4) or (B1 shr 4);
                           L := W;
                           Longint(P2^) := L and FAT_MASK_12;
                           Inc(Longint(P2), 4);
                        end;
                    if Odd(FATSize) then
                       begin
                          B1 := Byte(P1^); Inc(Longint(P1));
                          B2 := Byte(P1^) and $0F;
                          W := B2; W := (W shl 8) or B1;
                          L := W;
                          Longint(P2^) := L and FAT_MASK_12;
                       end;
                 end;
          end else
       if FSType = fsFAT16 then
          begin
             for J := 0 to FATCount-1 do
                 begin
                    P1 := Pointer(Longint(P)+J*SectorsPerFAT*BytesPerSector+4);
                    for I := 1 to FATSize do
                        begin
                           L := Word(P1^); Inc(Longint(P1), 2);
                           Longint(P2^) := L and FAT_MASK_16;
                           Inc(Longint(P2), 4);
                        end;
                 end;
          end else
            if FSType = fsFAT32 then
          begin
             for J := 0 to FATCount-1 do
                 begin
                    P1 := Pointer(Longint(P)+J*SectorsPerFAT*BytesPerSector+8);
                    for I := 1 to FATSize do
                        begin
                           L := Longint(P1^);
                           Inc(Longint(P1), 4);
                           Longint(P2^) := L and FAT_MASK_32;
                           Inc(Longint(P2), 4);
                        end;
                 end;
          end;
       FreeMem(P);
    end;
     
     
    function GetFATEntry(Cluster: Int64): Longint;
    Var
     CopyOfFAT:Byte;
    begin
       Result := -1;
       if FSType = fsNone then Exit;
       if FAT = NIL then Exit;
       if FATSize = 0 then Exit;
       if ActiveFAT = 0 then
       CopyOfFAT := FATCount else
       CopyOfFAT := ActiveFAT;
       Cluster := Cluster-2;
       CopyOfFAT := CopyOfFAT-1;
       Result := Longint(Pointer(Longint(FAT)+CopyOfFAT*FATSize*4+Cluster*4)^);
       if FSType = fsFAT12 then Result := Result and FAT_MASK_12 else
       if FSType = fsFAT16 then Result := Result and FAT_MASK_16 else
          Result := Result and FAT_MASK_32;
    end;
     
    procedure SetFATEntry(Cluster: Int64; Value: Longint);
    Var
     CopyOfFAT:Byte;
    begin
       if FSType = fsNone then Exit;
       if FAT = NIL then Exit;
       if FATSize = 0 then Exit;
       if ActiveFAT = 0 then CopyOfFAT := FATCount else
       CopyOfFAT := ActiveFAT;
    //   if Cluster < 2 then Cluster := 2;
    //   if Cluster > EndingCluster then Cluster := EndingCluster;
       Cluster := Cluster-2;
       CopyOfFAT := CopyOfFAT-1;
       if FSType = fsFAT12 then Value := Value and FAT_MASK_12 else
       if FSType = fsFAT16 then Value := Value and FAT_MASK_16 else
          Value := Value and FAT_MASK_32;
       Longint(Pointer(Longint(FAT)+CopyOfFAT*FATSize*4+Cluster*4)^) := Value;
    end;
     
     
    FUNCTION GetCluster(Sector: Int64):Int64;
    BEGIN
          if (Sector - DataAreaSector >= 0) and (LogicalSectors -Sector >= 0) then
          GetCluster :=(Sector-DataAreaSector) div SectorsPerCluster
          else
          Result := 0;
    END;
     
    function ReadCluster(Cluster: Int64; var Buffer; BufferSize: Longint): Boolean;
    var P: Pointer;
        I: Int64;
    begin
       Result := False;
       if Cluster < 1 then Cluster := RootDirCluster;
       Cluster := Cluster-2;
       GetMem(P, BytesPerSector*SectorsPerCluster);
       I := DataAreaSector + (SectorsPerCluster*Cluster);
       Result := ReadSector(I, SectorsPerCluster, Buffer,
       BytesPerSector*SectorsPerCluster);
       FreeMem(P);
    end;
     
    function WriteCluster(Cluster: Int64; var Buffer; BufferSize: Longint): Boolean;
    var P: Pointer;
        I: Int64;
    begin
       Result := False;
       if FSType = fsNone then Exit;
       if FATSize = 0 then Exit;
       if Cluster < 1 then Cluster := RootDirCluster;
       Cluster := Cluster-2;
       GetMem(P, BytesPerSector*SectorsPerCluster);
       FillChar(P^, BytesPerSector*SectorsPerCluster, 0);
       if BufferSize > BytesPerSector * SectorsPerCluster then
       BufferSize := BytesPerSector*SectorsPerCluster;
       Move(Buffer, P^, BufferSize);
       I := DataAreaSector+SectorsPerCluster*Cluster;
       Result := WriteSector(I, SectorsPerCluster, P^,
       BytesPerSector*SectorsPerCluster);
       FreeMem(P);
    end;
     
     
    function WriteClusterChain(StartCluster: Longint; Buffer: Pointer; BufferSize: Longint): Boolean;
    var ClusterSize: Longint;
        I: Int64;
    begin
       Result := False;
       if FSType = fsNone then Exit;
       if FAT = NIL then Exit;
       if FATSize = 0 then Exit;
       if StartCluster < 1 then StartCluster := RootDirSector;
       ClusterSize := BytesPerSector*SectorsPerCluster;
       I := StartCluster;
       while ValidCluster(I) do
         begin
            if BufferSize<ClusterSize then
               begin
                  Result := WriteCluster(I, Buffer^, BufferSize);
                  Break;
               end else Result := WriteCluster(I, Buffer^, ClusterSize);
            if not Result then Break;
            Longint(Buffer) := Longint(Buffer)+ClusterSize;
            BufferSize := BufferSize-ClusterSize;
            I := GetFATEntry(I);
         end;
    end;
     
    function ReadClusterChain(StartCluster: Int64; var Buffer: Pointer; var BufferSize: Longint): Boolean;
    var I, J:Int64;
        P: Pointer;
        F: TMemoryStream;
        B: Boolean;
    begin
       Result := False;
       if FSType = fsNone then Exit;
       if FAT = NIL then Exit;
       if FATSize = 0 then Exit;
       if StartCluster < 1 then StartCluster := RootDirCluster;
       I := StartCluster;
       J := BytesPerSector*SectorsPerCluster;
       GetMem(P, J);
       F := TMemoryStream.Create;
       repeat
         if not ValidCluster(I) then Break;
         B := ReadCluster(I, P^, J);
         if not B then
            begin
               Result := False;
               Break;
            end;
         Result := True;
         F.Write(P^, J);
         I := GetFATEntry(I);
       until False;
       FreeMem(P);
       Buffer := NIL;
       BufferSize := 0;
       if Result then
          begin
             BufferSize := F.Size;
             GetMem(Buffer, BufferSize);
             F.Seek(0, 0);
             F.Read(Buffer^, BufferSize);
          end;
       F.Free;
    end;
     
    function SeekForChainStart(Cluster: Int64): Longint;
    var I: DWORD;
        J:LongInt;
        B: Boolean;
    begin
       Result := -1;
       if FSType = fsNone then Exit;
       if FAT = NIL then Exit;
       if FATSize = 0 then Exit;
       if Cluster < 1 then Cluster := RootDirCluster;
       J := -1;
       repeat
         B := False;
         for I := 2 to EndingCluster do
             if GetFATEntry(I) = Cluster then
                begin
                   J := I;
                   Cluster := I;
                   B := True;
                   Break;
                end;
       until not B;
       Result := J;
    end;
     
     
    function ValidCluster(Cluster: Int64): Boolean;
    begin
       Result := (Cluster>=2) and (Cluster<=EndingCluster);
    end;
     
     
     
     
     
     
    Procedure Done;
    Begin
       if FATSector <> NIL then FreeMem(FATSector);
       if FAT <> NIL then FreeMem(FAT);
    end;
     
     
    (******************************************************************************)
     
    procedure ParseDOSTime(Time: Word; var Hour, Minute, Second: Word);
    begin
      Second := (Time and $001f)*2;
      Minute := (Time and $07e0) shr 5;
      Hour := (Time and $f800) shr 11;
    end;
     
    procedure ParseDOSDate(Date: Word; var Day, Month, Year: Word);
    begin
      Day := Date and $001f;
      Month := (Date and $01e0) shr 5;
      Year := ((Date and $fe00) shr 9) + 1980;
    end;
     
     
    function GetShortName(Name: String): String;
    var S: String;
        I: Longint;
    begin
       SetLength(S, 10000);
       I := GetShortPathName(PChar(Name), @S[1], 10000);
       SetLength(S, I);
       Result := S;
    end;
     
     
    function FormatDiskSize (Value: TLargeInteger): string;
    const
      SizeUnits: array[1..5] of string = (' Bytes', ' KB', ' MB', ' GB', 'TB');
    var
      SizeUnit: Integer;
      Temp: TLargeInteger;
      Size: Integer;
    begin
      SizeUnit := 1;
      if Value < 1024 then
        Result := IntToStr(Value)
      else begin
        Temp := Value;
        while (Temp >= 1000*1024) and (SizeUnit <= 5) do begin
          Temp := Temp shr 10; //div 1024
          Inc(SizeUnit);
        end;
        Inc(SizeUnit);
        Size := (Temp shr 10); //div 1024
        Temp := Temp - (Size shl 10);
        if Temp > 1000 then
          Temp := 999;
        if Size > 100 then
          Result := IntToStr(Size)
        else if Size > 10 then
          Result := Format('%d%s%.1d', [Size, DecimalSeparator, Temp div 100])
        else
          Result := Format('%d%s%.2d', [Size, DecimalSeparator,
            Temp div 10])
      end;
      Result := Result + SizeUnits[SizeUnit];
    end;
     
     
    function DosToWin(St: string): string;
    var
      Ch: PChar;
    begin
      Ch := StrAlloc(Length(St) + 1);
      OemToAnsi(PChar(St), Ch);
      Result := Ch;
      StrDispose(Ch)
    end;
     
     
    end.
     
     
