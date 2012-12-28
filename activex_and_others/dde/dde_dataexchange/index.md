---
Title: Динамический обмен данными (DDE)
Date: 01.01.2007
---


Динамический обмен данными (DDE)
================================

::: {.date}
01.01.2007
:::

Динамический обмен данными (DDE)

 

DDE --- давний и прижившийся протокол обмена данными между разными
приложениями, появившийся еще на заре эры Windows. С тех пор на его базе
был создан интерфейс OLE, а в 32-разрядном API Windows появились и
другие методы межпрограммного взаимодействия. Но ниша, занимаемая DDE,
осталась неизменной --- это оперативная передача и синхронизация данных
в приложениях.

Приложения, использующие DDE, разделяются на две категории --- клиенты и
серверы (не путать с одноименной архитектурой СУБД). Оба участника
процесса осуществляют контакты (conversations) по определенным темам
(topic), при этом в рамках темы производится обмен элементами данных
(items). Устанавливает контакт клиент, который посылает запрос,
содержащий имена контакта и темы. После установления контакта всякое
изменение элемента данных на сервере передается данным клиента. Подробно
функции DDE описаны в \[4\].

Первоначально программирование DDE было чрезвычайно сложным делом ---
оно требовало взаимосвязанной обработки более чем десяти сообщений
Windows. В версии Windows 3.1 появилась библиотека DDEML, которая
перевела управление DDE на уровень вызова процедур. Разработчики
подсистемы DDE в Delphi, верные идеологии создания VCL, свели интерфейс
этого протокола к четырем компонентам --- двум для сервера и двум для
клиента.

На уровне поддержания контакта лежат компоненты TDDEServerConv и
TDDEClientConv. Первый играет пассивную роль --- он только указывает имя
одной из поддерживаемых сервером тем. Все операции по установлению и
разрыву контакта осуществляет из приложения-клиента второй компонент.

Посредством одного контакта могут быть связаны и синхронизированы
несколько пар элементов данных. Для их описания предназначены компоненты

TDDEServerItem и TDDEClientItem. Каждый из них во время работы должен
указывать на контакт, к которому он привязан. Кроме того, в составе
обоих есть свойства, содержащие некий текст. При установленном контакте
их содержимое синхронизируется.

Помимо этого в модуле DDEMAN описан и пятый компонент, который управляет
всеми связями DDE. Его рассмотрение выходит за рамки книги.

Начнем с рассмотрения двух компонентов, необходимых для создания сервера
DDE.

Компонент TDDeServerConv

TObject---\>TPersistent-\>TCoinponent---\>TDDeServerConv

Модуль DDEMAN

Страница Палитры компонентов System

В этом компоненте самую важную роль играет единственное свойство ---
Name. Имя компонента совпадает с именем темы, которую он поддерживает.
Клиент должен знать это имя при установлении контакта, за исключением
того случая, когда он подключается к данным контакта, которые
скопированы в буфер обмена (это реализует компонент TDDEServerItem).

В моменты открытия и закрытия контакта возникают события:

property OnOpen: TNotifyEvent;

property OnClose: TNotifyEvent;

Первоначально протокол DDE был ориентирован только на оперативное
получение данных клиентом от сервера, но позже его возможности
расширились. Клиент может передать для выполнения серверу набор
макрокоманд --- для этого у него есть нужные методы. На стороне сервера
за их исполнение отвечает обработчик события:

(pb) property OnExecuteMacro: TMacroEvent;

TMacroEvent = procedure(Sender: TObject; Msg: TStrings) of object;

Если вы хотите, чтобы ваш сервер DDE мог исполнять команды, то нужно
предусмотреть такой обработчик. Передаваемые команды содержатся в
параметре Msg в виде набора строк. Можно вызвать процесс выполнения
команд и из приложения, с помощью метода:

function ExecuteMacro(Data: HDDeData): Longint;

В этом случае параметр Data должен содержать дескриптор строки с
командами (типа pChar).

Компонент TDDeServerltem

TObject---\"TPersistent---\>TConiponent-\"TDDeServerI tern

Модуль DDEMAN

Страница Палитры компонентов System

Этот компонент реализует элемент данных, которые при установленном
контакте будут передаваться клиенту. В принципе, протокол DDE
подразумевает обмен любыми данными, формат которых зарегистрирован в
буфере обмена. Но для рассматриваемых компонентов Delphi эти возможности
ограничиваются

только текстовыми данными. Так что свойство, содержащее формат обмена
данными,

