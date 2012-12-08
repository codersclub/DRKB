---
Title: Обмен информацией по TCP/IP-протоколу
Date: 01.01.2007
---


Обмен информацией по TCP/IP-протоколу
=====================================

::: {.date}
01.01.2007
:::

Обмен информацией по TCP/IP-протоколу

© 2004 Рудюк С.А.\

rudjuk.kiev.ua

Часто возникает необходимость обмениваться данными между программами на
разных компьютерах. Например, это необходимо в чатах, или в программах,
которые должны реагировать одновременно на одно и то же событие.

Обмен информации между компьютерами можно реализовать большим
количеством способов. В данной статье я рассмотрю обмен данными по
протоколу TCP/IP.

Компоненты для обмена данными по TCP/IP

Для обмена данными по протоколу TCP/IP будем использовать три
Indy-компоненты:

+-----------------------------------+-----------------------------------+
| TIdTCPServer                      | ![](/pic/embim1778.png){width="33 |
|                                   | "                                 |
|                                   | height="44"}                      |
+-----------------------------------+-----------------------------------+
| TIdTCPClient                      | ![](/pic/embim1779.png){width="29 |
|                                   | "                                 |
|                                   | height="41"}                      |
+-----------------------------------+-----------------------------------+
| TIdThreadMgrDefault               | ![](/pic/embim1780.png){width="10 |
|                                   | 0"                                |
|                                   | height="51"}                      |
+-----------------------------------+-----------------------------------+

Клиентская компонента предназначена для посылки и приёма сообщений, а
серверная компонента - для приёма сообщения и рассылки клиентским
компонентам.

\<\>

Программа состоит из двех частей: серверная, на которой стоит серверная
компонента, можно на неё ещё поставить и клиентскую компоненту - для
тестирования клиентской части и возможности генерации сообщений с
серверной программы. На клиентской части - стоит только клиентская
компонента. Эта часть предназначена только для посылки и приёма
сообщений.

Серверная часть

Установим на форму в программе серверной части компоненты TIdTCPServer
![](/pic/embim1781.png){width="33" height="44"}, TIdThreadMgrDefault
![](/pic/embim1782.png){width="100" height="51"}.

Свяжите свойство ThreadMgr компоненты TIdTCPServer с компонентой
TIdThreadMgrDefault.

Для запуска сервера хватит установить свойство компоненты в True:

    Server.Active := True;
    Protocol.Lines.Add('=== Запуск сервера ====');

Для остановки сервера - в False:

    Server.Active := False;
    Protocol.Lines.Add('=== Сервер остановлен====');

Для регистрагистрации подключенного компьютера следует определить
событие OnConnect в компоненте TIdTCPServer.

    var
    NewClient: PClient;
    begin
    GetMem(NewClient, SizeOf(TClient));
    NewClient.DNS := AThread.Connection.LocalName;
    NewClient.Connected := Now;
    NewClient.LastAction := NewClient.Connected;
    NewClient.Thread := AThread;
    AThread.Data:=TObject(NewClient);
    try
    Clients.LockList.Add(NewClient);
    finally
    Clients.UnlockList;
    end;
    Protocol.Lines.Add(TimeToStr(Time)+' Соединение компьютера: "'+NewClient.DNS+'"');
    end;

Для регистрации отключения клиента необходимо определить событие
ServerDisconnect.

    var
    ActClient: PClient;
    ConnN: integer;
     
    begin
    ActClient := PClient(AThread.Data);
    Protocol.Lines.Add (TimeToStr(Time)+' Отсоединение компьютера: "'+ActClient^.DNS+'"');
    try
    Clients.LockList.Remove(ActClient);
    finally
    Clients.UnlockList;
    end;
    FreeMem(ActClient);
    AThread.Data := nil;
    end;

