<h1>ICQ2000 &ndash; сделай сам (статья)</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Alexander Vaga</div>
<p>WEB-сайт: http://icq2000cc.hobi.ru</p>
<p>Урок №1</p>
<p>Прежде чем приступить к изложению своего небольшого проектика ... скажу сразу…. написан он на Делфи. Кто огорчится , кто обрадуется. Для кого языковой барьер не помеха, а для кого непреодолимое препятствие. Лично я постигал все перелести протоколов ICQ на кодах написанных на С++. Главное - видеть "главное". А мне нравится Делфи. На нем отправить пакет данных в интернет наверное проще, чем записать его в обычный файл.</p>
<p>Самые общие сведения о протоколахм ICQ</p>
<p>Существует около десятка версий ICQ-клиентов. И у каждого - своя версия протокола. Но не смотря на это, их всего два. Есть ICQ, работа, которых с сервером основана на протоколе UDP, и есть ICQ общающиеся с сервером по протоколу TCP. Немного подробнее:</p>
<p>ICQ на протоколе UDP</p>
<p>С нее, собственно, и начиналась история ICQ.</p>
<p>Это были версии протоколов 1,2,3,4 и 5. Это были аськи ICQ97, ICQ98, ICQ99. Т.к. использован протокол UDP, то постоянного соединения клиент-сервер не существует. Пакет передал. Получил подтверждение, и баста. Не получил подтверждение - передай повторно.</p>
<p>Но об этих протоколах уже можно (и нужно) забыть. Они поддерживаются сервером весьма неохотно, потому, что в какой-то момент компания Mirabilis растворилась в компании America OnLine (AOL). После этого ICQ начала работать на протоколе AOL Instant Messenger (AIM). Это и есть вторая группа протоколов ICQ.</p>
<p>ICQ на протоколе TCP</p>
<p>Это версии протоколов 7,8. А может уже и 9,10,11 и т.д.</p>
<p>По сути дела в ICQ20xx используется протокол от AOL Inastant Messenger. И по этому признаку эти два продукта - родные братья. Хоть я и спользовал информацию по прортоколу v8 (ICQ2000b) но рассматривать буду протокол v7 (ICQ2000a). Потому, что эта версия у меня была установлена и именно ее пакеты я использовал для анализа и отладки своего детища. Это различие не имело ровным счетом никакого значения.</p>
<p>Но, как говорится: "ближе к телу".</p>
<p>Вы вправе задать вопрос: "Как же это все будет выглядеть?"</p>
<p>Это выглядит примерно так.</p>
<p>Сами понимаете, что номера ICQ и имена клиентов - полностью вымышленные. Любые совпадения с реальными людьми - чистая случайность. Конечно же, изображения принадлежат своим уважаемым владельцам, поэтому дальше их и не будет.</p>
<p>Как видно на скриншоте, это не просто аська, а - мультиаська! Т.е. можно находиться в онлайне сразу под несколькими UIN-ами одновременно. Иногда это бывает полезно и даже необходимо. В интернете есть конечно примочки для одновременного запуска нескольких копий ICQ, но ничто так не умиляет, как сделанное своими руками. И все же для понимания работы протокола - это излишество, поэтому я оставил только самое необходимое.</p>
<p>Думаю, что не стоит в самом начале нагружать разными сводными таблицами с описанием пакетов протокола. Я буду делать это по мере необходимости. Тем более, что из всего их множества, поначалу не все они будут и нужны.</p>
<p>Для работы вам потребуются только стандартные компоненты Делфи-5. Нет нужды устанавливать какие-то вспомогательные библиотеки или пакеты.</p>
<p>С помощью моего ICQ-клиента можно:</p>
<p>логиниться к серверу;</p>
<p>отображать состояние клиентов;</p>
<p>передавать и принимать сообщения;</p>
<p>регистрировать (register) новый UIN на сервере;</p>
<p>удалять (unregister) UIN с сервера;</p>
<p>просматривать и обновлять информацию о клиентах из контактного списка;</p>
<p>производить поиск клиентов по имени, по e-mail, по UIN-у;</p>
<p>включать найденных клиентов в контактный список;</p>
<p>вести журнал сообщений и пакетов.</p>
<p>Но изначально приложение будет иметь самую минимальную функциональность. UIN и пароль у вас уже должны быть. Будем логиниться на сервере, менять свой статус, принимать сообщения. Весь TCP-трафик идет только через сервер. Так проще и этот способ в комбинации с некоторыми другими параметрами позволит скрыть ваш IP-адрес от любопытных глаз. Наверное, поэтому я не рассматриваю прямые соединения между клиентами. Разумеется, что будем рассматривать протокол v7. На нем работает ICQ2000a.</p>
<p>Итак, приступим...</p>
<p>Все пакеты данных (и от клиента к серверу, и от сервера к клиенту) упаковываются в т.н. FLAP-протокол. Он находится в самом низу иерархии. Ниже показана структура FLAP-пакета:</p>
<p>FLAP</p>
<p>Command Start byte: $2A</p>
<p>Channel ID byte</p>
<p>Sequence Number word</p>
<p>Data Field Length word</p>
<p>Data variable</p>
<p>Каждый FLAP-пакет имеет заголовок c фиксированной длиной и, следующий за ним блок данных (переменной длины). Длина заголовка равна 6-и байтам.</p>
<p>FLAP-заголовок содержит такие поля:</p>
<p>Однобайтовый идентификатор начала пакета (Command Start). Его значение всегда равно $2A. С ним можно сверяться при приеме пакетов.</p>
<p>Идентификатор канала (Channel ID). Он может принимать четыре значения:</p>
<p>1 - канал установления соединения;</p>
<p>2 - канал обмена данными (основная фаза работы: какие-либо полезные данные передаются только в этой фазе);</p>
<p>3 - канал ошибок. (на практике мне не попадался :);</p>
<p>4 - канал разъединения. (это проще, чем написано).</p>
<p>На 99.9% времени протокол работает в канале 2.</p>
<p>Последовательный номер пакета (Sequence Number). В начале обмена данными это поле устанавливается случайным образом, а затем увеличивается на единицу при передаче каждого последующего пакета. Обычно такие поля используются для обеспечения целостности данных (например, когда используется UDP-протокол). Но в нашем случае используется TCP-соединение и этого вполне достаточно для обеспечения целостности передаваемых пакетов. Просто нужно следовать правилу формирования этого поля при передаче пакетов и можно забыть о нем. (На приеме я его никак не контролировал).</p>
<p>Длина блока данных (Data Field Length). Указывает на длину блока данных, который следует сразу же за заголовком. Это очень важное поле. Зная его, мы знаем сколько данных нужно прочитать из входного потока. Ошибись мы хоть на один байт и синхронизация потока будет нарушена.</p>
<p>Блок данных FLAP-пакета. Его длина указана в FLAP-заголовке. В нем находится вся полезная информация для обмена ICQ-клиента и сервера.</p>
<p>При приеме (обработке) FLAP-пакетов очень важно не потерять синхронизацию пакетов ( что просто недопустимо ). Нужно всегда читать 6-и байтовый залоговок, а далее считывать только, то количество данных, которое указано в заголовке. При соблюдении этого правила можно быть уверенным, что прочитанный блок данных будет содержать достоверную информацию. Потеря данных неприемлема в AIM стандарте. Все это на самом деле не трудно обеспечить.</p>
<p>Труднее разобраться в структуре самого блока данных. А напичкан он весьма разнообразными структурными единицами. Видать оччень много народу постаралось для этого. Впечатление такое, что взяли и скрестили старые версии v2 - v5 ICQ-протокола с самим AIM-протоколом. Это вам еще предстоит увидеть. Вот например, для представления обычных текстовых строк , использовано 3 или 4 различных варианта. Представляете себе строку в формате C++ или в формате Pascal, с нулем в конце или без него, с однобайтовой длиной или двубайтовой, а порядок следования байтов в слове? Черт ногу сломает. А может это специально сделано? Мне кажется, что впопыхах!!!</p>
<p>Попробуем разобраться.</p>
<p>Делфи-проект nICQ в начале будет состоять из 3-х модулей: Types, Packet, Main.</p>
<p>В модуле <a href="types_pas.htm">Types</a> находятся константы и объявлены некоторые записи.</p>
<p>В модуле <a href="packet_pas.htm">Packet</a> - процедуры и функции для записи/чтения FLAP-пакетов.(Большинство процедур из этого модуля просто адаптированы из других проектов ICQ).</p>
<p>Название модуля <a href="main_pas.htm">Main</a> говорит само за себя.</p>
<p>До того, как начать тестирование, вам следует ввести свой UIN, password, NickName. Внесите эти данные в файл nICQ.ini:</p>
<p>[User]</p>
<p>Uin=199222333</p>
<p>Nick=My Nick</p>
<p>Password=mypass</p>

