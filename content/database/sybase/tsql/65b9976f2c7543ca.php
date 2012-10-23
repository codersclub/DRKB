<h1>Курсоры: доступ  к отдельным строкам</h1>
<div class="date">01.01.2007</div>


<p>Курсоры: доступ&nbsp; к отдельным строкам</p>
&nbsp;</p>
Оператор выбора (select) возвращает обычно несколько строк, либо ничего не возвращает. Если оператор выбора возвращает в результате несколько строк, то с помощью курсоров можно получить доступ к каждой строке в отдельности.</p>
В этой главе рассматриваются следующие темы:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Дается общий обзор курсоров;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Описывается, как объявить и открыть курсор;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объясняется, как получить данные с помощью курсора;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объясняется, как обновить или удалить данные с помощью курсора;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Описывается, как закрыть курсор и освободить занимаемую им память;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Даются примеры использования курсоров;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Описывается,как нейтрализовать воздействие (locking affects) курсоров;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Описывается, как получить информацию о курсорах.</td></tr></table></div>&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое курсор ?</td></tr></table></div>&nbsp;</p>
Курсор - это символическое название объекта, который&nbsp; связан с оператором выбора с помощью декларативного оператора. Он состоит из следующих частей:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Результирующего множества курсора - множества (таблицы) строк, которое получено в результате запроса и с которым связывается курсор;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Позиции курсора - указателя на одну из строк результирующего множества.</td></tr></table></div>&nbsp;</p>
Позиция курсора указывает на текущую строку курсора. Пользователь может непосредственно модифицировать или удалять эту строку операторами update или delete, используя конструкцию с названием курсора. Можно изменить текущую позицию курсора с помощью операции fetch (передвинуть и загрузить). Эта операция переводит курсор на одну или несколько строк ниже в результирующем множестве.</p>
Курсор аналогичен указателю на записи файла. Однако курсор можно сдвигать только вперед по результирующему множеству (последовательный доступ). Если несколько строк уже пройдены, то нельзя вернуться назад и снова получить к ним доступ, переведя на них курсор. Этот процесс позволяет просматривать строки друг за другом.</p>
После объявления курсора он может находиться в двух состояниях:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Закрытом - В этом случае не существует результирующего множества, поэтому нельзя считывать из него информацию. Первоначально курсор находится в этом состоянии. Чтобы использовать курсор, его необходимо явно открыть. После окончания работы курсор необходимо явно закрыть. SQL Сервер может неявно закрыть курсор в некоторых случаях, которые будут далее перечислены;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Открытом - В этом случае с помощью курсора можно считывать и модифицировать строки.</td></tr></table></div>&nbsp;</p>
Курсор можно закрыть и затем снова отрыть его. Повторное открытие курсора вновь создает результирующее множество и курсор устанавливается непосредственно перед первой строкой в этом множестве. Это позволяет пройти по результирующему множеству столько раз, сколько это необходимо. Курсор можно закрыть в любое время; необязательно проходить все результирующее множество.</p>
Все операции с курсором, такие как передвижение и модификация, выполняются по отношению к текущей позиции курсора. Обновление курсорной строки включает в себя изменение данных в этой строке и полное удаление этой строки. Курсор нельзя использовать для вставки строк. Все обновления через курсор выполняются в соответствующих базовых таблицах, откуда выбирается результирующее множество.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как SQL Сервер обрабатывает курсоры</td></tr></table></div>&nbsp;</p>
Когда доступ к данным осуществляется через курсор, SQL Сервер разбивает процесс на следующие шаги:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Объявление курсора;</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SQL Сервер создает структуру курсора и компилирует запрос, определенный для курсора. Он сохраняет скомпилированный план, но не выполняет его.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Открытие курсора;</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SQL Сервер выполняет план запроса. Он просматривает базовые таблицы (столько, сколько это необходимо как в обычном операторе выбора) и создает результирующее множество курсора. Он подготавливает необходимые временные таблицы, порожденные запросом, и выделяет ресурсы (такие как память) для реализации курсора. Он также располагает курсор перед первой строкой результирующего множества.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Передвижение курсора;</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SQL Сервер передвигает курсор на одну или несколько позиций по результирующему множеству. Он выбирает данные из строки и сохраняет позицию курсора, чтобы в дальнейшем достичь конца результирующего множества.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Обновление или удаление данных через курсор;</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SQL Сервер обновляет или удаляет данные в указанной курсором строке результирующего множества (и в соответствующих базовых таблицах, откуда были выбраны данные). Этот шаг необязателен.&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Закрытие курсора;</td></tr></table></div>SQL Сервер закрывает результирующее множества курсора, удаляет&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; все временные таблицы и освобождает ресурсы, занятые курсором. Однако он сохраняет план выполнения запроса, чтобы снова можно было открыть курсор.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Удаление курсора.</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SQL Сервер удаляет план выполнения курсора из памяти и все ссылки на структуру курсора. После этого нужно объявить курсор, чтобы снова использовать его.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Объявление курсоров</td></tr></table></div>&nbsp;</p>
Пользователь должен объявить курсор прежде, чем можно будет его использовать. В объявлении указывается запрос, который определяет результирующее множество курсора. Пользователь может явно объявить курсор для обновления или только для чтения с помощью ключевых слов for update (для обновления) или for read only (только для чтения). Если эти слова не указаны, то SQL Сервер определяет можно ли обновлять через курсор, основываясь на типе запроса, который формирует результирующее множество курсора. Нельзя использовать операторы update и delete в формирующем запросе для курсора, объявленного только для чтения.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Синтаксис объявления курсора</td></tr></table></div>&nbsp;</p>
Синтаксис оператора declare cursor (объявление курсора) имеет следующий вид:</p>
&nbsp;</p>
declare название_курсора cursor</p>
 &nbsp;&nbsp; for оператор_выбора</p>
 &nbsp; [for {read only | update [of список_столбцов]}]</p>
