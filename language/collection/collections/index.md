---
Title: Коллекции и работа с ними
Date: 03.05.2000
Source: <https://www.delphikingdom.ru/helloworld/tcollection.htm>
---


Коллекции и работа с ними
=========================

## 1. ТЕОРИЯ

### 1.1. Почему коллекции?

Действительно, а почему, собственно, коллекции? Ведь существует класс
TList, это классический список, принципы построения и использования
таких списков хорошо известны и подробно описаны в литературе, сам этот
класс достаточно прост, но содержит все необходимое - так зачем же еще
какие-то ухищрения?

Ответ на этот вопрос, очевидно, следующий - разработчики Delphi ввели
класс TCollection для удобства своих пользователей. И, конечно, для
расширения возможностей самой Delphi.

Главное отличие класса TCollection от класса TList состоит в том, что
он, во-первых, предназначен, в основном, для создания не обычных, а как
бы "визуальных" списков и, во-вторых, Delphi содержит готовые
средства, поддерживающие работу с коллекциями в design-time.

Что значит "визуальный" список? Это список, элементы которого должны
каким-то образом отображаться на экране. Возьмем, например, шапку
какой-либо таблицы. Ясно, что она содержит заголовки столбцов, причем
каждый заголовок - это строка, которую видит пользователь. Это и есть
"визуальный" список, а сами заголовки, очевидно, являются элементами
этого списка.

А что значит "поддержка в design-time"? Это значит, что добавлять
элементы к коллекции, удалять их и настраивать их свойства можно так же
легко и просто, как мы это делаем, работая с компонентами. Для этого
используется Object Inspector и еще один встроенный в Delphi редактор,
который так и называется - Collection Editor. И еще, что очень важно,
коллекции построены на основе класса TPersistent (в отличие от TList,
являющегося прямым потомком TObject) - а это означает, что Delphi умеет
запоминать в файле формы все настройки коллекции и ее элементов, которые
мы делаем в design-time. Со списком TList без его модификации такое
невозможно.

Вернемся к примеру с заголовками столбцов в шапке таблицы. Можно
реализовать их список на основе класса TList? Безусловно, можно. Но
работать с элементами такого списка нам придется только в run-time, что,
согласитесь, не очень удобно (ведь потребуется "ручное" написание
дополнительного кода, в котором, кстати, не исключены и ошибки). Если
программист знает механизмы работы самой Delphi, то на основе класса
TList он, конечно, может написать специальный объект-список, специальный
редактор для него и получить поддержку списка в design-time. Но что
делать другим программистам? Ответ - использовать уже существующие
именно для подобных целей коллекции с их готовым редактором Collection
Editor. И, конечно, не забыть сказать "спасибо" разработчикам Delphi,
позаботившимся о нашем удобстве.

Только ли для построения "визуальных" списков предназначены коллекции?
Естественно, нет, с их помощью можно создавать любые списки. Но именно
при построении "визуальных" списков преимущества коллекций проявляются
особенно отчетливо. Вы легко убедитесь в этом, поработав, например, с
компонентом THeaderControl и его свойством Sections.

Посмотрев исходный текст модуля Classes, легко убедиться, что сами
коллекции построены на основе все того же списка TList. Таким образом,
можно сказать, что коллекции - это "списки специального назначения".

### 1.2. Основные особенности коллекций и их элементов

Любая коллекция - это объект (но не компонент), потомок класса
TCollection. Она содержит элементы, причем каждый элемент - это тоже
объект (но тоже не компонент), потомок класса TCollectionItem. Оба этих
класса являются лишь базовыми, то есть имеют только ту функциональность,
которая нужна для самой коллекции и ее взаимодействия с IDE. Чтобы
получить что-то полезное в прикладном смысле, мы должны построить свой
класс "элемент коллекции" и свой класс "коллекция", введя в них
нужные свойства и методы (а, если требуется, то и события). Это делается
обычным образом, с использованием наследования и будет рассмотрено ниже.
Сейчас, для того, чтобы лучше понять отличия коллекций от списков на
основе класса TList, разберем их основные особенности. Именно основные и
именно особенности, потому что все подробности, конечно, есть в справке
Delphi и в ее исходных текстах (модуль Classes). Начнем с класса
TCollectionItem.

