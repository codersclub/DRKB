---
Title: Автозапуск Windows: помещение и удаление програм из автозапуска
Date: 01.01.2007
---


Автозапуск Windows: помещение и удаление програм из автозапуска
===============================================================

::: {.date}
01.01.2007
:::

Вариант 1:

Для этого надо добавить ключ в реестр:

    procedure SetAutorun(aProgTitle,aCmdLine: string; aRunOnce: boolean ); 
    var 
      hKey: string; 
      hReg: TRegIniFile; 
    begin 
      if aRunOnce then hKey := 'Once' 
      else 
        hKey := ''; 
     
      hReg := TRegIniFile.Create( '' ); 
      hReg.RootKey := HKEY_LOCAL_MACHINE; 
      hReg.WriteString('Software\Microsoft\Windows\CurrentVersion\Run' 
                      + hKey + #0, 
                      aProgTitle, 
                      aCmdLine ); 
      hReg.destroy; 
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------
Вариант 2:


    { 
     There's a RunOnce key in the registry. 
     When a user logs on, the programs in the run-once list are run just once, 
     and then the entries will be removed. 
     The "runonce" key is normally used by setup programs to install 
     software after a machine has been rebooted. 
    }
     
     { 
     Jede Anwendung, die im Schlьssel RunOnce aufgefьhrt ist, wird 
     beim nдchsten Windowsstart ausgefьhrt und anschlieЯend wieder 
     aus der Registry entfernt. Betrifft Anwendungen, die nur einmal 
     mit Windows gestartet werden sollen. Normalerweise wird dieser Schlьssel 
     von Setup Programmen genutzt, um nach einem Neustart mit der Installation 
     fortzufahren. 
    }
     
     
     // Add the application to the registry... 
    // Anwendung in die Registry aufnehmen... 
     
    procedure DoAppToRunOnce(RunName, AppName: string);
     var
       Reg: TRegistry;
     begin
       Reg := TRegistry.Create;
       with Reg do
       begin
         RootKey := HKEY_LOCAL_MACHINE;
         OpenKey('Software\Microsoft\Windows\CurrentVersion\RunOnce', True);
         WriteString(RunName, AppName);
         CloseKey;
         Free;
       end;
     end;
     
     // Check if the application is in the registry... 
    // Prьfen, ob Anwendung in der Registry vorhanden ist... 
     
    function IsAppInRunOnce(RunName: string): Boolean;
     var
       Reg: TRegistry;
     begin
       Reg := TRegistry.Create;
       with Reg do
       begin
         RootKey := HKEY_LOCAL_MACHINE;
         OpenKey('Software\Microsoft\Windows\CurrentVersion\RunOnce', False);
         Result := ValueExists(RunName);
         CloseKey;
         Free;
       end;
     end;
     
     // Remove the application from the registry... 
    // Anwendung aus der Registry entfernen... 
     
    procedure DelAppFromRunOnce(RunName: string);
     var
       Reg: TRegistry;
     begin
       Reg := TRegistry.Create;
       with Reg do
       begin
         RootKey := HKEY_LOCAL_MACHINE;
         OpenKey('Software\Microsoft\Windows\CurrentVersion\RunOnce', True);
         if ValueExists(RunName) then DeleteValue(RunName);
         CloseKey;
         Free;
       end;
     end;
     
     { 
      Applications under the key "Run" will be executed 
      each time the user logs on. 
    { 
     
    { 
      Jede Anwendung, die im Schlьssel Run aufgefьhrt ist, wird beim 
      jedem Windowsstart ausgefьhrt. Betrifft Anwendungen, die immer 
      mit Windows gestartet werden sollen... 
    }
     
     
     // Add the application to the registry... 
    // Anwendung in die Registry aufnehmen... 
     
    procedure DoAppToRun(RunName, AppName: string);
     var
       Reg: TRegistry;
     begin
       Reg := TRegistry.Create;
       with Reg do
       begin
         RootKey := HKEY_LOCAL_MACHINE;
         OpenKey('Software\Microsoft\Windows\CurrentVersion\Run', True);
         WriteString(RunName, AppName);
         CloseKey;
         Free;
       end;
     end;
     
     // Check if the application is in the registry... 
    // Prьfen, ob Anwendung in der Registry vorhanden ist... 
     
    function IsAppInRun(RunName: string): Boolean;
     var
       Reg: TRegistry;
     begin
       Reg := TRegistry.Create;
       with Reg do
       begin
         RootKey := HKEY_LOCAL_MACHINE;
         OpenKey('Software\Microsoft\Windows\CurrentVersion\Run', False);
         Result := ValueExists(RunName);
         CloseKey;
         Free;
       end;
     end;
     
     // Remove the application from the registry... 
    // Anwendung aus der Registry entfernen... 
     
    procedure DelAppFromRun(RunName: string);
     var
       Reg: TRegistry;
     begin
       Reg := TRegistry.Create;
       with Reg do
       begin
         RootKey := HKEY_LOCAL_MACHINE;
         OpenKey('Software\Microsoft\Windows\CurrentVersion\Run', True);
         if ValueExists(RunName) then DeleteValue(RunName);
         CloseKey;
         Free;
       end;
     end;
     
     // Examples, Beispiele 
     
    // Add app, Anwendung aufnehmen... 
    DoAppToRun('Programm', 'C:\Programs\XYZ\Program.exe');
     
     // Is app there ? Ist Anwendung vorhanden? 
    if IsAppInRun('Programm') then...
     
     // Remove app, Anwendung entfernen 
    DelAppFromRun('Programm');

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------
Вариант 3:


    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Помещение записи в одну из секций автозапуска реестра
     
    Функция помещает параметр Name и значение параметра Data, в одну из секций
    автозапуска, выбранного раздела реестра.
     
    HkeyTarget:THkeyTarget - указываете раздел реестра, в одну из секций
    автозапуска которого должна быть помещена запись:
    htLocalMachine - раздел HKEY_LOCAL_MACHINE
    htCurrentUser - раздел HKEY_CURRENT_USER
     
    SectionTarget:TSectionTarget - указываете одну из секций автозапуска,
    в которую должна быть помещена запись:
    stRun - секция RUN
    stRunOnce - секция RunOnce
    stRunOnceEx - секция RunOnceEx
     
    Name:String - имя параметра (например, 'myApplication')
     
    Data:String - значение параметра (например, Application.Exename)
     
    Зависимости: windows, registry
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        23 мая 2002 г.
    ***************************************************** }
     
    type
      THKEYTarget = (htLocalMachine, htCurrentUser);
    type
      TSectionTarget = (stRun, stRunOnce, stRunOnceEx);
     
    function StoreToRunSection(HKEYTarget: THKEYTarget;
      SectionTarget: TSectionTarget; Name, Data: string): boolean;
    var
      Reg: TRegistry;
      Section: string;
    begin
      Result := TRUE;
      try
        reg := TRegistry.Create;
        if HKEYTarget = htLocalMachine then
          reg.RootKey := HKEY_LOCAL_MACHINE;
        if HKEYTarget = htCurrentUser then
          reg.RootKey := HKEY_CURRENT_USER;
        if SectionTarget = stRun then
          Section := 'Run';
        if SectionTarget = stRunOnce then
          Section := 'RunOnce';
        if SectionTarget = stRunOnceEx then
          Section := 'RunOnceEx';
        reg.LazyWrite := false;
        reg.OpenKey('Software\Microsoft\Windows\CurrentVersion\' + Section, false);
        reg.WriteString(Name, Data);
        reg.CloseKey;
        reg.free;
      except RESULT := FALSE;
      end;
    end;
     
    // Пример использования:
     
    begin
      StoreToRunSection(htLocalMachine, stRun, 'Имя программы',
        application.exename);
    end;