&nbsp;</p>
Оператор declare cursor должен предшествовать любому оператору open (открыть) для этого курсора. Оператор declare cursor нельзя совмещать с другими операторами в одном Transact-SQL пакете за исключением случая, когда курсор используется в сохраненной процедуре.</p>
 Оператор_выбора (select) является запросом, который определяет результирующее множество данного курсора. Вообще говоря, в этом операторе можно использовать весь синтаксис и семантику оператора select, включая ключевое слово holdlock. Однако, в нем нельзя использовать конструкции compute, for browse и into.</p>
Например, в следующем операторе объявляется курсор authors_crsr на результирующем множестве, которое содержит всех авторов, которые не живут в Калифорнии:</p>
&nbsp;</p>
declare authors_crsr cursor</p>
for select au_id, au_lname, au_fname</p>
from authors</p>
where state != 'CA'</p>
&nbsp;</p>
Оператор выбора в объявлении курсора может содержать ссылки на названия параметров и локальные переменные. Однако эти параметры и локальные переменные должны быть определены в сохраненной процедуре, которая содержит оператор объявления курсора declare cursor. Если курсор используется в триггере, то в соответствующем операторе выбора можно ссылаться на временные триггерные таблицы inserted и deleted. Более подробную информацию об операторе выбора можно посмотреть в главе 2 «Запросы: выбор данных из таблицы».</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Области действия курсора</td></tr></table></div>&nbsp;</p>
Курсор определяется своей областью (диапазоном) действия, которая&nbsp; определяет временной промежуток (region), в течении которого курсор существует. Вне этого промежутка курсор перестает существовать. Области действия курсора определяются следующим образом:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Сессия - В этом случае область действия курсора начинается в момент регистрации клиента SQL Сервера и заканчивается, когда клиент заканчивает работу. Эта область действия отличается от областей, определяемых сохраненными процедурами и триггерами;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Сохраненная процедура - В этом случае область действия курсора начинается с момента начала выполнения сохраненной процедуры и заканчивается, когда она заканчивает выполнение. Когда сохраненная процедура вызывает другую процедуру, то SQL Сервер начинает отсчет новой области действия и рассматривает ее, как подобласть области действия первой процедуры;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Триггер - В этом случае область действия курсора начинается с момента начала выполнения триггера и заканчивается, когда триггер заканчивает свою работу.</td></tr></table></div>&nbsp;</p>
Название курсора должно быть уникально в области его действия. В различных областях названия курсоров могут совпадать. Курсор определенный для одной области недоступен из других областей (диапазонов) действия. Однако, SQL Сервер позволяет использовать курсор в подобласти, если в ней не был определен курсор с тем же названием.</p>
SQL Сервер определяет конфликты в названиях курсоров лишь в процессе выполнения. В сохраненной процедуре или триггере можно определить два курсора с одним названием, если в процессе исполнения они используются раздельно, как в следующем примере:</p>
&nbsp;</p>
create procedure proc1 (@flag int)</p>
as</p>
if (@flag)</p>
 &nbsp;&nbsp; declare names_crsr cursor</p>
 &nbsp;&nbsp; for select au_fname from authors</p>
else</p>
 &nbsp;&nbsp; declare names_crsr cursor</p>
 &nbsp;&nbsp; for select au_lname from authors</p>
