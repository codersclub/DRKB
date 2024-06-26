---
Title: 12. Обработчики ввода/вывода (IOHandlers)
Date: 12.12.2006
Author: Анатолий Подгорецкий
---


12\. Обработчики ввода/вывода (IOHandlers)
============

Статья [Indy in depth. Глубины Indy](./)

**Indy.  
Taming Internet development one protocol at a time.**

Copyright Atozed Software

Indy is Copyright (c) 1993 - 2002, Chad Z. Hower (Kudzu)  
and the Indy Pit Crew - <https://www.nevrona.com/Indy/>

&copy; Анатолий Подгорецкий, 2006, перевод на русский язык

 



Indy может настраиваться и расширяться многими путями, без необходимости
напрямую модифицировать исходный код. Примером такой расширяемости
являются обработчики ввода/вывода (_IOHandlers_). Обработчики ввода/вывода
позволяют вам использовать любой источник ввода/вывода I/O в Indy.
Обработчики ввода/вывода должны использоваться, когда вы желаете
использовать альтернативный механизм ввода/вывода или создание нового
транспортного механизма.

Обработчики ввода/вывода выполняют весь ввод/вывод (Input/Output) для
Indy. Indy не выполняет ни какого своего ввода/вывода, за пределами
обработчика ввода/вывода. Обработчик ввода/вывода используется для
посылки сырых TCP данных для компонент Indy.

Обработчики ввода/вывода позволяют классам обрабатывать весь ввод/вывод
в Indy. Обычно, весь ввод/вывод делается через сокет и обслуживается
обработчиком по умолчанию -  TIdIOHandlerSocket.

Каждый TCP клиент имеет свойство IOHandler, которое может быть назначено
обработчику IOHandler, как это делает каждое серверное соединение. Если
обработчик IOHandler не указан, то неявно используется
TIdIOHandlerSocket, который создается автоматически и используется TCP
клиентом. TIdIOHandlerSocket реализует ввод/вывод используя TCP сокет.
Indy также включает дополнительные обработчики ввода/вывода:
TIdIOHandlerStream и TIdSSLIOHandlerSocket.

Другие обработчики ввода/вывода могут быть созданы, позволяя Indy
использовать любые источники ввода/вывода, которые вы только можете
вообразить. В данный момент Indy поддерживает только сокеты, потоки и
SSL как источники ввода/вывода, но источники ввода/вывода позволяют и
другие возможности. Пока нет других планов, но обработчики ввода/вывода
могут быть созданы для поддержки туннелей, IPX/SPX, RS-232, USB или
Firewire. Indy не ограничивает вас в выборе вашего источника
ввода/вывода и использование обработчиков ввода/вывода позволяет это
сделать.

### 12.1. Компоненты IOHandler

#### 12.1.1. Компонент TIdIOHandlerSocket

Компонент TIdIOHandlerSocket это обработчик IOHandler по умолчанию. Если
обработчик не указан явно, то он создается неявно для вас. Компонент
TIdIOHandlerSocket обрабатывает весь ввод/вывод, относящийся к TCP
сокетам.

Обычно, компонент TIdIOHandlerSocket не используется явно, пока не
потребуются расширенные способности.

#### 12.1.2. Компонент TIdIOHandlerStream

Компонент TIdIOHandlerStream используется для отладки и тестирования.
При его использовании все взаимодействие с сервером в TCP сессии может
быть записаны. Позже вся сессия может быть «проиграна». Компоненты Indy
не знают, работают ли они с реальным сервером и реальным соединением.

Это очень мощное средство отладки в дополнение к инструменту QA отладки.
Если у пользователя есть проблемы, то специальная версия программы может
быть послана пользователю или включены средства отладки для ведения лога
сессии. Используя лог файлы, вы можете затем реконструировать сессию
пользователя в локальной отладочной среде.

#### 12.1.3. Компонент TIdSSLIOHandlerSocket