Обработка команд (рассылка) на серверной части осуществляется с помощью
события OnExecute.

    var
    ActClient, RecClient: PClient;
    CommBlock, NewCommBlock: TCommBlock;
    RecThread: TIdPeerThread;
    i, ConnN: Integer;
    itmp: integer;
     
    begin
    if not AThread.Terminated and AThread.Connection.Connected then
    begin
     
    AThread.Connection.ReadBuffer (CommBlock, SizeOf (CommBlock));
    ActClient := PClient(AThread.Data);
    ActClient.LastAction := Now; // update the time of last action
    // Регистрация компьютера
    if (RusUpperCase(CommBlock.Command) = RusUpperCase(cmRegisterComp)) then
    begin
    Protocol.Lines.Add(' Регистрация компьютера: '+RusUpperCase(CommBlock.ComputerName));
    meConnected.Lines.Add(RusUpperCase(CommBlock.ComputerName));
    RefreshConnected;
    RefreshConnectedComps;
    RefreshGolosProcess;
    // AThread.Connection.WriteBuffer (NewCommBlock, SizeOf (NewCommBlock), true); // and there it goes...
    end
    // Удаление компьютера
    else if (RusUpperCase(CommBlock.Command) = RusUpperCase(cmUnRegisterComp)) then
    begin
    Protocol.Lines.Add(' Удаление компьютера: '+RusUpperCase(CommBlock.ComputerName));ConnN
    :=FindConnComp(RusUpperCase(CommBlock.ComputerName));
    if ConnN<>-1
    then meConnected.Lines.Delete(ConnN);
    RefreshConnected;
    RefreshConnectedComps;
    RefreshGolosProcess;
    // AThread.Connection.WriteBuffer (NewCommBlock, SizeOf (NewCommBlock), true); // and there it goes...
    end
    // Регистрация ответов
    else if (RusUpperCase(CommBlock.Command) = RusUpperCase(cmAnswerQuest)) then
    begin
    if mdGolos.Locate('CompName',RusUpperCase(CommBlock.Msg),[loCaseInsensitive]) then
    begin
    mdGolos.Edit;
    mdGolosCONN.Value:=True;
    mdGolos.Post;
    end;
    RefreshGolosProcess;
    // AThread.Connection.WriteBuffer (NewCommBlock, SizeOf (NewCommBlock), true); // and there it goes...
    end
    // Различные сообщения
    else if (CommBlock.Command = {'MESSAGE'}cmMess) or (CommBlock.Command = 'DIALOG') then
    begin // 'MESSAGE': A message was send - forward or broadcast it
    // 'DIALOG': A dialog-window shall popup on the recipient's screen
    // it's the same code for both commands...
    if CommBlock.ReceiverName = '' then
    begin // no recipient given - broadcast
    Protocol.Lines.Add (TimeToStr(Time)+' Получение сообщения от '
    +CommBlock.MyUserName+' '+CommBlock.Command+': "'+CommBlock.Msg+'"');
    NewCommBlock := CommBlock; // nothing to change ;-))
    with Clients.LockList do
    try
    for i := 0 to Count-1 do // iterate through client-list
    begin
    RecClient := Items[i]; // get client-object
    RecThread := RecClient.Thread; // get client-thread out of it
    RecThread.Connection.WriteBuffer(NewCommBlock, SizeOf(NewCommBlock), True); // send the stuff
    end;
    finally
    Clients.UnlockList;
    end;
    end
    else
    begin // receiver given - search him and send it to him
    NewCommBlock := CommBlock; // again: nothing to change ;-))
    Protocol.Lines.Add(TimeToStr(Time)+' Посылка '+CommBlock.Command+' к "'+CommBlock.ReceiverName+'": "'+CommBlock.Msg+'"');
    with Clients.LockList do
    try
    for i := 0 to Count-1 do
    begin
    RecClient:=Items[i];
    if RecClient.DNS=CommBlock.ReceiverName then // we don't have a login function so we have to use the DNS (Hostname)
    begin
    RecThread:=RecClient.Thread;
    RecThread.Connection.WriteBuffer(NewCommBlock, SizeOf(NewCommBlock), True);
    end;
    end;
    finally
    Clients.UnlockList;
    end;
    end;
    end
    else
    begin // unknown command given
    Protocol.Lines.Add (TimeToStr(Time)+' Unknown command from "'+CommBlock.MyUserName+'": '+CommBlock.Command);
    NewCommBlock.Command := 'DIALOG'; // the message should popup on the client's screen
    NewCommBlock.MyUserName := '[Server]'; // the server's username
    NewCommBlock.Msg := 'I dont understand your command: "'+CommBlock.Command+'"'; // the message to show
    NewCommBlock.ReceiverName := '[return-to-sender]'; // unnecessary
    AThread.Connection.WriteBuffer (NewCommBlock, SizeOf (NewCommBlock), true); // and there it goes...
    end;
    end;
    end;

