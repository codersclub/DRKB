---
Title: Создание Plug-In в виде COM-Сервера
Date: 01.01.2007
Author: Тенцер А. Л. <tolik@katren.nsk.ru> ICQ UIN 15925834
---


Создание Plug-In в виде COM-Сервера
===================================

Попробуем теперь реализовать Plug-In к своей программе, в виде
COM-сервера и сравним код, полученный в этом случае с кодом, полученным
при «ручном» программировании. В начале создадим модуль с описанием
интерфейсов:

    unit PluginInterface;
     
    interface
     
    const
      Class_TAPI: TGUID = '{A132D1A1-721C-11D4-84DD-E2DEF6359A17}';
     
    type
      IAPI = interface
      ['{64CFF1E0-61A3-11D4-84DD-B18D6F94141F}']
        procedure ShowMessage(const S: String);
      end;
     
     
      ILoadFilter = interface
      ['{64CFF1E1-61A3-11D4-84DD-B18D6F94141F}']
        procedure Init(const FileName: String);
        function GetNextLine(var S: String): Boolean;
      end;
     
    implementation
     
    end.

Обратите внимание, что метод ILoadFilter.Init больше не получает ссылки
на внутренний API программы - он будет реализован в виде COM-объекта.

Создадим DLL c COM-сервером, реализующим ILoadFilter. Для этого создадим
новую ActiveX library и добавим в неё COM-объект TLoadFilter. Установим
ThreadingModel в Single, поскольку использования сервера в потоках не
предполагается. После этого реализуем методы интерфейса ILoadFilter.

    unit Unit3;
     
    interface
     
    uses
      Windows, ActiveX, Classes, ComObj, PluginInterface;
     
    type
      TLoadFilter = class(TComObject, ILoadFilter)
      private
        FAPI: IAPI;
        F: TextFile;
        Lines: Integer;
        InitSuccess: Boolean;
       protected
        procedure Init(const FileName: String);
        function GetNextLine(var S: String): Boolean;
      public
        destructor Destroy; override;
      end;
     
    const
      Class_LoadFilter: TGUID = '{A132D1A2-721C-11D4-84DD-E2DEF6359A17}';
     
     
    implementation
     
    uses ComServ, SysUtils;

Деструктор и метод GetNextLine аналогичны предыдущему примеру:

     
    destructor TLoadFilter.Destroy;
    begin
      if InitSuccess then
        CloseFile(F);
      inherited;
    end;
     
    function TLoadFilter.GetNextLine(var S: String): Boolean;
    begin
      if InitSuccess then begin
        Inc(Lines);
        Result := not Eof(F);
        if Result then begin
          Readln(F, S);
          FAPI.ShowMessage('Загружено ' + IntToStr(Lines) + ' строк.');
        end;
      end else
        Result := FALSE;
    end;

В методе Init имеется существенное отличие - теперь ссылку на
внутреннее API программы мы получаем при помощи COM. Это освобождает нас
от необходимости передавать ссылку в модуль расширения.

    procedure TLoadFilter.Init(const FileName: String);
    begin
      FAPI := CreateComObject(Class_TAPI) as IAPI;
      {$I-}
      AssignFile(F, FileName);
      Reset(F);
      {$I+}
      InitSuccess := IOResult = 0;
      if not InitSuccess then
        FAPI.ShowMessage('Ошибка инициализации загрузки');
    end;

В конце модуля код, автоматически сгенерированный Delphi для создания
фабрики объектов

    initialization
      TComObjectFactory.Create(ComServer, TLoadFilter, Class_LoadFilter,
        'LoadFilter', '', ciMultiInstance, tmSingle);
    end.

Компилируем DLL и регистрируем её при помощи regsvr32.

Поскольку программа может поддерживать множество различных фильтров,
организуем их подключение через INI файл следующего вида:

    [Filters]
    TXT={A132D1A2-721C-11D4-84DD-E2DEF6359A17}

Параметром строки служит CLSID сервера, реализующего фильтр. В нашем
случае это будет содержание константы Class\_LoadFilter. Для подключения
дополнительных фильтров необходимо создать DLL с сервером, реализующим
ILoadFilter, зарегистрировать её в системе и добавить CLSID сервера в
INI-файл.

Теперь можно приступать к написанию программы-клиента. Она аналогична
используемой в предыдущем примере. Добавим в неё COM-сервер, реализующий
внутреннее API.

За исключением кода, сгенерированного COM объект полностью аналогичен
объекту, приведенному ранее. Константу  Class\_TAPI вынесем в модуль
PluginInterface, чтобы сделать её доступной для модулей расширения.

    unit Unit2;
     
    interface
     
    uses
      Windows, ActiveX, Classes, ComObj, PluginInterface;
     
    type
      TTAPI = class(TComObject, IAPI)
      protected
        procedure ShowMessage(const S: String);
      end;
     
    implementation
     
    uses Forms, ComServ, Unit1;
     
    { TTAPI }
     
    procedure TTAPI.ShowMessage(const S: String);
    begin
      (Application.MainForm as TForm1).StatusBar1.SimpleText := S;
    end;
     
    initialization
      TComObjectFactory.Create(ComServer, TTAPI, Class_TAPI,
        'TAPI', '', ciMultiInstance, tmSingle);
    end.
     

Теперь все готово к реализации функциональности клиента. Для экономии
места приведем лишь метод LoadData

    procedure TForm1.LoadData(FileName: String);
    var
      PlugInName: String;
      Filter: ILoadFilter;
      S, Ext: String;
    begin
      Memo1.Lines.Clear;
      Memo1.Lines.BeginUpdate;
      try
        Ext := ExtractFileExt(FileName);
        Delete(Ext, 1, 1);
        with TIniFile.Create(ExtractFilePath(ParamStr(0)) + 'plugins.ini') do
        try
          PlugInName := ReadString('Filters', Ext, '');
        finally
          Free;
        end;
        Filter := CreateComObject(StringToGUID(PlugInName)) as ILoadFilter;
        Filter.Init(FileName);
        while Filter.GetNextLine(S) do
          Memo1.Lines.Add(S);
      finally
        Memo1.Lines.EndUpdate;
      end;
    end;

Очевидно, что код метода стал гораздо короче и читабельнее. COM взял на
себя всю черновую работу по поиску загрузке и выгрузке DLL, поиску и
созданию объектов.

**Внимание!**
Поскольку в EXE и DLL используются длинные строки, не забудьте
включить в список uses обоих проектов модуль ShareMem