Свойство Collection. Указывает на коллекцию, которой принадлежит данный
элемент. Требуется для корректной работы коллекции с внутренним списком
своих элементов. Автоматически назначается при создании элемента.
Позволяет легко "перебросить" элемент из одной коллекции в другую, что
при использовании списков на основе TList было бы все же посложнее.

Свойство DisplayName. Строка, представляющая элемент в Collection
Editor. По умолчанию это всего лишь имя класса элемента, но может быть
использовано и более полезным образом (например, для того же заголовка
столбца таблицы). В последнем случае это свойство часто сопоставляется с
каким-то другим, которое и появляется в Object Inspector под более
смысловым именем (например, под именем Text в THeaderSection или
TStatusPanel).

Свойство ID. Уникальный целочисленный идентификатор элемента внутри
коллекции. Доступен только для чтения и автоматически назначается при
вставке элемента в коллекцию. Может измениться только при "переброске"
элемента в другую коллекцию (в отличие от свойства Index, которое может
меняться при вставке, удалении или переупорядочивании элементов в
пределах одной коллекции). Даже если элемент был удален из коллекции,
его ID для новых элементов повторно не используется.

Свойство Index. Порядковый номер элемента в коллекции. Аналог индекса
элемента в TList.

Метод GetNamePath. Используется в IDE для идентификации элемента
коллекции. Возвращает строку, которая появляется в верхнем окошке Object
Inspector, когда данный элемент выбирается в Collection Editor. Этот
метод - часть поддержки работы в design-time, но вряд ли может быть
полезен для прикладной программы.

Метод Changed. Этот protected-метод должен вызываться наследниками
TCollectionItem каждый раз, когда меняются существенные свойства
элемента и требуется уведомить об этом коллекцию. Приводит к вызову
метода Update коллекции, что может быть использовано, например, для
перерисовки, для обновления каких-то связей между элементами коллекции
(если таковые существуют), да и вообще для любых других целей. При
создании и уничтожении элемента метод Update коллекции вызывается
автоматически.

Других свойств класс TCollectionItem не содержит, а его остальные
методы, в общем, вполне стандартны (за исключением конструктора и
деструктора, которые, конечно, выполняют свои обычные функции, но имеют
несколько необычную реализацию, а также дополнительных методов для
взаимодействия с IDE в design-time). События в этом классе не
определены, но, если требуется, то никто не мешает нам определить любые
события в потомках этого класса.

Теперь рассмотрим особенности класса TCollection.

Свойство Count. Количество элементов в коллекции. Аналог такого же
свойства TList.

Свойство ItemClass. Дает фактический класс элементов коллекции. Этот
класс задается при создании коллекции и в дальнейшем быть изменен не
может. Все элементы коллекции имеют один и тот же класс (в этом смысле
список на основе TList более гибок, так как не имеет подобного
ограничения).

Свойство Items. Массив элементов коллекции. Аналог такого же свойства
TList.

Методы Add, Clear и Insert. Аналоги соответствующих методов TList, но с
одним важнейшим отличием. При добавлении (вставке) объекта в список
TList или его удалении из списка сам объект не создается и,
соответственно, не уничтожается. Те же операции с коллекцией приводят к
автоматическому созданию и уничтожению экземпляра объекта. Конечно, это
возможно именно потому, что в случае коллекции класс объекта известен
заранее, а в случае TList объект может быть любым.

Метод Assign. Копирует элементы одной коллекции в другую. Конечно, если
классы элементов этих коллекций не совпадают, возникнет ошибка. Кстати,
такое копирование стало возможным как раз потому, что коллекции и их
элементы построены на основе класса TPersistent, в то время как подобная
операция со списками TList требует дополнительного кода.

