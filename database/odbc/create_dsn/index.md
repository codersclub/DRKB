---
Title: Как создать новый DSN из программы?
Author: Vit
Date: 01.01.2007
---


Как создать новый DSN из программы?
===================================

::: {.date}
01.01.2007
:::

    type

     
      TSQLConfigDataSource =
        function(hwndParent: Integer;
        fRequest: Integer;
        lpszDriverString: string;
        lpszAttributes: string): Smallint; stdcall;
     
    function SQLConfigDataSource(hwndParent: Integer; fRequest: Integer;
      lpszDriverString: string; lpszAttributes: string): Integer; stdcall;
    var
      func: TSQLConfigDataSource;
      OdbccpHMODULE: HMODULE;
     
    begin
      OdbccpHMODULE := LoadLibrary('c:\WINDOWS\SYSTEM\odbccp32.dll');
      if OdbccpHMODULE = 0 then raise Exception.Create(SysErrorMessage(GetLastError));
      func := GetProcAddress(OdbccpHMODULE, PChar('SQLConfigDataSource'));
      if @func = nil then
        raise Exception.Create('Error Getting adress for SQLConfigDataSource' +
          SysErrorMessage(GetLastError));
      Result := func(hwndParent, fRequest, lpszDriverString, lpszAttributes);
      FreeLibrary(OdbccpHMODULE);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if SQLConfigDataSource(0, 1, 'Microsoft Excel Driver (*.xls)', Format('DSN=%s;DBQ=%s;DriverID=790', ['MyDSNName', 'c:\temp\temp.xls'])) <> 1 then
        ShowMessage('Cannot create ODBC alias');
    end;

PS. Ecли вы собираетесь работать с этим DSN через BDE, то надо закрыть и
открыть Session, иначе он не будет доступен.

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Автор: Olivio Moura

Этот пример показывает один из способов создания ODBC драйвера для
доступа к файлу Access MDB. Подобная операция применима к большинству
файлов баз данных. Естевственно, Вам потребуется MDB файл, для того,
чтобы связать его с DSN.

    const 
      ODBC_ADD_DSN        = 1;    // Добавляем источник данных 
      ODBC_CONFIG_DSN     = 2;    // Конфигурируем (редактируем) источник данных 
      ODBC_REMOVE_DSN     = 3;    // Удаляем источник данных 
      ODBC_ADD_SYS_DSN    = 4;    // Добавляем системный DSN 
      ODBC_CONFIG_SYS_DSN = 5;    // Конфигурируем системный DSN 
      ODBC_REMOVE_SYS_DSN = 6;    // удаляем системный DSN 
     
    type 
      TSQLConfigDataSource = function( hwndParent: HWND; 
                                       fRequest: WORD; 
                                       lpszDriver: LPCSTR; 
                                       lpszAttributes: LPCSTR ) : BOOL; stdcall; 
     
     
    procedure Form1.FormCreate(Sender: TObject); 
    var 
      pFn: TSQLConfigDataSource; 
      hLib: LongWord; 
      strDriver: string; 
      strHome: string; 
      strAttr: string; 
      strFile: string; 
      fResult: BOOL; 
      ModName: array[0..MAX_PATH] of Char; 
      srInfo : TSearchRec; 
    begin 
      Windows.GetModuleFileName( HInstance, ModName, SizeOf(ModName) ); 
      strHome := ModName; 
      while ( strHome[length(strHome)] <> '\' ) do 
        Delete( strHome, length(strHome), 1 ); 
      strFile := strHome + 'TestData.MDB';   // Тестовая база данных (Axes = Access) 
      hLib := LoadLibrary( 'ODBCCP32' );    // загружаем библиотеку (путь по умолчанию) 
      if( hLib <> NULL ) then 
      begin 
        @pFn := GetProcAddress( hLib, 'SQLConfigDataSource' ); 
        if( @pFn <> nil ) then 
        begin 
          // начинаем создание DSN 
          strDriver := 'Microsoft Access Driver (*.mdb)'; 
          strAttr := Format( 'DSN=TestDSN'+#0+ 
                             'DBQ=%s'+#0+ 
                             'Exclusive=1'+#0+ 
                             'Description=Test Data'+#0+#0, 
                             [strFile] ); 
          fResult := pFn( 0, ODBC_ADD_SYS_DSN, @strDriver[1], @strAttr[1] ); 
          if( fResult = false ) then ShowMessage( 'Ошибка создания DSN (Datasource) !' ); 
     
          // test/create MDB file associated with DSN 
          if( FindFirst( strFile, 0, srInfo ) <> 0 ) then 
          begin 
            strDriver := 'Microsoft Access Driver (*.mdb)'; 
            strAttr := Format( 'DSN=TestDSN'+#0+ 
                               'DBQ=%s'+#0+ 
                               'Exclusive=1'+#0+ 
                               'Description=Test Data'+#0+ 
                               'CREATE_DB="%s"'#0+#0, 
                               [strFile,strFile] ); 
            fResult := pFn( 0, ODBC_ADD_SYS_DSN, @strDriver[1], @strAttr[1] ); 
            if( fResult = false ) then ShowMessage( 'Ошибка создания MDB (файла базы данных) !' ); 
          end; 
          FindClose( srInfo ); 
     
          end; 
     
        FreeLibrary( hLib ); 
      end 
      else 
      begin 
        ShowMessage( 'Невозможно загрузить ODBCCP32.DLL' ); 
      end; 
    end;

Взято из <https://forum.sources.ru>
