<h1>Создание COM-объектов средствами Delphi?</h1>
<div class="date">01.01.2007</div>



<p>Часть 1</p>
<p>Как преодолеть отсутствие множественного наследования в Delphi.</p>

<p>Все сообщество программистов разделяется по приверженности к той или иной платформе и языку программирования. Один предпочитает Delphi для Windows, другому нравится ассемблер для DOS, третий программирует на Си++ для OS/2. Навыки работы для одной платформы совсем не обязательно станут полезными при переходе на другую, а знание отдельного языка программирования может даже затруднить изучение другого. Все эти преграды можно было бы преодолеть, используя межпроцессное взаимодействие между программами, однако здесь возникает новая трудность - разные формы внутреннего представления данных в этих программах. </p>

<p>Однако есть способ решения этих проблем: применение единого стандарта для организации связи между объектами, который не зависит от используемой платформы и языка. Именно такова разработанная Microsoft компонентная модель объекта COM (Component Object Model). Данная технология уже получила широкое внедрение: ведь на ее базе работают механизмы OLE и ActiveX. </p>

<p>К сожалению, в изданной на текущий момент литературе недостаточно четко отражен тот факт, что программировать для COM-модели можно на самых разных языках. В большинстве примеров, за очень редким исключением, используется Си++. Некоторые примеры ориентированы только на Си++ и средства этого языка для множественного наследования. Другие примеры строятся на основе библиотеки MFC, причем в этом случае настолько интенсивно используются ее специфические макроконструкции для COM, что создается впечатление, будто это вообще не Си. Вывод следующий: если у вас нет опыта работы в Си++, то вам будет трудно разобраться, как программировать для COM. </p>

<p>В этой и следующей за ней статьях мы рассмотрим процесс формирования COM-объектов в среде разработки Borland Delphi. В первой части мы коснемся проблем организации COM-объектов в Delphi и покажем несколько вариантов их решения. Во второй части будут приведены примеры пяти типовых объектов для стандартных надстроек оболочки Windows 95. В отдельных случаях COM-объекты целесообразно хранить как EXE-файлы. Однако в этой статье с целью простоты изложения материала будут рассматриваться лишь COM-объекты, записанные в наиболее часто используемой для них форме DLL-модулей. </p>

<p>Основные понятия о COM-объектах</p>
<p>Что же кроется внутри COM-объекта? Нам совершенно не нужно вникать в это! Весь обмен информацией между COM-объектом и внешним миром осуществляется через конкретные интерфейсы. Каждый из них реализует доступ к одной или нескольким функциям, обратиться к которым может любой объект или программа. Все COM-объекты должны иметь интерфейс IUnknown с тремя его функциями - AddRef, Release и QueryInterface. Функции AddRef и Release отвечают за обычную задачу сопровождения жизненного цикла объекта. При каждом обращении к Addref содержимое счетчика ссылок данного объекта увеличивается на единицу, а при каждом обращении к Release - уменьшается. Когда значение счетчика достигает нуля, объект уничтожается. Практический интерес представляет третья функция интерфейса IUnknown - QueryInterface. Получив доступ к обязательно присутствующему интерфейсу IUnknown, программа или любой другой объект сразу может обратиться к функции QueryInterface и узнать обо всех остальных имеющихся у этого объекта интерфейсах. IUnknown находится на вершине иерархического дерева всех COM-интерфейсов. Любой другой интерфейс фактически наследуется от IUnknown и поэтому также должен обеспечивать доступ ко всем трем IUnknown-функциям. </p>

<p>Понятие объекта как в терминологии COM-модели, так и в Delphi или Си++ имеет практически одинаковый смысл. А вот COM-интерфейс больше напоминает Delphi- или Си++-объект, у которого отсутствуют public-переменные и имеются лишь виртуальные методы. Список функций интерфейса соответствует виртуальной таблице методов Object Pascal или объекта Си++. Создать COM-интерфейс можно средствами практически любого языка: достаточно лишь объявить объект с требуемым списком виртуальных методов. Само собой разумеется, что задаваемые определения методов должны в точности соответствовать определениям функций в самих интерфейсах. Однако, кроме того, необходимо соблюдать правильный порядок их размещения в виртуальной таблице. Сказанное означает, что эти определения следуют в заданном порядке, а перед ними нет никаких других виртуальных методов. </p>

<p>В файле OLE2.PAS, входящем в комплект Delphi 2.0, показано, как давать определение типу интерфейсного объекта для IUnknown и для нескольких десятков других, производных от IUnknown интерфейсов, например IClassFactory, IMarshal и IMalloc. Каждому методу, входящему в состав этих интерфейсных объектов, дается такое определение, как virtual, stdcall или abstract. Пояснение, зачем указывается virtual, уже было дано. Ключевое слово stdcall сообщает компилятору, что вызов данного метода следует производить по стандартным правилам. Слово abstract указывает, что функциональная часть данного метода в текущем объекте отсутствует, но она должна присутствовать у некоторого дочернего объекта, для которого будет создаваться его экземпляр. В файле OLE2.PAS дается определение для более чем 50 интерфейсов, непосредственно наследуемых от IUnknown, причем каждый из них предоставляет как собственный интерфейс, так и IUnknown. </p>

<p>Однако из-за необходимости иметь для COM-объекта два или более интерфейса, не считая IUnknown, возникает одна проблема. В Си++ достаточно дать определение COM-объекту как многократно наследуемому от тех объектов, где требуемые интерфейсы содержатся. Однако для объектов Delphi возможность множественного наследования не допускается. Поэтому приходится искать иное решение. (К сведению программистов на Си++: при создании COM-объектов на базе MFC применяется технология, аналогичная описываемой здесь для Delphi. Эта особенность остается незамеченной на фоне великого множества макроконструкций, которые используются при определении COM-объекта средствами MFC.) </p>