<p>... и можно запускать. Список контактов нам пока не нужен. Он появится позже. А сейчас будет вполне достаточно, если список контактов будет состоять только из вашего собственного UINа. Жмем на единственную кнопку, а в отладочном окне будет отображаться протокол работы. При выборе одного из пунктов Popup-меню, вызывается процедура icq_Login. Что в ней? Смотрим:</p>
<pre>
procedure TForm1.icq_Login(Status : longint);
begin
  // определяем свой IP-адрес
  Local_IP := Get_my_IP;
  // преобразуем его в DIM_IP
  StrToIP(Local_IP,DIM_IP);
  // Запоминаем, какой будет наш статус
  ICQStatus := Status;
  // если ClientSocket открыт, то закроем его
  if CLI.Active then
    CLI.Close;
  // установим флажок isAuth,
  // это значит, что сначала мы коннектимся к серверу
  // авторизации. UIN и пароль передаются именно ему.
  isAuth := true;
  // устанавливаем флажок isHDR,
  // он говорит нам о том, что, самые первые данные ,
  // из ClientSocket следует интерпретировать как
  // FLAP-заголовок
  isHDR := true;
  // заполняем поля Host и Port в ClintSocket,
  // адрес сервера авторизации: 'login.icq.com'
  // и его порт: 5190
  CLI.Address :='';
  CLI.Host := 'login.icq.com';
  CLI.Port := 5190;
  // не забываем и про TMemo
  M(Memo,'&gt;&gt;&gt;&gt;&gt;&gt;&gt;&gt;&gt;&gt;  login.icq.com:5190 &lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;');
  // ... и собственно CONNECT
  CLI.Open;
end;
</pre>
<p>(А вот и подходящий момент, чтобы вспомнить о вашем подключении к интернету. Проблемы с получением CONNECTa могут возникнуть, если вы выходите в интернет из LAN через PROXY-сервер. Все зависит от того, как он настроен. Если он предоставляет выход в интернет только для основных сервисов (http,ftp,smtp,pop), то тут уж извините. А если на нем присутствует нормальный маскарадинг, то все будет OK).</p>
<p>Итак, что же дальше..? Желанный CONNECT должен наступить немного раньше конца света :) Мы подсоединились к серверу авторизации и он первым выдаст нам пакет данных. Что делать? Как принять? Куда его засунуть? Об этом мой расказ на следующей странице.</p>
<p>Итак, рассмотрим механизм приема FLAP-пакетов. Прием пакетов - это обработчик события onReadData нашего ClientSocket. Задача этого обработчика сводится только к приему FLAP-пакетов и формировании из них связного списка типа FIFO (первым пришел, первым и ушел). Главное корректно отработать границы пакетов.</p>
<p>Каждый пакет принимается в два захода:</p>
<p>сначала принимаем только заголовок FLAP-пакета (всего 6 байт);</p>
<p>затем, узнав из заголовка длину блока данных, принимаем последний (ни байтом больше, ни байтом меньше).</p>
<p>Приняв полный пакет, формируем из него элемент списка FIFO и присоединяем его к списку. Смотрим, как это сделано у меня. Для прима заголовка и блока данных FLAP-пакета объявлены два массива: FLAP и FLAP_DATA соответственно.</p>
<pre>
procedure TForm1.CLI_ReadData(Sender:TObject; Socket:TCustomWinSocket);
var num,Bytes,fact : integer;
    pFIFO,CurrFIFO : PFLAP_Item;
    buf : array[0..100] of byte;
begin
// узнаем, сколько всего данных уже есть в буфере ClientSocketa
     num := Socket.ReceiveLength;
// в icq_Login мы установили isHdr, т.к. сначала ожидаем заголовок
     if isHDR then begin
// если есть как минимум 6 байт, то читаем 6 байт заголовка в FLAP
       if num&gt;=6 then begin
         Socket.ReceiveBuf(FLAP,6);
// из заголовка узнаем длину блока данных FLAP-пакета
         NeedBytes := swap(FLAP.Len);
// сбрасываем в начало индекс массива FLAP_DATA
         index := 0;
