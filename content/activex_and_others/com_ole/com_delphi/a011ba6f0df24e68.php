<h1>OLE Automation</h1>
<div class="date">01.01.2007</div>


<p>Стандарт COM основан на едином для всех поддерживающих его языков формате таблицы, описывающей ссылки на методы объекта, реализующего интерфейс. Однако, вызов методов при помощи этой таблицы доступен только для компилирующих языков программирования. В то же время, очень удобно было бы иметь доступ к богатству возможностей, предоставляемых COM из интерпретирующих языков, таких, как VBScript. Для поддержки этих языков была разработана технология под названием OLE Automation, позволяющая приложениям делать свою функциональность доступной для гораздо большего числа клиентов. Automation базируется на COM и является его подмножеством, однако накладывает на COM-серверы ряд дополнительных требований:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Интерфейс, реализуемый COM-сервером должен наследоваться от IDispatch</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>Должны использоваться типы данных, из числа поддерживаемых OLE Automation</td></tr></table></div>Тип данных OLE Automation &nbsp; &nbsp; &nbsp; &nbsp;Тип данных Delphi &nbsp; &nbsp; &nbsp; &nbsp;Примечание &nbsp; &nbsp; &nbsp; 
<p>Boolean &nbsp; &nbsp; &nbsp; &nbsp;WordBool</p>
<p>Unsigned Char &nbsp; &nbsp; &nbsp; &nbsp;Byte &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>Double &nbsp; &nbsp; &nbsp; &nbsp;Double &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>Float &nbsp; &nbsp; &nbsp; &nbsp;Single &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>Int &nbsp; &nbsp; &nbsp; &nbsp;SYSINT  &nbsp; &nbsp; &nbsp; &nbsp;Машинно-зависимый целый тип данных, в настоящее время объявлен как Integer, однако, в будущем может иметь другую разрядность &nbsp; &nbsp; &nbsp; </p>
<p>Long &nbsp; &nbsp; &nbsp; &nbsp;Integer &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>Short &nbsp; &nbsp; &nbsp; &nbsp;SmallInt &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>BSTR &nbsp; &nbsp; &nbsp; &nbsp;WideString &nbsp; &nbsp; &nbsp; &nbsp;В Automation нельзя использовать строки Delphi &nbsp; &nbsp; &nbsp; </p>
<p>Currency &nbsp; &nbsp; &nbsp; &nbsp;Currency &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>Date &nbsp; &nbsp; &nbsp; &nbsp;TDateTime &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </p>
<p>SAFEARRAY &nbsp; &nbsp; &nbsp; &nbsp;PSafeArray &nbsp; &nbsp; &nbsp; &nbsp;Массив из элементов любого поддерживаемого типа &nbsp; &nbsp; &nbsp; </p>
<p>Decimal &nbsp; &nbsp; &nbsp; &nbsp;TDecimal &nbsp; &nbsp; &nbsp; &nbsp;96 битное десятичное число. &nbsp; &nbsp; &nbsp; </p>
<p>Interface IDispatch * &nbsp; &nbsp; &nbsp; &nbsp;IDispatch &nbsp; &nbsp; &nbsp; &nbsp;Ссылка на IDispatch или любой унаследованный от него интерфейс &nbsp; &nbsp; &nbsp; </p>
<p>Interface IUnknown * &nbsp; &nbsp; &nbsp; &nbsp;IUnknown &nbsp; &nbsp; &nbsp; &nbsp;Ссылка на произвольный интерфейс &nbsp; &nbsp; &nbsp; </p>
<p>VARIANT &nbsp; &nbsp; &nbsp; &nbsp;OleVariant &nbsp; &nbsp; &nbsp; &nbsp;Вариант, совместимый с OLE &nbsp; &nbsp; &nbsp; </p>
<p>Возможна поддержка пользовательских типов данных, для чего необходимо реализовать интерфейс IRecordInfo</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Все методы должны быть процедурами или функциями, возвращающими значение типа HRESULT</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>Все методы должны иметь соглашение о вызовах safecall</td></tr></table></div>Кроме этого, Automation-серверы могут поддерживать еще ряд интерфейсов, позволяющих получать информацию о методах, обрабатывать ошибки и т.п. Все необходимые интерфейсы реализуются VCL Delphi автоматически.</p>
IDispatch</p>
<p>Центральным элементом технологии OLE Automation является интерфейс IDispatch. Ключевыми методами этого интерфейса являются методы GetIdsOfNames и Invoke, которые позволяют клиенту запросить у сервера, поддерживает ли он метод с указанным именем, а затем, если метод поддерживается &#8211; вызвать его. Подробно реализация и работа IDispatch рассматривается в главе, посвященной работе с Mcrosoft Scripting Control, здесь же мы лишь вкратце опишем основной алгоритм вызова методов при помощи IDispatch.</p>
<p>Когда клиенту требуется вызвать метод, он вызывает GetIdsOfNames, передавая ему имя запрошенного метода. Если сервер поддерживает такой метод, он возвращает его идентификатор &#8211; целое число, уникальное для каждого метода. После этого клиент упаковывает параметры в массив переменных типа OleVariant и вызывает Invoke, передавая ему массив параметров и идентификатор метода.</p>
<p>Таким образом, все, что должен знать клиент &#8211; это строковое имя метода. Такой алгоритм позволяет работать с наследниками IDispatch из скриптовых языков.</p>
<p>Методы GetTypeInfo и GetTypeInfoCount являются вспомогательными и обеспечивают поддержку библиотеки типов объекта. Реализация методов GetIdsOfNames и Invoke, предоставляемая COM по умолчанию базируется на библиотеке типов объекта.</p>
Поддержка IDispatch, тип данных Variant</p>
<p>Delphi имеет встроенную поддержку работы в качестве клиента Automation. Тип данных Variant может содержать ссылку на интерфейс IDispatch и использоваться для вызова его методов.</p>
<pre>
uses ComObj;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  V: Variant;
begin
  V := CreateOleObject('InternetExplorer.Application');
  V.Toolbar := FALSE;
  V.Left := (Screen.Width - 600) div 2;
  V.Width := 600;
  V.Top := (Screen.Height - 400) div 2;
  V.Height := 400;
  V.Visible := TRUE;
  V.Navigate(URL := 'file://C:\config.sys');
  V.StatusText := V.LocationURL;
  Sleep(10000);
  V.Quit;