<p>Сателлиты и контейнеры</p>
<p>Ключевой фактор создания в Delphi COM-объекта с несколькими интерфейсами состоит в том, что объект рассматривается как передающий контейнер этих интерфейсов. Совсем не обязательно иметь их внутри данного COM-объекта. Необходимо лишь при запросе, когда вызывается метод QueryInterface его интерфейса IUnknown предоставлять доступ к нужному интерфейсу. Такой COM-объект, созданный в Delphi, может лишь непосредственно обслуживать три свои функции IUnknown, а при запросе через QueryInterface интерфейса IUnknown, передавать указатель на самого себя. Он действует как передаточный механизм и распорядитель других объектов, имеющих свои интерфейсы. Такие интерфейсные объекты-сателлиты отображают свои три IUnknown-метода на общий объект-контейнер. Если приходит запрос на один из сателлитных интерфейсов (как правило, через метод QueryInterface), контейнер передает указатель на соответствующий объект-сателлит. На листинге показан пример, как средствами Delphi можно создать такие интерфейсные объекты с типами сателлит и контейнер, а также как подготовить соответствующий интерфейс IClassFactory. </p>

<p>Листинг. С помощью этих обобщенных объектов с описанием интерфейсов можно создавать в среде Delphi COM-объекты с несколькими интерфейсами. </p>
<pre>
unit DelphCom;
// "Обобщенные" объекты. Предназначены для создания COM-объектов
// в Delphi. ISatelliteUnknown - интерфейсный объект, который
// будет обслуживаться через IContainerUnknown. Любой реальный
// COM-объект с несколькими интерфейсами
// будет наследоваться из IContainerUnknown и содержать
// функцию QueryInterface.
interface
uses Windows, Ole2, Classes, SysUtils, ShellApi, ShlObj;
 
var DllRefCount : Integer;
type
  IContainerUnknown = class;
 
ISattelliteUnknown = class(IUnknown)
  // Этот интерфейс будет обслуживаться через IContainerUnknown.
// Отображает три IUnknown-функции на свой объект-контейнер.
protected
  fContainer : IContainerUnknown;
public
  constructor Create(vContainer : IContainerUnknown);
  function QueryInterface(const WantIID: TIID;
    var ReturnedObject): HResult; override;
  function AddRef: Longint; override;
  function Release: Longint; override;
end;
 
IContainerUnknown = class (IUnknown)
protected
  FRefCount : Integer;
public
  сonstructor Create;
  destructor Destroy; override;
  (IUnknown-функции)
  function QueryInterface(const WantIID: TIID;
    var ReturnedObject): HResult; override;
  function AddRef: LongInt; override;
  function Release: LongInt; override;
end;
 
IMyClassFactory = сlass(IClassFactory)
private
  FRefcount : Integer;
public
  constructor Create;
  destructor Destroy; override;
  function QueryInterface(const WantIID: TIID;
    var ReturnedObject): HResult; override;
  function AddRef: LongInt; override;
  function Release: LongInt; override;
// В дочернем объекте должно быть дано определение
// для функции CreateInstance
  function LockServer(fLock: BOOL):
      HResult; override;
end;
 
function DLLCanUnloadNow : HResult; StdCall; Export;
implementation
 
(****** ISatelliteUnknown *****)
constructor ISatelliteUnknown.Create(vContainer:
    IContainerUnknown);
begin fContainer := vContainer; end;
 
function ISatelliteUnknown.QueryInterface(const WantIID: TIID;
    var ReturnedObject): HResult;
begin
  Result := fContainer.QueryInterface(WantIid,
      ReturnedObject);
end;
 
function ISatelliteUnknown.AddRef: LongInt;
begin Result := fContainer.AddRef; end;
 
function ISatelliteUnknown.Release: LongInt;
begin Result := fContainer.Release; end;
 
(****** IContainerUnknown ******)
constructor  IContainerUnknown.Create;
begin
  inherited Create;
  FRefCount := 0;
  Inc(DllRefCount);
end;
 
destructor IContainerUnknown.Destroy;
begin
  Dec(DllRefCount);
  inherited Destroy;
end;
 
function IContainerUnknown.QueryInterface(const WantIID: TIID;
    var ReturnedObject): HResult;
var P : IUnknown;
begin
  if IsEqualIID(WantIID, IID_IUnknown) then P := Self
  else P:= nil;
  Pointer(ReturnedObject) := P;
  if P = nil then Result := E_NOINTERFACE
  else begin
      P.AddRef;
      Result := S_OK;
  end;
end;
 
function IContainerUnknown.AddRef: LongInt;
begin Inc(FRefCount); Result := FRefCount; end;
 
function IContainerUnknown.Release: LongInt;
begin
  Dec(FRefCount);
  Result := FRefCount;
  if FRefCount = 0 then Free;
end;
 
(****** IMyClassFactory ******)
constructor IMyClassFactory.Create;
begin
  inherited Create;
  Inc(DllRefCount);
  FRefCount := 0;
end;
 
destructor IMyClassFactory.Destroy;
begin
  Dec(DllRefCount);
  inherited Destroy;
end;
 
function IMyClassFactory.QueryInterface(const WantIID: TIID;
    var ReturnedObject): HResult;
begin
  if IsEqualIID(WantIiD, IID_IUnknown) or
      IsEqualIID(WantIiD, IID_IClassFactory) then
  begin
      Pointer(ReturnedObject) := Self;
      AddRef;
      Result := S_OK;
  end
  else begin
      Pointer(ReturnedObject) := NIL;
      Result := E_NOINTERFACE;
  end
end;
 