Здесь я реализовал дополнительную регистрацию компьютера с помощью
команды cmRegisterComp=\'REGISTER\', и дополнительно посылку сообщения,
что компьютер отключился: cmUnRegisterComp=\'UNREGISTER\'.

При передаче сообщения передаётся сообщения типа TCommBlock. Это тип
данных мы можем изменять по необходимости. В данном блоке я объявил
переменную для идентификации ComputerName компьютера.

    TCommBlock = record // the Communication Block used in both parts (Server+Client)
    Command,
    MyUserName, // the sender of the message
    Msg, // the message itself
    ReceiverName: string[100]; // name of receiver
    ComputerName: String[100]; // Название компьютера, посылающего сообщение
    end;

Поле Command - команда, котора посылается с клиентского места.\
MyUserName - имя пользователя, который посылает сообщение.\
Msg - Текст сообщения.\

ReceiverName - название компьютера-получателя сообщения, если это поле
будет пустым, то сообщение будет отправляться всем компьютерам.

Клиентская часть

Через клиентскую компоненту мы можем отправлять сообщения, а так же
получать сообщения от других сообщений.

Установим на форму клиентского приложения компоненту TIdTCPClient
![](/pic/embim1783.png){width="29" height="41"}.

Установим на форму кнопки Подключиться и Отключиться.