return</p>
&nbsp;</p>
Эта процедура будет успешно выполнена, поскольку только один из курсоров names_crsr будет определен в процессе выполнения этой процедуры.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Развертывание курсора и результирующее множество</td></tr></table></div>&nbsp;</p>
Результирующее множество курсора может не совпадать с данными из базовых таблиц. Например, курсор объявленный с конструкцией order by (упорядочить по) обычно требует создания внутренней таблицы для упорядочения строк результирующего множества. Кроме того, SQL Сервер не блокирует строки базовых таблиц, которые соответствуют строкам внутренней таблицы, что позволяет другим клиентам обновлять эти строки в базовых таблицах. В этом случае строки, которые видит клиент в результирующем множестве могут не отражать последних изменений, произошедших в базовых таблицах.</p>
Результирующее множество курсора порождается по мере его продвижения. Это означает, что оператор выбора курсора выполняется как обычный запрос на выбор. Этот процесс известный как развертывание курсора (cursor scans) обеспечивает быстрое время ответа и не требует считывания строк, которые не нужны приложению в данный момент.</p>
SQL Сервер требует, чтобы при развертывании курсора использовался уникальный индекс таблицы, особенно на нулевом уровне изоляции считывания (isolation level 0 reads). Если таблица содержит&nbsp; столбец-счетчик и необходимо создать неуникальный индекс для этой таблицы, то следует использовать опцию базы данных identity in nonunique index (счетчик в неуникальном индексе), что позволит автоматически включать&nbsp; столбец-счетчик в ключи табличных индексов и поэтому все они будут уникальными. Таким образом, эта опция делает логически неуникальные индексы внутренне уникальными, что позволяет использовать их в обновляемых курсорах на нулевом уровне изоляции считывания.</p>
Можно также использовать курсор для таблиц без индексов, если эти таблицы не обновляются другими процессами, что приводит к изменению позиций строк. Например:</p>
&nbsp;</p>
declare storinfo_crsr cursor</p>
for select stor_id, stor_name, payterms</p>
 &nbsp;&nbsp; from stores</p>
 &nbsp;&nbsp; where state = 'CA'</p>
