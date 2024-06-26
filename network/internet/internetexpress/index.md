---
Title: Обзор компонентов InternetExpress
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Обзор компонентов InternetExpress
=================================

**Аннотация**

Среди новых возможностей Delphi5 одной из наиболее заметных является
технология InternetExpress - средство публикации и обработки данных в
Internet на основе технологии MIDAS. InternetExpress представляет собой
набор компонентов, позволяющих реализовать полный цикл клиент-серверной
обработки данных на базе Internet с использованием как уже имевшихся в
распоряжении разработчиков на Delphi средств (создание
Internet-приложений на основе ISAPI/NSAPI, ASP и CGI), так и новых
средств, например стандарта XML (eXtended Markup Language - дальнейшего
развития стандарта HTML, позволяющего реализовать объектный подход к
созданию Internet-контента и структурированную передачу и обработку
данных через Internet).

В данной публикации производится обзор технологии InternetExpress, а
также приводится пример простейшего решения обработки данных с
использованием Internet.

**Краткое описание технологии InternetExpress**

До недавнего времени решения на основе MIDAS можно было задействовать в
Internet, создав MIDAS-клиент на Java и используя в качестве транспорта
данных протокол IIOP. В Delphi 5 появилась возможность для передачи
данных пакеты XML (XML data packets), что автоматически сделало пакеты
данных MIDAS частью открытого стандарта

В InternetExpress используются средства поддержки XML из MIDAS 3.
Поскольку в настоящее время даже лидеры среди Internet-броузеров
(Netscape Navigator и Microsoft Internet Explorer) не поддерживают (или
поддерживают частично) представление данных по стандарту XML, в
InternetExpress реализована специальная технология поддержки XML на
основе JavaScript и DHTML, позволяющая использовать InternetExpress даже
с теми броузерами, которые вообще не имеют поддержки XML. В частности,
для экспериментов с InternetExpress были использованы Netscape Navigator
4.61 и Internet Explorer 4.01, для которых поддержка XML не была
реализована. В IE 5.0 уже встроена поддержка XML, поэтому большинство
решений на основе этого стандарта требуют для работы наличия этого
броузера, что, конечно, далеко не всегда желательно и (или) возможно.

Кстати, если приложение InternetExpress работает с IE 5, то порождаемый
XML-пакет будет специальным образом оптимизироваться.

В броузерах, не имеющих встроенной поддержки XML, пакеты данных в этом
формате разбираются с использованием специального модуля JavaScript
(xmldom.js), который реализует спецификацию DOM (Document Object Model),
позволяющую создавать HTML-клиенты для обработки данных на базе обычных
web-серверов. Серверные приложения разрабатываются с использованием
таких спецификаций взаимодействия с web-сервером, как ISAPI/NSAPI, CGI и
ASP, которые позволяют канализировать запросы к данным и сами данные
между клиентами и сервером приложений MIDAS

**Компоненты InternetExpress**

С точки зрения VCL (Visual Components Library, библиотеки визуальных
компонент) InternetExpress представляет собой две компоненты базового
набора: TXMLBroker и TMIDASPageProducer. TXMLBroker отвечает собственно
за формирование XML-пакета, реакцию на изменения в данных и оповещение о
действиях, выполняемых клиентом. TMIDASPageProducer отвечает за
формирование сборного DHTML-документа, который, собственно, и является
клиентским приложением, поскольку содержит все те визуальные элементы,
которые соответствуют структуре пакета данных XML. В этот документ
передаются XML-пакеты, формируемые компонентом XMLBroker. В тот момент,
когда от клиентского приложения приходит сообщение о необходимости
передать изменения в данных на сервер приложений, TMIDASPageProducer
осуществляет опрос каждого из элементов управления HTML, формирует пакет
с данными, подлежащими обновлению и передает их серверу приложений.
Таким образом, обработка данных на клиенте происходит с использованием
средств HTML, а передача структурированных данных к клиенту и изменений
от него - при помощи пакетов данных XML.

Эти компоненты помещаются в web-модуль (WebModule) серверного
приложения, для создания которого может быть использован специальный
мастер (File-\>New-\>Web Server Application).

