<h1>Использование Web Services</h1>
<div class="date">01.01.2007</div>

<p>Что такое Web Service</p>
<p>&nbsp;<br>
Последний вид приложений для Web, о котором я хочу рассказать в данном цикле статей&#8211; это Web Services. Web Service &#8211; это приложение-сервер, предоставляющее клиенту свои функции через протоколы Internet. В отличие CGI и других подобных internet приложений, Web Services ориентируются не на предоставление информации человеку в удобной для восприятия форме, а на обмен информацией между приложениями. <br>
Общение клиента и сервера осуществляется путем обмена сообщениями. Web Service может представить клиенту описание своих возможностей в терминах принимаемых и генерируемых им сообщений. При этом детали реализации сервера скрыты от клиента. Таким образом, с точки зрения клиента Web service представляется &#171;черным ящиком&#187;, с определенной функциональностью и заданными способами публикации описания этой функциональности. С другой стороны серверу безразлично как именно клиент формирует сообщения и использует полученные результаты. Налицо компонентно-ориентированный подход. <br>
<p>Применение в качестве транспортного протокола доставки сообщений протокола HTTP позволяет взаимодействовать клиента и сервера вне зависимости от аппаратной платформы и ОС. </p>
<p>Протокол SOAP</p>
<p>&nbsp;<br>
Помимо транспортного протокола для вызова методов сервера необходим единый протокол, описывающий формат сообщений вызова методов сервера. В качестве такого протокола используется SOAP &#8211; Simple Object Access Protocol. Спецификация SOAP 1.1 можно найти в Web по адресу www.w3.org/TR/SOAP. SOAP позволяет использовать вызов удаленных процедур (RPC) через HTTP. <br>
<p>Запросы кодируются в формате XML. Это имеет свои достоинства и недостатки. Достоинства: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Легкость восприятия текста запроса человеком (&#171;читабельность&#187;); </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Наличие парсеров XML, позволяющих достаточно просто осуществлять анализ поступающих сообщений. </td></tr></table></div><p>Из недостатков можно отметить больший объем сообщений по сравнению с бинарными форматами представления данных. Ниже представлен пример SOAP запроса: </p>
<p>POST /examples HTTP/1.1 <br>
User-Agent: Radio UserLand/7.0 (WinNT) <br>
Host: localhost:81 <br>
Content-Type: text/xml; charset=utf-8 <br>
Content-length: 474 <br>
SOAPAction: "/examples" <br>
&nbsp;<br>
&lt;?xml version="1.0"?&gt; <br>
&lt;SOAP-ENV:Envelope <br>
SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" <br>
xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" <br>
xmlns:SOAP-ENV=&#8221;http://schemas.xmlsoap.org/soap/envelope/&#8221; <br>
xmlns:xsd="http://www.w3.org/1999/XMLSchema" <br>
xmlns:xsi="http://www.w3.org/1999/XMLSchema-instance"&gt; <br>
&lt;SOAP-ENV:Body&gt; <br>
&lt;m:getStateName xmlns:m="http://www.soapware.org/"&gt; <br>
&lt;statenum xsi:type="xsd:int"&gt;41&lt;/statenum&gt; <br>
&lt;/m:getStateName&gt; <br>
&lt;/SOAP-ENV:Body&gt; <br>
<p>&lt;/SOAP-ENV:Envelope&gt; </p>
<p>Рассмотрим заголовок запроса. Формат URI в первой строке запроса не специфицирован. Например это может быть просто / или, как в нашем примере /examples. <br>
User Agent и Host должны быть указаны. Content-Type, т.е тип содержимого запроса, естественно, text/xml. Content-Length - lлина запроса. <br>
SoapAction &#8211; значение данного поля используется для передачи сообщения нужному обработчику сообщений сервера. Как правило, значение SoapAction совпадает с URI в первой строке запроса. <br>
Тело запроса представляет собой документ в формате XML. Корневой тег SOAP-ENV:Envelop содержит внутри себя тег SOAP-ENV:Body, содержащий описание вызываемой процедуры. В нашем примере сообщение описывает запрос на вызов процедуры getStateName с параметром statenum равным 41. <br>
<p>Ответ сервера при успешном вызове выглядит так: </p>
<p>HTTP/1.1 200 OK <br>
Connection: close <br>
Content-Length: 499 <br>
Content-Type: text/xml; charset=utf-8 <br>
Date: Wed, 28 Mar 2001 05:05:04 GMT <br>
Server: UserLand Frontier/7.0-WinNT <br>
&nbsp;<br>
&lt;?xml version="1.0"?&gt; <br>
&lt;SOAP-ENV:Envelope <br>
SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" <br>
xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" <br>
xmlns:SOAP-ENV=http://schemas.xmlsoap.org/soap/envelope/ <br>
xmlns:xsd=http://www.w3.org/1999/XMLSchema <br>
xmlns:xsi="http://www.w3.org/1999/XMLSchema-instance"&gt; <br>
&lt;SOAP-ENV:Body&gt; <br>
&lt;m:getStateNameResponse xmlns:m="http://www.soapware.org/"&gt; <br>
&lt;Result xsi:type="xsd:string"&gt;South Dakota&lt;/Result&gt; <br>
&lt;/m:getStateNameResponse&gt; <br>
&lt;/SOAP-ENV:Body&gt; <br>
<p>&lt;/SOAP-ENV:Envelope&gt; </p>
<p>Отметим лишь наиболее важные моменты: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Пространство имен в описании ответа (тег &lt; m:getStateNameResponse &gt;) должен совпадать с пространством имен в запросе. В нашем примере пространство имен &#8211; m </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Имя тега описания ответа формируемся добавлением слова Response к имени вызываемой процедуры. В нашем случае это m:getStateNameResponse </td></tr></table></div><p>Разработка сервера Web Services в Delphi6</p>
<p>Delphi 6 позволяет создавать как сервера, так и клиентов Web Services. Мы начнем рассмотрение с создания сервера. <br>
<p>Создание сервера Web Services в Delphi6 состоит из следующих этапов: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Описание интерфейса сервера, то есть методов, которые будут доступны для вызова клиенту; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Реализация методов сервера; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Создание проекта Delphi и включение в него результатов первых двух шагов. </td></tr></table></div><p>Последовательно опишем каждый из этапов. </p>
<p>Описание интерфейса сервера</p>
<p>&nbsp;<br>
В Delphi при создании сервера Web Services методы доступные для вызова клиенту описываются в виде invokable интерфейсов. Invokable интерфейс &#8211; это интерфейс для методов которого доступна RTTI (информация о типах на этапе выполнения). Для того чтобы из обычного интерфейса сделать invokable достаточно указать директиву компиляции {$M+}. После этого все потомки и сам интерфейс будут содержать RTTI. В иерархии VCL уже есть такой интерфейс IInvokable. Таким образом, при написании сервера проще всего унаследовать свой интерфейс от Iinvokable. Кроме того необходимо зарегистрировать свой интерфейс в invocation registry. Регистрация позволяет серверу определить класс, реализующий методы интерфейса, а клиенту получить описание методов, поддерживаемых сервером. Регистрация осуществляется вызовом метода InvRegistry.RegisterInterface в секции initialization модуля. <br>
Так как интерфейс используется не только сервером, но и клиентом, то желательно определить его в отдельном модуле Delphi. <br>
<p>Для примера мы разработаем сервер, который будет осуществлять пересчет денег из долларов в рубли и обратно. В IDE Delphi выберем пункт меню File/New/Unit. В полученном пустом модуле определим интерфейс сервера: </p>
<pre>
unit u_Intrf;
interface
type
  IEncodeDecode = interface(IInvokable)
 
    ['{32B3312E-684C-444D-88DB-13DE6F535F6D}']
    // Конвертация долларов в рубли
    function US2RUS(Value: Currency): Currency; stdcall;
    // Конвертация рублей в доллары
    function RUS2US(Value: Currency): Currency;
stdcall;
end;
 
implementation
uses  InvokeRegistry;
 
initialization
  InvRegistry.RegisterInterface(TypeInfo(IEncodeDecode));
end.
</pre>
<p>Обратите внимание, что строка ['{32B3312E-684C-444D-88DB-13DE6F535F6D}'] &#8211; это GUID интерфейса, для корректной работы примера Вам необходимо сгенерировать его, а не вводить вручную или копировать из приведенного текста. Генерация GUID в IDE Delphi вызывается нажатием Ctrl+Shift+G. <br>
<p>В случае использования в функциях интерфейсе скалярных типов данных генерация SOAP сообщений происходит автоматически без дополнительных усилий со стороны программиста. Если же Вы хотите использовать сложные типы данных, такие как статические массивы, наборы и классы, то необходимо создать и зарегистрировать класс-наследник от TRemotableXS и переопределить методы XSToNative и NativeToXS. Данные методы конвертируют строковое и бинарное представление Ваших данных друг в друга. </p>
<p>Реализация методов сервера</p>
<p>&nbsp;<br>
<p>Наиболее простым способом реализации интерфейса на сервере является создание и регистрация в invocation реестре класса-наследника от TInvokableClass. Класс TInvokableClass имеет две замечательные особенности: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Invocation реестр знает о том, как создать экземпляр этого класса и его наследников при запросе клиентом вызовов методов интерфейса. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Так как класс TinvokableClass наследник TInterfacedObject, то он умеет освободить память в случае, когда число ссылок на него равно 0, что облегчает программисту жизнь. </td></tr></table></div><p>Текст модуля реализации представлен ниже, комментарии излишни: </p>
<pre>
unit u_Impl;
 
interface
uses InvokeRegistry, u_Intrf;
type
  TEncodeDecode = class(TInvokableClass, IEncodeDecode)
  protected
    function US2RUS(Value: Currency): Currency; stdcall;
    function RUS2US(Value: Currency): Currency; stdcall;
  end;
 
implementation
 
{ TEncodeDecode }
 
function TEncodeDecode.RUS2US(Value: Currency): Currency;
begin
  Result := Value / 30;
end;
 
function TEncodeDecode.US2RUS(Value: Currency): Currency;
begin
  Result := Value * 30;
end;
 
initialization
  InvRegistry.RegisterInvokableClass(TEncodeDecode);
end.
</pre>
<p>В случае, если Вы не хотите наследовать класс от TInvokableClass, необходимо создать и зарегистрировать метод-фабрику класса, который сможет создавать экземпляры Вашего класса. Метод должен быть типа TCreateInstanceProc = procedure(out obj: TObject); При этом экземпляр должен уметь ликвидировать себя, если количество ссылок использующих его клиентов станет нулевым. При регистрации такого класса методу InvRegistry.RegisterInvokableClass вторым параметром необходимо передать имя метода-фабрики класса. </p>
<p>Создание проекта приложения Web Services в Delphi</p>
<p>Остался последний шаг &#8211; создание проекта приложения. В IDE выберем пункт меню File/New/Other и с закладки WebServices значок SOAP Server Application. Будет выведен диалог выбора формата приложения Web Services. Мы выберем CGI формат. При этом будет создан проект с Web модулем, содержащим три компонента: HTTPSoapDispatcher, HTTPSoapPascalInvoker, WSDLHTMLPublish. </p>
<p>THTTPSoapDispatcher получает и обрабатывает SOAP сообщения, перенаправляя их invoke интерфейсам, зарегистрированным в приложении. Таким образом, THTTPSoapDispatcher является диспетчером, ответственным за прием, распределение и отправку SOAP сообщений. <br>
<p>Интрепретация запросов и вызов методов интерфейсов осуществляется другим компонентом, указанным в свойстве Dispatcher (HTTPSoapPascalInvoker1). THTTPSoapDispatcher автоматически регистрирует себя в Web модуле, как автодиспетчера. При этом все запросы передаются THTTPSoapDispatcher, что избавляет Вас от необходимости создавать обработчики запросов Web модуля. </p>
<img src="/pic/clip0077.gif" width="181" height="220" border="0" alt="clip0077"></p>
<p>&nbsp;<br>
&nbsp;<br>
WSDLHTMLPublish1 &#8211; данный компонент генерирует и выдает по запросу клиента описание интерфейса сервера. <br>
Далее в проект необходимо подключить файлы с описанием и реализацией интерфейса. Для этого в IDE выберем пункт меню Project/Add to project и появившемся диалоге выберем модули с описанием и реализацией методов интерфейса. Можно откомпилировать проект и поместить полученный исполняемый файл в директорию для CGI скриптов Web сервера. <br>
<p>Сервер готов к работе. </p>
<p>Разработка клиента Web Services в Delphi6</p>
<p>Условно разработку клиента можно разбить на две части: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Получение описания интерфейса сервера </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Написания кода вызова методов сервера </td></tr></table></div><p>В случае разработки сервера на Delphi существует модуль с описанием интерфейса сервера на языке Object Pascal, т.е первый этап может быть пропущен. В случае если сервер был разработан с использованием других языков или модуль с описанием интерфейса не доступен, необходимо получить описание интерфейса в формате WSDL или XML. <br>
Первый вариант &#8211; это попросить файл с описанием у разработчиков, второй сгенерировать описание самому. <br>
<p>Для этого достаточно запустить Web браузер в строке адреса набрать: http://&lt;имя сервера&gt;/&lt;папка с CGI&gt;/&lt;имя приложения сервера&gt;/wsdl. В нашем примере я, разместил сервер на локальной машине, web сервер Apache, строка адреса в этом случае http://localhost/cgi-bin/Server.exe/wsdl . При этом на экран будет выведена таблица с описанием интерфейсов сервера. </p>
<img src="/pic/clip0078.gif" width="593" height="248" border="0" alt="clip0078"></p>
<p>Необходимо выбрать в таблице интересующий нас интерфейс IEncodeDecode при этом будет сгенерировано описание интерфейса в формате xml. <br>
&lt;?xml version="1.0" ?&gt; <br>
&lt;definitions xmlns="http://schemas.xmlsoap.org/wsdl/" xmlns:xs="http://www.w3.org/2001/XMLSchema"name="IEncodeDecodeservice"targetNamespace="http://www.borland.com/soapServices/" xmlns:tns="http://www.borland.com/soapServices/" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"&gt; <br>
&lt;messagename="US2RUSRequest"&gt; <br>
&lt;part name="Value"type="xs:double" /&gt; <br>
&lt;/message&gt; <br>
&lt;messagename="US2RUSResponse"&gt; <br>
&lt;part name="return"type="xs:double" /&gt; <br>
&lt;/message&gt; <br>
&lt;messagename="RUS2USRequest"&gt; <br>
&lt;part name="Value"type="xs:double" /&gt; <br>
&lt;/message&gt; <br>
&lt;messagename="RUS2USResponse"&gt; <br>
&lt;part name="return"type="xs:double" /&gt; <br>
&lt;/message&gt; <br>
&lt;portTypename="IEncodeDecode"&gt; <br>
&lt;operationname="US2RUS"&gt; <br>
&lt;input message="tns:US2RUSRequest" /&gt; <br>
&lt;output message="tns:US2RUSResponse" /&gt; <br>
&lt;/operation&gt; <br>
&lt;operationname="RUS2US"&gt; <br>
&lt;input message="tns:RUS2USRequest" /&gt; <br>
&lt;output message="tns:RUS2USResponse" /&gt; <br>
&lt;/operation&gt; <br>
&lt;/portType&gt; <br>
&lt;bindingname="IEncodeDecodebinding"type="tns:IEncodeDecode"&gt; <br>
&lt;soap:binding style="rpc"transport="http://schemas.xmlsoap.org/soap/http" /&gt; <br>
&lt;operationname="US2RUS"&gt; <br>
&lt;soap:operation soapAction="urn:u_Intrf-IEncodeDecode#US2RUS" /&gt; <br>
&lt;input&gt; <br>
&lt;soap:body use="encoded"encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"namespace="urn:u_Intrf-IEncodeDecode" /&gt; <br>
&lt;/input&gt; <br>
&lt;output&gt; <br>
&lt;soap:body use="encoded"encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"namespace="urn:u_Intrf-IEncodeDecode" /&gt; <br>
&lt;/output&gt; <br>
&lt;/operation&gt; <br>
&lt;operationname="RUS2US"&gt; <br>
&lt;soap:operation soapAction="urn:u_Intrf-IEncodeDecode#RUS2US" /&gt; <br>
&lt;input&gt; <br>
&lt;soap:body use="encoded"encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"namespace="urn:u_Intrf-IEncodeDecode" /&gt; <br>
&lt;/input&gt; <br>
&lt;output&gt; <br>
&lt;soap:body use="encoded"encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"namespace="urn:u_Intrf-IEncodeDecode" /&gt; <br>
&lt;/output&gt; <br>
&lt;/operation&gt; <br>
&lt;/binding&gt; <br>
&lt;servicename="IEncodeDecodeservice"&gt; <br>
&lt;portname="IEncodeDecodePort"binding="tns:IEncodeDecodebinding"&gt; <br>
&lt;soap:address location="http://localhost/cgi-bin/Server.exe/soap/IEncodeDecode" /&gt; <br>
&lt;/port&gt; <br>
&lt;/service&gt; <br>
&lt;/definitions&gt; <br>
&nbsp;<br>
<p>Сохраните его в файл Client.xml. Итак, тем или иным способом файл с описанием в формате xml оказался у нас в руках, теперь необходимо экспортировать его в Delphi. При экспорте будет сгенерирован модуль Delphi с описанием интерфейса на языке Object Pascal. Выберем пункт меню File/New/Other, перейдем на закладку WebServices и выберем иконку Web Services Importer. При этом на экране появится диалог импорта описания. </p>
<img src="/pic/clip0079.gif" width="419" height="337" border="0" alt="clip0079"></p>
<p>Используя кнопку Browse диалога, укажем полученный ранее файл Client.xml, и нажмем кнопку Generate. Опа и модуль Delphi с описанием интерфейса готов. Переходим ко второму этапу &#8211; непосредственному созданию клиента. Создадим заготовку нового приложения &#8211; File/New/Application. На главной форме разместим строку ввода, две кнопки и компонент HTTPRIO с закладки WebServices. </p>
<img src="/pic/clip0080.gif" width="226" height="134" border="0" alt="clip0080"></p>
<p>Компонент HTTPRIO предназначен для вызова серверов через SOAP. Укажем в свойстве URL значение http://localhost/cgi-bin/Server.exe/soap/IEncodeDecode, т.е путь к серверу. <br>
<p>Далее включим в проект модуль Delphi с описанием интерфейса сервера и укажем его в секции uses главной формы проекта. Теперь можно переходить к написанию кода вызова методов сервера. Обработчик события нажатия на кнопку с заголовком руб-&gt;$ будет выглядеть так: </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  X:IEncodeDecode;
  R:Currency;
begin
  X:=HTTPRIO1 as IEncodeDecode;
  R:=X.RUS2US(StrToCurr(Edit1.Text));
  ShowMessage(CurrToStr(R)+'$');
end;
</pre>

<p>По аналогии код нажатия на кнопку с заголовком $-&gt;руб:</p>
<pre>
procedure TForm1.Button2Click(Sender: TObject);
var
  X:IEncodeDecode;
  R:Currency;
begin
  X:=HTTPRIO1 as IEncodeDecode;
  R:=X.US2RUS(StrToCurr(Edit1.Text));
  ShowMessage(CurrToStr(R)+'руб.');
end;
</pre>
<p>Осталось запустить проект на выполнение и убедиться в его работоспособности. В данной статье мы рассмотрели лишь самый простой пример. Надеюсь, она станет для Вас хорошим стартом в освоении новых Web технологий. </p>

<div class="author">Автор: Mike Goblin </div>
<p><a href="https://www.delphimaster.ru" target="_blank">https://www.delphimaster.ru</a></p>
