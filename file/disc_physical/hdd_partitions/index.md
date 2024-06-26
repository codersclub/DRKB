---
Title: Показать структуру разделов жесткого диска
Author: NikNet (NikNet@Yandex.ru)
Date: 01.01.2007
---


Показать структуру разделов жесткого диска
==========================================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ComCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        TreeView1: TTreeView;
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
       Function SearchLogicalDisks:Int64;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    Uses Disk;
     
    TYPE
    {---------------------- Структура описателя раздела -------------------------}
     PPartition   =  ^TPartition;
     TPartition    {                                    }=packed Record
      Boot         { Флаг активности $80=YES, $00=NO    }: BYTE;
      BegHead      { Головка                            }: BYTE;
      BegCylSec    { Цылиндер и сектор                  }: WORD;
      PartType     { Код типа раздела (Смотрите ниже)   }: BYTE;
      EndHead      { Головка                            }: BYTE;
      EndCylSec    { Цылиндер и сектор                  }: WORD;
      Sector       { Номер начального сектора раздела   }: LongInt;
      PartSize     { Размер раздела в секторах          }: LongInt;
      end;
     
    const
      PARTITION_ENTRY_UNUSED    = $00;      // Entry unused
      PARTITION_FAT_12          = $01;      // 12-bit FAT entries
      PARTITION_XENIX_1         = $02;      // Xenix
      PARTITION_XENIX_2         = $03;      // Xenix
      PARTITION_FAT_16          = $04;      // 16-bit FAT entries
      PARTITION_EXTENDED        = $05;      // Extended partition entry
      PARTITION_FAT16           = $06;      // Unformatted
      PARTITION_IFS             = $07;      // IFS Partition
      PARTITION_OS2BOOTMGR      = $08;      // OS/2 Boot Manager/OPUS/Coherent swap
      PARTITION_FAT32           = $0B;      // FAT32
      PARTITION_FAT32_XINT13    = $0C;      // FAT32 using extended int13 services
      PARTITION_XINT13          = $0E;      // Win95 partition using extended int13 services
      PARTITION_XINT13_EXTENDED = $0F;      // Same as type 5 but uses extended int13 services
      PARTITION_PREP            = $41;      // PowerPC Reference Platform (PReP) Boot Partition
      PARTITION_LDM             = $42;      // Logical Disk Manager partition
      PARTITION_UNIX            = $63;      // Unix
      PARTITION_LINUX_SWAP      = $82;      // Linux swap
      PARTITION_LINUX_EXT2      = $83;      // Linux ext2
      VALID_NTFT                = $C0;      // NTFT uses high order bits
     
    {--------- Структура главной загрузочной записи и таблицы разделов ----------}
    TYPE
     PPartitionTable  = ^TPartitionTable;
     TPartitionTable {                                  }=packed Record
      Boot           { Загрузочная запись (MSB)         }:array[1..446] of Byte;
      Partition      { Описатель радела 1               }:array[1..4]   of TPartition;
      TrailSig       { Сигнатура AA55h                  }:array[1..2]   of byte;
      end;
     
     
    Var
      MNode,ExtNode,Node:TTreeNode;
      HddNumber:Byte;
     
     
    function ReadSector (Sector:Int64; Count:word;  Var Buffer): DWORD;
    Begin
     Result:=ReadPlysicalSector (HddNumber,Sector,Count,Buffer);
    end;
     
    // Ф-ция заполняет масив таблицу разделов, возвращает номер
    // активного раздела или $FF при неправельном построение...
    Function GetPartitionTable(PartitionSector:Int64; Var PartitionTable:PPartitionTable):Byte;
    Var
     I : Byte;
    Begin
     ReadSector(PartitionSector,1,PartitionTable^);
      For  i:=1 to 4 do
      If PPartitionTable(PartitionTable)^.Partition[i].Boot = $80 Then
       Result:=(i+1);
      If (Result > 1) or (Result < 1) Then
      Result:=$FF; // Ошибка построения разделов
    end;
     
    function PartitionTypeToString (Value : Integer) : String;
    begin
      case Value of
      $00:Result:='Unused';
      $01:Result:='FAT 12';
      $02:Result:='XENIX Root';
      $03:Result:='XENIX Usr';
      $04:Result:='FAT 16';
      $05:Result:='Extended Partition';
      $06:Result:='FAT 16';
      $07:Result:='NTFS';
      $08:Result:='AIX bootable';
      $09:Result:='AIX data Coher';
      $0A:Result:='OS/2 Swap';
      $0B:Result:='FAT 32';
      $0C:Result:='FAT 32 LBA';
      $0E:Result:='DOS Extended';
      $0F:Result:='DOS Extended LBA';
      $10:Result:='OPUS';
      $12:Result:='Compaq Diagnostics';
      $16:Result:='Hidden (PM)';
      $17:Result:='NTFS Hidden (PM)';
      $18:Result:='AST swap';
      $19:Result:='Willowtech Photon';
      $1B:Result:='FAT32 Hidden(PM)';
      $1E:Result:='FAT 16 (Win ME)';
      $20:Result:='Willowsoft Overture';
      $21:Result:='Oxygen FSo2';
      $22:Result:='Oxygen Ext';
      $24:Result:='NEC-DOS v3x';
      $38:Result:='Theos';
      $3C:Result:='PMagic';
      $40:Result:='Venix 286';
      $41:Result:='Personal RISC Boot';
      $42:Result:='Secure FS';
      $45:Result:='EUMEL/Elan';
      $46:Result:='EUMEL/Elan';
      $47:Result:='EUMEL/Elan';
      $48:Result:='EUMEL/Elan';
      $4D:Result:='QNX 1.Part';
      $4E:Result:='QNX 2.Part';
      $4F:Result:='QNX 3.Part';
      $50:Result:='OnTrack Read-Only';
      $51:Result:='OnTrack R/W';
      $52:Result:='Microport';
      $53:Result:='OnTrack, Aux3';
      $54:Result:='OnTrack, DDO';
      $55:Result:='EZ-Drive';
      $56:Result:='Golden Bow';
      $5C:Result:='Priam EDisk';
      $61:Result:='Speed Stor';
      $63:Result:='GNUHurd';
      $64:Result:='Netware 286';
      $65:Result:='Netware 386 v4x';
      $67:Result:='Netware';
      $68:Result:='Netware';
      $69:Result:='Netware 386 v3x';
      $70:Result:='DiskSecure MuliBoot';
      $75:Result:='PC/ix';
      $7E:Result:='F.I.X.';
      $80:Result:='MINIX 1.1-1.4a';
      $81:Result:='Linux';
      $82:Result:='Linux swap';
      $83:Result:='Linux';
      $85:Result:='Linux Ext part';
      $86:Result:='NTFS FAT 16';
      $87:Result:='HPFS';
      $93:Result:='Amoeba FS';
      $94:Result:='Amoeba BadBlockTable';
      $98:Result:='Datalight ROM-DOS';
      $99:Result:='Unix';
      $A0:Result:='Notebook swap';
      $A5:Result:='FreeBSD';
      $A6:Result:='OpenBSD';
      $A7:Result:='NEXTSTEP';
      $A9:Result:='NetBSD';
      $AA:Result:='Olivetti FAT12';
      $B0:Result:='BOOTSTAR Dummy';
      $B6:Result:='Windows NT mirror';
      $B7:Result:='BSDI';
      $B8:Result:='BSDI swap';
      $BE:Result:='Solaris boot';
      $C0:Result:='CTOS';
      $C1:Result:='DR-DOS (FAT 12 bit)';
      $C4:Result:='DR-DOS (FAT 16 bit)';
      $C6:Result:='DR-DOS (Huge)';
      $C7:Result:='Syrinx Boot';
      $CC:Result:='DR-DOS FAT32 LBA';
      $CE:Result:='DR-DOS FAT16 LBA';
      $D0:Result:='Multiuser DOS FAT 12';
      $D1:Result:='Multiuser DOS FAT 12';
      $D4:Result:='Multiuser DOS FAT 16';
      $D5:Result:='Multiuser DOS ext';
      $D6:Result:='Multiuser DOS FAT 16';
      $D8:Result:='CP/M-86';
      $DB:Result:='CP/M / Concurrent DOS';
      $E1:Result:='Speed Stor DOS access';
      $E2:Result:='DOS readonly XFDisk';
      $E3:Result:='DOS readonly';
      $E4:Result:='SpeedStor FAT 16 ext';
      $EB:Result:='BeOS';
      $F1:Result:='SpeedStor';
      $F2:Result:='DOS secondary';
      $F4:Result:='SpeedStor DOS access';
      $F5:Result:='Prologue';
      $FE:Result:='IBM PS2';
      $FF:Result:='Xenix Bad Block Table';
      else
        Result := 'Unknown';
      end;
    end;
     
     
    {$R *.dfm}

     Function TForm1.SearchLogicalDisks:Int64;
     Label
         PrimPartFound,
         PrimPartNotFound,
         ExtPartFound,
         OtherExtPartFound1,
         OtherExtPartFound2,
         NextDriveNotPresent0,
         ReadSMBR,
         NextDriveNotPresent1,
         SearchEnd;
     TYPE
      TData = record
       // Номер раздела
       PartitionNumber     : Byte;
       // Начальный номер основного раздела DOS
       PriDOS_StartSector  : Int64;
       // Начальный номер расширенного раздела DOS
       ExtDOS_StartSector  : Int64;
       // Нчальный сектор текущего логического диска
       CurrentDrive_StartSector : Int64;
       // Номер логического диска
       LogicalDriveNumber  : Byte;
       // Флаг присутствияв системе следующего диска
       NextDrivePresent    : Boolean;
      end;
      PData = ^TData;
     
     Var
       // Таблица разделов
       Partition   : PPartitionTable;
       // Переменные...
       Data        : PData;
       I         : Integer;
     
     Begin
       MNode:=TreeView1.Items.Add(nil,'HDD Driver');
       Result:=0;
       // Выделяем память для наших переменных
       New(Data);
       // Онулируем все переменные
       FillMemory(Data,SizeOf(TData),0);
       // Выделяем память для таблиц разделов
       New(Partition);
       GetPartitionTable(Data.CurrentDrive_StartSector,Partition);
       Data.NextDrivePresent:=False;
       // Проверить код основного раздела
       For i:=0 to 3 do
       IF (Partition.Partition[1].PartType  <> $00) or
          ((Partition.Partition[1].PartType <> $05) and
          (Partition.Partition[1].PartType  <> $0F)) Then
       with Partition.Partition[1] do
       Begin
         Node:=TreeView1.Items.AddChild(MNode,'1st partition ('+
         PartitionTypeToString(PartType)+') ');
         Break;
         goto PrimPartFound;
       end else
        if Partition.Partition[1].Sector = 0 Then
        Begin
           Break;
           //----- Result:=1; -----\\ // Диск не размечен
           goto SearchEnd;
       end else
       IF (Partition.Partition[1].PartType <> $05) or
          (Partition.Partition[1].PartType <> $0F) Then
       Begin
         Break;
         //----- Result:=2; -----\\  // Основной раздел определен как расширеный
         goto SearchEnd;
       end else
       Begin
         Break;
         //----- Result:=3; -----\\ // Не определенный раздел
        goto SearchEnd;
       end;
       PrimPartFound:
       Begin
         Data.PriDOS_StartSector:= Partition.Partition[1].Sector;
         Inc(Data.LogicalDriveNumber);
         // Проверить код расширенного раздела
       For i:=0 to 3 do
       IF
         ((Partition.Partition[2].PartType = $05) or
          (Partition.Partition[2].PartType = $0F)) and
          (Partition.Partition[2].PartType <> $00)
       Then
       Begin
         ExtNode:=TreeView1.Items.AddChild(MNode,
         '2st partition ('+PartitionTypeToString(Partition.Partition[2].PartType)+') ');
         // Проверить коды других разделов
         Node:=TreeView1.Items.AddChild(MNode,
         '3st partition ('+PartitionTypeToString(Partition.Partition[3].PartType)+') ');
         Node:=TreeView1.Items.AddChild(MNode,
         '4st partition ('+PartitionTypeToString(Partition.Partition[4].PartType)+') ');
         Break;
         goto ExtPartFound
       end else
       Begin
         Break;
         goto NextDriveNotPresent0;
       end;
        // Имеется расширенный раздел
        ExtPartFound:
          Begin
           // Извлечь адрес сектора
           Data.ExtDOS_StartSector := Partition.Partition[2].Sector;
           Data.NextDrivePresent   := True;
          end;
       end;
     
        NextDriveNotPresent0:
        Begin
         // Имеется следующий диск?
         if not Data.NextDrivePresent Then
         goto SearchEnd;
          Data.CurrentDrive_StartSector:=Data.ExtDOS_StartSector;
        end;
     
      {- ЦИКЛ  ОПРОСА ЛОГИЧЕСКИХ ДИСКОВ РАСШИРЕННОГО РАЗДЕЛА -}
      ReadSMBR:
      Begin
       Inc(Data.LogicalDriveNumber);
       Node:=ExtNode;
       ExtNode:=TreeView1.Items.AddChild(ExtNode,
         '1st partition ('+PartitionTypeToString(Partition.Partition[1].PartType)+') ');
       ExtNode:=TreeView1.Items.AddChild(Node,
         '2st partition ('+PartitionTypeToString(Partition.Partition[2].PartType)+') ');
       // Прочитать очередной SMBR
       GetPartitionTable(Data^.CurrentDrive_StartSector,Partition);
       Data.NextDrivePresent:=False;
       // Смещение второй записи
       If Partition.Partition[2].Sector = 0 Then
        goto NextDriveNotPresent1;
       Data.CurrentDrive_StartSector:= Partition.Partition[2].Sector+
        Data.ExtDOS_StartSector;
       Data.NextDrivePresent:=True;
       NextDriveNotPresent1:
       Begin
         // Имеется следующий диск?
         if not Data.NextDrivePresent then
           goto SearchEnd
         else
           goto ReadSMBR;
       end;
      end;
     
     SearchEnd:
       Result:=DATA.LogicalDriveNumber;
       // Освобождаем память
       if Assigned(Partition) Then
         Dispose(Partition);
       // Освобождаем память
       if Assigned(Data) Then
         Dispose(Data);
       Exit;
     end;
     
     procedure TForm1.FormCreate(Sender: TObject);
     begin
      HddNumber:=0;
       SearchLogicalDisks;
     end;
     
    end.