Методы BeginUpdate и EndUpdate. Эти методы проще всего рассмотреть на
примере перерисовки. Выше отмечалось, что коллекции предназначены, в
основном, для создания "визуальных" списков. Если один из элементов
коллекции обновляется, это приводит к его обновлению и на экране. Если
же обновляются сразу несколько элементов, то нет смысла выполнять
промежуточные перерисовки экрана, а надо выполнить только одну - после
обновления всех элементов. Это и позволяют сделать два рассматриваемых
метода. Важно знать, что перерисовка происходит только после того, как
метод EndUpdate будет вызван ровно столько раз, сколько перед этим был
вызван BeginUpdate. Чтобы гарантировать правильную работу, обычно эти
вызовы используются совместно с блоком try:finally. Конечно, этот
механизм может быть использован при любом обновлении элементов
коллекции, а не только для их перерисовки.

Метод FindItemID. Дает элемент коллекции с заданным ID (либо Nil, если
такового нет).

Метод GetNamePath. Используется для внутренних нужд IDE, как часть
поддержки работы в design-time. Для прикладного программиста этот метод
вряд ли представляет интерес.

Метод Changed. Этот protected-метод должен вызываться наследниками
TCollection при изменении существенных свойств коллекции. Приводит к
вызову метода Update, но не сразу, а после ее полного обновления (см.
BeginUpdate и EndUpdate).

Метод Update. В классе TCollection этот protected-метод не делает
ничего, но потомки могут заместить его для фактического обновления
коллекции (например, для той же перерисовки).

В остальном класс TCollection - это, в общем-то, обычный объект (за
исключением того, что имеет ряд дополнительных методов, обеспечивающих
взаимодействие с IDE в design-time). Никакие события в этом классе не
определены, но могут быть определены в его потомках.

### 1.3. Владелец коллекции и класс TOwnedCollection

В большинстве случаев коллекции используются, как свойства компонентов
(собственно, это и есть их основное назначение). Пусть, например, мы
разрабатываем компонент, который должен содержать список некоторых
объектов. Тогда сначала мы определяем класс "элемент коллекции", затем
класс самой коллекции и, наконец, вводим в наш компонент свойство, как
объект этого класса. Это свойство и будет представлять искомый список
объектов, причем мы сможем работать с ним в design-time, не предпринимая
для этого никаких дополнительных усилий.

В рассмотренном случае наш компонент будет владельцем (owner) коллекции.
Согласно общей идеологии Delphi и для обеспечения правильной работы IDE
в классе самой коллекции следует заместить метод GetOwner, который любая
коллекция наследует от класса TPersistent. Все, что этот метод должен
делать - это возвращать ссылку на компонент-владелец и в Delphi
определен еще один класс - TOwnedCollection, в котором такая
функциональность уже реализована.

Вопрос - если мы создаем коллекцию, планируя использовать ее именно как
свойство компонента, то должны ли мы в качестве ее предка выбирать
только класс TOwnedCollection, или можно использовать общий класс
TCollection?

Ответ - правильно и то, и другое, но во втором случае мы должны сами
позаботиться о замещении метода GetOwner. Можно даже в раздел public (но
только не в published) ввести read-only свойство Owner, также дающее
ссылку на владельца (через тот же метод GetOwner). Тем самым, не
затрачивая лишних ресурсов (свойства не требуют памяти) мы дополнительно
усиливаем сходство создаваемой коллекции с компонентом - ведь все
компоненты имеют свойство Owner.

### 1.4. Резюме по теоретической части

Итак, коллекция - это объект, реализующий список других объектов. Его
основное отличие от общего списка TList заключается в том, что, не
будучи компонентом, он в design-time допускает работу с собой, как с
компонентом. Для этого используются общий редактор всех компонентов
Object Inspector и специальный редактор свойства Collection Editor.
Такая особенность поддерживается как IDE, так и самой коллекцией, что
налагает на ее реализацию ряд требований.