end;
</pre>

<p>Приведенный выше код весьма необычен и заслуживает внимательного рассмотрения.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Переменная V не является классом и, очевидно не имеет ни одного из используемых свойств и методов.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>Вызываемые свойства и методы нигде не описаны, однако это не вызывает ошибки компиляции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>Объект создается не по CLSID, а по информативному имени, функцией CreateOleObject</td></tr></table></div>Все это непривычно и выглядит довольно странно. На самом деле &#8211; ничего странного нет. Компилятор Delphi просто запоминает в коде программы строковые описания обращений к серверу автоматизации, а на этапе выполнения передает их его интерфейсу IDispatch, который и производит синтаксический разбор и выполнение. Исправим третью строку функции на:</p>
<p>  V.Left1 := (Screen.Width - 600) div 2;</p>
<p>Программа успешно откомпилируется, однако, при попытке выполнить выдаст ошибку с сообщением, что метод «Left1» не поддерживается сервером автоматизации.</p>
<p>Такое обращение к серверу называется поздним связыванием, что означает, что связывание имен свойств и методов объекта с их кодом происходит не на этапе компиляции, а на этапе выполнения программы.</p>
<p>Достоинства позднего связывания очевидны &#8211; не нужна библиотека типов, написание несложных программ упрощается. Столь же очевидны недостатки &#8211; не производится контроль вызовов и передаваемых параметров на этапе компиляции, работа несколько медленнее, чем при раннем связывании.</p>
<p>! &nbsp; &nbsp; &nbsp; &nbsp;Если COM-сервер находится в другой «комнате» - затраты на позднее связывание пренебрежимо малы, по сравнению с затратами на маршаллинг вызовов. Разница в скорости между ранним и поздним связыванием становится ощутимой (десятки и сотни раз) при нахождении клиента ми сервера в одной «комнате», что возможно только для In-Proc сервера при совместимой с клиентом потоковой модели. Для Out-Of-Proc сервера (размещенного в отдельном исполнимом файле) затраты на вызов метода практически равны.</p>
<p>В связи с этим главным преимуществом раннего связывания является строгий контроль типов на этапе компиляции. Для разрешения проблемы нестрогого контроля типов COM предлагает несколько дополнительных возможностей</p>

Dispinterface</p>
<p>Dispinterface &#8211; это декларация методов, доступных через интерфейс IDispatch. Объявляется он следующим образом:</p>
<pre>
type
  IMyDisp = dispinterface
    ['{EE05DFE2-5549-11D0-9EA9-0020AF3D82DA}']
    property Count: Integer dispid 1
    procedure Clear dispid 2; 
  end;