&nbsp;</p>
Таблица stores, указанная в этом курсоре, вообще не содержит индексов. SQL Сервер допускает объявление курсора в таблице без уникальных индексов, но при обновлении или удалении из нее строк закрываются все курсоры в таких таблицах.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Создание обновляемых курсоров</td></tr></table></div>&nbsp;</p>
Если курсор является обновляемым, то через него можно обновлять содержимое строк или удалять строки полностью. Если курсор предназначен только для чтения, то через него можно только считывать данные. По умолчанию SQL Сервер пытается сделать курсор обновляемым и если это не удается, то курсор предназначается для чтения.</p>
Можно явно указать, является ли курсор обновляемым с помощью ключевых слов read only или update в операторе declare. Например, в следующем операторе определяется обновляемое результирующее множество для курсора pubs_crsr:</p>
&nbsp;</p>
declare pubs_crsr cursor</p>
for select pub_name, city, state</p>
from publishers</p>
for update of city, state</p>
&nbsp;</p>
В этом примере результирующее множество будет включать все строки из таблицы publishers, но только поля city и state явно указаны как обновляемые.</p>
Если через курсор не нужно обновлять или удалять, то его следует объявить только для чтения. Если явно не указано является ли курсор обновляемым или предназначенным только для чтения, то SQL Сервер по умолчанию считает курсор обновляемым, если соответствующий оператор выбора не содержит следующих конструкций:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>опции distinct (различные);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>предложения group by (группировка);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>агрегирующих функций;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>подзапросов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>оператора union (объединить);</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="13">&#183;</td><td>предложения at isolation read uncommitted.</td></tr></table></div>&nbsp;</p>
Нельзя указывать предложение for update, если оператор выбора курсора содержит одну из вышеперечисленных конструкций. SQL Сервер устанавливает курсор только для чтения, если предложение order by содержится в операторе выбора этого курсора. Дополнительная информация о курсорах содержится в главе «Курсоры» Справочного руководства SQL Сервера.</p>
Если в предложении for update не указывается список столбцов, то все столбцы будут обновляемыми. Как было отмечено ранее при описании развертывания курсора, SQL Сервер пытается использовать уникальные индексы для обновляемых курсоров, когда развертывает базовую таблицу. При наличии курсора SQL Сервер рассматривает индекс, содержащий&nbsp; столбец-счетчик, как уникальный, даже если он и не объявлен таковым.</p>
SQL Сервер позволяет указывать в списке столбцов предложения for update названия столбцов, которых нет в операторе выбора курсора.</p>
В следующем примере SQL Сервер использует уникальный индекс в столбце pub_id таблицы publishers (несмотря на то, что этого столбца нет в определении курсора newpubs_crsr):</p>
&nbsp;</p>
declare newpubs_crsr cursor</p>
for select pub_name, city, state</p>
from publishers</p>
for update</p>
&nbsp;</p>
Если предложение for update не указано, то SQL Сервер может выбрать любой уникальный индекс или, при его отсутствии, любую комбинацию индексов для развертывания таблицы. Однако, если явно указано предложение for update, то должен существовать уникальный индекс, необходимый для развертывания базовой таблицы.&nbsp; В противном случае будет выдано сообщение об ошибке.</p>
В списке столбцов предложения for update следует указывать столбцы, в которых необходимо обновлять данные, и в этом списке не должно быть столбцов, включенных в уникальные индексы. Это позволяет SQL Серверу использовать уникальные индексы для развертки таблицы и позволяет избежать аномального обновления известного как Проблема привидений (Halloween Problem).</p>
Эта проблема возникает, когда клиент обновляет поле строки результирующего множества курсора, которое влияет на порядок расположения строк базовой таблицы. Например, если SQL Сервер получает доступ к базовой таблице используя индекс, и ключ (значение) индекса обновляется клиентом, то измененная строка может переместиться и следовательно может быть снова считана через курсор. Это результат того, что обновляющий курсор лишь логически создает результирующее множество. На самом деле это множество является подмножеством базовой таблицы, на основе которой получен курсор.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Открытие курсоров</td></tr></table></div>&nbsp;</p>
После объявления курсора его необходимо открыть, чтобы получить доступ к отдельным строкам. Открытие курсора состоит из вычисления оператора выбора, указанного в определении курсора, и формирования его результирующего множества. Операция открытия имеет следующий вид:</p>
&nbsp;</p>
open название_курсора</p>
&nbsp;</p>
После открытия курсор располагается перед первой строкой результирующего множества. Теперь можно использовать операцию fetch (загрузка) для считывания первой строки результирующего множества.</p>
SQL Сервер не позволяет открывать курсор, если он уже открыт или еще не объявлен. Можно снова открыть ранее закрытый курсор, чтобы вернуть курсор в начало результирующего множества.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Считывание строк данных с помощью курсоров</td></tr></table></div>&nbsp;</p>
После объявления и открытия курсора можно выбирать строки из результирующего множества с помощью команды fetch (загрузить, сдвинуть). Эта команда возвращает клиенту одну или несколько строк. Можно включить в эту команду Transact-SQL параметры или локальные переменные для сохранения возвращаемых данных.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Синтаксис оператора fetch</td></tr></table></div>&nbsp;</p>
Оператор fetch имеет следующий синтаксис:</p>
&nbsp;</p>
fetch название_курсора [into список_переменных]</p>
&nbsp;</p>
Например, после объявления и открытия курсора authors_crsr можно считать первую строку результирующего множества следующим образом:</p>
&nbsp;</p>
fetch authors_crsr</p>
&nbsp;</p>
au_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname</p>
---------------&nbsp;&nbsp; -------------------&nbsp;&nbsp;&nbsp;&nbsp; ---------------</p>
341-22-1782&nbsp;&nbsp; Smith&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Meander</p>
&nbsp;</p>
Каждый последующий оператор fetch выбирает следующую строку результирующего множества. Например:</p>
&nbsp;</p>
fetch authors_crsr</p>
&nbsp;</p>
au_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname</p>
--------------&nbsp;&nbsp; --------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ---------------</p>
527-72-3246&nbsp; Greene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Morningstar</p>
&nbsp;</p>
После прохода всех строк курсор будет указывать на последнюю строку результирующего множества. Если вновь попытаться выполнить команду fetch, то SQL Сервер выдаст предупреждающее сообщение о состоянии переменной sqlstatus (описанной далее), которая указывает на отсутствие данных. Позиция курсора при этом не изменится.</p>
Нельзя вновь прочитать строку, которая была уже пройдена, т.е. нельзя передвигаться по результирующему множеству в обратном направлении. Чтобы вернуться к началу, необходимо закрыть и затем вновь открыть результирующее множество, т.е. сгенерировать его снова.</p>
В конструкции into указываются переменные, в которых SQL Сервер должен сохранить возвращаемые данные. Список_переменных должен состоять из ранее объявленных Transact-SQL параметров или локальных переменных.</p>
Например, после объявления переменных @name, @city и @state можно сохранить в них поля строки, возвращаемой через курсор pubs_crsr:</p>
&nbsp;</p>
fetch pubs_crsr into @name, @city, @state</p>
&nbsp;</p>
SQL Сервер ожидает взаимно однозначного соответствия между переменными из списка и полями строки, возвращаемой через курсор. Типы&nbsp; переменных и параметров должны быть совместимы с типами данных столбцов&nbsp; результирующего множества.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Проверка состояния курсора</td></tr></table></div>&nbsp;</p>
SQL Сервер возвращает информацию о состоянии (статусе) курсора после каждого чтения (загрузки). Информацию о состоянии можно также получить через глобальную переменную @@sqlstatus. В следующей таблице перечислены возможные значения этой переменной и их смысл:</p>
&nbsp;</p>
Таблица 16-1: Значения переменной @sqlstatus</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Величина</p>
</td>
<td><p>Смысл</p>
</td>
</tr>
<tr>
<td><p>0</p>
</td>
<td><p>Указывает на успешное окончание оператора fetch.</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>Указывает на ошибочное завершение оператора fetch.</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>Указывает, что в результирующем множестве больше нет данных для чтения. Это предупреждение выдается, если курсор находится на последней строке и клиент выдает команду fetch.
</td>
</tr>
</table>
&nbsp;</p>
Следующий оператор определяет статус переменной @@sqlstatus для текущего открытого курсора authors_crsr:</p>
&nbsp;</p>
select @@sqlstatus</p>
&nbsp;</p>
-------------------</p>
0</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
Только оператор fetch может устанавливать переменную @@sqlstatus. Другие операторы не затрагивают эту переменную.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Проверка количества загруженных строк</td></tr></table></div>&nbsp;</p>
У SQL Сервера имеется также глобальная переменная @@rowcount. Она позволяет увидеть количество строк результирующего множества, возвращенных клиенту операторами fetch. Другими словами, в ней запоминается общее количество строк, просмотренных через курсор до текущего момента времени.</p>
После чтения всех строк результирующего множества значение переменной @@rowcount совпадает с общим числом строк в этом множестве. Заметим, что на каждый открытый курсор заводится своя переменная @@rowcount. Эта переменная удаляется вместе с удалением курсора. Проверка значения переменной @@rowcount позволяет определить общее число строк, считанных через курсор операторами fetch.</p>
В следующем примере определяется значение переменной @@rowcount для текущего открытого курсора authors_crsr:</p>
&nbsp;</p>
select @@rowcount</p>
&nbsp;</p>
-------------------</p>
1</p>
&nbsp;</p>
(Выбрана 1 строка)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Получение нескольких строк одним оператором fetch</td></tr></table></div>&nbsp;</p>
По умолчанию команда fetch позволяет получить одну строку данных за один раз. Пользователь может установить опцию cursor rows (курсорные строки), чтобы изменить число строк, возвращаемых одной командой fetch. Однако эта опция не влияет на операторы fetch, содержащие конструкцию into.</p>
Команда установки этой опции имеет следующий вид:</p>
&nbsp;</p>
set cursor rows число for название_курсора</p>
&nbsp;</p>
где параметр число указывает на число возвращаемых через курсор строк. По умолчанию этот парметр равен 1 для каждого объявленного курсора. Установку этой опции можно сделать и при открытом и при закрытом курсоре.</p>
Например, можно следующим образом изменить количество строк, возвращаемых через курсор authors_crsr:</p>
&nbsp;</p>
set cursor rows 3 for authors_crsr</p>
&nbsp;</p>
Теперь после каждого считывания оператор fetch будет возвращать три строки:</p>
&nbsp;</p>
fetch authors_crsr</p>
&nbsp;</p>
au_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------------&nbsp;&nbsp;&nbsp;&nbsp; ---------------</p>
648-92-1872&nbsp; Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reginald</p>
712-45-1867&nbsp; del Castillo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Innes</p>
722-51-5424&nbsp; DeFrance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Michel</p>
&nbsp;</p>
После считывания курсор будет расположен на последней переданной строке (в данном примере на авторе Michel DeFrance).</p>
Передача нескольких строк за один раз особенно удобна для приложений клиента. Если пользователь считывает более одной строки за раз, то Открытый Клиент или Встроенный SQL (Open Client or Embedded SQL) автоматически буферизуют строки, переданные приложению клиента. Клиент по-прежнему имеет построчный доступ к данным, но при выполнении операторов fetch обращение к SQL Серверу происходит реже, что повышает производительность системы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Обновление и удаление строк с помощью курсора</td></tr></table></div>&nbsp;</p>
Если курсор является обновляемым, то через него можно обновлять и удалять строки. SQL Сервер анализирует оператор выбора, определяющий курсор, чтобы выяснить можно ли обновлять через этот курсор. Можно также явно указать на обновляющий курсор с помощью предложения for update в операторе объявления курсора declare cursor. Дополнительную информацию по этому поводу можно посмотреть в разделе "Создание обновляемых курсоров".</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Удаление строк из результирующего множества курсора</td></tr></table></div>&nbsp;</p>
С помощью конструкции where current of в операторе delete можно удалять строку, где находится курсор. Если строка удаляется из результирующего множества, то она также удаляется из соответствующей базовой таблицы. С помощью курсора за один раз можно удалить только одну строку.</p>
Предложение delete... where current of имеет следующий синтаксис:</p>
&nbsp;</p>
delete [from] [[база_данных.]владелец.]{название_таблицы | название_вьювера}</p>
 &nbsp; &nbsp; &nbsp; &nbsp;where current of название_курсора</p>