// сбпасываем, чтобы следующее чтение было в FLAP_DATA
// и выходим из обработчика
       isHDR := false;
       end else begin
             // вообще-то ситуация, когда в Sockete меньше 6-и байт
             // пока никак не контролируется (возникает очень редко :)
             // отмечаю этот факт только в окне отладки 
             M(Memo,'!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
             Socket.ReceiveBuf(buf,num);
             M(Memo,Dim2Hex(@(buf),num));
             M(Memo,'!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!');
           end;
 
// if not isHDR then чтение в FLAP_DATA
end else begin  
// сколько байт читать уже известно: NeedBytes
         Bytes := NeedBytes;
// читаем их в FLAP_DATA[Index]
         fact := Socket.ReceiveBuf(FLAP_DATA[index],Bytes);
// если в Sockete было данных меньше чем нужно, 
// педвинем Index и NeedBytes для следующего входа в обработчик
         inc(index,fact);
         dec(NeedBytes,fact);
         if NeedBytes = 0 then begin
// если весь блок данных FLAP-пакета уже в FLAP_DATA,
// тогда выделаем память для элемента списка FIFO (PFLAP_Item) 
           New(pFIFO);
// копируем заголовок
           pFIFO^.FLAP := FLAP;
           pFIFO^.Next := nil;
// выделяем память для блока данных и копируем его
           GetMem(pFIFO^.DATA,index);
           move(FLAP_DATA,PFIFO^.Data^,swap(FLAP.Len));
 
// добавляем указатель на PFLAP_Item в список
           CurrFIFO:=HeadFIFO;
           if HeadFIFO&lt;&gt;nil then begin
             while CurrFIFO&lt;&gt;nil do
               if CurrFIFO^.Next=nil then begin
                 CurrFIFO^.Next:=pFIFO;
                 break;
               end else CurrFIFO:=CurrFIFO^.Next;
           end else HeadFIFO:=pFIFO; 
// устанавливаем isHDR (в true) уже для прима заголовка
// последующих FLAP-пакетов 
           isHDR := true; 
         end;
     end;
end;
</pre>
<p>Дальнейшая обработка списка FIFO - это задача уже другой процедуры.</p>
<p>Итак, в обработчике события ClientSocket.onRead_Data из FLAP-пакетов формируется список FIFO. Обработку этого списка производит таймерная процедура MainT. Ее задача заключается в следующем:</p>
<p>взять из очереди FLAP-пакет (если очередь не пуста);</p>
<p>сформировать из него временный объект (запись) типа PPack. (Для его обработки в модуле Packet находятся соответствующие функции и процедуры);</p>
<p>направить его на вход одного из двух обработчиков;</p>
<p>после обработки удалить временный объект.</p>
<pre>
procedure TForm1.MainTTimer(Sender: TObject);
var FindFIFO : PFLAP_Item;
    tmp : PPack;
begin
// закроем вход в таймер (реентерабельность нам не нужна) 
     MainT.Enabled := false;
// проверим не пуста ли очередь
     while HeadFIFO&lt;&gt;nil do begin
// если есть ожидающие пакеты, то берем первый из них
       FindFIFO := HeadFIFO;
// и корректируем очередь
       if HeadFIFO^.Next=nil then HeadFIFO := nil
       else HeadFIFO := HeadFIFO^.Next;
// создаем временный Pak
       tmp := PacketNew;
// переносим в него данные из пакета очереди
// сначала FLAP-заголовок
       PacketAppend(tmp,@FindFIFO^.FLAP,sizeof(FLAP_HDR));
// затем блок данных
       PacketAppend(tmp,FindFIFO^.DATA,swap(FindFIFO^.FLAP.Len));
// освобождаем пакет, который из очереди
       FreeMem(FindFIFO^.DATA,swap(FindFIFO^.FLAP.Len));
       Dispose(FindFIFO);
// пропишем его дамп в файл "&lt;твой UIN&gt;.log"
       debugFILE(tmp,'&lt; ');
// если в данный момент мы соединены с сервером авторизации
       if isAuth then 
// то напавим пакет в обработчик AuthorizePart 
          AuthorizePart(tmp)
       else 
// либо в основной обработчик
          WorkPart(tmp);
// удалим временный Pak
       PacketDelete(tmp);
     end;
// откроем вход в таймер
     MainT.Enabled := true;
end;
</pre>
<p>Вполне логично, что дальше надо рассмотреть работу процедуры AuthorizePart, т.к. самый первый FLAP-пакет попадет именно в нее.</p>
<p>Перед рассмотрением работы обработчика AuthorizePart надо немного поговорить и о протоколе.</p>
<p>Перед тем, как подключиться к ICQ-серверу и начать работать мы должны пройти авторизацию на Authorization Server. Его адрес - login.icq.com:5190.</p>
<p>Необходимо:</p>
<p>соединиться с Authorization Server;</p>
<p>передать ему пакет с UINом и паролем;</p>
<p>получить от него IP-адрес и порт основного сервера и Cookie (256 байт случайных данных). Cookie - это будет наш пропуск при последующем (после авторизации) коннекте к основному рабочему серверу;</p>
<p>разьединиться с Authorization Server.</p>
<p>Именно к Authorization Server инициируется соединение в процедуре icq_Login.</p>
<p>Сервер отвечает нам маленьким пакетом:</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 01</p>
<p>Sequence Number XX XX</p>
<p>Data Field Length 00 04</p>
<p>Data 00 00 00 01</p>
<p>В нем только лишь 00 00 00 01. Для нас - это сигнал начать передачу пакета с авторизационными данными (с UINом и паролем).</p>
<p>Сейчас уже пора разобраться и с форматом блока данных FLAP-пакета.</p>
<p>Можно сказать, что показанный выше пакет совсем не имеет никакой структуры: просто DWORD и все. В большинстве случаев в FLAP-пакете размещены данные, которые упакованы еще в один протокол: т.н. SNAC. В этом случае пакет данных выглядит так:</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 02</p>
<p>Sequence Number word</p>
<p>Data Field Length word</p>
<p>SNAC</p>
<p>Family ID word</p>
<p>SubType ID word</p>
<p>Flags[0] byte</p>
<p>Flags[1] byte</p>
<p>Request ID dword</p>
<p>SNAC Data variable</p>
<p>SNAC</p>
<p>SNAC - это обычное содержимое блока данных FLAP-пакета в основной рабочей фазе соединения. Т.е. SNACи посылаются только через Сhannel ID = 2.</p>
<p>В любом FLAP-пакете может находиться только один пакет SNAC.</p>
<p>Прием (анализ) и передача SCACов - это то основное, что предстоит делать, чтобы реализовать все функции ICQ-клиента. Будь то передача списка контактов, или изменение нашего статуса, или получение и передача сообщений, или запрос информации о любом клиенте, для любого запроса и ответа на него есть свой SNAC (FamilyID, SubTypeID). Из сказанного видно, что вся смысловая информация помещена в SNACи. И UINы, и никнэймы, и и-мэйлы с хоумпэйджами. Конечно же они не просто так накиданы в SNACи. Они там размещены в юнитах, которые называются TLV.</p>
<p>TLV</p>
<p>TLV дословно означает - "Type, Length, Value" ("Тип, Длина, Значение"). Его структура такая:</p>
<p>TLV</p>
<p>(T)ype code word</p>
<p>(L)ength code word</p>
<p>(V)alue field variable length</p>
<p>В TLV упаковывается все, что используется в ICQ-протоколе: текстовые строки, байты, слова, двойные слова, другие массивы и т.д. и т.п.. На тип содеожимого TLV указывает Type code. Чаще всего TLV располагаются внутри SNACов, но это не является обязательным условием. Они могут также напрямую использоваться в блоке данных FLAP-пакета. Именно напрямую (т.е. без использования SNACов) TLV задействованы на этапе авторизации.</p>
<p>Этот механизм мы и рассмотрим именно сейчас, т.к. мы соединены уже с Authorization Server и получили от него добро в виде DWORD=00000001 на передачу нашего UINа и пароля.</p>
<pre>
procedure TForm1.AuthorizePart(p:PPack);
var ss : string;
    T : integer;
    tmp : PPack;
begin
     // позиционируемся на начало блока данных, пропустив заголовок
     PacketGoto(p,sizeof(FLAP_HDR));
     // если FLAP-данные содержат лишь 00000001,
     // то это самое начало сессии 
     if (swap(p^.Len)=4)and
        (swap(p^.SNAC.FamilyID)=0)and
        (swap(p^.SNAC.SubTypeID)=1) then begin
       M(Memo,'&lt; Authorize Server CONNECT');
              // каждый раз, когда начинается новая TCP-сессия,
              // присваиваем SEQ случайное начальное значение
       SEQ := random($7FFF);       // в ответ надо передать пакет с UINом и паролем
       // создаем объект-пакет типа PPack: в нем формируется
       // FLAP-заголовок с Chanel_ID=1 
       tmp := CreatePacket(1,SEQ);
       // сначала надо вставить такой же DWORD=00000001
       // (еще надо помнить о порядке следования байтов в DWORD !!!)
       PacketAppend32(tmp,DSwap(1));
       // далее в поле данных добавляются несколько TLV
       // это наш UIN -  TLV(1)
       TLVAppendStr(tmp,$1,s(UIN));
       // и закодированный пароль - TLV(2) 
       TLVAppendStr(tmp,$2,Calc_Pass(PASSWORD));
       // описывать содержимое других TLV особого смысла нет
       TLVAppendStr(tmp,$3,
         'ICQ Inc. - Product of ICQ (TM).2000a.4.31.1.3143.85');
       TLVAppendWord(tmp,$16,$010A);
       TLVAppendWord(tmp,$17,$0004); // 4 - для ICQ2000a
       TLVAppendWord(tmp,$18,$001F);
       TLVAppendWord(tmp,$19,$0001);
       TLVAppendWord(tmp,$1A,$0C47);
       TLVAppendDWord(tmp,$14,$00000055);
       TLVAppendStr(tmp,$0F,'en');
       TLVAppendStr(tmp,$0E,'us');
       // посылаем пакет через  ClientSocket
       // (здесь tmp-пакет будет также и удален)
       PacketSend(tmp);
       M(Memo,'&gt; Auth Request (Login)');
 
     end else  
     // на это сервер ответит так:
     // его ответ содержит TLV(1) - т.е. наш UIN
     if (TLVReadStr(p,ss)=1)and(ss=s(UIN))then begin
        // если это так, то считаем следующий TLV
        T := TLVReadStr(p,ss);
        case T of
          // если это TLV(5) - значит это адрес и порт основного сервера
          5: g&gt;begin // BOS-IP:PORT
            M(Memo,'&lt; Auth Responce (COOKIE)');
            // запоминаем и адрес и порт
            WorkAddress := copy(ss,1,pos(':',ss)-1);
            WorkPort := strtoint(copy(ss,pos(':',ss)+1,
                              length(ss)-pos(':',ss)));
            // за ними должен быть и TLV(6) - т.н. COOKIE (256 байт)
            // принимаем его прямо в переменную sCOOKIE
            // (он пригодится при коннекте к основному серверу)
            if (TLVReadStr(p,sCOOKIE)=6) then begin;
              // COOKIE получен и значит пора разъединяться
              // формируем пустой пакет с Channel_ID=4
              tmp:=CreatePacket(4,SEQ); // ChID=4
              // который и передаем
              PacketSend(tmp);
              // закрываем свой ClientSocket
              OfflineDiscconnect1Click(self);
              // говорим себе, что авторизация пройдена
              isAuth := false;
              // настраиваем ClientSocket на адрес:порт
              // основного (BOS) сервера
              CLI.Address := WorkAddress;
              CLI.Host := '';
              CLI.Port := WorkPort;
              M(Memo,'');
              M(Memo,'&gt;&gt;&gt; Connecting to BOS: '+ss);
              // и коннектимся к нему
              CLI.Open;
{ ******************************************* }
{ в этом месте заканчивается этап авторизации }
{ ******************************************* }
            end;
          end;
          // а, например, в случае неверного UINа или пароля
          // мы получим TLV(4) и TLV(8)
          4,8: begin
               M(Memo,'&lt; Auth ERROR');
               M(Memo,'TLV($'+inttohex(T,2)+') ERROR');
               M(Memo,'STRING: '+ss);
               if pos('http://',ss)&gt;0 then begin
                 // и даже можем загрузить в браузер присланный нам URL
                 // с описанием ошибки
                 // Web.Navigate(ss); 
                 // {это навигатор с панели компонентов Делфи}
               end;
               TLVReadStr(p,ss); M(Memo,ss);
               // конечно же закрываем ClientSocket
               OfflineDiscconnect1Click(self);
               M(Memo,'');
             end;
        end;
     end;
end;
</pre>

<p>После успешного прохождения авторизации, мы подключаемся к основному рабочему серверу ICQ. Т.к. флажек isAuth уже сброшен, то диспетчер MainTTimer все пакеты будет направлять на обработчик WorkPart. Его построение во многом схоже с только, что рассмотренным обработчиком AuthorizePart.</p>
<p>Обработчик WorkPart выполняет всю диспетчерскую работу на протяжении всего времени, когда мы подключены к основному ICQ-серверу. Устроен он очень просто.</p>
<pre>
procedure TForm1.WorkPart(p:PPack);
var ss,ss2,sErr : string;
    tmp : PPack;
begin
     { иногда бывает: сервер прервал соединение.
        такая ситуация возникала только в одном случае:
        сервером зафиксирован логин с нашим UINом с другого компьютера. }
     if p^.FLAP.ChID = 4 then begin 
       PacketGoto(p,sizeof(FLAP_HDR));
       // Код ошибки
       TLVReadStr(p,ss); M(Memo,ss);
       // Описание ошибки
       TLVReadStr(p,ss2); M(Memo,ss2);
       // Разьединяемся
       OfflineDiscconnect1Click(self);
       sErr:='Str1: '+Dim2Hex(@(ss[1]),length(ss));
       sErr:=sErr+#13#10+'Str2: '+ss2+#13#10+#13#10;
       ShowMessage('Another Computer Use YOUR UIN!'#13#10+#13#10+
                   sErr+'...i gonna to disconnect');
       // Выходим из обработчика
       exit;
     end;
     {}
 
 
     {  Основная секция  }
 
     // позиционируемся на данные
     PacketGoto(p,sizeof(FLAP_HDR)+sizeof(SNAC_HDR));
 
     // BOS Connection ACK (DWORD 00000001)
     // т.е. основной сервер готов с нами общаться
     if (swap(p^.Len)=4)and
        (swap(p^.SNAC.FamilyID)=0)and
        (swap(p^.SNAC.SubTypeID)=1) then begin
        M(Memo,'&lt; BOS connection ACK');
 
       // ... и мы ему передадим COOKIE
       // Sign-ON  (COOKIE)
       SEQ := random($7FFF);
       tmp := CreatePacket(1,SEQ);
       PacketAppend32(tmp,DSwap($00000001));
       TLVAppendStr(tmp,$6,sCOOKIE);
       PacketSend(tmp);
       M(Memo,'&gt; Sign-ON (COOKIE)');
 
     end else  // 
     if (swap(p^.SNAC.FamilyID)=1)and
        (swap(p^.SNAC.SubTypeID)=3) then begin
        M(Memo,'&gt; "I`m ICQ client, not AIM"');
 
     end else // ACK to "I`m ICQ Client"
     if (swap(p^.SNAC.FamilyID)=$1)and // ACK
        (swap(p^.SNAC.SubTypeID)=$18) then begin
        M(Memo,'&lt; Rate Information Request');
 
     end else // Rate Information Response
     if (swap(p^.SNAC.FamilyID)=$1)and
        (swap(p^.SNAC.SubTypeID)=$7) then begin
        M(Memo,'&lt; Rate Information Response');
 
       // ACK to Rate Information Response
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$1,$8);
       PacketAppend32(tmp,DSwap($00010002));
       PacketAppend32(tmp,DSwap($00030004));
       PacketAppend16(tmp,Swap($0005));
       PacketSend(tmp);
       M(Memo,'&gt; ACK to Rate Response');
 
       // Request Personal Info
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$1,$0E);
       PacketSend(tmp);
       M(Memo,'&gt; Request Personal Info');
 
       // Request Rights for Location service
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$2,$02);
       PacketSend(tmp);
       M(Memo,'&gt; Request Rights for Location service');
 
       // Request Rights for Buddy List
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$3,$02);
       PacketSend(tmp);
       M(Memo,'&gt; Request Rights for Buddy List');
 
       // Request Rights for ICMB
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$4,$04);
       PacketSend(tmp);
       M(Memo,'&gt; Request Rights for ICMB');
 
       // Request BOS Rights
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$9,$02);
       PacketSend(tmp);
       M(Memo,'&gt; Request BOS Rights');
 
     end else  // Personal Information
     if (swap(p^.SNAC.FamilyID)=$1)and
        (swap(p^.SNAC.SubTypeID)=$F) then begin
        M(Memo,'&lt; Personal Information');
 
     end else  // Rights for location service
     if (swap(p^.SNAC.FamilyID)=$2)and
        (swap(p^.SNAC.SubTypeID)=$3) then begin
        M(Memo,'&lt; Rights for location service');
 
     end else  // Rights for byddy list
     if (swap(p^.SNAC.FamilyID)=$3)and
        (swap(p^.SNAC.SubTypeID)=$3) then begin
        M(Memo,'&lt; Rights for byddy list');
 
     end else  // Rights for ICMB
     if (swap(p^.SNAC.FamilyID)=$4)and
        (swap(p^.SNAC.SubTypeID)=$5) then begin
        M(Memo,'&lt; Rights for ICMB');
 
     end else // BOS Rights
     if (swap(p^.SNAC.FamilyID)=$9)and
        (swap(p^.SNAC.SubTypeID)=$3) then begin
        M(Memo,'&lt; BOS Rights');
 
       // Set ICMB parameters
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$4,$2);
       PacketAppend16(tmp, swap($0000));
       PacketAppend32(tmp,dswap($00000003));
       PacketAppend16(tmp, swap($1F40));
       PacketAppend16(tmp, swap($03E7));
       PacketAppend16(tmp, swap($03E7));
       PacketAppend16(tmp, swap($0000));
       PacketAppend16(tmp, swap($0000));
       PacketSend(tmp);
       M(Memo,'&gt; Set ICMB parameters');
 
       // Set User Info (capability)
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$2,$4);      // tlv(5)=capability
       TLVAppendStr(tmp,5,#$09#$46#$13#$49#$4C#$7F#$11#$D1+
                          #$82#$22#$44#$45#$53#$54#$00#$00+
                          #$09#$46#$13#$44#$4C#$7F#$11#$D1+
                          #$82#$22#$44#$45#$53#$54#$00#$00);
       PacketSend(tmp);
       M(Memo,'&gt; Set User Info (capability)');
 
       // Send Contact List
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$3,$4);
       // пока включаем только свой UIN
       PacketAppendB_String(tmp,s(UIN));
    // PacketAppendB_String(tmp,s(UIN_1));   
    // PacketAppendB_String(tmp,s(UIN_2));   
    // ...
    // PacketAppendB_String(tmp,s(UIN_n));   
    // Можно включить любой UIN, ... даже если он и не хочет :)   
       PacketSend(tmp);
       M(Memo,'&gt; Send Contact List (1)');
 
       // если  мы начинаем с режима Invisible, то передаем
       // Visible List, во всех других режимах - Invisible List
       case ICQStatus of
       STATE_INVISIBLE: begin
           // Send Visible List
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$9,$5);
           // пока список пуст (кого включать решать вам)
           PacketSend(tmp);
           M(Memo,'&gt; Send Visible List (0)');
         end;
         else begin
           // Send Invisible List
           tmp := CreatePacket(2,SEQ);
           SNACAppend(tmp,$9,$7);
           // пока список пуст (кого включать решать вам)
           PacketSend(tmp);
           M(Memo,'&gt; Send Invisible List (0)');
         end;
       end; // case
 
       ConnectMode(true);
       SetStatus(ICQStatus);
       M(Memo,'&gt; Set Status Code');
 
       // Client Ready
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$1,$2);
       PacketAppend32(tmp,dswap($00010003));
       PacketAppend32(tmp,dswap($0110028A));
       PacketAppend32(tmp,dswap($00020001));
       PacketAppend32(tmp,dswap($0101028A));
       PacketAppend32(tmp,dswap($00030001));
       PacketAppend32(tmp,dswap($0110028A));
       PacketAppend32(tmp,dswap($00150001));
       PacketAppend32(tmp,dswap($0110028A));
       PacketAppend32(tmp,dswap($00040001));
       PacketAppend32(tmp,dswap($0110028A));
       PacketAppend32(tmp,dswap($00060001));
       PacketAppend32(tmp,dswap($0110028A));
       PacketAppend32(tmp,dswap($00090001));
       PacketAppend32(tmp,dswap($0110028A));
       PacketAppend32(tmp,dswap($000A0003));
       PacketAppend32(tmp,dswap($0110028A));
       PacketSend(tmp);
       M(Memo,'&gt; Client Ready');
 
