<h1>Сервер приложения (статья)</h1>
<div class="date">01.01.2007</div>


<p>Многозвенные распределенные приложения обеспечивают эффективный доступ удаленных клиентов к базе данных, так как в них для управления доступом к данным применяется специализированное ПО промежуточного слоя. В наиболее распространенной схеме &#8212; трехзвенном приложении &#8212; это сервер приложения, который выполняет следующие функции:</p>

<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> обеспечивает авторизацию пользователей;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> принимает и передает запросы пользователей и пакеты данных;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> регулирует доступ клиентских запросов к серверу БД, балансируя нагрузку сервера БД;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> может содержать часть бизнес-логики распределенного приложения, обеспечивая существование "тонких" клиентов.</td></tr></table>
<p>Delphi обеспечивает разработку серверов приложений на основе использования ряда технологий:</p>

<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> Web;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> Автоматизация;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> MTS;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td> SOAP.</td></tr></table>
<p>Структура сервера приложения</p>

<p>Итак, сервер приложения &#8212; это ПО промежуточного слоя трехзвенного распределенного приложения. Его основой является удаленный модуль данных. В Delphi предусмотрено использование удаленных модулей данных пяти типов (см. ниже).</p>

<p>Далее в этой главе мы детально рассмотрим вопросы использования удаленных модулей данных, инкапсулирующих функции серверов Автоматизации. Другие типы удаленных модулей данных рассматриваются в следующих частях книги.</p>

<p>Каждый удаленный модуль данных инкапсулирует интерфейс IAppServer, методы которого используются в механизме удаленного доступа клиентов к серверу БД.</p>

<p>Для обмена данными с сервером БД модуль данных может содержать некоторое количество компонентов доступа к данным (компонентов соединений и компонентов, инкапсулирующих набор данных).</p>

<p>Для обеспечения передачи данных клиентам удаленный модуль данных обязательно должен содержать необходимое количество компонентов TDataSetProvider, каждый из которых должен быть связан с соответствующим набором данных.</p>

<p>Внимание</p>

<p>Обмен данными сервера приложения с клиентами обеспечивает динамическая библиотека MIDAS.DLL, которая должна быть зарегистрирована на компьютере сервера приложения.</p>

<p>Для создания нового сервера приложения достаточно выполнить несколько простых операций.</p>

<p>1. Создать новый проект, выбрав в качестве типа проекта обычное приложение (пункт меню File | New | Application) и сохранить его.</p>

<p>2. В зависимости от используемой технологии, выбрать из Репозитория Delphi необходимый тип удаленного модуля данных (см. рис. 20.3). Удаленные модули данных располагаются на страницах Multitier, WebSnap и WebServices.</p>

<p>3. Настроить параметры создаваемого удаленного модуля данных (см. ниже).</p>

<p>4. Разместить в удаленном модуле данных компоненты доступа к данным и настроить их. Здесь разработчик может выбрать один из имеющихся</p>

<p>наборов компонентов (см. часть IV) в зависимости от используемого сервера БД и требуемых характеристик создаваемого приложения.</p>

<p>5. Разместить в удаленном модуле данных необходимое число компонентов TDataSetProvider и связать их с компонентами, инкапсулирующими наборы данных.</p>

<p>6. При необходимости создать для потомка интерфейса IAppServer, используемого в удаленном модуле данных, дополнительные методы. Для этого создается новая библиотека типов (см. низке).</p>

<p>7. Скомпилировать проект и создать исполняемый файл сервера приложения.</p>

<p>8. Зарегистрировать сервер приложения и при необходимости настроить дополнительное ПО.</p>

<p>Весь механизм удаленного доступа, инкапсулированный в удаленных модулях данных и компонентах-провайдерах, работает автоматически, без создания разработчиком дополнительного программного кода.</p>

<p>Далее в этой главе на простом примере рассматриваются все перечисленные этапы создания сервера приложения.</p>

<p>Интерфейс IAppServer</p>

<p>Интерфейс IAppServer является основной механизма удаленного доступа клиентских приложений к серверу приложения. Набор данных клиента использует его для общения с компонентом-провайдером на сервере приложения. Наборы данных клиента получают экземпляр IAppServer от компонента соединения в клиентском приложении.</p>

<p>При создании удаленных модулей данных (см. ниже) каждому такому модулю ставится в соответствие вновь создаваемый интерфейс, предком которого является интерфейс IAppServer.</p>

<p>Разработчик может добавить к новому интерфейсу собственные методы, которые, благодаря возможностям механизма удаленного доступа многозвенных приложений, становятся доступны приложению-клиенту.</p>

