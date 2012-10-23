<h1>Принципы работы с памятью в системе Windows32</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Павел</div>

<p>Оглавление</p>
<p>1. Введение</p>
<p>В данной статье изучаются принципы работы с памятью в системе Windows 32. Исследуется проблема накопления потоковых данных в специальных потоковых хранилищах. Работа с памятью является одной из важнейших функций любой программы. Выделение участков памяти для структур программы должно быть эффективным, поэтому программист должен хорошо разбираться в особенностях этого процесса.</p>
<p>В статье приводятся только основные принципы работы с памятью в системе Windows 32. Для подробного изучения всех тонкостей этого сложного процесса читатель может обратиться к специальной литературе. Особенно хочется отметить книгу: Дж.Рихтер, "Windows для профессионалов".</p>
<p>2. Организация виртуальной памяти в Windows</p>
<p>Как известно, Windows 32 - тридцатидвуразрядная операционная система (число 32 как раз это и обозначает). Прежде всего, из этого следует, что запущенная программа может адресовать линейное адресное пространство размером 2^32 байт = 4 ГБ, при этом адресация производится при помощи тридцатидвуразрядных регистров-указателей. Каждый запущенный в системе процесс обладает своим собственным адресным пространством, каждое из которых не пересекается с адресными пространствами других процессов. Распределение системных областей в адресном пространстве систем Windows 95/98 и Windows NT различно.</p>
<p>Программа может адресовать любую ячейку памяти в диапазоне адресов своего адресного пространства. Однако, это не значит, что программа может записать или считать данные из этой ячейки. Адресное пространство в Windows - виртуально, оно не связано напрямую с физическим пространством оперативной памяти вашего компьютера.</p>
<p>Механизм выделения памяти в Windows состоит из двух фаз. Первая фаза выделения памяти состоит в резервировании (захвате) участка необходимого размера в адресном пространстве процесса. При этом не выделяется ни байта реальной памяти (не считая системных структур ядра). Вы можете спокойно зарезервировать участок адресного пространства размером 100 мегабайт, и это ничего не будет стоить системе. Вы можете указать какие адреса вы хотели бы занять, а можете предоставить выбор участка необходимого размера самой системе. Стоит отметить, что адресное пространство резервируется с гранулярностью 64 кБ. Это значит, что несмотря на указанные вами адреса, базовый адрес реально зарезервированного участка памяти будет кратен 64 кБ. При резервировании участка в адресном пространстве можно указать желаемый аттрибут, который регулирует доступ к этой памяти: запись данных, чтение данных, выполнение кода или комбинацию этих признаков. Нарушение правил доступа к памяти приводит к генерации системой исключения.</p>
<p>Вторая фаза выделения памяти в Windows - это выделение реальной, физической памяти в зарезервированный участок виртуального адресного пространства. На этом этапе системой выделяется реальная память, со всеми вытекающими из этого последствиями. Выделение реальной памяти также гранулярно. Минимальный блок реальной памяти, которым оперирует система, и который можно выделить, называеся страницей памяти. Размер страницы зависит от типа операционной системы и составляет для Windows 95/98 - 4 кБ, а для Windows NT - 8 кБ. Гранулярность при резервировании участка памяти и при выделении реальной памяти призвана облегчить нагрузку на ядро системы.</p>
<p>Выделение реальной памяти происходит постранично, при этом существует возможность выделения произвольного количества страниц в произвольные (кратные размеру страницы) адреса заранее зарезервированного участка адресного пространства процесса. Каждой странице может быть назначен свой собственный атрибут доступа. Желательно указывать тот же самый атрибут, что имеет зарезервированный участок адресного пространства в котором происходит выделение страницы реальной памяти.</p>
<p>Важным моментом в механизме выделения памяти является механизм динамической выгрузки и загрузки страниц памяти. В самом деле, современный компьютер имеет оперативную память объемом 16-256 МБ, а для совместной работы нескольких программ необходимо гораздо больше. Windows, как и большинство современных операционных систем, выгружает страницы памяти, к которым давно не было обращений, на жесткий диск в так называемый своп-файл. При этом размер реальной памяти, доступной для программ, становиться равным суммарному объему оперативной памяти и своп-файла. По возможности, система старается держать все страницы в оперативной памяти, однако когда суммарный размер выделенных всеми процессами страниц превышает ее размер, система выгружает страницы с давним доступом на диск, а на их месте выделяет новые страницы. Если же выгруженная на диск страница затребуется владеющим ею процессом, система освободит для нее место в оперативной памяти путем выгрузки редко используемой страницы, загрузит затребованную страницу на ее место и вернет управление процессу.</p>
<p>Весь механизм динамической загрузки и выгрузки страниц абсолюдно прозрачен для процессов, а реализация этого механизма полностью обеспечивается операционной системой. Процесс может абсолюдно ничего не знать о сущесвовании такого механизма - он обращается к своим ячейкам памяти, а система автоматически выгружает редко используемые страницы и загружает необходимые страницы; процесс может только регулировать некоторые нюансы работы этого механизма.</p>
<p>На основании вышеперечисленного можно сделать следующие выводы:</p>
<p>каждый процесс со всеми своими потоками имеет отдельное и независимое линейное адресное пространство размером 4 Гб;</p>
<p>выделение памяти состоит из двух фаз: резервирования адресного пространства и выделение в нем реальной памяти;</p>
<p>при резервировании участка адресного пространства существует гранулярность размером 64 кБ;</p>
<p>выделение реальной памяти производится постранично, размер страницы записит от типа операционной системы;</p>
<p>каждой странице моежт быть назначен свой собственный атрибут доступа, нарушение которого приводит к генерации исключения системой;</p>
<p>операционная система динамически выгружает редко используемый страницы памяти на из оперативной памяти на жесткий диск, причем этот механизм прозрачен для всех процессов.</p>
<p>3. Кучи и менеджеры куч</p>
<p>Алгоритмы современных программ используют механизмы выделения и освобождения памяти очень интенсивно. Строки, динамические массивы, объекты, структуры, буфера - выделение и освобождение этих элементов происходит очень часто, при этом оказывается, что все эти элементы имеют небольшой размер.</p>
<p>Выделение у системы большого количества объектов небольшого размера оказывается неэффективным по следующим причинам.</p>
<p>частое обращение на выделение памяти снижает производительность, так как резервирование адресного пространства и выделение реальной памяти происходит на уровне ядра операционной системы;</p>
<p>из-за страничной организации памяти (гранулярности) выделение памяти происходит с большими издержками; запрос на выделение 100-байтного участка приводит к выделению одной страницы памяти с размером 4 или 8 кБ.</p>
<p>Решение этой проблемы организуется следующим образом: у операционной системы выделяется достаточно большой участок памяти, а уже из него для прикладной программы "нарезаются" небольшие участки. Такая организация называется кучей, а механизм, который следит за выделением и освобождением участков памяти называется менеджером кучи. Куча позволяет решить как проблему потери производительности - менеджер кучи может функционировать на уровне прикладной программы, так и проблему гранулярности - менеджер запрашивает у системы один большой участок памяти.</p>
<p>Windows имеет свою собственную реализацию менеджера кучи, который позволяет приложениям создавать, уничтожать кучи, а также производить с ними операции выделения и освобождения памяти в куче. Кроме того, для каждого вновь создаваемого процесса Windows специально создает кучу по умолчанию, которая используется при работе API функций, а также может быть использована прикладной программой. Все создаваемые Windows кучи потоко-безопасны, то есть существует возможность обращения к одной и той же куче из разных потоков одновременно.</p>
<p>Инженеры компании Borland по видимому не доверяют инженерам компании Microsoft, поэтому каждая программа на Delphi имеет свою собственную реализацию менеджера кучи, которая определена в системных модулях. Такое решение аргументируется инженерами Borland тем, что стандартный менеджер кучи Windows не обеспечивает достаточно эффективную работу с памятью. Конечно, как и любая Windows-программа, программа на Delphi имеет стандартную кучу по умолчанию, которую создает для нее система, однако функции New, Release, GetMem, FreeMem и некоторые другие оперируют с собственной реализацией менеджера куч. Менеджер кучи Delphi резервирует блоки адресного пространства размером 1 Мб, а выделяет блоки реальной памяти размером 16 Кб. Также вы можете написать и установить свою реализацию менеджера куч, если не доверяете ни инженерам Borland, ни инженерам Microsoft - для этого имеются все необходимые функции.</p>
<p>Хотя куча совершенно не предназначена для выделения больших участков памяти, запрос выделения большого участка у кучи не приведет к ошибке. Куча просто перенаправит ваш запрос операционной системе и вернет указатель на выделенный ею участок памяти.</p>
<p>4. Группы функций работы с памятью</p>
<p>В главе описываются группы базовых функций работы с памятью, которые доступны для программиста на Delphi. Включены описания как API-фукнций, так и Delphi-функций.</p>
<p>Delphi-функции</p>
<p>New(), Dispose()</p>
<p>Фунции работают с менеджером кучи Delphi. Обеспечивают типизированное выделение и освобождение памяти. Используются для динамической работы со структурами.</p>
<p>GetMem(), FreeMem()</p>
<p>Фунции работают с менеджером кучи Delphi. Обеспечивают нетипизированное выделение и освобождение памяти. Используются для динамической работы с небольшими бинарными блоками памяти (буфера, блоки).</p>
<p>API-функции</p>
<p>HeapCreate(), HeapDestroy(), ...</p>
<p>Функции работы со стандартным менеджером кучи Windows. Используются для создания и уничтожения куч, выделения и освобождения большого количества нетипизированных блоков памяти малого размера. Функции позволяют работать со стандартной кучей по умолчанию, которую создает операционная система для каждого процесса.</p>
<p>LocalAlloc(), LocalFree(), ... , GlobalAlloc(), GlobalFree(), ...</p>
<p>Так как в Windows 32 нет разделения на глобальные и локальные кучи, эти две группы функций идентичны. Функции работают со стандартной кучей по умолчанию, которую создает операционная система для каждого процесса. Функции морально устарели и Microsoft не рекомендует их использовать без крайней необходимости. Однако эти функции могут пригодиться, например, при работе с буфером обмена.</p>
<p>VirtualAlloc(), VirtualFree(), ...</p>
<p>"Основополагающие" функции выделения памяти в Windows. Используются как для резервирования адресного пространства, так и для выделения страниц реальной памяти в заранее зарезервированный участок адресного пространства. Позволяют выполнить обе фазы за один вызов функции. Используются для резервирования и выделения больших участков памяти.</p>
<p>5. Потоковые хранилища</p>
<p>Очень часто во многих программах встает проблема накопления потока поступающих данных. Например, это может быть запись звука, запись сигналов с датчиков, накопление данных с модема, коммуникационного порта, прием данных по сети и так далее. Если объем накапливаемых данных небольшой и заранее точно известен, то такая задача решается элементарно - под буфер выделяется блок памяти и эта память постепенно заполняется. Если же размер требуемого буфера достаточно большой, то выделение его полностью в самом начале может быть неэффективным - запись потока может прерваться гораздо раньше, а если же размер его неизвестен заранее, например когда запись данных останавливается по какому-либо внешнему сигналу, то встает проблема о выборе размера выделяемого блока.</p>
<p>В таких случаях используют динамические хранилища. В Delphi такими хранилищами являются динамические массивы, объект TMemoryStream, динамическое перераспределение памяти. Все эти хранилища работают на одном и том же принципе: под хранение данных выделяется блок памяти и поступающие данные последовательно записываются в этот блок, когда этот блок заполняется полностью, он перераспределяется с некоторым запасом (размер его увеличивается, а старые данные остаются). После того как каждый новый блок заполняется полностью он снова перераспределяется по мере поступления новых данных.</p>
<p>Перераспределение памяти занимает много ресурсов само по себе, а так как оно выполняется еще и в куче, то можно считать его вдвойне неэффективным, особенно если размеры перераспределяемых блоков становятся очень большими. Динамические массивы и динамическое перераспределение памяти используют менеджер кучи Delphi, а объект TMemoryStream использует стандартный менеджер кучи Windows.</p>
<p>Кроме того постоянное перераспределение участков памяти с разными размерами приводит к сильной дефрагментации памяти компьютера, что приводит к замедлению работы компьютера, а в конечном счете и к блокировке его работы.</p>
<p>Для решения проблемы накопления данных автором были разработаны два объекта накопления данных, основанные на двух разных принципах и имеющих разные характеристики.</p>
<p>TLinearStorage</p>
<p>Если размер буфера большой, но максимально возможный размер известен (например если есть ограничение на объем записываемых данных), то можно поступить следующим образом. В адресном пространстве процесса резервируется блок памяти необходимого размера, напомним, что такая операция не занимает ресурсов у системы. Затем по мере необходимости в этом зарезервированном участке памяти, по мере необходимости, последовательно выделяются страницы реальной памяти. Достоинством такого метода является линейное расположение ячеек в памяти друг за другом, то есть к такому хранилищу можно обращаться как к обычному линейному массиву. Недостатком - необходимость указания максимального размера.</p>
<p>TSectionStorage</p>
<p>Если размер буфера заранее неизвестен (ограничен лишь размером доступной реальной памяти), то предыдущее решение не подходит. В этом случае можно предложить другое решение. По мере необходимости, у системы можно запрашивать участки памяти одинакового размера и записывать в них поступающие данные. При этом буфер не будет иметь линейного адресного пространства, а будет состоять из одноразмерных "лоскутов" памяти - для вычислительного алгоритма такая организация буфера пожет стать серьезной помехой. Достоинством же такого решения является отсутствие необходимости изначально указывать какой либо размер буфера.</p>
<p>Если предполагается интенсивное увеличение-уменьшение хранилища, причем желательно, чтобы приращения были небольшими, то можно запрашивать память не у системы, а у стандартного менеджера кучи Windows, который создается для каждого хранилища отдельно. При этом, менеджер кучи выполняет роль кэша страниц памяти, увеличивая производительность.</p>
<p>Дополнительно, каждое хранилище имеет функции записи и чтения в стандартные потоки Delphi с упаковкой. Упаковка производится по стандартным алгоритмам библиотеки ZLIB.</p>
<p>6. Библиотека потоковых хранилищ</p>
<p>TBaseStorage - базовый класс</p>
<p>Оба хранилища, которые будут рассматриваться в дальнейшем, основаны на одном абстрактом базовом классе и имеют схожие свойства и методы.</p>
<p>Item[] - получение указателя на указанный элемент по его индексу.</p>
<p>ItemSize - запрос размера хранимого элемента.</p>
<p>Count - запрос и установка числа хранимых элементов.</p>
<p>Clear - очистка хранилища, установление его размера в нуль.</p>
<p>AddItems, GetItems, SetItems - добавление, запрос и установка блока элементов. SaveStream, LoadStream - запись и загрузка хранилища в/из потока. Параметр Compression в этих процедурах означает следующее 0 - компрессия не производится, и хранилище записывается в линейном натуральном виде; 1 - наименьшая степень компрессии; 9 - наивысшая степень компрессии. Число между 1..9 - произвольная степень компрессии.</p>
<pre>
// TBaseStorage
// Базовый класс для хранилищ
type
  TBaseStorage = class(TObject)
  public
    property Item[Ind: Cardinal]: Pointer read GetItem; default;
    property ItemSize: Cardinal read FItemSize;
    property Count: Cardinal read FCount write SetCount;
  public
    procedure Clear; virtual; abstract;
    procedure AddItems(Items: Pointer; Count: Cardinal); virtual; abstract;
    procedure SetItems(Items: Pointer; Index, Count: Cardinal); virtual;
      abstract;
    procedure GetItems(Items: Pointer; Index, Count: Cardinal); virtual;
      abstract;
    procedure SaveStream(Stream: TStream; Compression: Integer); virtual;
      abstract;
    procedure LoadStream(Stream: TStream; Compression: Integer; Count:
      Cardinal);
      virtual; abstract;
  end;