{
Здесь заканчивается утомительная процедура вхождения в связь
(согласования различных параметров с сервером.
Возможно, что в AOL Imstant Messenger такая процедура, что-то и значит,
но в ICQ-протоколе похоже, что ничего).
 
 
В этот момент считается, что мы уже в Online
и другие клиенты наш статус увидят.
}
 
       // А мы можем уже запрашивать у сервера полезную информацию,
       // например, надо запросить off-лайновые сообщения
       // Get offline messages
       tmp := CreatePacket(2,SEQ);
       SNACAppend(tmp,$15,$2);
       PacketAppend32(tmp,dswap($0001000A));
       PacketAppend16(tmp, swap($0800));
       PacketAppend32(tmp, UIN);
       PacketAppend16(tmp, swap($3C00));
       PacketAppend16(tmp, swap($0200));
       PacketSend(tmp);
       M(Memo,'&gt; Get offline messages');
     end else  
 
 
{
здесь начинается секция обработки почти всех пакетов-ответов,
которые поступят во время, пока мы подключены к ICQ-серверу.
}
 
               // UIN ON-line
     if (swap(p^.SNAC.FamilyID)=$3)and
        (swap(p^.SNAC.SubTypeID)=$0B) then begin
        M(Memo,'');
        ShowUserONStatus(p);
        M(Memo,'');
 
     end else  // UIN OFF-line
     if (swap(p^.SNAC.FamilyID)=$3)and
        (swap(p^.SNAC.SubTypeID)=$0C) then begin
        M(Memo,'');
        M(Memo,'&lt; UIN OFF-line: '+PacketReadB_String(p));
        M(Memo,'');
 
     end else  // Reject notification
               // отказ сервера выдать статус этого UINа
               // (встречается очень редко)
     if (swap(p^.SNAC.FamilyID)=$3)and
        (swap(p^.SNAC.SubTypeID)=$0A) then begin
        M(Memo,'');
        M(Memo,'&lt; Reject from UIN: '+PacketReadB_String(p));
        M(Memo,'');
 
     end else  // SNAC 15,3  
               // имеет много назначений:
               // - ответы с offlines messages
               // - ответы с UserInfo Results
               // - ответы с SearchUser Results
               // - и многое другое
     if (swap(p^.SNAC.FamilyID)=$15)and
        (swap(p^.SNAC.SubTypeID)=$3) then begin
        M(Memo,'');
        SNAC_15_3(p);
        M(Memo,'');
 
     end else  // SNAC 4,7  Входящие сообщения (всех типов)
     if (swap(p^.SNAC.FamilyID)=$4)and
        (swap(p^.SNAC.SubTypeID)=$7) then begin
        M(Memo,'');
        SNAC_4_7(p);
        M(Memo,'');
 
     end else begin  // и если, что-то еще не обрабатывается
        M(Memo,'');
        M(Memo,'???? Unrecognized SNAC: ????????');
        M(Memo,'???? SNAC [$'+inttohex(swap(p^.SNAC.FamilyID),2)+':$'+
                             inttohex(swap(p^.SNAC.SubTypeID),2)+']');
        M(Memo,'');
      end;
end;
</pre>

