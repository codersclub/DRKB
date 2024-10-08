---
Title: Как получить инфу о жестком диске?
Author: Pegas
---


Как получить инфу о жестком диске?
==================================

Author: cyborg, cyborg1979@newmail.ru

Date: 23.05.2005

Source: Vingrad.ru <https://forum.vingrad.ru>

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение сведений о диске (метка/имя диска, файловая система, серийный номер)
     
    Получение информации о любом диске.
    Работает на FDD, HDD, CD, другие не пробовал.
     
    Создайте модуль с именем HDDInfo и полностью скопируйте в него весь текст.
     
    Зависимости: Все Windows (32S,95,NT)
    Автор: cyborg, cyborg1979@newmail.ru, ICQ:114205759, Бузулук
    Copyright: Собственное написание (Осипов Евгений Анатольевич)
    Дата: 23 мая 2002 г.
    ***************************************************** }
     
    unit HDDInfo;
     
    interface
     
    Uses Windows;
     
    Const {Константы для TypeOfDisk функции GetDisks}
    DiskUnknown=0; {Неизвестные диски}
    DiskNone=1; {Отсутствующие диски}
    DiskFDD=DRIVE_REMOVABLE; {Съёмные диски, дискеты}
    DiskHDD=DRIVE_FIXED; {Не съёиные диски, жёсткие диски}
    DiskNet=DRIVE_REMOTE; {Сетевые диски}
    DiskCDROM=DRIVE_CDROM; {CD ROM}
    DiskRAM=DRIVE_RAMDISK; {Диски в ОЗУ}
     
    {Получить имена нужных дисков}
    function GetDisks(TypeOfDisk : Word) : String;
     
    {Функция получения информации о диске (HDD,FDD,CD) с буквой Disk}
    {
    Передаваемые значения:
    Disk - Буква диска
     
    Получаемые значения:
    VolumeName - Метка/Имя тома
    FileSystemName - Файловая система
    VolumeSerialNo - Серийный номер диска (можно привязывать к диску программы)
    MaxComponentLength - Максимальная длинна имени файла
    FileSystemFlags - Флаги смотрите в справке Delphi по GetVolumeInformation
     
    Функция возвращает true, если всё прошло успешно (диск нашёлся),
    и false, если возникли проблемы, например диска нет в дисководе,
    либо дисковода такого вообще нет
    }
    Function GetHDDInfo(Disk : Char;Var VolumeName, FileSystemName : String;
    Var VolumeSerialNo, MaxComponentLength, FileSystemFlags:LongWord) : Boolean;
     
    implementation
     
    function GetDisks(TypeOfDisk : Word) : String;{Получить имена нужных дисков}
    var
      DriveArray : array[1..26] of Char;
      I : integer;
    begin
    DriveArray:='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for I := 1 to 26 do
      if GetDriveType(PChar(DriveArray[I]+':\')) = TypeOfDisk then 
        Result := Result+DriveArray[I];
    end;
     
    Function GetHDDInfo(Disk : Char;Var VolumeName, FileSystemName : String;
      Var VolumeSerialNo, MaxComponentLength, FileSystemFlags:LongWord) : Boolean;
      Var
    _VolumeName,_FileSystemName:array [0..MAX_PATH-1] of Char;
    _VolumeSerialNo,_MaxComponentLength,_FileSystemFlags:LongWord;
    Begin
    if GetVolumeInformation(PChar(Disk+':\'),_VolumeName,MAX_PATH,@_VolumeSerialNo,
       _MaxComponentLength,_FileSystemFlags,_FileSystemName,MAX_PATH) then
    Begin
    VolumeName:=_VolumeName;
    VolumeSerialNo:=_VolumeSerialNo;
    MaxComponentLength:=_MaxComponentLength;
    FileSystemFlags:=_FileSystemFlags;
    FileSystemName:=_FileSystemName;
    Result:=True;
    End 
    else 
      Result:=False;
    End;
    end.

Пример использования:

    USES ..., ..., ..., HDDInfo; {Добавляем наш модуль}
     
    {Нужно создать на форме компонент TLabel, Name которого ставим в Disks}
    {И в событии главной формы OnActicate написать это:}
     
    procedure TMyForm.FormActivate(Sender: TObject);
    Var
      S,SOut : String;
      I : Integer;
      VolumeName,FileSystemName : String;
      VolumeSerialNo,MaxComponentLength,FileSystemFlags:LongWord;
    begin
      S:=GetDisks(DiskHDD); {Получаем список Жёстких дисков (Параметр DiskHDD)}
      SOut:='';
      For I:=1 to Length(S) do {Получаем информацию о всех дисках и пишем в TLabel на форме}
      Begin
      {Если диск существует/вставлен ...}
        if GetHDDInfo(S[I], VolumeName, FileSystemName, VolumeSerialNo,
          MaxComponentLength, FileSystemFlags) then {... тогда собираем информацию}
          SOut:=SOut+
                'Диск: '+S[I]+#13#10+
                'Метка: '+VolumeName+#13#10+
                'Файловая система: '+FileSystemName+#13+#10+
                'Серийный номер: '+IntToHex(VolumeSerialNo,8)+#13+#10+
                'Макс. длина имени файла: '+
                IntToStr(MaxComponentLength)+#13+#10+
                'Flags: '+IntToHex(FileSystemFlags,4)+#13#10+#13#10;
      End;
      Disks.Caption:=SOut; {Выводим в компонент TLabel полученные данные о дисках}
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Alex&Co 

Source: <https://alex-co.com.ru>

Присутствует неточность в топике "Как получить инфу о жестком диске?".
Неточность заключается в том, что функция "GetVolumeInformation"
выдает совершенно разный номер диска под системами 9х и NT. Я долго
бился над этой проблемой т. к. в своей программе привязываются к номеру
в своей программе для определения какой диск вставил пользователь. Пару
раз задавал этот вопрос в форумах, но ответа так и не получил. Но
недавно я нашел решение этой проблемы. Вот код моей функции для
корректного определения серийного номера диска под любой ОС:

    function SirealNumberDisk(disk: string): string;
    // Определяем серийный номер диска
     
    var
      VolumeName         : array [0..MAX_PATH-1] of Char;
      FileSystemName     : array [0..MAX_PATH-1] of Char;
      VolumeSerialNo     : DWord;
      MaxComponentLength : DWord;
      FileSystemFlags    : DWord;
     
      function GetReplaceCDNumber(num: String): String;
      var
        i, len: Integer;
      begin
        Result:= '';
        len:= Length(num);
        if len <> 8 then exit;
        for i:= 1 to (len div 2) do begin
           Dec(len);
           Result:= Result + num[len    ];
           Result:= Result + num[len + 1];
           Dec(len);
        end;
      end;
     
    begin
      GetVolumeInformation(PChar(disk), VolumeName, MAX_PATH,
                           @VolumeSerialNo, MaxComponentLength, 
                           FileSystemFlags, FileSystemName, MAX_PATH);
      Result:= IntToHex(Integer(VolumeSerialNo), 8);
      if Win32Platform <> VER_PLATFORM_WIN32_NT then
        Result:= GetReplaceCDNumber(Result);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Label1.Caption:= SirealNumberDisk('f:\');
    end; 