WebModule является наследником TDataModule и обладает некоторыми
дополнительными возможностями по сравнению с базовым классом, которые
позволяют обмениваться данными с Web-клиентами. В дополнение к базовому
набору InternetExpress имеется несколько компонентов, например
TReconcilePageProducer, которые устанавливаются из дополнительных
пакетов (packages), входящих в поставку Delphi, и, конечно, существует
возможность наследования базовых классов и создания на их основе
собственных компонентов с расширенными возможностями.

Помимо визуальных компонентов InternetExpress состоит из ряда классов и
интерфейсов, которые будут рассмотрены в разделе "Обзор компонентов
InternetExpress".

**Пакеты данных XML**

Пакеты данных XML используются InternetExpress как транспортные
контейнеры для передачи данных от серверной части приложения к
клиентской и обратно. В качестве примера можно привести пакет данных,
сформированный демонстрационным приложением, описываемым далее в этом
обзоре:

    <DATAPACKET Version="2.0">
    <METADATA>
    <FIELDS>
    <FIELD fieldname="Species No" attrname="Species_No" fieldtype="r8"/>
    <FIELD attrname="Category" fieldtype="string" WIDTH="15"/>
    <FIELD attrname="Common_Name" fieldtype="string" WIDTH="30"/>
    <FIELD fieldname="Species Name" attrname="Species_Name" fieldtype="string" WIDTH="40"/>
    <FIELD fieldname="Length (cm)" attrname="Length__cm_" fieldtype="r8"/>
    <FIELD attrname="Length_In" fieldtype="r8"/>
    <FIELD attrname="Notes" fieldtype="bin.hex" WIDTH="50" SUBTYPE="Text"/>
    <FIELD attrname="Graphic" fieldtype="bin.hex" SUBTYPE="Graphics"/>
    </FIELDS>
    <PARAMS DEFAULT_ORDER="1" PRIMARY_KEY="1" LCID="1033"/>
    </METADATA>
    <ROWDATA>
    <ROW Species_No="90020" Category="Triggerfish" Common_Name="Clown Triggerfish"
        Species_Name="Ballistoides conspicillum" Length__cm_="50"
        Length_In="19.68503937007874"
    Notes="Also known as the big spotted triggerfish.
    Inhabits outer reef areas and feeds upon crustaceans and mollusks by crushing
    them with powerful teeth. They are voracious eaters, and divers report
    seeing the clown triggerfish devour beds of pearl oysters.&#010;&#010;Do not
    eat this fish. According to an 1878 account, &quot;the poisonous flesh acts
    primarily upon the nervous tissue of the stomach, occasioning violent
    spasms of that organ, and shortly afterwards all the muscles of the body. The
    frame becomes rocked with spasms, the tongue thickened, the eye fixed, the
    breathing laborious, and the patient expires in a paroxysm of extreme suffering.
    &quot;&#010;&#010;Not edible.&#010;&#010;Range is Indo-Pacific
    and East Africa to Somoa.&#010;"/>
    <ROW Species_No="90030" Category="Snapper" Common_Name="Red Emperor"
          Species_Name="Lutjanus sebae" Length__cm_="60"
          Length_In="23.62204724409449"
          Notes="Called seaperch in Australia. Inhabits the areas around lagoon
    coral reefs and sandy bottoms.&#010;&#010;The red emperor is a valuable food
    fish and considered a great sporting fish that fights with fury when
    hooked.
    The flesh of an old fish is just as tender to eat as that of the very young.
    &#010;&#010;Range is from the Indo-Pacific to East Africa.&#010;"/>
    </ROWDATA>
    </DATAPACKET> 

**Структура пакета данных XML**

Как видно из приведенного выше фрагмента, пакет данных XML содержит
необходимое описание структуры данных (секция ), а также собственно
данные, разбитые на строки (), которые, в свою очередь, содержат ссылки
на имена столбцов и собственно данные для каждой из ячеек таблицы данных
(или ее части), которую, собственно, и представляет собой пакет данных
XML.