<p>Для разбора конкретного примера возьмем ситуацию, когда мы запрашиваем у ICQ-сервера оффлайновые сообщения (т.е. те, которые накопились на сервере, пока нас не было в онлайне).</p>
<p>Запрос оффлайновых сообщений делаем с помощью SNAC(15,2), а ответ на него получим соответственно в SNAC(15,3). Оба этих SNACa имеют очень простой формат. Они содержат в себе только по одному TLV, а именно TLV(1). На первый взгляд все очень просто. Но... TLV(1), в свою очередь, имеет очень ветвистую структуру. (Такие особенности имеют и некоторые другие SNACи, например, SNAC(4,6) для передачи и SNAC(4,7) для приема сообщений).</p>
<p>В заметках к протоколу ICQv7 от Massimo Melina есть описание SNAC(15,2). Этот SNAC используется во множестве различных запросов. Я лишь выделю те строки, которые будут включены в наш запрос, а именно:</p>
<p>заголовок самого SNAC(15,2);</p>
<p>TLV(1), который включает в себя:</p>
<p>длину, следующих далее данных,</p>
<p>наш UIN,</p>
<p>тип запроса ($3С00),</p>
<p>cookie (по которому мы узнаем ответный SNAC(15,3) ).</p>
<p>В описании это находится вот здесь:</p>
<p>SNAC 15,02</p>
<p> TLV(1)</p>
<p>   WORD   (LE) bytes remaining, useless</p>
<p>   UIN    my uin</p>
<p>   WORD   type</p>
<p>   WORD   cookie</p>
<p>   type = 3C00       // ask for offlines messages</p>
<p>     nothing</p>
<p>   type = 3E00       // ack to offline messages,</p>
<p>     nothing   type=D007</p>
<p>     WORD  subtype</p>
<p>     subtype=9808  xml-stype in an LNTS</p>
<p>       LNTS  '' name of required data ''</p>
<p>     subtype=1F05       // simple query info</p>
<p>       UIN   user to request info     subtype=B204       // query info about user</p>
<p>       UIN   user to request info     subtype=D004       // query my info</p>
<p>       UIN   my uin</p>
<p>     ..............</p>
<p>     ..............</p>
<p>     ..............</p>

<p>В исходном коде это выглядит так:</p>
<pre>
// Get offline messages
// создаем FLAP-заголовок с Channel_ID=2 и SEQ++
tmp := CreatePacket(2,SEQ);
// добавляем SNAC-заголовок SNAC(15,2)
SNACAppend(tmp,$15,$2);
// добавляем TLV(1) ($0001-Type, $000A-Length)
PacketAppend32(tmp,dswap($0001000A));
// добавляем саму Value Для TLV(1)
PacketAppend16(tmp, swap($0800));// бесполезная длина
PacketAppend32(tmp, UIN);        // наш UIN
PacketAppend16(tmp, swap($3C00));// тип запроса
PacketAppend16(tmp, swap($0200));// cookie
PacketSend(tmp);
M(Memo,'&gt; Get offline messages');
</pre>

<p>Этот кусок кода сгенерирует следующий дамп:</p>
<p>2A 02 36 86 00 18 00 15</p>
<p>00 02 00 00 00 87 00 02</p>
<p>00 01 00 0A 08 00 XX XX</p>
<p>XX XX 3C 00 02 00</p>

<p>Разпишем его в табличном виде для лучшего восприятия:</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 02</p>
<p>Sequence Number 36 86</p>
<p>Data Field Length 00 18</p>
<p>SNAC (15, 02)</p>
<p>Family ID 00 15</p>
<p>SubType ID 00 02</p>
<p>Flags[0] 00</p>
<p>Flags[1] 00</p>
<p>Request ID 00 87 00 02</p>
<p>TLV (1)</p>
<p>Type 00 01</p>
<p>Length 00 0A</p>
<p>Value 08 00</p>
<p>XX XX XX XX наш UIN</p>
<p>3C 00 запрос на оффлайновые сообщения</p>
<p>02 00 cookie</p>
<p>Передадим пакет и от сервера получим FLAP-пакет с таким дампом:</p>
<p>2A 02 74 6D 00 4D 00 15</p>
<p>00 03 00 01 00 87 00 02</p>
<p>00 01 00 3F 3D 00 XX XX</p>
<p>XX XX 41 00 02 00 F8 5F</p>
<p>F1 08 D2 07 02 0C 10 12</p>
<p>01 00 25 00 EF F0 E8 E2</p>
<p>E5 F2 0D 0A FD F2 EE 20</p>
<p>F2 E5 F1 F2 EE E2 EE E5</p>
<p>20 F1 EE EE E1 F9 E5 ED</p>
<p>E8 E5 20 21 21 21 0D 0A</p>
<p>00 00 00</p>
<p>И снова распишем его в таблицу:</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 02</p>
<p>Sequence Number 74 6D</p>
<p>Data Field Length 4D 00</p>
<p>SNAC (15, 03)</p>
<p>Family ID 00 15</p>
<p>SubType ID 00 03</p>
<p>Flags[0] 00</p>
<p>Flags[1] 01</p>
<p>Request ID 00 87 00 02 (такой же как и в запросе)</p>
<p>TLV (1)</p>
<p>Type 00 01</p>
<p>Length 00 3F</p>
<p>Value 3D 00</p>
<p>XX XX XX XX наш UIN</p>
<p>41 00 тип: оффлайновое сообщение</p>
<p>02 00 cookie (как и в запросе)</p>
<p>тело сообщения</p>
<p>XX XX XX XX его UIN</p>
<p>D2 07 год (2002)</p>
<p>02 месяц (февраль)</p>
<p>0C день (12)</p>
<p>10 час (16)</p>
<p>12 минуты (18)</p>
<p>01 под-тип сообщения</p>
<p>(обычное)</p>
<p>00 флаги сообщения (?)</p>
<p>25 00 длина сообщения (37)</p>
<p>EF F0 E8 E2 E5 F2 0D 0A FD F2 EE 20 F2 E5 F1 F2 EE E2 EE E5 20 F1 EE EE E1 F9 E5 ED E8 E5 20 21 21 21 0D 0A 00 текст сообщения:</p>
<p>"привет</p>
<p>это тестовое сообщение !!!"</p>
<p>00 00 присутствют, если сообщение единственное</p>

<p>В протокольных заметках я выделю ту часть описания SNAC(15,3), которая соответствует таблице:</p>
<p>SNAC 15,03</p>
<p>TLV(1)</p>
<p>  WORD (LE) bytes remaining, useless</p>
<p>  UIN my uin</p>
<p>  WORD message-type</p>
<p>  WORD cookie</p>
<p>    message-type = 4100 // offline message</p>
<p>      UIN his uin</p>
<p>      WORD year (LE)</p>
<p>      BYTE month (1=jan)</p>
<p>      BYTE day</p>
<p>      BYTE hour (GMT time)</p>
<p>      BYTE minutes</p>
<p>      BYTE msg-subtype</p>
<p>      BYTE msg-flags</p>
<p>      LNTS msg</p>
<p>      WORD 0000, present only in single messages</p>
<p>    message-type = 4200 // end of offline messages</p>
<p>      BYTE unknown, usually 0</p>
<p>    message-type = D007</p>
<p>      2 BYTE unknown, usually 98 08</p>
<p>      WORD length of the following NTS</p>
<p>      NTS ""field-type""</p>
<p>      field-type = DataFilesIP</p>
<p>        6 BYTE unk, usually 2A 02 44 25 00 31</p>
<p>    message-type = DA07</p>
<p>      3 BYTE subtype</p>
<p>        subtype=A4010A // wp-full-request result</p>
<p>          wp-result-info</p>
<p>        ..............</p>
<p>        ..............</p>
<p>        ..............</p>
<p>        subtype=B4000A // ack to remove user</p>
<p>          empty</p>
<p>        subtype=AA000A // ack to change password</p>
<p>          empty</p>

<p>И "нарешти" - код для приема SNAC(15,3). Множественные комментарии, кажется тут уже излишни.</p>
<pre>
procedure TForm1.SNAC_15_3(p:PPack);
var MessageType,Cookie : word;
    myUIN,hisUIN : longint;
    year,month,day,hour,minute,typemes,subtypemes,lenmes : word;
    tmp : PPack;
begin
     // просто пролетаем над началом TLV(1)
     PacketRead32(p);
     PacketRead16(p);
 
     // а дальше имена переменных объясняют больше, чем комментарии
     myUIN := PacketRead32(p);
     MessageType := swap(PacketRead16(p));
     Cookie := swap(PacketRead16(p));
     M(Memo,'&lt; Cookie: $'+inttohex(Cookie,4));
     case MessageType of
     $4100: begin // OFFLINE MESSAGE
             hisUIN := PacketRead32(p); 
             M(Memo,'&lt; Message-Type: $'+inttohex(MessageType,4));
             M(Memo,'&lt; OFFLINE MESSAGE from UIN: '+s(hisUIN));
             year := PacketRead16(p);
             month := PacketRead8(p);
             day := PacketRead8(p);
             hour := PacketRead8(p);
             minute := PacketRead8(p);
             typemes := PacketRead8(p);
             subtypemes := PacketRead8(p);
             lenmes := PacketRead16(p);
             DoMsg(false,typemes,lenmes,PCharArray(@(p^.data[p^.cursor])),
                  hisUIN,UTC2LT(year,month,day,hour,minute));
            end;
      end;
end;
</pre>

<p>Передача сообщений</p>
<p>Уверен, что у вас не возникло никаких проблем со скачиванием, с компиляцией, с "конфигурированием" первого проекта. Если вы вписывали в файл nICQ.ini свой пароль, то коннект был обеспечен.</p>
<p>Урок №2 содержит два новых модуля. <a href="sendmess_pas.htm">SendMess</a> и <a href="messform_pas.htm">MessFrom</a>. Каждый из них имеет свое окно. Это - передача и прием сообщений.</p>
<p>Чтобы полноценно передавать сообщения, необходим и такой объект в основном окне, как список контактов. Объект TTreeView напрашивается сам. Проще некуда. Тем более каждый элемент в нем может содержать указатель на связанные данные. TTreeView меня полностью устроил.</p>
<p>Сам список контактов будет хранится в файле &lt;ваш_uin&gt;.dat</p>
<p>Т.к. сейчас рассматриваетя только урок №2, то и заполняться этот файл будет пока только вручную. При его заполнении вполне можно пренебречь процедурой авторизации.</p>
<p>[ContactList]</p>
<p>199111222=1st_User</p>
<p>199111333=2nd_User</p>
<p>199111444=3rd_User</p>
<p>345345234=Иван Иваныч</p>
<p>188888888=Вася Пупкин</p>
<p>и т.д. и т.п.</p>

