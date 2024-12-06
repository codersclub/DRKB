---
Title: Написание сервисов Windows NT на WinAPI
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Написание сервисов Windows NT на WinAPI
=======================================


Причиной написания этой статьи, как ни странно, стала необходимость
написания своего сервиса. Но в Borland\'е решили немного "порадовать"
нас, пользователей Delphi 6 Personal, не добавив возможности создания
сервисов (в остальных версиях Delphi 5 и 6 эта возможность имеется в
виде класса TService). Решив, что еще не все потеряно, взял на проверку
компоненты из одноименного раздела этого сайта. Первый оказался с
многочисленными багами, а до пробы второго я не дошел, взглянув на
исходник - модуль Forms в Uses это не только окошки, но и более 300
килобайт "веса" программы. Бессмысленного увеличения размера не
хотелось и пришлось творить своё.

Так как сервис из воздуха не сотворишь, то мой исходник и эта статья
очень сильно опираются на MSDN.

Итак, приступим к написанию своего сервиса...

Обычный Win32-сервис - это обычная программа. Программу рекомендуется
сделать консольной

    DELPHI MENU | Project | Options.. | Linker
    [X] Generate Console Application

и крайне рекомендуется сделать ее без форм !!!
и удалить модуль Forms из Uses. Рекомендуется потому, что,
во-первых, это окошко показывать не стоит потому, что оно позволит
любому юзеру, прибив ваше окошко прибить и сервис и, во-вторых, конечно
же, размер файла (19Kb против 350 ).

Поэтому удаляем форму

    DELPHI MENU | Project | Remove from project...

Удалив все формы, перейдем на главный модуль проекта,
в котором удаляем текст между begin и end и
Forms из Uses и добавляем Windows и WinSvc.

В результате должно получиться что-то вроде этого

    program Project1;
     
    uses
     Windows,WinSvc;
     
    {$R *.res}
     
    begin
     
    end.

На этом подготовительный этап закончен - начинаем писАть сервис.

**Главная часть программы**

Как уже отмечалось - сервис это обычная программа. Программа в Pascal\'е
находится между begin и end. После запуска нашего сервиса (здесь и далее
под запуском сервиса понимается именно запуск его из Менеджера сервисов,
а не просто запуск exe\'шника сервиса) менеджер сервисов ждет пока наш
сервис вызовет функцию StartServiceCtrlDispatcher.
Ждать он будет недолго - если в нашем exe\'шнике несколько сервисов,
то секунд 30, если один - около секунды,
поэтому помещаем вызов StartServiceCtrlDispatcher поближе к begin.

StartServiceCtrlDispatcher в качестве аргумента требует
\_SERVICE\_TABLE\_ENTRYA, поэтому добавляем в var

    DispatchTable : array[0..кол-во сервисов] of _SERVICE_TABLE_ENTRYA;

и заполняем этот массив (естественно перед вызовом StartServiceCtrlDispatcher).

Т.к. в нашем ехешнике будет 1 сервис, то заполняем его так :

     DispatchTable[0].lpServiceName:=ServiceName;
     DispatchTable[0].lpServiceProc:=@ServiceProc;
     
     DispatchTable[1].lpServiceName:=nil;
     DispatchTable[1].lpServiceProc:=nil;

Советую завести константы ServiceName (имя сервиса)
и ServiceDisplayName (отображаемое имя).

ServiceProc - основная функция сервиса (о ней ниже),
а в функцию мы передаем ее адрес.

В `DispatchTable[кол-во сервисов]` все равно nil - это показывает
функции, что предыдущее поле было последним. У меня получилось так :

    begin
     DispatchTable[0].lpServiceName:=ServiceName;
     DispatchTable[0].lpServiceProc:=@ServiceProc;
     
     DispatchTable[1].lpServiceName:=nil;
     DispatchTable[1].lpServiceProc:=nil;
     
     if not StartServiceCtrlDispatcher(DispatchTable[0])
      then LogError('StartServiceCtrlDispatcher Error');
    end.

StartServiceCtrlDispatcher выполнится только после того, как все сервисы
будут остановлены.

Функция LogError протоколирует ошибки - напишите ее сами.

**Функция ServiceMain**

ServiceMain - основная функция сервиса. Если в ехешнике несколько
сервисов, но для каждого сервиса пишется своя ServiceMain функция. Имя
функции может быть любым! и передается в
`DispatchTable.lpServiceProc:=@ServiceMain` (см.предыдущущий абзац).
У меня она называется ServiceProc и описывается так:

    procedure ServiceProc(argc : DWORD;var argv : array of PChar);stdcall;

argc - кол-во аргументов, и их массив argv передаются менеджером сервисов
из настроек сервиса.

**НЕ ЗАБЫВАЙТЕ STDCALL!!!**
Такая забывчивость - частая причина ошибки в программе.

В ServiceMain требуется выполнить подготовку к запуску сервиса и
зарегистрировать обработчик сообщений от менеджера сервисов (Handler).

Опять после запуска ServiceMain и до запуска RegisterServiceCtrlHandler
должно пройти минимум времени. Если сервису надо делать что-нибудь очень
долго и обязательно до вызова RegisterServiceCtrlHandler, то надо
посылать сообщение SERVICE\_START\_PENDING функцией SetServiceStatus.

Итак, в RegisterServiceCtrlHandler передаем название нашего сервиса и
адрес функции Handler\'а (см.далее). Далее выполняем подготовку к
запуску и настройку сервиса. Остановимся на настройке поподробнее.

Эта самая настройка

    var ServiceStatus : SERVICE_STATUS;

(`ServiceStatusHandle : SERVICE_STATUS_HANDLE` и `ServiceStatus` надо
сделать глобальными переменными и поместить их выше всех функций).

dwServiceType - тип сервиса:

- SERVICE\_WIN32\_OWN\_PROCESS   - Одиночный сервис
- SERVICE\_WIN32\_SHARE\_PROCESS - Несколько сервисов в одном процессе
- SERVICE\_INTERACTIVE\_PROCESS  - интерактивный сервис (может взаимодействовать с пользователем).

Остальные константы - о драйверах. Если надо - смотрите их в MSDN.

dwControlsAccepted - принимаемые сообщения (какие сообщения мы будем обрабатывать)

- SERVICE\_ACCEPT\_PAUSE\_CONTINUE - приостановка/перезапуск
- SERVICE\_ACCEPT\_STOP            - остановка сервиса
- SERVICE\_ACCEPT\_SHUTDOWN        - перезагрузка компьютера
- SERVICE\_ACCEPT\_PARAMCHANGE     - изменение параметров сервиса без перезапуска (Win2000 и выше)

Остальные сообщения смотрите опять же в MSDN (куда уж без него ;-)

dwWin32ExitCode и dwServiceSpecificExitCode - коды ошибок сервиса. Если
все идет нормально, то они должны быть равны нулю, иначе коду ошибки.

dwCheckPoint - если сервис выполняет какое-нибудь долгое действие при
остановке, запуске и т.д. то dwCheckPoint является индикатором прогресса
(увеличивайте его, чтобы дать понять, что сервис не завис), иначе он
должен быть равен нулю.

dwWaitHint - время, через которое сервис должен послать свой новый
статус менеджеру сервисов при выполнении действия (запуска, остановки и
т.д.). Если dwCurrentState и dwCheckPoint через это кол-во миллисекунд
не изменится, то менеджер сервисов решит, что произошла ошибка.

dwCurrentState - см. где-то здесь Ставим его в SERVICE\_RUNNING, если
сервис запущен.

После заполнения этой структуры посылаем наш новый статус функцией
SetServiceStatus и мы работаем :).