## 2. ПРАКТИКА

Прикладным программистам, особенно мало знакомым с работой самой IDE все
предыдущее вполне могло показаться слишком неинтересным или слишком
сложным. Настало время показать, что это вовсе не так. Создадим учебный
компонент - потомок TShape, содержащий коллекцию визуальных точек. Его
практическая ценность довольно сомнительна, но для демонстрационных
целей такой компонент неплох, поскольку он достаточно прост и поэтому
"лес не будет слишком заслонен деревьями" (ведь наша основная цель -
научиться работать с коллекциями).

Итак, запускаем Delphi, щелкаем по File \| New, выбираем и нажимаем OK.
В поле пишем слово , а в поле - слово и нажимаем . Переходим на вкладку
, нажимаем и задаем путь к создаваемому пакету, а в качестве его имени
указываем, например, . Далее на все вопросы отвечаем нажимом кнопок
"Да" - и в итоге на странице Samples палитры получаем свежесозданный
компонент DappledShape, который пока еще ничем не отличается от своего
предка - стандартного Shape.

На экране будет окно, в котором отображается состав нового пакета
HelloWorld. Не нужно его закрывать, оно еще понадобится - ведь после
всех изменений пакет надо перекомпилировать (кнопка ). А мы перейдем в
окно редактора с текстом модуля DappledShape и, наконец, займемся
настоящим программированием. Практически весь код нам придется писать
вручную, но что может быть интереснее, не правда ли?

### 2.1. Создание элемента коллекции

Итак, элемент нашей коллекции будет представлять визуальную точку. Такая
точка имеет две координаты центра и цвет. Конечно, можно ввести еще
множество других параметров (размер, форма, вид кисти и т.д.), но мы не
будем усложнять и ограничимся перечисленными тремя.

В разделе interface сразу после слова type пишем следующее объявление
класса, который и будет представлять элемент нашей коллекции.

    TSpot = class(TCollectionItem)
    private
      FCenterX: integer;
      FCenterY: integer;
      FColor: TColor;
    public
      constructor Create(Collection: TCollection); override;
    published
      property CenterX: integer read FCenterX write SetCenterX default 3;
      property CenterY: integer read FCenterY write SetCenterY default 3;
      property Color: TColor read FColor write SetColor default clBlack;
    end;

Почему это объявление именно такое, а не какое-то другое? Очень просто -
мы хотели ввести три свойства и ввели их, а конструктор нужен для
присвоения им значений по умолчанию.

Теперь ставим курсор куда-то в середину этого объявления и нажимаем
Ctrl+Shift+C. Умница Delphi добавляет еще три метода и создает скелет
реализации. Остается только на языке Object Pascal объяснить, чего же
мы, собственно, хотим. Итак, пишем реализацию.

    constructor TSpot.Create(Collection: TCollection);
    begin
    // Создаем сам объект и инициализируем его поля
      inherited Create(Collection);
      FCenterX := 3;
      FCenterY := 3;
      FColor := clBlack
    end;
     
    procedure TSpot.SetCenterX(const Value: integer);
    begin
    // Если значение новое, запоминаем его и запрашиваем перерисовку
      if FCenterX <> Value then
        begin
          FCenterX := Value;
          Changed(False)
        end
    end;
     
    procedure TSpot.SetCenterY(const Value: integer);
    begin
      if FCenterY <> Value then
        begin
          FCenterY := Value;
          Changed(False)
        end
    end;
     
    procedure TSpot.SetColor(const Value: TColor);
    begin
      if FColor <> Value then
        begin
          FColor := Value;
          Changed(False)
        end
    end;

Весь этот код, в общем-то, совершенно стандартный, но для тех, кто не
имеет достаточного опыта в написании классов, приведу все же некоторые
пояснения.