<p>Вписывайте UINов столько, сколько нужно. Только не забудьте увеличить массив TContactList, если UINов планируете больше сотни:</p>
<p>type TContactList = array[0..100] of TListRecord;</p>

<p>И еще пару слов относительно интерфейса: те кому надоели зелененькие цветочки - могут нарисовать свои значки для контактного списка. Bitmapы прилагаются.</p>
<p>Теперь о том как реально передаются сообщения.</p>
<p>Есть два типа передаваемых сообщений: Simple Message и Advanced Message.</p>
<p>Если UIN (для которого предназначено сообщение) находится в оффлайне - то ему шлется Simple Message. Advanced Message посылаются тем адресатам, (кажется ) если версия аськи у них не ниже ICQ2000. Из формата Advanced Message в уроке №2 используется лишь информация о Foreground Color и Background Color (это цвета раскраски текста). Использовал бы еще что-нибудь, так там больше ничего нет такого, что можно назвать advanced.</p>
<p>При передаче, сообщения пакуются в SNAC(4,06).</p>
<p>Начнем с более простого формата - Simple Message:</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 02</p>
<p>Sequence Number 34 3B</p>
<p>Data Field Length 00 3D</p>
<p>SNAC (4, 06) - Send Message (Simple)</p>
<p>Family ID 00 04</p>
<p>SubType ID 00 06</p>
<p>Flags[0] 00</p>
<p>Flags[1] 00</p>
<p>Request ID 00 AD 00 06</p>
<p>53 DE 53 75</p>
<p> Cookie 1</p>
<p>16 14 BB 50 Cookie 2</p>
<p>00 01  msg-format: Simple Message</p>
<p>09</p>
<p> длина его UINа почти как</p>
<p>PascalStr</p>
<p>31 39 39</p>
<p>37 37 37</p>
<p>36 36 36 его UIN</p>
<p>(например: '199777666')</p>
<p>TLV (2) - сообщение здесь</p>
<p>T ype 00 02</p>
<p>L ength 00 17</p>
<p>V alue 05 01 00 01 01 01 01 (unk) ???</p>
<p>00 0E длина сообщения</p>
<p>+ 4</p>
<p>00 00 00 00 (unk) ???</p>
<p>D1 EE EE E1 F9 E5 ED E8 E5 21  'Сообщение!'</p>
<p>TLV (6) - пустой</p>
<p>T ype 00 06</p>
<p>L ength 00 00</p>
<p>Продолжим более сложным форматом - Advanced Message. А он действительно по-сложнее будет.</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 02</p>
<p>Sequence Number 0C A3</p>
<p>Data Field Length 00 99</p>
<p>SNAC (4, 06) - Send Message (Advanced)</p>
<p>Family ID 00 04</p>
<p>SubType ID 00 06</p>
<p>Flags[0] 00</p>
<p>Flags[1] 00</p>
<p>Request ID 00 C3 00 06</p>
<p>1C D3 C4 B7</p>
<p> Cookie 1</p>
<p>23 4D 75 95 Cookie 2</p>
<p>00 02  msg-format: Advanced Message</p>
<p>09</p>
<p> длина его UINа почти как</p>
<p>PascalStr</p>
<p>31 39 39</p>
<p>37 37 37</p>
<p>36 36 36 его UIN</p>
<p>(например: '199777666')</p>
<p>TLV (5)</p>
<p>T ype 00 05</p>
<p>L ength 00 73</p>
<p>V alue 00 00 00 00 - для посылки сообщения</p>
<p>1C D3 C4 B7 Cookie 1</p>
<p>23 4D 75 95 Cookie 1</p>
<p>09 46 13 49</p>
<p>4C 7F 11 D1</p>
<p>82 22 44 45</p>
<p>53 54 00 00 4 DWORD</p>
<p>наши возможности ???</p>
<p>(capability)</p>
<p>TLV (A)</p>
<p>T ype 00 0A</p>
<p>L ength 00 02</p>
<p>V alue 00 01  00 01 - для посылки сообщения</p>
<p>TLV (F) - пустой (???)</p>
<p>T ype 00 0F</p>
<p>L ength 00 00</p>
<p>TLV (2711) - сообщение здесь</p>
<p>T ype 27 11</p>
<p>L ength 00 4B</p>
<p>V alue 1B 00 07 00 00</p>
<p>00 00 00 00 00</p>
<p>00 00 00 00 00</p>
<p>00 00 00 00 00</p>
<p>00 00 03 00 00</p>
<p>00 26 байт (unk)</p>
<p>00</p>
<p>FF FF</p>
<p>0E 00</p>
<p>FF FF</p>
<p>00 00 00 00 00</p>
<p>00 00 00 00 00</p>
<p>00 00 12 байт (unk)</p>
<p>01  msg-subtype ( 01-обычное )</p>
<p>00</p>
<p>00 00</p>
<p>01 00</p>
<p>0E 00  длина сообщения  тело</p>
<p>сообщения</p>
<p>D1 EE EE E1 F9 E5 ED E8 E5 20 B9 32 2E (00)  'Сообщение №2.'</p>
<p>80 00 80 00 foreground color</p>
<p>FF FF 00 00 background color</p>

<p>TLV (3) - пустой</p>
<p>T ype 00 03</p>
<p>L ength 00 00 TLV(3) посылается, как запрос подтверждения</p>
<p>Что касается кода, то мудровать с формированием TLV я не стал. Зато получилось дешево и сердито. Одним словом - это все работает.</p>
<pre>
unit SendMess; 
 
 
 
procedure TMessageTo.SendButtonClick(Sender: TObject);
var sNN,sMess,sUIN : string;
    tmp : PPack;
    sTmp : string;
    d1,d2 : longint;
    buf : TByteArray;
    ind,indmem : word;
const capab : string{16}= #$09#$46#$13#$49#$4C#$7F#$11#$D1+
                          #$82#$22#$44#$45#$53#$54#$00#$00;
      blok : string{26} = #$1B#$00#$07#$00#$00#$00#$00#$00+
                          #$00#$00#$00#$00#$00#$00#$00#$00+
                          #$00#$00#$00#$00#$00#$00#$03#$00+
                          #$00#$00;
     x:word=0;
