<h1>Программирование серверов на основе сокетов в Delphi</h1>
<div class="date">01.01.2007</div>


<p>Данная статья посвящена созданию приложений архитектуры клиент/сервер в Borland Delphi на основе сокетов ("sockets" - гнезда). В отличие от предыдущей статьи на тему сокетов, здесь мы разберем создание серверных приложений.</p>
<p>Следует сразу заметить, что для сосуществования отдельных приложений клиента и сервера не обязательно иметь несколько компьютеров. Достаточно иметь лишь один, на котором Вы одновременно запустите и сервер, и клиент. При этом нужно в качестве имени компьютера, к которому надо подключиться, использовать хост-имя localhost или IP-адрес - 127.0.0.1.</p>
<p>Итак, начнем с теории. Если Вы убежденный практик (и в глаза не можете видеть всяких алгоритмов), то Вам следует пропустить этот раздел.</p>
<p>Алгоритм работы сокетного сервера</p>
<p>Что же позволяет делать сокетный сервер?.. По какому принципу он работает?.. Сервер, основанный на сокетном протоколе, позволяет обслуживать сразу множество клиентов. Причем, ограничение на их количество Вы можете указать сами (или вообще убрать это ограничение, как это сделано по умолчанию). Для каждого подключенного клиента сервер открывает отдельный сокет, по которому Вы можете обмениваться данными с клиентом. Также отличным решением является создание для каждого подключения отдельного процесса (Thread).</p>

<p>Ниже следует примерная схема работы сокетного сервера в Дельфи-приложениях:</p>

<img src="/pic/clip0002.png" width="162" height="50" border="0" alt="clip0002"><img src="/pic/clip0003.png" width="50" height="50" border="0" alt="clip0003"><img src="/pic/clip0007.png" width="162" height="50" border="0" alt="clip0007"><img src="/pic/clip0006.png" width="50" height="50" border="0" alt="clip0006"><img src="/pic/clip0008.png" width="162" height="50" border="0" alt="clip0008"><img src="/pic/clip0009.png" width="50" height="50" border="0" alt="clip0009"><img src="/pic/clip0010.png" width="162" height="50" border="0" alt="clip0010"><img src="/pic/clip0005.png" width="50" height="50" border="0" alt="clip0005"><img src="/pic/clip0011.png" width="162" height="50" border="0" alt="clip0011"></p>

<p>Разберем схему подробнее:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Определение св-в Port и ServerType - чтобы к серверу могли нормально подключаться клиенты, нужно, чтобы порт, используемый сервером точно совпадал с портом, используемым клиентом (и наоборот). Свойство ServerType определяет тип подключения (подробнее см.ниже);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Открытие сокета - открытие сокета и указанного порта. Здесь выполняется автоматическое начало ожидания подсоединения клиентов (Listen);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Подключение клиента и обмен данными с ним - здесь подключается клиент и идет обмен данными с ним. Подробней об этом этапе можно узнать ниже в этой статье и в статье про сокеты (клиентская часть);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Отключение клиента - Здесь клиент отключается и закрывается его сокетное соединение с сервером;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Закрытие сервера и сокета - По команде администратора сервер завершает свою работу, закрывая все открытые сокетные каналы и прекращая ожидание подключений клиентов.</td></tr></table></div>Следует заметить, что пункты 3-4 повторяются многократно, т.е. эти пункты выполняются для каждого нового подключения клиента.</p>
<p class="note">Примечание: Документации по сокетам в Дельфи на данный момент очень мало, так что, если Вы хотите максимально глубоко изучить эту тему, то советую просмотреть литературу и электронную документацию по Unix/Linux-системам - там очень хорошо описана теория работы с сокетами. Кроме того, для этих ОС есть множество примеров сокетных приложений (правда, в основном на C/C++ и Perl).</p>

<p>Краткое описание компонента TServerSocket</p>
<p>Здесь мы познакомимся с основными свойствами, методами и событиями компонента</p>

