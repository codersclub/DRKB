<h1>Механизм вызова удаленных процедур &ndash; RPC</h1>
<div class="date">01.01.2007</div>


<p>Механизм вызова удаленных процедур - RPC</p>
<p>Программы, общающиеся через сеть, нуждаются в механизме связи. На нижнем уровне по поступлении пакетов подается сигнал, обрабатываемый сетевой программой обработки сигналов. На верхнем уровне работает механизм rendezvous (рандеву), принятый в языке Ада. В NFS используется механизм вызова удаленных процедур (RPC), в котором клиент взаимодействует с сервером (см. Рисунок 1). В соответствии с этим процессом клиент сначала обращается к процедуре, посылающей запрос на сервер. По прибытии пакета с запросом сервер вызывает процедуру его вскрытия, выполняет запрашиваемую услугу, посылает ответ, и управление возвращается клиенту.</p>
<p>Интерфейс RPC можно представить состоящим из трех уровней:</p>
<p>- Верхний уровень полностью "прозрачен". Программа этого уровня может, например, содержать обращение к процедуре rnusers(), возвращающей число пользователей на удаленной машине. Вам не нужно знать об использовании механизма RPC, поскольку вы делаете обращение в программе.</p>
<p>- Средний уровень предназначен для наиболее общих приложений. RPC-вызовами на этом уровне занимаются подпрограммы registerrpc() и callrpc(): registerrpc() получает общесис темный код, а callrpc() исполняет вызов удаленной процедуры. Вызов rnusers() реализуется с помощью этих двух подпрограмм.</p>
<p>- Нижний уровень используется для более сложных задач, изменяющих умолчания на значения параметров процедур. На этом уровне вы можете явно манипулировать гнездами, используемыми для передачи RPC-сообщений.</p>
<p>Как правило, вам следует пользоваться верхним уровнем и избегать использования нижних уровней без особой необходимости.</p>
<p>Несмотря на то, что в данном руководстве мы рассматриваем интерфейс только на Си, обращение к удаленным процедурам может быть сделано из любого языка. Работа механизма RPC для организации взаимодействия между процессами на разных машинах не отличается от его работы на одной машине.</p>
<p>RPC (Remote Procedure Call, Сервис вызова удаленных процедур) представляет собой интерфейс между удаленными пользователями и определенными программами хоста, которые запускаются по запросам этих пользователей. Сервис RPC какого-либо хоста, как правило, предоставляет клиентам комплекс программ. Каждая из таких программ состоит, в свою очередь, из одной или нескольких удаленных процедур. Например, сервис удаленной файловой системы NFS, который построен на вызовах RPC, может состоять только из двух программ: например, одна программа взаимодействует с высокоуровневыми пользовательскими интерфейсами, а другая - с низкоуровневыми функциями ввода-вывода.</p>
<p>В каждом вызове удаленной процедуры участвуют две стороны: активный клиент, который отправляет запрос вызова процедуры на сервер, и сервер, который отправляет клиенту ответ.</p>
<p>Примечание. Следует иметь в виду, что термины "клиент" и "сервер" в данном случае относятся к определенной транзакции Конкретный хост или программное обеспечение (процесс или программа) могут работать как в роли клиента, так и в роли сервера. Например, программа, которая обеспечивает работу сервиса удаленных процедур, в то же время может быть клиентом в работе с сетевой файловой системой.</p>
<p>Протокол RPC построен на модели вызовов удаленных процедур, подобному механизму вызовов локальных процедур. При вызове локальной процедуры вы помещаете аргументы в определенное место памяти, в стек или переменные окружения и передаете управление процессом по определенному адресу. После завершения работы вы читаете результаты по конкретному адресу и продолжаете свой процесс.</p>
<p>В случае работы с удаленной процедурой, основное отличие состоит в том, что вызов удаленной функции обслуживают два процесса: клиентский процесс и серверный процесс.</p>
<p>Процесс клиента отправляет серверу сообщение, в которое включены параметры вызываемой процедуры и ожидает ответного сообщения с результатами ее работы. При получении ответа результат считывается, и процесс продолжает работу. Со стороны сервера процесс-обработчик вызовов находится в состоянии ожидания, и, при поступлении сообщения, считывает параметры процедуры, выполняет ее, отправляет ответ и становится в состояние ожидания следующего вызова.</p>
<p>RPC-протокол не накладывает каких-либо требований на дополнительные связи между процессами и не требует синхронности выполняемых функций, т. е. вызовы могут быть асинхронными и взамонезависимыми, так что клиент во время ожидания ответа может выполнять другие процедуры. Сервер RPC может выделять для каждой функции отдельный процесс или виртуальную машину, поэтому, не дожидаясь окончания работы предыдущих запросов, сразу же может принимать следующие.</p>
<p>Однако между вызовами локальных и удаленных процедур есть несколько важных отличий:</p>
<p>1. Обработка ошибок. Клиент в любом случае должен получать уведомление об ошибках, возникающих при вызовах удаленных процедур на сервере или в сети.</p>
<p>2. Глобальные переменные. Поскольку сервер не имеет доступа к адресному пространству клиента, при вызовах удаленных процедур нельзя использовать скрытые параметры в виде глобальных переменных.</p>
<p>3. Производительность. Скорость выполнения удаленных процедур, как правило на один или два порядка ниже скорости выполнения аналогичных локальных процедур.</p>
<p>4. Аутентификация. Поскольку вызовы удаленных процедур происходят по сети, необходимо использовать механизмы аутентификации клиента.</p>
<p>Принципы построения протокола.</p>
<p>Протокол RPC может использовать несколько различных транспортных протоколов. В обязанности RPC-протокола входит только обеспечение стандартов и интерпретация передачи сообщений. Достоверность и надежность передачи сообщений целиком обеспечивается транспортным уровнем.</p>
<p>Однако RPC может контролировать выбор и некоторые функции транспортного протокола. В качестве примера взаимодействия между RPC и транспортным протоколом рассмотрим процедуру назначения RPC-порта работы прикладного процесса через RPC - Portmapper.</p>
<p>Эта функция динамически (по запросу) назначает соединению RPC определенный порт. Функция Portmapper используется довольно часто, поскольку набор зарезервированных для RPC транспортных портов ограничен, а количество процессов, которые потенциально могут одновременно работать очень высоко. Portmapper, например, вызывается при выборе портов взаимодействия клиента и сервера системы NFS.</p>
<p>Сервис Portmapper использует механизм широковещательных сообщений RPC на определенный порт - III. На этот порт клиент отправляет широковещательное сообщение запроса порта определенного сервиса RPC. Сервис Portmapper обрабатывает таксе сообщение, определяет адрес локального сервиса RPC и отправляет клиенту ответ. Сервис RPC Portmapper может работать как с TCP, так и с UDP-протоколами.</p>
<p>RPC может работать с различными транспортными протоколами, но никогда не дублирует их функции, т. е. если RPC работает поверх TCP, все заботы о надежности и достоверности соединения RPC возлагает на TCP. Однако, если протокол RPC установлен поверх UDP, он может обеспечивать дополнительные собственные функции обеспечения гарантированной доставки сообщений.</p>
<p>Примечание. Прикладные задачи могут рассматривать RPC-протокол как определенную процедуру вызова функции по сети JSR (Jump Subroutine Instruction).</p>
<p>Для работы RPC-протокола необходимо выполнение следующих условий:</p>
<p>1. Уникальная идентификации всех удаленно вызываемых процедур на данном хосте. RPC-запросы содержат три поля идентификаторов - номер удаленной программы (сервиса), номер версии удаленной программы и номер удаленной процедуры указанной программы. Номер программы назначается производителем сервиса, номер процедуры указывает на конкретную функцию данного сервиса</p>
<p>2. Идентификация версии RPC-протокола. RPC-сообщения содержат поле версии RPC-протокола. Она используется для согласования форматов передаваемых параметров при работе клиента с различными версиями RPC.</p>
<p>3. Предоставление механизмов аутентификации клиента на сервере. RPC-протокол обеспечивает процедуру аутентификации клиента в сервисе, и, в случае необходимости, при каждом запросе или отправке ответа клиенту. Кроме того, RPC позволяет использовать различные дополнительные механизмы безопасности.</p>
<p>RPC может использовать четыре типа механизмов аутентификации:</p>
<p>- AUTH_NULL - без использования аутентификации</p>
<p>- AUTH_UNIX - аутентификация по стандарту UNIX</p>
<p>- AUTH_SHORT - аутентификация по стандарту UNIX с собственной структурой кодирования</p>
<p>- AUTH_DES - аутентификация по стандарту DES</p>
<p>4. Идентификация сообщений ответа на соответствующие запросы. Ответные сообщения RPC содержат идентификатор запроса, на основании которого они были построены. Этот идентификатор можно назвать идентификатором транзакции вызова RPC. Данный механизм особенно необходим при работе в асинхронном режиме и при выполнении последовательности из нескольких RPC-вызовов.</p>
<p>5. Идентификация ошибок работы протокола. Все сетевые или серверные ошибки имеют уникальные идентификаторы, по которым каждый из участников соединения может определить причину сбоя в работе.</p>
<p>Структуры сообщений протокола</p>
<p>При передаче RPC-сообщений поверх транспортного протокола, несколько RPC-сообщений могут располагаться внутри одного транспортного пакета. Для того чтобы отделять одно сообщение от другого, используется маркер записи (RM - Record Marker). Каждое RPC-сообщение "маркируется" ровно одним RM.</p>
<p>RPC-сообщение может состоять из нескольких фрагментов. Каждый фрагмент состоит из четырех байт заголовка и (от 0 до 2**31-1) данных. Первый бит заголовка указывает, является ли данный фрагмент последним, а остальные 31 бит указывают длину пакета данных.</p>
<p>Структура RPC формально описана на языке описания и представления форматов данных - XDR с дополнениями, касающимися описания процедур. Можно даже сказать, что язык описания RPC является расширением XDR, дополненным работой с процедурами.</p>
<p>Структура RPC-пакета выглядит следующим образом:</p>
<pre>
struct rpc_msg { 
unsigned int xid;
union switch (msg_type mtype) { 
case CALL:
call_body cbody; 
case REPLY:
reply body rbody; 
} body; 
};
</pre>

 
<p>где xid - идентификатор текущей транзакции, call_body - пакет запроса, reply_body - пакет ответа. Структура запроса выглядит примерно так:</p>
<pre>
struct call body { 
unsigned int rpcvers; 
unsigned int prog; 
unsigned int vers; 
unsigned int proc; 
opaque_auth cred; 
opaque_auth verf;
/* procedure parameters */ 
};
</pre>