</pre>

<p>Линейное хранилище</p>
<p>Линейное хранилище имеет линейное адресное пространство буфера, однако нуждается в указаниии максимальной емкости, пусть даже и очень большой.</p>
<p>Capacity - запрос и установка максимальной емкости хранилища. При установке емкости хранилища, все ранее хранимые данные теряются.</p>
<p>Memory - запрос указателя на линейный участок памяти, в котором хранятся данные, может быть использован в вычислительных алгоритмах.</p>
<p>Create - конструктор, в котором необходимо указать размер хранимого элемента.</p>
<pre>
 
// TLinearStorage
// Линейное хранилище
type
  TLinearStorage = class(TBaseStorage)
  public
    property Capacity: Cardinal read FCapacity write SetCapacity;
    property Memory: Pointer read FMemory;
  public
    procedure Clear; override;
    procedure AddItems(Items: Pointer; Count: Cardinal); override;
    procedure SetItems(Items: Pointer; Index, Count: Cardinal); override;
    procedure GetItems(Items: Pointer; Index, Count: Cardinal); override;
    procedure SaveStream(Stream: TStream; Compression: Integer); override;
    procedure LoadStream(Stream: TStream; Compression: Integer; Count:
      Cardinal);
      override;
  public
    constructor Create(AItemSize: Cardinal);
    destructor Destroy; override;
  end;