begin
     sNN := NNEd.Text;
     sUIN := ICQEd.Text;
     if SendMemo.Lines.Count = 0 then exit;
     sMess := SendMemo.Text;
 
     // создаем новый FLAP
     tmp := CreatePacket(2,SEQ);
     // добавляем SNAC(4,6)
     SNACAppend(tmp,$4,$6);
     // генерируем Cookie-1 и Cookie-2
     d1:=random($7FFFFFFF);
     d2:=random($7FFFFFFF);
     // запоминаем их: по ним мы узнаем ACKи от сервера и клиента
     SEQ1:=dswap(d1);
     SEQ2:=dswap(d2);
     PacketAppend32(tmp,dswap(d1));
     PacketAppend32(tmp,dswap(d2));
 
     // проверяем какой тип сообщения выбран     case MesFmtBox.Checked of
     true:
      begin
      // advanced message
      // 0002 - advanced
        PacketAppend16(tmp,swap($0002));
        // кому ?
        // дальше, вся последовательность формируется
        // в дополнительном буфере buf
        PacketAppendB_String(tmp,sUIN);
        // TLV(5) + его длина, которую впишем в конце
        ind:=0;fillchar(buf,sizeof(buf),'^');
        PLONG(@(buf[ind]))^:=dswap($0005FFFF);inc(ind,4);
        // Cookie-1 и Cookie-2
        PWORD(@(buf[ind]))^:=0;inc(ind,2);
        PLONG(@(buf[ind]))^:=dswap(d1);inc(ind,4);
        PLONG(@(buf[ind]))^:=dswap(d2);inc(ind,4);
        // Capability
        MOVE(capab[1],buf[ind],length(capab));inc(ind,length(capab));
        //TLV(A)=0001
        PLONG(@(buf[ind]))^:=dswap($000A0002);inc(ind,4);
        PWORD(@(buf[ind]))^:=swap($0001);inc(ind,2);
        //TLV(F)-пустой
        PLONG(@(buf[ind]))^:=dswap($000F0000);inc(ind,4);
 
        // TLV(2711) + его длина, которую впишем в конце
        PLONG(@(buf[ind]))^:=dswap($2711FFFF);inc(ind,4);
        indmem:=ind-2;
        // 16 байт
        MOVE(blok[1],buf[ind],length(blok));inc(ind,length(blok));
        PBYTE(@(buf[ind]))^:=0;inc(ind,1);
        PWORD(@(buf[ind]))^:=swap($FFFF);inc(ind,2);
        PWORD(@(buf[ind]))^:=swap($0E00);inc(ind,2);
        PWORD(@(buf[ind]))^:=swap($FFFF);inc(ind,2);
        // 12 байт = 0
        PLONG(@(buf[ind]))^:=$00000000;inc(ind,4);
        PLONG(@(buf[ind]))^:=$00000000;inc(ind,4);
        PLONG(@(buf[ind]))^:=$00000000;inc(ind,4);
        // под-Тип сообщения = 1 (обычное)
        PBYTE(@(buf[ind]))^:=1;inc(ind,1);
 
        PBYTE(@(buf[ind]))^:=0;inc(ind,1);
        PWORD(@(buf[ind]))^:=swap($0000);inc(ind,2);
        PWORD(@(buf[ind]))^:=swap($0100);inc(ind,2);
        // длина сообщения
        PWORD(@(buf[ind]))^:=length(sMess)+1;inc(ind,2);
        // сообщение
        move(sMess[1],buf[ind],length(sMess));inc(ind,length(sMess));
        // завершающий ноль
        PBYTE(@(buf[ind]))^:=0;inc(ind,1);
        // foreground color
        PLONG(@(buf[ind]))^:=dswap(GetColor(SendMemo,FG));inc(ind,4);
        // background color
        PLONG(@(buf[ind]))^:=dswap(GetColor(SendMemo,BG));inc(ind,4);
 
        // вписываем фактическую длину в TLV(5)
        PWORD(@(buf[2]))^:=swap(ind-4);
        // подсчитывем фактическую длину TLV(2711)
        x:=length(blok)+27+length(sMess)+9;
        // ... и вписывем ее
        PWORD(@(buf[indmem]))^:=swap(x);
 
        // пепеносим данные с buf в FLAP
        PacketAppend(tmp,@buf,ind);
        // ack request ? (запрос подтверждения)
        // TLV(3)-пустой
        PacketAppend32(tmp,dswap($00030000));
      end;
 
     false:
      g&gt;begin // simple message
        // 0001 - simple
        PacketAppend16(tmp,swap($0001));
        // кому ?
        PacketAppendB_String(tmp,sUIN);
        // tlv(2)
        PacketAppend16(tmp,swap(2));
        // длина tlv(2)
        PacketAppend16(tmp,swap(13+length(sMess)));
        // 7 байт
        PacketAppend32(tmp,dswap($05010001));
        PacketAppend16(tmp,swap($0101));
        PacketAppend8(tmp,$01);
        // длина сообщения + 4
        PacketAppend16(tmp,swap(4+length(sMess)));
        // 4 байта = 0
        PacketAppend32(tmp,dswap($0));
        // сообщение
        PacketAppend(tmp,@(sMess[1]),length(sMess));
        // tlv(6) - пустой
        PacketAppend16(tmp,swap($0006));
        PacketAppend16(tmp,0);
      end;
     end;
     //case
     // посылаем пакет
     Form1.PacketSend(tmp);
     M(SendMemo,'Sending...');
 
     // пишем в журнал
     case MesFmtBox.Checked of
       // A - advanced
       true:  sTmp := '[A] ';
       // S - simple
       false: sTmp := '[S] ';
     end;
     // тут и так ясно
     sTmp := '-&gt;'+sTmp+DateTimeToStr(Now)+' '+
                  sNN+' ['+sUIN+']  "'+sMess+'"';
     M(Form1.Memo,sTmp);       Form1.LogMessage(sTmp);
 
     if MesFmtBox.Checked then begin
       // если advanced
       SendAnime.Active := true;
       SendMemo.Enabled := false;
       SendButton.Enabled := false;
       MesFmtBox.Enabled := false;
       // окно закроется только после получения
       // ACKов от сервера и от клиента (или вручную)
     end
     else
       // если simple, то окно сразу закрывается
       Close;
end;
</pre>

<p>Прием сообщений</p>
<p>Все сообщения приходят в SNAC(4,07).</p>
<p>У него такой же формат, как и у SNAC(4,06). Поэтому стоит сразу комментировать код:</p>
<pre>
unit Main.pas; 
 
 
 
procedure TForm1.SNAC_4_7(p:PPack);
var
    i,cnt,T,MessageFormat,SubMode,SubMode2,Empty : word;
    {myUIN,}
    hisUIN : longint;
    SubType : array[0..3] of byte;
    MessageSubType : longint absolute SubType;
    tmp,tmp2,tmp3 : PPack;
    sTemp : string;
    dTemp : TByteArray;
    typemes,
    {subtypemes,}
    unk,modifier,lenmes : word;
 
    // для SNAC(4,0B)-подтверждения принятых advanced сообщений
    d1,d2 : longint;
    ACK : TByteArray;
    ind : word;
 
    NewMsg : PMsgItem;
    FG : array[0..3] of byte;
    BG : array[0..3] of byte;
begin
     // сохраняем Cookie-1 и Cookie-2
     d1:=PacketRead32(p);
     d2:=PacketRead32(p);
     // читаем формат сообщения
     MessageFormat := swap(PacketRead16(p));
     // от кого ?
     sTemp := PacketReadB_String(p);
 
     // Cookie-1,Cookie-2 и некоторую другую часть пакета сохраним.
     // Эти данные необходимо включить в ACK на это сообщение
     ind:=0;
     PLONG(@(ACK[ind]))^:=d1; inc(ind,4);
     PLONG(@(ACK[ind]))^:=d2; inc(ind,4);
     PWORD(@(ACK[ind]))^:=swap(MessageFormat);inc(ind,2);
     PBYTE(@(ACK[ind]))^:=length(sTemp);inc(ind,1);
     MOVE(sTemp[1],ACK[ind],length(sTemp));inc(ind,length(sTemp));
     PWORD(@(ACK[ind]))^:=swap($0003);inc(ind,2);
 
     // преобразуем его UIN из строки в longint
     try hisUIN := strtoint(sTemp); except hisUIN:=0; end;
     M(Memo,'&lt; From: '+sTemp);
     PacketRead16(p);
     // узнаем сколько всего TLV во входящем пакете
     cnt := swap(PacketRead16(p));
     // читаем все эти TLV
     for i:=1 to cnt do
       // самый интересный - TLV(6)
       if TLVReadStr(p,sTemp)=6 then begin
         { в TLV(6) - его статус }
       end;
 
     // анализируем каждый из форматов
     case MessageFormat of
     $0001: begin
            M(Memo,'&lt; Message-format:1 (SIMPLE)');
            // чтение TLV(2) в sTemp
            TLVReadStr(p,sTemp);
            // скопируем sTemp во временный PPack,
            // для удобства обработки
            tmp := PacketNew;
            PacketAppend(tmp,@(sTemp[1]),length(sTemp));
            PacketGoto(tmp,0);
            // обработаем его
            PacketRead16(tmp);
            PacketRead16(tmp);
            PacketRead8(tmp);
            PacketRead16(tmp);
            // добрались до длины сообщения
            lenmes := swap(PacketRead16(tmp))-4;
            PacketRead32(tmp);
            // читаем сообщение в sTemp
            PacketRead(tmp,@sTemp[1],lenmes);
            SetLength(sTemp,lenmes);
            // анализ содержания сообщения
            DoSimpleMsg(hisUIN,sTemp);
            // удалим временный PPack
            PacketDelete(tmp);
            end;
 
     $0002: begin
            M(Memo,'&lt; Message-format:2 (ADVANCED)');
            // чтение TLV(5) в sTemp
            TLVReadStr(p,sTemp);
            // скопируем sTemp во временный PPack,
            // для удобства обработки
            tmp := PacketNew;
            PacketAppend(tmp,@(sTemp[1]),length(sTemp));
            PacketGoto(tmp,0);
            // обработаем его
            SubMode := swap(PacketRead16(tmp));
            PacketRead32(tmp);
            PacketRead32(tmp);
            PacketRead(tmp,@dTemp,16);
 
            case SubMode of
            $0000: begin
                   M(Memo,'SubMode: $0000 NORMAL');
                   TLVReadWord(tmp,SubMode2);
                   // TLV(F) - пустой
                   TLVReadWord(tmp,Empty);
                   // прием и анализ TLV(2711)
                   T := TLVReadStr(tmp,sTemp);
                   if T=$2711 then begin
                     // сохраняем кусок данных для ACKа
                     MOVE(sTemp[1],ACK[ind],47);inc(ind,47);
                     PLONG(@(ACK[ind]))^:=0; inc(ind,4);
 
                     // используем временный PPack
                     tmp2 := PacketNew;
                     PacketAppend(tmp2,@(sTemp[1]),length(sTemp));
                     PacketGoto(tmp2,0);
 
                     PacketRead(tmp2,@dTemp,26);
                     PacketRead8(tmp2);
                     PacketRead16(tmp2);
                     PacketRead16(tmp2);
                     PacketRead16(tmp2);
                     PacketRead(tmp2,@dTemp,12);
                     // читаем ТИП сообщения
                     typemes := PacketRead8(tmp2);
                     {subtypemes := }PacketRead8(tmp2);
                     unk:=swap(PacketRead16(tmp2));
                     modifier:=swap(PacketRead16(tmp2));
                     M(Memo,'Unk: $'+inttohex(unk,4));
                     M(Memo,'Modifier: $'+inttohex(modifier,4));
                     // длина сообщения
                     lenmes := PacketRead16(tmp2);
                     // анализ сообщения
                     NewMsg:=DoMsg(true,typemes,
                        lenmes,PCharArray(@(tmp2^.data[tmp2^.cursor])),
                        hisUIN,Now2DateTime);
                     // небольшая перемотка
                     PacketGoto(tmp2,(tmp2^.cursor)+lenmes);
                     // читаем Foreground и Background Colors
                     PacketRead(tmp2,@FG,4);
                     PacketRead(tmp2,@BG,4);
                     if NewMsg&lt;&gt;nil then begin
                       NewMsg^.FG:='$00'+inttohex(FG[2],2)+
                                         inttohex(FG[1],2)+
                                         inttohex(FG[0],2);
                       NewMsg^.BG:='$00'+inttohex(BG[2],2)+
                                         inttohex(BG[1],2)+
                                         inttohex(BG[0],2);
                     end;
                     // удаление временного PPack
                     PacketDelete(tmp2);
 
                     // дозаполнение ACK
                     PWORD(@(ACK[ind]))^:= 1; inc(ind,2);
                     PBYTE(@(ACK[ind]))^:= 0; inc(ind,1);
                     PLONG(@(ACK[ind]))^:= 0; inc(ind,4);
                     PLONG(@(ACK[ind]))^:=-1; inc(ind,4);
 
                     // посылка ACKа
                     tmp3 := CreatePacket($2,SEQ);
                     SNACAppend(tmp3,$4,$0B);
                     PacketAppend(tmp3,@ACK[0],ind);
                     PacketSend(tmp3);
                   end;
                   // Submode:$0000
                   end;
            $0001: M(Memo,'SubMode:$0001 ??? message canceled ???');
            $0002: M(Memo,'SubMode:$0002 FILE-ACK');
            // case SubMode
            end;
            PacketDelete(tmp);
            end;
 
     $0004: begin
            M(Memo,'&lt; Message-format:4 '+
                   '(url or contacts or auth-req or userAddedYou)');
            TLVReadStr(p,sTemp);
            tmp := PacketNew;
            PacketAppend(tmp,@(sTemp[1]),length(sTemp));
            PacketGoto(tmp,0);
 
            hisUIN := PacketRead32(tmp);
            typemes := PacketRead8(tmp);
            {subtypemes := }
            PacketRead8(tmp);
 
            lenmes := PacketRead16(tmp);
            DoMsg(true,typemes,
              lenmes,PCharArray(@(tmp^.data[tmp^.cursor])),
              hisUIN,Now2DateTime);
 
            PacketDelete(tmp);
            end;
       else M(Memo,'&lt; ??? SNAC 4,7; Message-format: '+s(MessageFormat));
     // case MessageFormat
     end;