Обработчик кнопки Подключиться:

    IncomingMessages.Lines.Add('===Подключение к серверу===');
    Client.Host:=DBInfo.IBaseServerName;
    Client.Connect(10000); // in Indy < 8.1 leave the parameter away
    ClientHandleThread := TClientHandleThread.Create(True);
    ClientHandleThread.Cli:=Client;
    ClientHandleThread.EventMest:=FEventMess;
    ClientHandleThread.Str:=IncomingMessages.Lines;
    ClientHandleThread.FreeOnTerminate:=True;
    ClientHandleThread.Resume;
    RegComp;
    except
    on E: Exception do MessageDlg ('Ошибка подключения:'+#13+E.Message, mtError, [mbOk], 0);
    end; 

В кнопке Отключиться прописываем:

    if Client.Connected then
    begin
    ClientHandleThread.Terminate;
    Client.Disconnect;
    end;

Тип TClientHandleThread предназначен для обработки команд с клиентской
стороны.

    TEvent_Mesto = procedure(Sender: TObject) of object;
    .... 
    TClientHandleThread = class(TThread)
    private
    procedure HandleInput;
    public
    Str: TStrings;
    Cli: TIdTCPClient;
    protected
    procedure Execute; override;
    public
    CB: TCommBlock;
    FEventMest: TEvent_Mesto;
    published
    property EventMest: TEvent_Mesto read FEventMest write FEventMest;
    end;
    .... 
    var
    ClientHandleThread: TClientHandleThread; // variable (type see above)
    ....
    procedure TClientHandleThread.Execute;
    begin
    while not Terminated do
    begin
    if not Cli.Connected then
    Terminate
    else
    try
    Cli.ReadBuffer(CB, SizeOf (CB));
    Synchronize(HandleInput);
    except
    end;
    end;
    end;
    ....
    procedure TClientHandleThread.HandleInput;
    begin
    if Assigned(EventMest) then EventMest(Self);
    // Обработка команд 
    if RusCompare(CB.Command,'MESSAGE') Or (RusCompare(CB.Command,cmdSendPrav)) or (RusCompare(CB.Command, cmdAskPrav)) or
    (RusCompare(CB.Command,cmdNewGame)) or (RusCompare(CB.Command,cmdEndGame)) or
    (RusCompare(CB.Command,cmdNewTur)) or (RusCompare(CB.Command,cmdEndTur)) or
    (RusCompare(CB.Command,cmdRunShellAll)) or (RusCompare(CB.Command,cmdRunShell)) or
    (RusCompare(CB.Command,cmdSendActiveWinAll)) or (RusCompare(CB.Command,cmdSendActiveWin)) or
    (RusCompare(CB.Command,cmdMinimizeWin)) or (RusCompare(CB.Command,cmdMinimizeWinAll)) or
    (RusCompare(CB.Command,cmdCloseWin)) or (RusCompare(CB.Command,cmdCloseWinAll)) or
    (RusCompare(CB.Command,cmdSendUserName)) or (RusCompare(CB.Command,cmdSendPassword)) or
    (RusCompare(CB.Command,cmdNextGolos)) or (RusCompare(CB.Command,cmdGolosSended)) or
    (RusCompare(CB.Command,cmdGolosEkspert)) or (RusCompare(CB.Command,cmdRefreshInfo)) or
    (RusCompare(CB.Command,cmdRefreshInfoAll)) or (RusCompare(CB.Command,cmdSendMessage)) or
    (RusCompare(CB.Command,cmdSendMessageAll)) or (RusCompare(CB.Command,cmdSendMessageAdmin)) or
    (RusCompare(CB.Command,cmdClearMessages)) or (RusCompare(CB.Command,cmdClearMessgesAll)) or
    (RusCompare(CB.Command,cmdReconnected)) or (RusCompare(CB.Command,cmdReconnectedAll))
    or (RusCompare(CB.Command,cmdSetOcenk))
    or RusCompare(CB.Command, cmdRegComp)
     
    then Str.Add (CB.MyUserName + ': ' + CB.Msg)
    else
    if RusCompare(CB.Command,'DIALOG') then
    MessageDlg ('"'+CB.MyUserName+'" посылаем сообение:'+#13+CB.Msg, mtInformation, [mbOk], 0)
    else // unknown command
    MessageDlg('Команда "'+CB.Command+'" содержит это сообщение:'+#13+CB.Msg, mtError, [mbOk], 0);
    end;
    ... 

В процедуре HandleInput перхватываются сообщения. В событии EventMest мы
можем определить процедуру, которая будет выполняться при получении
сообщения.

Помещаем на форму кнопку Послать, поле ввода Сообщение, и список
Команда, где будут перечислены все доступные команды.

В обработчике щелчка кнопки опишем команду посылки сообщения:

    var
    CommBlock : TCommBlock;
     
    begin
    inherited;
    // Команда, которую мы посылаем
    CommBlock.Command := RusUpperCase(EditCommand.Text); 
    // Названеи компьютера 
    CommBlock.MyUserName := Client.LocalName; 
    // Текст сообщения 
    CommBlock.Msg := EditMessage.Text;
    // Название компьютера, которому мы посылаем сообщение 
    CommBlock.ReceiverName := EditRecipient.Text;
    // Название компьютера, который посылает сообщение 
    CommBlock.ComputerName := RusUpperCase(Client.LocalName);
     
    Client.WriteBuffer (CommBlock, SizeOf (CommBlock), true);
    end; 

Copyright© 2004 Рудюк С.А.