</pre>
<p>Секционное хранилище</p>
<p>Секционное хранилище хранит данные в кусочно-линейном буфере состоящем из участков одинакового размера. Хранилище не требует указания максимальной емкости, но взамен не позволяет обращаться к элементам как к массиву данных.</p>
<p>Block - список указателей на блоки, из которых состоит хранилище.</p>
<p>BlockSize - размер блоков, измеряемый в числе хранимых элементов.</p>
<p>Create - конструктор, в котором необходимо указать размер хранимого элемента в байтах и размер блока хранения.</p>
<pre>
// TSectionStorage
// Секционное хранилище
type
  TSectionStorage = class(TBaseStorage)
  public
    property Blocks: TList read FBlocks;
    property BlockSize: Cardinal read FBlockSize;
  public
    procedure Clear; override;
    procedure AddItems(Items: Pointer; Count: Cardinal); override;
    procedure SetItems(Items: Pointer; Index, Count: Cardinal); override;
    procedure GetItems(Items: Pointer; Index, Count: Cardinal); override;
    procedure SaveStream(Stream: TStream; Compression: Integer); override;
    procedure LoadStream(Stream: TStream; Compression: Integer; Count:
      Cardinal);
      override;
  public
    constructor Create(AItemSize: Cardinal; ABlockSize: Cardinal);
    destructor Destroy; override;
  end;
