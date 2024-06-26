---
Title: Модуль для принятия и отправления длинных блоков данных
Date: 02.10.2002
author: Егоров Виктор aka Subfire, subfire@mail.ru
---


Модуль для принятия и отправления длинных блоков данных
=======================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Процедуры передачи и приема длинных блоков данных, с учетом фрагментации и возможной слепки пакетов. На компоненты TServerSocket,TClientSocket ..SendText
     
    Данный модуль содержит функции, которые позволяет принимать и отправлять длинные блоки данных.
    В код встрена автоматическая обработка фрагментации и слепки пакетов.
    Данные процелуры предназначены для передачи текстовых строк, и используют методы SendText, ReciveText TCustomSocket и предназначены для использования с компонентами TClientSocket, TServerSocket и других производных от TCustomSocket.
    Данные решение отличается простотой использования, скоростью обработки и надежностью:
    тестировалось посылкой блоков данных размером 1-16000, было обработано 15100 блоков данных. Последующее сравнение отправленнх и полученных данных показало отсутвие каких либо ошибок при передачи, сборки и фрагментации данных.
     
    Перед использованием нужно приготовить пользовательскую процедуру, которая будет вызываться каждый раз, когда получен очередной БЛОК данных. Данная процедура должна иметь ОДИН входной параметр типа STRING:
     
    procedure SomeUserProc(S:String);
    begin
    ....
    end;
     
    Модуль содержит 3 функции, из которых пользьзователю нужны только 2
    function SendLongText(Socket:TCustomWinSocket; S:String):boolean;
    function ReceiveLongText(Socket:TCustomWinSocket;MySProc:TMySProc;SafeCalledStr :string = ''):boolean;
    Фунция SendText служит для отправки пакетов. В качестве параметров ей пердается объект TCustomWinSocket (например это ClientSocket.Socket) и собственно отправляемя строка S (ShortString,AnsiString,WideString).
    В случае успешной отправки функция возвращает true, иначе false. Для обработки используйте GetLastError().
     
    function ReceiveLongText(Socket:TCustomWinSocket;MySProc:TMySProc;SafeCalledStr :string = ''):boolean;
    Используется для получения. Даннах фунция должна быть вызвана в событии On*Read компонента. В качестве параметров необходимо передать TCustomWinSocket (например ServerSocket.Socket) и имя процедуры, назначенной для обработки данных (например, ранее приготовленная SomeUserProc). Третий параметр ЗАПОЛНЯТЬ НЕ СЛЕДУЕТ!!!
    Процедура FlushBuffers является внутренней и очищает буфер приема, и напрямую пользователем вызываться не должна.
     
    Зависимости: ScktComp;
    Автор:       Subfire, subfire@mail.ru, ICQ:55161852, Санкт-Петербург
    Copyright:   Егоров Виктор aka Subfire
    Дата:        2 октября 2002 г.
    ********************************************** }
     
    unit LongDataTransfer;
     
    interface
    uses ScktComp;
    Type TMySProc = procedure(const S:AnsiString);
    function SendLongText(Socket:TCustomWinSocket; S:String):boolean;
    function ReceiveLongText(Socket:TCustomWinSocket;MySProc:TMySProc;SafeCalledStr :string = ''):boolean;
     
    var
      InputBuf : String;
      InputDataSize : LongWord;
      InputReceivedSize : LongWord;
     
    implementation
    
    function SendLongText(Socket:TCustomWinSocket; S:String):boolean;
    Var TextSize:integer;
        TSSig : string[4];
    begin
      Result:=True;
      Try
        If not Socket.Connected then Exit;
        TextSize:=Length(S);
        asm
                mov EAX,TextSize;
                mov dword ptr TSSig[1],EAX;
                mov byte ptr TSSig[0],4;
         
        end;
        S:=String(TSSig+S);
        Socket.SendBuf(Pointer(S)^,Length(S));
        except Result:=False;
      end;
    end;
     
    procedure FlushBuffers;
    begin
      InputBuf:='';
      InputDataSize:=0;
      InputReceivedSize:=0;
    end;
     
    function ReceiveLongText(Socket:TCustomWinSocket;MySProc:TMySProc;SafeCalledStr :string = ''):boolean;
    var
      S:String;
      RDSize:LongWord;
      F:String[4];
    begin
      Result:=True;
      try
        If SafeCalledStr='' then begin
          RDSize:=Socket.ReceiveLength;
          S:=Socket.ReceiveText;
        end
        else begin
          S:=SafeCalledStr;
          RDSize:=length(S);
        end;
        If (Length(InputBuf)<4) and (Length(InputBuf)>0) then begin //Корректировка, в том случае
          S:=InputBuf+S; //если фрагментирован сам заголовок 
          FlushBuffers; //блока данных
        end;
        If InputBuf='' then
        begin //Самый первый пакет;
          F:=Copy(S,0,4);
          asm
                  mov EAX,dword ptr F[1];
                  mov InputDataSize,EAX;
          end;
     
          if InputDataSize=RDSize-4 then begin //Один блок в пакете
            InputBuf:=Copy(S,5,RDSize-4); //ни слепки, ни фрагментации нет.
            MySProc(InputBuf);
            FlushBuffers;
            Exit;
          end;
     
          if InputDataSize<RDSize-4 then begin //Пакет слеплен.
            InputBuf:=Copy(S,5,InputDataSize);
            MySProc(InputBuf);
            Delete(S,1,InputDataSize+4);
            FlushBuffers;
            ReceiveLongText(Socket,MySProc,S);
            Exit;
          end;
     
          if InputDataSize>RDSize-4 then begin //это ПЕРВЫЙ фрагмент
            InputBuf:=Copy(S,5,RDSize-4); //большого пакета
            InputReceivedSize:=RDSize-4;
          end;
        end
        else begin //Буфер приема не пуст
          //InputBuf:=
          If RDSize+InputReceivedSize=InputDataSize then
          begin //Получили последний
            InputBuf:=InputBuf+Copy(S,0,RDSize); //фрагмент целиком
            MySProc(InputBuf); //в пакете, данных
            FlushBuffers; // в пакете больше нет
            Exit;
          end;
          If RDSize+InputReceivedSize<InputDataSize then // Получили
          begin //очередной
            InputBuf:=InputBuf+Copy(S,0,RDSize); //фрагмент
            InputReceivedSize:=InputReceivedSize+RDSize;
            Exit;
          end;
          If RDSize+InputReceivedSize>InputDataSize then //Поледний фрагмент
          begin // но в пакете есть еще данные - слеплен. 
            InputBuf:=InputBuf+Copy(S,0,InputDataSize-InputReceivedSize);
            MySProc(InputBuf);
            Delete(S,1,InputDataSize-InputReceivedSize);
            FlushBuffers;
            ReceiveLongText(Socket,MySProc,S);
          end;
        end;
        except Result:=False;
      end;
    end;
     
    end. 

Пример использования:

    .....
    Procedure DataProcessing(S:String); //Эта процедура будет обрабатывать 
    begin //полученные данные, и
      ShowMessage(S); //автоматически вызывается каждый 
    end; //при получении нового блока данных.
     
    //Процедура отправки - по нажатию кнопки отправляем через компонент
    //ClientSocket три строки.
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      SendLongText(ClientSocket.Socket,'Первая строчка!');
      SendLongText(ClientSocket.Socket,'Вторая строчка!');
      SendLongText(ClientSocket.Socket,'Третья строчка! Все три показаны по отдельности!!!');
    end;
     
    //Процедура ServerSocket OnClientRead содержит одну строчку
    //вызова ReceiveLongText, передавая ей в качесте параметра
    //имя вашей процедуры обработки.
    procedure TForm1.ServerSocketClientRead(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      ReceiveLongText(Socket,DataProcessing);
    end;
     
    // И все!!! Не правда ли просто? :) Если у вас есть какие-либо вопросы, 
    // комментарии, замечания, bug reports - пишите на subfire@mail.ru 