property Fmt: Integer;

всегда равно CF\_TEXT. Данные содержатся в свойствах:

property Text: string;

property Lines: TStrings;

По сути дела, первое свойство представляет собой подмножество второго.
При чтении Text равен первой строке Lines. Но если вы присваиваете ему
значение, все прочие строки Lines очищаются. Элемент данных должен быть
связан с определенной темой. В свойстве:

(Pb) property ServerConv: TDDeServerConv;

может быть задана ссылка на компонент типа TDDEServerConv, чье имя будет
темой контакта DDE. Можно обойтись и без использования такого
компонента. В этом случае именем темы будет являться заголовок (Caption)
той формы, которая содержит TDDEServerItem. Элемент данных может быть
скопирован в буфер обмена в специальном формате (в виде информации о
контакте), с помощью метода:

procedure CopyToClipboard;

Для вступления в контакт посредством буфера обмена клиент может вызвать
функцию GetPasteLinkInfo (см. ниже), и, проанализировав имена сервера,
темы и элемента, принять решение о вступлении. Клиент может
переустановить данные сервера. При переустановке возникает событие:

property OnPokeData: TNotifyEvent;

Кроме того, для этого вами может быть использован метод:

function PokeData(Data: HDDeData): Longint;

Параметр Data должен представлять собой дескриптор области памяти, в
которой содержится текстовая строка типа pChar. В отличие от OnPokeData,
событие:

property OnChange: TNotifyEvent;

возникает при любом изменении данных, как при присвоении значений
свойствам Text или Lines, так и при вызове PokeData. Оно может также
быть вызвано явно из метода:    \^

procedure Change;

Компонент TDDECIIentConv

TObject-\>TPersistent-\>TComponent---\>TDDEClientConv

Модуль DDEMAN

Страница Палитры компонентов System

Компонент TDDEClientConv осуществляет контакт на клиентской стороне.
Именно в нем описаны методы, отвечающие за установление контакта. Имена
требуемых сервера DDE и темы содержатся в свойствах:

property DDEService: String;

property DDETopic: String;

Сервер и тема устанавливаются при вхождении в контакт. Предусмотрены два
режима вхождения в него:

property ConnectMode: TDataMode;

TDataMode = (ddeAutomatic, ddeManual);

Метод

function SetLink(const Service: string; const Topic: string): Boolean;

присваивает серверу и теме имена, равные Service и Topic, а если выбран
режим контакта ddeAutomatic --- то и устанавливает контакт. Будьте
внимательны при задании параметров метода--- здесь учитывается регистр
символов. В случае режима ddeManual для установления контакта необходимо
вызвать дополнительно метод:

function OpenLink: Boolean;

Этот метод сначала закрывает предыдущий контакт, затем он пытается
связаться с сервером DDEService на тему DDETopic. Если это не удается
сразу (например, если требуемый сервер DDE отсутствует), то делается
попытка загрузить программу с именем, определенным в свойстве

(Pb) property ServiceApplication: String;

