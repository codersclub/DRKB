---
Title: Как установить BDE?
Date: 01.01.2007
---


Как установить BDE?
===================

::: {.date}
01.01.2007
:::

    program InstallPrfSt;
     
    {
    Программа иллюстрирует, как установить BDE с поддержкой PARADOX 7.0
    на "чистой машине" и создать алиас.
    Пример использования в качестве простейшего инсталлятора для программы
    C:\MyDir\MyProg.exe
    1.Создайте каталог C:\MyDir\BDE и скопируйте в него след. файлы:
    CHARSET.BLL
    OTHER.BLL
    IDAPI32.CFG
    BLW32.DLL
    IDAPI32.DLL
    IDBAT32.DLL
    IDPDX32.DLL
    IDR20009.DLL
    IDSQL32.DLL
    BDEADMIN.EXE - по вкусу, т.к. необходимым не является.
    2.Измените значение константы AliasName на имя необходимого вам алиаса.
    3.Откомпиллируйте и запустите эту программу из каталога C:\MyDir.
    ВHИМАHИЕ!!! Если на машине уже установлено BDE, то перед экспериментами
    сохраните (на всякий случай) след. ключи из реестра:
    [HKEY_LOCAL_MACHINE\SOFTWARE\Borland\Database Engine] и
    [HKEY_LOCAL_MACHINE\SOFTWARE\Borland\BLW32].
    }
     
    {$APPTYPE CONSOLE}
    uses
      Windows, BDE, Registry;
     
    const
      AliasName: string = 'PrefStat';
     
    var
      R: DBIResult;
      Path: string;
     
    procedure WriteString(S1:string);
    begin
      S1 := S1 + #0;
      AnsiToOem(@S1[1], @S1[1]);
      writeln(S1);
    end;
     
    function GetExePath(S1:string):string;
    var
      I, K :Integer;
      S: string;
    begin
      K := 1;
      S := '';
      for I := Length(S1) downto 1 do
      begin
        if S1[I] = '\' then
        begin
          K := I;
          Break;
        end;
      end;
     
      for I := 1 to K - 1 do
        S := S + S1[I];
     
      Result:=S;
    end;
     
    procedure InstallBde;
    const
      Bor: string = 'SOFTWARE\Borland';
    var
      a: TRegistry;
      BPath: string;
    begin
      BPath:=PATH + '\BDE';
      a := TRegistry.Create;
      with a do
      begin
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey(Bor + '\Database Engine', True);
        WriteString('CONFIGFILE01', BPath+'\IDAPI32.CFG');
        WriteString('DLLPATH', BPath);
        WriteString('RESOURCE', '0009');
        WriteString('SaveConfig', 'WIN32');
        WriteString('UseCount', '2');
        CloseKey;
        OpenKey(Bor+'\BLW32',True);
        WriteString('BLAPIPATH', BPath);
        WriteString('LOCALE_LIB3', BPath+'\OTHER.BLL');
        WriteString('LOCALE_LIB4', BPath+'\CHARSET.BLL');
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\SYSTEM\INIT',True);
        WriteString('AUTO ODBC', 'FALSE');
        WriteString('DATA REPOSITORY', '');
        WriteString('DEFAULT DRIVER', 'PARADOX');
        WriteString('LANGDRIVER', 'ancyrr');
        WriteString('LOCAL SHARE', 'FALSE');
        WriteString('LOW MEMORY USAGE LIMIT', '32');
        WriteString('MAXBUFSIZE', '2048');
        WriteString('MAXFILEHANDLES', '48');
        WriteString('MEMSIZE', '16');
        WriteString('MINBUFSIZE', '128');
        WriteString('SHAREDMEMLOCATION', '');
        WriteString('SHAREDMEMSIZE', '2048');
        WriteString('SQLQRYMODE', '');
        WriteString('SYSFLAGS', '0');
        WriteString('VERSION', '1.0');
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\SYSTEM\FORMATS\DATE',True);
        WriteString('FOURDIGITYEAR', 'TRUE');
        WriteString('LEADINGZEROD', 'FALSE');
        WriteString('LEADINGZEROM', 'FALSE');
        WriteString('MODE', '1');
        WriteString('SEPARATOR', '.');
        WriteString('YEARBIASED', 'TRUE');
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\SYSTEM\FORMATS\NUMBER',True);
        WriteString('DECIMALDIGITS', '2');
        WriteString('DECIMALSEPARATOR', ',');
        WriteString('LEADINGZERON', 'TRUE');
        WriteString('THOUSANDSEPARATOR', ' ');
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\SYSTEM\FORMATS\TIME',True);
        WriteString('AMSTRING', 'AM');
        WriteString('MILSECONDS', 'FALSE');
        WriteString('PMSTRING', 'PM');
        WriteString('SECONDS', 'TRUE');
        WriteString('TWELVEHOUR', 'TRUE');
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\REPOSITORIES',True);
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\DRIVERS\PARADOX\INIT',True);
        WriteString('LANGDRIVER', 'ancyrr');
        WriteString('TYPE', 'FILE');
        WriteString('VERSION', '1.0');
        CloseKey;
        OpenKey(Bor+'\Database Engine\Settings\DRIVERS\PARADOX\TABLE
        CREATE',True);
        WriteString('BLOCK SIZE', '4096');
        WriteString('FILL FACTOR', '95');
        WriteString('LEVEL', '7');
        WriteString('STRICTINTEGRTY', 'TRUE');
        CloseKey;
      end;
      a.Free;
    end;
     
    begin
      Path:=GetExePath(ParamStr(0));
      R:=dbiInit(nil);
      if R<>DBIERR_NONE then
      begin
        WriteString('Инициализация BDE ...');
        InstallBDE;
      end;
      R:=dbiInit(nil);
      if R=DBIERR_NONE then
      begin
        WriteString('Инициализация BDE прошла успешно');
        DbiDeleteAlias(nil, PChar(AliasName));
        R:=DbiAddAlias(nil, PChar(AliasName), szPARADOX,
        PChar('PATH:'+Path+'\DB'), True);
        if R=DBIERR_NONE then
          WriteString('Псевдоним "'+AliasName+'" создан')
        else
          WriteString('Ошибка создания псевдонима "'+AliasName+'"');
        R:=DbiCfgSave(nil, nil, Bool(-1));
        if R=DBIERR_NONE then
          WriteString('Файл конфигурации сохранён')
        else
          WriteString('Ошибка сохранения файла конфигурации');
        DbiExit;
      end
      else
        WriteString('Ошибка инициализации BDE');
    end.

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Следуйте приведенной ниже инструкции для разворачивания BDE на
клиентской машине:

  ---- ---------------------------------------------------------------------------------------------------------
  1.   Отформатируйте две дискеты в дисководе клиентской машины. Пометьте дискеты как \"Disk 1\" и \"Disk 2\".
  ---- ---------------------------------------------------------------------------------------------------------

  ---- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  2.   Скопируйте файлы с DELPHI CD, содержащиеся в каталоге \\REDIST\\BDEINST\\DISK1 на дискету, помеченную как \"Disk 1\", и файлы из каталога \\REDIST\\BDEINST\\DISK2 на дискету \"Disk 2\".
  ---- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  ---- ---------------------------------------------------------------------------------------------------------------------------------------
  3.   Вставьте в дисковод клиентской машины дискету, помеченную как \"BDE Install 1\" (в нашем примере мы используем дисковод с буквой A:).
  ---- ---------------------------------------------------------------------------------------------------------------------------------------

  ---- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  4.   Убедитесь в том, что в Windows отсутствуют запущенные программы. В Windows Program Manager выберите File\|Run, введите в поле редактирования командной строки (\"Command Line\") \"A:\\DISK1\\SETUP\" и нажмите \"OK\" для начала установки Borland Database Engine на клиентской машине.
  ---- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  ---- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  5.   Сначала, на короткое время, появится окно \"Database Engine Install\", затем диалог \"preparing to install...\", и, наконец, диалог \"BDE Redisttributable\", содержащий кнопки Continue (Продолжить) и Exit (Выйти). Нажмите \"Continue\".
  ---- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  ---- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  6.   Появится диалог \"Borland Database Engine Location Settings\", позволяющий изменить каталог установки программ BDE и конфигурационных файлов. Оставьте настройки по умолчанию и нажмите \"Continue\" (Продолжить).
  ---- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  ---- ---------------------------------------------------------------------------------------------------------------------------------------------------------------
  7.   Появится диалог \"Borland Database Engine Installation\", позволяющий вернуться к предыдущим диалогам или начать установку. Нажмите \"Install\" (Установить).
  ---- ---------------------------------------------------------------------------------------------------------------------------------------------------------------

  ---- -------------------------------------------------------------------------------
  8.   Процесс копирования дискеты \"Disk 1\" будет отображаться полоской прогресса.
  ---- -------------------------------------------------------------------------------

  ---- --------------------------------------------------------------------------------------------------------------------------
  9.   Появится диалог \"BDE Redistributable Install Request\". Вставьте дискету \"Disk 2\". Нажмите \"continue\" (Продолжить).
  ---- --------------------------------------------------------------------------------------------------------------------------

  ----- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  10.   По окончании процедуры установки появится диалог \"Borland Database Engine Installation Notification\", сообщающий об успешной установке BDE. Нажмите \"Exit\" (Выход).
  ----- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  ----- -----------------------------------------------------------------------------------------
  11.   Завершите работу Windows, удалите дискету из дисковода и перегрузите клиентскую машину.
  ----- -----------------------------------------------------------------------------------------

12\.        Если настройки по умолчанию уже где-то используются,
произойдут изменения, указанные ниже.

На клиентской машине появятся два новых каталога - \\IDAPI и
\\IDAPI\\LANGDRV. Обратите внимание на то, что утилита BDE Configuration
Utility, BDECFG.EXE, располагается в каталоге \\IDAPI. Языковые драйвера
располагаются в каталоге \\IDAPI\\LANGDRV как файлы *.LD. AUTOEXEC.BAT,
CONFIG.SYS и SYSTEM.INI при инсталляции не изменяются.

WIN.INI в каталоге \\WINDOWS\\SYSTEM будет иметь новые секции:

\[IDAPI\]

DLLPATH=C:\\IDAPI

CONFIGFILE01=C:\\IDAPI\\IDAPI.CFG

\[Borland Language Drivers\]

LDPath=C:\\IDAPI\\LANGDRV

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba

------------------------------------------------------------------------

Как установить BDE из файла BDEINST.CAB?

If you have taken a close look at the listing of the BDE installation
directory (usually \\Program Files\\Borland\\Common FIles\\BDE), you\'ve
noticed there\'s a file called BDEINST.CAB. If BDEINST.CAB isn\'t
present in the BDE folder, you probably chose not to let it be
installed. As this tip requires this file, you might want to run install
again and install only BDEINST.CAB. Anyway, let\'s get back to the tip.

What is BDEINST.CAB?

BDEINST.CAB is a cabinet (Microsoft\'s compression format) file that
contains only one large file: BDEINST.DLL. This DLL contains a simple
installation program along with all the necessary files for a basic
install of BDE. It will correctly install BDE with the native drivers
for Paradox, dBase, MS Access and FoxPro. It won\'t install drivers for
SQL database servers. If all you need is a basic installation of BDE for
supporting one of the forementioned databases, then BDEINST.CAB is the
best choice for you.

Given the problem InstallShield and Wise have with installing BDE 5,
BDEINST.DLL has a great appeal, since it was created by the Borland
folks and doesn\'t suffer from the same problems InstallShield and WISE
do.

There is, however, a drawback: BDEINST.DLL is a quite large file, so
it\'s that good if you\'re deploying on floppy disks. There\'s a
workaround for this problem and we\'ll get back to it later on.

Using BDEINST.DLL

In order to use BDEINST.DLL, all you have to do is to extract it from
BDEINST.CAB. There are several ways this can be done. Two of them are:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ------------------------------------------------------------------------------------------------
  ·   Using WinZip or another CAB-compatible archiver. Simply extract BDEINST.DLL from the CAB file.
  --- ------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ----------------------------------------------------------------------------------------------------------------------------------------
  ·   Using Microsoft\'s EXTRACT utility that comes with Windows 9x and NT. From a DOS window, issue the command below (path is also shown):
  --- ----------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- --
  ·   
  --- --
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- -----------------------------------------------------------------------
  ·   C:\\Program Files\\Borland\\Common Files\\BDE\>EXTRACT /E BDEINST.CAB
  --- -----------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- --
  ·   
  --- --
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ---------------------------------------------------------------------------------------------------------------------
  ·   This will extract BDEINST.DLL to the current directory, since no destination dir was specified in the command line.
  --- ---------------------------------------------------------------------------------------------------------------------
:::

The task now is to use the DLL. This is as simple as issuing the command
line below:

C:\\WINDOWS\\SYSTEM\\REGSVR32.EXE /S CABINST.DLL

If the command above fails, make sure you have REGSVR32.EXE on your
machine. Not all machines have it, and, in case of deploying
BDEINST.DLL, it\'s also a good idea to deploy REGSVR32.EXE. This file
can be found in \\WINDOWS\\SYSTEM or \\WINNT\\SYSTEM32.

A progress dialog box will popup indicating that the installation of BDE
is going ok. This is all it takes to install BDE without needing any
additional tool such as InstallShield or Wise.

If you do not want to deploy REGSVR32.EXE, you can create a small
VCL-less and formless application that simply calls DllRegisterServer
from the DLL.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Problem/Question/Abstract:

What are the essential files to ship with an application that uses the
BDE?

Answer:

Delphi allows you to generate a nice tight executable file (.EXE), but
if you have created a database application you must include the files
that make up the Borland Database Engine as well. The table below shows
the files that are mandatory when delivering a database application with
Delphi.

File Name        Description

IDAPI01.DLL - BDE API DLL

IDBAT01.DLL -  BDE Batch Utilities DLL

IDQRY01.DLL -  BDE Query DLL

IDASCI01.DLL - BDE ASCII Driver DLL

IDPDX01.DLL - BDE Paradox Driver DLL

IDDBAS01.DLL - BDE dBASE Driver DLL

IDR10009.DLL - BDE Resources DLL

ILD01.DLL  - Language Driver DLL

IDODBC01.DLL - BDE ODBC Socket DLL

ODBC.New  - Microsoft ODBC Driver Manager DLL V2.0

ODBCINST.NEW - Microsoft ODBC Driver Installation DLL V2.0

TUTILITY.DLL - BDE Table Repair Utility DLL 

BDECFG.EXE  - BDE Configuration Utility DLL

BDECFG.HLP  -  BDE Configuration Utility Help

IDAPI.CFG -        BDE Configuation File (settings)

To assist the user, Delphi ships with an install program for exporting
the appropriate files that you want deliver to your clients. Also,
installation programs such as InnoSetup and InstallShield can
automatically include the relevant files in their setup programs.

InnoSetup is my program installation program of choice, and it is FREE!
For more information or to download a copy visit Jordan Russ[https://
www.jrsoftware.org](https://%20www.jrsoftware.org)ell\'s site at

Finally a tip on using the setup CAB file that ships with the BDE to
install the relevant files can be found in DKB, article title
\"Installing BDE from BDEINST.CAB\"

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
