---
Title: Создание новой MS Access базы данных
Author: Vit
Date: 01.01.2007
---


Создание новой MS Access базы данных
====================================

Вариант 1.

Приведенная ниже процедура создает пустую базу данных MS Access

    procedure CreateMSAccessDatabase(filename: string);
     
    var DAO: Variant;
      i: integer;
    const Engines: array[0..2] of string = ('DAO.DBEngine.36', 'DAO.DBEngine.35', 'DAO.DBEngine');
     
      function CheckClass(OLEClassName: string): boolean;
      var Res: HResult;
      begin
        Result := CoCreateInstance(ProgIDToClassID(OLEClassName), nil, CLSCTX_INPROC_SERVER or CLSCTX_LOCAL_SERVER, IDispatch, Res) = S_OK;
      end;
    begin
      for i := 0 to 2 do
        if CheckClass(Engines[i]) then
          begin
            DAO := CreateOleObject(Engines[i]);
            DAO.Workspaces[0].CreateDatabase(filename, ';LANGID=0x0409;CP=1252;COUNTRY=0', 32);
            exit;
          end;
      raise Exception.Create('DAO engine could not be initialized');
    end;

Кусочек кода, который должен распознавать какая версия DAO установлена
на компьютере мной не мог быть оттестирован, так как только одна
работающая версия DAO может быть установлена на компьютере. У меня
установлен Office XP (DAO36) и на нем все работает нормально. Интересно
было бы узнать работает ли логика для Office 2000 (DAO35) и Office 97
(DAO30)

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Вариант 2.

Вот функция OP, которая сделает это за вас:

    procedure CreateMSAccessDB(filename: string);
    var
      DBEngine, Workspace: Variant;
    const
      {Important to use the following constant as is}
      dbLangGeneral = '';
      LANGID = 0x0409;
      CP = 1252;
      COUNTRY = '0';
      dbVersion30 = 32;
    begin
      DBEngine := CreateOleObject('DAO.DBEngine');
      {DBEngine := CreateOleObject('DAO.DBEngine.35'); For DAO 3.5}
      Workspace := DBEngine.Workspaces[0];
      try
        Workspace.CreateDatabase(filename, dbLangGeneral, dbVersion30);
      except
        on EOleException do
          ShowMessage('Database already exists');
      end;
    end;

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Вариант 3.

Создать пустую базу данных доступа (файл *.mdb) с помощью OLE очень просто.
Нет необходимости устанавливать MS-Access на ваш компьютер.
Если возникнет исключение, будет возвращено сообщение об ошибке.
После создания БД вы можете создавать таблицы с помощью простых операторов SQL.

    uses comobj, sysutils;
     
    function CreateAccessDatabase(FileName: string): string;
    var
      cat: OLEVariant;
    begin
      result := '';
      try
        cat := CreateOleObject('ADOX.Catalog');
        cat.create('Provider=Microsoft.Jet.OLEDB.4.0;Data Source=' + Filename + ';');
        cat := NULL;
      except
        on e: Exception do
          result := e.message;
      end;
    end;

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Вариант 4.

    const
      CLASS_DBEngine: TGUID = '{00000100-0000-0010-8000-00AA006D2EA4}';
      dbLangCyrillic = ';LANGID=0x0409;CP=1252;COUNTRY=0';
      dbOption       =     0
    //                  or $20 // ? похоже создание в формате Access 97
                    ;
     
    procedure CreateMSAccessDatabase(FileName :String);
    begin
      Variant(CreateOleObject(ClassIDToProgID(CLASS_DBEngine)))
        .Workspaces[0]
          .CreateDatabase (FileName, dbLangCyrillic, dbOption);
    end;

Author: Петрович

Source: <https://forum.sources.ru>