После этого пишем код самого сервиса. Я вернусь к этому попозже.

Вот так выглядит моя ServiceMain :

    procedure ServiceProc(argc : DWORD;var argv : array of PChar);stdcall;
    var
     Status : DWORD;
     SpecificError : DWORD;
    begin
      ServiceStatus.dwServiceType      := SERVICE_WIN32;
      ServiceStatus.dwCurrentState     := SERVICE_START_PENDING;
      ServiceStatus.dwControlsAccepted := SERVICE_ACCEPT_STOP
                                       or SERVICE_ACCEPT_PAUSE_CONTINUE;
      ServiceStatus.dwWin32ExitCode           := 0;
      ServiceStatus.dwServiceSpecificExitCode := 0;
      ServiceStatus.dwCheckPoint              := 0;
      ServiceStatus.dwWaitHint                := 0;
     
      ServiceStatusHandle := RegisterServiceCtrlHandler(ServiceName,@ServiceCtrlHandler);
      if ServiceStatusHandle = 0 then
        WriteLn('RegisterServiceCtrlHandler Error');
     
      Status :=ServiceInitialization(argc,argv,SpecificError);
      if Status <> NO_ERROR then
      begin
        ServiceStatus.dwCurrentState := SERVICE_STOPPED;
        ServiceStatus.dwCheckPoint   := 0;
        ServiceStatus.dwWaitHint     := 0;
        ServiceStatus.dwWin32ExitCode:=Status;
        ServiceStatus.dwServiceSpecificExitCode:=SpecificError;
     
        SetServiceStatus (ServiceStatusHandle, ServiceStatus);
        LogError('ServiceInitialization');
        exit;
       end;
     
       ServiceStatus.dwCurrentState :=SERVICE_RUNNING;
       ServiceStatus.dwCheckPoint   :=0;
       ServiceStatus.dwWaitHint     :=0;
     
       if not SetServiceStatus (ServiceStatusHandle,ServiceStatus) then
       begin
         Status:=GetLastError;
         LogError('SetServiceStatus');
         exit;
       end;
      // WORK HERE 
      //ЗДЕСЬ БУДЕТ ОСНОВНОЙ КОД ПРОГРАММЫ
    end;
     

