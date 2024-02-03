---
Title: Класс-оболочка для объекта синхронизации WaitableTimer
Date: 01.01.2007
---


Класс-оболочка для объекта синхронизации WaitableTimer
======================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Класс-оболочка для объекта синхронизации WaitableTimer.
     
    Класс представляет собой оболочку для объекта синхронизации WaitableTimer,
    существующего в операционных системах, основанных на ядре WinNT. 
     
    Методы.
    --------------
    Start - запуск таймера.
     
    Stop - остановка таймера.
     
    Wait - ожидает срабатывания таймера заданное количество миллисекунд и
    возвращает результат ожидания.
     
     
    Свойства.
    --------------
    Time : TDateTime - дата/время когда должен сработать таймер.
     
    Period : integer - Период срабатывания таймера. Если значение равно 0, то
    таймер срабатывает один раз, если же значение отлично от нуля, таймер будет
    срабатывать периодически с заданным интервалом, первое срабытывание произойдет
    в момент, заданный свойством Time. 
     
    LongTime : int64 - альтернативный способ задания времени срабатывания. Время
    задается в формате UTC.
     
    Handle : THandle (только чтение) - хендл обекта синхронизации.
     
    LastError : integer (только чтение) - В случае если метод Wait возвращает
    wrError, это свойство содержит значение, возвращаемое функцией GetLastError.
     
    Зависимости: Windows, SysUtils, SyncObjs
    Автор:       vuk
    Copyright:   Алексей Вуколов
    Дата:        25 апреля 2002 г.
    ********************************************** }
     
    unit wtimer;
     
    interface
     
    uses
        Windows, SysUtils, SyncObjs;
     
    type
     
        TWaitableTimer = class( TSynchroObject )
        protected
          FHandle : THandle;
          FPeriod : longint;
          FDueTime : TDateTime;
          FLastError: Integer;
          FLongTime: int64;
        public
     
          constructor Create( ManualReset : boolean;
            TimerAttributes: PSecurityAttributes; const Name : string );
          destructor Destroy; override;
     
          procedure Start;
          procedure Stop;
          function Wait( Timeout : longint ) : TWaitResult;
     
          property Handle : THandle read FHandle;
          property LastError : integer read FLastError;
          property Period : integer read FPeriod write FPeriod;
          property Time : TDateTime read FDueTime write FDueTime;
          property LongTime : int64 read FLongTime write FLongTime;
     
        end;
     
     
     
    implementation
     
     
    { TWaitableTimer }
     
    constructor TWaitableTimer.Create(ManualReset: boolean;
      TimerAttributes: PSecurityAttributes; const Name: string);
    var
       pName : PChar;
    begin
      inherited Create;
      if Name = '' then pName := nil else
        pName := PChar( Name );
      FHandle := CreateWaitableTimer( TimerAttributes, ManualReset, pName );
    end;
     
    destructor TWaitableTimer.Destroy;
    begin
      CloseHandle(FHandle);
      inherited Destroy;
    end;
     
    procedure TWaitableTimer.Start;
    var
       SysTime : TSystemTime;
       LocalTime, UTCTime : FileTime;
       Value : int64 absolute UTCTime;
     
    begin
      if FLongTime = 0 then 
      begin
        DateTimeToSystemTime( FDueTime, SysTime );
        SystemTimeToFileTime( SysTime, LocalTime );
        LocalFileTimeToFileTime( LocalTime, UTCTime );
      end else 
        Value := FLongTime;
      SetWaitableTimer( FHandle, Value, FPeriod, nil, nil, false );
    end;
     
    procedure TWaitableTimer.Stop;
    begin
      CancelWaitableTimer( FHandle );
    end;
     
    function TWaitableTimer.Wait(Timeout: Integer): TWaitResult;
    begin
      case WaitForSingleObjectEx(Handle, Timeout, BOOL(1)) of
        WAIT_ABANDONED: Result := wrAbandoned;
        WAIT_OBJECT_0: Result := wrSignaled;
        WAIT_TIMEOUT: Result := wrTimeout;
        WAIT_FAILED:
          begin
            Result := wrError;
            FLastError := GetLastError;
          end;
      else
        Result := wrError;
      end;
    end;
     
     
    end. 

Пример использования:

Пример создания таймера, который срабатывает по алгоритму "завтра в это
же

время и далее с интервалом в одну минуту".

    var
      Timer : TWaitableTimer;
    ....
    begin
      Timer := TWaitableTimer.Create(false, nil, '');
      Timer.Time := Now + 1; //завтра в это же время
      Timer.Period := 60 * 1000; //Интервал в 1 минуту
      Timer.Start; //запуск таймера
    .... 