<p>Свойство</p>
<p>property AppServer: Variant;</p>

<p>в клиентском приложении имеется как в компонентах удаленного соединения, так и клиентском наборе данных.</p>

<p>По умолчанию интерфейс является несохраняющим состояние (stateless). Это означает, что вызовы методов интерфейса независимы и не привязаны</p>

<p>к предыдущему вызову. Поэтому интерфейс IAppServer не имеет свойств, которые бы хранили информацию о состоянии между вызовами.</p>

<p>Обычно разработчику ни к чему использовать методы интерфейса напрямую, однако его значение для многозвенных приложений трудно переоценить. И при детальной работе с механизмом удаленного доступа интерфейс понадобится так или иначе.</p>

<p>Методы интерфейса IAppServar</p>

<p>function AS ApplyUpdates (const ProviderName: WideString; Delta: OleVariant; MaxErrors: Integer; out ErrorCount: Integer; var OwnerData: OleVariant) : OleVariant; safecall; Передает изменения, полученные от клиентского набора данных, компоненту-провайдеру, определяемому параметром ProviderName. Изменения содержатся в параметре Delta. Параметр MaxErrors задает максимальное число ошибок, пропускаемых при сохранении данных перед прерыванием операции. Реальное число возникших ошибок возвращается параметром ErrorCount. Параметр OwnerData содержит дополнительную информацию, передаваемую между клиентом и сервером (например, значения параметров методов-обработчиков). Функция возвращает пакет данных, содержащий все записи, которые не были сохранены в базе данных по какой-либо причине</p>

<p>function AS DataRequest (const ProviderName: WideString; Data: OleVariant) : OleVariant; safecall; Генерирует событие OnDataRequest для указанного провайдера ProviderName</p>

<p>procedure AS Execute (const ProviderName: WideString; const CommandText : WideString; var Params : OleVariant; var OwnerData: OleVariant) ; safecall;</p>
<p>Выполняет запрос или хранимую процедуру, определяемые параметром CommandText для провайдера, указанного параметром ProviderName. Параметры запроса или хранимой процедуры содержатся в параметре Params</p>

<p>function AS GetParams (const ProviderName: WideString; var OwnerData: OleVariant): OleVariant; safecall; Передает провайдеру ProviderName текущие значения параметров клиентского набора данных</p>

<p>function AS GetProviderNames: OleVariant; safecall; Возвращает список всех доступных провайдеров удаленного модуля данных</p>

<p>function AS GetRecords (const ProviderName : WideString, Count: Integer; out RecsOut: Integer; Options: Integer; const CommandText: WideString; var Params : OleVariant; var OwnerData :OieVariant) : OleVariant; safecall;</p>
<p>Возвращает пакет данных с записями набора данных сервера, связанного с компонентом-провайдером. Параметр CommandText содержит имя таблицы, текст запроса или имя хранимой процедуры, откуда необходимо получить записи. Но он работает только в случае, если для провайдера в параметре Options включена опция poAllowCommandText. Параметры запроса или процедуры помещаются в параметре Params. Параметр задает требуемое число записей, начиная с текущей, если его значение больше нуля. Если параметр равен нулю &#8212; возвращаются только метаданные, если он равен -1 &#8212; возвращаются все записи. Параметр RecsOut возвращает реальное число переданных записей</p>

<p>function AS RowRequest (const ProviderName: WideString; Row: OleVariant; RequestType: Integer; var OwnerData: OleVariant): OleVariant; safecall;</p>
<p>Возвращает запись набора данных (предоставляемого провайдером ProviderName), определяемую параметром Row. Параметр RequestType содержит значение типа TfetchOptions</p>

<p>Большинство методов интерфейса используют параметры ProviderName и OwnerData. Первый определяет имя компонента-провайдера, а второй содержит набор параметров, передаваемых для использования в методах-обработчиках.</p>

<p>Внимательный читатель обратил внимание, что использование метода AS_GetRecords подразумевает сохранение информации при работе интерфейса, т. к. метод возвращает записи, начиная с текущей, хотя интерфейс IAppServer имеет тип stateless. Поэтому перед использованием метода рекомендуется обновлять набор данных клиента.</p>

<p>Тип</p>

<p>TFetchOption = (foRecord, foBlobs, foDetails);</p>
<p>TFetchOptions = set of TFetchOption;</p>

<p>используется в параметре RequestType метода AS_RowRequest.</p>

<p>foRecord &#8212; возвращает значения полей текущей записи;</p>

<p>foBlobs &#8212; возвращает значения полей типа BLOB текущей записи;</p>

<p>foDetails &#8212; возвращает все подчиненные записи вложенных наборов данных для текущей записи.</p>