**Функция Handler**

Функция Handler будет вызываться менеджером сервисов при передаче
сообщений сервису. Опять же название функции - любое. Адрес функции
передается с помощью функции RegisterServiceCtrlHandler (см. выше).
Функция имеет один параметр типа DWORD (Cardinal) - сообщение сервису.
Если в одном процессе несколько сервисов - для каждого из них должна
быть своя функция.

    procedure ServiceCtrlHandler(Opcode : Cardinal);stdcall;

Опять не забываем про stdcall.

Итак, функция получает код сообщения, который мы и проверяем. Начинаем
вспоминать, что мы писали в ServiceStatus.dwControlsAccepted. У меня это
SERVICE\_ACCEPT\_STOP и SERVICE\_ACCEPT\_PAUSE\_CONTINUE, значит, мне
надо проверять сообщения SERVICE\_CONTROL\_PAUSE,
SERVICE\_CONTROL\_CONTINUE, SERVICE\_CONTROL\_STOP и выполнять
соответствующие действия.

Остальные сообщения:

ServiceStatus.dwControlsAccepted - Обрабатываемые сообщения

- SERVICE\_ACCEPT\_PAUSE\_CONTINUE
- SERVICE\_CONTROL\_PAUSE и SERVICE\_CONTROL\_CONTINUE
- SERVICE\_ACCEPT\_STOP
- SERVICE\_CONTROL\_STOP
- SERVICE\_ACCEPT\_SHUTDOWN
- SERVICE\_CONTROL\_SHUTDOWN
- SERVICE\_ACCEPT\_PARAMCHANGE
- SERVICE\_CONTROL\_PARAMCHANGE

Также надо обрабатывать SERVICE\_CONTROL\_INTERROGATE. Что это такое -
непонятно, но обрабатывать надо :) Передаем новый статус сервиса
менеджеру сервисов функцией SetServiceStatus.

Пример функции Handler:

    procedure ServiceCtrlHandler(Opcode : Cardinal);stdcall;
    var
     Status : Cardinal;
    begin
      case Opcode of
      SERVICE_CONTROL_PAUSE    :
        begin
          ServiceStatus.dwCurrentState := SERVICE_PAUSED;
        end;
      SERVICE_CONTROL_CONTINUE :
        begin
          ServiceStatus.dwCurrentState := SERVICE_RUNNING;
        end;
      SERVICE_CONTROL_STOP     :
        begin
          ServiceStatus.dwWin32ExitCode:=0;
          ServiceStatus.dwCurrentState := SERVICE_STOPPED;
          ServiceStatus.dwCheckPoint   :=0;
          ServiceStatus.dwWaitHint     :=0;
     
          if not SetServiceStatus (ServiceStatusHandle,ServiceStatus)
          then begin
            Status:=GetLastError;
            LogError('SetServiceStatus');
            Exit;
          end;
          exit;
        end;
     
      SERVICE_CONTROL_INTERROGATE : ;
      end;
     
      if not SetServiceStatus (ServiceStatusHandle, ServiceStatus)
      then begin
        Status := GetLastError;
        LogError('SetServiceStatus');
        Exit;
      end;
    end;

**Реализация главной функции программы**

В функции ServiceMain (см.там, где отмечено) пишем код сервиса. Так как
сервис обычно постоянно находится в памяти компьютера, то скорее всего
код будет находиться в цикле. Например в таком :

    repeat
      Что-нибудь делаем пока сервис не завершится.
    until ServiceStatus.dwCurrentState = SERVICE_STOPPED;

Но это пройдет если сервис не обрабатывает сообщения приостановки/перезапуска,
иначе сервис никак не прореагирует.

Другой вариант :

    repeat 
      if ServiceStatus.dwCurrentState <> SERVICE_PAUSED
      then чего-то делаем
    until ServiceStatus.dwCurrentState = SERVICE_STOPPED;

 И третий, имхо, самый правильный вариант = использование потока.

Пишем функцию 

    function MainServiceThread(p:Pointer):DWORD;stdcall;
    begin
     // что-то делаем
    end;  

и в ServiceMain создаем поток

    var
      ThID : Cardinal;
     
    hThread:=CreateThread(nil,0,@MainServiceThread,nil,0,ThID);

и ждем его завершения

    WaitForSingleObject(hThread,INFINITE);

закрывая после этого его дескриптор

    CloseHandle(hThread);

При этом hThread делаем глобальной переменной.
Теперь при приостановке сервиса (в Handler) делаем так

    SERVICE_CONTROL_PAUSE    :
      begin
        ServiceStatus.dwCurrentState := SERVICE_PAUSED;
        SuspendThread(hThread); // приостанавливаем поток
      end;

и при возобновлении работы сервиса

    SERVICE_CONTROL_CONTINUE :
      begin
        ServiceStatus.dwCurrentState := SERVICE_RUNNING;
        ResumeThread(hThread); // возобновляем поток
      end;

