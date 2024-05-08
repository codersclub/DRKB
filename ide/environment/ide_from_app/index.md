---
Title: Работа с IDE из программы
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Работа с IDE из программы
=========================

Вот подпрограммы, работающие у меня в связке D1 и Win 3.1x:

    function LaunchedFromDelphiIDE: Boolean;
    {----------------------------------------------------------------}
    { Осуществляем проверку запущенности приложения из-под Delphi    }
    { IDE. Идея взята из сообщения в Delphi-Talk от Ed Salgado       }
    { из Eminent Domain Software.                                    }
    {----------------------------------------------------------------}
     
    begin
      LaunchedFromDelphiIDE := Bool(PrefixSeg) {т.е. не DLL} and
      Bool(PWordArray(MemL[DSeg: 36])^[8]);
    end; {LaunchedFromDelphiIDE}
     
    function DelphiLoaded: Boolean;
    {----------------------------------------------------------------}
    { Проверяем, загружена ли Delphi. Дает правильные результаты     }
    {  - если вызывающее приложение запущено отдельно, или из-под IDE}
    {  - если Delphi имеет открытый проект                           }
    {  - если Delphi минимизирована.                                 }
    { Автор идеи Wade Tatman (wtatman@onramp.net).                   }
    {----------------------------------------------------------------}
     
    begin
      DelphiLoaded := false;
      if WindowExists('TPropertyInspector', 'Object Inspector') then
        if WindowExists('TMenuBuilder', 'Menu Designer') then
          if WindowExists('TAppBuilder', '(AnyName)') then
            if WindowExists('TApplication', 'Delphi') then
              if WindowExists('TAlignPalette', 'Align') then
                DelphiLoaded := true;
    end; {DelphiLoaded}
     
    function DelphiInstalled: Boolean;
    {----------------------------------------------------------------}
    { Проверяем наличие Delphi.ini, ищем в нем путь к Библиотеке     }
    { Компонентов, после чего проверяем ее наличие по этому пути.    }
    {----------------------------------------------------------------}
     
    var
      IniFile: string;
    begin
      DelphiInstalled := false;
      IniFile := WindowsDirectory + '\Delphi.ini';
      if FileExists(IniFile) then
        if FileExists(GetIni(IniFile, 'Library', 'ComponentLibrary')) then
          DelphiInstalled := true;
    end; {DelphiInstalled}
     
    Я уверен, что один из приведенных выше методов вам поможет.Последние две
      подпрограммы используют некоторые другие инкапсуляции Windows API и классов
      Delphi, и они определены следующим образом:
     
    function WindowExists(WindowClass, WindowName: string): Boolean;
    {----------------------------------------------------------------}
    { С помощью паскалевских строк проверяем наличие определенного   }
    { окна. Для поиска только имени окна (WindowName), используем    }
    { WindowClass '(AnyClass)'; для поиска только класса окна        }
    { (WindowClass), используем WindowName '(AnyName)'.              }
    {----------------------------------------------------------------}
     
    var
      PWindowClass, PWindowName: PChar;
      AWindowClass, AWindowName: array[0..63] of Char;
    begin
      if WindowClass = '(AnyClass)' then
        PWindowClass := nil
      else
        PWindowClass := StrPCopy(PChar(@AWindowClass), WindowClass);
     
      if WindowName = '(AnyName)' then
        PWindowName := nil
      else
        PWindowName := StrPCopy(PChar(@AWindowName), WindowName);
     
      if FindWindow(PWindowClass, PWindowName) <> 0 then
        WindowExists := true
      else
        WindowExists := false;
    end; {WindowExists}
     
    function WindowsDirectory: string;
    {----------------------------------------------------------------}
    { Возвращаем путь к каталогу Windows (без обратной косой черты)  }
    {----------------------------------------------------------------}
     
    const
      BufferSize = 144;
    var
      ABuffer: array[0..BufferSize] of Char;
    begin
      if GetWindowsDirectory(PChar(@ABuffer), BufferSize) = 0 then
        WindowsDirectory := ''
      else
        WindowsDirectory := StrPas(PChar(@ABuffer));
    end; {WindowsDirectory}
     
    function GetIni(const IniFile, Section, Entry: string): string;
    {----------------------------------------------------------------}
    { Получаем инициализационную 'profile' строку из определенного   }
    { пункта (Entry) определенной секции [Section] определенного     }
    { INI-файла (дополняем '.ini', если отсутствует). Возвращаем     }
    { нулевую строку, если IniFile, Section или Entry не найден.     }
    {----------------------------------------------------------------}
     
    var
      IniFileVar: string;
      IniFileObj: TIniFile;
    begin
      if StrEndsWith(IniFile, '.ini') then
        IniFileVar := IniFile
      else
        IniFileVar := IniFile + '.ini';
      IniFileObj := TIniFile.Create(IniFileVar);
      GetIni := IniFileObj.ReadString(Section, Entry, '');
      IniFileObj.Free;
    end; {GetIni}

