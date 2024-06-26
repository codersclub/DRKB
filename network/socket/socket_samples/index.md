---
Title: Примеры работы с socket
Author: Терехов А В. (dark@online.ru)
Date: 12.12.2002
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Примеры работы с socket
=======================


## SocketClient для непродвинутых.

### Вступление

Статья написана для непродвинутых. В ней все объясняется своими словами, поэтому претензии
по правильности изложенного не принимаются.

Итак, что такое сокеты. Сокеты условно можно разделить на две группы: сокет-клиент и сокет-сервер.
Представьте себе электрическую вилку и электрическую розетку. Электрическая вилка - это
сокет-клиент, электрическая розетка - это сокет-сервер. Клиент (электроутюг) просит 
сервер (электроподстанцию), чтобы тот ему что-то дал, в нашем примере электрический ток,
что сервер и делает (если, конечно, ток в сети есть).
Когда вилка вставляется в розетку происходит сокетное соединение. Вот, в принципе, и все.

Задача сокетного соединения - пересылать пакеты с данными между клиентом и сервером. Обработка
этих пактеных данных уже лежит на совести как клиента, так сервера. Это и понятно, утюг
нагревается - он же не холодильник, чтобы охлаждать...

Чтобы не изобретать велосипед, воспользуемся готовым способом
передачи данных по протоколу HTTP. Пока у нас нет своего сервера воспользуемся каким-нибудь готовым
HTTP-сервером, например, Apache или PersonalWebServer. Я пользуюсь замечательным SmallHTTPServer'ом.
Вот ссылка на него <http://home.lanck.net/mf/srv/index.html>.

### Порядок работы

Сначала мы должны создать сокет-клиент, затем сунуть вилку в розетку - 
создать сокетное соединение, отправить пакет данных серверу, получить ответ и обработать его.

Чтобы все это сделать мы должны выполнить ряд действий:

1. [Инициализировать поддержку сокетов в Windows](#Step1) - WSAStartup
2. [Создать свой сокет](#Step2) - socket
3. [Настроить параметры сокета:](#Step3)

     3.1. указать IP-адрес сервера  
     3.2. указать порт (для HTTP-протокола 80-й)  
     3.3. указать способ передачи данных

4. [Соединиться с сервером](#Step4) - connect

5. [Подготовить данные в соответствии с протоколом HTTP](#Step5)

6. [Передать пакет данных серверу](#Step6) - send

7. [Получить ответ от сервера](#Step7) - recv

8. [Обработать полученные данные](#Step8)

9. [Закрыть сокет](#Step9) - closesocket

10. [Уничтожить сокет](#Step10) - WSACleanup

**ВАЖНО.**  
При работе с сокетами используется системная библиотека wsock32.dll.
Для обращения к функциям этой библиотеки существует модуль WinSock, входящий в поставку
Delphi. Поэтому не забудьте указать модуль WinSock в клаузе **Uses**.

### Предварительные шаги

Прежде, чем приступать к программированию клиент-сокета сделаем
несколько предварительных шагов:

1. откроем новый проект;
2. положим на форму два TEdit, одно TMemo и одну TButton
3. создадим новый модуль: File-New-Unit
4. сохраним модуль с названием SocketUnit.pas
5. приведем модуль SocketUnit  в следующий вид:

    ```delphi
    unit SocketUnit;

    interface
    Uses Windows, SysUtils, WinSock;

    Function MyClientSocket:String;
    implementation

    Function MyClientSocket:String;
    Begin
      //писать будем все сюда
    End;

    End.
    ```

6. Вернемся в главную форму и выберем File-UseUnit...-SocketUnit

Теперь можно приступать к сокетам.


<a NAME="Step1"></a>
### Шаг 1. Инициализация сокета Windows

Для инициализации сокета используется функция:

    Function WSAStartUp(wVersionRequested:Word; WSAData:TWSAData):Integer;

VersionRequested - это запрашиваемая версия сокетов

В Windows есть две версии 1.1 и 2.0. Мы будем использовать версию 1.1
Младший байт переменной wVersionRequested должен содержать номер версии (major), 
старший байт - номер расширения версии (minor). Для того чтобы создать нужное
нам значение, воспользуемся функцией:

    wVersionRequested:=MakeWord(1,1);

Второй аргумент функции несколько посложнее. При вызове функции WSAStartUp в этот аргумент
будут возвращены параметры инициализации. На языке Си принято переменные типа запись (Record)
называть структорой, будем придерживать такой же терминологии. Итак WSAData - это структура
следующего типа:

```delphi
TWSAData = Record
  wVersion : Word;
  wHighVersion : Word;
  szDescription : Array [0..WSADESCRIPTION_LEN+1] Of Char; //где WSADESCRIPTION_LEN = 255
  szSystemStatus : Array [0..WSASYS_STATUS_LEN+1] Of Char; //где WSASYS_STATUS_LEN+1 = 127
  MaxSockets : Word;
  MaxUdpDg : Word;
  lpVendor : Word;
End;
```

На самом деле аргумент WSAData нам не нужен, нам важен результат функции. Если результат функции
равен 0, значит все в порядке, иначе - надо искать ошибку с помощью функции WSAGetLastError, которая
вернет код ошибки. Затем код ошибки можно обработать используя Help Win32 Develoer's References
(входит в поставку Delphi).

Напишем первые строчки кода (не забудем о включении в клаузу **Uses**
модуля WinSock):

```delphi
Function MyClientSocket:String;
Var
     wVersionRequested:Word;
     WSAData:TWSAData;
Begin {MyClientSocket}
     wVersionRequested:=MakeWord(1,1); //инициализируем сокет Windows
     FillChar(WSAData,SizeOf(WSAData),#0); //обнулим все значения WSAData
     If Not WSAStartup(wVersionRequested,WSAData)=0 Then //стартуем
     Begin {If Not = 0}
          //неудача при старте
          Result:='';
          WSACleanup; //уничтожим сокет см. [шаг 10](#Step10)
          Exit;
     End;  {If Not = 0}
     WSACleanup; //уничтожим сокет см. [шаг 10](#Step10)
End; {MyClientSocket}
```

Итак, если все в порядке, перейдем к созданию сокета.

<a NAME="Step2"></a>
### Шаг 2. Создание сокета

Для создания сокета используется функция:

    Function socket(af:Integer; struct:Integer; protocol:Integer):TSocket;

где (все константы определены в модуле WinSock):

af - спецификация формата адресов, всегда PF_INET

struct - тип спецификации для нового сокета

- SOCK_STREAM - для TCP-протокола,
- SOCK_DGRAM - для UDP-протокола

protocol - конкретный протокол или 0, если протокол не определен

    IPPROTO_TCP   - TCP/IP протокол
    IPPROTO_UDP   - UDP/IP протокол
    ISOPROTO_TP4  - ISO протокол
    NSPROTO_IPX   - IPX протокол
    NSPROTO_SPX   - SPX протколо
    NSPROTO_SPXII - SPX II протокол

результат функции - в результате возвращается хэндл (описатель) нового сокета или 
INVALID_SOCKET в случае неудачи.

```delphi
Function MyClientSocket:String;
Var
     wVersionRequested:Word;
     WSAData:TWSAData;
     hSocket:TSocket;
Begin {MyClientSocket}
     wVersionRequested:=MakeWord(1,1); //инициализируем сокет Windows
     FillChar(WSAData,SizeOf(WSAData),#0); //обнулим все значения WSAData
     If Not WSAStartup(wVersionRequested,WSAData)=0 Then //стартуем
     Begin {If Not = 0}
          //неудача при старте
          Result:='';
          closesocket(hSocket); //закрыть сокет [см. шаг 9]
          WSACleanup; //уничтожим сокет 
          Exit;
     End;  {If Not = 0}
     hSocket:=socket(PF_INET,SOCK_STREAM,0); //создаем сокет
     If hSocket=INVALID_SOCKET Then
     //неудача при создании сокета
     Begin {INVALID_SOCKET}
          Result:='';
          closesocket(hSocket); //закрыть сокет [см. шаг 9](#Step9)
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {INVALID_SOCKET}
     closesocket(hSocket); //закрыть сокет
     WSACleanup; //уничтожим сокет
End; {MyClientSocket}
```

<a name="Step3"></a>
### Шаг 3. Настройка параметров сокета

Для настройки параметров сокетов используется довольно сложная структура:

```delphi
TSockAddrIn = Record
  sin_family : Word;
  sin_port : Word;
  sin_addr : TInAddr;
  sin_zero : Array [0..7] of Char;
  sa_family : Word;
  sa_data : Array [0..13] Of Char;
End;

TInAddr = Record
  S_un_b : SunB;
  S_un_w : SunW;
  S_addr : Integer;
End;

SunB = Record
  s_b1 : Char;
  s_b2 : Char;
  s_b3 : Char;
  s_b4 : Char;
End;

SunW = Record
  s_w1 : Word;
  s_w2 : Word;
End;
```

Во всей этой сложной структуре пока нас будет интересовать три параметра:

1. `TSockAddrIn.sin_addr.S_addr` - IP-адрес сервера
2. `TSockAddrIn.sin_family` - используемый протокол
3. `TSockAddrIn.sin_port` - используемый порт

Все остальные параметры установим в 0.

Исходные параметры:

1. пока будем работать с сервером, находящимся на локальной машине, поэтому
IP-адрес у нас должен быть такого вида: "127.0.0.1"
2. работать будем по IP-протоколу
3. порт для HTTP-протокола используется 80-й

Прежде всего объявим переменные

```delphi
Var

  name:TSockAddrIn;

  IPAddress:String;
```

Затем надо перевести строку "127.0.0.1" в числовой формат. Для этого существует
специальная функция:

    Function inet_addr(cp:PChar):Integer;

где cp - нужный IP-адрес

```delphi
IPAddress:='127.0.0.1';
name.sin_addr.S_addr:=inet_addr(PChar(IPAddress));
```

Далее указываем по какому протоколу будем работать:

```delphi
name.sin_family:=AF_INET; //для сокетов TCP/IP надо использовать константу AF_INET
```

И последнее, надо указать 80-й порт. Однако порядок старшинства бит, принятый для Интернет,
отличается от порядка старшинства, принятого в Windows. Поэтому придется конвертировать
число 80 в интернет-формат специальной функцией:

```delphi
Function htons(hostshort:Word):Word;

name.sin_port:=htons(80);
```

Теперь наша функция будет выглядеть следующим образом:

```delphi
Function MyClientSocket:String;
Var
     wVersionRequested:Word;
     WSAData:TWSAData;
     hSocket:TSocket;
     IPAddress:String;
Begin {MyClientSocket}
     wVersionRequested:=MakeWord(1,1); //инициализируем сокет Windows
     FillChar(WSAData,SizeOf(WSAData),#0); //обнулим все значения WSAData
     If Not WSAStartup(wVersionRequested,WSAData)=0 Then //стартуем
     Begin {If Not = 0}
          //неудача при старте
          Result:='';
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {If Not = 0}
     hSocket:=socket(PF_INET,SOCK_STREAM,0); //создаем сокет
     If hSocket=INVALID_SOCKET Then
     //неудача при создании сокета
     Begin {INVALID_SOCKET}
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {INVALID_SOCKET}

     IPAddress:='127.0.0.1'; //будем использовать localhost
     name.sin_family:=AF_INET; //укажем тип протокола
     name.sin_addr.S_addr:=inet_addr(PChar(IPAddress)); //укажем IP-адрес
     name.sin_port:=htons(80); //укажем 80-й порт для HTTP-протокола
     closesocket(hSocket); //закрыть сокет
     WSACleanup; //уничтожим сокет
End; {MyClientSocket}
```

<a name="Step4"></a>
### Шаг 4. Соединение с сервером

Для соединения вилки с розеткой используется следующая функция:

    Function connect(hSocket:Integer; Var name:TSockAddrIn;
                     namelen:Integer):Integer;

где:

hSocket - полученый нами ранее хэндл сокета;

name - полученная нами ранее структура с параметрами соединения;

namelen - размер этой струтуры;

результат функции - если все в порядке, то 0, проблемы - SOCKET_ERROR.

Теперь посмотрим полученный код.
К этому времени локальный сервер должен быть уже запущен.

```delphi
Function MyClientSocket:String;
Var
     wVersionRequested:Word;
     WSAData:TWSAData;
     hSocket:TSocket;
     IPAddress:String;
Begin {MyClientSocket}
     wVersionRequested:=MakeWord(1,1); //инициализируем сокет Windows
     FillChar(WSAData,SizeOf(WSAData),#0); //обнулим все значения WSAData
     If Not WSAStartup(wVersionRequested,WSAData)=0 Then //стартуем
     Begin {If Not = 0}
          //неудача при старте
          Result:='';
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {If Not = 0}
     hSocket:=socket(PF_INET,SOCK_STREAM,0); //создаем сокет
     If hSocket=INVALID_SOCKET Then
     //неудача при создании сокета
     Begin {INVALID_SOCKET}
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {INVALID_SOCKET}
     IPAddress:='127.0.0.1'; //будем использовать localhost
     name.sin_family:=AF_INET; //укажем тип протокола
     name.sin_addr.S_addr:=inet_addr(PChar(IPAddress)); //укажем IP-адрес
     name.sin_port:=htons(80); //укажем 80-й порт для HTTP-протокола
     If connect(hSocket,name,SizeOf(name))=SOCKET_ERROR Then //соединяемся с сервером
     Begin {SOCKET_ERROR}
          //неудача при соедении с сервером
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup;
          Exit;
     End;  {SOCKET_ERROR}
     closesocket(hSocket); //закрыть сокет
     WSACleanup; //уничтожим сокет
End; {MyClientSocket}
```

<a name="Step5"></a>
### Шаг 5. Подготовка данных в соотвествии с протоколом HTTP

Пакет с данными для протокола HTTP состоит из двух частей:
заголовка и собственно данных, размер всего пакета должен быть равен 1024 байтам.
В заголовке располагается служебная информация. Заголовок отделяется от данных
двойным #13#10 - конец строки и перевод каретки. Мы будем использовать команду HTTP-протокола
GET. Послав серверу команду GET /index.html HTTP 1.1#13#10#13#10, мы говорим
серверу, чтобы он отправил нам файл index.html из корневой WEB-директории по протоколу HTTP1.1,
если мы напишем GET /cgi-bin/cgi.exe HTTP 1.1, то сервер выполнит CGI-скрипт cgi.exe.

Подготовим новые переменные:

```delphi
Var
  ...
  HTTPAddress:String;
  GetingString:String;
  Buf:Array [0..1023] Of Char;
```

В переменную HTTPAddress поместим адрес нужной страницы или cgi-скрипта,
в GetingString сформируем нужную командную строку и поместим ее в буфер Buf.

```delphi
FillChar(Buf,SizeOf(Buf),#0); //обнулим буфер
HTTPAddress:='/index.html'; //укажем нужную страницу
GetingString:='GET '+HTTPAddress+' HTTP/1.1'#13#10#13#10; //сформируем HTTP-заголовок
StrPCopy(Buf, GetingString); //положим заголовок в буфер
```

<a name="Step6"></a>
### Шаг 6. Передача пакета данных серверу

Для передачи данных используется функция:

    Function send(hSocket:Integer; Var Buf:Untyped, len:Integer; Flags:Integer):Integer;

где:

hSocket - уже знакомый нам хэндл сокета;

Buf - буфер с данными - нетипизированная переменная, т.е. просто набор байтов;

len - длина буфера;

Flags - способ передачи данных, мы этот флаг установим в 0

результат функции - количество переданных байт в случае успеха или SOCKET_ERROR в случае неудачи.

```delphi
Function MyClientSocket:String;
Var
     wVersionRequested:Word;
     WSAData:TWSAData;
     hSocket:TSocket;
     GetingString:String;
     Buf:Array [0..1023] Of Char;
     IPAddress,HTTPAddress:String
Begin {MyClientSocket}
     wVersionRequested:=MakeWord(1,1); *//инициализируем сокет Windows*
     FillChar(WSAData,SizeOf(WSAData),#0);*//обнулим все значения WSAData*
     If Not WSAStartup(wVersionRequested,WSAData)=0 Then*//стартуем*
     Begin {If Not = 0}
          //неудача при старте
          Result:='';
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {If Not = 0}
     hSocket:=socket(PF_INET,SOCK_STREAM,0); //создаем сокет
     If hSocket=INVALID_SOCKET Then
     //неудача при создании сокета
     Begin {INVALID_SOCKET}
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {INVALID_SOCKET}
     IPAddress:='127.0.0.1'; //будем использовать localhost
     name.sin_family:=AF_INET; //укажем тип протокола
     name.sin_addr.S_addr:=inet_addr(PChar(IPAddress)); //укажем IP-адрес
     name.sin_port:=htons(80); //укажем 80-й порт для HTTP-протокола
     If connect(hSocket,name,SizeOf(name))=SOCKET_ERROR Then //соединяемся с сервером
     Begin {SOCKET_ERROR}
     //неудача при соедении с сервером
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup;
          Exit;
     End;  {SOCKET_ERROR}
     FillChar(Buf,SizeOf(Buf),#0); //обнулим буфер
     HTTPAddress:='/index.html'; //укажем нужную страницу
     GetingString:='GET '+HTTPAddress+' HTTP/1.1'#13#10#13#10; //сформируем HTTP-заголовок
     StrPCopy(Buf, GetingString); //положим заголовок в буфер
     If send(hSocket,Buf,SizeOf(Buf), 0)=SOCKET_ERROR Then //передаем данные
     Begin {SOCKET_ERROR}
          //неудача при передаче данных
          Result:='';
          closesocket(hSocket);
          WSACleanup;
          Exit;
     End; {SOCKET_ERROR}
     closesocket(hSocket); //закрыть сокет
     WSACleanup; //уничтожим сокет
End; {MyClientSocket}
```

<a name="Step7"></a>
### Шаг 7. Получение ответа от сервера

Для приема данных используется следующая функция:

    Function recv(hSocket:Integer; Var Buf:Untyped, len:Integer; Flags:Integer):Integer;

где:

hSocket - хэндл сокета;

Buf - буфер с данными;

len - длина буфера;

Flags - способ передачи данных, мы этот флаг установим в 0

результат функции - количество полученных байт в случае успеха или SOCKET_ERROR в случае неудачи.

Для получения данных от сервера напишем небольшой код и определим
еще одну переменную.

```delphi
Var
  ...
  ReciveBytes:Integer;
  ReciveBytes:=1; //инициализируем переменную
//будем принимать данные пока они не закончатся или возникнет ошибка
While Not((ReciveBytes=SOCKET_ERROR) OR (ReciveBytes=0)) Do
//ошибка при приеме данных или нет данных
Begin {SOCKET_ERROR OR нет данных}
     FillChar(Buf,SizeOf(Buf),#0);  //очистим буфер
     ReciveBytes:=recv(hSocket,Buf,SizeOf(Buf),0); //примем данные
     Result:=Result+String(Buf); //сформируем результат
End;   {SOCKET_ERROR OR нет данных}
```

<a name="Step8"></a>
### Шаг 8. Обработка полученных данных

Мы не будем писать свой Web-броузер, поэтому данные будем смотреть
именно в том виде, в котором они пришли. Прежде немного модернизируем функцию вынеся
две переменные IPAddress,HTTPAddress в ее аргументы (не забудьте сделать это и в
объявлении функции и в ее реализации, а также убрать 

```delphi
IPAddress:='127.0.0.1'; и 
HTTPAddress:='/index.html';
```

из реализации функции). Обработку ошибок для наглядности оставим
без изменений.

```delphi
Function MyClientSocket(IPAddress,HTTPAddress:String):String;
Var
     wVersionRequested:Word;
     WSAData:TWSAData;
     hSocket:TSocket;
     GetingString:String;
     Buf:Array [0..1023] Of Char;
     ReciveBytes:Integer;
Begin {MyClientSocket}
     wVersionRequested:=MakeWord(1,1); //инициализируем сокет Windows
     FillChar(WSAData,SizeOf(WSAData),#0); //обнулим все значения WSAData
     If Not WSAStartup(wVersionRequested,WSAData)=0 Then //стартуем
     Begin {If Not = 0}
          //неудача при старте
          Result:='';
          WSACleanup; //уничтожим сокет
          Exit;
     End;  {If Not = 0}
     hSocket:=socket(PF_INET,SOCK_STREAM,0); //создаем сокет
     If hSocket=INVALID_SOCKET Then
     //неудача при создании сокета
     Begin {INVALID_SOCKET}
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup; //уничтожим сокет
          closesocket(hSocket); //закрыть сокет
          Exit;
     End;  {INVALID_SOCKET}
     name.sin_family:=AF_INET; //укажем тип протокола
     name.sin_addr.S_addr:=inet_addr(PChar(IPAddress)); //укажем IP-адрес
     name.sin_port:=htons(80); //укажем 80-й порт для HTTP-протокола
     If connect(hSocket,name,SizeOf(name))=SOCKET_ERROR Then //соединяемся с сервером
     Begin {SOCKET_ERROR}
          //неудача при соедении с сервером
          Result:='';
          closesocket(hSocket); //закрыть сокет
          WSACleanup;
          Exit;
     End;  {SOCKET_ERROR}
     FillChar(Buf,SizeOf(Buf),#0); //обнулим буфер
     GetingString:='GET '+HTTPAddress+' HTTP/1.1'#13#10#13#10; //сформируем HTTP-заголовок
     StrPCopy(Buf, GetingString); //положим заголовок в буфер
     If send(hSocket,Buf,SizeOf(Buf), 0)=SOCKET_ERROR Then //передаем данные
     Begin {SOCKET_ERROR}
          //неудача при передаче данных
          Result:='';
          closesocket(hSocket);
          WSACleanup;
          Exit;
     End; {SOCKET_ERROR}
     ReciveBytes:=1; //инициализируем переменную
     //будем принимать данные пока они не закончатся или возникнет ошибка
     While Not((ReciveBytes=SOCKET_ERROR) OR (ReciveBytes=0)) Do
     //ошибка при приеме данных или нет данных
     Begin {SOCKET_ERROR OR нет данных}
          FillChar(Buf,SizeOf(Buf),#0);  //очистим буфер
          ReciveBytes:=recv(hSocket,Buf,SizeOf(Buf),0); //примем данные
          Result:=Result+String(Buf); //сформируем результат
     End;   {SOCKET_ERROR OR нет данных}
     closesocket(hSocket); //закрыть сокет
     WSACleanup; //уничтожим сокет
End; {MyClientSocket}
```

Теперь вернемся в главную форму и на обытие OnClick кнопки (TButton) укажем следующее:

    Memo1.Text:=MyClientSocket(Edit1.Text,Edit2.Text);

Теперь надо запускать локальный Web-сервер, убедиться в том, что файл index.html существует
и запускать проект.

Если локального сервера нет, можно использовать какой-нибудь Web-сервер в Интернет.
Чтобы посмотреть как перевести доменное имя в IP-адрес обратитесь к [Приложению 1](#Pril1).

<a name="Step9"></a>
### Шаг 9. Закрытие сокета

Каждая попытка создать сокет socket 
должна быть завершена вызовом функции 

    closesocket(hSocket)

где hSocket - хендл сокета.

<a name="Step10"></a>
### Шаг 10. Уничтожение сокета

Каждая попытка инициализировать сокет WSAStartUp 
должна быть завершена вызовом функции WSACleanUp.

<a name="Pril1"></a>
### Приложение 1. Получение IP-адреса из доменного имени

```delphi
Function DomaneNameToIP(DomaneName:String):String;
Type
  TaPInAddr = Array [0..10] Of PInAddr;
  PaPInAddr = ^TaPInAddr;
Var
     phe: PHostEnt;
     pptr: PaPInAddr;
     i: Integer;
     GInitData: TWSADATA;
     wVersionRequested : WORD;
Begin {DomaneNameToIP}
     wVersionRequested:=MakeWord(1,1);
     WSAStartup(wVersionRequested, GInitData);
     Result := '';
     phe :=GetHostByName(PChar(DomaneName));
     If phe = NIL Then Exit;
     pptr := PaPInAddr(Phe^.h_addr_list);
     i := 0;
     While pptr^[i] <> Nil Do
     Begin {While}
          result:=StrPas(inet_ntoa(pptr^[i]^));
          Inc(i);
     End;  {While}

     WSACleanup;
End;   {DomaneNameToIP}
```

<a name="Pril2"></a>
### Приложение 2. Получение доменного имени из IP-адреса

```delphi
Function IpToDomaneName(IP:String):String;
Var
     wVersionRequested : WORD;
     wsaData : TWSAData;
     Addr:Integer;     
     p : PHostEnt;
     Begin {IpToDomaneName}
     Result:='Can''t reslove host';
     wVersionRequested := MAKEWORD(1, 1);
     WSAStartup(wVersionRequested, wsaData);
     Addr:=inet_addr(PChar(IP));
     p := GetHostByAddr(@Addr,128,AF_INET);
     WSACleanup;
     If p<>Nil Then Result:=p^.h_Name;
End;   {IpToDomaneName}
```

Скачать примеры для работы с socket: [socketclient.zip](socketclient.zip)