В том случае, если пакет представляет собой разностный пакет данных XML
(XML delta packet), в строку PARAMS метаданных добавляется фрагмент вида
`DATASET_DELTA="1"`, то есть строка PARAMS будет выглядеть следующим
образом:

    <METADATA>
    <FIELDS>
    ...
    </FIELDS>
    <PARAMS DEFAULT_ORDER="1" PRIMARY_KEY="1" LCID="1033" DATASET_DELTA="1"/>
    </METADATA>
    <ROWDATA>
    ...
    </ROWDATA>
    </DATAPACKET> 

**Структура разностного пакета данных XML**

Серверная часть Internet-приложения на основе InternetExpress.

Серверная часть такого приложения состоит из исполняемого модуля,
написанного в данном случае на Delphi 5, и включающего WebModule,
упомянутый выше, а также файлов-библиотек JavaScript, которые в случае
отсутствия поддержки XML броузером передаются на сторону клиента.

Библиотеки JavaScript, входящие в состав серверной части
приложения InternetExpress:

- xmldom.js XML-парсер, соответствующий стандарту DOM, написанный на
JavaScript. Позволяет броузерам использовать пакеты данных XML не имея
встроенной поддержки этого стандарта. Для IE5 этот файл не передается, а
XML-пакет специальными образом оптимизируется.

- xmldb.js Библиотека классов доступа к данным, обслуживающая пакеты
данных XML.

- xmldisp.js Библиотека описания связей между классами доступа к данным в
xmldb.js и элементами HTML.

- xmlerrdisp.js Библиотека классов для обработки конфликтных ситуаций при
внесении изменений в данные. Использует пакет разности данных (XML delta
packet) и пакет ошибок (XML error packet).

- xmlshow.js Библиотека функций для отображения окон с данными XML.


**Примечание:**

Для того, чтобы серверная часть приложения InternetExpress корректно
обслуживала клиентов без поддержки XML, эти библиотеки (по умолчанию)
должны быть размещены в том же каталоге, что и исполняемый модуль
серверной части приложения, или же для каждого из компонентов типа
TMIDASPageProducer и его наследников свойство IncludePathURL должно
указывать место расположения этих файлов (в относительном или полном
формате), например /iexpress/, как в демонстрационном примере к данной
статье.

Для того, чтобы вышеперечисленные библиотеки были переданы клиентской
стороне и задействованы там, достаточно просто включить соответствующие
ссылки на них в HTML-документ:

    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="xmldom.js"></SCRIPT>
    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="xmldb.js"></SCRIPT>
    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="xmldisp.js"></SCRIPT>
    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="xmlshow.js"></SCRIPT>
    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" SRC="xmlerrdisp.js"></SCRIPT> 

**Примечание:**

ссылка на xmldom.js требуется только в том случае, если броузер не имеет
встроенной поддержки XML.

**Клиентская часть приложения InternetExpress**

Клиентская часть приложения на основе InternetExpress представляет собой
собственно HTML-документ, порожденный одним или более компонентами типа
(или его наследниками) TMIDASPageProducer, исполняемый
(интерпретируемый) тем или иным броузером. Как уже было сказано выше,
этот документ может содержать элементы отображения и управления,
соответствующие структуре пакета данных XML. К ним также могут
добавляться элементы управления, формирующие HTML-аналог DBnavigator из
состава Delphi VCL в том случае, если соответствующие параметры были
заданы при настройке PageProducer, а также другие элементы управления
HTML, как связанные с обработкой данных, так и составляющие независимые
части интерфейса, например группу для ввода имени пользователя и пароля
с целью авторизации доступа к данным системы.

**Схема работы приложения InternetExpress**

В целом, схема работы приложения на основе InternetExpress выглядит
следующим образом:

Броузер обращается по ссылке (URL) к серверному приложению
InternetExpress, которое возвращает HTML-документ, являющийся, как
правило, некой отправной точкой в алгоритме обработки данных.

По запросу пользователя серверное приложение сначала возвращает
очередной HTML-документ, содержащий (при необходимости) ссылки на
библиотеки JavaScript, отвечающие за обработку XML-пакетов, а затем уже
этот документ посылает запрос серверной части приложения, которая затем
посылает клиенту данные в виде пакетов XML, интерпретируемых
соответствующими библиотеками JavaScrip.