</pre>

<p>Самих методов может физически и не существовать (например, они реализуются динамически в Invoke). Рассмотрим использование dispinterface на простом примере. Объявим диспинтерфейс объекта InternetExplorer и используем его в своей программе:</p>
<pre>
type
  IIE = dispinterface
  ['{0002DF05-0000-0000-C000-000000000046}']
    property Visible: WordBool dispid 402;
  end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  II: IIE;
begin
  II := CreateOleObject('InternetExplorer.Application') as IIE;
  II.Visible := TRUE;
end;
</pre>

<p>Эта программа успешно компилируется и работает, несмотря на то, что в интерфейсе объявлено только одно из множества имеющихся свойств и методов. Это возможно благодаря тому, что Delphi не вызывает методы диспинтерфейса напрямую и, поэтому, не требует полного описания всех методов в правильном порядке. При вызове метода диспинтерфейса Delphi просто вызывает Invoke соответствующего IDispatch, передавая ему идентификатор метода, указанный в dispid. В результате программисту становятся доступна возможность строгого контроля типов при вызове методов IDispatch и вызов методов, реализованных в IDispatch без формирования сложных структур данных для вызова Invoke. Необходимо лишь описать (или импортировать из библиотеки типов сервера) описание диспинтерфейса.</p>
<p>В описании диспинтерфейса допустимо использовать только OLE-совместимые типы данных.</p>
Dual Interfaces</p>
<p>Идея двойных интерфейсов очень проста. Сервер реализует одновременно некоторый интерфейс, оформленный по стандартам COM (VTable) и диспинтерфейс, доступный через IDispatch. При этом интерфейс VTable должен быть унаследован от IDispatch и иметь идентичный с диспинтерфейсом набор методов. Такое оформление сервера позволяет клиентам работать с ним наиболее удобным для каждого клиента образом.</p>
<p>Клиенты, использующие VTable вызывают методы интерфейса напрямую, а клиенты, использубщие позднее связывание &#8211; через методы IDispatch.</p>
<p>Большинство OLE-серверов реализуют двойной интерфейс.</p>
Создание Automation серверов</p>
<p>Чтобы создать при помощи Delphi сервер, совместимый с OLE Automation необходимо включить в свое приложение Automation Object. Мастер для его создания запускается при выборе File -&gt; New -&gt; ActiveX -&gt; Automation Object</p>
<p>
<p>В поле CoClassName вводится имя создаваемого объекта. Поля Instancing и Threading Model аналогичны рассмотренным выше при создании COM сервера. Наибольший интерес представляет собой флаг Generate Event Support code. В случае, если он задан, генерируется дополнительный код, позволяющий серверу реализовать интерфейс событий. Этот интерфейс описывает события, которые может генерировать сервер. Клиент может зарегистрировать себя в качестве подписчика на эти события и получать уведомления о них. Для того, чтобы понять механизм этого процесса отвлечемся от создания ActiveX сервера и рассмотрим событийную модель COM.</p>
<p>События в COM</p>
<p>При возникновении события в COM-сервере, которое он должен передать клиенту, сервер должен вызвать какой-либо из методов клиента. Фактически, в этот момент клиент с сервером меняются местами. Обращение к клиенту осуществляется при помощи стандартных механизмов COM. Основная идея заключается в том, что сервер, генерирующий события декларирует интерфейс их обработчика. Клиент, подписывающийся на события, должен реализовать этот интерфейс (т.е. фактически должен быть или включать в себя COM-объект, реализующий интерфейс). Кроме этого сервер должен&nbsp; реализовать стандартные интерфейсы COM, позволяющие зарегистрировать на нем обработчик событий. Клиент, используя эти интерфейсы, регистрирует на сервере интерфейс обработчика событий, позволяя серверу вызывать свои методы. Рассмотрим основные интерфейсы, используемые в этом процессе.</p>
<pre>
type
  IConnectionPointContainer = interface
    ['{B196B284-BAB4-101A-B69C-00AA00341D07}']
    function EnumConnectionPoints(out Enum: IEnumConnectionPoints): HResult;
      stdcall;
    function FindConnectionPoint(const iid: TIID;
      out cp: IConnectionPoint): HResult; stdcall;
  end;
</pre>

