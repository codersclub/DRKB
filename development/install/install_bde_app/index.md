---
Title: Установка BDE программы
author: Константин Кочедыков /kostya@roadtech.saratov.su/
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Установка BDE программы
=====================

Периодически муссируются вопросы типа "Как установить BDE?" и т.п.

Предлагаю, как пример возможного решения проблемы, следующую программу.

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
    Замечания, предложения по улучшению приветствуются.
    Счастливо,
    Константин Кочедыков / kostya@roadtech.saratov.su / }
    {$APPTYPE CONSOLE}
    uses
      Windows, BDE, Registry;
    const
      AliasName: string = 'PrefStat';
    var
      R: DBIResult;
      Path: string;
     
    procedure WriteString(S1: string);
    begin
      S1 := S1 + #0;
      AnsiToOem(@S1[1], @S1[1]);
      writeln(S1);
    end;
     
    function GetExePath(S1: string): string;
    var
      I, K: Integer;
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
      Result := S;
    end;
     
    procedure InstallBde;
    const
      Bor: string = 'SOFTWARE\Borland';
    var
      a: TRegistry;
      BPath: string;
    begin
      BPath := PATH + '\BDE';
      a := TRegistry.Create;
      with a do
        begin
          RootKey := HKEY_LOCAL_MACHINE;
          OpenKey(Bor + '\Database Engine', True);
          WriteString('CONFIGFILE01', BPath + '\IDAPI32.CFG');
          WriteString('DLLPATH', BPath);
          WriteString('RESOURCE',
            '0009');
          WriteString('SaveConfig', 'WIN32');
          WriteString('UseCount', '2');
          CloseKey;
          OpenKey(Bor + '\BLW32', True);
          WriteString('BLAPIPATH', BPath);
          WriteString('LOCALE_LIB3', BPath + '\OTHER.BLL');
          WriteString('LOCALE_LIB4', BPath + '\CHARSET.BLL');
          CloseKey;
          OpenKey(Bor + '\Database Engine\Settings\SYSTEM\INIT', True);
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
          WriteString('SHAREDMWriteString(' SQLQRYMODE', '');
            WriteString('SYSFLAGS', '0');
            WriteString('VERSION', '1.0');
            CloseKey;
            OpenKey(Bor + '\Database Engine\Settings\SYSTEM\FORMATS\DATE', True);
            WriteString('FOURDIGITYEAR', 'TRUE');
            WriteString('LEADINGZEROD', 'FALSE');
            WriteString('LEADINGZEROM', 'FALSE');
            WriteString('MODE', '1');
            WriteString('SEPARATOR', '.');
            WriteString('YEARBIASED', 'TRUE');
            CloseKey;
            OpenKey(Bor + '\Database Engine\Settings\SYSTEM\FORMATS\NUMBER', True);
            WriteString('DECIMALDIGITS', '2');
            WriteString('DECIMALSEPARATOR', ',');
            WriteString('LEADINGZERON', 'TRUE');
            WriteString('THOUSANDSEPARATOR', ' ');
            CloseKey;
            OpenKey(Bor + '\Database Engine\Settings\SYSTEM\FORMATS\TIME', True);
            WriteString('AMSTRING', 'AM');
            WriteString('MILSECONDS', 'FALSE');
            WriteString('PMSTRING', 'PM');
            WriteString('SECONDS', 'TRUE');
            WriteString('TWELVEHOUR', 'TRUE');
            CloseKey;
            OpenKey(Bor + '\Database Engine\Settings\REPOSITORIES', True);
            CloseKey;
            OpenKey(Bor + '\Database Engine\Settings\DRIVERS\PARADOX\INIT', True);
            WriteString('LANGDRIVER', 'ancyrr');
            WriteString('TYPE', 'FILE');
            WriteString('VERSION', '1.0');
            CloseKey;
            OpenKey(Bor + '\Database Engine\Settings\DRIVERS\PARADOX\TABLE
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
      Path := GetExePath(ParamStr(0));
      R := dbiInit(nil);
      if R <> DBIERR_NONE then
        begin
          WriteString('Инициализация BDE ...');
          InstallBDE;
        end;
      R := dbiInit(nil);
      if R = DBIERR_NONE then
        begin
          WriteString('Инициализация BDE прошла успешно');
          DbiDeleteAlias(nil, PChar(AliasName));
          R := DbiAddAlias(nil, PChar(AliasName), szPARADOX,
            PChar('PATH:' + Path + '\DB'), True);
          if R = DBIERR_NONE then
            WriteString('Псевдоним "' + AliasName + '" создан')
          else
            WriteString('Ошибка создания псевдонима "' + AliasName + '"');
          R := DbiCfgSave(nil, nil, Bool(-1));
          if R = DBIERR_NONE then
            WriteString('Файл конфигурации сохранён')
          else
            WriteString('Ошибка сохранения файла конфигурации');
          DbiExit;
        end
      else
        WriteString('Ошибка инициализации BDE');
    end.