<p>Структура ответа (reply_body) может содержать либо структуру, передаваемую в случае ошибки (тогда она содержит код ошибки), либо структуру успешной обработки запроса (тогда она содержит возвращаемые данные).</p>
<p>Программный интерфейс высокого уровня.</p>
<p>Использование подпрограмм в программе - традиционный способ структурировать задачу, сделать ее более ясной. Наиболее часто используемые подпрограммы собираются в библиотеки, где могут использоваться различными программами. В данном случае речь идет о локальном (местном) вызове, т. е. и вызывающий, и вызываемый объекты работают в рамках одной программы на одном компьютере.</p>
<p>В случае удаленного вызова процесс, выполняющийся на одном компьютере, запускает процесс на удаленном компьютере (т. е. фактически запускает код процедуры на удаленном компьютере). Очевидно, что удаленный вызов процедуры существенным образом отличается от традиционного локального, однако с точки зрения программиста такие отличия практически отсутствуют, т. е. архитектура удаленного вызова процедуры позволяет сымитировать вызов локальной.</p>
<p>Однако если в случае локального вызова программа передает параметры в вызываемую процедуру и получает результат работы через стек или общие области памяти, то в случае удаленного вызова передача параметров превращается в передачу запроса по сети, а результат работы находится в пришедшем отклике.</p>
<p>Данный подход является возможной основой создания распределенных приложений, и хотя многие современные системы не используют этот механизм, основные концепции и термины во многих случаях сохраняются. При описании механизма RPC мы будем традиционно называть вызывающий процесс - клиентом, а удаленный процесс, реализующий процедуру, - сервером.</p>
<p>Удаленный вызов процедуры включает следующие шаги:</p>
<p>1. Программа-клиент производит локальный вызов процедуры, называемой заглушкой (stub). При этом клиенту "кажется", что, вызывая заглушку, он производит собственно вызов процедуры-сервера. И действительно, клиент передает заглушке необходимые параметры, а она возвращает результат. Однако дело обстоит не совсем так, как это себе представляет клиент. Задача заглушки - принять аргументы, предназначаемые удаленной процедуре, возможно, преобразовать их в некий стандартный формат и сформировать сетевой запрос. Упаковка аргументов и создание сетевого запроса называется сборкой (marshalling).</p>
<p>2. Сетевой запрос пересылается по сети на удаленную систему. Для этого в заглушке используются соответствующие вызовы, например, рассмотренные в предыдущих разделах. Заметим, что при этом могут быть использованы различные транспортные протоколы, причем не только семейства TCP/IP.</p>
<p>3. На удаленном хосте все происходит в обратном порядке. Заглушка сервера ожидает запрос и при получении извлекает параметры - аргументы вызова процедуры. Извлечение (unmarshalling) может включать необходимые преобразования (например, изменения порядка расположения байтов).</p>
<p>4. Заглушка выполняет вызов настоящей процедуры-сервера, которой адресован запрос клиента, передавая ей полученные по сети аргументы.</p>
<p>5. После выполнения процедуры управление возвращается в заглушку сервера, передавая ей требуемые параметры. Как и заглушка клиента; заглушка сервера преобразует возвращенные процедурой значения, формируя сетевое сообщение-отклик, который передается по сети системе, от которой пришел запрос.</p>
<p>6. Операционная система передает полученное сообщение заглушке клиента, которая, после необходимого преобразования, передает значения (являющиеся значениями, возвращенными удаленной процедурой) клиенту, воспринимающему это как нормальный возврат из процедуры.</p>
<p>Таким образом, с точки зрения клиента, он производит вызов удаленной процедуры, как он это сделал бы для локальной. То же самое можно сказать и о сервере: вызов процедуры происходит стандартным образом, некий объект (заглушка сервера) производит вызов локальной процедуры и получает возвращенные ею значения. Клиент воспринимает заглушку как вызываемую процедуру-сервер, а сервер принимает собственную заглушку за клиента.</p>
<p>Таким образом, заглушки составляют ядро системы RPC, отвечая за все аспекты формирования и передачи сообщений между клиентом и удаленным сервером (процедурой), хотя и клиент и сервер считают, что вызовы происходят локально. В этом-то и состоит основная концепция RPC - полностью спрятать распределенный (сетевой) характер взаимодействия в коде заглушек. Преимущества такого подхода очевидны: и клиент и сервер являются независимыми от сетевой реализации, оба они работают в рамках некой распределенной виртуальной машины, и вызовы процедур имеют стандартный интерфейс.</p>
<p>Передача параметров</p>
<p>Передача параметров-значений не вызывает особых трудностей. В этом случае заглушка клиента размещает значение параметра в сетевом запросе возможно, выполняя преобразования к стандартному виду (например, изменяя порядок следования байтов). Гораздо сложнее обстоит дело с передачей указателей, когда параметр представляет собой адрес данных, а не их значение. Передача в запросе адреса лишена смысла, так как удаленная процедура выполняется в совершенно другом адресном пространстве. Самым простым решением, применяемым в RPC, является запрет клиентам передавать параметры иначе, как по значению, хотя это, безусловно, накладывает серьезные ограничения.</p>
<p>Связывание (binding)</p>
<p>Прежде чем клиент сможет вызвать удаленную процедуру, необходимо связать его с удаленной системой, располагающей требуемым сервером. Таким образом, задача связывания распадается на две:</p>
<p>- Нахождение удаленного хоста с требуемым сервером</p>
<p>- Нахождение требуемого серверного процесса на данном хосте</p>
<p>Для нахождения хоста могут использоваться различные подходы. Возможный вариант - создание некоего централизованного справочника, в котором хосты анонсируют свои серверы, и где клиент при желании может выбрать подходящие для него хост и адрес процедуры.</p>
<p>Каждая процедура RPC однозначно определяется номером программы и процедуры. Номер программы определяет группу удаленных процедур, каждая из которых имеет собственный номер. Каждой программе также присваивается номер версии, так что при внесении в программу незначительных изменений (например, при добавлении процедуры) отсутствует необходимость менять ее номер. Обычно несколько функционально сход-ных процедур реализуются в одном программном модуле, который при запуске становится сервером этих процедур, и который идентифицируется номером программы.</p>
<p>Таким образом, когда клиент хочет вызвать удаленную процедуру, ему необходимо знать номера программы, версии и процедуры, предоставляющей требуемый сервис.</p>
<p>Для передачи запроса клиенту также необходимо знать сетевой адрес хоста и номер порта, связанный с программой-сервером, обеспечивающей требуемые процедуры. Для этого используется демон portmap(IM) (в некоторых системах он называется rpcbind(IM)). Демон запускается на хосте, который предоставляет сервис удаленных процедур, и использует общеизвестный номер порта. При инициализации процесса-сервера он регистрирует в portmap(IM) свои процедуры и номера портов. Теперь, когда клиенту требуется знать номер порта для вызова конкретной процедуры, он посылает запрос на сервер portmap(IM), который, в свою очередь, либо возвращает номер порта, либо перенаправляет запрос непосредственно серверу удаленной процедуры и после ее выполнения возвращает клиенту отклик. В любом случае, если требуемая процедура существует, клиент получает от сервера portmap(IM) номер порта процедуры, и дальнейшие запросы может делать уже непосредственно на этот порт.</p>
<p>Обработка особых ситуаций (exception)</p>
<p>Обработка особых ситуаций при вызове локальных процедур не представляет особой проблемы. UNIX обеспечивает обработку ошибок процессов таких как деление на ноль, обращение к недопустимой области памяти и т. д. В случае вызова удаленной процедуры вероятность возникновения ошибочных ситуаций увеличивается. К ошибкам сервера и заглушек добавляются ошибки, связанные, например, с получением ошибочного сетевого сообщения.</p>
<p>Например, при использовании UDP в качестве транспортного протокола производится повторная передача сообщений после определенного тайм-аута. Клиенту возвращается ошибка, если, спустя определенное число попыток, отклик от сервера так и не был получен. В случае, когда используется протокол TCP, клиенту возвращается ошибка, если сервер оборвал TCP-соединение.</p>
<p>Семантика вызова</p>
<p>Вызов локальной процедуры однозначно приводит к ее выполнению после чего управление возвращается в головную программу. Иначе дело обстоит при вызове удаленной процедуры. Невозможно установить, когда конкретно будет выполняться процедура, будет ли она выполнена вообще, а если будет, то какое число раз? Например, если запрос будет получен удаленной системой после аварийного завершения программы сервера, процедура не будет выполнена вообще. Если клиент при неполучении отклика после определенного промежутка времени (тайм-аута) повторно посылает запрос, то может создаться ситуация, когда отклик уже передается по сети, а повторный запрос вновь принимается на обработку удаленной процедурой. В этом случае процедура будет выполнена несколько раз.</p>
<p>Таким образом, выполнение удаленной процедуры можно характеризовать следующей семантикой:</p>
<p>- Один и только один раз. Данного поведения (в некоторых случаях наиболее желательного) трудно требовать ввиду возможных аварий сервера.</p>
<p>- Максимум раз. Это означает, что процедура либо вообще не была выполнена, либо была выполнена только один раз. Подобное утверждение можно сделать при получении ошибки вместо нормального отклика.</p>
<p>- Хотя бы раз. Процедура наверняка была выполнена один раз, но возможно и больше. Для нормальной работы в такой ситуации удаленная процедура должна обладать свойством идемпотентности (от англ. idemponent). Этим свойством обладает процедура, многократное выполнение которой не вызывает кумулятивных изменений. Например, чтение файла идемпотентно, а добавление текста в файл - нет.</p>
<p>Представление данных</p>
<p>Когда клиент и сервер выполняются в одной системе на одном компьютере, проблем с несовместимостью данных не возникает. И для клиента и для сервера данные в двоичном виде представляются одинаково. В случае удаленного вызова дело осложняется тем, что клиент и сервер могут выполняться на системах с различной архитектурой, имеющих различное представление данных (например, представление значения с плавающей точкой, порядок следования байтов и т. д.)</p>
<p>Большинство реализаций системы RPC определяют некоторые стандартные виды представления данных, к которым должны быть преобразованы все значения, передаваемые в запросах и откликах.</p>
<p>Например, формат представления данных в RPC фирмы Sun Microsystems следующий:</p>
<p>Порядок следования байтов - Старший - последний</p>
<p>Представление значений с плавающей точкой - IEEE</p>
<p>Представление символа - ASCII</p>
<p><b>Сеть</b></p>
<p>По своей функциональности система RPC занимает промежуточное место между уровнем приложения и транспортным уровнем. В соответствии с моделью OSI этому положению соответствуют уровни представления и сеанса. Таким образом, RPC теоретически независим от реализации сети, в частности, от сетевых протоколов транспортного уровня.</p>
<p>Программные реализации системы, как правило, поддерживают один или два протокола. Например, система RPC разработки фирмы Sun Microsystems поддерживает передачу сообщений с использованием протоколов TCP и UDP. Выбор того или иного протокола зависит от требований приложения. Выбор протокола UDP оправдан для приложений, обладающих следующими характеристиками:</p>
<p>- Вызываемые процедуры идемпотентны</p>
<p>- Размер передаваемых аргументов и возвращаемого результата меньше размера пакета UDP - 8 Кбайт.</p>
<p>- Сервер обеспечивает работу с несколькими сотнями клиентов. Поскольку при работе с протоколами TCP сервер вынужден поддерживать соединение с каждым из активных клиентов, это занимает значительную часть его ресурсов. Протокол UDP в этом отношении является менее ресурсоемким</p>
<p>С другой стороны, TCP обеспечивает эффективную работу приложений со следующими характеристиками:</p>
<p>- Приложению требуется надежный протокол передачи</p>
<p>- Вызываемые процедуры неидемпонентны</p>
<p>- Размер аргументов или возвращаемого результата превышает 8 Кбайт</p>
<p>Выбор протокола обычно остается за клиентом, и система по-разному организует формирование и передачу сообщений. Так, при использовании протокола TCP, для которого передаваемые данные представляют собой поток байтов, необходимо отделить сообщения друг от друга. Для этого например, применяется протокол маркировки записей, описанный в RFC1057 "RPC: Remote Procedure Call Protocol specification version 2", при котором в начале каждого сообщения помещается 32-разрядное целое число, определяющее размер сообщения в байтах.</p>
<p>По-разному обстоит дело и с семантикой вызова. Например, если RPC выполняется с использованием ненадежного транспортного протокола (UDP), система выполняет повторную передачу сообщения через короткие промежутки времени (тайм-ауты). Если приложение-клиент не получает отклик, то с уверенностью можно сказать, что процедура была выполнена ноль или большее число раз. Если отклик был получен, приложение может сделать вывод, что процедура была выполнена хотя бы однажды. При использовании надежного транспортного протокола (TCP) в случае получения отклика можно сказать, что процедура была выполнена один раз. Если же отклик не получен, определенно сказать, что процедура выполнена не была, нельзя3.</p>
<p>Как это работает?</p>
<p>По существу, собственно система RPC является встроенной в программу-клиент и программу-сервер. Отрадно, что при разработке распределенных приложений, не придется вникать в подробности протокола RPC или программировать обработку сообщений. Система предполагает существование соответствующей среды разработки, которая значительно облегчает жизнь создателям прикладного программного обеспечения. Одним из ключевых моментов в RPC является то, что разработка распределенного приложения начинается с определения интерфейса объекта - формального описания функций сервера, сделанного на специальном языке. На основании этого интерфейса затем автоматически создаются заглушки клиента и сервера. Единственное, что необходимо сделать после этого, - написать фактический код процедуры.</p>
<p>В качестве примера рассмотрим RPC фирмы Sun Microsystems. Система состоит из трех основных частей:</p>
<p>- rpcgen(1) - RPC-компилятор, который на основании описания интерфейса удаленной процедуры генерирует заглушки клиента и сервера в виде программ на языке С.</p>
<p>- Библиотека XDR (eXternal Data Representation), которая содержит функции для преобразования различных типов данных в машинно-независимый вид, позволяющий производить обмен информацией между разнородными системами.</p>
<p>- Библиотека модулей, обеспечивающих работу системы в целом.</p>
<p>Рассмотрим пример простейшего распределенного приложения для ведения журнала событий. Клиент при запуске вызывает удаленную процедуру записи сообщения в файл журнала удаленного компьютера.</p>
<p>Для этого придется создать как минимум три файла: спецификацию интерфейсов удаленных процедур log.x (на языке описания интерфейса), собственно текст удаленных процедур log.c и текст головной программы клиента main ( ) - client.c (на языке С) .</p>
<p>Компилятор rpcgen(l) на основании спецификации log.x создает три файла: текст заглушек клиента и сервера на языке С (log clnt.c и log svc.c) и файл описаний log.h, используемый обеими заглушками.</p>
<p>Итак, рассмотрим исходные тексты программ.</p>
<p>log.x</p>
<p>В этом файле указываются регистрационные параметры удаленной процедуры - номера программы, версии и процедуры, а также определяется интерфейс вызова - входные аргументы и возвращаемые значения. Таким образом, определена процедура RLOG, в качестве аргумента принимающая строку (которая будет записана в журнал), а возвращаемое значение стандартно указывает на успешное или неудачное выполнение заказанной операции.</p>
<pre>
program LOG_PROG {
version LOG_VER {
int RLOG (string) = 1;
} = 1;
} = 0х31234567;
</pre>

