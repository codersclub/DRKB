---
Title: Как зарегистрировать свою команду в контекстном меню проводника?
Author: Rouse\_
Date: 01.01.2007
---


Как зарегистрировать свою команду в контекстном меню проводника?
================================================================

::: {.date}
01.01.2007
:::

Для подобных действий пишется маленький комсервер задача которого лишь
реализовать 2 интерфейса IShellExtInit и IContextMenu.
Для чего это делается - операционная система при инициализации меню
проверит твою библиотеку на предмет: поддерживает ли она эти интерфейсы
и если да - то вызовет нужные их методы. Ну а уж при срабатывании данных
методов ты и добавляешь свои пункты меню.

Для облегчения отладки, чтобы библиотека выгружалась сразу же как только
не используется производим следующие действия:

В реестре вот по этому пути
HKEY\_LOCAL\_MASHINE\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Explorer
устанавливаем строковое значение AlwaysUnloadDLL равным "1" (если
такого значения нет, тогда нужно его создать).

Далее пишем код:

вот реализация сервера:

 

    // Test COM Server Shell Context menu extention
     
    library CONTMENU;

     
    uses
      ComServ,
      ContextM in 'ContextM.pas';
     
    exports
      DllGetClassObject,
      DllCanUnloadNow,
      DllRegisterServer,
      DllUnregisterServer;
     
    begin
    end.

    unit ContextM;

     
    interface
     
    uses
      Windows, ActiveX, ComObj, ShlObj;
     
    type
      TContextMenu = class(TComObject, IShellExtInit, IContextMenu)
      private
        FFileName: array[0..MAX_PATH] of Char;
        TmpFileNames:String;
      protected
        { IShellExtInit }
        function IShellExtInit.Initialize = SEIInitialize;
        function SEIInitialize(pidlFolder: PItemIDList; lpdobj: IDataObject;
          hKeyProgID: HKEY): HResult; stdcall;
        { IContextMenu }
        function QueryContextMenu(Menu: HMENU; indexMenu, idCmdFirst, idCmdLast,
          uFlags: UINT): HResult; stdcall;
        function InvokeCommand(var lpici: TCMInvokeCommandInfo): HResult; stdcall;
        function GetCommandString(idCmd, uType: UINT; pwReserved: PUINT;
          pszName: LPSTR; cchMax: UINT): HResult; stdcall;
      end;
     
    resourcestring
      IDC_TEST1 = 'Тестовая строка номер 1';
      IDC_TEST2 = 'Тестовая строка номер 2';
     
    const
      Class_ContextMenu: TGUID = '{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}';
     
    implementation
     
    uses ComServ, SysUtils, ShellApi, Registry, Graphics;
     
    // Тут наше меню инициализируется
    // на вход приходит интерфейс IDataObject из которого мы можем получить
    // список файлов и папок над которыми будут происходить действия
    function TContextMenu.SEIInitialize(pidlFolder: PItemIDList; lpdobj: IDataObject;
      hKeyProgID: HKEY): HResult;
    var
      StgMedium: TStgMedium;
      FormatEtc: TFormatEtc;
      FilesCount,I:Integer;
    begin
     
      if (lpdobj = nil) then
      begin
        Result := E_INVALIDARG;
        Exit;
      end;
     
      with FormatEtc do begin
        cfFormat := CF_HDROP;
        ptd      := nil;
        dwAspect := DVASPECT_CONTENT;
        lindex   := -1;
        tymed    := TYMED_HGLOBAL;
      end;
     
      Result := lpdobj.GetData(FormatEtc, StgMedium);
      if Failed(Result) then Exit;
     
      TmpFileNames := '';
      FilesCount := DragQueryFile(StgMedium.hGlobal, $FFFFFFFF, nil, 0);
      for I:= 0 to FilesCount - 1 do
      begin
        DragQueryFile(StgMedium.hGlobal, I, FFileName, SizeOf(FFileName));
        TmpFileNames := TmpFileNames + '"'+FFileName+'" ';
      end;
      Result := NOERROR;
      ReleaseStgMedium(StgMedium);
    end;
     
    // Создание меню
    // по этому событию мы добавляем новые элементы меню...
    function TContextMenu.QueryContextMenu(Menu: HMENU; indexMenu, idCmdFirst,
              idCmdLast, uFlags: UINT): HResult;
    begin
      Result := MakeResult(SEVERITY_SUCCESS, FACILITY_NULL, 0);
     
      if ((uFlags and $0000000F) = CMF_NORMAL) or
         ((uFlags and CMF_EXPLORE) <> 0) then
      begin
        // Разделитель
        InsertMenu(Menu, indexMenu, MF_SEPARATOR or MF_BYPOSITION, 0, nil);
        // первый пункт меню
        InsertMenu(Menu, indexMenu + 1, MF_STRING or MF_BYPOSITION, idCmdFirst,
          PChar(IDC_TEST1));
        // второй пункт меню
        InsertMenu(Menu, indexMenu + 2, MF_STRING or MF_BYPOSITION, idCmdFirst + 1,
          PChar(IDC_TEST2));
        // разделитель
        InsertMenu(Menu, indexMenu + 3, MF_SEPARATOR or MF_BYPOSITION, 0, nil);
        // указываем сколько пунктов меню мы добавили
        // 2 пункта - т.к. разделители не считаются
        Result := MakeResult(SEVERITY_SUCCESS, FACILITY_NULL, 2);
      end;
    end;
     
    // данная функция срабатывает при нажатии на наш элемент меню
    function TContextMenu.InvokeCommand(var lpici: TCMInvokeCommandInfo): HResult;
    begin
      Result := E_FAIL;
      if (HiWord(Integer(lpici.lpVerb)) <> 0) then Exit;
      Result := NOERROR;
      // Выбор элементов меню идет по возрастающей в том порядке
      // в каком они были добавлены
      case LoWord(lpici.lpVerb) of
      0: // первый элемент меню
         // тут собственно и нужно делать реакцию на нажатие ;)
        MessageBox(lpici.hWnd, PChar(TmpFileNames), PChar(IDC_TEST1 + ' Pressed'), MB_OK);
      1: // второй элемент меню
        MessageBox(lpici.hWnd, PChar(TmpFileNames), PChar(IDC_TEST2 + ' Pressed'), MB_OK);
      else
        Result := E_INVALIDARG;
      end;
    end;
     
    // Данная функция вызывается когда статус бар в эксплорере активен
    // и в нем отображается краткая информация о подсвеченном пункте меню
    function TContextMenu.GetCommandString(idCmd, uType: UINT; pwReserved: PUINT;
      pszName: LPSTR; cchMax: UINT): HRESULT;
    begin
      Result := S_OK;
      if uType = GCS_HELPTEXT then
        case idCmd of
          0:
          begin
            StrCopy(pszName, 'Справочная информация по первому пункту меню');
          end;
          1:
          begin
            StrCopy(pszName, 'Справочная информация по второму пункту меню');
          end
          else
            Result := E_INVALIDARG
        end
    end;
     
    type
      TContextMenuFactory = class(TComObjectFactory)
      public
        procedure UpdateRegistry(Register: Boolean); override;
      end;
     
    // Это процедура которая будет выполнятся при вызове библиотеки из командной строки
    // regsvr32   C:\CONTMENU.dll  - регистрация библиотеки
    // regsvr32   C:\CONTMENU.dll -unregister - снятие библиотеки с регистрации
    procedure TContextMenuFactory.UpdateRegistry(Register: Boolean);
    var
      ClassID: string;
    begin
      if Register then
      begin
        inherited UpdateRegistry(Register);
     
        ClassID := GUIDToString(Class_ContextMenu);
        CreateRegKey('Test\shellex', '', '');
        CreateRegKey('Test\shellex\ContextMenuHandlers', '', '');
        CreateRegKey('Test\shellex\ContextMenuHandlers\ContMenu', '', ClassID);
     
        if (Win32Platform = VER_PLATFORM_WIN32_NT) then
          with TRegistry.Create do
          try
            RootKey := HKEY_LOCAL_MACHINE;
            OpenKey('SOFTWARE\Microsoft\Windows\CurrentVersion\Shell Extensions', True);
            OpenKey('Approved', True);
            WriteString(ClassID, 'Test Context Menu Shell Extension');
          finally
            Free;
          end;
      end
      else
      begin
        DeleteRegKey('Test\shellex\ContextMenuHandlers\ContMenu');
        DeleteRegKey('Test\shellex\ContextMenuHandlers');
        DeleteRegKey('Test\shellex');
        inherited UpdateRegistry(Register);
      end;
    end;
     
    initialization
      TContextMenuFactory.Create(ComServer, TContextMenu, Class_ContextMenu,
        '', 'Test Context Menu Shell Extension', ciMultiInstance,
        tmApartment);
    end.