<p>Этот интерфейс должен реализовываться каждым COM-объектом, который позволяет подключаться к своим событиям. Ключевой метод FindConnectionPoint, который получает GUID интерфейса-обработчика и возвращает указатель на соответствующую этому обработчику «точку подключения». Такой подход позволяет серверу иметь несколько интерфейсов для обработки событий и позволять клиентам подключаться к ним по необходимости. В случае успеха метод возвращает S_OK, иначе &#8211; код ошибки.</p>
<p>Точка подключения также представляет собой интерфейс:</p>
<pre>
type
  IConnectionPoint = interface
    ['{B196B286-BAB4-101A-B69C-00AA00341D07}']
    function GetConnectionInterface(out iid: TIID): HResult; stdcall;
    function GetConnectionPointContainer(out cpc: IConnectionPointContainer):
      HResult; stdcall;
    function Advise(const unkSink: IUnknown; out dwCookie: Longint): HResult;
      stdcall;
    function Unadvise(dwCookie: Longint): HResult; stdcall;
    function EnumConnections(out Enum: IEnumConnections): HResult; stdcall;
  end;
</pre>

<p>Ключевые методы этого интерфейса &#8211; Advise и Unadvise.</p>
<p>function Advise(const unkSink: IUnknown; out dwCookie: Longint): HResult;</p>
<p>  stdcall;</p>
<p>Этот метод регистрирует на сервере клиентский интерфейс обработчика событий, который передается в параметре unkSink. Метод возвращает dwCookie &#8211; идентификатор подключения, который должен использоваться при отключении обработчика событий. Начиная с этого момента, сервер, при возникновении события, вызывает методы переданного ему интерфейса-обработчика.</p>
<p>function Unadvise(dwCookie: Longint): HResult; stdcall;</p>
<p>Метод Unadvise отключает обработчик от сервера. Теперь, когда мы имеем базовое понимание, как COM реализует обработчики событий, можно продолжить работу над нашим сервером.</p>
<p>Продолжаем создание Automation сервера</p>
<p>Если флаг Generate Event Support code включен, то Delphi автоматически добавляет в библиотеку типов сервера интерфейс IXXXEvents, где XXX &#8211; имя Automation объекта</p>
<p><img src="/pic/clip0236.gif" width="216" height="200" border="0" alt="clip0236"></p>
<p>В этот интерфейс Вы должны добавить методы, которые должен реализовать обработчик событий Вашего сервера</p>
<p>Создадим интерфейс обработчика событий с методом TestEvent и метод FireEvent&nbsp; интерфейса IAutoTest.</p>
<p>В сгенерированном файле с реализацией сервера добавим код для вызова обработчика события в метод FilreEvent</p>
<pre>
procedure TAutoTest.FireEvent;
begin
  if FEvents &lt;&gt; NIL then
    FEvents.TestEvent;
end;
</pre>

<p>Здесь FEvents&nbsp; - автоматически добавленный Delphi в код сервера интерфейс IAutoTestEvents.</p>
<p>Компилируем и регистрируем сервер аналогично любому другому COM-серверу. Теперь его можно использовать из любого Automation клиента, например из скрипта на Web-странице</p>
<p>lt;HTML&gt;</p>
<p> &lt;HEAD&gt;</p>
<p>  &lt;TITLE&gt;Test Page&lt;/TITLE&gt;</p>
<p> &lt;/HEAD&gt;</p>
<p> &lt;BODY LANGUAGE = VBScript ONLOAD = "Page_Initialize"&gt;</p>
<p>  &lt;CENTER&gt;</p>
<p> &nbsp;&nbsp; &lt;OBJECT CLASSID="clsid:344E2D50-7B91-11D4-84DD-97E4E55E3E05" ID=Ctrl1&gt;</p>
<p> &nbsp;&nbsp; &lt;/OBJECT&gt;</p>
<p> &nbsp;&nbsp; &lt;INPUT TYPE = TEXT NAME = Textbox SIZE=20&gt;</p>
<p>  &lt;/CENTER&gt;</p>
<p>  &lt;SCRIPT LANGUAGE = VBScript&gt;</p>
<p> &nbsp; Sub Page_Initialize</p>
<p> &nbsp;&nbsp; Ctrl1.FireEvent</p>
<p> &nbsp; End Sub</p>
<p> &nbsp; Sub Ctrl1_TestEvent</p>
<p> &nbsp;&nbsp; MsgBox("Event Fired")</p>
<p> &nbsp;&nbsp; Textbox.Value = "Hi !"</p>
<p> &nbsp; End Sub</p>
<p>  &lt;/SCRIPT&gt;</p>
<p> &lt;/BODY&gt;</p>
<p>&lt;/HTML&gt;</p>
<p>Здесь в качестве Clsid элемента OBJECT необходимо указать содержание константы CLASS_AutoTest из файла Project1_TLB, сгенерированного Delphi. Загрузив эту страницу в Internet Explorer Вы получите сообщение при загрузке страницы.</p>
<p>Создание обработчика событий COM</p>
<p>Для лучшего понимания механизма обработки событий COM создадим программу, обрабатывающую события от нашего сервера. Для этого создадим проект с одной формой и добавим в него объект, реализующий интерфейс IAutoTestEvents. Этот объект реализуется в виде Automation Object</p>
<p><img src="/pic/clip0237.gif" width="464" height="281" border="0" alt="clip0237"></p>
<p>После этого, в редакторе библиотеки типов необходимо произвести следующие действия:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Для созданного объекта вводим все методы, имеющиеся в интерфейсе IAutoTestEvents</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>В поле GUID заменяем автоматически сгенерированный идентификатор на содержимое константы DIID_IAutoTestEvents из библиотеки типов объекта IAutoEvents. Если этого не сделать, наш обработчик не удастся зарегистрировать в объекте IAutoEvents.</td></tr></table></div>Нажимаем кнопку «Обновить» и в сгенерированном модуле пишем код обработчика события</p>
<pre>
procedure TEventSink.TestEvent;
begin
  MessageBox(0, 'Event Fired', NIL, 0);