<p>Свойства</p>
<p> Socket - класс TServerWinSocket, через который Вы имеете доступ к открытым сокетным каналам. Далее мы рассмотрим это свойство более подробно, т.к. оно, собственно и есть одно из главных. Тип: TServerWinSocket;</p>
<p>ServerType - тип сервера. Может принимать одно из двух значений: stNonBlocking - синхронная работа с клиентскими сокетами. При таком типе сервера Вы можете работать с клиентами через события OnClientRead и OnClientWrite. stThreadBlocking - асинхронный тип. Для каждого клиентского сокетного канала создается отдельный процесс (Thread). Тип: TServerType;</p>
<p>ThreadCacheSize - количество клиентских процессов (Thread), которые будут кэшироваться сервером. Здесь необходимо подбирать среднее значение в зависимости от загруженности Вашего сервера. Кэширование происходит для того, чтобы не создавать каждый раз отдельный процесс и не убивать закрытый сокет, а оставить их для дальнейшего использования. Тип: Integer;</p>
<p>Active - показатель того, активен в данных момент сервер, или нет. Т.е., фактически, значение True указывает на то, что сервер работает и готов к приему клиентов, а False - сервер выключен. Чтобы запустить сервер, нужно просто присвоить этому свойству значение True. Тип: Boolean;</p>
<p>Port - номер порта для установления соединений с клиентами. Порт у сервера и у клиентов должны быть одинаковыми. Рекомендуются значения от 1025 до 65535, т.к. от 1 до 1024 - могут быть заняты системой. Тип: Integer;</p>
<p>Service - строка, определяющая службу (ftp, http, pop, и т.д.), порт которой будет использован. Это своеобразный справочник соответствия номеров портов различным стандартным протоколам. Тип: string;</p>

<p>Методы</p>
<p>Open - Запускает сервер. По сути, эта команда идентична присвоению значения True свойству Active;</p>
<p>Close - Останавливает сервер. По сути, эта команда идентична присвоению значения False свойству Active.</p>

<p>События</p>
<p>OnClientConnect - возникает, когда клиент установил сокетное соединение и ждет ответа сервера (OnAccept);</p>
<p>OnClientDisconnect - возникает, когда клиент отсоединился от сокетного канала;</p>
<p>OnClientError - возникает, когда текущая операция завершилась неудачно, т.е. произошла ошибка;</p>
<p>OnClientRead - возникает, когда клиент передал берверу какие-либо данные. Доступ к этим данным можно получить через пеаедаваемый параметр Socket: TCustomWinSocket;</p>
<p>OnClientWrite - возникает, когда сервер может отправлять данные клиенту по сокету;</p>
<p>OnGetSocket - в обработчике этого события Вы можете отредактировать параметр ClientSocket;</p>
<p>OnGetThread - в обработчике этого события Вы можете определить уникальный процесс (Thread) для каждого отдельного клиентского канала, присвоив параметру SocketThread нужную подзадачу TServerClientThread;</p>
<p>OnThreadStart, OnThreadEnd - возникает, когда подзадача (процесс, Thread) запускается или останавливается, соответственно;</p>
<p>OnAccept - возникает, когда сервер принимает клиента или отказывает ему в соединении;</p>
<p>OnListen - возникает, когда сервер переходит в режим ожидания подсоединения клиентов.</p>

<p>TServerSocket.Socket (TServerWinSocket)</p>
<p>
<p>Итак, как же сервер может отсылать данные клиенту? А принимать данные? В основном, если Вы работаете через события OnClientRead и OnClientWrite, то общаться с клиентом можно через параметр ClientSocket (TCustomWinSocket). Про работу с этим классом можно прочитать в статье про клиентские сокеты, т.к. отправка/посылка данных через этот класс аналогична - методы (Send/Receive)(Text,Buffer,Stream). Также и при работе с TServerSocket.Socket. Однако, т.к. здесь мы рассматриваем сервер, то следует выделить некоторые полезные свойства и методы:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ActiveConnections (Integer) - количество подключенных клиентов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ActiveThreads (Integеr) - количество работающих процессов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Connections (array) - массив, состоящий из отдельных классов TClientWinSocket для каждого подключенного клиента. Например, такая команда:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ServerSocket1.Socket.Connections[0].SendText('Hello!');</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>отсылает первому подключенному клиенту сообщение 'Hello!'. Команды для работы с элементами этого массива - также (Send/Receive)(Text,Buffer, Stream);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>IdleThreads (Integer) - количество свободных процессов. Такие процессы кэшируются сервером (см. ThreadCacheSize);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>LocalAddress, LocalHost, LocalPort - соответственно - локальный IP-адрес, хост-имя, порт;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>RemoteAddress, RemoteHost, RemotePort - соответственно - удаленный IP-адрес, хост-имя, порт;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Методы Lock и UnLock - соответственно, блокировка и разблокировка сокета.</td></tr></table></div><p>Практика и примеры</p>
<p>А теперь рассмотрим вышеприведенное на конкретном примере. Скачать уже готовые исходники можно, щелкнув здесь.</p>
<p>Итак, рассмотрим очень неплохой пример работы с TServerSocket (этот пример - наиболее наглядное пособие для изучения этого компонента). В приведенных ниже исходниках демонстрируется протоколирование всех важных событий сервера, плюс возможность принимать и отсылать текстовые сообщения:</p>