<p>Компилятор rpcgen(l) создает файл заголовков log.h, где, в частности, определены процедуры:</p>
<p>log.h</p>
<pre>
/*
* Please do not edit this file. 
* It was generated using rpcgen. 
*/ 
#ifndef _LOG_H_RPCGEN 
#define _LOG_H_RPCGEN 
#include &lt;rpc/rpc.&gt; 
/* Номер программы*/
#define LOG_PROG ((unsigned long) (0х31234567)) 
#define LOG_VER ((unsigned long) (1)) /*Номер версии*/ 
#define RLOG ((unsigned long) (1)) /*Номер процедуры*/ 
extern int *rlog_l () ;
/*Внутренняя процедура - нам ее использовать не придется*/ extern int log_prog_l_freeresult(); 
#endif /* !_LOG_H_RPCGEN */
</pre>

<p>Рассмотрим этот файл внимательно. Компилятор транслирует имя RLOG определенное в файле описания интерфейса, в rlog_1, заменяя прописные символы на строчные и добавляя номер версии программы с подчеркиванием. Тип возвращаемого значения изменился с int на int *. Таково правило - RPC позволяет передавать и получать только адреса объявленных при описании интерфейса параметров. Это же правило касается и передаваемой в качестве аргумента строки. Хотя из файла print.h это не следует, на самом деле в качестве аргумента функции rlog_l ( ) также передается адрес строки.</p>
<p>Помимо файла заголовков компилятор rpcgen(l) создает модули заглушки клиента и заглушки сервера. По существу, в тексте этих файлов заключен весь код удаленного вызова.</p>
<p>Заглушка сервера является головной программой, обрабатывающей все сетевое взаимодействие с клиентом (точнее, с его заглушкой). Для выполнения операции заглушка сервера производит локальный вызов функции, текст которой необходимо написать:</p>
<p>log.c</p>