Конструктор. Здесь его замещение нужно только для того, чтобы присвоить
полям объекта начальные значения. Те же значения указаны в объявлениях
свойств, но это не значит, что они будут присвоены автоматически.
Наоборот, описатель default в объявлении свойства просто информирует IDE
о том, какое значение это свойство получает по умолчанию. Если текущее
значение свойства и его значение по умолчанию совпадают, то IDE не будет
сохранять текущее значение в файле формы, что уменьшает размер
программы.

Методы . Это так называемые методы доступа к свойствам (точнее, методы
их записи), причем в данном случае все они практически одинаковы. После
присваивания вызывается метод Changed, что информирует коллекцию об
изменении элемента и, как мы увидим далее, приводит к перерисовке.
Предварительная проверка равенства нового и текущего значений позволяет
избежать ненужных действий, особенно, лишней перерисовки.

Если в программе написано, например, Color:=clRed, то вместо прямого
присваивания компилятор сгенерит вызов метода записи SetColor(clRed) и,
таким образом, перерисовка будет выполнена автоматически. Почти то же
самое происходит и при установке свойства в design-time.

### 2.2. Создание самой коллекции

Создание элемента коллекции полностью закончено. Возвращаемся в раздел
interface и сразу же после объявления класса TSpot пишем две следующие
строки.

    TDappledShape = class;
    TItemChangeEvent = procedure(Item: TCollectionItem) of object;

Первая строка - это так называемое опережающее объявление класса. При
вставке коллекции в компонент этот прием является стандартным и
позволяет использовать еще не объявленный класс самого компонента в
объявлении класса коллекции (что, в свою очередь, дает возможность
реализовать метод GetOwner).

Вторая строка определяет так называемый тип обработчика события. Наше
событие будет означать, что произошло какое-то изменение элемента
коллекции (параметр Item). Собственно говоря, введение такого события
совсем не обязательно и сделано лишь с целью иллюстрации.

Теперь мы можем объявить класс самой коллекции.

    TSpotCollection = class(TCollection)
    private
      FDappledShape: TDappledShape;
      FOnItemChange : TItemChangeEvent;
    protected
      function GetOwner: TPersistent; override;
      procedure Update(Item: TCollectionItem); override;
      procedure DoItemChange(Item: TCollectionItem); dynamic;
    public
      constructor Create(DappledShape: TDappledShape);
      function Add: TSpot;
      property Items[Index: Integer]: TSpot read GetItem write SetItem; default;
    published
      property OnItemChange: TItemChangeEvent read FOnItemChange write FOnItemChange;
    end;

Если не учитывать добавленное нами событие (поле FOnItemChange, метод
DoItemChange и свойство OnItemChange), то можно сказать, что такое
объявление коллекции является практически стандартным. Описатель default
для свойства Items здесь имеет иной смысл, чем ранее. Он означает, что
само свойство Items является "свойством по умолчанию" - то есть, что,
если в программе объявлена, например, переменная MySpotCollection:
TSpotCollection, то синтаксические конструкции MySpotCollection\[i\] и
MySpotCollection.Items\[i\] будут эквивалентны.