function IMyClassFactory.AddRef: LongInt;
begin
  Inc(FRefCount);
  Result := FRefCount;
end;
 
function IMyClassFactory.Release: LongInt;
begin
  Dec(FRefCount);
  Result := FRefCount;
  if FRefCount = 0 then Free;
end;
 
function IMyClassFactory.LockServer(fLock: Bool):HResult;
begin Result := E_NOTIMPL; end;
 
(****** экспортируемая функция ******)
function DLLCanUnloadNow: hResult; StdCall; Export;
begin
  if DllRefCount = 0 then Result := S_OK
  else Result := S_FALSE;
end;
 
initialization
  DllRefCount := 0;
end.
</pre>


<p>Объекты-сателлиты</p>
<p>Объектный тип ISatelliteUnknown непосредственно наследуется от рабочего типа IUnknown, причем все его три абстрактных метода обязательно переопределяются. ISatelliteUnknown содержит единственное поле protected-переменной с именем FContainer и типом IContainerUnknown (его определение дается позже); начальное значение для данной переменной присваивается в его конструкторе Create. Назначение трех его IUnknown-функций состоит лишь в том, чтобы передать результат, полученный после вызова соответствующего метода объекта-контейнера. В зависимости от того, какой интерфейс запрашивает вызывающая программа, она получает доступ к методам QueryInterface, AddRef и Release либо непосредственно через объект-контейнер, либо через любой из его объектов-сателлитов</p>

<p>Если вам уже приходилось изучать литературу по технологии OLE, то вы наверняка обратили внимание, что в модуле DelphCOM, приведенном в листинге, используются нестандартные имена для параметров QueryInterface. Обычно для обозначения идентификатора ID нужного интерфейса используется имя riid, а передаваемому программе объекту назначается имя ppv. Поскольку имена параметров имеют смысл только в пределах данного объекта, я решил заменить зашифрованные стандартные имена на более понятные WantIID и ReturnedObject.</p>

<p>Объекты-контейнеры</p>
<p>Объектный тип IContainerUnknown также непосредственно наследуется от IUnknown. Он содержит собственный счетчик количества ссылок, записываемый в поле protected-переменной с именем FRefCount; его функция AddRef обеспечивает приращение счетчика FRefCount, а Release - его уменьшение. Обе функции - AddRef и Release - передают в программу новое значение счетчика. Если оно становится равным 0, функция Release дополнительно производит высвобождение объекта. </p>

<p>Кроме этого, в модуле DelphCOM дается определение глобальному счетчику ссылок для всей DLL, через который отслеживаются все объекты, производные от этих обобщенных COM-объектов. Его приращение и уменьшение производятся при работе соответственно конструктора и деструктора этого объекта-контейнера. Любая DLL, где содержатся COM-объекты, должна выполнять две специальные функции - DLLCanUnloadNow и DLLGetClassObject. В модуле DelphCOM присутствует функция DLLCanUnloadNow, которая будет принимать значение False до тех пор, пока значение упомянутого глобального счетчика DLL не станет равным 0. Что же касается функции DLLGetClassObject, то ее содержание специфично для каждой конкретной DLL, использующей DelphCOM. Поэтому ее нельзя будет записать до тех пор, пока не будут заданы сами COM-объекты (являющиеся производными от ISatelliteUnknown и IContainerUnknown). </p>

<p>Объект IContainerUnknown реагирует на запросы интерфейса IUnknown, поступающие через QueryInterface, и передает указатель на самого себя. При запросе иного интерфейса передается код ошибки E_NOINTERFACE. Когда же данная ситуация возникает в производном от IContainerUnknown объекте, то функция QueryInterface сначала обращается к этой, наследуемой от родительского объекта функции. Если в ответ передается значение E_NOINTERFACE, тогда проверяется совпадение идентификатора запрашиваемого интерфейса с идентификаторами его других интерфейсов. При совпадении в программу передается указатель этого объекта-сателлита. </p>

<p>Генератор класса</p>
<p>COM-объекты могут создаваться при выдаче соответствующей команды от системы или от некоторой программы. Этот процесс создания управляется особым типом COM-объекта, именуемым генератором класса (class factory); он также получается прямым наследованием от IUnknown. Имеющийся в модуле DelphCOM объект IMyClassFactory, как и объект IContainerUnknown, содержит методы AddRef и Release. Если через QueryInterface поступает запрос на IUnknown или IClassFactory, то он передает указатель на самого себя. Кроме названных трех функций в интерфейсе IClassFactory дополнительно появляются две новые - CreateInstance и LockServer. Обычно функция LockServer не требуется, и в этом случае она принимает особое значение E_NOTIMPL - признак того, что данная функция не задействована. </p>

<p>Наиболее важная функция генератора класса, ради которой он создается, - это CreateInstance. С ее помощью вызывающая программа создает экземпляр требуемого объекта. В модуле DelphCOM, правда, еще нет каких-либо "законченных" объектов; здесь содержатся лишь обобщенные объекты сателлита и контейнера. Когда мы даем определение COM-объекту как наследуемому от IContainerUnknown, нам также приходится давать определение объекту, производному от IMyClassFactory, функция которого - CreateInstance - будет передавать в программу новый экземпляр этого COM-объекта. </p>

<p>Теперь, введя IMyClassFactory, мы получили полный комплект обобщенного COM-объекта для работы в Delphi. Эта система из объектов сателлита и контейнера может использоваться в любом объектно-ориентированном языке программирования; ведь, действительно, COM-объекты, создаваемые средствами MFC, используют аналогичную систему. Во второй части этой статьи мы перейдем от теории к практике. Возможности рассмотренных здесь обобщенных объектов будут существенно расширены, что позволит в качестве примера создать пять различных типовых надстроек для оболочки Windows 95 - для обслуживания операций с контекстным меню, диалоговым окном Property, перетаскивания объектов с помощью правой клавиши мыши, манипуляций с пиктограммами и операций копирования. </p>