Компонент TIdSSLIOHandlerSocket используется для поддержки SSL. Обычно
компрессия и декомпрессия данных может быть реализована с использованием
перехватчиков (`Intercepts`) вместо IOHandlers. Но SSL библиотека
используемая Indy (OpenSSL), работает напрямую с сокетом, вместо
трансляции данных посылаемых Indy.  Поэтому реализация выполнена как
IOHandler. . TIdSSLIOHandlerSocket является наследником
TIdIOHandlerSocket.

### 12.2. Пример - Speed Debugger

Пример Speed Debugger демонстрирует как симулировать медленное
соединение. Это полезно, как для отладки, так и для тестирования ваших
приложений при симуляции медленных сетей, таких как модемы.

Пример Speed Debugger состоит из главной формы и пользовательского
обработчика IOHandler. Speed Debugger использует компонент «маппированый
порт» для передачи данных конкретному web серверу. Браузер соединяется
со Speed Debugger и Speed Debugger пробует получить  страницу с
указанного web сервера, затем возвращает ее web браузеру замедленно, с
указанной скоростью.

Поле текстового ввода используется для указания web сервера.

_**Примечание:** не указывайте URL и не указывайте протокол http:// или web
страницу. Оно предназначено только для указания имени сервера или его IP
адреса. Если у вас есть локальный web сервер, то вы можете просто
указать 127.0.0.1 и использовать локальный web сервер._

Комбо-бокс используется для выбора скорости и состоит из следующих
выборов. Симулируемая скорость указывается в скобках.

- Apache (Unlimited)
- Dial Up (28.8k baud)
- IBM PC XT (9600 baud)
- Commodore 64 (2400 baud)
- Microsoft IIS on a PIII-750 & 1GB RAM (300 baud) _(Боже как же он его ненавидит! :-))_

После нажатия кнопки Test - Speed Debugger загружает браузер по
умолчанию с URL http://127.0.0.1:8081/. В данном случае браузер делает
запрос из Speed Debugger. Speed Debugger слушает на порту 8081, который
может конфликтовать с некоторым существующими локальными web серверами.

Пример Speed Debugger может быть загружен с Indy Demo Playground.

#### 12.2.1. Пользовательский обработчик IOHandler

Работа Speed Debugger делается на основе пользовательского IOHandler.
Маппированый порт  компонент имеет событие OnConnect, и данное событие
используется как хук в нашем IOHandler для каждого исходящего клиента,
который создает маппированый порт. Это выглядит так:

    procedure TformMain.IdMappedPortTCP1Connect(AThread: TIdMappedPortThread);
    var
      LClient: TIdTCPConnection;
      LDebugger: TMyDebugger;
    begin
      LClient := AThread.OutboundClient;
      LDebugger := TMyDebugger.Create(LClient);
      LDebugger.BytesPerSecond := GSpeed;
      LClient.IOHandler := LDebugger;
    end;


Пользовательский класс IOHandler, называется TMyDebugger и реализован
как наследник от TIdIOHandlerSocket, являющегося наследником IOHandler.
Поскольку TIdIOHandlerSocket уже реализует весь актуальный ввод/вывод,
TMyDebugger должен только замедлить передачу данных. Это делается путем
перекрытия метода Recv.

Из метода Recv вызывается наследованный Recv для приема данных. Затем,
базируясь на выбранном ограничении скорости, рассчитывается необходимая
задержка. Если рассчитанная величина больше, чем наследованная, то
метод  Recv вызывает Sleep. Это может казаться сложным, но на самом деле
это очень просто. Метод  Recv приведен ниже.

    function TMyDebugger.Recv(var ABuf; ALen: integer): integer;
    var
      LWaitTime: Cardinal;
      LRecvTime: Cardinal;
    begin
      if FBytesPerSecond > 0 then 
      begin
        LRecvTime := IdGlobal.GetTickCount;
        Result := inherited Recv(ABuf, ALen);
        LRecvTime := GetTickDiff(LRecvTime, IdGlobal.GetTickCount);
        LWaitTime := (Result * 1000) div FBytesPerSecond;
        if LWaitTime > LRecvTime then 
        begin
          IdGlobal.Sleep(LWaitTime – LRecvTime);
        end;
      end 
      else 
      begin
        Result := inherited Recv(ABuf, ALen);
      end;
    end;