Вот и все, компилишь этот код и у тебя готовый ком сервер...
Регистрировать билиотеку из своей программы так:

 

    // Установка...

     
    procedure TForm1.btnRegClick(Sender: TObject);
    begin
      with TRegistry.Create do
      try
        RootKey := HKEY_CLASSES_ROOT;
        OpenKey('CLSID\{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}\InprocServer32', True);
        WriteString('','C:\CONTMENU.dll');
        WriteString('ThreadingModel','Apartment');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey('SOFTWARE\Classes\CLSID\{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}\InprocServer32', True);
        WriteString('','C:\CONTMENU.dll');
        WriteString('ThreadingModel','Apartment');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey('SOFTWARE\Microsoft\Windows\CurrentVersion\Shell Extensions\Approved', True);
        WriteString('{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}', 'Test Context Menu Shell Extension');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_CLASSES_ROOT;
        OpenKey('*\shellex\ContextMenuHandlers\Test', True);
        WriteString('','{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_CLASSES_ROOT;
        OpenKey('Folder\shellex\ContextMenuHandlers\Test', True);
        WriteString('','{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}');
        CloseKey;
      finally
        Free;
      end;
    end;
     
     
    а снимать с регистрации вот так:
     
    // Удаление ...
    procedure TForm1.btnUnRegClick(Sender: TObject);
    begin    
      with TRegistry.Create do
      try
        RootKey := HKEY_CLASSES_ROOT;
        OpenKey('CLSID', True);
        DeleteKey('{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey('SOFTWARE\Classes\CLSID', True);
        DeleteKey('{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_LOCAL_MACHINE;
        OpenKey('SOFTWARE\Microsoft\Windows\CurrentVersion\Shell Extensions\Approved', True);
        DeleteValue('{45C15F61-ACAD-48C6-8D86-321ED8A6CFC6}');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_CLASSES_ROOT;
        OpenKey('*\shellex\ContextMenuHandlers', True);
        DeleteKey('Test');
        CloseKey;
      finally
        Free;
      end;
     
      with TRegistry.Create do
      try
        RootKey := HKEY_CLASSES_ROOT;
        OpenKey('Folder\shellex\ContextMenuHandlers', True);
        DeleteKey('Test');
        CloseKey;
      finally
        Free;
      end;
    end;


Если нужно, чтобы пункты меню возникали только для определенных типов
файлов, то при вызове QueryContextMenu нужно проверить какие файлы
находятся в TmpFileNames, если данные типы файлов не подходят, то
выходить из процедуры с результатом

 

    Result := MakeResult(SEVERITY_SUCCESS, FACILITY_NULL, 0);



Взято из <https://forum.sources.ru>

Автор: Rouse\_