<p>Разобравшись с примерами, вы почувствуете полную готовность к созданию собственных, реально действующих надстроек для оболочки Windows 95. </p>

<p>Идентификаторы GUID, CLSID и IID</p>
<p>При создании и работе COM-объектов интенсивно используются идентификаторы, именуемые как Globally Unique Identifiers (глобально уникальные идентификаторы), или, коротко, GUIDs (произносится "GOO-ids"). Этот параметр представляет собой некоторое 128-разрядное число, генерируемое функцией CoCreateGUID, входящей в состав Windows API. Значения GUID должны быть уникальны в глобальных масштабах: передаваемое функцией CoCreateGUID значение никогда не должно повторяться. Крейг Брокшмидт (Kraig Brockschmidt), специалист по OLE (из группы разработчиков OLE в Microsoft), как-то заявил, что вероятность совпадения результатов двух различных обращений к CoCreateGUID равняется тому, что "два случайно блуждающих по вселенной атома вдруг внезапно столкнутся и образуют гибрид маленького калифорнийского авокадо с канализационной крысой из Нью-Йорка". </p>

<p>Дело в том, что у каждого интерфейса должен быть свой идентификатор IID (Interface ID), являющийся тем же самым GUID. В файле OLE2.PAS, входящем в комплект Delphi, дается определение десяткам таких параметров. Пример программы из данной статьи содержит ссылки на идентификаторы интерфейсов IUnknown и IClassFactory; а в файле OLE2.PAS содержится множество других подобных параметров. Кроме того, любой объектный класс, зарегистрированный в системе, должен иметь свой идентификатор класса Class ID (CLSID). Если вам когда-нибудь приходилось с помощью программы RegEdit просматривать ключ HKEY_CLASSES_ROOT\CLSID системного реестра Windows, вы наверняка обращали внимание на десятки, а иногда и сотни непонятных строк с записанными в них цифрами. Все это - идентификаторы классов для всех COM-объектов, зарегистрированных на вашем компьютере. Не будем вдаваться в подробности; скажем лишь, что при программировании COM-объектов следует использовать имеющиеся параметры GUID, а также создавать новые, специфичные для вашей конкретной программы. </p>

<p>Существует ряд бесплатных утилит, например UUIDGEN.EXE, позволяющих генерировать новые значения GUID. Однако после ее исполнения придется заниматься рутинной задачей - аккуратно переписывать полученные значения на место констант Delphi. Взамен UUIDGEN.EXE служба PC Magazine Online предлагает другую "консольную" программу с текстовым выводом. Ее можно либо загрузить в интегрированную среду Delphi и произвести компиляцию там, либо обработать компилятором Delphi, введя через командную строку DCC32 GUIDS.DPR. Теперь запустите полученную программу, и вы получите абсолютно новое, не встречавшееся ранее значение GUID - в виде строки и в виде типовой константы Delphi.</p>

<p>Отныне, начиная работу над новым проектом, внимательно подсчитайте необходимое количество отдельных параметров GUID. На всякий случай добавьте еще несколько. Теперь укажите это число как параметр для программы GUIDS.EXE и перенаправьте ее вывод в отдельный файл. Там будут записаны указанное количество идентификаторов GUID, причем, как правило, они будут представлять собой блок непрерывно возрастающих чисел. Дело в том, что когда используемые в вашем проекте параметры GUID отличаются между собой лишь цифрой в отдельной позиции, легче разбираться, какой идентификатор к чему относится. Теперь вы можете вырезать эти значения из текстового файла и вставить в нужные места своего проекта.</p>

<p>© Нил Дж. Рубенкинг</p>
<p>Материал взят с PC Magazine, January 7, 1997, p. 227</p>

<p>Часть 2</p>
<p>Примеры создания четырех COM объектов - расширений оболочки Windows 95. </p>

<p>В технологиях создания COM объектов в среде Delphi и в среде Си++ наблюдаются существенные различия, хотя, конечно, есть в них и некоторое сходство: у таких объектов обычно один или несколько интерфейсов, а у объекта в Delphi и у объекта в C++ может быть один и тот же COM-интерфейс. Однако в Си++ задача обеспечения COM объекта несколькими интерфейсами решается с помощью механизма множественного наследования, т. е. порождаемый объект наследует функции от всех требующихся интерфейсов. В Delphi подобной возможности нет, поэтому необходим другой подход. </p>

<p>В Delphi COM объект с несколькими интерфейсами приходится формировать из нескольких отдельных объектов. Каждый из требующихся COM-интерфейсов предоставляется объектом-сателлитом - потомком имеющегося в Delphi объекта типа IUnknown. Такой объект-саттелит реализует интерфейс IUnknown. Сам же COM объект представляет собой объект-контейнер, тоже производный от IUnknown. Объект-контейнер, содержащий экземпляры объектов-сателлитов в виде полей данных, в ответ на запрос к своему методу QueryInterface передает указатель на упомянутый в нем интерфейс. Эти приемы и их реализацию на примере объектов ISatelliteUnknown и IContainerUnknown мы рассмотрели в первой части данной статьи. А теперь с помощью этих объектов мы попробуем подготовить специальные COM объекты - расширения оболочки Windows 95. </p>

<p>Мы продемонстрируем процедуры создания средствами Delphi четырех расширений Windows95: обработчика контекстного меню, обработчика списка параметров, обработчика для механизма drag-and-drop и обработчика пиктограмм. Они выполняют операции с некоторым воображаемым типом файлов DelShellFile с расширением DEL. Строка текста такого файла представляет собой целое число; в настоящей программе его заменит какой-то более сложный атрибут файла. Названный "магический номер" используется всеми четырьмя расширениями. </p>