Теперь поступаем так же, как и прежде - ставим курсор куда-то внутрь
этого объявления, нажимаем Ctrl+Shift+C, получаем скелет реализации и
дописываем код. Обратите внимание, что и в этом случае Delphi добавляет
в раздел private два метода доступа - GetItem (чтение) и SetItem
(запись), которые мы ввели при объявлении свойства Items. Однако
коллекции требуют, чтобы эти два метода были доступны классам-потомкам и
поэтому они должны быть объявлены в разделе protected, куда нам и
следует их перенести вручную. В итоге получим следующее.

    function TSpotCollection.Add: TSpot;
    begin
    // Получаем общий TCollectionItem и приводим его к нашему TSpot
      Result := TSpot(inherited Add)
    end;
     
    constructor TSpotCollection.Create(DappledShape: TDappledShape);
    begin
    // Создаем коллекцию и запоминаем ссылку на ее владельца
      inherited Create(TSpot);
      FDappledShape := DappledShape
    end;
     
    procedure TSpotCollection.DoItemChange(Item: TCollectionItem);
    begin
    // Стандартный вызов пользовательского обработчика события
      if Assigned(FOnItemChange) then FOnItemChange(Item)
    end;
     
    function TSpotCollection.GetItem(Index: Integer): TSpot;
    begin
    // Получаем общий TCollectionItem и приводим его к нашему TSpot
      Result := TSpot(inherited GetItem(Index))
    end;
     
    function TSpotCollection.GetOwner: TPersistent;
    begin
    // Возвращаем ранее запомненную ссылку на владельца коллекции
      Result := FDappledShape
    end;
     
    procedure TSpotCollection.SetItem(Index: Integer; const Value: TSpot);
    begin
    // Просто используем унаследованный метод записи
      inherited SetItem(Index, Value)
    end;
     
    procedure TSpotCollection.Update(Item: TCollectionItem);
    begin
    // Вызов унаследованного метода здесь лишний, но это грамотный стиль. Он
    // гарантирует верную работу даже при изменениях в новых версиях Delphi.
      inherited Update(Item);
    // Даем запрос на перерисовку компонента-владельца
      FDappledShape.Invalidate;
    // Возбуждаем событие - сигнал об изменении элемента
      DoItemChange(Item)
    end;

Практически весь приведенный код реализации коллекции можно
рассматривать, как совершенно стандартный и использовать его аналог чуть
ли не для всех коллекций. Как видим, замещение методов класса-предка
нужно, в общем-то, лишь для поддержки работы с конкретными используемыми
классами элемента коллекции и ее владельца.

Замещение метода Update позволяет обновить компонент-владелец при
изменении любого элемента коллекции (а также при их добавлении к
коллекции и удалении из нее). Использованный в данном примере способ
обновления не является оптимальным (поскольку при изменении всего лишь
одного элемента перерисовывается весь компонент) и выбран лишь из-за
своей простоты.

В том же методе Update возбуждается введенное нами событие. При этом
пользовательский обработчик вызывается не напрямую, а через так
называемый метод диспетчеризации события - в данном случае,
DoItemChange. Это стандартный подход. Он позволяет потомкам класса
заместить метод диспетчеризации и, таким образом, встроить в цепочку
обработки события свой код, не затрагивая никаких других аспектов. Но
такая необходимость возникает все же достаточно редко и потому, с целью
некоторой экономии памяти, методы диспетчеризации событий практически
всегда объявляются, как динамические, а не виртуальные.

Итак, коллекция создана. Но для того, чтобы использовать ее по
назначению, нужно сначала "вживить" ее в компонент.

### 2.3. Внедрение коллекции в компонент

С самого начала Delphi создала нам скелет объявления класса
TDappledShape и сейчас, наконец, настало время его оживить. Пишем
следующее.

    TDappledShape = class(TShape)
    private
      FSpots: TSpotCollection;
    protected
      procedure Paint; override;
    public
      constructor Create(AOwner: TComponent); override;
      destructor Destroy; override;
    published
      property Spots: TSpotCollection read FSpots write SetSpots;
    end;

Что мы сделали? Во-первых, ввели в компонент коллекцию (поле FSpots и
свойство Spots с методом записи SetSpots). Далее, поскольку коллекция -
это объект, то ее надо сначала создать, а затем уничтожить, поэтому
замещаем конструктор и деструктор. Наконец, для отрисовки элементов
коллекции замещаем метод Paint. И, конечно, чтобы с коллекцией можно
было работать в design-time, свойство Spots обязательно должно быть
помещено в раздел published.