После того, как пользователь просмотрел набор данных и, при
необходимости, внес в них изменения, он имеет возможность передать
изменения серверной части приложения. Это процесс запускается событием,
которое, как правило, связано с "кнопкой" "Apply Updates" (Внести
изменения) и передается серверной части приложения InternetExpress, а
именно - компоненту TMIDASPageProducer. Все изменения в данных
передаются серверной части приложения в виде разностных пакетов XML (XML
delta packets).

Серверная часть получает информацию об изменениях в данных и использует
сервер приложений для внесения этих изменений в базу данных. При
возникновении конфликта (reconcile error) имеется возможность
сформировать HTML-вариант Reconcile Dialog из состава Delphi или
разрешить конфликтную ситуацию автоматически, включив компонент
TReconcilePageProducer в состав серверной части приложения

**Обзор компонентов InternetExpress**

Компонент **TMIDASPageProducer**

Данный компонент отвечает за сборку HTML-документа, отображающего
"живой" набор данных, получаемый от сервера приложений, или же
"типового" HTML-документа, не осуществляющего обработку данных вообще.
Компонент может быть использован для создания Web-приложений на основе
MIDAS, которые будут отображать информацию, содержащуюся в базе данных,
получая ее через сервер приложений, и передавать ее HTML-клиентам в
пакетах данных XML. Реализация компонента находится в модуле (unit)
dsprod.

При создании Web-модуля ссылка на один из таких компонентов (свойство
Producer) должна быть выставлена у соответствующих элементов
TWebActionItem.

TMIDASPageProducer создает HTML-документ на основе шаблона. В отличие от
других компонентов типа Producer, этот компонент имеет шаблон "по
умолчанию" (default), в котором содержатся несколько описаний верхнего
уровня, на основе которых в других компонентах порождаются
HTML-документы. Помимо шаблонов содержание конечного документа может
быть сгенерировано на основе данных, порождаемых другими компонентами,
добавленными в Web-модуль, получено от другого компонента
TMIDASPageProducer через свойство TMIDASPageProducer.Content и так далее

**Примечание:**

Связывание HTML-элементов с пакетами данных XML и обработчиками событий
HTTP в TMIDASPageProducer осуществляется исключительно по именам
HTML-объектов и соответствующих событий, за счет чего становится
возможным редактировать сгенерированный HTML-шаблон любым из средств
работы с HTML-документами, придавая ему необходимый внешний вид и
дополняя логику обработки данных вставками JavaScript, поскольку даже
при изменении свойств объектов, порожденных встроенным редактором
TMIDASPageProducer, внесенные другими средствами изменения потеряны не
будут. В демонстрационном приложении, описываемом ниже в шаблон
HTML-документа был изменен с целью добавить заголовок страницы с
данными.

Расширение функциональности обработчика шаблонов (свойство
TMIDASPageProducer.HTMLdoc) возможно за счет реализации обработчика
события TMIDASPageProducer.OnHTMLtag или перекрытия метода
TMIDASPageProducer.DoTagEvent. Реализовав свою собственную версию
обработчика этого события вы получаете возможность использовать в теле
шаблона документа собственные тэги, заменяя их на этапе генерации
HTML-документа соответствующими значениями. Пример такого подхода
показан в демонстрационном приложении InetXCenter из состава Delphi 5
(модуль InetXCenterProd.pas).

И конечно, возможности InternetExpress можно практически неограниченно
расширять, реализуя специальные компоненты-наследники от
TMIDASPageProducer и компонентов, используемых для формирования
содержимого документа (TDataForm, TQueryForm и так далее). Создавая на
их основе специализированные компоненты, вы получаете возможность
максимально упростить создание конечного решения на основе
InternetExpress за счет реализации специфических возможностей,
необходимых вашему Internet-приложению. Например, в демонстрационном
приложении InetXCenter за счет создания наследника от компонента
TMIDASPageProducer реализованы такие возможности, как генерация таких
полей заголовка HTML-документа, как, задание комментариев и описаний,
автоматически подставляемых в конечный HTML-документ и другие расширения
базового компонента.