end;
</pre>

<p>Обработчик готов, теперь надо добавить в проект код для его использования</p>
<p><img src="/pic/clip0238.gif" width="613" height="400" border="0" alt="clip0238"></p>
<p>Добавляем к классу формы поля для хранения необходимых данных &#8211; ссылки на экземпляр обработчика событий, экземпляр объекта, точку подключения и идентификатор подключения.</p>
<pre>
type
  TForm1 = class(TForm)
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    EventSink: IEventSink;
    AutoTest: IAutoTest;
    ConnectionPoint: IConnectionPoint;
    Cookie: Integer;
  end;
</pre>

<p>При создании формы создаем COM-сервер AutoTest и COM-объект обработчика событий</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  Container: IConnectionPointContainer;
begin
  AutoTest := CreateOleObject('Project1.AutoTest') as IAutoTest;
  EventSink := TEventSink.Create as IEventSink;
</pre>

<p>Запрашиваем у COM-сервера интерфейс IConnectionPointContainer</p>
<p>  Container := AutoTest as IConnectionPointContainer;</p>
<p>Получаем ссылку на точку подключения</p>
<p>  OleCheck(Container.FindConnectionPoint(IEventSink, ConnectionPoint));</p>
<p>И регистрируем в ней свой обработчик</p>
<p>  OleCheck(ConnectionPoint.Advise(EventSink, Cookie));</p>
<p>end;</p>
<p>По окончании работы &#8211; отключаем обработчик</p>
<pre>
procedure TForm1.FormDestroy(Sender: TObject);
begin
  ConnectionPoint.UnAdvise(Cookie);
end;
</pre>

<p>Все. Теперь можно вызвать метод объекта и убедиться, что обработчик реагирует на события в нем:</p>
<pre>procedure TForm1.Button1Click(Sender: TObject);
begin
  AutoTest.FireEvent;
end;
</pre>

<p><img src="/pic/clip0239.gif" width="356" height="275" border="0" alt="clip0239"></p>
<p>Хорошая новость &#8211; проделывать все эти сложные манипуляции не обязательно. Мы сделали это в основном для демонстрации механизмов работы COM. Можно пойти другим, более простым путем. Для этого Вы можете просто импортировать библиотеку типов сервера, поддерживающего события и в мастере импорта библиотеки типов нажать кнопку Install. </p>
<p><img src="/pic/clip0240.gif" width="477" height="581" border="0" alt="clip0240"></p>
<p>После этого на закладку ActiveX палитры компонентов будет помещен компонент для работы с этим сервером, который можно просто положить на форму</p>
<p><img src="/pic/clip0241.gif" width="636" height="244" border="0" alt="clip0241"></p>
<p>При этом сгенерированный компонент Delphi будет иметь обработчики событий для всех событий, объявленных в COM-объекте. Вам останется лишь написать для них свой код. Всю работу по созданию объекта-обработчика, подключению к серверу&nbsp; и трансляции его событий в события компонента VCL Delphi возьмет на себя.</p>