<pre>
#include &lt;rpc/rpc.&gt;
#include &lt;sys/types.&gt;
#include &lt;sys/stat.&gt;
#include "log.h"
int *rlog_1 (char **arg)
{
/*Возвращаемое значение должно определяться как static*/
static int result;
int fd; /*Файловый дескриптор журнала*/
int len;
result = 1;
/*0ткроем файл журнала (создадим, если он не существует), в случае неудачи вернем код ошибки result == 1.*/
if ((fd=open( "./server .log",
O_CREAT | O_RDWR | O_APPEND)) &lt; 0) return (&amp;result);
len = strlen(*arg);
if (write(fd, *arg, strlen(*arg)) != len)
result = 1;
else
result = 0;
close (fd);
return(&amp;result); /*Возвращаем результат - адрес result*/
}
</pre>
<p>Заглушка клиента принимает аргумент, передаваемый удаленной процедуре, делает необходимые преобразования, формирует запрос на сервер portmap(1M), обменивается данными с сервером удаленной процедуры и, наконец, передает возвращаемое значение клиенту. Для клиента вызов удаленной процедуры сводится к вызову заглушки и ничем не отличается от обычного локального вызова.</p>
<p>client.c</p>
<pre>
#include &lt;rpc/rpc.&gt;
#include "log.h"
main(int argc, char *argv[])
{
CLIENT *cl;
char *server, *mystring, *clnttime;
time_t bintime;
int *result;
if (argc != 2) {
fprintf(stderr, "Формат вызова: %s Адрес_хоста\n",
argv [0]);
exit (1) ;
}

server = argv [1];
/*Получим дескриптор клиента. В случае неудачи - сообщим о
невозможности установления связи с сервером*/
if ( (с1 = clnt_create (server,
LOG_PROG, LOG_VER, "udp")) == NULL) {
clnt_pcreateerror (server);
exit (2);
}
/*Выделим буфер для строки*/
mystring = (char * )malloc (100);
/*Определим время события*/
bintime = time ((time_t * ) NULL);
clnttime = ctime(&amp;bintime);
sprintf (mystring, "%s - Клиент запущен", clnttime);
/*Передадим сообщение для журнала - время начала работы клиента. В случае неудачи - сообщим об ошибке*/
if ( (result = rlog_l(&amp;mystring, cl)) == NULL) {
fprintf(stderr, "error2\n");
clnt_perror(cl, server);
exit(3);
}
/*B случае неудачи на удаленном компьютере сообщим об ошибке*/
if (*result !=0 )
fprintf(stderr, "Ошибка записи в журнал\n");
/*0свободим дескриптор*/
cint destroy(cl);
exit (0);
}
</pre>
<p>Заглушка клиента log_clnt.c компилируется с модулем client.c для получения исполняемой программы клиента.</p>
<p>cc -о rlog client.c log_clnt.c -Insl</p>
<p>Заглушка сервера log_svc.c и процедура log.c компилируются для получения исполняемой программы сервера.</p>
<p>cc -о logger log_svc.c log.c -Insl</p>
<p>Теперь на некотором хосте server.nowhere.ru необходимо запустить серверный процесс:</p>
<p>$ logger</p>
<p>После чего при запуске клиента rlog на другой машине сервер добавит соответствующую запись в файл журнала.</p>
<p>Схема работы RPC в этом случае приведена на рис. 1. Модули взаимодействуют следующим образом:</p>
<p>1. Когда запускается серверный процесс, он создает сокет UDP и связывает любой локальный порт с этим сокетом. Далее сервер вызывает библиотечную функцию svc_register(3N) для регистрации номеров программы и ее версии. Для этого функция обращается к процессу portmap(IM) и передает требуемые значения. Сервер portmap(IM) обычно запускается при инициализации системы и связывается с некоторым общеизвестным портом. Теперь portmap(3N) знает номер порта для нашей программы и версии. Сервер же ожидает получения запроса. Заметим, что все описанные действия производятся заглушкой сервера, созданной компилятором rpcgen(IM).</p>
<p>2. Когда запускается программа rlog, первое, что она делает, - вызывает библиотечную функцию clnt_create(3N), указывая ей адрес удаленной системы, номера программы и версии, а также транспортный протокол. Функция направляет запрос к серверу portmap(IM) удаленной системы server.nowhere.m и получает номер удаленного порта для сервера журнала.</p>
<p>3. Клиент вызывает процедуру rlog_1 ( ) , определенную в заглушке клиента, и передает управление заглушке. Та, в свою очередь, формирует запрос (преобразуя аргументы в формат XDR) в виде пакета UDP и направляет его на удаленный порт, полученный от сервера portmap(IM). Затем она некоторое время ожидает отклика и в случае неполучения повторно отправляет запрос. При благоприятных обстоятельствах запрос принимается сервером logger (модулем заглушки сервера). Заглушка определяет, какая именно функция была вызвана (по номеру процедуры), и вызывает функцию rlog_1 ( ) модуля log.c. После возврата управления обратно в заглушку последняя преобразует возвращенное функцией rlog_1 ( ) значение в формат XDR, и формирует отклик также в виде пакета UDP. После получения отклика заглушка клиента извлекает возвращенное значение, преобразует его и возвращает в головную программу клиента.</p>