<p>Среди прилагаемых к статье исходных текстов вы обнаружите и еще одно расширение - для обслуживания операции копирования. Но, поскольку для его реализации не требовалась связка контейнер/сателлит, мы не уделили ему внимания в статье. </p>

<p>Все упомянутые в статье программы можно загрузить из службы PC Magazine Online. </p>

<p>Подготовка вспомогательных интерфейсов</p>
<p>На рис. 1 представлена иерархия создаваемых нами вспомогательных объектов. Сплошными линиями обозначены стандартные иерархические связи между объектами; на вершине этого дерева вы видите объект IUnknown, описанный на языке Delphi. Под именем каждого объекта перечисляются все его интерфейсы, за исключением обязательного для всех интерфейса IUnknown. Пунктирными линиями показаны связи контейнер/сателлит, которые служат основой всей системы. </p>

<p>Инициализаций расширений, предназначенных для обслуживания контекстного меню, списка параметров и работы механизма drag-and-drop, выполняется с помощью интерфейса IShellExtInit. Аналогичная операция для расширения - обработка пиктограмм осуществляется через интерфейс IPersistFile. На лист. 2 приведены описания объектов-сателлитов, реализующих два названных вспомогательных интерфейса, и объектов-контейнеров, заранее подготовленных для управления этими объектами-сателлитами.</p>

<p>Дополнительный метод Initialize объекта IMyShellExtInit служит функцией Initialize интерфейса IShellExtInit. Данный объект наследует функции объекта ISatelliteUnknown: его методы QueryInterface, AddRef и Release. В результате таблица виртуальных методов объекта IMyShellExtInit полность совпадает с набором функций интерфейса IShellExtInit. Метод Initialize извлекает из передаваемых вызывающей программой данных список файлов и сохраняет его в отдельном поле данных своего объекта-контейнера, тип которого обязательно должен быть ISEIContainer. </p>

<p>ISEIContainer наследует методы AddRef и Release контейнера IContainerUnknown. Имеющий собственную реализацию метода QueryInterface объект ISEIContainer сначала вызывает вариант QueryInterface, унаследованный от IContainerUnknown. Если полученное в ответ значение не равно S_OK, тогда с помощью его собственного метода QueryInterface проверяется, есть ли обращение к интерфейсу IShellExtInit. Если ответ положительный, этот метод передает указатель на свое поле типа protected FShellExtInit, являющееся объектом типа IMyShellExtInit. Кроме этого, в ISEIContainer описываются поля для хранения списка файлов, их числа и маршруты к ним. Имеющийся у него конструктор Create инициализирует список файлов и объекты FShellExtInit, а деструктор Destroy высвобождает память, отведенную для этих двух объектов. </p>

<p>Описание объекта IMyPersistFile кажется более сложным, чем у IMyShellExtInit. Однако в действительности пять из шести его методов, реализующих функции интерфейса IPersistFile, в качестве результата передают значение E_FAIL. Метод Load объекта IMyPersistFile получает имя файла в формате Unicode, преобразует его в строку ANSI и записывает в соответствующее поле своего объекта-контейнера, тип которого обязательно IPFContainer. Так же как у ISEIContainer, метод QueryInterface объекта IPFContainer имеет свои особенности. Сначала выполняется обращение к унаследованному варианту QueryInterface. Если в ответ получено значение ошибки, то с помощью собственного метода QueryInterface проверяется, есть ли обращения к интерфейсу IPersistFile. Если да, передается указатель на protected-поле FPersistFile - объект типа IMyPersistFile. За создание и удаление объекта FPersistFile отвечают специальные методы объекта-контейнера - конструктор и деструктор. </p>

<p>Теперь все готово и можно приступать к подготовке наших расширений оболочки Windows95. </p>

<p>Рис. 1. Иерархия объектов - расширений оболочки Windows</p>

<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;--------- IUnknown -----------&gt;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; IContainerUnknown&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ISatelliteUnknown</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |-&gt; IPFContainer&nbsp; -----------&gt; IMyPersistFile&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |&nbsp;&nbsp; IPersistFile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IPersistFile&nbsp;&nbsp; &lt;---|</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --------&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; -&gt;IDSExtraction -------&gt; IMyExtraction&nbsp; &lt;---|</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IPersistFile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IExtractIcon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IExtractIcon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp; --&gt;ISEIContainer -----------&gt; IMyShellExtInit&lt;---|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IShellExtInit&nbsp;&nbsp;&nbsp;&nbsp; -------&gt; IShellExtInit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; ||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |-&gt; IDSContextMenu ----||&gt; IMyContextMenu &lt;---|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; IShellExtInit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ||&nbsp; IContextMenu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; IContextMenu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------- |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; ------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |-&gt; IDSDragDrop -|-------&gt; IMyDragDrop&nbsp;&nbsp;&nbsp; &lt;---|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; IShellExtInit|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IContextMenu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; IContextMenu |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |-&gt; IDSPropSheet --------&gt; IMyPropSheet&nbsp;&nbsp; &lt;---|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IShellExtInit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IShellPropSheetExt</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IShellPropSheetExt</p>