Описание компонента **TMIDASPageProducer**

Поскольку TMIDASPageProducer (TCustomMIDASPageProducer) является
собственно генератором содержания HTML-документа, в его описание входит
интерфейс IWebContent, который, собственно, это содержание и
предоставляет. Заголовок соответствующего класса выглядит следующим
образом:

    TCustomMIDASPageProducer = class(TPageItemProducer, IWebContent,
        IWebComponentEditor, IScriptEditor)

Помимо IWebContent в описании класса участвуют еще два интерфейса:
IWebComponentEditor и IScriptEditor, которые, соответственно, являются
средствами связи с design-time редактором для компонентов типа
TWebComponent и HTML-кода.

Назначение свойств:

- HTMLDoc - Собственно базовый шаблон, содержащий включения (includes)
описателей содержания

- HTMLFile - Аналогично HTMLDoc, но с привязкой к файлу

- IncludePathURL - Путь к библиотекам JavaScript (в формате URL). Может быть
как полный (http://someserver/iexpress/), т.е. с указанием имени сервера
и так далее, так и относительный (/iexpress/).

- Styles - Описание стилей "по умолчанию" для генерации HTML-документа.
Это свойство является аналогом файла стилей, используемого для создания
канонических Web-страниц

- StylesFile - Аналогично Styles, но с привязкой к файлу стилей

WebPageItems Список специальных компонентов, определяющих ключевые
элементы документа. Основные типы PageItem включают: DataForm, QueryForm
и LayoutGroup. Каждый из базовых компонентов TWebPageItem может иметь
вложенные компоненты. Например, для DataForm могут иметься DataGrid,
DataNavigator и так далее

Ключевые свойства компонента **TMIDASPageProducer**

Комбинация компонентов TDataForm, TQueryForm и так далее, определяет
структуру и основные параметры отображения HTML-документа, стили же
(цвета, шрифты и так далее) определяются свойствами Styles и HTMLDoc.

Другие свойства компонента подробно описаны в документации и файле
Справки Delphi.

Следует отметить, что за счет использования для определения состава
элементов HTML-документа стандартных компонентов, поставляемых в
исходных текстах, становится возможным практически неограниченное
расширение функциональных возможностей InternetExpress путем создания
специализированных наборов компонент для построения Internet-приложений.
Примеры подобного подхода можно найти в демонстрационном приложении
InetXCenter из поставки Delphi 5.

Компонент **TWebActionItem**

TWebActionItem представляет собой невизуальный компонент, позволяющий
задавать реакцию Internet-приложения на те или иные события,
транслируемые протоколом HTTP от web-клиента. Предоставляя специальные
свойства для задания ссылок на компоненты TMIDASPageProducer и
TPageProducer, а также пути URL, TWebActionItem дает возможность
задавать алгоритм перемещения между HTML-документами, составляющими
Internet-приложение, реагировать на передачу параметров и значений полей
HTML-документа специфическим образом и так далее. Реализуя обработчик
события TWebActionItem.OnAction, программист получает возможность
возвращать необходимые данные в полях запросов, устанавливать
идентификационные маркеры (Cookies) для Web-клиентов, контролировать
генерацию содержания HTML-документов и выполнять ряд других операций
практически на самом нижнем уровне функционирования Internet-приложения

Свойства:

- Default Означает использование этого компонента как обработчика событий
соответствующих типов (свойство MethodType) в тех случаях, когда иной
обработчик явно не задан.Из всех компонентов TWebActionItem,
присутствующих в контейнере TWebModule, только один может иметь свойство
Default равным True

- DisplayName Служит для задания отображения компонента в списке
компонента TCustomWebDispatcher. Должно быть уникальным для своего
контекста.

- Enabled Аналогично многим другим компонентам означает разрешение или
запрет на выполнение связанных с компонентом действий. В случае
установки в False содержимое HTML-документа соответствующим компонентом
типа PageProducer генерироваться не будет

- MethodType Определяет метод HTTP, при вызове которого со стороны
web-клиента будет задействован данный компонент. По умолчанию имеет
значение mtAny, то есть все доступные методы, но может принимать
значения отдельных типов, например mtGet (запрос на получение
web-клиентом содержимого документа).

- PathInfo В формате URI (Unified Resource Identifier) задает путь к
получателю всех сообщений, принимаемых TWebActionItem. Позволяет
перенаправить очередь сообщений другому компоненту PageProducer или
HTML-документу.

- Producer Ссылка на компонент PageProducer. В случае, если компонент явно
не задан, обработчик OnAction должен быть реализован в обязательном
порядке для осуществления реакции на сообщение. Если ссылка на
PageProducer актуальна (не nil), сообщение обрабатывается или
PageProducer, или реализацией OnAction в случае ее наличия

Ключевые свойства компонента **TWebActionItem**

Примеры использования свойств TWebActionItem можно найти в
демонстрационном приложении InetXCenter (модуль InextXCenterModule.pas).

Невизуальные компоненты категории PageItems (элементы HTML-документа)

Компоненты PageItems предназначены для формирования структуры
HTML-документа. Точно так же, как и компоненты VCL, они подразделяются
на средства отображения типовых элементов HTML-документа и элементов для
обработки данных, получаемых от сервера приложений. Для каждого из этих
компонентов могут быть созданы наследники, расширяющие их свойства или
реализующие те элементы HTML, эквивалента которым нет в текущей
реализации InternetExpress. Реализация компонентов PageItems находится в
модуле MidItems. При построении HTML-документа компоненты PageItems
объединяются в иерархические структуры. Например, компонент
TDataNavigator содержит компоненты типа TDataSetButton

На этапе генерации содержания HTML-документа компонентом
TMIDASPageProducer эти компоненты генерируют фрагменты HTML-кода,
описывающего эквивалентные HTML-элементы. Эти фрагменты собираются
TMIDASPageProducer в единый поток и подставляются вместо соответствующих
тэгов в шаблоне документа. К элементам HTML привязываются обработчики на
JavaScript, которые составляют аналог обработчиков событий для
визуальных компонентов Delphi, таких, как OnClick и тому подобных.
Отдельные компоненты PageItems позволяют напрямую задать мишень (target)
для передачи сообщений (свойство Action) в формате URI, что позволяет
осуществлять переход от одного HTML-документа к другому передачу
параметров в формате протокола HTTP между этими документами.

За счет использования в TMIDASPageProducer шаблонов для генерации
HTML-документов появляется возможность добавлять отдельные визуальные и
невизуальные элементы HTML-документа прямым редактированием. Однако
используя обработчики событий HTTP можно связывать такие элементы с
генерируемыми по шаблону через компоненты TWebActionItem или при помощи
создаваемых опять-таки прямым редактированием обработчиков на JavaScript
внутри HTML-документа.

Компонент **TXMLBroker**

Этот компонент осуществляет передачу пакетов данных в формате XML от
сервера приложений HTML-клиенту, получение изменений в данных от
HTML-клиента, расшифровку разностных пакетов данных XML и передачу
информации об изменениях в данных на сервер приложений. Реализация
компонента находится в модуле xmlbrokr.

Компонент TXMLBroker может быть использован в приложении, которое
одновременно является и MIDAS-клиентом, и серверным Web-приложением.
Серверы такого класса как правило имеют две основные функции:

- получать пакеты XML-данных от сервера приложений через интерфейс
IAppServer.

- oбрабатывать сообщения HTTP от броузеров, содержащие пакеты XML-данных с
изменениями относительно исходного набора и передавать их серверу
приложений.

Для того, чтобы сделать информацию, содержащуюся в базе данных,
доступной в формате XML, достаточно добавить компонент TXMLBroker в
контейнер WebModule совместно с компонентом TMIDASPageProducer, который
будет использовать XML-пакеты данных для создания HTML-страниц.

TXMLBroker автоматически регистрирует себя в Web-модуле (или
Web-диспетчере) как автодиспетчеризуемый объект (auto-dispatching
object). Это означает, что Web-модуль или Web-диспетчер будут
перенаправлять все входящие HTTP-сообщения непосредственно этому. Все
входящие сообщения считаются данными для обновления, порождаемыми
броузером в ответ на получение HTML-потока, порождаемого компонентом
TApplyUpdatesButton. TXMLBroker автоматически передает пакет с
XML-данным, содержащий различия в данных, на сервер приложений и
возвращает все ошибки, возникшие при обновлении данных тому компоненту
управления содержимым (TMIDASPageProducer) документа, который имеет
возможность генерации соответствующего ответного сообщения

Свойство     | Назначение
-------------|----------
AppServer    |Интерфейс IAppServer, служащий для связи с провайдерами (providers) данных
MaxErrors    |Максимальное число ошибок, по достижении которого соответствующий провайдер должен прекратить операцию обновления данных.
MaxRecords   |Управляет формированием пакетов данных XML.<br>Значение -1 позволяет компоненту передать все записи из набора данных в XML-пакет;<br>Значение 0 позволяет передачу только метаданных;<br>Значение больше нуля собственно определяет число записей (строк), которые могут быть переданы в XML-пакет.
Params       |Список параметров, передаваемых серверу приложений. Используется, в частности, для передачи параметров хранимых процедур и SQL-запросов.
ProviderName |Имя провайдера данных
ReconcileProducer |Ссылка на компонент TReconcilePageProducer, который будет использоваться при разрешении конфликтов данных во время операций обновления.
WebDispatch  |Перечисляет типы сообщений протокола HTTP, на которые будет реагировать компонент. Как правило, эти сообщения порождаются при нажатии кнопки типа TApplyUpdatesButton на HTML-странице.

Ключевые свойства компонента **TXMLBroker**

**Построение Web-приложения на основе InternetExpress**

Для создания Web-приложения необходимо наличие скомпилированного и
зарегистрированного приложения-сервера данных. В данном примере
используются данные из таблицы biolife.db, входящей в состав
демонстрационной базы данных из комплекта Delphi 5. Данные публикуются
через контейнер Remote Data Module.

**Remote Data Module демонстрационного сервера данных**

После создания и регистрации сервера данных необходимо создать клиента
для этого сервера, который, в свою очередь, будет являться сервером для
HTML-клиента, являющегося третьим звеном в нашей системе. Delphi 5
предоставляет специальный мастер для создания приложений-расширений
Web-сервера. Он может быть вызван через меню File-\>New-\>Web Server
Application и имеет следующий вид:

**Мастер создания серверных Web-приложений.**

В данном случае мы создаем CGI-приложение, выводящее порождаемый поток
данных в устройство стандартного вывода (stdout). Поток данных этого
приложения будет без изменений передан вызывающему документу через
транспортный протокол.

Мастер автоматически создаст контейнер типа TWebModule, в который
необходимо поместить компоненты TMIDASPageProducer и TXMLBroker. Сюда же
мы поместим и компонент TDCOMConnection, который будем использовать для
подключения с удаленным сервером данных, а также компонент
TClientDataSet для доступа к удаленному модулю данных.

Контейнер WebModule с размещенными в нем компонентами TXMLBroker и
TMIDASPageProducer.

Определив необходимые для соединения с удаленным сервером свойства,
переходим к созданию содержимого HTML-документа. Для этого необходимо
назначить для TXMLBroker свойства RemoteServer и ProviderName, а также
создать хотя бы один компонент TWebActionItem, вызвав соответствующий
редактор по правой кнопке мыши на компоненте TXMLBroker и
TMIDASPageProducer.

**Всплывающее меню и ActionEditor**

Далее необходимо вызвать редактор Web-страниц, для чего необходимо
выбрать пункт всплывающего меню компонента TMIDASPageProducer-\>Web Page
Editor.

**Примечание:**

для работы этого элемента необходимо наличие установленного Microsoft
Internet Explorer 4.0 и выше.

После добавления необходимых элементов мы получаем готовое к применению
приложение Web-сервера. При установке параметров отображения
HTML-документа можно воспользоваться свойствами компонента DataGrid и
других элементов HTML-документа для придания ему необходимого внешнего
вида, а также вручную доработать HTML-код в соответствующем встроенном
редакторе.

Встроенное средство просмотра HTML. Красным выделены автоматически
сгенерированные ссылки на библиотеки JavaScript.

После компиляции исполняемый модуль (в нашем примере - XMLServerApp.exe)
необходимо поместить в каталог Web-сервера, для которого выделены права
на запуск приложений. В этот же каталог необходимо поместить
перечисленные в разделе "Серверная часть Internet-приложения на основе
InternetExpress" библиотеки JavaScript. Для проверки правильности
размещения библиотек можно воспользоваться специальным HTML-файлом
scripttest.html, который находится в каталоге
Demos\\Midas\\InternetExpress\\TroubleShoot на компакт-диске Delphi 5
или в каталоге установки на жестком диске рабочей станции. Этот
HTML-файл проверяет правильность размещения библиотек и настройки
Web-сервера и в случае наличия тех или иных ошибок выдает некоторые
рекомендации по разрешению проблем.

После того, как настройка закончена, можно обратиться к нашему
приложению напрямую через протокол HTTP, поскольку оно порождает
полноценный HTML-документ, не требующий дополнительной "обвязки".

Окно броузера Netscape Navigator со страницей, порожденной
демонстрационным приложением InternetExpress.

**Несколько советов**

Демонстрационное приложение для данного обзора тестировалось под
управлением серверов Apache 1.3.6 для платформы Win32 и Microsoft
Personal Web Server. Сервер Apache после установки был сконфигурирован
следующим образом:

В корневом каталоге документов был создан подкаталог iexpress
(F:\\inetpub\\iexpress), в который были помещены файлы, необходимые для
работы приложения InternetExpress (библиотеки JavaScript, файл
err.html).

В файл mime.types (перечень mime-типов) была внесены исправления,
определяющие библиотеки JavaScript для передачи на клиентское место, а
для исполнения на сервере вводящие новое расширение:

    text/javascript js
    application/x-javascript jss

Свойству компонента TMIDASPageProducer.IncludePathURL было присвоено
значение "/iexpress/" с целью указать местонахождение библиотек
JavaScript, поскольку по умолчанию TMIDASPageProducer по умолчанию
предполагает размещение этих файлов в том же каталоге, что и исполняемый
(.exe) модуль, однако в случае использования Apache содержимое каталога
/cgi-bin/ по умолчанию считается исполняемым на стороне сервера и
требуется дополнительная настройка с целью определить модули с
расширением .js и .html как неисполняемые.

Настройка MS Personal Web Server заключалась в определении
дополнительного каталога для серверных приложений (того же что и для
Apache) и задания для него соответствующих прав доступа (Read и
Execute).

Как показало тестирование, при отладке приложений InternetExpress
удобнее пользоваться броузером Netscape Navigator (использовались версии
4.61 и 4.7), поскольку в случае возникновения ошибок он дает более
полную диагностическую информацию нежели MSIE, старающийся "защитить"
пользователя от различных "загадочных" сообщений. К тому же Netscape
корректно обрабатывает обращения к localhost в отсутствие соединения с
Internet.

Для отладки приложений InternetExpress также удобнее создавать их в
CGI-варианте, поскольку IIS, Personal Web Server и Apache не блокируют
по записи CGI-приложения в отличие от ISAPI/ASP, которые захватываются
кэш-системой этих серверов и для освобождения (например для перезаписи
новой версией) exe-файла требуется остановка и повторный запуск
web-сервера. В то же время преобразование CGI-приложение в ISAPI или ASP
выполняется простой заменой включения (uses) модуля CGIApp на ISAPIApp в
исходном тексте проекта.

Приводимое здесь демонстрационное приложение отнюдь не претендует на
полноту и законченность. Для более полного ознакомления с возможностями
InternetExpress рекомендуется обратиться к демонстрационным примерам из
поставки Delphi 5 Enterprise, находящиеся в каталоге
Runimage\\Delphi50\\Demos\\Midas\\InternetExpress на компакт-диске или в
D:\\Delphi5\\Demos\\Midas\\InternetExpress (или ином, в зависимости от
пути установки Delphi) на жестком диске. Внимательно прочитайте
сопроводительные файлы к этим примерам, поскольку некоторые из них
требуют специфических настроек Delphi и (или) Web-сервера.

