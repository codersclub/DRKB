---
Title: Использование компонента TServerSocket
Author: Brian Pedersen
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Использование компонента TServerSocket
======================================

В Delphi документации по многопотоковому TServerSocket налито довольно
много воды, и начинающему программисту сложно понять суть дела. Давайте
попытаемся пролить немного света на этот раздел хелпа.

Совместимость: Delphi 3.x (или выше)

Вообще-то, создать многопотоковый сервер, который ожидает пришедшие
сообщения на сокете довольно просто. В Delphi для этой цели достаточно
использовать компонент TServerSocket.

Давайте рассмотрим структуру работы данного компонента:

- Добавляем TServerSocket в Вашу основную форму.

- Устанавливаем свойство Servertype в stThreadBlocking

- Создаём новый "unit" (показанный ниже) содержащий поток сервера.

Устанавливаем следующий код на OnSocketGetThread

    procedure TfrmMain.fSocketGetThread(Sender: TObject; 
      ClientSocket: TServerClientWinSocket; 
      var SocketThread: TServerClientThread); 
    begin 
      // Здесь создаём объект TServerThread, который я привожу ниже. 
      // Новый объект создаётся каждый раз, когда когда установлен канал связи.  
      SocketThread := TServerThread.Create( FALSE, ClientSocket ); 
    end;

TServerThread - это объект, который я создаю самостоятельно. Объект
наследуется от TServerClientThread и содержит код, который обычно читает
и пишет данные из/в сокет.

Созданный "unit", содержит следующий код:

    unit serverthread; 
     
    interface 
     
    uses 
      windows, scktcomp, SysUtils, Classes, Forms; 
     
    type 
      EServerThread = class( Exception ); 
      // serverthread это потомок TServerClientThread 
      TServerThread = class( TServerClientThread ) 
        private 
          fSocketStream : TWinSocketStream; 
        public 
          procedure ClientExecute; override; 
          // ClientExecute отменяет 
          // TServerClientThread.ClientExecute 
          // и содержит код, который 
          // выполняется при старте потока 
      end; 
     
    implementation 
     
    procedure TServerThread.ClientExecute; 
    begin 
      inherited FreeOnTerminate := TRUE; 
      try 
        fSocketStream := TWinSocketStream.Create( ClientSocket, 
                                                  100000 ); 
        // 100000 - это таймаут в миллисекундах. 
        try 
          while ( not Terminated ) and ( ClientSocket.Connected ) do 
          try 
            // В это место обычно помещается код, 
            // ожидающий входных данных, читающий из сокета или пишущий в него 
            // Пример, приведённый ниже, показывает, что можно добавить в данную 
            // секцию программы. 
          except on e:exception do 
            begin 
              // Если произошла ошибка, то закрываем сокет и выходим 
              ClientSocket.Close; 
              Terminate; 
            end; 
          end; 
        finally 
          fSocketStream.Free; 
        end; 
      except on e:exception do 
        begin 
          // Если произошла ошибка, то закрываем сокет и выходим 
          ClientSocket.Close; 
          Terminate; 
        end; 
      end; 
    end; 

Когда связь установлена, потоку необходимо ожидать входящих
данных(запроса от клиента). Для этого можно использовать следующий код:

    if ( not Terminated ) and 
       ( not fSocketStream.WaitForData( 1000000 ) ) then 
    begin 
      // Обработчик таймаута (т.е. если по истечении 1000000 миллисекунд
      // от клиента не пришло запроса
    end; 
    // В сокете есть входящие данные! 

Для чтения данных, Вам понадобится создать буфер для хранения полученных
данных. Обычно буфер - это PByteArray или массив символов. В этом
примере я обозвал буфер как fRequest который является массивом символов.
Кроме того я ожидаю фиксированное количество байт. Массив имеет
постоянный размер REQUESTSIZE.

    var 
      ac, readlen : integer; 
    begin 
      FillChar( fRequest, REQUESTSIZE, 0 ); 
      ac := 0; 
      repeat 
        readlen := fSocketStream.Read( fRequest[ac], 
                                       1024 ); 
        // считываем блоки по 1024 байт, до тех пор, пока буфер 
        // не заполнится 
        ac := ac+readlen; 
      until ( readlen = 0 ) or ( ac = REQUESTSIZE ); 
    end; 

Если readlen равно 0, значит больше нет входящих данных. Функция Чтения
завершается через 100000 миллисекунд после запуска в
TWinSocketStream.Create(). Если Вы не знаете сколько времени нужно
ожидать запроса от клиента, то чем меньше будет таймаут, тем лучше. В
большинстве случаев максимальный таймаут не должен превышать 30 секунд.

При посылке ответа, Вы должны знать, в каком режиме работает клиент.
Многие клиенты ожидают только один пакет ответа, другие ожидают
несколько пакетов. В этом примере, я подразумеваю клиента, который
ожидает только один пакет, так что я должен послать мои данные назад в
одном блоке:

    fSocketStream.WriteBuffer( fRep, fReplySize );

`fRep` это буфер, содержащий ответ на запрос клиента,  
`fReplySize` - это размер буфера.