&nbsp;</p>
Название таблицы или вьювера, указанные в этом предложении, должна совпадать с названием таблицы или вьювера, указанных в предложении from оператора выбора, определяющего курсор.</p>
Например, можно удалить строку, на которую указывает курсор authors_crsr с помощью следующего оператора:</p>
&nbsp;</p>
delete from authors</p>
where current of authors_crsr</p>
&nbsp;</p>
Ключевое слово from здесь можно не указывать.</p>
&nbsp;</p>
Замечание: Нельзя удалять строки с помощью курсора, который определен через соединение, даже если он объявлен как обновляемый.</p>
&nbsp;</p>
После удаление строки с помощью курсора SQL Сервер располагает курсор перед строкой, которая следует за удаленной строкой в результирующем множестве. Нужно по-прежнему использовать оператор fetch, чтобы получить доступ к следующей строке. Если была удалена последняя строка, то SQL Сервер располагает курсор за последней строкой результирующего множества.</p>
Например, после удаления строки в предыдущем примере (которая соответствует Мишелю ДеФрансу) можно просчитать следующие три строки результирующего множества следующим образом:</p>
&nbsp;</p>
fetch authors_crsr</p>
&nbsp;</p>
au_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname</p>
---------------&nbsp; -------------------&nbsp;&nbsp; ---------------</p>
807-91-6654&nbsp; Panteley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sylvia</p>
899-46-2035&nbsp; Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Anne</p>
998-72-3567&nbsp; Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Albert</p>
&nbsp;</p>
Конечно, можно удалить строку базовой таблицы и не обращаясь к курсору. Результирующее множество курсора будет изменяться в соответствии с изменением базовой таблицы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Обновление строк результирующего множества курсора</td></tr></table></div>&nbsp;</p>
Используя конструкцию where current of в операторе update, можно обновить содержимое строки, на которую указывает курсор. Каждое обновление результирующего множества курсора приводит к обновлению содержимого базовой таблицы, из которой получено множество курсора.</p>
Оператор update... where current of имеет следующий синтаксис:</p>
&nbsp;</p>
update [[база_данных.]владелец.]{название_таблицы | название_вьювера}</p>
 &nbsp;&nbsp; set [[[база_данных.]владелец.]{название_таблицы | название_вьювера}]</p>
 &nbsp; &nbsp; &nbsp; &nbsp;название_столбца1 = { выражение1 | NULL | (оператор_выбора)}</p>
 &nbsp;&nbsp;&nbsp;&nbsp; [, название_столбца2 = { выражение2 | NULL | (оператор_выбора)}] ...</p>
 &nbsp; &nbsp; &nbsp; &nbsp;where current of название_курсора</p>