end;
</pre>

<p>Урок №3</p>
<p>Запрос информации о клиенте,</p>
<p>Поиск клиентов по различным критериям и др.</p>
<p>Итак... Передавать и принимать сообщения уже умеем. На очереди - получение информации о клиентах, которые находятся в списке контактов; а также поиск новых клиентов по различным критериям. Такие запросы к серверу посылаются с помощью все тех же SNAC(15,2). Вспомните, как производится запрос оффлайновых сообщений.</p>
<p>Точно также SNAC(15,2) с типом запроса равным D007 применяется:</p>
<p>при всех операциях с Инфо клиентов ( и получение, и обновление своего);</p>
<p>при поиске клиентов по имени, по UINу, по E-mailу;</p>
<p>при изменении пароля;</p>
<p>при удалении UINа из реестра ICQ;</p>
<p>при многих других операциях.</p>
<p>Каждая из перечисленных операций определяется подтипом запроса. Приведу обобщенную таблицу SNAC(15,2) для некоторых запросов:</p>
<p>FLAP</p>
<p>Command Start 2A</p>
<p>Channel ID 02</p>
<p>Sequence Number XX XX</p>
<p>Data Field Length XX XX</p>
<p>SNAC (15, 02)</p>
<p>Family ID 00 15</p>
<p>SubType ID 00 02</p>
<p>Flags[0] 00</p>
<p>Flags[1] 00</p>
<p>Request ID 00 XX 00 02 (по ним можно опознать ответ)</p>
<p>TLV (1)</p>
<p>Type 00 01</p>
<p>Length XX XX</p>
<p>Value Length-2</p>
<p> (и что оно тут делает ?)</p>
<p>XX XX XX XX наш UIN</p>
<p>D0 07 тип запроса</p>
<p>XX 00 cookie</p>
<p>(по нему можно/нужно</p>
<p>опознавать ответ)</p>
<p>B2 04 подтип запроса</p>
<p>(B204 - запрос инфо клиента)</p>
<p>Это переменная часть зпроса.</p>
<p>Она определяется подтипом запроса.</p>
<p>Например:</p>
<p>При запросе инфо клиента (B2 04) или при поиске клиента по UINу (1F05) здесь следует разместить запрашиваемый UIN.</p>
<p>При поиске клиента по E-mail (2905) здесь будет помещена строка с искомым адресом.</p>
<p>При поиске по NickName, FirstName, LastName (1505) сюда помещаются соответственно три стоки.</p>
<p>При смене пароля (2E04) здесь будет лишь строка с паролем, а наш UIN сервер и так знает.</p>
<p>Теперь к Delphi-проекту добавлены еще два модуля: <a href="uinfo_pas.htm">UInfo</a> и <a href="suser_pas.htm">SUser</a> (User Info &amp; Search User).</p>
<p>Очередные исходники 3-его урока здесь. Т.к. все рассмотренные више запросы практически однотипные, то приведу комментарии только к одному из них. Это будет поиск по NickName, FirstName, LastName:</p>
<pre>
unit SUser; 
 
 
 
procedure TSearchUser.META_Search_User(NN,FN,LN : string);
var p : PPack;
    // промежуточный массив.
    // в нем накапливаются данные TLV(1)
    b : TByteArray;
    i : integer;
begin
     if (NN='')and(FN='')and(LN='') then exit;
     EndOfSearch := false;
 
     // word(b[0]) - тут будет ненужная длина
     // (но ее надо потом корректно заполнить)
     // а пока переходим к 3-у елементу
     i:=2;
 
     // вписываем UIN (только СВОЙ - укажем явно,что из модуля Main.pas)
     PLONG(@(b[i]))^ := main.UIN;    inc(i,4);
     // ТИП запроса
     PWORD(@(b[i]))^ := swap($D007);   inc(i,2);
     // придумаем себе COOKIE
     // (можно и по-проще, но в настоящей аське
     // COOKIE имеет такой вид XX00)
     Cookie := random($FF) shl 8;
     PWORD(@(b[i]))^ := swap(Cookie); inc(i,2);
     // ПОДТИП запроса
     PWORD(@(b[i]))^ := swap($1505);   inc(i,2);
 
     // добавляем три текстовые строки (First, Last, Nick)
     // у AOL новый тип строк наверное :)
     // впереди - длина строки, а в конце #0
     // (что-то одно из них убрали бы)
 
     // длина строки
     PWORD(@(b[i]))^ := length(FN)+1;  inc(i,2);
     // сама строка FirstName
     MOVE(FN[1],b[i],length(FN));     inc(i,Length(FN));
     // завершающий #0
     PBYTE(@(b[i]))^ := 0;             inc(i,1);
 
     // LastName
     PWORD(@(b[i]))^ := length(LN)+1;  inc(i,2);
     MOVE(LN[1],b[i],length(LN));     inc(i,Length(LN));
     PBYTE(@(b[i]))^ := 0;             inc(i,1);
 
     // NickName
     PWORD(@(b[i]))^ := length(NN)+1;  inc(i,2);
     MOVE(NN[1],b[i],length(NN));     inc(i,Length(NN));
     PBYTE(@(b[i]))^ := 0;             inc(i,1);
 
     // дозаполним "ненужную" длину в начале массива
     PWORD(@(b[0]))^ := i-2;
     // создаем FLAP-пакет
     P:=CreatePacket(2,SEQ);
     // добавляем SNAC(15,2)
     SNACAppend(p,$15,$2);
     // добавляем TLV(1) с данными из промежуточного массива
     TLVAppend(p,1,i,@b);
     // шлем запрос
     Form1.PacketSend(p);
     // пишем в Memo
     M(Form1.Memo,'&gt; Search Detail: Nick:'+NN+
                               '   First:'+FN+
                                '   Last:'+LN+'   '+
                                 'Cookie:$'+inttohex(Cookie,4));
end;
</pre>

<p>Запросы других подтипов передаются аналогично. С небольшими вариациями. Оновременно можем передавать на сервер много запросов. Сервер разберется. Ведь в каждом нашем запросе есть уникальное(ый) Cookie (а также и RequestID в SNAC-заголовке). Сервер пометит свои пакеты-ответы этими же опознавательными знаками.</p>
<p>Я лично делаю проверку(сверку) только по Cookie. Выдавая запрос, запоминаю Cookie. А когда приходит ответ от сервера, то процедура-обработчик SNAC_15_3 просто использует WinAPI функцию PostMessage для передачи ответа окну, которое выдало запрос. В параметрах PostMessage указан Cookie из ответа сервера. Какое окно его опознает - значит тому окну и предназначен ответ.</p>
<p>Работа процедуры-обработчика SNAC_15_3 уже ранее рассматривалась. Сейчас она просто дополнена новыми блоками, обрабатывающими новые ответы сервера. Следует упомянуть, что на один (единственный) наш запрос сервер присылает сразу целый массив из SNAC-ответов. Это типичная ситуация.</p>
<p>Например: запрашиваем Инфо о клиенте SNAC(15,2) [подтип запроса B204].</p>
<p>В ответ получим сразу восемь SNAC-ответов.</p>
<p>Вот их краткие названия-описания:</p>
<p>main-home-info</p>
<p>homepage-more-info</p>
<p>more-email-info</p>
<p>additional-info</p>
<p>work-info</p>
<p>about</p>
<p>personal-interests</p>
<p>past-background</p>
<p>Все полученные данные теперь сохраняются в файле .dat</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<h1>ICQ2000 − сделай сам (статья)</h1>

