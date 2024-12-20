---
Title: Как показать иконку, ассоциированную с данным типом файла?
Date: 01.01.2007
---

Как показать иконку, ассоциированную с данным типом файла?
==========================================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    uses
      ShellAPI;
    ...
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Icon: hIcon;
      IconIndex: word;
    begin
      IconIndex := 1;
      Icon := ExtractAssociatedIcon(HInstance,
        Application.ExeName, IconIndex);
      DrawIcon(Canvas.Handle, 10, 10, Icon);
    end;

-------------------------------------------------------------

Вариант 2:

Author: Poirot, poirot@rol.ru
Date: 16.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение иконки для зарегистрированного расширения по его имени
     
    Функции в качестве параметра передаётся имя файла и в случае удачного выполнения
    она (функция) возвращает handle-р иконки (HICON). В случае, если в реестре небыло
    найдено расширения предложеного файла, функция возвращает 0.
     
    Также при успешном выполнении необходимо освободить хендлер. Для этого используется
    функция DestroyIcon(Handle:HICON).
     
    Зависимости: модуль Registry, модуль ShellAPI, модуль SysUtils и стандартные
    функции Pos, Delete, Copy, ExtractFileExt, ExtractIcon, StrToInt.
     
    Автор:       Poirot, poirot@rol.ru, Нижний Новгород
    Copyright:   Poirot (частично из Delphi 5. Руководство разработчика)
    Дата:        16 июня 2002 г.
    ***************************************************** }
     
    function GetRegistryIconHandle(FileName: string): HICON;
    var
      R: TRegistry;
      Alias, //псевдвним для расширения в реестре
      IconPath: string; //путь для файла с иконкой
      IconNum, //номер иконки в файле
      QPos: Integer; //позиция запятой в записи реестра
    begin
      IconNum := 0;
     
      R := TRegistry.Create;
     
      try
        R.RootKey := HKEY_CLASSES_ROOT;
     
        //чтение псевданима
        if R.OpenKey('\' + ExtractFileExt(FileName), True) then
          Alias := R.ReadString('');
        R.CloseKey;
     
        //чтение записи об иконке
        if R.OpenKey('\' + Alias + '\DefaultIcon', True) then
          IconPath := R.ReadString('');
        R.CloseKey;
     
        //поиск запятой
        QPos := Pos(',', IconPath);
     
        //чтение номера иконки в файле если она имеется
        if QPos <> 0 then
        begin
          IconNum := StrToInt(Copy(IconPath, QPos + 1, 4));
          IconPath := Copy(IconPath, 1, QPos - 1)
        end;
     
      finally
        R.Free;
      end;
     
      //передача хендлера иконки как рещультат выполнения
      Result := ExtractIcon(hInstance, PChar(IconPath), IconNum);
    end;

Пример использования: 

    GetRegistryIconHandle('c:\winnt\win.ini');

------------------------------------------------------------------------

Вариант 3:

Author: Дмитрий Баранов, kda@pisem.net
Date: 20.05.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение системной иконки, ассоциированной с файлом в данной системе
     
    Функция позволяет получить такую же иконку любой директории или любого файла,
    какую вы видите в "проводнике". Размеры - 16 * 16 (по умолчанию) или 32 * 32
    (второй параметр - itLarge)
     
    Зависимости: Юниты VCL + ComObj, ActiveX, ShellApi, ShlObj;
    Автор:       Дмитрий Баранов, kda@pisem.net, Москва
    Copyright:   Взято из MSDN
    Дата:        20 мая 2002 г.
    ***************************************************** }
     
    type
      TIconType = (itSmall, itLarge);
     
    function GetIcon(const FileName: string; const IconType: TIconType = itSmall):
      TIcon;
    var
      FileInfo: TShFileInfo;
      ImageList: TImageList;
      IT: DWORD;
    begin
      // CoInitialize; лучше - поместите вызов этой ф. в раздел initialization
      IT := SHGFI_SMALLICON;
      Result := TIcon.Create;
      ImageList := TImageList.Create(nil);
      if (IconType = itLarge) then
      begin
        IT := SHGFI_LARGEICON;
        ImageList.Height := 32;
        ImageList.Width := 32;
      end;
      FillChar(FileInfo, Sizeof(FileInfo), #0);
      ImageList.ShareImages := true;
      ImageList.Handle := SHGetFileInfo(
        PChar(FileName),
        SFGAO_SHARE,
        FileInfo,
        sizeof(FileInfo),
        IT or SHGFI_SYSICONINDEX
        );
      ImageList.GetIcon(FileInfo.iIcon, Result);
      ImageList.Free;
      { Не забывайте освободить полученную иконку }
    end;
    Пример использования: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Icon: TIcon;
    begin
      Self.Icon := GetIcon('C:\');
    end;