Пример 1. Протоколирование и изучение работы сервера, посылка/прием сообщений через сокеты. &nbsp; &nbsp; &nbsp; 
<pre>
{... Здесь идет заголовок файла и определение формы TForm1 и ее экземпляра Form1}
 
    {Полный исходник смотри здесь}
 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      {Определяем порт и запускаем сервер}
      ServerSocket1.Port := 1025;
      {Метод Insert вставляет строку в массив в указанную позицию}
      Memo2.Lines.Insert(0,'Server starting');
      ServerSocket1.Open;
    end;
 
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      {Останавливаем сервер}
      ServerSocket1.Active := False;
      Memo2.Lines.Insert(0,'Server stopped');
    end;
 
    procedure TForm1.ServerSocket1Listen(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      {Здесь сервер "прослушивает" сокет на наличие клиентов}
      Memo2.Lines.Insert(0,'Listening on port '+IntToStr(ServerSocket1.Port));
    end;
 
    procedure TForm1.ServerSocket1Accept(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      {Здесь сервер принимает клиента}
      Memo2.Lines.Insert(0,'Client connection accepted');
    end;
 
    procedure TForm1.ServerSocket1ClientConnect(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      {Здесь клиент подсоединяется}
      Memo2.Lines.Insert(0,'Client connected');
    end;
 
    procedure TForm1.ServerSocket1ClientDisconnect(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      {Здесь клиент отсоединяется}
      Memo2.Lines.Insert(0,'Client disconnected');
    end;
 
    procedure TForm1.ServerSocket1ClientError(Sender: TObject;
      Socket: TCustomWinSocket; ErrorEvent: TErrorEvent;
      var ErrorCode: Integer);
    begin
      {Произошла ошибка - выводим ее код}
      Memo2.Lines.Insert(0,'Client error. Code = '+IntToStr(ErrorCode));
    end;
 
    procedure TForm1.ServerSocket1ClientRead(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      {От клиента получено сообщение - выводим его в Memo1}
      Memo2.Lines.Insert(0,'Message received from client');
      Memo1.Lines.Insert(0,'&gt; '+Socket.ReceiveText);
    end;
 
    procedure TForm1.ServerSocket1ClientWrite(Sender: TObject;
      Socket: TCustomWinSocket);
    begin
      {Теперь можно слать данные в сокет}
      Memo2.Lines.Insert(0,'Now can write to socket');
    end;
 
    procedure TForm1.ServerSocket1GetSocket(Sender: TObject; Socket: Integer;
      var ClientSocket: TServerClientWinSocket);
    begin
      Memo2.Lines.Insert(0,'Get socket');
    end;
 
    procedure TForm1.ServerSocket1GetThread(Sender: TObject;
      ClientSocket: TServerClientWinSocket;
      var SocketThread: TServerClientThread);
    begin
      Memo2.Lines.Insert(0,'Get Thread');
    end;
 
    procedure TForm1.ServerSocket1ThreadEnd(Sender: TObject;
      Thread: TServerClientThread);
    begin
      Memo2.Lines.Insert(0,'Thread end');
    end;
 
    procedure TForm1.ServerSocket1ThreadStart(Sender: TObject;
      Thread: TServerClientThread);
    begin
      Memo2.Lines.Insert(0,'Thread start');
    end;
 
    procedure TForm1.Button3Click(Sender: TObject);
     var i: Integer;
    begin
      {Посылаем ВСЕМ клиентам сообщение из Edit1}
      for i := 0 to ServerSocket1.Socket.ActiveConnections-1 do begin
       ServerSocket1.Socket.Connections[i].SendText(Edit1.Text);
      end;
      Memo1.Lines.Insert(0,'&lt; '+Edit1.Text);
    end;
</pre>

<p>Далее мы будем рассматривать уже не примеры, а приемы работы с TServerSocket.</p>

<p>Приемы работы с TServerSocket (и просто с сокетами)</p>
<p>
<p>Хранение уникальных данных для каждого клиента.</p>
<p>Наверняка, если Ваш сервер будет обслуживать множество клиентов, то Вам потребуется хранить какую-либо информацию для каждого клиента (имя, и др.), причем с привязкой этой информации к сокету данного клиента. В некоторых случаях делать все это вручную (привязка к handle сокета, массивы клиентов, и т.д.) не очень удобно. Поэтому для каждого сокета существует специальное свойство - Data. На самом деле, Data - это всего-навсего указатель. Поэтому, записывая данные клиента в это свойство будьте внимательны и следуйте правилам работы с указателями (выделение памяти, определение типа, и т.д.)!</p>
<p>Посылка файлов через сокет.</p>
<p>Здесь мы рассмотрим посылку файлов через сокет (по просьбе JINX-а) :-). Итак, как же послать файл по сокету? Очень просто! Достаточно лишь открыть этот файл как файловый поток (TFileStream) и отправить его через сокет (SendStream)! Рассмотрим это на примере:</p>
<pre>
{Посылка файла через сокет}
  procedure SendFileBySocket(filename: string);
   var srcfile: TFileStream;
  begin
    {Открываем файл filename}
    srcfile := TFileStream.Create(filename,fmOpenRead);
    {Посылаем его первому подключенному клиенту}
    ServerSocket1.Socket.Connections[0].SendStream(srcfile);
    {Закрываем файл}
    srcfile.Free;
  end;
</pre>


<p>Нужно заметить, что метод SendStream используется не только сервером, но и клиентом (ClientSocket1.Socket.SendStream(srcfile))</p>
<p>Почему несколько блоков при передаче могут обьединяться в один</p>
<p>Это тоже по просьбе JINX-а :-). За это ему огромное спасибо! Итак, во-первых, надо заметить, что посылаемые через сокет данные могут не только объединяться в один блок, но и разъединяться по нескольким блокам. Дело в том, что сокет - обычный поток, но в отличие, скажем, от файлового (TFileStream), он передает данные медленнее (сами понимаете - сеть, ограниченный трафик, и т.д.). Именно поэтому две команды:</p>
<p>ServerSocket1.Socket.Connections[0].SendText('Hello, ');</p>
<p>ServerSocket1.Socket.Connections[0].SendText('world!');</p>
<p>совершенно идентичны одной команде:</p>
<p>ServerSocket1.Socket.Connections[0].SendText('Hello, world!');</p>
<p>И именно поэтому, если Вы отправите через сокет файл, скажем, в 100 Кб, то тому, кому Вы посылали этот блок, придет несколько блоков с размерами, которые зависят от трафика и загруженности линии. Причем, размеры не обязательно будут одинаковыми. Отсюда следует, что для того, чтобы принять файл или любые другие данные большого размера, Вам следует принимать блоки данных, а затем объединять их в одно целое (и сохранять, например, в файл). Отличным решением данной задачи является тот же файловый поток - TFileStream (либо поток в памяти - TMemoryStream). Принимать частички данных из сокета можно через событие OnRead (OnClientRead), используя универсальный метод ReceiveBuf. Определить размер полученного блока можно методом ReceiveLength. Также можно воспользоваться сокетным потоком (см. статью про TClientSocket). А вот и небольшой примерчик (приблизительный):</p>

<pre>
{Прием файла через сокет}
  procedure TForm1.ClientSocket1Read(Sender: TObject;
    Socket: TCustomWinSocket);
   var l: Integer;
       buf: PChar;
       src: TFileStream;
  begin
    {Записываем в l размер полученного блока}
    l := Socket.ReceiveLength;
    {Заказываем память для буфера}
    GetMem(buf,l+1);
    {Записываем в буфер полученный блок}
    Socket.ReceiveBuf(buf,l);
    {Открываем временный файл для записи}
    src := TFileStream.Create('myfile.tmp',fmOpenReadWrite);
    {Ставим позицию в конец файла}
    src.Seek(0,soFromEnd);
    {Записываем буфер в файл}
    src.WriteBuffer(buf,l);
    {Закрываем файл}
    src.Free;
    {Освобождаем память}
    FreeMem(buf);
  end;
</pre>


<p>Как следить за сокетом</p>
<p>Это вопрос сложный и требует долгого рассмотрения. Пока лишь замечу, что созданный Вашей программой сокет Вы можете промониторить всегда :-). Сокеты (как и большинство объектов в Windows) имеют свой дескриптор (handle), записанный в свойстве Handle. Так вот, узнав этот дескриптор Вы свободно сможете управлять любым сокетом (даже созданным чужой программой)! Однако, скорее всего, чтобы следить за чужим сокетом, Вам придется использовать исключительно функции WinAPI Sockets.</p>

<p>Эпилог</p>
<p>В этой статье отображены основные приемы работы с компонентом TServerSocket в Дельфи и несколько общих приемов для обмена данными по сокетам. Если у Вас есть вопросы - скидывайте их мне на E-mail: snick@mailru.com, а еще лучше - пишите в конференции этого сайта (Delphi. Общие вопросы), чтобы и другие пользователи смогли увидеть Ваш вопрос и попытаться на него ответить!</p>
<p>Карих Николай (Nitro). Московская область, г.Жуковский</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