<p>Интерфейс IProviderSupport</p>

<p>Для организации взаимодействия клиентов с сервером БД удаленный модуль данных сервера приложения должен содержать компоненты-провайдеры TDataSetProvider. При этом используются методы интерфейса IAppServer.</p>

<p>Для обмена данными с набором данных на сервере компонент-провайдер применяет интерфейс IProviderSupport, который включен в любой компонент набора данных, произошедший от класса TDataSet. В зависимости от используемой технологии доступа к данным каждый компонент, инкапсулирующий набор данных, имеет собственную реализацию методов интерфейса IProviderSupport.</p>

<p>Методы интерфейса могут понадобится разработчику только при создании собственных компонентов, инкапсулирующих набор данных и наследующих от класса TDataSet.</p>

<p>Удаленные модули данных</p>

<p>Удаленный модуль данных является основой сервера приложения (см. рис. 20.2) для многозвенного распределенного приложения. Во-первых, он выполняет функции обычного модуля данных &#8212; на нем можно размещать компоненты доступа к данным. Во-вторых, удаленный модуль данных инкапсулирует интерфейс IAppServer, обеспечивая тем самым выполнение функций сервера и обмен данными с удаленными клиентами.</p>

<p>В зависимости от используемой технологии в Delphi можно использовать удаленные модули данных пяти типов.</p>

<p>Remote Data Module. Класс TRemoteDataModule инкапсулирует сервер Автоматизации.</p>
<p>Transactional Data Module. Класс TMTSDataModule является потомком класса TRemoteDataModule и к функциям обычного сервера Автоматизации добавляет возможности MTS.</p>

<p>WebSnap Data Module. Класс TWebDataModule создает сервер приложения, использующий возможности Internet-технологий.</p>

<p>Soap Server Data Module. Класс TSOAPDataModule инкапсулирует сервер SOAP.</p>

<p>CORBA Data Module. Класс TCORBADataModule является потомком класса TRemoteDataModule и реализует функции сервера CORBA.</p>

<p>Ниже мы рассмотрим процесс создания сервера приложения на основе удаленного модуля данных TRemoteDataModule. Остальные модули данных (за исключением удаленного модуля данных для CORBA) детально рассматриваются далее в этой книге.</p>

<p>Удаленный модуль данных для сервера Автоматизации</p>

<p>Для создания удаленного модуля данных TRemoteDataModule используется Репозиторий Delphi (команда File | New | Other). Значок класса TRemoteDataModuie находится на странице Multitier. Перед созданием экземпляра удаленного модуля данных появляется диалоговое окно, в котором необходимо предустановить три параметра.</p>
<p>Строка CoClass Name должна содержать имя нового модуля данных, которое будет также использовано для именования нового класса, создаваемого для поддержки нового модуля данных.</p>

<p>Список Instancing позволяет задать способ создания модуля данных.</p>

<p>- Internal &#8212; модуль данных обеспечивает функционирование лишь внутреннего сервера Автоматизации.</p>
<p>- Single Instance &#8212; для каждого клиентского соединения создается собственный экземпляр удаленного сервера Автоматизации в собственном процессе.</p>
<p>- Multiple Instance &#8212; для каждого клиентского соединения создается собственный экземпляр удаленного сервера Автоматизации в одном общем процессе.</p>

<p>Список Threading Model задает механизм обработки запросов клиентов.</p>

<p>- Single &#8212; поток запросов клиентов обрабатывается строго последовательно.</p>
<p>- Apartment &#8212; модуль данных одновременно обрабатывает один запрос. Однако если DLL для выполнения запросов создает экземпляры СОМ объектов, то для запросов могут создаваться отдельные нити, в которых обработка ведется параллельно.</p>
<p>- Free &#8212; модуль данных может создавать нити для параллельного выполнения запросов.</p>
<p>- Both &#8212; аналогична модели Free, за исключением того, что все ответы клиентам возвращаются строго один за другим.</p>
<p>- Neutral &#8212; запросы клиентов могут направляться модулям данных в нескольких нитях одновременно. Используется только для технологии СОМ+.</p>

<p>При создании нового удаленного модуля данных создается специальный класс &#8212; наследник класса TRemoteDataModule. И фабрика класса на основе класса TComponentFactory</p>

<p>Класс TComponentFactory представляет собой фабрику класса для компонентов Delphi, инкапсулирующих интерфейсы. Поддерживает интерфейс IClass Factory.</p>