Далее, как обычно - курсор внутрь класса, Ctrl+Shift+C и пишем
реализацию.

    constructor TDappledShape.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FSpots := TSpotCollection.Create(Self)
    end;
     
    destructor TDappledShape.Destroy;
    begin
      FSpots.Free;
      inherited Destroy
    end;
     
    procedure TDappledShape.Paint;
    var
      SaveColor: TColor;
      SaveStyle: TBrushStyle;
      i: integer;
    begin
      inherited Paint;
      SaveColor := Canvas.Brush.Color;
      SaveStyle := Canvas.Brush.Style;
      Canvas.Brush.Style := bsSolid;
      for i := 0 to FSpots.Count - 1 do
        with FSpots.Items[i] do
          begin
            Canvas.Brush.Color := Color;
            Canvas.Ellipse(CenterX - 3, CenterY - 3, CenterX + 3, CenterY + 3)
          end;
      Canvas.Brush.Style := SaveStyle;
      Canvas.Brush.Color := SaveColor
    end;
     
    procedure TDappledShape.SetSpots(const Value: TSpotCollection);
    begin
      FSpots.Assign(Value)
    end;

Весь этот код, в общем, очевиден и некоторых комментариев, пожалуй,
требует только метод SetSpots. Тем более, что его код опять-таки
стандартен для внедренного в компонент объектного свойства, в частности,
для свойства-коллекции.

Что произойдет, если написать Object1:=Object2 ? Поскольку Object1 и
Object2 - это, по сути, указатели, то после прямого копирования значения
Object2 в Object1 оба указателя будут ссылаться на один и тот же объект.
Если перед этим Object1 указывал на другой объект, то ссылка потеряется
и объект "зависнет" в памяти - но никакого копирования "начинки"
Object2 в Object1 не произойдет.

Чтобы скопировать не адрес объекта, а его "начинку" используется метод
Assign. Но мы поместили его вызов внутрь метода записи - а это означает,
что обычное присвоение нашей коллекции какого-либо значения скопирует
именно элементы, а не адрес присваиваемой коллекции (в самом деле, ведь
вместо присвоения компилятор сгенерит вызов метода SetSpots).

Вот и все! Теперь осталось только сохранить готовый модуль, вспомнить,
что где-то в недрах экрана висит окно пакета HelloWorld, найти его и
нажать кнопку Compile. После этого можем с удовольствием пользоваться
собственным компонентом с собственной коллекцией.

## ПОСЛЕСЛОВИЕ

Мы рассмотрели особенности коллекций, как списков и на практике прошли
весь, от начала и до самого конца путь разработки коллекции и ее
внедрения в компонент. Надеюсь, эта статья окажется полезной - прежде
всего, начинающим программистам, для которых она и писалась.

А мне остается попрощаться и пожелать Вам, читатель, хорошего
коллекционирования!

--  
Юрий Зотов,  
03 мая 2000  
Специально для "Королевства Delphi".


## Приложение:

Полный текст модуля

    // Пример разработки и использования коллекции.
    // Юрий Зотов (yurzosoft@mtu-net.ru?subject=Collections).
    // 29 апреля 2000 года.
    // Специально для сайта "Королевство Delphi" (http://delphi.vitpc.com).
     
    unit DappledShape;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls;
     
    type
      TSpot = class(TCollectionItem)
      private
        FCenterX: integer;
        FCenterY: integer;
        FColor: TColor;
        procedure SetCenterX(const Value: integer);
        procedure SetCenterY(const Value: integer);
        procedure SetColor(const Value: TColor);
      public
        constructor Create(Collection: TCollection); override;
      published
        property CenterX: integer read FCenterX write SetCenterX default 3;
        property CenterY: integer read FCenterY write SetCenterY default 3;
        property Color: TColor read FColor write SetColor default clBlack;
      end;
     
      TDappledShape = class;
      TItemChangeEvent = procedure(Item: TCollectionItem) of object;
     
      TSpotCollection = class(TCollection)
      private
        FDappledShape: TDappledShape;
        FOnItemChange : TItemChangeEvent;
        function GetItem(Index: Integer): TSpot;
        procedure SetItem(Index: Integer; const Value: TSpot);
      protected
        function GetOwner: TPersistent; override;
        procedure Update(Item: TCollectionItem); override;
        procedure DoItemChange(Item: TCollectionItem); dynamic;
      public
        constructor Create(DappledShape: TDappledShape);
        function Add: TSpot;
        property Items[Index: Integer]: TSpot read GetItem write SetItem; default;
      published
        property OnItemChange: TItemChangeEvent
          read FOnItemChange write FOnItemChange;
      end;
     
      TDappledShape = class(TShape)
      private
        FSpots: TSpotCollection;
        procedure SetSpots(const Value: TSpotCollection);
      protected
        procedure Paint; override;
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
      published
        property Spots: TSpotCollection read FSpots write SetSpots;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TDappledShape]);
    end;
     
    { TSpot }
     
    constructor TSpot.Create(Collection: TCollection);
    begin
      inherited Create(Collection);
      FCenterX := 3;
      FCenterY := 3;
      FColor := clBlack
    end;
     
    procedure TSpot.SetCenterX(const Value: integer);
    begin
      if FCenterX <> Value
         then begin
                FCenterX := Value;
                Changed(False)
              end
    end;
     
    procedure TSpot.SetCenterY(const Value: integer);
    begin
      if FCenterY <> Value
         then begin
                FCenterY := Value;
                Changed(False)
              end
    end;
     
    procedure TSpot.SetColor(const Value: TColor);
    begin
      if FColor <> Value
         then begin
                FColor := Value;
                Changed(False)
              end
    end;
     
    { TSpotCollection }
     
    function TSpotCollection.Add: TSpot;
    begin
      Result := TSpot(inherited Add)
    end;
     
    constructor TSpotCollection.Create(DappledShape: TDappledShape);
    begin
      inherited Create(TSpot);
      FDappledShape := DappledShape
    end;
     
    procedure TSpotCollection.DoItemChange(Item: TCollectionItem);
    begin
      if Assigned(FOnItemChange) then FOnItemChange(Item)
    end;
     
    function TSpotCollection.GetItem(Index: Integer): TSpot;
    begin
      Result := TSpot(inherited GetItem(Index))
    end;
     
    function TSpotCollection.GetOwner: TPersistent;
    begin
      Result := FDappledShape
    end;
     
    procedure TSpotCollection.SetItem(Index: Integer; const Value: TSpot);
    begin
      inherited SetItem(Index, Value)
    end;
     
    procedure TSpotCollection.Update(Item: TCollectionItem);
    begin
      inherited Update(Item);
      FDappledShape.Invalidate;
      DoItemChange(Item)
    end;
     
    { TDappledShape }
     
    constructor TDappledShape.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FSpots := TSpotCollection.Create(Self)
    end;
     
    destructor TDappledShape.Destroy;
    begin
      FSpots.Free;
      inherited Destroy
    end;
     
    procedure TDappledShape.Paint;
    var
      SaveColor: TColor;
      SaveStyle: TBrushStyle;
      i: integer;
    begin
      inherited Paint;
      SaveColor := Canvas.Brush.Color;
      SaveStyle := Canvas.Brush.Style;
      Canvas.Brush.Style := bsSolid;
      for i := 0 to FSpots.Count - 1 do
        with FSpots.Items[i] do
          begin
            Canvas.Brush.Color := Color;
            Canvas.Ellipse(CenterX - 3, CenterY - 3, CenterX + 3, CenterY + 3)
          end;
      Canvas.Brush.Style := SaveStyle;
      Canvas.Brush.Color := SaveColor
    end;
     
    procedure TDappledShape.SetSpots(const Value: TSpotCollection);
    begin
      FSpots.Assign(Value)
    end;
     
    end. 