<p>Лист. 1. Два объекта-сателлита реализуют вспомогательные интерфейсы, необходимые для работы таких расширений оболочки Windows 95, как обработчики контекстного меню, списка параметров, для механизма drag-and-drop и пиктограмм. </p>
<pre>
 type
   IMyShellExtInit = class(ISatelliteUnknown)
   public
     function Initialize(pidlFolder:PItemIDlist; lpdobj: IDataObject;
       hKeyProgID:HKEY) :HResult; virtual; stdcall;
   end;
 
   IMyPersistFile = class(ISatelliteUnknown)
   public
     function GetClassID(var classID: TCLSID): HResult; virtual;
      stdcall;
     function IsDirty: HResult; virtual; stdcall;
     function Load(pszFileName: POleStr; dwMode: Longint): HResult;
       virtual; stdcall;
     function Save(pszFileName: POleStr; fRemember: BOOL): HResult;
       virtual; stdcall;
     function SaveCompleted(pszFileName: POleStr): HResult;
       virtual; stdcall;
     function GetCurFile(var pszFileName: POleStr): HResult;
       virtual; stdcall;
   end;
 
   ISEIContainer = class(IContainerUnknown)
   protected
//Интерфейс объекта-сателлита
     FShellExtInit : IMyShellExtInit; 
   public
     FNumFiles         : Integer;
     FInitFiles        : TStringList;
     FIDPath           : String;
     constructor Create;
     destructor Destroy; override;
     function QueryInterface(const WantIID: TIID);
       var ReturnedObject): HResult; override;
   end;
 
   IPFContainer = class(IContainerUnknown)
   protected
//Интерфейс объекта-сателлита
     FPersistFile : IMyPersistFile; 
   public
     FPFFileName : String;
     constructor Create;
     destructor Destroy; override;
     function QueryInterface(const WantIID: TIID;
       var ReturnedObject): HResult; override;
   end;
</pre>


<p>Обработчик контекстного меню</p>
<p>Щелчок правой клавишей мыши на каком-то файле, в среде Windows 95 Explorer приводит к тому, что система предпринимает попытку выяснить, задан ли для такого типа файлов обработчик контекстного меню. Если таковой имеется, система создает экземпляр COM-объекта - обработчика контекстного меню и передает список выделенных файлов функции Initialize интерфейса IShellExtInit этого объекта. Затем обращается к методу QueryContextMenu интерфейса IContextMenu. В работе этой функции используются стандартные функции Windows API; например, для вставки дополнительных элементов меню или разделителей вызывается функция InsertMenu, которая передает в качестве return-значения число добавленных элементов, не считая разделителей. Если же пользователь выбрал один из этих внесенных элементов меню, то происходит вызов функции InvokeCommand интерфейса IContextMenu. Чтобы предоставить комментарий к данному элементу меню в строке состояний программы Explorer, вызывается функция GetCommandString. </p>

<p>Для определения и инициализации обработчика контекстного меню используются следующие Delphi-объекты: IMyContextMenu, IDSContextMenu и ICMClassFactory. Объект IMyContextMenu является потомком ISatelliteUnknown; его интерфейс IContextMenu реализует три функции. Объект IDSContextMenu - потомок ISEIContainer, поэтому снабжен интерфейсом IShellExtInit. В IDSContextMenu имеется дополнительное protected-поле FContextMenu с типом IMyContextMenu. И в этом случае конструктор и деструктор объекта IDSContextMenu ответственны за создание и удаление объекта-сателлита; при обращении к интерфейсу IContextMenu метод QueryInterface данного объекта передает в вызывающую программу указатель на объект FContextMenu. </p>

<p>Эта программа содержит также описание объекта ICMClassFactory - потомка IMyClassFactory, специально предназначенного для получения экземпляра IDSContextMenu. Метод CreateInstance создает запрашиваемый экземпляр и обеспечивает к нему доступ, но только если среди интерфейсов объекта IDSContextMenu имеется запрашиваемый. Для каждого из наших расширений оболочки потребуется почти такой же вариант потомка IMyClassFactory. </p>

<p>Метод QueryContextMenu предназначен для проверки того, сколько файлов выбирается: один или несколько. Если только один, в меню добавляется элемент под именем Magic Number (магический номер); если же их несколько - элемент Average Magic Number (усредненный магический номер). Метод InvokeCommand проверяет правильность переданных ему аргументов и выводит в окне сообщений запрошенный номер. Метод GetCommandString в соответствии с тем, что было запрошено, передает либо отдельное слово - наименование элемента меню, либо пояснительную строку. </p>

<p>Обработчик для механизма drag-and-drop</p>
<p>Обработчик для механизма drag-and-drop практически не отличается от обработчика контекстного меню - в них используется даже один и тот же интерфейс IContextMenu. Однако имеются некоторые отличия: во-первых, активизация расширения, предназначенного для обслуживания механизма drag-and-drop происходит при переносе файла в какую-то папку правой клавишей мыши; во-вторых, это расширение вносится в список файлов того типа, которые помещены в данную папку, а не к тому типу файлов, к которому относится перемещенный файл. Объект-сателлит IMyDragDrop содержит следующие методы: QueryContextMenu, InvokeCommand и GetCommandString. </p>

<p>Сначала метод QueryContextMenu выполняет просмотр переданного ему системой списка файлов с целью проверки, все ли относятся к типу DelShellFile. Если это так, данный метод добавляет в меню новый элемент Count Files (Подсчет файлов), разделитель и передает в качестве return-значение 1. Если же результат отрицательный, никаких действий не производится и передается значение 0. При выборе добавленного элемента меню метод InvokeCommand подсчитывает количество файлов в папке-получателе и добавляет это число к "магическому номеру" каждого из выделенных DelShellFile-файлов. Поскольку этот номер и пиктограмма такого файла взаимосвязаны, обращение к функции API, SHChangeNotify осведомит систему о необходимости обновить пиктограммы каждого из этих файлов. </p>

<p>В функциональном отношении объект-контейнер IDSDragDrop идентичен объекту IDSContextMenu. Разница лишь в том, что тип его объекта-сателлита - IMyDragDrop, а не IMyContextMenu. </p>