<p>Создадим, например, удаленный модуль данных simpleRDM. В мастере создания модуля данных в качестве способа создания выберем Single Instance, a Free &#8212; как модель обработки запросов.</p>
<pre class="delphi">
type  
  TSimpleRDM = class(TRemoteDataModuie, ISimpleRDM) 
  private 
  protected 
    class procedure UpdateRegistry(Register: Boolean; const Classic, ProgID:                                           string); override; 
   public 
  end; 
 
implementation  
 
{$R *.DFM} 
 
class procedure TSimpleRDM.UpdateRegistry(Register: Boolean; const
                ClassID, ProgID: string); 
begin 
  if Register then 
    begin 
      inherited UpdateRegistry(Register, Classic, ProgID); 
      EnableSocketTransport(ClassID); 
      EnableWebTransport(ClassID);  
    end 
  else 
    begin 
      DisableSocketTransport(ClassID); 
      DisableWebTransport(ClassID); 
      inherited UpdateRegistry(Register, ClassID, ProgID); 
   end; 
end; 
 
initialization 
  TComponentFactory.Create(ComServer, TSimpleRDM, Class_SimpleRDM,                            ciMultilnstance, tmApartment);  
end. 
</pre>


<p>Обратите внимание, что параметры модуля данных, заданные при создании, использованы в фабрике класса TComponentFactory в секции initialization.</p>

<p>Фабрика класса TComponentFactory обеспечивает создание экземпляров компонентов Delphi, поддерживающих использование интерфейсов.</p>

<p>Метод класса UpdateRegistry создается автоматически и обеспечивает регистрацию и аннулирование регистрации сервера Автоматизации. Если параметр Register имеет значение True, выполняется регистрация, иначе &#8212; отмена регистрации.</p>

<p>Разработчик не должен использовать этот метод, т. к. его вызов осуществляется автоматически.</p>

<p>Одновременно с модулем данных создается и его интерфейс &#8212; потомок интерфейса IAppServer. Его исходный код содержится в библиотеке типов проекта сервера приложения. Для удаленного модуля данных simpleRDM созданный интерфейс isimpleRDM представлен ниже. Для удобства из листинга удалены автоматически добавляемые комментарии.</p>
<pre class="delphi">
LIBID_SimpleAppSrvr: TGUID='(93577575-OF4F-43B5-9FBE-A5745128D9A4}'; 
IID_ISimpleRDM: TGUID = '{Е2СВЕВСВ-1950-4054-В823-62906306Е840}'; 
CLASS_SimpleRDM: TGUID = '{DB6A6463-5F61-485F-8F23-EC6622091908}' ; 
 
type 
  ISimpleRDM = interface;  
  ISimpleRDMDisp = dispinterface; 
  SimpleRDM = ISimpleRDM; 
  ISimpleRDM = interface(lAppServer) 
  ['{E2CBEBCB-1950-4054-B823-62906306E840}']  
end; 
 
ISimpleRDMDisp = dispinterface 
  ['{E2CBEBCB-1950-4054-B823-62906306E840}'] 
 
function AS_ApplyUpdates(const ProviderName: WideString; Delta: OleVariant; MaxErrors: Integer; out ErrorCount: Integer; var OwnerData: OleVariant): OleVariant; dispid 20000000; function AS_GetRecords(const ProviderName: WideString; Count: Integer; out RecsOut: Integer; Options: Integer; const CommandText: WideString; var Params: OleVariant; var OwnerData: OleVariant): OleVariant; dispid 20000001; 
 
function AS_DataRequest(const ProviderName: WideString; Data: OleVariant): OleVariant; dispid 20000002; 
 
function AS_GetProviderNames: OleVariant; dispid 20000003; 
 
function AS_GetParams(const ProviderName: WideString; 
 
var OwnerData: OleVariant): OleVariant; dispid 20000004; 
 
function AS_RowRequest(const ProviderName: WideString; Row: OleVariant; RequestType: Integer; var OwnerData: OleVariant): OleVariant; dispid 20000005; 
 
procedure AS_Execute(const ProviderName: WideString; const CommandText: WideString; var Params: OleVariant; var OwnerData: OleVariant);  
 
dispid 20000006; 
 
end; 
 
CoSimpleRDM = class 
  class function Create: ISimpleRDM; 
  class function CreateRemote(const MachineName: string): ISimpleRDM; 
end; 
 
imp1ementation uses ComObj; 
 
class function CoSimpleRDM.Create: ISimpleRDM; 
begin 
  Result := CreateComObject(CLASS_SimpleRDM) as ISimpleRDM;  
end; 
 
class function CoSimpleRDM.CreateRemote(const MachineName: string):ISimpleRDM; 
begin 
  Result := CreateRemoteComObject(MachineName, CLASS_SimpleRDM) as ISimpleRDM;  