и установить контакт с ней. Если оно не определено (ServiceApplication =
\"), то в качестве последней попытки для контакта пробуется имя,
представляющее собой конкатенацию имен сервера и темы, разделенных
пробелом. В случае неудачи метод OpenLink возвращает False.

Можно связаться с сервером, если он поместил данные о контакте в буфер
обмена. В этом случае метод

function PasteLink: Boolean;

переключит компонент на новый контакт и вернет значение True. Наконец,
метод

procedure CloseLink;

разрывает контакт с сервером DDE.

Метод

function StartAdvise: Boolean;

инициирует начало обмена данными. Обычно он вызывается в методе
OpenLink.

Как уже упоминалось, основное направление потоков данных --- от сервера
к клиенту, однако возможно и обратное. При помощи двух методов можно
присвоить новые значения элементу данных сервера:

function PokeDataLines(const Item: string; Data: TStrings): Boolean;

function PokeData(const Item: string; Data: PChar): Boolean;

Здесь Item --- имя элемента данных, Data --- передаваемые текстовые
данные. Кроме того, некоторые серверы DDE имеют собственные наборы
макрокоманд, запрос на выполнение которых можно послать от клиента. К
ним относятся многие приложения, в т. ч. СУБД и электронные таблицы,
такие, как Paradox и MS Excel; наиболее типичным примером служит Program
Manager. Запрос на выполнение макрокоманд посылают методы:

function ExecuteMacroLines(Cmd: TStrings; waitFIg: Boolean):
Boolean-function ExecuteMacro(Cmd: PChar; waitFIg: Boolean): Boolean;

Серверу может потребоваться определенное время для выполнения этих
операций. Если до их окончания снова загрузить его работой, то это может
привести к непредсказуемым результатам. Чтобы отследить состояние
сервера, нужно установить параметр функции waitFIg в True. С началом
операции свойство

property WaitStat: Boolean;

устанавливается в True. При этом вызовы последних четырех описанных
методов отрабатываться не будут, пока сервер не известит об окончании
операции, и WaitStat не примет значение False. Это свойство доступно
только по чтению. Клиент может запросить данные от сервера немедленно с
помощью метода:

function RequestData(const Item: string): PChar;

Формат обмена данными можно узнать из свойства:

property DDEPmt: Integer;

Перефразируя Генри Форда, скажем, что можно обмениваться данными любого
формата, если этот формат --- CF\_TEXT.

Если возможностей, предоставляемых методами и свойствами класса,
недостаточно, то для вызова процедур библиотеки DDEML программисту
доступен дескриптор контакта:

property Conv: HConv;

В полученном от сервера тексте могут быть специальные управляющие
символы --- \<Enter\>, \<Tab\>, \<Backspace\> и другие. Их можно
отфильтровать (подавить), если свойство

property FormatChars: Boolean;

установлено в False. В этом случае все символы ASCII с десятичными
кодами от 1 до 31 заменяются на пробел (код 32). В случае True
преобразования не происходит.

Так же, как и в TDDEServerConv, при открытии и закрытии контакта вы
можете выполнить специфотеские действия путем обработки событий:

property OnOpen: TNotifyEvent;

property OnClose: TNotifyEvent;

Свойство

property DataMode: TDataMode;

по-видимому, зарезервировано ддя дальнейших применений.

Компонент TDDECIientltem

TObject---\>TPersistent---\"TComponent---\>TDDEClientItem

Модуль DDEMAN

Страница Палитры компонентов System

Этот компонент представляет элемент данных на клиентской стороне. После
установления контакта с сервером нужно присвоить свойству

property DDEConv: TDDEClientConv;

указатель на объект, соответствующий появившемуся контакту, а свойству

property DDEItem: String;

имя элемента данных сервера. В этом случае все изменения будут
отслеживаться.

В рассмотренном ниже примере приложение-клиент вступает в контакт с
сервером InfbServer на тему TimeTopic. При нажатии кнопки TimeButton
связь устанавливается, при отпускании --- разрывается. Метод
TimeConvOpen, служащий обработчиком события ОпОреп, присваивает значения
именам темы и элемента данных.

     
    const
      InfoServer = 'infoserv';
      TimeConversation = 'TimeTopic';
      ServerTimeItem = 'Timeltem' ;
      SCannotStart = 'Cannot start conversation';
     
    procedure TFormI.TimeButtonClick(Sender: Tobject);
    begin
      if TimeButton.Down then 
        begin
          if not TimeConv.SetLink(InfoServer, TimeConversation) or not TimeConv.OpenLink then 
            begin
              MessageDIg(SCannotStart, mtError, [mbOk], 0) ;
              TimeButton.Down := False;
            end 
        end 
      else 
        TimeConv.CloseLink;
    end;
     
    procedure TPormI.TimeConvOpen(Sender: TObject);
    begin
      ClientTimeItem.DDEConv := TimeConv;
      ClientTimeItem.DDEItem := ServerTimeItem;
    end;

Организация данных у клиента сходна с той, которая принята на сервере:

property Text: String;

property Lines: TStrings;

Свойство Text является подмножеством Lines и содержит первую строку
этого набора.

Когда изменяются данные на сервере, эти изменения отражаются в
TDDEClientItem. В этот момент происходит событие:

property OnChange: TNotifyEvent;

В обработчике этого события и нужно предусмотреть реакцию на изменение
данных --- пересчет формулы, обновление текста и т. п.

Принципы работы с DDE отражены в примере DDEINFO. Приложение-сервер
запускает таймер и с установленным периодом формирует текстовые строки
со значением текущего времени и количества свободной памяти. Эти строки
являются элементами данных соответствующих тем DDE. На форме клиента
находятся две кнопки --- Time и Memory. При их нажатии происходит
попытка входа в соответствующий контакт. Если она была успешной, кнопка
утапливается, и на ней отображается время или количество свободной
памяти. При отжатии кнопки контакт разрывается.