&nbsp;</p>
В предложении set указываются названия столбцов и их новые (обновляемые) значения. Если здесь указывается несколько столбцов, то они должны разделяться запятыми.</p>
Название таблицы или вьювера, указанное в этом операторе, должно совпадать с названием таблицы или вьювера, указанным в предложении from оператора выбора, определяющего курсор. Если в предложении from указано несколько таблиц или вьюверов (в случае соединения), то можно указать только ту таблицу (вьювер), которая действительно обновляется.</p>
Например, можно обновить строку, на которую указывает курсор pubs_crsr, следующим образом:</p>
&nbsp;</p>
update publishers</p>
set city = "Pasadena",</p>
 &nbsp;&nbsp; state = "CA"</p>
where current of pubs_crsr</p>
&nbsp;</p>
После обновления позиция курсора остается неизменной. Можно продолжать обновление строки, на которую указывает курсор, до тех пор, пока другой SQL оператор не изменит позицию курсора.</p>
SQL позволяет обновлять столбцы базовой таблицы, которые не были указаны в списке столбцов оператора выбора, определяющего курсор. Однако, если в предложении for update указывается список столбцов, то обновлять можно содержимое только этих столбцов.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Закрытие и удаление курсора</td></tr></table></div>&nbsp;</p>
Когда работа с результирующем множеством закончена, курсор можно закрыть. Команда закрытия имеет следующий вид:</p>
&nbsp;</p>
close название_курсора</p>
&nbsp;</p>
Закрытие курсора не изменяет его определения. После этого можно вновь открыть курсор, тогда SQL Сервер создаст новое результирующее множество с помощью того же запроса. Например:</p>
&nbsp;</p>
close authors_crsr</p>
open authors_crsr</p>
&nbsp;</p>
После этого можно считывать данные через курсор authors_crsr, начиная с начала результирующего множества. Все условия, связанные с этим курсором (такие как число строк считываемых за один раз) остаются в силе.</p>
Например:</p>
&nbsp;</p>
fetch authors_crsr</p>
&nbsp;</p>
au_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_lname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_fname</p>
-----------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -------------------&nbsp;&nbsp; ---------------</p>
341-22-1782&nbsp; Smith&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Meander</p>
527-72-3246&nbsp; Greene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Morningstar</p>
648-92-1872&nbsp; Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp; Reginald</p>
&nbsp;</p>
Если курсор больше не нужен, то его следует удалить (deallocate). Синтаксис оператора deallocate имеет следующий вид:</p>
&nbsp;</p>
deallocate cursor название_курсора</p>
&nbsp;</p>
Удаление курсора освобождает все ресурсы с ним связанные, включая название курсора. Нельзя вновь использовать название курсора до тех пор, пока курсор не удален. Если удаляется открытый курсор, SQL Сервер автоматически закрывает его. По окончанию соединения пользователя с сервером также закрываются и удаляются все курсоры.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Примеры использования курсора</td></tr></table></div>&nbsp;</p>
Последующие примеры использования курсоров будут базироваться на следующем запросе:</p>
&nbsp;</p>
select author = au_fname + " " + au_lname, au_id</p>
from authors</p>
order by au_lname</p>
&nbsp;</p>
Результат этого запроса имеет следующий вид:</p>
&nbsp;</p>
author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_id</p>
------------------------------&nbsp;&nbsp; ----------------</p>
Abraham Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 409-56-7008</p>
Reginald Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp; 648-92-1872</p>
Cheryl Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 238-95-7766</p>
Michel DeFrance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 722-51-5454</p>
Ann Dull&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 427-17-2319</p>
Marjorie Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 213-46-8915</p>
Morningstar Greene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 527-72-3246</p>
Burt Gringlesby&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 472-27-2349</p>
Sheryl Hunter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 846-92-7186</p>
Livia Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 756-30-7391</p>
Chastity Locksley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 486-29-1786</p>
Stearns MacFeather&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 724-80-9391</p>
Heather McBadden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 893-72-1158</p>
Michael O'Leary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 267-41-2394</p>
Sylvia Panteley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 807-91-6654</p>
Anne Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 899-46-2035</p>
Albert Ringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 998-72-3567</p>
Meander Smith&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 341-22-1782</p>
Dick Straight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 274-80-9391</p>
Dirk Stringer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 724-08-9931</p>
Johnson White&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 172-32-1176</p>
Akiko Yokomoto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 672-71-3249</p>
Innes del Castillo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 712-45-1867</p>
&nbsp;</p>
В следующих пунктах показано как использовать курсор в этом запросе:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">1.</td><td>Сначала необходимо объявить курсор. В операторе declare курсор определяется с помощью вышеприведенного оператора выбора:</td></tr></table></div>&nbsp;</p>
declare newauthors_crsr cursor for</p>
select author = au_fname + " " + au_lname, au_id</p>
from authors</p>
order by au_lname</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="16">2.</td><td>После объявления курсор можно открыть:</td></tr></table></div>&nbsp;</p>
open newauthors_crsr</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="16">3.</td><td>Теперь можно считывать строки, используя курсор:</td></tr></table></div>&nbsp;</p>
fetch newauthors_crsr</p>
&nbsp;</p>
author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_id</p>
-------------------------&nbsp;&nbsp;&nbsp; ---------------</p>
Abraham Bennet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 409-56-7008</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">4.</td><td>Можно считывать несколько строк за один раз, установив число с помощью команды set:</td></tr></table></div>&nbsp;</p>
set cursor rows 5 for newauthors_crsr</p>
fetch newauthors_crsr</p>
&nbsp;</p>
author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_id</p>
-------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----------------</p>
Reginald Blotchet-Halls&nbsp;&nbsp;&nbsp;&nbsp; 648-92-1872</p>
Cheryl Carson&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 238-95-7766</p>
Michel DeFrance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 722-51-5454</p>
Ann Dull&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 427-17-2319</p>
Marjorie Green&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 213-46-8915</p>
&nbsp;</p>
Каждое последующее считывание будет сдвигать курсор еще на пять строк:</p>
&nbsp;</p>
fetch newauthors_crsr</p>
&nbsp;</p>
author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; au_id</p>
-------------------------&nbsp;&nbsp;&nbsp; -----------------</p>
Morningstar Greene&nbsp;&nbsp;&nbsp;&nbsp; 527-72-3246</p>
Burt Gringlesby&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 472-27-2349</p>
Sheryl Hunter&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 846-92-7186</p>
Livia Karsen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 756-30-7391</p>
Chastity Locksley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 486-29-1786</p>
&nbsp;</p>
5.&nbsp; После окончания работы с курсором его можно закрыть:</p>
&nbsp;</p>
close newauthors_crsr</p>
&nbsp;</p>
Закрытие курсора приводит к закрытию (releases) результирующего множества, но курсор остается определенным. Если его снова открыть командой open, то SQL Сервер снова выполняет запрос для формирования результирующего множества и устанавливает курсор перед первой строкой этого множества. По прежнему каждый оператор fetch будет считывать по пять строк.</p>
&nbsp;</p>
Для полного удаления курсора следует выполнить команду deallocate:</p>
&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp;deallocate cursor newauthors_crsr</p>
&nbsp;</p>
Нельзя использовать название курсора до тех пор, пока курсор не удален командой deallocate:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td> Курсоры в сохраненных процедурах</td></tr></table></div>&nbsp;</p>
Курсоры особенно полезны в сохраненных процедурах. С их помощью можно выполнить задание, требующее несколько запросов, всего одним запросом. Однако, все операции с курсором должны быть выполнены в одной процедуре. В сохраненной процедуре нельзя открывать, считывать или закрывать курсор, который не был объявлен в этой процедуре. Курсор не определен за пределами области действия (scope) сохраненной процедуры.</p>
Например, следующая сохраненная процедура au_sales проверяет таблицу продаж, чтобы определить, продается ли у данного автора достаточно хорошо хотя бы одна книга:</p>
&nbsp;</p>
create procedure au_sales (@author_id id)</p>
as</p>
/* declare local variables used for fetch */</p>
declare @title_id tid</p>
declare @title varchar(80)</p>
declare @ytd_sales int</p>
declare @msg varchar(120)</p>
&nbsp;</p>
/* declare the cursor to get each book written by given author */</p>
declare author_sales cursor for</p>
select ta.title_id, t.title, t.total_sales</p>
from titleauthor ta, titles t</p>
where ta.title_id = t.title_id</p>
and ta.au_id = @author_id</p>
&nbsp;</p>
open author_sales</p>
&nbsp;</p>
fetch author_sales</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; into @title_id, @title, @ytd_sales</p>
&nbsp;</p>
if (@@sqlstatus = 2)</p>
begin</p>
 &nbsp;&nbsp; print "We do not sell books by this author."</p>
 &nbsp;&nbsp; close author_sales</p>
 &nbsp;&nbsp; return</p>