<p>Обработчик списка параметров</p>
<p>Когда пользователь, выделив один или несколько файлов, выбирает в контекстном меню команду Properties (Параметры), система сначала пытается определить, предусмотрен ли специальный обработчик списка параметров для данного типа файлов. Если да, система создает экземпляр соответствующего расширения оболочки и инициализирует, передав функции Initialize его интерфейса IShellExtInit список выделенных файлов. Система также обращается к функции AddPages интерфейса IShellPropSheetExt, с тем чтобы дать возможность обработчику списка параметров добавить к нему одну или несколько страниц. Другая функция интерфейса IShellPropSheetExt - ReplacePages - обычно не используется. </p>

<p>Однако, когда дело доходит до реализации метода AddPages, программисты, работающие с Delphi, внезапно оказываются в полной растерянности. Для создания страницы списка параметров необходим такой ресурс, как шаблон диалогового окна, и функция для его обработки. Лишь бывалые Windows-программисты, возможно, еще помнят о старинных предшественниках нынешних средств визуального программирования. Для подготовки шаблона диалогового окна можно воспользоваться инструментом для генерации ресурсов, таким, как Resource Workshop фирмы Borland или составить сценарий ресурса и откомпилировать его с помощью компилятора ресурсов BRCC.EXE, входящего в комплект Delphi. Вместе с исходными текстами для этой статьи можно загрузить и сценарий ресурса, описывающий список параметров для файлов типа DelShellFile. </p>

<p>Этот сценарий дает определения двух статических полей с текстом, окна списка и кнопки. В общем подключаемом файле SHEET.INC объявлены константы IDC_Static, IDC_ListBox и IDC_Button, используемые в качестве идентификаторов для управления диалоговым окном. </p>

<p>При исполнении метода AddPages происходит инициализация различных полей структуры TPropSheetPage, в том числе шаблона диалогового окна, процедуры управления им и параметра lParam, описанного в программе. Здесь lParam содержит список файлов, переданных из оболочки Windows. Использование функции обратного вызова гарантирует освобождение памяти, выделенной под этот список. При обращении к функции CreatePropertySheetPage она создает страницу на основании данных структуры TPropSheetPage, а при вызове предусмотренной в оболочке функции lpfnAddPage к диалоговому окну Properties будет добавлена эта страница. </p>

<p>Процедура управления диалоговым окном обрабатывает два конкретных сообщения. Если поступает сообщение WM_INITDIALOG, окно списка дополняется перечнем файлов, указанным в поле параметра lParam данной страницы списка параметров. Перед каждым именем проставляется соответствующий "магический номер". Затем процедура формирует статический элемент управления, отображающий количество выбранных в данный момент файлов. Список файлов удаляется, а поле, где прежде находился данный список файлов, обнуляется. </p>

<p>Если же пользователь щелкнет на кнопке Zero Out (Очистить), процедура управления диалоговым окном получает сообщение WM_COMMAND, где в младшем слове wParam указывается идентификатор данной кнопки. Процедура просматривает весь список файлов и делает нулевым "магический номер" каждого из них, затем обращается к функции API - SHChangeNotify, чтобы сообщить системе о необходимости перерисовать пиктограммы файлов. Фактически любая процедура управления диалоговым окном списка параметров должна иметь средства для реакции на сообщение WM_INITDIALOG, чтобы выполнить инициализацию своих управляющих элементов. Если же она предназначена не только для отображения информации, тогда в ней должны быть средства, обеспечивающие реакцию на сообщения WM_COMMAND, поступающие от конкретных управляющих элементов. </p>

<p>Обработчик пиктограмм</p>
<p>В большинстве случаев средства оболочки Windows 95 просто выбирают для файла ту пиктограмму, которая указана для такого типа файлов в разделе DefaultIcon системного реестра. Однако, если в разделе DefaultIcon задано значение %1, тогда происходит обращение к некоторому расширению оболочки, которое выполняет роль обработчика пиктограмм для данного файла. Система обращается к функции Load интерфейса IPersistFile этого расширения, передавая ей в качестве параметра имя файла. Обработчик пиктограмм обеспечивает соответствующую пиктограмму через функции GetIconLocation и Extract своего интерфейса IExtractIcon. Эта информация представляет собой либо имя файла и порядковый номер конкретной пиктограммы, либо созданную при поступлении запроса пиктограмму. </p>

<p>Наш пример объекта-сателлита IMyExtractIcon реализует оба варианта. Если задана директива условной компиляции UseResource, метод GetIconLocation присваивает аргументу szIconFile в качестве значения имя DLL-модуля, содержащего объект IMyExtractIcon, затем на основании "магического номера" файла вычисляет значение аргумента piIndex. Данный метод включает в значение аргумента pwFlags флажок GIL_PERINSTANCE, наличие которого означает, что каждый файл может иметь свою отдельную пиктограмму и флажок GIL_DONTCACHE - знак того, что система не должна сохранять эту пиктограмму в памяти для последующих применений. Метод Extract в этом случае не используется; его return-значение будет S_FALSE. </p>

<p>Если же директива условной компиляции UseResource не задана, тогда объект-сателлит IMyExtractIcon формирует пиктограмму для каждого файла. Метод GetIconLocation заносит "магический номер" данного файла в аргумент piIndex и помимо упомянутых выше флажков использует флажок GIL_NOTFILENAME. Из оболочки вызывается метод Extract, который создает для данного файла пиктограммы двух размеров - крупную и маленькую. Высота красной полоски в прямоугольнике пиктограммы определяется "магическим номером" файла. В исходных текстах, прилагаемых к этой статье, представлена процедура создания пиктограммы на ходу. Однако, поскольку она имеет лишь косвенное отношение к тематике этой статьи, ее подробности здесь не обсуждаются. </p>