end; 
 
end. 
</pre>


<p>Обратите внимание, что интерфейс ISimpleRDM является потомком интерфейса IAppServer, рассмотренного выше.</p>

<p>Так как удаленный модуль данных реализует сервер Автоматизации, дополнительно к основному дуальному интерфейсу ISimpleRDM автоматически создан интерфейс диспетчеризации isimpleRDMDisp. При этом для интерфейса диспетчеризации созданы методы, соответствующие методам интерфейса IAppServer.</p>

<p>Класс coSimpleRDM обеспечивает создание СОМ-объектов, поддерживающих использование интерфейса. Для него автоматически созданы два метода класса.</p>

<p>class function Create: ISimpleRDM;</p>

<p>используется при работе с локальным и внутренним сервером (in process).</p>

<p>class function CreateRemote(const MachineName: string): ISimpleRDM;</p>

<p>используется в удаленном сервере.</p>

<p>Оба метода возвращают ссылку на интерфейс ISimpleRDM.</p>

<p>Теперь, если проект с созданным модулем данных сохранить и зарегистрировать, он станет доступен в удаленных клиентских приложениях как сервер приложения.</p>

<p>После создания удаленный модуль данных становится платформой для размещения компонентов доступа к данным и компонентов провайдеров (см. гл. 20), которые, наряду с модулем данных, реализуют основные функции сервера приложения.</p>

<p>Дочерние удаленные модули данных</p>

<p>Один сервер приложения может содержать несколько удаленных модулей данных, которые, например, выполняют различные функции или обращаются к разным серверам БД. В этом случае процесс разработки серверной части не претерпевает изменений. При выборе имени сервера в компоненте удаленного соединения на стороне клиента  будут доступны имена всех удаленных модулей данных, включенных в состав сервера приложения.</p>

<p>Однако тогда для каждого модуля понадобится собственный компонент соединения. Если это нежелательно, можно использовать компонент TSharedConnection, но в этом случае в интерфейсы удаленных модулей данных необходимо внести изменения.</p>

<p>Для того чтобы несколько модулей данных были доступны в рамках одного удаленного соединения, необходимо выделить один главный модуль данных, а остальные сделать дочерними.</p>

<p>Рассмотрим, что же это означает для практики создания удаленных модулей данных. Суть идеи проста. Интерфейс главного модуля данных (разработчик назначает модуль главным, исходя из собственных соображений) должен содержать свойства, указывающие на интерфейсы всех других модулей данных, которые также необходимо использовать в рамках одного соединения на клиенте. Такие модули данных и называются дочерними.</p>

<p>Если такие свойства (свойство должно иметь атрибут только для чтения) существуют, все дочерние модули данных будут доступны в свойстве ChildName Компонента TSharedConnection (см. гл. 20).</p>

<p>Например, если дочерний удаленный модуль данных носит название Secondary, главный модуль данных должен содержать свойство Secondary:</p>
<pre class="delphi">
ISimpleRDM = interface(lAppServer) 
  ['{E2CBEBCB-1950-4054-B823-62906306E840}'] 
  function Get_Secondary: Secondary; safecall; 
  property Secondary: Secondary read Get_Secondary; 
end; 
</pre>


<p>Реализация метода Get_secondary выглядит так:</p>
<pre class="delphi">
function TSimpleRDM.Get_Secondary: Secondary; 
begin 
  Result := FSecondaryFactory.CreateCOMObject(nil) as ISecondary; 
end; 
</pre>


<p>Как видите, в простейшем случае достаточно вернуть ссылку на вновь созданный дочерний интерфейс.</p>

<p>Полностью пример создания дочернего удаленного модуля данных рассматривается далее в этой главе.</p>

<p>Регистрация сервера приложения</p>

<p>Для того чтобы клиент мог "увидеть" сервер приложения, он должен быть зарегистрирован на компьютере сервера. В зависимости от используемой технологии процесс регистрации имеет особенности. Регистрация серверов MTS, Web и SOAP рассматривается далее в этой книге.</p>

<p>Здесь же мы остановимся на регистрации сервера приложения, использующего удаленный модуль данных TRemoteDataModule (сервер Автоматизации), который чрезвычайно прост.</p>

<p>Для исполняемых файлов достаточно запустить сервер с ключом /regserver или даже просто запустить исполняемый файл.</p>

<p>В среде разработки ключ можно поместить в диалоге команды меню Run Parameters.</p>

<p>Для удаления регистрации используется ключ /unregserver, но только в командной строке.</p>

<p>Для регистрации динамических библиотек применяется ключ /regsvr32.</p>