end</p>
&nbsp;</p>
/* if cursor result set is not empty, then process each row of information */</p>
while (@@sqlstatus = 0)</p>
begin</p>
 &nbsp;&nbsp; if (@ytd_sales = NULL)</p>
 &nbsp;&nbsp; begin</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; select @msg = @title +</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " had no sales this year."</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print @msg</p>
 &nbsp;&nbsp; end</p>
 &nbsp;&nbsp; else if (@ytd_sales &lt; 500)</p>
 &nbsp;&nbsp; begin</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; select @msg = @title +</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " had poor sales this year."</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print @msg</p>
 &nbsp;&nbsp; end</p>
 &nbsp;&nbsp; else if (@ytd_sales &lt; 1000)</p>
 &nbsp;&nbsp; begin</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; select @msg = @title +</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " had mediocre sales this year."</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print @msg</p>
 &nbsp;&nbsp; end</p>
 &nbsp;&nbsp; else</p>
 &nbsp;&nbsp; begin</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; select @msg = @title +</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " had good sales this year."</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print @msg</p>
 &nbsp;&nbsp; end</p>
 &nbsp;&nbsp; fetch author_sales into @title_id, @title,</p>
 &nbsp;&nbsp; @ytd_sales</p>
end</p>
&nbsp;</p>
/* if error occurred, call a designated handler */</p>
if (@@sqlstatus = 1) exec error_handle</p>
close author_sales</p>
deallocate cursor author_sales</p>
return</p>
&nbsp;</p>
Дополнительную информацию о сохраненных процедурах можно получить в главе 14 "Использование сохраненных процедур".</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Курсоры и блокировка</td></tr></table></div>&nbsp;</p>
Методы блокировки при работе с курсором аналогичны обычным методам блокировки для SQL Сервера. Вообще говоря, операторы, считывающие данные (такие как select или readtext), используют разделяющую (shared) блокировку каждой страницы данных, чтобы предотвратить изменение данных со стороны неподтвержденных транзакций. Операторы обновления используют исключающую (exclusive) блокировку каждой страницы, которую они изменяют. Чтобы уменьшить вероятность тупиков (deadlocks) и улучшить производительность, SQL Сервер часто предваряет исключающую блокировку обновляющей блокировкой, которая указывает, что клиент собирается изменить данные на странице.</p>
Для обновляющих курсоров SQL Сервер использует по умолчанию обновляющую блокировку при просмотре таблиц и вьюверов, указанных в предложении for update оператора declare cursor. Если предложение for update включено, но список таблиц пуст, то при обращении ко всем таблицам и вьюверам, указанным в предложении from оператора select, по умолчанию устанавливается обновляющая блокировка. Если предложение for update не указано, то при обращении ко всем таблицам и вьюверам устанавливается разделяющая блокировка. Чтобы использовалась разделяющая блокировка вместо обновляющей, необходимо добавить ключевое слово shared в предложении from. В частности, можно добавить слово shared к названию таблицы, для которой предпочтительна разделяющая блокировка.</p>
Информация о блокировках SQL Сервера дается в Руководстве системного администратора SQL Сервера. Дополнительную информацию о курсорах и блокировках можно посмотреть в Справочном руководстве SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Получение информации о курсорах</td></tr></table></div>&nbsp;</p>
SQL Сервер предоставляет системную процедуру sp_cursorinfo, которая дает информацию о названии курсора, его текущем состоянии (таком как открыт или закрыт) и столбцах результирующего множества. В следующем примере дается информация о курсоре authors_crsr:</p>
&nbsp;</p>
sp_cursorinfo 0, authors_crsr</p>
&nbsp;</p>
Cursor name 'authors_crsr' is declared at nesting level '0'.</p>
The cursor id is 327681</p>
The cursor has been successfully opened 1 times</p>
The cursor was compiled at isolation level 1.</p>
The cursor is not open.</p>
The cursor will remain open when a transaction is committed or rolled back.</p>
The number of rows returned for each FETCH is 1.</p>
The cursor is updatable.</p>
There are 3 columns returned by this cursor.</p>
&nbsp;</p>
The result columns are:</p>
Name = 'au_id', Table = 'authors', Type = ID,</p>
 &nbsp;&nbsp; Length = 11 (updatable)</p>
Name = 'au_lname', Table = 'authors', Type =</p>
 &nbsp;&nbsp; VARCHAR, Length = 40 (updatable)</p>
Name = 'au_fname', Table = 'authors', Type =</p>
 &nbsp;&nbsp; VARCHAR, Length = 20 (updatable)</p>
&nbsp;</p>