<p>Компоновка программы</p>
<p>Для того чтобы все перечисленные расширения оболочки работали, нужно скомпилировать их в DLL-модуль, содержащий стандартные функции DllGetClassObject и DllCanUnloadNow. В числе исходных текстов, прилагающихся к этой статье, имеется и программа, описывающая такой DLL-модуль. Функция DllGetClassObject выполняет следующие операции: выясняет, к какому объекту поступил запрос, формирует соответствующую фабрику классов (class factory) и передает в качестве результата объект, созданный этой фабрикой. Среди упомянутых исходных текстов вы найдете также программу, описывающую DLL-модуль несложной консольной процедуры, управляющей операциями внесения и удаления из системного реестра информации обо всех перечисленных здесь образцах расширений оболочки.</p>

<p>Теперь, изучив приведенные примеры, можно приступать к созданию собственных расширений оболочки. Только не забудьте заменить имеющиеся в текстах программ значения глобально уникальных идентификаторов GUID (Globally Unique Identifiers) новыми. В этом вам поможет программа генерации, GUIDS, представленная в первой части этой статьи. </p>

<p>Средства для отладки COM объектов</p>
<p>Большинство современных пакетов для разработки программ содержат встроенные средства отладки, обеспечивающие возможность выполнения в пошаговом режиме, трассировки кода, установки точек прерывания и просмотра значений переменных. Все они пригодны для отладки исполнимых EXE-модулей. Однако если программа оформлена в виде DLL-модуля, то интегрированные средства отладки оказываются бесполезными. Даже при использовании 32-разрядного автономного отладчика не так-то просто добраться до COM объектов, поскольку они выполняются в адресном пространстве обратившегося к ним объекта или программы. Например, COM объекты, являющиеся расширениями оболочки Windows 95, исполняются в адресном пространстве программы Windows Explorer. </p>

<p>Однако чаще всего разработчика интересуют достаточно простые вопросы о работе COM объектов: Был ли загружен DLL-модуль вообще? Производилась ли попытка создать экземпляр конкретного COM объекта? Какой интерфейс запрашивался? Выяснить все это можно с помощью простого механизма регистрации сообщений: COM объект отправляет сообщения о своем состоянии, которые принимает и регистрирует предназначенная для этого самостоятельная программа. Из службы PC Magazine Online вы можете загрузить специальный модуль DllDebug, который обеспечивает механизм передачи таких сообщений. </p>

<p>Раздел этого модуля, который выполняет инициализацию, присваивает переменной WM_LOGGIT уникальное значение идентификатора сообщений, полученное от функции RegisterWindowMessage в результате передачи ей строковой переменной Debugging Status Message. При первом обращении к функции RegisterWindowMessage с использованием этой строки она передает уникальный номер сообщения, а при последующих вызовах с ней в качестве результата будет получен тот же номер. </p>

<p>Поскольку 32-разрядные программы выполняются в отдельном адресном пространстве, функция Loggit не может так просто передать указатель на свою строку с сообщением о состоянии. В адресном пространстве принимающей программы этот указатель будет недействителен. Поэтому функция Loggit вносит это сообщение в таблицу глобальных элементов системы Windows (global atom table). После этого она обращается к функции SendMessage, передавая ей следующие параметры: значение -1 для дескриптора окна, WM_LOGGIT в качестве номера сообщения и элемент для wParam. Функция SendMessage сохраняет за собой управление до тех пор, пока действующие в системе окна верхнего уровня не обработают это сообщение. Теперь этот элемент можно безболезненно удалить.</p>

<p>При подготовке сообщений о состоянии очень кстати придется функция NameOfIID, предусмотренная в модуле DllDebug. Согласно документации, она передает идентификаторы интерфейсов IIDs, реализуемых расширениями оболочки. Однако к ним можно добавить любые значения системных IID, необходимых для вашего проекта. Например, в тело метода QueryInterface можно было бы вставить следующую строку: </p>

<p> &nbsp; Loggit(Format('QueryInterface: %s requested', [NameOfIID(WantIID)]));</p>

<p>Организовать передачу сообщения WM_LOGGIT - это еще полдела. Нужна программа, которая будет принимать и регистрировать сообщения о производимых операциях. Утилита Logger, предлагаемая службой PC Magazine Online, - один из возможных вариантов решения этой задачи. </p>

<p>Поскольку значение, имеющееся в сообщении WM_LOGGIT, становится известным только в процессе исполнения, нет возможности задать стандартный метод обработки сообщения. Поэтому в программе Logger переопределяется интерфейсный метод DefaultHandler. При прохождении сообщения WM_LOGGIT этот метод извлекает сообщение о состоянии из передаваемого элемента и добавляет его в имеющийся список окна просмотра. Помимо этой основной функции она обслуживает три рабочие кнопки - для вставки комментария пользователя, для очистки окна списка и для сохранения зарегистрированных сообщений в файле. На рис. А вы видите момент выполнения программы Logger. </p>

<p>В приведенном диалоговом окне представлены методы QueryInterface нескольких COM объектов, подготовленных в среде Delphi, инструментированные строкой, в которой регистрируется имя запрашиваемого интерфейса. Перед вами список запросов, отправленных, когда Explorer извлек пиктограмму для некоторого файла, затем пользователь щелкнул на ней правой клавишей мыши и просмотрел его параметры. Все работает правильно. Если же наша утилита вдруг выводит на экран неожиданные результаты, тогда в сомнительный фрагмент своей программы можно добавить новые обращения к функции Loggit и повторять эксперимент до тех пор, пока не удастся найти ошибку. </p>

<p>© Нил Дж. Рубенкинг</p>
<p>Материал взят с PC Magazine, January 21, 1997</p>

<p>Взято с сайта <a href="https://www.emanual.ru" target="_blank">www.emanual.ru</a></p>