</pre>
<p>7. Пример использования библиотеки потоковых хранилищ</p>
<p>Первый пример демонстрирует эффективность менеджера кучи Delphi перед стандатным менеджером кучи Windows. На компьютерах, которые были мне доступны, тест показывал более чем четырехкратное превосходство менеджера кучи Delphi над менеджером кучи Windows.</p>
<p>Следующий пример содержит исходные тексты библиотеки потоковых хранилищ и тест, сравнивающий два потоковых хранилища, а также объекты TMemoryStream и TFileStream. Тест содержит один параметр, который вы можете регулировать - число добавляемых объектов. Увеличивайте этот параметр вдвое при каждом запуске теста и наблюдайте за поведением всех четырех объектов, особенно объекта TMemoryStream. Пока массив данных помещается в оперативной памяти, результаты этого объекта будут прекрасными, однако после того как массив перестанет помещаться в ОЗУ, объект начинает резко сдавать свои позиции, а вскоре перестает работать совсем. Когда же он работает на пределе возможностей, он создает помехи при выделении памяти - именно из-за этого тест желательно перезапускать.</p>
<p>Вообще с объектом TMemoryStream связаны странные, необъяснимые истории. Как-то раз автор имел несчастье использовать этот объект в одной из своих программ для накопления потока данных с модема. Через некоторое время после запуска программа зависала сама и, кроме того, подвешивала Windows NT. Анализ с помощью диспетчера задач показал, что в процессе жизнедеятельности программы, она занимает все новые и новые участки памяти.</p>
<p>Поиск ошибок ни к чему ни привел, однако в конце концов пришлось обратить внимание на странности в поведении объекта TMemoryStream. Пришлось создать свой поток THeapStream путем формальной замены функций семейства Global... на функции GetMem, FreeMem, ReallocMem - то есть заменой стандартного менеджера кучи Windows на менеджер кучи Delphi. После этого все странности при работе программы исчезли.</p>
<p>Скорее всего это было связано с очень сильной дефрагментацией памяти, так как заполнение объекта TMemoryStream данными приводит к постоянному перераспределению участков памяти с разными размерами. От такой дефрагментации помогает только перезагрузка компьютера.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
