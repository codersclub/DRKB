---
Title: Инсталляция / удаление сервисов под NT
Author: Alex Kantchev, stoma@bitex.bg
Date: 19.06.2002
---

Инсталляция / удаление сервисов под NT
======================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Инсталляция/удаление сервисов под НТ.
     
    Функции для создавания и удаления NT Services.
    Можно создать NT Service от текущее приложение.
    Параметры:
      1. CreateNTService(ExecutablePath,ServiceName: String)
         ExecutablePath - Полный путь к изполнимого файла от которого создавается NT Service
         ServiceName - Имя сервиза которое отобразится в Service Control Manager
         Результат:
           true - если операциая завершена успешно
           false - если есть ошибка.
                   Можно произвести call то GetLastError
                   чтобы информироваться об естество ошибки
      2. DeleteNTService(ServiceName: String):boolean;
         ServiceName - имя сервиза подлежающии удаления
         Результат:
           true - если операциая завершена успешно
           false - если есть ошибка. Можно произвести call то GetLastError чтобы 
                   информироваться об естество ошибки
     
    Зависимости: WinSVC, Windows
    Автор:       Alex Kantchev, stoma@bitex.bg
    Copyright:   Собственное написание
    Дата:        19 июня 2002 г.
    ********************************************** }
     
    // CreateNTService(ExecutablePath,ServiceName: String)
    // ExecutablePath - Полный путь к изполнимого файла от 
    // которого создавается NT Service
    // ServiceName - Имя сервиза которое отобразится 
    // в Service Control Manager Результат:
    //Результат:
    // true - если операциая завершена успешно
    // false - если есть ошибка. Можно произвести 
    // call то GetLastError чтобы информироваться об 
    // естество ошибки
    function CreateNTService(ExecutablePath,ServiceName: String):boolean;
    var
     hNewService,hSCMgr: SC_HANDLE;
    // Rights: DWORD;
     FuncRetVal: Boolean;
    begin
     FuncRetVal := False;
     hSCMgr := OpenSCManager(nil,nil,SC_MANAGER_CREATE_SERVICE);
     if (hSCMgr <> 0 ) then
      begin
       //Custom service access rights may be built here
       //we use GENERIC_EXECUTE which is combination of
       //STANDARD_RIGHTS_EXECUTE, SERVICE_START, SERVICE_STOP,
       //SERVICE_PAUSE_CONTINUE, and SERVICE_USER_DEFINED_CONTROL
       //You can create own rights and use them as shown in the
       //commented line below.
     
       //Rights := STANDARD_RIGHTS_REQUIRED or SERVICE_START or SERVICE_STOP
       // or SERVICE_QUERY_STATUS or SERVICE_PAUSE_CONTINUE or
       // SERVICE_INTERROGATE;
     
       hNewService := CreateService(hSCMgr,PChar(ServiceName),PChar(ServiceName),
                                    STANDARD_RIGHTS_REQUIRED,SERVICE_WIN32_OWN_PROCESS,
                                    SERVICE_DEMAND_START,SERVICE_ERROR_NORMAL,
                                    PChar(ExecutablePath),nil,nil,nil,nil,nil);
       CloseServiceHandle(hSCMgr);
       if (hNewService <> 0) then
        FuncRetVal := true
       else
        FuncRetVal := false;
      end;
     CreateNTService := FuncRetVal;
    end;
     
    // ***
     
    //DeleteNTService(ServiceName: String):boolean;
    // ServiceName - имя сервиза подлежающии удаления
    //Результат:
    // true - если операциая завершена успешно
    // false - если есть ошибка. Можно произвести call то GetLastError чтобы 
    // информироваться об естество ошибки
     
    function DeleteNTService(ServiceName: String):boolean;
    var
     hServiceToDelete,hSCMgr: SC_HANDLE;
     RetVal: LongBool;
     FunctRetVal: Boolean;
    begin
     FunctRetVal := false;
     hSCMgr := OpenSCManager(nil,nil,SC_MANAGER_CREATE_SERVICE);
     if (hSCMgr <> 0 ) then
      begin
       hServiceToDelete := OpenService(hSCMgr, PChar(ServiceName), SERVICE_ALL_ACCESS);
       RetVal := DeleteService(hServiceToDelete);
       CloseServiceHandle(hSCMgr);
       FunctRetVal := RetVal;
      end;
       DeleteNTService := FunctRetVal;
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
     tmpS: String;
    begin
       tmpS := 'Delphi_Service_'+Application.Title;
       if (CreateNTService(Application.ExeName,tmpS)) then
         MessageDlg('Service '+tmpS+' has been successfully created!',mtInformation,[mbOK],0)
        else
         MessageDlg('Unable to create service '+tmpS+' Win32 Error code: '+IntToStr(GetLastError),mtWarning,[mbOK],0);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
     tmpS: String;
    begin
     tmpS := 'Delphi_Service_'+Application.Title+'1';
     if (DeleteNTService(tmpS)) then
         MessageDlg('Service '+tmpS+' has been successfully deleted!',mtInformation,[mbOK],0)
     else
         MessageDlg('Unable to delete service '+tmpS+' Win32 Error code: '+IntToStr(GetLastError),mtWarning,[mbOK],0);
    end; 
