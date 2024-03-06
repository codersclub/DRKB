---
Title: Отладка приложений с технологией dbExpress
Date: 01.01.2007
---


Отладка приложений с технологией dbExpress
==========================================

Наряду с обычными методами отладки исходного кода, в dbExpress
существует возможность контроля запросов, проходящих на сервер через
соединение. Для этого используется компонент TSQLMonitor.

Через свойство

    property SQLConnection: TSQLConnection;

компонент связывается с отлаживаемым соединением. Затем компонент
включается установкой Active = True.

Теперь во время выполнения приложения сразу после открытия соединения
свойство

    property TraceList: TStrings;

будет заполняться информацией обо всех проходящих командах. Содержимое
этого списка можно сохранить в файле при помощи метода

    procedure SaveToFile(AFileName: string);

Эту же информацию можно автоматически добавлять в текстовый файл,
определяемый свойством

     property FileName: string;

но только тогда, когда свойство

    property AutoSave: Boolean;

будет иметь значение True. Свойство

    property MaxTraceCount: Integer;

определяет максимальное число контролируемых команд, а также управляет
процессом контроля. При значении -1 ограничения снимаются, а при
значении 0 контроль останавливается. Текущее число проверенных команд
содержится в свойстве

    property TraceCount: Integer;

Перед записью команды в список вызывается метод-обработчик

    TTraceEvent = procedure(Sender: TObject; CBInfo: pSQLTRACEDesc;
        var LogTrace: Boolean) of object; 

    property OnTrace: TTraceEvent;

а сразу после записи в список вызывается

    TTraceLogEvent = procedure (Sender: TObject; CBInfo: pSQLTRACEDesc) 
                     of object;

    property OnLogTrace: TTraceLogEvent;

Таким образом, разработчик получает компактный и симпатичный компонент,
позволяющий без усилий получать информацию о прохождении команд в
соединении.

Если же компонент TSQLMonitor не подходит, можно воспользоваться методом

    procedure SetTraceCallbackEvent(Event: TSQLCallbackEvent;
                                    IClientlnfo: Integer);

компонента TSQLConnection. Параметр процедурного типа Event определяет
функцию, которая будет вызываться при выполнении каждой команды.
Параметр iclientinfo должен содержать любое число.

Он позволяет разработчику самостоятельно определить функцию типа
TSQLCallbackEvent:

    TRACECat = TypedEnum;

    TSQLCallbackEvent = function(CallType: TRACECat; CBInfo: Pointer):
                        CBRType; stdcall;

Эта функция будет вызываться каждый раз при прохождении команды. Текст
команды будет передаваться в буфер CBInfo. Разработчику необходимо лишь
выполнить запланированные действия с буфером внутри функции.

Рассмотрим в качестве примера следующий исходный код.

```sql
function GetTracelnfо(CallType: TRACECat; CBInfo: Pointer):
                      CBRType;stdcall;
begin
  if Assigned(Forml.TraceList) then Forml.TraceList.Add(pChar(CBinfo));
end;

procedure TForml.MyConnectionBeforeConnect(Sender: TObject);
begin
  TraceList := TStringList.Create; 
end;

procedure TForml.MyConnectionAfterDisconnect(Sender: TObject);
begin
  if Assigned(TraceList) then
  begin
    TraceList.SaveToFile('с:\Temp\TraceInfo.txt');
    TraceList.Free;
  end;
end;

procedure TForml.StartBtnClick(Sender: TObject);
begin
  MyConnection.SetTraceCallbackEvent(GetTracelnfo, 8);
  MyConnection.Open;
  {...}
  MyConnection.Close;
end;
```


Перед открытием соединения в методе-обработчике BeforeConnection
создается объект типа TStringList. После закрытия соединения этот объект
сохраняется в файле и уничтожается.

Перед открытием соединения (метод-обработчик нажатия кнопки Start) при
помощи метода SetTraceCallbackEvent с соединением связывается функция
GetTracelnfo.

Таким образом, по мере прохождения команд информация о них будет
накапливаться в списке. После закрытия соединения список сохраняется в
текстовом файле.

**Примечание **

В своей работе компонент TSQLMonitor также использует вызовы метода
SetTraceCallbackEvent. Поэтому одновременно применять компонент и
собственные функции нельзя.
