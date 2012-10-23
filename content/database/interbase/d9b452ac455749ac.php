<h1>InterBase для программиста</h1>
<div class="date">01.01.2007</div>


<p>InterBase для программиста</p>

<p>коряво перевел Хаос</p>

<p>Работа с базой данных</p>

<p>Для подключения, отключения, и информации о базе данных IB предоставляет пять функций.</p>
<p>Следующая таблица показывает API для работы с БД. Функции напечатаны в порядке их обычного появления в приложении.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>isc_expand_dpb()</p>
</td>
<td><p>Определяет дополнительные параметры для доступа к БД, типа имени пользователя и пароля, использует предварительно объявленный и заполненный DPB</p>
</td>
</tr>
<tr>
<td><p>isc_attach_database()</p>
</td>
<td><p>Соединяется с БД и инициализирует параметры для доступа к БД, типа числа буферов кэша для использования; использует объявленный и заполненный DPB</p>
</td>
</tr>
<tr>
<td><p>isc_database_info()</p>
</td>
<td><p>Запрашивает информацию о подключенной БД, типа версии дисковой структуры(ODS) и др.</p>
</td>
</tr>
<tr>
<td><p>isc_detach_database()</p>
</td>
<td><p>Отключает от подключенной БД и освобождает системные ресурсы связанные с подключением</p>
</td>
</tr>
<tr>
<td><p>isc_drop_database()</p>
</td>
<td><p>Удаляет БД и все поддерживаемые файлы, типа теневого файла
</td>
</tr>
</table>
Соединение с БД</p>
<p>Подключение к одной или нескольким БД состоит из четырех шагов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Создание и инициализация&nbsp; дескриптора БД для каждой подключаемой БД</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Создание и заполнение DPB(буфер параметров БД) для каждой подключаемой БД</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Вызов isc_expand_dpb() до подключения к БД для предварительного создания и заполнения DPB (если лень заполнять его руками).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td> Вызов isc_attach_database() для каждой БД к которой будете подключаться</td></tr></table></div>
<p>Рассмотрим все это детально по шагам.</p>
<p>1. Создание дескриптора БД</p>
Каждая БД, которая используется приложением должна быть связана с некоторым уникальным целым числом -&nbsp; дескриптором БД, это число идентификатор БД, его возвращает при подключении к БД функция isc_attach_database(). Заголовочный файл&nbsp; ibase.h содержит следующее объявление дескриптора БД:</p>
<p>typedef void ISC_FAR *isc_db_handle;</p>
<p>используйте этот тип для объявления дескриптора БД.</p>
<p>Пример, обьявление дескриптора БД:</p>
<p>#include &lt;ibase.h&gt;</p>
<p>. . .</p>
<p>isc_db_handle db1;</p>
<p>isc_db_handle db2;</p>
<p>/*</p>
<p> дескриптор должен быть установлен в 0 перед использованием,&nbsp; иначе</p>
<p>isc_attach_database() вернет код ошибки</p>
<p>*/</p>
<p>. . .</p>
<p>db1 = 0L;</p>
<p>db2 = 0L;</p>
<p>Далее для каждого подключения, в зависимости от целей программиста нужны какие-то параметры, для хранения и передачи серверу этих параметров служит буфер параметров БД (DPB). О нем и пойдет речь ниже.</p>
<p>2. Создание и заполнение DPB</p>
<p>DPB это обычный char массив объявленный в приложении, который следующую структуру:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Первый байт, определяет версию буфера параметров,&nbsp;&nbsp; и равен определенной в ibase.h константе isc_dpb_version1.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Далее идет длинный ряд состоящий из одного или нескольких&nbsp; кластеров байт. Каждый&nbsp; кластер описывает отдельный параметр.</td></tr></table></div>
<p>Кластер состоит в свою очередь из нескольких частей:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Первый байт кластера определяет параметр который будет описываться далее в кластере. Этот байт равен одной из констант &#8211; идентификаторов параметров объявленных в ibase.h&nbsp; (например, константа isc_dpb_num_buffers говорит, что после нее последует определение числа буферов кэша БД).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Второй байт кластера содержит число, определяющее размер параметра в байтах.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Далее следует сам параметр который может занимать несколько байт. Число этих байт и указывает предыдущий байт. (это может быть, например, число или строка символов, \0 не считается для строки символов и не входит в строковый параметр).</td></tr></table></div>
<p>К примеру, следующий код создает DPB c одним параметром, который описывает число буферов кэша, используемых при соединении с БД.</p>
<p>char dpb_buffer[256], *dpb,;</p>
<p>short dpb_length;</p>
<p>/* Создание буфера параметров базы данных. */</p>
<p>dpb = dpb_buffer;/*длина буфера*/</p>
<p>dpb++ = isc_dpb_version1; /* версия буфера параметров БД */</p>
<p>dpb++ = isc_num_buffers; /*говорит что далее пойдет описание параметра числа буферов*/</p>
<p>dpb++ = 1; /* в кластере остается 1 байт */</p>
<p>dpb++ = 90; /*&nbsp; этот байт содержит число 90 */</p>
<p>dpb_length = dpb - dpb_buffer;/*длина буфера */</p>
<p>Обратите внимание: Все числа в буфере параметров базы данных должны быть представлены в универсальном формате, сначала идет самый младший байт, потом старшие по возрастанию. Числа со знаком должны иметь признак знака в последнем байте (старшем). Можно использовать функцию isc_vax_integer () которая меняет порядок байт на обратный (см. Приложение) .</p>
<p>Следующая таблица содержит константы идентификаторов параметров, которые можно передать в&nbsp; DPB для получения каких &#8211; то специфических характеристик соединения с БД</p>
Идентификация пользователя</p>
<p>Имя пользователя &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; isc_dpb_user_name</p>
<p>Пароль  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; isc_dpb_password</p>
<p>Зашифрованный пароль &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; isc_dpb_password_enc</p>
<p>Название роли &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dpb_sql_role_name</p>
<p>Имя администратора системной БД  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dpb_sys_user_name</p>
<p>Авторизированный ключ для лицензии  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_license</p>
<p>Зашифрованный ключ БД  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_encrypt_key</p>
Управление средой</p>
<p>Число буферов кэша  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_num_buffers</p>
<p>dbkey context scope &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; isc_dpb_dbkey_scope</p>
Управление системой</p>
<p>Синхронная&nbsp; или асинхронная запись в БД &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; isc_dpb_force_write</p>
<p>(т.е. писать на диск сразу, или покоптить в памяти)</p>
<p>Определяет резервировать или нет небольшое место&nbsp;</p>
<p>на каждой странице БД для хранения старых версий</p>
<p> модифицированных записей когда модификации уже сделаны  &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_no_reserve</p>
<p>Определяет, должна БД быть помечена как поврежденная или нет &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_damaged</p>
<p>Выполнять последовательно проверку внутренних структур &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_verify</p>
Управление теневым файлом БД</p>
<p>Активизировать теневой файл БД, который необязателен, но является</p>
<p> синхро-копией БД &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_activate_shadow</p>
<p>Удалять теневой файл БД &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_delete_shadow</p>
Управление системой регистрациии</p>
<p>Активизировать управление системой регистрации, для слежения</p>
<p>за всеми запросами к БД &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_begin_log</p>
<p>Деактивировать систему регистрации &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_quit_log</p>
Спецификация файла сообщений и символьной кодировки</p>
<p>Языковая спецификация файла сообщений &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_lc_messages</p>
Используемая кодировка &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_lc_ctype</p>
<p>Следующая таблица показывает DPB параметры в алфавитном порядке.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Параметр</p>
</td>
<td><p>Назначение</p>
</td>
<td><p>Длина</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_activate_shadow</p>
</td>
<td><p>Директива активации теневого файла БД, синхрокопии БД,&nbsp; которая необязательна.</p>
</td>
<td><p>1(Игнорируется)</p>
</td>
<td><p>0(Игнорируется)</p>
</td>
</tr>
<tr>
<td>isc_dpb_damaged</p>
</td>
<td><p>Число определяющее помечать или нет БД как поврежденную</p>
<p>1 = помечать как поврежденную</p>
<p>0 = непомечать</p>
</td>
<td>
<p>1</p>
</td>
<td>
<p>0 или 1</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_dbkey_scope</p>
</td>
<td><p>Scope of dbkey context. 0 limits scope to the current1 transaction, 1 extends scope to the database session</p>
</td>
<td>
<p>1</p>
</td>
<td>
<p>0 или 1</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_delete_shadow</p>
</td>
<td><p>Указание удалить теневой файл БД который больше не нужен</p>
</td>
<td><p>1(Игнорируется)</p>
</td>
<td><p>0(Игнорируется)</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_encrypt_key</p>
</td>
<td><p>Строка шифрования ключа, до 255 байт</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая ключ</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_force_write</p>
</td>
<td><p>Определяет синхронная или асинхронная запись будет в БД</p>
<p>0 = асинхронная</p>
<p>1 =синхронная</p>
</td>
<td><p>1</p>
</td>
<td><p>0 или 1</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_lc_ctype</p>
</td>
<td><p>Строка опрделяющая набор символов для использования</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержит название набора символов</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_lc_messages</p>
</td>
<td><p>Строка определяющая язык файла сообщений</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая название файла сообщеней</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_license</p>
</td>
<td><p>Строка содержащая ключ к программной лицензии</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая ключ</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_no_reserve</p>
</td>
<td><p>Определяет резервировать или нет немного места на каждой странице БД для хранеия устаревших версий записей которые были модифицированы. keep backup versions on the same page as the primary record to optimize update activity</p>
<p>0(по умолчанию) = резервировать</p>
<p>1= не резервировать</p>
</td>
<td><p>1</p>
</td>
<td><p>0 или 1</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_num_buffers</p>
</td>
<td><p> Число буферов кэша выделенных для использования с БД;</p>
<p>По умолчанию 75</p>
</td>
<td><p>1</p>
</td>
<td><p>Число выделенных буферов</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_password</p>
</td>
<td><p>Строка пароля, до 255 символов</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая пароль</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_password_enc</p>
</td>
<td><p>Строка шифрованного пароля, до 255 символов</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая пароль</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_sys_user_name</p>
</td>
<td><p>Строка системного DBA, до 255 символов</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая имя SYSDBA</p>
</td>
</tr>
<tr>
<td><p>isc_dpb_user_name</p>
</td>
<td><p>Строка имени пользователя, до 255 символов</p>
</td>
<td><p>Число байт в строке</p>
</td>
<td><p>Строка содержащая имя пользователя
</td>
</tr>
</table>

<p>3. Добавление параметров к DPB(раздел не отработан)</p>
<p>Иногда требуется добавить параметры в уже существующий DPB во время выполнения. К примеру, когда приложение запущено, и нужно определить имя пользователя и пароль и внести эти значения динамически. Функция isc_expand_dpb()  может быть использована для передачи дополнительных параметров в созданный DPB&nbsp; во isc_dpb_lc_ctypeвремя выполнения. Это параметры isc_dpb_user_name, isc_dpb_password, isc_dpb_lc_messages. Но isc_expand_dpb() автоматически не освобождает выделенное место в памяти при отключении от БД. Функция требует следующих параметров:</p>
Параметр &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;тип &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Описание</p>
<p>dpb &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char** &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Указатель на DPB</p>
<p>dpb_size &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;unsigned short* &nbsp; &nbsp; &nbsp; &nbsp;Указатель на текущий размер DPB в байтах</p>
… &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char* &nbsp; &nbsp; &nbsp; &nbsp;Указатели на тип элемента и элемент добавляемый к DPB</p>
<p>Третий параметр в таблице, « . . .», показывает переменное число вводимых параметров, с различными именами,&nbsp; но каждый из которых указывает на char.</p>
<p>Следующий код демонстрирует как вызываемая функция isc_expand_dpb() добавляет имя пользователя и пароль&nbsp; DPB после того как пользователь вводит их во время выполнения</p>
<pre>char dpb_buffer[256], *dpb, *p;
char uname[256], upass[256];
short dpb_length;
/* Создание параметров буфера DPB. */
dpb = dpb_buffer;
*dpb++ = isc_dpb_version1;
*dpb++ = isc_dpb_num_buffers;
*dpb++ = 1;
*dpb++ = 90;
dpb_length = dpb - dpb_buffer;
/* Спрашиваем пользователя о имени и пароле */
prompt_user("Enter your user name: ");
gets(uname);
prompt_user("\nEnter your password: ");
gets(upass);
/* Добавляем введенное к DPB. */
dpb = dbp_buffer;
isc_expand_dpb(&amp;dpb, &amp;dpb_length,
isc_dpb_user_name, uname,
isc_dpb_password, upass,
NULL);
</pre>

<p>4. Подключение к БД</p>
<p>После создания и инициализации дескриптора БД, и небязательных установок в DPB, определяющих параметры соединения, используется функция&nbsp; isc_attach_database() для подключения к существующей БД. Помимо распределения ресурсов системы для соединения с БД эта функцияя связывает определенную БД с дескриптором БД для последующего его использования в других API вызовах.&nbsp;</p>
<p>isc_attach_database() требует 6 параметров&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Указатель на вектор ошибки, откуда можно узнать ошибках если они были.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Длина в байтах имени БД для открытия БД. Если имя БД включает имя и путь, указывается их общая длина.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Строка содержащая имя БД для подключения. Имя может включать имя БД и путь к ней.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Указатель на дескриптор БД .</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Длина в байтах DPB. Если DPB остался по умолчанию то, устанавливается в 0.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Указателъ на DPB. Если DPB остался по умолчанию то, устанавливается в NULL.</td></tr></table></div>
<p>Каждая БД требует отдельного вызова isc_attach_database().</p>
<p>Следующий код показывает подключение к демо базе xsample.gdb.</p>
<pre>
#include &lt;stdio.h&gt;
#include &lt;stdlib.h&gt;
#include &lt;string.h&gt;
#include &lt;time.h&gt;
#include &lt;ibase.h&gt;
 
isc_db_handle db;
ISC_STATUS status_vector[20];
short dpb_buf_len=20;
char dpb_buf[]={
                                isc_dpb_version1,                //версия буфера 
                                isc_dpb_user_name,                //начинается кластер параметра имя пользователя
                                6,                                 //длина этого параметра 6 байт
                                'S','Y','S','D','B','A',                //строка имени пользователя
                                isc_dpb_password,                //начинается кластер пароля пользователя
                                9,                                 //длина его 9 байт
                                'm','a','s','t','e','r','k','e','y'        //сам пароль
                };
 
int main()
{
 char str[]="c:\\Doc\\Ibgpre\ibmake\\xsample.gdb";
 
 isc_attach_database(status_vector, strlen(str), str, &amp;db,dpb_buf_len,dpb_buf);
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])
 {
   isc_print_status(status_vector);        //печать информации по ошибке
 }
 if(db)
  isc_detach_database(status_vector, &amp;db);
 
 return 0;
}
</pre>

<p>Запрос информации о подключении</p>
<p>После подключения к БД можно узнать информацию о соединении. Вызов функции isc_database_info() возвращает информацию о соединении, а также о версии дисковой структуры (ODS) используемой соединением, о числе выделенных буферов кэша, о числе страниц БД читаемых или записываемых, и т.д.</p>
<p>В дополнение к указателю на вектор ошибки и дескриптора БД, isc_database_info()&nbsp; требует двух буферов предоставляемых приложением, буфер запроса, где приложение определяет какая&nbsp; информация ему нужна, и буфер результата, куда InterBase возвращает затребованную информацию. Приложение заполняет буфер запроса до вызова isc_database_info(), и передает ей указатель на буфер запроса и также размер в байтах этого буфера.</p>
<p>Приложение должно создать буфер результата достаточного размера, куда IB вернет информацию, и передать функции указатель на буфер и его размер в байтах. Если IB возвращает больше информации, чем буфер может принять, то в последний байт буфера пишется число соответствующее константе&nbsp; isc_info_truncated.&nbsp;&nbsp;&nbsp;</p>
<p>Элементы буфера запроса и значения буфера результата</p>
<p>Буфер запроса это символьный массив в каждый элемент которого заносятся значения определяющие какая информация будет возвращена. Каждый байт это параметр, информацию о котором мы хотим получить. Константы связанные с каждым таким параметром&nbsp; определены в ibase.h.</p>
<p>Буфер результата содержит после выполнения функции серию кластеров информации, каждый кластер состоит из трех частей.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Первый байт определяет информация о каком параметре содержится в этом кластере, он равен одной из констант определенных в ibase.h и уже описанных выше.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Далее идут два байта &#8211; содержащие число равное числу байт оставшихся до конца кластера, фактически размер значения параметра в байтах.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>И наконец идет само значение занимающее столько байт сколько определено предыдущими двумя байтами. (это может быть число или строка )</td></tr></table></div>&nbsp;</p>
<p>Пример:</p>
<p>Вот так выглядит буфер результата после запроса&nbsp; информации&nbsp; о размере страницы БД</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>isc_info_page_size</p>
</td>
<td colspan="2" ><p>Число байт до конца кластера (4 байта)</p>
</td>
<td colspan="4" ><p>Число 1024</p>
</td>
<td><p>Символ конца буфера</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>2</p>
</td>
<td><p>3</p>
</td>
<td><p>4</p>
</td>
<td><p>5</p>
</td>
<td><p>6</p>
</td>
<td><p>7</p>
</td>
<td><p>8</p>
</td>
</tr>
<tr>
<td><p>0х0E</p>
</td>
<td><p>0x04</p>
</td>
<td><p>0x00</p>
</td>
<td><p>0x00</p>
</td>
<td><p>0x04</p>
</td>
<td><p>0x00</p>
</td>
<td><p>0x00</p>
</td>
<td><p>0x01
</td>
</tr>
</table>
<p>Кластеры записанные в&nbsp; буфер результатов не выровнены. Кроме того все числа представлены в универсальном формате(сначала младший байт, потом более&nbsp; старший). Числа со знаком имеют признак знака в старшем байте. Преобразовывайте эти числа к типу присущему вашей системе, можно также для конвертации воспользоваться функцией isc_vax_integer() меняющей порядок байт.</p>
<p>Характеристики БД</p>
<p>Следующая таблица перечисляет параметры БД информацию о которых можно получить вызвав&nbsp; isc_database_info() , при добавлении в буфер запроса к параметрам добавляется префикс isc_info_</p>
Элементы буфера запроса &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Содержание буфера результата</p>
<p>allocation &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Число страниц зарезервированных БД</p>
<p>base_level &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Версия БД &nbsp; &nbsp; &nbsp; &nbsp;</p>
- 1 байт содержит число 1</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - 1 байт содержит номер версии</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">db_id</td><td>Имя файла базы данных и название местоположения</td></tr></table>• 1 байт, содержит число 2 для локального подключения или 4 для удаленного подключения</p>
• 1 байт, содержит длину&nbsp; d, имени файла базы данных в байтах</p>
• Строка d байтов, содержит имя файла базы данных</p>
• 1 байт, содержит длину l, названия местоположения&nbsp; в байтах</p>
• строка l байтов, содержит название местопоожения</p>
<p>implementation &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Число выполнения базы данных:</p>
• 1 байт, содержит 1</p>
• 1 байт, содержит номер выполнения</p>
• 1 байт, содержащий номер “класса”, или 1 или&nbsp;&nbsp; 12</p>
<p>no_reserve &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;0 или 1</p>
• 0 указывает, что часть места зарезервировано на каждой странице базы данных для хранения резервных версий изменяемых записей [По умолчанию]</p>
• 1 указывает, что не надо резервировать место для таких записей</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">ods_minor_version</td><td>Младший номер версии дисковой структуры (ODS); увеличение в младшем номере версии указывает на не-структурное изменение, оно все еще позволяет базе данных быть доступной ядрам&nbsp; баз данных с тем же самым главным номером версии, но с различными младшими номерами версии ODS</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="330">ods_version</td><td>Старший номер версии ODS ; базы данных с различными старшими номерами версий имеют различные физические&nbsp; структуры,&nbsp; ядро базы данных может обращаться только к базам данных с одинаковым старшим номером версии ODS; попытка присоединяться к базе данных с различными старшими ODS номерами приводит к ошибке</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="330">page_size</td><td>Размер страницы в&nbsp; байтах в подключенной базе данных; используйте с isc_info_allocation, чтобы определить размер базы данных</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="330">version</td><td> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Строка идентификации версии данной базы данных:?</td></tr></table>• 1 байт, содержит число 1</p>
• 1 байт, определяет длину n, следующей строки</p>
• n байт, содержат строку идентификации версии</p>
&nbsp;</p>
<p>Параметры среды</p>
<p>Предоставляются несколько элементов для определения характеристик окружающей среды, - используемый в настоящее время объем памяти, или число буферов кэшей базы данных, выделенный в данный момент времени. Эти элементы описаны в следующей таблице:</p>
Запрос буферного элемента &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Содержание буфера результата</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">current_memory</td><td>Размер памяти&nbsp; (в байтах) используемый сервером в настоящее время:</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">forced_writes</td><td>Число, определяющее режим записи&nbsp; данных на диск (0 для асинхронного, 1 для синхронного)</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">max_memory</td><td>Максимальный объем памяти (в байтах) используемый сервером начиная с первого процесса подключенного базе данных</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">num_buffers</td><td>Число буферов памяти выделенной в данный момент времени (в страницах)</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">sweep_interval</td><td>Число транзакций, которые завершились подтверждением между “sweeps”(чистками мусора) , удаляющего версии записей базы данных которые больше не нужны</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="283">user_names</td><td>Имена всех пользователей в настоящее время подключенных к базе данных; для каждого такого пользователя, буфер результатов содержит байт isc_info_user_names, следующий байт&nbsp; определяет число байтов приходящихся на имя пользователя, и далее следует имя пользователя</td></tr></table>
<p>Обратите внимание: Не все параметры среды&nbsp; доступны на всех платформах.</p>
<p>Статистика работы сервера БД.</p>
<p>Существуют четыре параметра, которые характеризуют статистику работы базы данных. Эта статистика накапливается для базы данных с момента, первого подключения к БД любым процессом, и продолжается до тех пор пока последний&nbsp; процесс не будет отключен от базы данных.</p>
<p>Например, значение возвращенное для isc_info_reads - это число чтений с момента первого подключения к данной базе данных, то есть он содержит все чтения выполняемые всеми подключенными процессами, а не число чтений выполненое вызвавшей&nbsp; isc_database_info() программой, подключенной к данной базе данных.</p>
Следующая таблица&nbsp; содержит параметры статистики работы БД:</p>
&nbsp;</p>
Элемент буфера запроса &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Содержание буфера результата</p>
<p>fetches &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Число чтений из памяти буфера кэша</p>
<p>marks &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Число записей в память буфера кэша</p>
<p>reads &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Число читаемых страниц</p>
writes &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Число записываемых страниц</p>
<p>Счетчики операций базы данных</p>
<p>Несколько информационных параметров предоставляют возможность для определения числа различных операций над базой данных, выполненных в текущем подключении вызовами программы. Эти значения вычисляются на основание таблицы(per-table)</p>
<p>Когда любой из этих информационных параметров затребован, IB возвращает буфер результата имеющий вид:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 28px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>1 байт определяет что за параметр возвратился (например, isc_info_insert_count).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 28px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>2 байта , сообщающие, сколько байт составляют следующая пара значений.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 28px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Пара значений для каждой таблицы в базе данных, в которой произошел требуемый тип операции начиная с момента последнего подключения к БД.</td></tr></table></div>Каждая пара состоит из:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 52px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>2 байта определяют ID таблицы</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 52px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>4 байта показывают число операций (к примеру, вставки) произведенных над таблицей</td></tr></table></div><p>Совет: чтобы определить настоящее имя таблицы из ID таблицы&nbsp; выполните запрос к системной таблице, RDB$RELATION.</p>
<p>Следующая таблица описывает параметры, которые возвращают значения счетчиков операций над базой данных:</p>
Элемент буфера запроса &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Содержание буфера результата</p>
<p>backout_count &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Число удалений версии записи(?)</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">delete_count</td><td>Число операций удаления с момента последнего подключения к БД</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">expunge_count</td><td>Число удалений записи и всех ее предыдущих версий, для записей чьи удаления&nbsp; были потверждены</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">insert_count</td><td>Число операций вставки в БД с момента последнего подключения к БД</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">purge_count</td><td>Число удалений старых версий полностью готовых записей (записи, которые подтверждены, так чтобы более старые версии больше не были необходимы)</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">read_idx_count</td><td>Число чтений выполненных по индексу, с момента последнего подключения</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">read_seq_count</td><td>Число последовательных просмотров таблицы (чтение строк) сделанные для каждой таблицы, с момента последнего подключения к БД</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">update_count</td><td>Число обновлений БД с момента последнего подключения к БД</td></tr></table>
<p>Пример вызова isc_database_info()</p>
<p>Следующий код запрашивает размер страницы и число буферов кэша для подключенной БД, затем анализирует буфер результатов:</p>
<pre>
#include &lt;stdio.h&gt;
#include &lt;stdlib.h&gt;
#include &lt;string.h&gt;
#include &lt;time.h&gt;
#include &lt;ibase.h&gt;
 
isc_db_handle db;
ISC_STATUS status_vector[20];
short dpb_buf_len=20;
 
char dpb_buf[]={
                    isc_dpb_version1,        //версия буфера 
                    isc_dpb_user_name,        //начинается кластер параметра имя пользователя
                    6,                            //длина этого параметра 6 байт
                    'S','Y','S','D','B','A',//строка имени пользователя
                    isc_dpb_password,            //начинается кластер пароля пользователя
                    9,                                                 //длина его 9 байт
                   'm','a','s','t','e','r','k','e','y'        //сам пароль
                  };
 
int main()
{
 char str[]="c:\\Doc\\Ibgpre\\ibmake\\xsample.gdb";
 
isc_attach_database(status_vector, strlen(str), str,&amp;db,dpb_buf_len,dpb_buf);
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])
 {
          isc_print_status(status_vector);
 }
 
 //обьявляем и заполняем буфер запроса о информации
 char db_items[] = {
                           isc_info_page_size,  //информация о размере страницы
                    isc_info_num_buffers,//информация о числе буферов кэша
                    isc_info_end                 //конец буфера
                   };
 char res_buffer[40], *p, item;
 int length;
 long page_size = 0L, num_buffers = 0L;
 
 isc_database_info(status_vector,&amp;db, 
                   sizeof(db_items),
                   db_items,sizeof(res_buffer),
                   res_buffer);
 if (status_vector[0] == 1 &amp;&amp; status_vector[1]) 
 {
  /* Для ошибок */
          isc_print_status(status_vector);
          return(1);
 }
        /* Выделяет значения возвращенные в буфере результатов. */
 for (p = res_buffer; *p != isc_info_end ; ) 
 {
          item = *p++;
          length = isc_vax_integer(p, 2);
          p += 2;
          switch (item)
          {
             case isc_info_page_size:
             page_size = isc_vax_integer(p, length);
             break;
                   case isc_info_num_buffers:
            num_buffers = isc_vax_integer(p, length);
            break;
             default:
            break;
          }
          p += length;
 }
 printf("page_size=%d\nnum_buffers=%d\n",page_size,num_buffers);
 
 if(db)
  isc_detach_database(status_vector, &amp;db);
 
 return 0;
}
</pre>
<p>Отключение от БД</p>
<p>Просто вызываем isc_detach_database(status_vector, &amp;db)(см.пример выше); &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>И все ресурсы освободятся, а дескриптор станет 0L</p>
<p>Удаление БД</p>
<p>Пример говорит сам за себя</p>
<pre>
. . .
isc_db_handle db;
char *str = "xsample.gdb";
ISC_STATUS status_vector[20];
. . .
db = 0L;
/* Сначала соединяемся? чтобы получить дескриптор. */
isc_attach_database(status_vector, strlen(str), str, &amp;db, 0, NULL);
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
  error_exit();
}
isc_drop_database(status_vector, &amp;db1);/* вот тут удаляем БД */
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
  error_exit();
}
. . .
</pre>

<p>Использование транзакций</p>
<p>Эта глава описывает как формировать буфер параметров транзакции (TPB), как обьявлять и инициализировать дескриптор транзакций, и&nbsp; как использовать API функции которые управляют транзакциями. Также объясняется как получать ID транзакции.</p>
<p> Все определения данных и манипуляции данными в приложении происходят в контексте одной или нескольких транзакций, состоящих из одной или нескольких инструкций, которые работают вместе до полного завершения определенного&nbsp; набора действий, и являются элементарной единицей работы.</p>
<p>В следующей таблице показаны API функции используемые при работе с транзакциями. Они описаны в том порядке, в каком обычно применяются в приложении.</p>
Функция &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Описание</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">isc_start_transaction()</td><td>Начинает новую транзакцию с одной или&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; несколькими БД; использует предварительно объявленный и заполненный TPB</td></tr></table><p>isc_commit_retaining()&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Потверждает изменения произведенные транзакцией</p>
и сохраняет контекст для дальнейшей обработки транзакции (то есть не заканчивает транзакцию. прим.пер)</p>
<p>isc_commit_transaction() &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Подтверждает изменения произведенные транзакцией</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;, и заканчивает транзакцию.</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 2px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 1px 1px 2px 0px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">isc_rollback_transaction()</td><td>Производит откат изменений внесенных транзакцией, и заканчивает транзакцию</td></tr></table>&nbsp;</p>
В дополнение к этим функциям, следующая таблица содержит редко используемые API</p>
ф-ии управляющие транзакциями в порядке их обычного использования в приложении.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 2px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 1px 1px 2px 0px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">Функция</td><td> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Описание</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">isc_start_multiple()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Стартует транзакцию, если использеутся фортран вместо isc_start_transaction()</td></tr></table>isc_prepare_transaction()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Подготавливает первую стадию двухфазного</p>
 &nbsp;&nbsp; подтверждения, до первого вызова ф-ии isc_commit_transaction(); используется&nbsp; когда необходимо отменить автоматичекое двухфазное</p>
 &nbsp;&nbsp; подтверждение</p>
isc_prepare_transaction2()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Подготавливает первую стадию двухфазного</p>
<p> &nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;подтверждения, до первого вызова ф-ии</p>
isc_commit_transaction();используется&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; когда необходимо отменить автоматичекое двухфазное&nbsp;&nbsp;&nbsp;&nbsp; подтверждение</p>
&nbsp;</p>
<p>Старт транзакций</p>
<p>Старт транзакций происходит в три этапа:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Создание и инициализация дескриптора транзакции для каждой одновременно стартующей транзакции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Необязательное создание и заполнение TPB для каждой транзакции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Вызов ф-ии isc_start_transaction() для старта каждой транзакции</td></tr></table></div>
<p>Все эти этапы описаны далее.</p>
<p class="note">Примечание: Программисты пишущие приложения которые не разрешают использовать функции с переменным числом параметров должны использовать функцию isc_start_multiple() вместо isc_start_transaction().</p>
<p>Создание дескриптора транзакции</p>
<p>Каждая транзакция которая используется в приложении должна быть связана с владеющим ей дескриптором транзакции (transaction handle), указателем на адрес который используется всеми API ф-ями. Ibase.h содержит декларацию типа для дескриптора транзакции.</p>
<p>typedef void ISC_FAR *isc_tr_handle;</p>
<p>Объявление дескриптора транзакции</p>
<p>Для правильного объявления дескриптора используется тип isc_tr_handle.</p>
<pre>#include &lt;ibase.h&gt;
. . .
isc_tr_handle tr1;
isc_tr_handle tr2;
</pre>

<p>Инициализация дескритора</p>
<pre>#include &lt;ibase.h&gt;
. . .
isc_tr_handle tr1;
isc_tr_handle tr2;
. . .
/* Устанавливаем дескриптор в 0 перед использованием. */
tr1 = 0L;
tr2 = 0L;
</pre>

<p>Если он будет не 0, то isc_start_transaction() вернет код ошибки</p>
<p>Создание буфера параметров транзакции</p>
<p>Буфер параметров транзакции (TPB) &#8211;  это необязательный байтовый массив, определяемый приложением, которое через этот буфер передает аргументы в isc_start_transaction(), которая, в свою очередь, устанавливает аттрибуты транзакции, ее операционные характеристики, режим чтения или записи для доступа к таблице, или только чтение, и могут или нет другие&nbsp; активные транзакции иметь разделяемый доступ к таблице. Каждая транзакция должна иметь TPB, или использовать совместно с другими общий TPB.</p>
<p class="note">Примечание: Если TPB не создан, то в isc_start_transaction() нужно передать вместо TPB &#8211; NULL.</p>
<p>И тогда установятся атрибуты транзакции по умолчанию.</p>
<p>TPB обьявляется в С программе как char массив однобайтовых элементов. Каждый элемент это параметр который описывает один аттрибут транзакции. Вот так выглядит обычная декларация этого буфера:</p>
<p>static char isc_tpb[] = {isc_tpb_version3,</p>
<p>isc_tpb_write,</p>
<p>isc_tpb_read_committed,</p>
<p>isc_tpb_no_rec_version,</p>
<p>isc_tpb_wait};</p>
<p>Этот пример использует параметрические константы определенные в заголовочном файле ibase.h . Первый элемент в каждом TPB должен быть константой isc_tpb_version3. Следующая таблица показывает доступные TPB константы, описывает их назначение, показывает которые из них назначаются по умолчанию если указатель на TPB установлен в NULL.</p>
Параметр &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Описание</p>
<p>isc_tpb_version3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Версия 3 буфера транзакций</p>
<p>isc_tpb_consistency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Модель транзакции "блокировка таблицы"</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="189">isc_tpb_concurrency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Производительная, параллельная транзакция с приемлемой последовательностью; использование этого параметра дает все преимущества InterBase модели многорождаемых транзакций&nbsp; [Значение по умолчанию]?????</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="218">isc_tpb_shared&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> Параллельный, разделяемый доступ к определенной таблице между всеми транзакциями; используется в сочетании с isc_tpb_lock_read и isc_tpb_lock_write, чтобы установить опцию блокировки [Значение по умолчанию]</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="218">isc_tpb_protected&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> Параллельный, ограниченный доступ к определенной таблице; используется в сочетании с isc_tpb_lock_read и isc_tpb_lock_write, чтобы установить опцию блокировки</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="218">isc_tpb_wait&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Резолюция блокировки определяет, что транзакция должна ждать, пока блокированные ресурсы не будут освобождены перед повторением операции [Значение по умолчанию] &nbsp;&nbsp;&nbsp;</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="218">isc_tpb_nowait&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;Резолюция блокировки определяет, что транзакция не должна ждать при блокировке ресурсов, когда они будут освобождены, вместо этого должна быть возвращена немедленно ошибка конфликта блокировки.</td></tr></table>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">isc_tpb_read&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Режим доступа только для чтения, который позволяет транзакции лишь производить выбор данных из таблиц</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">isc_tpb_write&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Режим&nbsp; доступа чтения-записи позволяющий транзакции выбирать, вставлять и обновлять данные таблицы[по умолчанию]</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="225">isc_tpb_lock_read&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Доступ только для чтения к определенной таблице. Используется в сочетании с isc_tpb_shared, isc_tpb_protected, и isc_tpb_exclusive чтобы установить блокировку.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="225">isc_tpb_lock_write&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Доступ чтение-запись для определенной таблицы. Используется в сочетании с isc_tpb_shared, isc_tpb_protected, и isc_tpb_exclusive чтобы установить блокировку[по умолчанию]</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="225">isc_tpb_read_committed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> &nbsp;&nbsp;&nbsp; Высокопроизводительная, высоко(?) параллельная транзакция, которая может читать изменения, совершенные другими параллельными транзакциями. Использование этого параметра дает полное преимущество модели InterBase многорождаемых транзакций.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="225">isc_tpb_rec_version&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> &nbsp; &nbsp; &nbsp; &nbsp;Позволяет isc_tpb_read_committed транзакции читать наиболее позднюю подтвержденную версию записи даже если есть другие, но неподтвержденные версии. &nbsp;&nbsp;&nbsp;</td></tr></table></div>isc_tpb_no_rec_version&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Позволяет isc_tpb_read_committed транзакции с читать только самую позднейшую подтвержденную версию записи. Если есть неподтвержденная версия записи и она задерживается, и isc_tpb_wait также определен, то транзакция ждет для задержанной записи подтверждения или отката назад. Иначе произойдет сразу ошибка конфликта блокировки. (То есть она не показывает старые версии записей если есть неподтвержденные новые. Прим. переводчика)</p>
<p>TPB параметры определяют следующие характеристики транзакции:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 81px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Номер версии буфера параметров транзакции (Transaction version number), используется ядром InterBase.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 81px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Режим доступа (Access mode) описывает действия, которые могут быть выполнены функциями связанными с транзакцией. Существуют следующие режимы доступа:</td></tr></table></div><p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_read</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_write&nbsp;&nbsp;&nbsp;&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 76px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Уровень изоляции (Isolation level) описывает насколько изменения внесенные транзакцией будут отражены в других, одновременно с данной стартовавших транзакций. Существуют следующие уровни изоляции:</td></tr></table></div>isc_tpb_concurrency&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_consistency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_read_committed, isc_tpb_rec_version&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_read_committed, isc_tpb_no_rec_version</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 76px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Разрешение конфликтов блокировок (Lock resolution). Описывает как транзакция должна вести себя если происходит конфликт блокировок. Существуют два вида реакции. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_wait &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_nowait</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 76px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Необязательное резервирование таблицы(Table reservation)&nbsp; описывает метод доступа и тип блокировки для указанной таблицы с которой транзакция работает. Когда используется резервирование таблицы, таблицы резервируются с определенным типом доступа, когда транзакция стартует,&nbsp; а не когда она получит фактически обратится к обратится к таблице. Существуют следующие виды резервирования: &nbsp; &nbsp; &nbsp; &nbsp;</td></tr></table></div>isc_tpb_shared, isc_tpb_lock_write  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_shared, isc_tpb_lock_read  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_protected, isc_tpb_lock_write &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_protected, isc_tpb_lock_read</p>
<p>Определение версии номера транзакции</p>
<p>Первый параметр в TPB должен всегда определять версию буфера. Он должен всегда быть установлен в isc_tpb_version3. Следующее объявление TPB иллюстрирует правильное использование этого параметра:</p>
<p>static char isc_tpb[] = {isc_tpb_version3, ...};</p>
<p>Определение режима доступа</p>
<p>Режим доступа описывает действия которые может выполнять транзакция. По умолчанию режим доступа, isc_tpb_write, разрешает транзакции читать данные из таблицы и писать данные в нее. Второй режим доступа, isc_tpb_read, ограничивает доступ только чтением. К примеру, следующее объявление TPB определяет транзакцию только для чтения:</p>
<p>static char isc_tpb[] = {isc_tpb_version3, isc_tpb_read};&nbsp;&nbsp;</p>
<p>TPB разрешает определять только один параметр режима доступа. Более поздние объявления отменяют ранние.</p>
<p>Определение уровня изоляции</p>
<p>Уровень изоляции (Isolation level) описывает насколько изменения внесенные транзакцией будут отражены в других, одновременно с данной стартовавших транзакций</p>
<p>ISC_TPB_CONCURRENCY</p>
<p>По умолчанию, после старта транзакции, не могут быть доступны подтвержденные изменения в таблице, сделанные другими, параллельно работающими транзакциями, даже если используется разделяемый доступ к таблице. Такая транзакция имеет уровень изоляции isc_tpb_concurrency, это означает, что другие параллельно работающие транзакции могут иметь параллельный доступ к таблицам. Пример:</p>
<p>  static char isc_tpb[] = {isc_tpb_version3,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_write,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_concurrency};</p>
<p>ISC_TPB_READ_COMMITTED</p>
<p>Второй уровень изоляции,&nbsp; isc_tpb_read_committed, имеет все преимущества isc_tpb_concurrency и дополнительно позволяет транзакции обращаться к подтвержденным изменениям совершенным другими параллельно работающими транзакциями. Два других параметра, isc_tpb_rec_version, и isc_tpb_no_rec_version, должны использоваться в комбинации с isc_tpb_read_committed. Они предоставляют более гибкое управление для доступа транзакции к подтвержденным изменениям.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_tpb_no_rec_version, заданное по умолчанию, определяет что транзакция может видеть только самую последнюю версию записи. Если изменение записи продолжается, но не завершено подтверждением, запись не может быть прочитана.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_tpb_rec_version определяет что транзакция может читать самую последнюю подтвержденную версию записи, даже если самая последняя не подтвержденная версия записи не завершилась и продолжает изменение.</td></tr></table></div><p>Следующее объявление создает TPB с уровнем изоляции read_committed, и определяет транзакцию которая может читать самую последнюю версию записи.</p>
<p>static char isc_tpb[] = {isc_tpb_version3,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_write,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_read_committed,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_tpb_rec_version};</p>
<p>ISC_TPB_CONSISTENCY</p>
<p>InterBase также поддерживает ограничительный уровень изоляции. isc_tpb_consistency не разрешает доступ транзакции к таблицам, если туда производят записи другие транзакции; и также не дает доступа другим транзакциям к таблице в которую производит запись эта транзакция. Этот уровень изоляции предназначен, чтобы гарантировать,&nbsp; если производятся транзакцией записи в таблицу перед другими одновременно читающими и пишущими транзакциями, то только эта транзакция может изменять данные таблицы. Так как это существенно ограничивает одновременный доступ к таблице, то</p>
<p>isc_tpb_consistency надо использовать осторожно.</p>
<p>В TPB должен быть определен только&nbsp; один параметр уровня изоляции (и один параметр уточнения, еслиуровень изоляции - isc_tpb_read_committed). Если определено больше одного параметра, то&nbsp; более поздние объявления отменяют более ранние.</p>
<p>Если в TPB опущен параметр уровня изоляции то IB ставит транзакции уровень изоляции как&nbsp; isc_tpb_concurrency.</p>
<p>Взаимодействия уровней изоляции</p>
<p>Для определения конфликтов блокировок между двумя транзакциями, обращающимися к одной и тойже БД, нужно рассмотреть уровень изоляции и режим доступа каждой транзакции. Следующая таблица дает возможные комбинации.</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; isc_tpb_concurrency,</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; isc_tpb_read_committed  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_consistency</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td colspan="2" ><br>
</td>
<td><p>isc_tpb_write</p>
</td>
<td><p>isc_tpb_read</p>
</td>
<td><p>isc_tpb_write</p>
</td>
<td><p>isc_tpb_read</p>
</td>
</tr>
<tr>
<td rowspan="2" ><p>concurrency,</p>
<p>read_committed</p>
</td>
<td><p>isc_tpb_write</p>
</td>
<td><p>Некоторые одновременные обновления могут конфликтовать</p>
</td>
<td><p>___</p>
</td>
<td><p>Конфликты</p>
</td>
<td><p>Конфликты</p>
</td>
</tr>
<tr>
<td><p>isc_tpb_read</p>
</td>
<td><p>--</p>
</td>
<td><p>--</p>
</td>
<td><p>--</p>
</td>
<td><p>--</p>
</td>
</tr>
<tr>
<td rowspan="2" ><p>consistency</p>
</td>
<td><p>isc_tpb_write</p>
</td>
<td><p>Конфликты</p>
</td>
<td><p>--</p>
</td>
<td><p>Конфликты</p>
</td>
<td><p>Конфликты</p>
</td>
</tr>
<tr>
<td><p>isc_tpb_read</p>
</td>
<td><p>Конфликты</p>
</td>
<td><p>--</p>
</td>
<td><p>Конфликты</p>
</td>
<td>
</td>
</tr>
</table>
<p>Эта таблица показывает, что транзакции isc_tpb_concurrency и isc_tpb_read_committed имеют наименьшее количество конфликтных ситуаций. К примеру, если t1 есть транзакция isc_tpb_concurrency с доступом isc_tpb_write, а t2 есть транзакция isc_tpb_read_committed с доступом isc_tpb_write, t1 и t2 тогда конфликтуют, когда они пытаются обновить одни и теже строки. Если t1 и t2 имеют доступ&nbsp; isc_tpb_read, то они никогда не вступят в конфликт с другими транзакциями.</p>
<p>Разрешения конфликтов блокировок</p>
<p>Разрешение конфликтов блокировок (Lock resolution) описывает как транзакция должна вести себя если происходит конфликт блокировок. Существуют два вида реакции.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_tpb_wait, по умолчанию определяет что транзакция будет ожидать пока блокированные ресурсы не освободятся. Как только ресурсы освободятся транзакция повторит операцию.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_tpb_nowait, говорит что транзакция возвратит ошибку конфликта блокировок, без ожидания окончания блокировки.</td></tr></table></div>
<p>К примеру, следующее объявление создает TPB с доступом для записи, и concurrency уровнем изоляции, и с разрешением блокировки isc_tpb_nowait:</p>
<p>static char isc_tpb[] = {isc_tpb_version3,</p>
<p>isc_tpb_write,</p>
<p>isc_tpb_concurrency,</p>
<p>isc_tpb_nowait};</p>
<p>TPB может иметь только один параметр разрешения конфликта блокировки. Если их больше одного, то поздняя декларация отменит раннюю. Если в TPB опущен этот параметр, то IB интерпретирует это как isc_tpb_concurrency.?</p>
<p>Определение резервирования таблицы</p>
<p>Обычно транзакции получают определенный доступ к таблицам только когда они непосредственно читают или пишут в таблицы. Параметр резервирования таблицы необязателен и может быть опущен в TPB. Резервирование таблицы (Table reservation) описывает режим доступа и разрешение конфликта блокировок для определенной таблицы которая доступна транзакции. Когда используется резервирование таблицы, таблицы резервируются для специального доступа когда транзакция стартует, а не когда транзакция фактически получит доступ к таблице.&nbsp; Резервироание таблиц используется в среде, где одновременно существующие транзакции имеют совместный доступ к БД. Существуют следующие цели резервирования.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Предотвращение возможных тупиковых ситуаций и конфликтов обновления, которые могут происходить, если блокировки принимаются только там&nbsp; где они фактически необходимы (поведение по умолчанию).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Предусмотрение&nbsp; зависимой блокировки, блокировок таблиц, на которые можно воздействовать ограничениями целостности и триггерами. Если есть явная зависимость, блокировка не требуется, можно ручаться, что конфликты обновлений не произойдут из-за косвенных конфликтов таблиц.(!!!!!!!!!!!!!!!!!!!!!!!!!!!!)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Изменение уровеня разделяемого доступа для одной или нескольких таблиц в транзакции. Например, isc_tpb_write транзакция с уровнем изоляции isc_tpb_concurrency может нуждаться в исключительных правах на изменения для отдельной таблицы, и могла бы использовать параметр резервирования, чтобы гарантировать себе единственный доступ для записи в таблицу.</td></tr></table></div><p>Виды резервирования:</p>
<p>- Isc_tpb_shared, isc_tpb_lock_write,&nbsp; разрешают любой транзакции с режимом доступа isc_tpb_write и уровнями изоляции isc_tpb_concurrency или isc_tpb_read_committed модифицировать данные, в то время как другие транзакции с этими уровнями изоляции и режимом доступа isc_tpb_read могут только читать данные.</p>
<p>- Isc_tpb_shared, isc_tpb_lock_read, разрешает любой транзакции читать данные, и любой транзакции с режимом доступа isc_tpb_write изменять данные. Это - наиболее либеральный режим резервирования.</p>
<p>- Isc_tpb_protected, isc_tpb_lock_write, не дает другим транзакциям изменять данные. Другие транзакции с уровнями изоляции isc_tpb_concurrency или isc_tpb_read_committed могут читать данные, но только эта транзакция может изменять их.</p>
<p>- Isc_tpb_protected, isc_tpb_lock_read, не дает всем транзакциям делать изменения данных, но разрешает всем транзакциям читать данные.</p>
<p>Имя таблицы, которую надо резервировать должно сразу следовать за параметрами резервирования. Например, следующее обьявление TPB  резервирует таблицу, EMPLOYEE, для защищенного доступа&nbsp; чтения:</p>
<p>static char isc_tpb[] = {isc_tpb_version3,</p>
<p>isc_tpb_write,</p>
<p>isc_tpb_concurrency,</p>
<p>isc_tpb_nowait,</p>
<p>isc_tpb_protected, isc_tpb_lock_read, "EMPLOYEE"};</p>
<p>Несколько таблиц могут быть зарезервированы одновременно. Следующее объявление иллюстрирует, как две таблицы зарезервированы, один для защищенного чтения, другой для защищенной записи:</p>
<p>static char isc_tpb[] = {isc_tpb_version3,</p>
<p>isc_tpb_write,</p>
<p>isc_tpb_concurrency,</p>
<p>isc_tpb_nowait,</p>
<p>isc_tpb_protected, isc_tpb_lock_read, "COUNTRY",</p>
<p>isc_tpb_protected, isc_tpb_lock_write, "EMPLOYEE"};</p>
&nbsp;</p>
<p>Использование TPB по умолчанию.</p>
<p>Для транзакции TPB необязателен. Если он не нужен, тогда в isc_start_transaction() в качестве&nbsp; указателя на TPB надо передать NULL. В этом случае IB будет запускать транзакцию с параметрами как если бы TPB был обьявлен так:</p>
<p>static char isc_tpb[] = {isc_tpb_version3,</p>
<p>isc_tpb_write,</p>
<p>isc_tpb_concurrency,</p>
<p>isc_tpb_wait};</p>
<p>Вызов isc_start_transaction()</p>
<p>Как только дескриптор транзакции и TPB подготовлены, транзакция может стартовать посредством вызова isc_start_transaction(), использующей следующий синтаксис:</p>
<pre>ISC_STATUS isc_start_transaction(ISC_STATUS *status vector,
isc_tr_handle *trans_handle,
short db_count,
isc_db_handle *&amp;db_handle,
unsigned short tpb_length,
char *tpb_ad);
</pre>

<p>Для транзакции, которая выполняется для единственной базы данных, установите&nbsp; db_count в 1. db_handle должен быть установлен уже ф-ей isc_attach_database (), tpb_length - размер TPB, и isc_tpb - адрес TPB. Пример:</p>
<pre>#include &lt;ibase.h&gt;
. . .
ISC_STATUS status_vector[20];
isc_db_handle db1;
isc_tr_handle tr1;
static char isc_tbp[] = {isc_tpb_version3,
isc_tpb_write,
isc_tpb_concurrency,
isc_tpb_wait};
. . .
/* Здесь инициализируем дескрипторы БД и транзакции */
db1 = 0L;
tr1 = 0L;
. . .
/* Код для подключения к БД здесь опущен*/
isc_start_transaction(status_vector, &amp;tr1, 1, &amp;db1, (unsigned short) sizeof(isc_tpb), isc_tpb);
</pre>

<p>Транзакция может быть открыта для нескольких БД. Для этого установите db_count в число БД для которых будет запущена транзакция, где для каждой БД повторяется группа параметров db_handle, tpb_length, and isc_tpb. Пример:</p>
<p>isc_start_transaction(status_vector, &amp;tr1 ,2, &amp;db1,(unsigned short) sizeof(isc_tpb), &amp;tpb,</p>
<p>&amp;db2,(unsigned short) sizeof(tpb),&amp;tpb);</p>
<p>Завершение транзакций</p>
<p>Когда задачи транзакции выполнены, или ошибка освобождает транзакцию от завершения, и тогда транзакция должна быть закончена, чтобы оставить базу данных в целостном состоянии. Существуют две функции заканчивающие транзакцию.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_commit_transaction () делает изменения транзакции постоянными в базе данных. Для транзакций, которые охватывают больше одной базы данных, эта функция исполняет автоматический двухфазный commit, который гарантирует, что все изменения сделаны успешно.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_rollback_transaction() отменяет все изменения произведенные транзакцией, и возвращает БД в состояние которое было перед стартом транзакции.</td></tr></table></div>
<p>isc_commit_transaction () и isc_rollback_transaction () закрывают&nbsp; потоки записи, связанные с транзакцией, повторно инициализируют дескриптор транзакции в 0L,&nbsp; и освобождают ресурсы системы, выделенные для транзакции. Освобожденные ресурсы системы&nbsp; вновь доступны для последующего использования любым приложением или программой.</p>
<p>Isc_rollback_transaction () часто используется внутренними подпрограммами обработки ошибок, чтобы сбросить транзакции, когда происходят ошибки. Она может также использоваться, чтобы откатить назад частично законченную транзакцию, и также&nbsp; она может использоваться, чтобы восстановить базу данных к ее предыдущему состоянию, если программа сталкивается с неисправимой ошибкой.</p>
<p>Isc_start_multiple не будем рассматривать, так как фортран устарел.</p>
<p>Использование isc_commit_transaction( )</p>
<p>Используйте isc_commit_transaction () чтобы записать&nbsp; изменения внесенные транзакцией в базу данных. Isc_commit_transaction () закрывает&nbsp; потоки записей, связанные с транзакцией, сбрасывает имя транзакции в 0, и освобождает ресурсы системы, выделенные для транзакции. Полный синтаксис для isc_commit_transaction ():</p>
<p>ISC_STATUS isc_commit_transaction(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_tr_handle *trans_handle);</p>
<p>Пример, следующийвызов подтверждает транзакцию:</p>
<p>isc_commit_transaction(status_vector, &amp;trans);</p>
<p>Транзакции стартовавшие с режима доступа isc_tpb_read должны также заканчиваться вызовомк isc_commit_transaction (), а не isc_rollback_transaction (). База данных не изменяется в этом случае, but the overhead required to start subsequent transactions is greatly reduced.????</p>
<p>Использование isc_commit_retaining()</p>
<p>Чтобы сохранять изменения внесенные транзакцией в базу данных без создания нового контекста транзакции &#8212;  имени, системных ресурсов, и текущего состояния&nbsp; курсоров, используемых в транзакции &#8212; используют isc_commit_retaining (), вместо isc_commit_transaction (). В загруженной, многопользовательской среде, поддержка контекста транзакции для каждого пользователя ускоряет обработку и использует меньшее количество ресурсов системы, нежели закрытие и старт новой транзакции для каждого действия. Полный синтаксис для isc_commit_retaining ():</p>
<p>ISC_STATUS isc_commit_retaining(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_tr_handle *trans_handle);</p>
<p>Isc_commit_retaining () записывает все задержанные изменения в базу данных, заканчивает текущую транзакцию без&nbsp; закрытия ее потока записи и курсоров, и без освобождения ее ресурсов системы, затем начинает новую транзакцию и назначает существующие потоки и ресурсы системы&nbsp; новой транзакции.</p>
<p>Например, следующий вызлв подтверждает определенную транзакцию, сохраняя текущее состояние курсора и ресурсы системы:</p>
<p>isc_commit_retaining(status_vector, &amp;trans);</p>
<p>Вызов isc_rollback_transaction ()&nbsp; после isc_commit_retaining () откатывает назад обновления и записи, встречающиеся после вызова isc_commit_retaining ().</p>
<p>Использование isc_prepare_transaction()</p>
<p>Когда транзакция подтверждается для многих баз данных, использующих isc_commit_transaction (), InterBase автоматически исполняет двухфазное подтверждение. В течение первой фазы подтверждения, ядро InterBase опрашивает все участвующие в транзакции базы данных, чтобы удостовериться, что они все еще доступны, затем записывает сообщение, описывающее транзакцию в&nbsp; поле RDB$TRANSACTION_DESCRIPTION RDB ситемной таблицы $TRANSACTION , затем помещает транзакцию в состояние неопределенности (limbo). Именно в течение второй фазы&nbsp; изменения транзакции фактически подтверждаются&nbsp; для базы данных.</p>
<p>Некоторые приложения могут иметь их собственные, дополнительные требования, чтобы делать двухфазное подтверждение. Эти приложения могут вызывать isc_prepare_transaction () чтобы выполнить&nbsp; первую стадию двухфазного аодтверждения, затем исполнить их собственные, дополнительные задачи перед завершением подтверждения вызовом isc_commit_transaction ().</p>
<p>Синтаксис для isc_prepare_transaction ():</p>
<p>ISC_STATUS isc_prepare_transaction(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_tr_handle *trans_handle);</p>
<p>Например, следующий&nbsp; фрагмент кода иллюстрирует, как приложение могло бы вызывать isc_prepare_transaction (), потом после его собственными подпрограммами, перед завершением подтверждения по isc_commit_transaction ():</p>
<pre>ISC_STATUS status_vector[20];
isc_db_handle db1;
isc_tr_handle trans;
. . .
/* Initialize handles. */
db1 = 0L;
trans = 0L;
. . .
/* Code assumes a database is attached here, */
/* and a transaction started. */
. . .
/* Выполнение первой фазы двух – фазного подтвеждения. */
isc_prepare_transaction(status_vector, &amp;trans);
/* Приложение делает здесь свою какую-то работу */
my_app_function();
/* Сечас выполнится подтвержедние второй фазы */
isc_commit_transaction(status_vector, &amp;trans);
</pre>

<p>Это вообще опасная практика,&nbsp; задерживание второй фазы подтверждения после завершения первой, потому что задержки увеличивают шанс, что сетевые проблемы&nbsp; или проблемы с сервером могут произойти между фазами</p>
<p>Использование isc_prepare_transaction2( )</p>
<p>Подобно isc_prepare_transaction (), isc_prepare_transaction2 () выполняет,&nbsp; первую фазу двухфазного подтверждения, за исключением того, что isc_prepare_transaction2 () позволяет приложению применить свое&nbsp; описание транзакции для вставки в поле RDB$TRANSACTION_DESCRIPTION системной таблицы RDB$TRANSACTION.</p>
<p>ВАЖНО Не используйте этот запрос без первичного исследования и понимания информации хранимой InterBase в RDB$TRANSACTION_DESCRIPTION в течение автоматического&nbsp; двухфазного подтверждения. Хранение неподходящей или неполной информации может предотвратить восстановление базы данных, если двухфазное подтверждение даст сбой.</p>
<p>Использование isc_rollback_transaction( )</p>
<p>Используйте isc_rollback_transaction () чтобы восстановить базу данных к ее состоянию до начала транзакции. Isc_rollback_transaction () также закрывает потоки записи, связанные с транзакцией, сбрасывает имя транзакции в 0, и освобождает ресурсы системы, выделенные для транзакции. Isc_rollback_transaction () обычно появляется в подпрограммах обработки ошибок. Синтаксис для isc_rollback_transaction ():</p>
<p>ISC_STATUS isc_rollback_transaction(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_tr_handle *trans_handle);</p>
<p>Пример отката транзакции:</p>
<p>isc_rollback_transaction(status_vector, &amp;trans);</p>
<p>Работа с динамическим SQL (DSQL)</p>
<p>Эта глава описывает как использовать API&nbsp; динамические ф-ии SQL (DSQL), чтобы обрабатывать динамически созданные инструкции для создания и обработки данных. Использование вызовов API нижнего уровня позволяет клиентским приложениям формировать SQL инструкции или опрашивать конечных пользователей во время выполнения, предоставлять конечным пользователям знакомый интерфейс с БД. А также предоставляет разработчикам приложений доступ нижнего уровня к особенностям InterBase, типа множественных БД, обычно не доступных на высоком уровне для встроенных DSQL инструкций. Например, утилита InterBase isql - это DSQL приложение построенное на вызовах API нижнего уровня.</p>
<p>Все API DSQL ф-ии начинаются с “isc_dsql” , чтобы их отличить от других функций.</p>
<p>Краткий обзор процесса программирования на DSQL</p>
<p>Построение и выполнение DSQL приложений с API включает следующие основные шаги:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Встраивание DSQL API&nbsp; ф-ий в приложение.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Использование средств базового языка, таких как типы данных и макрокоманды, чтобы предоставить области ввода и вывода для проходящих инструкций и параметров во время выполнения.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Программные методы, которые используют эти инструкции и средства, чтобы обработать инструкции SQL во время выполнения.</td></tr></table></div><p>Эти шаги описываются детально в этой главе.</p>
<p>Ограничения для DSQL API</p>
<p>Хотя DSQL предлагает много преимуществ, но он также имеет следующие ограничения.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Динамическая обработка транзакций не разрешается; все именованные транзакции должны быть объявлены во время компиляции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Динамический доступ к Blob и массивам данных не поддерживается; К Blob&nbsp; и массивам данных можно обращаться, но только через стандартные, статически обработанные инструкции SQL, или через вызовы API нижнего уровня.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Создание БД выполняется через инструкции выполнения CREATE DATABASE в пределах контекста&nbsp; EXECUTE IMMEDIATE.</td></tr></table></div>
<p>Доступ к базам данных</p>
<p>InterBase API разрешают приложениям подсоединяться одновременно к нескольким БД используя дескрипторы БД. Дескрипторы БД должны быть обьявлены и инициализированы когда приложение откомпилировано. Отдельные дескрипторы базы данных должны быть определены и инициализированы для каждой базы данных доступной параллельно.</p>
<p>Дескрипторы транзакций</p>
<p>InterBase требует чтобы все дескрипторы транзакций были объявлены в откомпилированном приложении. После компиляции, дескрипторы транзакции не могут быть изменены во время выполнения, и при этом новые дескрипторы не могут быть объявлены динамически во время выполнения. Большинство функций API, которые обрабатывают инструкции SQL во время выполнения, типа isc_dsql_describe (), isc_dsql_describe_bind (), isc_dsql_execute (), isc_dsql_execute2 (), isc_dsql_execute_immediate (), isc_dsql_exec_immed2 (), и isc_dsql_prepare (), поддерживает включение параметра дескриптора транзакции. Инструкции SQL, обработанные этими функциями не могут передавать дескрипторы транзакции, даже если синтаксис SQL для инструкции разрешает использование предложения TRANSACTION.</p>
<p>Прежде, чем&nbsp; дескриптор транзакции будет использоваться, он должен быть объявлен и инициализирован в 0. Следующий код объявляет, инициализирует, и использует дескриптор транзакции в&nbsp; API вызове , который размещает и готовит инструкцию SQL для выполнения:</p>
<pre>#include &lt;ibase.h&gt;
. . .
isc_tr_handle trans; /* Обьявляется дескриптор транзакции. */
isc_stmt_handle stmt; /* Обьявляется дескриптор инструкции. */
char *sql_stmt = "SELECT * FROM EMPLOYEE";
isc_db_handle db1;
ISC_STATUS status_vector[20];
. . .
trans = 0L; /* Дескриптор транзакции инициализируется в 0. */
stmt = NULL; /* Дескриптор инструкции устанавливается в NULL перед выделенем. */
/* Здесь код для подключения, к БД и старта транзакции */
. . .
/* Выделяем место для дескриптора инструкции. */
isc_dsql_allocate_statement(status_vector, &amp;db1, &amp;stmt);
/* Подготавливаем инструкцию для выполнения. */
isc_dsql_prepare(status_vector, &amp;trans, &amp;stmt, 0, sql_stmt, 1, NULL);
</pre>

<p class="note">Примечание</p>
<p>Инструкция SQL SET TRANSACTION не может быть подготовлена через isc_dsql_prepare (), но она может быть обработана с помощью isc_dsql_execute_immediate () если:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Предыдущие транзакции закончились подтверждением&nbsp; или откачены назад.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Дескриптор транзакции установлен в NULL.</td></tr></table></div>
<p>Создание базы данных</p>
<p>Создание новой базы данных в API приложении:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Отсоединитесь от всех БД с помощью isc_detach_database().</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Сформируйте инструкцию&nbsp; CREATE DATABASE для обработки.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Выполните инструкцию с помощью isc_dsql_execute_immediate () или isc_dsql_exec_immed2 ().</td></tr></table></div><p>К примеру, следующие инструкции отсоединяют все подключенные БД и создают новую БД. Любой дескриптор существующей БД устанавливается в NULL, и может быть использован в будущем для подключения к новым БД.</p>
<pre>char *str = "CREATE DATABASE \"new_emp.gdb\"";
. . .
isc_detach_database(status_vector, &amp;db1);
isc_dsql_execute_immediate(status_vector, &amp;db1, &amp;trans, 0, str, 1,NULL);
</pre>

<p>Написание API приложения для обработки SQL инструкций</p>
<p>Написание приложения API, которое обрабатывает инструкции SQL, позволяет разработчику программировать напрямую Interbase на&nbsp; низком уровне, для предоставления конечным пользователям знакомого интерфейса SQL. Приложения SQL API особенно полезны, когда&nbsp; не известна до времени выполнения следующая информация:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Текст SQL инструкции</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Число базовых переменных</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Типы базовых переменных</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Ссылки на объекты БД</td></tr></table></div><p>Создание приложения API DSQL гораздо сложнее, чем программирование&nbsp; приложений со встроенным SQL и со статическим SQL, потому что для большинства операций DSQL, приложение должно явно выделить и обработать расширенный дескриптор области&nbsp; SQL (XSQLDA) - структура данных, чтобы передать данные в БД&nbsp; или из БД.</p>
<p>Использование API для обработки DSQL инструкций предполагает следующие основные шаги:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Определите, могут ли вызовы API обработать инструкцию SQL.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Представьте инструкцию SQL как строку символов в приложении.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>В случае необходимости, выделите одну или больше структур XSQLDA для входных параметров и возвращаемых значений.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Используйте соответствующие API, и программные методы, чтобы обработать инструкцию SQL.</td></tr></table></div>&nbsp;</p>
<p>Определение API вызовов которые могут обработать SQL инструкцию.</p>
<p>Кроме упомянутого ранее в этой главе, функции DSQL могут обрабатывать большинство инструкций SQL. Например, DSQL может обрабатывать инструкции манипуляции данными, такими как DELETE и INSERT, инструкции опеределения данных таких как ALTER TABLE и CREATE INDEX, и инструкции SELECT. Следующая таблица показывает список SQL инструкций , которые не могут быть обработаны функциями DSQL:</p>
Инструкция &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Инструкция</p>
<p>CLOSE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DECLARE CURSOR</p>
<p>DESCRIBE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;EXECUTE</p>
<p>EXECUTE IMMEDIATE &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FETCH</p>
OPEN  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;PREPARE</p>
<p>Эти инструкции используются, чтобы обработать запросы DSQL или дескрипторы курсоров SQL, которые должны всегда определяться, когда приложение написано. Попытка использовать их с DSQL приводит к ошибкам во время выполнения.</p>
<p>Представление инструкции SQL как строки символов</p>
<p>В рамках приложения DSQL, инструкция SQL может исходить из различных источников. Она может исходить&nbsp; непосредственно от пользователя, кто вводит инструкцию при подсказке, как делает isql. Или она может быть сгенерирована приложением в ответ на действие пользователя. Не взирая на источник инструкции SQL, она должна быть представлена как&nbsp; строка символов, которую передают к DSQL для обработки.</p>
<p>Строки SQL инструкций&nbsp; не начинаются с префикса EXEC SQL&nbsp; и не заканчиваются точкой с запятой (;) как это делается в типичных&nbsp; приложениях встроенного SQL. Например, следующее объявление переменной базового языка &#8211; связывается со строкой инструкции SQL:</p>
<p>char *str = "DELETE FROM CUSTOMER WHERE CUST_NO = 256";</p>
<p class="note">Примечание: Точка с запятой, которая появляется в конце этого объявления символа - терминатор строки в С, а не часть строки инструкции SQL.</p>
<p>Определение параметров в строках инструкции SQL</p>
<p>Строки инструкции SQL часто включают параметры, передаваемые по значению, или выражения&nbsp; которые приводят к отдельному числовому или символьному значению. Значение параметра в&nbsp; строке инструкции может быть передано как константа, или как метка - заполнитель во время выполнения. Например, следующая строка инструкции передает 256 как константу:</p>
<p>char *str = "DELETE FROM CUSTOMER WHERE CUST_NO = 256";</p>
<p>Также можно формировать строки во время выполнения c комбинацией констант. Этот метод полезен для инструкций, где переменная не истинная константа, или это - таблица или название столбца, и где инструкция выполняется только один раз в приложении.</p>
<p>Чтобы передавать параметр как метку - заполнитель, значение передают как вопросительный знак (?) вставленный внутрь инструкции строки:</p>
<p>char *str = "DELETE FROM CUSTOMER WHERE CUST_NO = ?";</p>
<p>Когда функция DSQL обрабатывает инструкцию, содержащую метку - заполнитель, то она заменяет вопросительный знак значением, находящимся в расширенном SQL дескрипторе (XSQLDA) предварительно объявленном и заполненном в приложении. Используйте метки - заполнители&nbsp; в инструкциях, которые подготовливаются один раз, но выполняются много раз с различными значениями параметра.</p>
<p>Заменяемые&nbsp; параметры, передаваемые по значению часто используются, чтобы передать значения SQL предложения&nbsp; SELECT&nbsp; инструкции WHERE&nbsp; и в предложениях SET инструкции UPDATE.</p>
<p>Понятие XSQLDA</p>
<p>Все DSQL приложения должны содержать объявление одной или нескольких структур данных, называемых расширенными областями данных SQL -  XSQLDA (eXtended SQL Descriptor Areal). Определение структуры XSQLDA может быть найдено в заголовочном файле ibase.h . Приложения объявляют элементы XSQLDA для использования.</p>
<p>XSQLDA это структура данных базового языка который использует DSQL для обмена данными с БД при обработке SQL инструкции. Есть два типа XSQLDA: для ввода и для вывода. Оба дескриптора реализованы с использованием структуры XSQLDA.</p>
<p>Одно поле в XSQLDA, sqlvar, является структурой XSQLVAR. Sqlvar особенно важен, потому что один XSQLVAR должен быть определен для каждого входного параметра или возвращаемого столбца. Подобно XSQLDA, XSQLVAR - структура, определенная в ibase.h .</p>
<p>Приложения не объявляют&nbsp; XSQLVAR раньше времени, но должны, вместо этого, динамически выделить память для хранения надлежащего числа структур XSQLVAR, требуемых для каждой инструкции DSQL прежде, чем она будет выполнена, а затем освобождают их, соответственно после&nbsp; выполнения инструкции.</p>
<p>Следующий рисунок иллюстрируют связи между XSQLDA и XSQLVAR:</p>
<p>Элемент XSQLDA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p>short version</p>
<p>char sqldaid[8]</p>
<p>ISC_LONG sqldabc</p>
<p>short sqln</p>
<p>short sqld</p>
<p>XSQLVAR sqlvar[1]    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; |</p>
<p>|</p>
<p>|амассив n элементов XSQVAR</p>
1-й элемент &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;n-й элемент</p>
<p>short sqltype  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short sqltype</p>
<p>short sqlscale  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short sqlscale</p>
<p>short sqlsubtype  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short sqlsubtype</p>
<p>short sqllen  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short sqllen</p>
<p>char *sqldata  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char *sqldata</p>
<p>short *sqlind  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short *sqlind</p>
<p>short sqlname_length  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short sqlname_length</p>
<p>char sqlname[32]  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char sqlname[32]</p>
<p>short relname_length  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; . . . &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short relname_length</p>
<p>char relname[32]  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char relname[32]</p>
<p>short ownname_length  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short ownname_length</p>
<p>char ownname[32]  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char ownname[32]</p>
<p>short aliasname_length  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short aliasname_length</p>
char aliasname[32]  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char aliasname[32]</p>
<p>XSQLDA для ввода состоит из одной структуры XSQLDA и одной структуры XSQLVAR для каждого входного параметра.&nbsp; XSQLDA для вывода также состоит из одной структуры XSQLDA и одной структуры XSQLVAR для каждого элемента данных, возвращенного инструкцией. XSQLDA и его связанные структуры XSQLVAR выделены в отдельный блок смежной памяти.</p>
<p>Isc_dsql_prepare(), isc_dsql_describe(), и isc_dsql_describe_bind()&nbsp; могут использоваться, чтобы определить нужное число структур XSQLVAR для выделения, и макрокоманда XSQLDA_LENGTH может использоваться, чтобы выделить нужное количество памяти.</p>
<p>Описание полей XSQLDA</p>
Определение поля &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Описание</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="189">short version</td><td>Указывает версию структуры XSQLDA. Устанавливается приложением. Текущая версия определена в ibase.h как SQLDA_VERSION1</td></tr></table><p>char sqldaid[8] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Зарезервировано для будущего использования</p>
<p>ISC_LONG sqldabc &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Зарезервировано для будущего использования</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="189">short sqln</td><td>Указывает число элементов в массиве sqlvar; приложение должно устанавливать это поле каждый раз, когда оно выделяет&nbsp; память для дескриптора</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="189">short sqld</td><td>Указывает число параметров XSQLDA&nbsp; для ввода, или число элементов списка выбора&nbsp; XSQLDA для вывода; устанавливается InterBase c помощью isc_dsql_describe (), isc_dsql_describe_bind (), или isc_dsql_prepare ()</td></tr></table>Для дескриптора ввода, sqld= 0 указывает, что инструкция SQL не имеет никаких параметров; для дескриптора вывода, sqld= 0 указывает, что инструкция SQL - не инструкция SELECT</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="189">XSQLVAR sqlvar</td><td>Массив структур XSQLVAR; число элементов в массиве определено в поле sqln</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">short sqltype</td><td>Указывает SQL тип данных параметров или элементов списка выбора; устанавливается InterBasec помощью isc_dsql_describe (), isc_dsql_describe_bind (), или Isc_dsql_prepare ()</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">short sqlscale</td><td>Представляет масштаб, определенный как отрицательное число, для точного числового типа данных&nbsp; ( DECIMAL, NUMERIC); устанавливается IB с помощью isc_dsql_describe (), isc_dsql_describe_bind (), или isc_dsql_prepare ()</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">short sqlsubtype</td><td>Определяет подтип дляBLOB данных; устанавливается IB с помощью&nbsp; isc_dsql_describe (), isc_dsql_describe_bind (), или isc_dsql_prepare ()</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">short sqllen</td><td>Указывает максимальный размер, в байтах, данных в поле sqldata; устанавливается IB с помощью&nbsp; isc_dsql_describe (), isc_dsql_describe_bind (), или isc_dsql_prepare ()</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">char *sqldata</td><td>Для дескрипторов ввода, определяет&nbsp; адрес элемента списка выбора или параметра; установливается приложением. Для дескрипторов&nbsp; вывода, содержит значение&nbsp; элемента из списка выбора; установливается IB (проще, указатель на данные)</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">short *sqlind</td><td>Для ввода, определяет указатель на переменную- индикатор; устанавливается приложением; При выводе, определяет указатель столбца значения индикатора&nbsp; для элемента списка выбора следующего FETCH . Значение 0 указывает, что столбец - не NULL ; значение -1 указывает, что&nbsp; столбец NULL; устанавливается IB</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">short sqlname_length</td><td>Определяет длину, в байтах, данных в поле, sqlname; устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</td></tr></table><p>char sqlname[32] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Содержит имя столбца. Не NULL, заканчивается (\0);</p>
установливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</p>
<p>short relname_length &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Определяет длину, в байтах, данных в поле, relname;</p>
устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</p>
<p>char relname[32] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Содержит имя таблицы; не NULL заканчивается (\0)&nbsp;</p>
устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</p>
<p>short ownname_length &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Определяет длину, в байтах, данных в поле, ownname;</p>
устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">char ownname[32]</td><td>Содержит имя владельца таблицы; не NULL , заканчивается (\0, устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</td></tr></table><p>short aliasname_length &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Определяет длину, в байтах, данных в поле, aliasname;</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236"></td><td>устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</td></tr></table></div><div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 2px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 1px 1px 2px 0px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="236">char aliasname[32]</td><td>Содержит имя псевдонима столбца. Если псевдонима нет, содержит имя столбца; не NULL заканчивается (\0), устанавливается IB с помощью isc_dsql_prepare () или isc_dsql_describe ()</td></tr></table></div>&nbsp;</p>
Дескрипторы ввода</p>
<p>Дескрипторы ввода используются, для обработки строк инструкции SQL, которые содержат параметры. Прежде, чем приложение сможет выполнить инструкцию с параметрами, оно должно присвоить параметрам значения. Приложение указывает&nbsp; число параметров переданных в поле XSQLDA  sqld, затем описывает каждый параметр в отдельной структуре XSQLVAR. Например, следующая&nbsp; строка - инструкция содержит два параметра, поэтому приложение должно установить sqld в 2, и описать каждый параметр:</p>
<p>char *str = "UPDATE DEPARTMENT SET BUDGET = ? WHERE LOCATION = ?";</p>
<p>Когда инструкция выполняется, в первом XSQLVAR находится информации относительно значения BUDGET, а во втором XSQLVAR информация о LOCATION.</p>
<p>Дескрипторы вывода</p>
<p>В дескрипторах вывода возвращаются результаты выполненного приложением запроса. Поле sqld XSQLDA указывает, сколько значений было возвращено. Каждое значение сохраняется в отдельной структуре XSQLVAR. Поле XSQLDA sqlvar указывает на первую&nbsp; из XSQLVAR структур . Следующая строка - инструкция требует дескриптора вывода:</p>
<p>char *str = "SELECT * FROM CUSTOMER WHERE CUST_NO &gt; 100";</p>
<p>Использование макроса XSQLDA_LENGTH</p>
<p>В заголовочном файле ibase.h содержится определение макроса, XSQLDA_LENGTH, подсчитывающего число байт которые нужно выделить для структур XSQLDA для ввода и вывода. XSQLDA_LENGTH определен следующим образом:</p>
<p>#define XSQLDA_LENGTH (n) (sizeof (XSQLDA) + (n &#8211; 1) * sizeof(XSQLVAR))</p>
<p>n - число параметров в cтроке-инструкции, или число элементов в списке - select, возвращенных запросом. Например, следующая инструкция C использует макрокоманду XSQLDA_LENGTH, чтобы определить сколько памяти надо выделить для XSQLDA с 5 параметрами или возвращаемыми элементами:</p>
<p>XSQLDA *my_xsqlda;</p>
<p>. . .</p>
<p>my_xsqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(5));</p>
<p>. . .</p>
<p>Константные макросы типов данных SQL</p>
<p>InterBase определяет набор макро констант для представления типов данных SQL и&nbsp;&nbsp; NULL &#8211; состояния информации в XSQLVAR. Приложение должно использовать эти макро константы, для определения типов данных параметров и&nbsp; типов данных элементов списка -select в инструкции SQL. Следующая таблица перечисляет каждый тип данных SQL, его соответствующее макро-константное выражение, тип данных C или тип данных определенный InterBase , и используется поле sqlind или нет, чтобы указать параметр или переменную, которая содержит NULL или неопределенные данные:</p>
Тип данных &nbsp; &nbsp; &nbsp; &nbsp;Макрос &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Тип данных С &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;использование sqlind</p>
<p>Array  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_ARRAY  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_QUAD  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>Array  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_ARRAY + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ISC_QUAD  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
Blob  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_BLOB  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_QUAD  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>BLOB  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_BLOB + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_QUAD  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>CHAR  &nbsp; &nbsp; &nbsp; &nbsp;SQL_TEXT  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char[]  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>CHAR  &nbsp; &nbsp; &nbsp; &nbsp;SQL_TEXT + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char[]  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>DATE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_DATE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_DATE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>DATE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_DATE + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_DATE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>DECIMAL  &nbsp; &nbsp; &nbsp; &nbsp;SQL_SHORT, SQL_LONG,</p>
SQL_DOUBLE, or SQL_INT64  &nbsp; &nbsp; &nbsp; &nbsp;int, long, double, or ISC_INT64  &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>DECIMAL  &nbsp; &nbsp; &nbsp; &nbsp;SQL_SHORT + 1,</p>
SQL_LONG + 1,</p>
SQL_DOUBLE + 1,</p>
or SQL_INT64 + 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int, long, double, or ISC_INT64  &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>DOUBLE</p>
<p>PRECISON  &nbsp; &nbsp; &nbsp; &nbsp;SQL_DOUBLE  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;double  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>DOUBLE</p>
<p>PRECISION  &nbsp; &nbsp; &nbsp; &nbsp;SQL_DOUBLE + 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;double  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>INTEGER  &nbsp; &nbsp; &nbsp; &nbsp;SQL_LONG  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;long  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>INTEGER  &nbsp; &nbsp; &nbsp; &nbsp;SQL_LONG + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_LONG  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>FLOAT  &nbsp; &nbsp; &nbsp; &nbsp;SQL_FLOAT  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;float  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>FLOAT  &nbsp; &nbsp; &nbsp; &nbsp;SQL_FLOAT + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;float  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>NUMERIC  &nbsp; &nbsp; &nbsp; &nbsp;SQL_SHORT, SQL_LONG,</p>
SQL_DOUBLE, or SQL_INT64  &nbsp; &nbsp; &nbsp; &nbsp;int, long, double, or ISC_INT64  &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>NUMERIC &nbsp; &nbsp; &nbsp; &nbsp; SQL_SHORT + 1,</p>
SQL_LONG + 1,</p>
SQL_DOUBLE + 1,</p>
or SQL_INT64 + 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int, long, double, or ISC_INT64  &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>SMALLINT  &nbsp; &nbsp; &nbsp; &nbsp;SQL_SHORT  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>SMALLINT  &nbsp; &nbsp; &nbsp; &nbsp;SQL_SHORT + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>TIME  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_TIME  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_TIME  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>TIME  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SQL_TIME + 1  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_TIME  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>TIMESTAMP  &nbsp; &nbsp; &nbsp; &nbsp;SQL_TIMESTAMP  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ISC_TIMESTAMP  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>TIMESTAMP  &nbsp; &nbsp; &nbsp; &nbsp;SQL_TIMESTAMP + 1  &nbsp; &nbsp; &nbsp; &nbsp;ISC_TIMESTAMP  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p>VARCHAR  &nbsp; &nbsp; &nbsp; &nbsp;SQL_VARYING &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Первые 2 байта: short содержащий</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; длину символьной строки;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; хранит байты: char [] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;No</p>
<p>VARCHAR  &nbsp; &nbsp; &nbsp; &nbsp;SQL_VARYING + 1 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Первые 2 байта: short содержащий</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; длину символьной строки;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; хранит байты: char [] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Yes</p>
<p class="note">Примечание</p>
<p>DECIMAL и типы данных NUMERIC хранятся внутри БД как SMALLINT, INTEGER, DOUBLE PRECISION, или 64-разрядные целочисленные типы данных. Чтобы определить правильное макро выражение для&nbsp; представления столбцов&nbsp; DECIMAL или&nbsp; NUMERIC, используйте isql, чтобы узнать определение столбца таблицы, и увидеть, как InterBase хранит данные столбца, а затем выбрать соответствующее макро выражение.</p>
<p>Информация о типе данных&nbsp; параметра или элемента списка-select содержится в поле sqltype структуры XSQLVAR. Значение, содержащееся в sqltype предоставляет два вида информации:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Тип данных параметра или select-списка.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Используется ли sqlind для показа значения NULL. Если sqlind используется, его значение определяет, является ли параметр или элемент списка -select NULL (-1), или не NULL (0):</td></tr></table></div>
<p>Например, если sqltype равняется SQL_TEXT, параметр или элемент списка -select&nbsp; это CHAR, который не использует sqlind для проверки значения NULL (потому что&nbsp; теоретически значения NULL не позволяются в этом случае). Если sqltype равняется SQL_TEXT + 1, то sqlind может быть проверен, чтобы увидеть, является ли параметр или элемент списка -select&nbsp;&nbsp; NULL:</p>
<p>Выражение языка C, sqltype &amp; 1, обеспечивает полезную проверку того, может ли параметр или элемент списка -select содержать NULL. Выражение равно 0, если параметр или элемент списка выбора не могут содержать NULL, и 1, если параметр или элемент списка выбора могут содержать NULL. Следующий фрагмент кода демонстрирует, как использовать это выражение:</p>
<pre>if (sqltype &amp; 1 == 0)
{
/* параметр не может содержать NULL */
}
else
{
/* параметр может содержать NULL*/
}
</pre>

<p>По умолчанию, и isc_dsql_prepare () и isc_dsql_describe () возвращают макро выражение type + 1, так что sqlind должен всегда проверяться на NULL&nbsp; значения с этими инструкциями.</p>
<p>Обработка переменных строк данных</p>
<p>Типы данных VARCHAR, CHARACTER VARYING, и NCHAR VARYING&nbsp; требуют осторожной обработки в DSQL. Первые два байта этих типов данных содержат&nbsp; информацию о длине строки, а остаток от данных содержит саму строку данных, для обработки.</p>
<p>Чтобы избежать необходимости писать код, для извлечения и обработки строки переменной длины в приложении, можно привести эти типы данных к фиксированной длине, используя макрокоманды SQL.</p>
<p>Приложения могут, вместо этого, обнаруживать и обрабатывать данные переменной длины напрямую. Чтобы&nbsp; так делать, они должны извлечь первые два байта из строки, чтобы определить длину&nbsp; строки, затем прочитать строку, " байт за байтом ", в буфер с нулевым символом в конце.</p>
<p>Обработка типов данных NUMERIC и DECIMAL</p>
<p>Типы данных DECIMAL и NUMERIC  внутри БД храняться как SMALLINT, INTEFER, DOUBLE</p>
<p>PRECISION, или 64-разрядное целый тип данных, в зависимости от точности и масштаба, определенного для столбца, который использует эти типы. Определите как значения&nbsp; DECIMAL или значения NUMERIC фактически храняться в базе данных, используя isql, чтобы проверить определение столбца таблице. У NUMERIC  данные фактически сохраняются как DOUBLE PRECISION.</p>
<p>Когда DECIMAL или значение NUMERIC храняться как SMALLINT, INTEGER, или 64-разрядное целое, значение хранится как целое число. Во время поиска в DSQL, поле sqlscale  XSQLVAR устанавливается в отрицательное число, которое показывает коэффициент(фактор) 10&nbsp; на который целое число (возвращенное в sqldata), должно быть разделено, чтобы получился правильный NUMERIC или значение DECIMAL с его дробной частью. Если sqlcale -1, то число должно быть разделено на 10, если это&nbsp; -2, то номер должен быть разделен 100, -3 1000, и т.д.</p>
<p>Приведение типов данных</p>
<p>Иногда при обработке DSQL входных параметров и элементов списка выбора, желательно или необходимо привести один тип данных к другому. Этот процесс упомянут как приведение типов данных. Например, приведение типов часто используется, когда параметры или элементы списка выбора имеют тип VARCHAR.&nbsp; Приведение данных из SQL_VARYING к SQL_TEXTможет быть упрощена. Приведение возможно только для совместимых типов данных. Например, SQL_VARYING к SQL_TEXT, или SQL_SHORT к SQL_LONG.</p>
<p>Приведение символьных типов данных</p>
<p>Чтобы привести SQL_VARYING&nbsp; к SQL_TEXT , измените поле sqltype структуры XSQLVAR в параметре или&nbsp; элементе списка выбора к желаемой макрокоманде типа данных SQL. Например, следующая инструкция предполагает, что var - указатель на структуру XSQLVAR, и что она содержит тип данных SQL_VARYING , нужно преобразовать) к SQL_TEXT:</p>
<p>var - &gt; sqltype = SQL_TEXT;</p>
<p>После приведения символьного типа данных, обеспечьте надлежащее количество памяти для него. Поле sqllen структуры XSQLVAR содержит информацию о размере неприведенных данных. Установите поле sqldata структуры XSQLVAR равным адресу данных.</p>
<p>Приведение числовых типов данных</p>
<p>Чтобы привести один числовой тип данных к другому, измените поле sqltype поле&nbsp; в XSQLVAR структуре&nbsp; параметре или&nbsp; элемента списка выбора к желательной макрокоманде типа данных SQL . Например, следующая инструкция предполагает, что var - указатель на структуру XSQLVAR, и что она содержит SQL_SHORT тип данных, преобразуем его к SQL_LONG:</p>
<p>var- &gt; sqltype = SQL_LONG;</p>
<p>ВАЖНО Не приводите больший тип данных к меньшему. Данные могут быть потеряны при такой трансляции.</p>
<p>Установка NULL индикатора</p>
<p>Если параметр или элемент списка выбора содержат значение NULL, поле sqlind должно использоваться, чтобы индицировать состояние NULL. Соответствующая память должна быть выделена для sqlind заранее.</p>
<p>Перед вставкой установите sqlind к -1 показывая, что значения NULL являются правомерными. Иначе, установите sqlind к 0.</p>
<p>После выбора, sqlind -1 указывает, что поле содержит значение NULL. Другие значения указывают, что поле содержит не-NULL данные.</p>
<p>Выравнивание числовых данных(плохо переведен)</p>
<p>Обычно, когда переменная с числовым типом данных создана, компилятор будет гарантировать, что переменная сохранена в должным образом выровненном адресе, но когда числовые данные сохранены в динамически выделенном буфере,&nbsp; программист должен делать предосторожности, чтобы гарантировать, что&nbsp; память должным образом выровнена. Некоторые платформы, в особенности с процессорами RISC, требуют, чтобы числовые данные в динамически выделенных структурах памяти были выровнены должным образом в памяти. Выравнивание зависимо, и от типа данных&nbsp; и от платформы. Например, short число на Sun SPARCstation должно быть расположено в адресе, делимом 2, в то время как long на той же самой платформе должен быть расположен в адресе, делимом 4. В большинстве случаев, элемент данных должным образом выровнен, если адрес его стартового байта делимый правильным номером выравнивания. Консультируйтесь с определенной системой и документацией компилятора для требований выравнивания.Полезное правило бегунка - то, что размер типа данных является всегда имеющим силу номером выравнивания для типа данных. Для данного типа T, если размер (T) равняется n, то адреса делимый n правильно выровнены для T. Следующее макро выражение может использоваться, чтобы выровнять данные:</p>
<p> #define ALIGN (ptr, n) ((ptr + n - 1) и ~ (n - 1))))</p>
<p>Где ptr - указатель на символ.Следующий код иллюстрирует, как макрокоманда ALIGN могла бы использоваться:</p>
<p>char *buffer_pointer, *next_aligned;</p>
<p>next_aligned = ALIGN(buffer_pointer, sizeof(T));</p>
<p>Методы программирования на DSQL</p>
<p>Существует четыре возможных метода программирования DSQL  для обработки строк -инструкций SQL. Лучший метод для обработки строки зависит от типа инструкции SQL в строке, и содержит она или нет метки - заполнители для параметров. Следующая&nbsp; таблица объясняет, как определить соответствующий метод обработки для SQL строки:</p>
Это запрос? &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Имеются ли метки-заполнители &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Определения метода</p>
<p>Нет  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Нет  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;метод 1</p>
<p>Нет &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Да  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;метод 2</p>
<p>Да &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Нет  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;метод 3</p>
Да  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Да &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;метод&nbsp; 4</p>
<p>Рассмотрим далее все четыре метода</p>
<p>Метод 1: Инструкция не является запросом и не содержит параметров</p>
<p>Cуществуют два способа обработки строки - инструкции SQL содержащей инструкции не являющиеся запросом и без параметров метки - заполнителя:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Используйте isc_dsql_execute_immediate (), чтобы подготовить и выполнить строку сразу.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Используйте isc_dsql_allocate_statement () чтобы выделить инструкцию для выполнения строки - инструкции, и isc_dsql_prepare (), чтобы пронализировать инструкцию для выполнения и назначить ей имя, затем используйте isc_dsql_execute () для выполнения инструкции как требуется в приложении.</td></tr></table></div>
<p>Использование isc_dsql_execute_immediate( )</p>
<p>Для исполнения инструкции сразу, используется isc_dsql_execute_immediate():</p>
1. Cоздайте строку содержащую инструкцию SQL. Например, следующая инструкция создает строку инструкции SQL:</p>
&nbsp;</p>
<p>char *str = "UPDATE DEPARTMENT SET BUDGET = BUDGET * 1.05";</p>
<p> &nbsp; 2. Проведите синтаксический анализ и выполните инструкцию, используя isc_dsql_execute_immediate ():</p>
<p>isc_dsql_execute_immediate(status_vector, &amp;db1, &amp;trans ,0, str, 1, NULL);</p>
<p class="note">Примечание: isc_dsql_execute_immediate () можно использовать и так. Например:</p>
<p>isc_dsql_execute_immediate(status_vector, &amp;db1, &amp;trans, 0,</p>
<p>"UPDATE DEPARTMENT SET BUDGET = BUDGET * 1.05", 1, NULL);</p>
<p>Использование isc_dsql_prepare( ) и isc_dsql_execute( )</p>
<p>Исполнение инструкций по этапам используются isc_dsql_allocate_statement(),</p>
<p>isc_dsql_prepare(), и isc_dsql_execute():</p>
<p>1. Создаем строку инструкции SQL:</p>
<p>char *str = "UPDATE DEPARTMENT SET BUDGET = BUDGET * 1.05";</p>
<p>2. Объявляем и инициализируем дескриптор SQL инструкции, который выделяется с помощью isc_dsql_allocate_statement():</p>
<p>isc_stmt_handle stmt; /* Обьявление дескриптора инструкции. */</p>
<p>stmt = NULL; /* Установите дескриптор инструкции в NULL. */</p>
<p>. . .</p>
<p>isc_dsql_allocate_statement(status_vector, &amp;db1, &amp;stmt);</p>
<p>3. Анализируем строку ф-ей isc_dsql_prepare(). Она устанавливает дескриптор инструкции stmt к нужному формату. Этот дескриптор будет потом использован в вызове isc_dsql_execute():</p>
<p>isc_dsql_prepare(status_vector, &amp;trans, &amp;stmt, 0, str, 1, NULL);</p>
<p class="note">Примечание: isc_dsql_prepare() также мо;жно вызывать и так.</p>
<p>isc_dsql_prepare(status_vector, &amp;trans, &amp;stmt, 0,</p>
<p>"UPDATE DEPARTMENT SET BUDGET = BUDGET * 1.05", 1, NULL);</p>
<p>4. Выполняем инструкцию используя isc_dsql_execute().</p>
<p>isc_dsql_execute(status_vector, &amp;trans, &amp;stmt, 1, NULL);</p>
<p>Метод 2: Инструкция не-запрос с параметрами</p>
<p>Существует два этапа&nbsp; обработки строки -инструкции SQL содержащий инструкции не-запроса с параметрами метки - заполнителя:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Создание структуры ввода XSQLDA для обработки строки инструкции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Подготовка и выполнения строки инструкции с параметрами.</td></tr></table></div>
<p>Создание структуры ввода XSQLDA</p>
<p>Параметры метки - заполнители заменяются фактическими данными перед тем как подготовленная строка инструкции SQL будет выполнена. Поскольку эти параметры неизвестны&nbsp; когда&nbsp; строка-инструкция создана, то надо создать XSQLDA ввода , чтобы подставить во время выполнения значения параметров. Для подготовки XSQLDA, следуйте этими шагами:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Объявите переменную указывающую на XSQLDA с необходимыми для обработки параметрами. Например, следующее обьявление создает XSQLDA ввода на которую указывает in_sqlda: &nbsp; &nbsp; &nbsp; &nbsp;XSQLDA *in_sqlda;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Объявите необязательную переменную для доступа к структуре XSQLVAR указатель на которую содержится в XSQLDA:</td></tr></table></div>XSQLVAR *var;</p>
Объявление указателя на структуру XSQLVAR необязательно, но может упростить ссылку на эту структуру в последующих инструкциях.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Выделите память для XSQLDA используя макрос XSQLDA_LENGTH. Следующая инструкция выделяет память для XSQLDA и передает указатель на нее в переменную in_sqlda:</td></tr></table></div>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(10));</p>
В этой инструкции выделяется место для 10 структур XSQLVAR, позволяя XSQLDA хранить до 10 параметров.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Установите поле версии XSQLDA в значение SQLDA_VERSION1, а полю sqln  присвойте число зарезервированных структур XSQLVAR:</td></tr></table></div>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in_sqlda-&gt;sqln = 10;</p>
<p>Подготовка и выполнение инструкции с параметрами</p>
<p>После создания XSQLDA для передачи параметров в SQL инструкцию, SQL инструкция может быть создана и подготовлена. Локальные&nbsp; переменные, соответствующие параметрам метки - заполнителя в строке должны быть присвоены соответствующим полям sqldata структурах XSQLVAR:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Создайте строку с параметрами метками-заполнителями, например:</td></tr></table></div>&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; char *str = "UPDATE DEPARTMENT SET BUDGET = ?, LOCATION = ?";</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Эта инструкция содержит два параметра BUDGET и LOCATION.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Объявите и инициализируйте дескриптор SQL инструкции, место подкоторый выделяется с помощью isc_dsql_allocate():</td></tr></table></div>&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_stmt_handle stmt; /* Обьявите дескриптор инструкции. */</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; stmt = NULL; /* Установите в NULL перед выделением памяти. */</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; . . .</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dsql_allocate_statement(status_vector, &amp;db1, &amp;stmt);</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Проанализируйте строковую инструкцию с помощью isc_dsql_prepare (), она производит грамматический разбор SQL предложения. Она установит дескриптор инструкции (stmt) ко внутреннему представлению. Дескриптор инструкции используется в последующих запросах к isc_dsql_describe_bind () и isc_dsql_execute ():</td></tr></table></div>&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dsql_prepare(status_vector, &amp;trans, &amp;stmt, 0, str, 1,in_sqlda);</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Используйте isc_dsql_describe_bind () чтобы заполнить&nbsp; XSQLDA ввода информацией о параметрах содержащихся в инструкции SQL:</td></tr></table></div>&nbsp;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dsql_describe_bind(status_vector, &amp;stmt, 1, in_sqlda);</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Сравните значение&nbsp; поля sqln структуры XSQLDA со значением поля sqld, чтобы удостовериться, что выделено достаточно структур XSQLVAR для хранения информации о каждом параметре. Sqln должен быть по крайней мере таким же как sqld. Если не хватает памяти для предварительного размещения дескриптора вывода,&nbsp; то перераспределте память заново таким образом, чтобы отразить число параметров, указанных в sqld, сбросьте sqln и version, установите и их снова, и выполните опять isc_dsql_describe_bind ():</td></tr></table></div>
<pre> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if (in_sqlda-&gt;sqld &gt; in_sqlda-&gt;sqln)
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; n = in_sqlda-&gt;sqld;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; free(in_sqlda);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(n));
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in_sqlda-&gt;sqln = n
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; in_sqlda-&gt;version = SQLDA_VERSION1;
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dsql_describe_bind(status_vector, &amp;stmt, 1, in_sqlda);
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }
</pre>

<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>Обработайте каждый XSQLVAR параметр в структуре XSQLDA. Это выглядит так:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">a.</td><td>Приведите типы данных&nbsp; параметров (необязательно).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">b.</td><td>Выделите&nbsp;&nbsp; память&nbsp; для локальных данных, указанных полем sqldata XSQLVAR. Этот шаг только требуется, если память для локальных переменных выделено до времени выполнения. Следующий пример иллюстрирует динамическое выделение&nbsp; памяти для локальных переменных:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">c.</td><td>Значение параметра должно быть совместимого типа данных(обязательно)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">d.</td><td>Определите&nbsp; индикатор&nbsp; NULL значения для параметра.</td></tr></table></div>&nbsp;</p>
Следующий пример кода иллюстрирует эти шаги, выполненяет цикл для каждой структуры XSQLVAR принадлежащей in_sqlda XSQLDA:</p>
<pre>
for ( i=0, var = in_sqlda-&gt;sqlvar; i &lt; in_sqlda-&gt;sqld; i++, var++ )
{
  /* Обрабатываем здесь каждую XSQLVAR структуру.
   Var указывает на структуру XSQLVAR. */
  dtype = (var-&gt;sqltype &amp; ~1); /* drop NULL flag for now */
  switch(dtype)
  {
   case SQL_VARYING: /* приводит к SQL_TEXT*/
    var-&gt;sqltype = SQL_TEXT;
        /* выделяем память для хранения локальной переменной */
         var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen);
         . . .
         break;
       case SQL_TEXT:
          var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen);
    /* здесь присваивается значение параметру */
       . . .
     break;
       case SQL_LONG:
           var-&gt;sqldata = (char *)malloc(sizeof(long));
     /* присваивается значения параметру */
           *(long *)(var-&gt;sqldata) = 17;
     break;
     . . .
      } /* end of switch statement */
      if (var-&gt;sqltype &amp; 1)
     {
          /* выделяется переменная для NULL индикатора */
           var-&gt;sqlind = (short *)malloc(sizeof(short));
     }
} /* конец цикла */
</pre>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">7.</td><td>Выполните инструкцию. Пример:</td></tr></table></div>&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isc_dsql_execute(status_vector, &amp;trans, &amp;stmt, 1, in_sqlda);</p>
&nbsp;</p>
<p>Повторное выполнение инструкции</p>
<p>Как только строка инструкции не-запроса с параметрами подготовлена, она может быть выполнена столько раз сколько требуется в приложении. Перед каждым последующим выполнением, XSQLDA ввода может быть связан новым параметром и новым индикатором&nbsp; NULL.</p>
<p>Метод 3: Инструкция запрос без параметров</p>
<p>Обработка инструкций запросов без параметров происходит за три шага:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Подготовьте XSQLDA вывода для обработки элементов списка выбора возвращенных при выполнении запроса.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Подготовьте строку инструкции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Используйте курсор для выполнения инструкции и извлечения элементов списка выбора из XSQLDA вывода.</td></tr></table></div>
<p>Подготовка XSQLDA для вывода данных.</p>
<p>Большинство запросов возвращает одну или несколько строк данных, упомянутых как список выбора. Поскольку число и вид возвращенных элементов&nbsp; неизвестны при создании инструкции - строки, то надо создать XSQLDA  для вывода данных, которая будет хранить элементы списка выбора, возвращеннные во время выполнения. Для подготовки XSQLDA следуйте&nbsp; этими шагами:</p>
<p>1. Объявите&nbsp; переменную типа XSQLDA которая будет хранить данные столбцов каждой строки, выбираемой из результатов запроса. Например, следующее объявление создает XSQLDA вывода, называемое out_sqlda:</p>
<p>XSQLDA *out_sqlda;</p>
<p>2. Объявите необязательную переменную для доступа к структуре XSQLVAR:</p>
<p>XSQLVAR *var;</p>
<p>Объявление указателя на структуру XSQLVAR не так уж необходимо, но может упростить ссылку на на структуру в последующих инструкциях.</p>
<p>3. Выделите память для XSQLDA используя макрос XSQLDA_LENGTH. Следующая инструкция выделяет память для хранения out_sqlda:</p>
<p>out_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(10));</p>
<p>В этой инструкции выделяется память для десяти структур XSQLVAR, позволяя разместить до 10 элементов списка выбора.</p>
<p>4. Установите поля&nbsp; version в SQLDA_VERSION1 и поля sqln в число выделенных XSQLVAR:</p>
<p>out_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p>out_sqlda-&gt;sqln = 10;</p>
<p>Подготовка инструкции запроса без параметров</p>
<p>После того, как XSQLDA создана для хранения элементов&nbsp; возвращаемых инструкцией запроса,&nbsp; строка инструкция может быть создана, подготовлена, и описана. Когда строка инструкция выполнена, InterBase создает список выбора&nbsp; строк как результат запроса.</p>
<p>Подготовка строки запроса включает следующие шаги:</p>
<p>1. Создайте саму строку:</p>
<p>char *str = "SELECT * FROM CUSTOMER";</p>
<p>Инструкция, кажется,&nbsp; имеет только один элемент списка выбора (*). Звездочка - символ подстановочных знаков, который замещает все столбцы в таблице, так что фактическое число возвращенных элементов равняется числу столбцов в таблице.</p>
<p>2. Объявите и инициализируйте дескриптор инструкции с помощью isc_dsql_allocate():</p>
<p>isc_stmt_handle stmt; /* Объявление дескриптора инструкции. */</p>
<p>stmt = NULL;</p>
<p>. . .</p>
<p>isc_dsql_allocate_statement(status_vector, &amp;db1, &amp;stmt);</p>
<p>3. Проанализируйте строку с помощью isc_dsql_prepare (), она выполняет грамматический разбор инструкции, и заполняет stmt. Дескриптор инструкции используется в последующих запросах к isc_dsql_describe_bind () и isc_dsql_execute ():</p>
<p>isc_dsql_prepare(status_vector, &amp;trans, &amp;stmt, 0, str, 1, NULL);</p>
<p>4. Используйте isc_dsql_describe () для заполения структуры XSQLDA вывода информацией об элементах списка выбора(столбцах), возвращаемых инструкцией:</p>
<p>isc_dsql_describe(status_vector, &amp;stmt,1, out_sqlda);</p>
<p>5. Сравните значение&nbsp; поля sqln структуры XSQLDA со значением поля sqld, чтобы удостовериться, что выделено достаточно структур XSQLVAR для хранения информации о каждом параметре. Sqln должен быть по крайней мере таким же как sqld. Если не хватает памяти для предварительного размещения дескриптора вывода,&nbsp; то перераспределте память заново таким образом, чтобы отразить число параметров, указанных в sqld, сбросьте sqln и version, установите и их снова, и выполните опять isc_dsql_describe_bind ():</p>
<pre>if (out_sqlda-&gt;sqld &gt; out_sqlda-&gt;sqln)
{
   n = out_sqlda-&gt;sqld;
  free(out_sqlda);
  out_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(n));
  out_sqlda-&gt;sqln = n;
  out_sqlda-&gt;version = SQLDA_VERSION1;
  isc_dsql_describe(status_vector, &amp;trans, 1, out_sqlda);
}
</pre>

<p>6. Обработайте каждый XSQLVAR параметр в структуре XSQLDA. Это выглядит так:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">e.</td><td>Приведите типы данных&nbsp; параметров (необязательно).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">f.</td><td>Выделите&nbsp;&nbsp; память&nbsp; для локальных данных, указанных полем sqldata XSQLVAR. Этот шаг только требуется, если память для локальных переменных выделена до времени выполнения. Следующий пример иллюстрирует динамическое выделение&nbsp; памяти для локальных переменных:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">g.</td><td>Значение параметра должно быть совместимого типа данных(обязательно)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">h.</td><td>Определите&nbsp; индикатор&nbsp; NULL - значения для параметра.</td></tr></table></div><p>Следующий пример кода иллюстрирует эти шаги, и выполняет цикл для каждой структуры XSQLVAR принадлежащей out_sqlda XSQLDA:</p>
<pre>
for (i=0, var = out_sqlda-&gt;sqlvar; i &lt; out_sqlda-&gt;sqld; i++, var++)
{
dtype = (var-&gt;sqltype &amp; ~1); /* drop flag bit for now */
switch(dtype)
{
case SQL_VARYING:
var-&gt;sqltype = SQL_TEXT;
var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen + 2);
break;
case SQL_TEXT:
var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen);
break;
case SQL_LONG:
var-&gt;sqldata = (char *)malloc(sizeof(long));
break;
. . .
/* обработка других типов */
} /* конец инструкции switch */
if (var-&gt;sqltype &amp; 1)
{
/* выделяем память для хранения NULL индикатора */
var-&gt;sqlind = (short *)malloc(sizeof(short));
}
} /* конец цикла */
</pre>

<p>Выполнение&nbsp; строки инструкции в пределах контекста курсора</p>
<p>Чтобы осуществлять поиск элементов&nbsp; списка выбора из подготовленной инструкции, строка должна быть выполнена в контексте курсора. Все объявления курсора в InterBase &#8211; это фиксированные инструкции, вставленные в приложение прежде, чем оно будет откомпилировано. Разработчики DSQL приложений&nbsp; должны предупреждать потребность в курсорах при написании приложения и объявлять их заранее.</p>
<p>Курсор&nbsp; необходим, чтобы обработать позиционированные инструкции UPDATE И DELETE, сделанные для строк, выбранных с помощью isc_dsql_fetch () для инструкций SELECT, которые определяют необязательное предложение FOR UPDATE OF.</p>
<p>Следующее описание рассматривает ситуации когда курсор необходим.</p>
<p>Конструкция выполнения цикла выбора используется, чтобы выбрать отдельную строку из курсора и обработать каждый элемент списка выбора (столбец) в этой строке до выбора следующей строки. Выполняйте&nbsp; строку - инструкцию в контексте курсора и выбирайте строки элементов списка выбора по следующим&nbsp; шагам:</p>
<p>1. Выполните подготовленную инструкцию с помощью isc_dsql_execute():</p>
<p>isc_dsql_execute(status_vector, &amp;trans, &amp;stmt, 1, NULL);</p>
<p>2. Объявите и откройте курсор для инструкции с помощью isc_dsql_set_cursor_name(). К примеру, следующая инструкция объявляет курсор с именем «dyn_cursor», для SQL инструкции stmt:</p>
<p>isc_dsql_set_cursor_name(status_vector, &amp;stmt,"dyn_cursor", NULL);</p>
<p>Открытие курсора выполняет инструкцию, и нужный набор строк будет найден</p>
<p>3. Выберите одну строку и сразу&nbsp; обработайте элементы списка выбора (столбцы), которые она содержит с помощью isc_dsql_fetch (). Например, следующий цикл выбирает одну строку из dyn_cursor и сразу обрабатывает каждый элемент в выбранной строке&nbsp; с помощью специфической для приложения функцией, называемой process_column ():</p>
<pre>
while ( ( fetch_stat =isc_dsql_fetch(status_vector, &amp;stmt, 1, out_sqlda) ) == 0)
{
for (i = 0; i &lt; out_sqlda-&gt;sqld; i++)
{
process_column(sqlda-&gt;sqlvar[i]);
}
}
if (fetch_stat != 100L)
{
/* isc_dsql_fetch возвращает 100 если нет больше строк для выбора*/
SQLCODE = isc_sqlcode(status_vector);
isc_print_sqlerror(SQLCODE, status_vector);
return(1);
}
</pre>

<p>Process_column () - функция упомянутая в этом примере обрабатывает каждый возвращенный элемент списка выбора. Следующий код иллюстрирует, как такая функция может быть написана:</p>
<pre>
void process_column(XSQLVAR *var)
{
/* проверка на NULL значение */
if ((var-&gt;sqltype &amp; 1) &amp;&amp; (*(var-&gt;sqlind) = -1))
{
/* Здесь определяется NULL значение */
}
else
{
/* обработка данных*/
}
. . .
}
</pre>

<p>4.&nbsp; Когда все строки выбраны курсор закройте с помощью isc_dsql_free_statement():</p>
<p>isc_dsql_free_statement(status_vector, &amp;stmt, DSQL_close);</p>
<p>Повторное выполнение инструкции запроса без параметров</p>
<p>Как только строка инструкции запроса без параметров подготовлена, она может быть выполнен столько раз сколько требуется в приложении,&nbsp; закрывая и повторно открывая&nbsp; курсор.</p>
<p>Метод 4: Инструкция запроса с параметрами</p>
<p>По этим четырем шагам происходит обработка строки запроса с параметрами метками-заполнителями:</p>
<p>1. Подготовка структуры ввода XSQLDA для обработки строк параметров.</p>
<p>2. Подготовка структуры вывода XSQLDA для обработки элементов выборки возвращенных при выполнении запроса.</p>
<p>3. Подготовка строки инструкции и ее параметров.</p>
<p>4. Использование курсора выполняющего инструкцию использующую переменные входных параметров из структуры ввода XSQLDA, и&nbsp; поиск элементов выборки из структуры вывода XSQLDA.</p>
<p>Подготовка структуры ввода XSQLDA</p>
<p>Параметры метки - заполнители заменяются фактическими данными перед тем как подготовленная строка инструкции SQL будет выполнена. Поскольку эти параметры - неизвестны&nbsp; когда&nbsp; строка-инструкция создана, то надо создать XSQLDA ввода , чтобы подставить во время выполнения значения параметров. Для подготовки XSQLDA, следуйте этими шагами:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Объявите переменную указывающую на XSQLDA с необходимыми для обрабоки параметрами. Например, следующая декларация создает XSQLDA на который указывает in_sqlda: &nbsp; &nbsp; &nbsp; &nbsp;XSQLDA *in_sqlda;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Объявите необязательную переменную для доступа к структуре XSQLVAR указатель на которую содержится в XSQLDA:</td></tr></table></div>XSQLVAR *var;</p>
Объявление указателя на структуру XSQLVAR необязательно, но может упростить ссылку на на структуру в последующих инструкциях.</p>
3. Выделите память для XSQLDA используя макрос XSQLDA_LENGTH. Следующая инструкция выделяет память для XSQLDA и передает указатель на нее в переменную in_sqlda:</p>
&nbsp;</p>
in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(10));</p>
&nbsp;</p>
В этой инструкции выделяется место для 10 структур XSQLVAR, позволяя XSQLDA хранить до 10 параметров.</p>
&nbsp;</p>
4. Установите поле версии XSQLDA в значение SQLDA_VERSION1, а полю sqln присвойте число зарезервированных структур XSQLVAR:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; in_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; in_sqlda-&gt;sqln = 10;</p>
<p>Подготовка структуры XSQLDA для вывода данных</p>
<p>Большинство запросов возвращается одну или несколько строк данных, упомянутых как список выбора. Поскольку число и вид возвращенных элементов&nbsp; неизвестны при создании инструкции - строки, то надо создать XSQLDA  для вывода данных, которая будет хранить элементы списка выбора, возвращеннные во время выполнения. Для подготовки XSQLDA следуйте&nbsp; этими шагами:</p>
<p>1. Объявите&nbsp; переменную типа XSQLDA которая будет хранить данные столбцов каждой строки, выбранной в запросе. Например, следующее объявление создает XSQLDA, называемое out_sqlda:</p>
<p>XSQLDA *out_sqlda;</p>
<p>2. Объявление необязательной переменной для доступа к структуре XSQLVAR:</p>
<p>XSQLVAR *var;</p>
<p>Объявление указателя на структуру XSQLVAR не так уж необходимо, но может упростить ссылку на на структуру в последующих инструкциях.</p>
<p>3. Выделите память для XSQLDA используя макрос XSQLDA_LENGTH. Следующая инструкция выделяет память для хранения out_sqlda:</p>
<p>out_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(10));</p>
<p>В этой инструкции выделяется память для десяти структур XSQLVAR, позволяя разместить до 10 элементов списка выбора.</p>
<p>4. Установите поля&nbsp; version в SQLDA_VERSION1 и поля sqln в число выделенных XSQLVAR:</p>
<p>out_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p>out_sqlda-&gt;sqln = 10;</p>
<p>Подготовка инструкции запроса с параметрами</p>
<p>После того как структуры XSQLDA ввода и вывода были созданы для передачи параметров строке инструкции, и принятия возвращенных элементов&nbsp; списка выборки после исполнения инструкции, строка - инструкция может быть создана и подготовлена. Когда&nbsp; строка инструкция подготовлена, InterBase заменяет параметры метки - заполнителя в строке информацией о фактических используемых параметрах. Информация о параметрах должна быть передана в структуру ввода XSQLDA (и возможно откорректирована) прежде, чем инструкция будет выполнена. Когда строка-инструкция выполнена, InterBase сохраняет элементы списка выбора в структуре вывода XSQLDA.</p>
<p>Подготовка SQL инструкции с метками-заполнителями идет следующими шагами:</p>
<p>1.&nbsp; Создайте саму строку с SQL инструкцией.</p>
<p>char *str = "SELECT * FROM DEPARTMENT WHERE BUDGET = ?,LOCATION = ?";</p>
<p>Эта инструкция содержит два параметра: значение связанное со столбцом BUDGET и значение связанное со столбцом LOCATION.</p>
<p>2. Объявите и инициализируйте дескриптор SQL инструкции с помощью</p>
<p>isc_dsql_allocate():</p>
<p>isc_stmt_handle stmt;</p>
<p>stmt = NULL;</p>
<p>. . .</p>
<p>isc_dsql_allocate_statement(status_vector, &amp;db1, &amp;stmt);</p>
<p>3. Подготовьте строку&nbsp; с помощью isc_dsql_prepare (). Она устанавливает дескриптор инструкции (stmt) в правильную синтаксическую форму. Дескриптор инструкции используется в последующих вызовах к isc_dsql_describe (), isc_dsql_describe_bind (), и isc_dsql_execute2 ():</p>
<p>isc_dsql_prepare(status_vector, &amp;trans, &amp;stmt, 0,str, 1, out_xsqlda);</p>
<p>4. Используйте isc_dsql_describe_bind () чтобы заполнить структуру ввода XSQLDA информацией о параметрах содержащихся в инструкции SQL:</p>
<p>isc_dsql_describe_bind(status_vector, &amp;stmt, 1, in_xsqlda);</p>
<p>5. Сравните поле sqln структуры XSQLDA с полем sqld, чтобы определить может ли&nbsp; дескриптор&nbsp; ввода принять то число параметров содержащихся в инструкции. Если нет, освободите&nbsp; предварительно выделеннeю память для&nbsp; дескриптора ввода, и заново перераспределите память чтобы отразить число параметров указанных sqld, сбросьте поля sqln и version и выполните isc_dsql_describe_bind () снова:</p>
<pre>
if (in_sqlda-&gt;sqld &gt; in_sqlda-&gt;sqln)
{
n = in_sqlda-&gt;sqld;
free(in_sqlda);
in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(n));
in_sqlda-&gt;sqln = n;
in_sqlda-&gt;version = SQLDA_VERSION1;
isc_dsql_decribe_bind(status_vector, &amp;stmt, 1, in_xsqlda);
}
</pre>

<p>6. Обработайте каждый XSQLVAR параметр структуры ввода XSQLDA. Обработка&nbsp; параметров структуры идет в четыре шага:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">a.</td><td>Приведите типы данных&nbsp; параметров (необязательно).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">b.</td><td>Выделите&nbsp;&nbsp; память&nbsp; для локальных данных, указанных полем sqldata XSQLVAR. Этот шаг только требуется, если память для локальных переменных выделена до времени выполнения. Следующий пример иллюстрирует динамическое выделение&nbsp; памяти для локальных переменных:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">c.</td><td>Значение параметра должно быть совместимого типа данных(обязательно)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">d.</td><td>Определите&nbsp;&nbsp;&nbsp; NULL значение индикатора для параметра</td></tr></table></div><p>Эти шаги должны быть представлены в следующем порядке. Следующий пример кода иллюстрирует эти шаги, и выполняет цикл для каждой структуры XSQLVAR в in_sqlda XSQLDA:</p>
<pre>
for (i=0, var = in_sqlda-&gt;sqlvar; i &lt; in_sqlda-&gt;sqld; i++, var++)
{
/* Обработайте каждый XSQLVAR параметр здесь. 
Var – указатель на структуру параметр*/
dtype = (var-&gt;sqltype &amp; ~1); 
switch(dtype)
{
case SQL_VARYING: /* приведение к  SQL_TEXT */
var-&gt;sqltype = SQL_TEXT;
/* allocate proper storage */
var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen);
/* Предоставьте значение для параметра. See case SQL_LONG. */
. . .
break;
case SQL_TEXT:
var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen);
/* Provide a value for the parameter. See case SQL_LONG. */
. . .
break;
case SQL_LONG:
var-&gt;sqldata = (char *)malloc(sizeof(long));
/* Присваиваем занчение пармтру. */
*(long *)(var-&gt;sqldata) = 17;
break;
. . .
} /* конец  инструкции switch */
if (sqltype &amp; 1)
{
/* Резервирует переменную для хранения индикатора NULL */
var-&gt;sqlind = (short *)malloc(sizeof(short));
}
} /* end of for loop */
</pre>

<p>7. Используйте isc_dsql_describe () чтобы заполнить структуру вывода XSQLDA информацией о элементах списка выбора, возвращаемых инструкцией:</p>
<p>isc_dsql_describe(status_vector, &amp;trans, &amp;stmt, out_xsqlda);</p>
<p>8. Сравните поле sqln структуры XSQLDA с полем sqld, чтобы определить может ли дескриптор вывода хранить число элементов списка выбора, указанных в инструкции. Если нет, освободите выделенную предварительно память&nbsp; для дескриптору вывода, затем перераспределите так память чтобы отразить число элементов списка выбора, указанных sqld, сбросьте sqln и version, и выполните все для output&nbsp; снова:</p>
<pre>
if (out_sqlda-&gt;sqld &gt; out_sqlda-&gt;sqln)
{
n = out_sqlda-&gt;sqld;
free(out_sqlda);
out_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(n));
out_sqlda-&gt;sqln = n;
out_sqlda-&gt;version = SQLDA_VERSION1;
isc_dsql_describe(status_vector, &amp;trans, &amp;stmt, out_xsqlda);
}
</pre>

<p>9. Подберите структуру XSQLVAR для каждого возвращаемого&nbsp; элемента. Следующие шаги описывают этот процесс:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">e.</td><td>Приведите типы данных&nbsp; параметров (необязательно).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">f.</td><td>Выделите&nbsp;&nbsp; память&nbsp; для локальных данных, указанных полем sqldata XSQLVAR. Этот шаг только требуется, если память для локальных переменных выделена до времени выполнения. Следующий пример иллюстрирует динамическое выделение&nbsp; памяти для локальных переменных:</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">g.</td><td>Значение параметра должно быть совместимого типа данных(обязательно)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">h.</td><td>Определите&nbsp; индикатор&nbsp; NULL значения для параметра.</td></tr></table></div><p>Следующий пример кода иллюстрирует эти шаги, выполняет цикл для каждой структуры XSQLVAR принадлежащей out_sqlda XSQLDA:</p>
<pre>for (i=0, var = out_sqlda-&gt;sqlvar; i &lt; out_sqlda-&gt;sqld; i++, var++)
{
dtype = (var-&gt;sqltype &amp; ~1);/
switch(dtype)
{
case SQL_VARYING:
var-&gt;sqltype = SQL_TEXT;
break;
case SQL_TEXT:
var-&gt;sqldata = (char *)malloc(sizeof(char)*var-&gt;sqllen);
break;
case SQL_LONG:
var-&gt;sqldata = (char *)malloc(sizeof(long));
break;
/* обработка других типов */
} /* конец swicth */
if (var-&gt;sqltype &amp; 1)
{
var-&gt;sqlind = (short *)malloc(sizeof(short));
}
} /* конец цикла */
</pre>

<p>Выполнение инструкции запроса в контексте курсора</p>
<p>Чтобы возвратить элементы списка выборки строки инструкции, строка должна быть выполнена в пределах контекста курсора. Все объявления курсора в InterBase фиксированы, встроенные инструкции вставлены&nbsp; в приложение прежде, чем оно будет откомпилировано. Разработчики DSQL приложений должны предусмотреть потребность в курсорах при написании приложения и объявлять их заранее.</p>
<p>Конструкция&nbsp; цикла используется, чтобы выбрать отдельную строку сразу из курсора и обработать каждый элемент списка выбора (столбец) в той строке прежде, чем будет выбрана следующая строка. Для выполнения инструкции&nbsp; в пределах контекста курсора и поиска строк списка выбора элементов, следуют этими шагами:</p>
<p>1. Выполните инструкцию с помощью isc_dsql_execute2():</p>
<p>isc_dsql_execute2(status_vector, &amp;trans, &amp;stmt, 1,in_xsqlda, out_xsqlda);</p>
<p class="note">Примечание от автора:</p>
<p> &nbsp;&nbsp;&nbsp; При работе с ф-ей isc_dsql_execute2 существует хитрость не указанная в справочнике и служащая иточником ошибок. Если возвращается набор строк и необходимо открытие курсора то вместо out_sqlda надо передавать NULL иначе вернется ошибка. Если заранее известно что вернется одна и только одна строка, то надо передавать out_sqlda как показано в примере, но не создавать курсор. А просто обработать после отработки функции структуру вывода. Так что в этом примере не верно произведен вызов ф-ии.</p>
<p>2. Объявлите и откройте курсор для инструкции строки с помощью</p>
<p>isc_dsql_set_cursor_name(). К примеру, следующая инструкция объявляет курсор dyn_cursor, и для подготовки строки SQL инструкции stmt:</p>
<p>isc_dsql_set_cursor_name(status_vector, &amp;stmt, "dyn_cursor", NULL);</p>
<p>Открытие курсора дает инструкции возможность выполнится, и отыскать активный набор строк .</p>
<p>3. Выберите строки с помощью isc_dsql_fetch () и сразу обработайте элементы списка выбора (столбцы), которые они содержит. Например, следующие цикл делает выбор одной строк&nbsp; из dyn_cursor и сразу обрабатывают каждый элемент в выбранной строке с помощью определенной для приложения функцией, называемой process_column ():</p>
<pre>while ( ( fetch_stat =isc_dsql_fetch(status_vector, &amp;stmt, 1, out_sqlda) ) == 0 )
{
for (i = 0; i &lt; out_sqlda-&gt;sqld; i++)
{
process_column(sqlda-&gt;sqlvar[i]);
}
}
 
if (fetch_stat != 100L)
{
/* isc_dsql_fetch возвращает 100, если нет больше строк оставшихся для выбора */
SQLCODE = isc_sqlcode(status_vector);
isc_print_sqlerror(SQLCODE, status_vector);
return(1);
}
</pre>

<p>4. Когда все строки выбраны закройте курсор с помощью isc_dsql_free_statement():</p>
<p>isc_dsql_free_statement(status_vector, &amp;stmt, DSQL_close);</p>
<p>Повторное выполнение инструкции</p>
<p>Как только строка инструкции запроса с параметрами подготовлена, это может использоваться столько сколько требуется в приложении. Перед каждым последующим использованием, структура ввода XSQLDA может быть снабжена новым параметром и данными индикатора NULL. Курсор должен быть закрыт и повторно открыт прежде, чем произойдет обработка.</p>
<p>Определение неизвестного типа инструкции во время выполнения</p>
<p>Приложение может использовать isc_dsql_sql_info () чтобы определить&nbsp; тип инструкции неизвестный при подготовке инструкции, например когда инструкция вводится пользователем во время выполнения.</p>
<p>Запрашиваемая информация может включать:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Тип инструкции</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Число параметров ввода требуемое для инструкции</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Число параметров вывода возвращаемое инструкцией</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td> Детальную информацию относительно каждого входного параметра или выходного значения , включая его тип данных, масштаб, и длину.</td></tr></table></div><p>Чтобы использовать isc_dsql_sql_info (), выделите буфер списка элементов, который описывает тип требуемой информации, и выделите буфер результатов, куда функция может возвращать нужную информацию. Например, чтобы определить&nbsp; неизвестный тип инструкции, но подготовленной инструкции, вы должны выделить буфер списка элементов с одним элементом, и заполнять его макро константой&nbsp; isc_info_sql_stmt_type, определенной в ibase.h:</p>
<p>char type_item[];</p>
<p>type_item[] = {isc_info_sql_stmt_type};</p>
<p>Обратите внимание, что дополнительная информация о макросах для требуемых элементов может быть найдена в ibase.h по комментарию, “ SQL information items."</p>
<p>Буфер результатов должен быть достаточно большим, чтобы содержать любые данные, возвращенные запросом. Надлежащий размер для этого буфера зависит от требуемой информации. Если не достаточно выделенной памяти куда isc_dsql_sql_info () помещает предопределенное значение, то в последний байт буфера результатов помещается isc_info_truncated. Вообще, когда запрашивается информация о типе инструкции то 8 байт - достаточный размер буфера. Объявление размера больше чем необходимо буферу безопасно. Запрос&nbsp; идентифицирующий тип инструкции возвращает следующую информацию в буфер результатов:</p>
<p>1. Первый байт содержит isc_info_sql_stmt_type.</p>
<p>2. Второй байт содержит число n говорящее о том сколько байт занимает следующее значение.</p>
<p>3. Один или два байта определяют&nbsp; тип инструкции. Следующая таблица показывает возвращаемые типы инструкций:</p>
&nbsp;</p>
Тип &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Числовое значение</p>
<p>isc_info_sql_stmt_select  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1</p>
<p>isc_info_sql_stmt_insert &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2</p>
<p>isc_info_sql_stmt_update &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;3</p>
<p>isc_info_sql_stmt_delete  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4</p>
<p>isc_info_sql_stmt_ddl  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;5</p>
<p>isc_info_sql_stmt_get_segment  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;6</p>
<p>isc_info_sql_stmt_put_segment  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;7</p>
<p>isc_info_sql_stmt_exec_procedure  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;8</p>
<p>isc_info_sql_stmt_start_trans  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;9</p>
<p>isc_info_sql_stmt_commit  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;10</p>
<p>isc_info_sql_stmt_rollback  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;11</p>
isc_info_sql_stmt_select_for_upd  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;12</p>
<p>4. Последний байт, содержит значение isc_info_end (0).</p>
<p>Значения, помещенные в буфер результатов не выровнены. Кроме того, все числа представлены в универсальном формате, с самым младшим байтом сначала, и страшим&nbsp; байтом в конце. Числа со знаком имеют признак в последнем байте. Преобразуйте числа к типу данных, присущему к вашей системе перед их интерпретацией.</p>
<p>Обратите внимание, что вся информация относительно инструкции кроме ее типа может быть более легко определена,&nbsp; вызывав другие функции кроме isc_dsql_sql_info (). Например, чтобы определить информацию, для заполнения структуры ввода XSQLDA, вызовите isc_dsql_describe_bind (). Чтобы заполнить структуру вывода XSQLDA, вызовите isc_dsql_prepare () или isc_dsql_describe ().</p>
<p>Работа с преобразованиями типов</p>
<p>InterBase использует свой формат для внутреннего хранения данных типов TIMESTAMP, TIME, и&nbsp; DATE, но предоставляет следующие вызовы API ф-й для трансляции в эти форматы и обратно:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_decode_sql_date() конвертирует внутренний формат даты IB&nbsp; к формату С структуры date</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_encode_sql_date() делает тоже, но обратно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_decode_sql_time() конвертирует внутренний формат времени IB к формату С структуры time</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_encode_sql_time() делает тоже, но обратно</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_decode_timestamp() конвертирует внутренний формат timestamp IB к формату С структуры timestamp ; Это прежде выполнялось вызовом isc_decode_date ();</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>isc_encode_timestamp() делает тоже, но обратно; Это прежде выполнялось вызовом isc_encode_date ();</td></tr></table></div>
<p>Эти вызовы просто транслируют данные типа datetime (DATE, TIME, и TIMESTAMP)&nbsp; в другие форматы; они не делают непосредственно чтения или записи данных типа datetime . Данные типа datetime  читаюся и пишутся в базу данных, при использовании стандартного&nbsp;&nbsp; синтаксиса DSQL, обрабатываемого с помощью семейства вызовов API&nbsp; isc_dsql.</p>
<p class="note">Примечание</p>
<p>В InterBase 6 тип данных DATE содержит только информацию о дате в диалекте 3 и не доступен в диалекте 1, чтобы избежать неоднозначности. Когда старая база данных перенесеносится к версии 6 диалект 1, все столбцы, которые предварительно имели тип данных DATE,&nbsp; автоматически преобразовываются в TIMESTAMP. Чтобы хранить перенесенные данные в столбце DATE в диалекте 3, Вы должны создать новый столбец в диалекте 3, который имеет тип данных DATE, и затем переместить данные в него. InterBase не позволяет Вам использовать ALTER COLUMN, чтобы изменить тип данных TIMESTAMP в тип данных DATE из-за возможной потери данных.</p>
<p>InterBase также требует, чтобы числа, введенные в базу данных и&nbsp; буфера параметров транзакций были в универсальном формате, с самым последним знаковым байтом. Знаковые числа требуют, чтобы&nbsp; знак был в последнем байте. Системы, которые представляют числа со старшим байтом последним, должны использовать isc_vax_integer (), чтобы полностью изменить порядок байт чисел, введенных в буфер параметров баз данных (DPBs) и&nbsp; буфера параметров транзакций (TPBs).</p>
<p>Преобразование даты и времени из InterBase в формат C</p>
<p>Следующие шаги показывают, как преобразовать тип данных TIMESTAMP из InterBase формата в&nbsp; формат C; те же самые шаги&nbsp; используются, чтобы преобразовать типы данных TIME И DATE. Начиная с InterBase 6, тип данных TIMESTAMP заменяет старый тип данных DATE, используемый в более ранних версиях .</p>
<p>Для выборки timestamp из таблицы, и преобразовывания его к форме пригодной для использования в C программах, следуют этими шагами:</p>
<p>1. Создайте&nbsp; переменную для C time структуры. Большинство C и систем разработки программ C++ обеспечивает тип, struct tm, для C time структур в time.h файле заголовка. Следующий код C включает этот файл заголовка, и объявляет переменную типа struct tm:</p>
<p>#include &lt;time.h&gt;</p>
<p>#include &lt;ibase.h&gt;</p>
<p>. . .</p>
<p>struct tm entry_time;</p>
<p>. . .</p>
<p>2. Создайте переменную типа ISC_TIMESTAMP.</p>
<p>ISC_TIMESTAMP entry_date;</p>
<p>ISC_TIMESTAMP это структура объявленная в ibase.h.</p>
<p>3. Получите данные из таблицы в переменную типа ISC_TIMESTAMP</p>
<p>4. Преобразуйте эту переменную в числовой формат C с помощью InterBase функции isc_sql_decode_timestamp(). Она также обьялена в ibase.h, и она требует двух параметров, адреса переменной типа ISC_TIMESTAMP, и адреса struct tm переменной. Например, следующий фрагмент кода преобразует entry_date к entry_time:</p>
<p>isc_decode_timestamp(&amp;entry_date, &amp;entry_time);</p>
<p>Преобразование даты из формата С в формат InterBase</p>
<p>1. Создайте переменную для С time структуры .</p>
<p>#include &lt;time.h&gt;;</p>
<p>. . .</p>
<p>struct tm entry_time;</p>
<p>. . .</p>
<p>2. Создайте переменную типа ISC_TIMESTAMP для использования InterBase.</p>
<p>ISC_TIMESTAMP mytime;</p>
<p>3. Запишите дату в entry_time.</p>
<p>4. Используйте функцию isc_encode_sql_date() для преобразования entry_time в&nbsp; mytime.</p>
<p>isc_encode_timestamp(&amp;entry_time, &amp;entry_date);</p>
<p>5. И выполните вставку даты в таблицу</p>

<p>Обработка ошибок</p>
<p>Эта глава описывает, как устанавливать вектор состояния ошибки, где InterBase может сохранять информацию об ошибке во время выполнения, и как использовать функции API, чтобы обрабатывать ошибки и сообщать о них. Следующая таблица содержит функции API для обработки ошибок:</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Функция</p>
</td>
<td><p>Что делает</p>
</td>
</tr>
<tr>
<td><p>isc_interprete()</p>
</td>
<td><p>Передает данные об ошибках IB в буфер</p>
</td>
</tr>
<tr>
<td><p>isc_print_sqlerror()</p>
</td>
<td><p>Выводит сообщение об SQL ошибке</p>
</td>
</tr>
<tr>
<td><p>isc_print_status()</p>
</td>
<td><p>Выводит сообщение об ошибке IB</p>
</td>
</tr>
<tr>
<td><p>isc_sqlcode()</p>
</td>
<td><p>Устанавливает значение SQLCODE</p>
</td>
</tr>
<tr>
<td><p>isc_sql_interprete()</p>
</td>
<td><p>Передает данные об ошибках SQL в буфер
</td>
</tr>
</table>

<p>Установка вектора состояния ошибки</p>
<p>Большинство функций API возвращает информацию о состоянии, которое показывает успех или неудачу. Возвращенная информация берется из второго элемента массива вектора состояния ошибки, где InterBase сообщает о состояниях ошибки. Вектор состояния ошибки объявлен в приложениях как массив 20 длинных целых чисел, используя следующий синтаксис:</p>
<p>#include &lt;Ibase.h&gt;</p>
<p>...</p>
<p>ISC_STATUS status_vector [20];</p>
<p>ISC_STATUS определен директивой #define в ibase.h, и предоставляет удобство программирования и независимость от платформы</p>
<p>Использование информации в векторе состояния</p>
<p>Происходит или нет ошибка в течение выполнения вызова API, InterBase загружает вектор состояния ошибки информацией о состоянии вызова. Информация состоит из одного или нескольких&nbsp; кодов ошибки InterBase, и информации об ошибке&nbsp; может использоваться, чтобы сформировать сообщение об ошибках.</p>
<p>Приложение может проверять вектор состояния после выполнения большинства вызовов API, чтобы определить их успех или неудачу. Если состояние ошибки возвращено, приложения могут:</p>
<p>- Отобразить сообщения об ошибках InterBase, используюя isc_print_status ().</p>
<p>- Установить значение SQLCODE, соответствующее ошибке InterBase, используя isc_sqlcode (), и отобразить SQLCODE и сообщение об ошибках SQL, используя isc_print_sqlerror ().</p>
<p>- Формировать индивидуальные сообщения об ошибках InterBase в буфере используя isc_interprete (). Буфер должно предварительно создать приложение. Использование буфера позволяет приложению исполнить дополнительную обработку сообщения (например, сохранение сообщений в файле регистрации ошибок). Эта способность особенно полезна на системах управления окнами, которые не разрешают прямые экранные записи.</p>
<p>- Фиксировать сообщение об ошибках SQL в буфере с isc_sql_interprete (). Буфер должно предварительно создать приложение.</p>
<p>- Производить синтаксический анализ и реагировать на определенные ошибки&nbsp; InterBase в векторе состояния.</p>
<p>Проверка вектора состояния на ошибки</p>
<p>Функции API, которые возвращают информацию в векторе состояния,&nbsp; объявлены в ibase.h как возвращающие указатели на ISC_STATUS. Например,&nbsp; прототип функции для isc_prepare_transaction () объявлен как:</p>
<p>ISC_STATUS ISC_EXPORT isc_prepare_transaction(ISC_STATUS ISC_FAR *, isc_tr_handle ISC_FAR *);</p>
<p>Чтобы проверить вектор состояния на состояние ошибки после выполнения функции, исследуйте первый элемент вектора состояния, чтобы узнать, установлен он в 1, и если так, исследуйте второй элемент, чтобы узнать, что он не 0. Значение отличное от нуля во втором элементе указывает на состояние ошибки. Следующий фрагмент кода на C иллюстрирует, как проверить вектор состояния на состояния ошибки:</p>
<pre>#include &lt;ibase.h&gt;
. . .
ISC_STATUS status_vector[20];
. . .
/* Здесь предполагаемый вызов API возвращающий  состояние ошибки. */
if (status_vector[0] == 1 &amp;&amp; status_vector[1] &gt; 0)
{
/* Здесь описание состояния ошибки */
;
}
</pre>
<p>Если ошибка обнаружена, Вы можете использовать функции API в подпрограмме обработки ошибок, чтобы отобразить сообщения об ошибках, фиксировать сообщения об ошибках в буфере, или анализировать вектор состояния для специфических кодов ошибки.</p>
<p>Вывод или сбор данных сообщений об ошибках - только одна часть подпрограммы обработки ошибок.</p>
<p>Обычно, эти подпрограммы делают откат транзакции, и иногда они могут повторять операцию.</p>
<p>Отображение сообщений об ошибках InterBase</p>
<p>Используйте isc_print_status () чтобы отобразить сообщения об ошибках InterBase на экране. Эта функция анализирует вектор состояния, чтобы формировать все доступные сообщения об ошибках, затем использует C printf () функцию, чтобы вывести сообщения на дисплей. Isc_print_status () требует одного параметра, указателя на вектор состояния содержащий информацию об ошибке. Например, следующий фрагмент кода вызывает isc_print_status () и делает откат транзакции при ошибке</p>
<pre>#include &lt;ibase.h&gt;.
. . .
ISC_STATUS status_vector[20];
isc_tr_handle trans;
. . .
trans = 0L;
. . .
/* Предпорлагаемая транзакция стартует здесь. */
/* Здесь предполагаемый вызов API возвращающий  состояние ошибки. */
if (status_vector[0] == 1 &amp;&amp; status_vector[1] &gt; 0)
{
isc_print_status(status_vector);
isc_rollback_transaction(status_vector, &amp;trans);
}
</pre>
<p>На системах управления окнами, которые не разрешают, прямые экранные записи с printf (), используют isc_interprete () чтобы фиксировать сообщения об ошибках в буфере.</p>
<p>Для приложений, которые используют,&nbsp; динамические функции SQL (DSQL) API, ошибки должны быть отображены, используя соглашения SQL. Используйте isc_sqlcode () и isc_print_sqlerror () вместо isc_print_status ().</p>
<p>Фиксация сообщений об ошибках InterBase</p>
<p>Используйте isc_interprete () чтобы формировать сообщение об ошибках из информации в векторе состояния, и сохраните это в определенном приложением буфере, где&nbsp; может далее использоваться. Фиксация сообщений в буфере полезна когда приложения:</p>
<p>- Работают под системами управления окнами, которые не разрешают прямые экранные записи.</p>
<p>- Требуют, чтобы большего контроля над выводом сообщения об ошибке чем это было возможно с isc_print_status ().</p>
<p>- Сохраняют отчет о всех об ошибках в журнале.</p>
<p>- Управляют сообщениями или форматируют сообщения об ошибках для вывода, или передают их&nbsp; подпрограммам отображения системам работы с окнами.</p>
<p>Isc_interprete () возвращает и форматирует отдельное сообщение об ошибках, каждый раз когда она вызывается. Когда ошибка происходит, вектор состояния обычно содержит больше чем одно сообщение об ошибках. Чтобы отыскивать все уместные сообщения об ошибках, Вы должны выполнять повторные вызовы&nbsp; isc_interprete ().</p>
<p>Передайте адрес буфера и адрес вектора состояния в isc_interprete(), и&nbsp; isc_interprete () сформирует сообщение об ошибках из информации в векторе состояния, поместит отформатированную строку в буфер, и приложение может управлять им, и переместит указатель вектора состояния на начало следующего кластера информации об ошибки. Isc_interprete () требует двух параметров, адрес буфера приложения, чтобы содержать отформатированный вывод сообщения, и указатель на массив векторов состояний.</p>
<p>Никогда не передавайте массив векторов состояний непосредственно&nbsp; isc_interprete (). Каждый раз при вызове, isc_interprete () продвигает указатель на вектор состояния к следующему элементу, содержащему новую информацию сообщения. Перед запросом isc_interprete (), убедитесь, что установили указатель на начальный адрес вектора состояния.</p>
<p>Следующий код демонстрирует подпрограмму обработки ошибок, которая делает повторные вызовы isc_interprete () чтобы получить сообщения об ошибках из вектора состояния по одной, так что они могут быть записаны в файл регистрации.</p>
<pre>#include &lt;ibase.h&gt;
. . .
ISC_STATUS status_vector[20];
isc_tr_handle trans;
long *pvector;
char msg[512];
FILE *efile; /* Фрагмент кода предполагаемого открытия файла */
trans = 0L;
. . .
/*Здесь начинается подпрограмма обработки ошибок. */
/* Всегда настраивайте pvector на указатель на status_vector. */
pvector = status_vector;
/* Получаем первое сообщение */
isc_interprete(msg, &amp;pvector);
/* Пишем первое сообщение из буфера в log файл. */
fprintf(efile, "%s\n", msg);
msg[0] = ’-’; /* Добавляем в конец дефис для второго сообщения */
/* Ищем другие сообщения в цикле */
while(isc_interprete(msg + 1, &amp;pvector)) /* Дальше? */
fprintf(efile, "%s\n", msg); /* Если так то пишем в log файл. */
fclose(efile); /* Все закончили закрываем Log файл */
isc_rollback(status_vector, &amp;trans);
return(1);
. . .
</pre>

<p>Заполнение SQLCODE значением ошибки</p>
<p>стр 176-178, (Не переведены так как SQLCODE не нужны и устарели)</p>
<p>Анализ вектора состояния ( статус-вектор )</p>
<p>InterBase сохраняет информацию об ошибке в векторе состояния во втором или третьем кластерах (каждый кластер это длинное целое, а фактически элемент массива статус-вектора). Первый кластер в векторе состояния всегда указывает первичную причину ошибки. Последующие кластеры могут содержать служебную информацию относительно ошибки, например, строки или числа для вывода в сообщении об ошибках. Такое число кластеров используется для отчета, так как служебная информация&nbsp; изменяется от ошибки к ошибке.</p>
<p>Во многих случаях, дополнительные ошибки могут быть переданы в векторе состояния. Дополнительные ошибки выводятся немедленно после первой же ошибки . Первый кластер для каждого дополнительного сообщения об ошибках идентифицирует ошибку. Последующие кластеры могут содержать служебную информацию об ошибке.</p>
<p>Как анализируется статус вектор</p>
<p>Подпрограммы обработки ошибок InterBase, isc_print_status () и isc_interprete (), используют подпрограммы, которые автоматически анализируют информацию сообщений об ошибках в векторе состояния без требования знаний о структуре статус-вектора. Если Вы планируете писать ваши собственные подпрограммы, чтобы читать статус-вектор и реагировать на его содержание, то Вы должны знать, как интерпретировать это содержание.</p>
<p>The key to parsing the status vector is to decipher the meaning of the first long in each cluster, beginning with the first cluster in the vector.</p>
<p>Значение первого длинного целого в кластере</p>
<p>Первое длинное целое в любом кластере - числовой дескриптор. Проверяя числовой дескриптор для любого кластера Вы можете всегда определять:</p>
<p>- Число длинных целых в кластере.</p>
<p>- Вид информации, содержащейся в оставшейся части кластера.</p>
<p>- Начальное местоположение следующего кластера в векторе состояния.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td colspan="3" ><p>Интерпретация первого длинного целого числа</p>
</td>
</tr>
<tr>
<td colspan="3" ><p>Длинное целое в</p>
</td>
</tr>
<tr>
<td><p>Значение</p>
</td>
<td><p>кластер</p>
</td>
<td><p>Интерпетация</p>
</td>
</tr>
<tr>
<td><p>0</p>
</td>
<td><p>-</p>
</td>
<td><p>Конец информации об ошибке в статус-векторе</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе long в коде ошибки</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>2</p>
</td>
<td><p>Второй long это адрес строки, используемой как переменный параметр в универсальном сообщении об ошибках InterBase</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>3</p>
</td>
<td><p>Второй long это длина, в байтах, строки переменной длины, предоставляемой операционной системой (наиболее часто эта строка - имя файла); третье long - адрес строки</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>2</p>
</td>
<td><p>Второй long это число используемое как переменный параметр в универсальном сообщении об ошибках</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>2</p>
</td>
<td><p>Второй long - адрес строки сообщения об ошибках не требующий никакой дальнейшей обработки перед выводом</p>
</td>
</tr>
<tr>
<td><p>6</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки VAX/VMC</p>
</td>
</tr>
<tr>
<td><p>7</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки UNIX</p>
</td>
</tr>
<tr>
<td><p>8</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки Apollo Domain</p>
</td>
</tr>
<tr>
<td><p>9</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки MS-DOS или OS/2</p>
</td>
</tr>
<tr>
<td><p>10</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки HP MPE/XL</p>
</td>
</tr>
<tr>
<td><p>11</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки HP MPE/XL IPC</p>
</td>
</tr>
<tr>
<td><p>12</p>
</td>
<td><p>2</p>
</td>
<td><p>Второе длинное есть код ошибки NeXT/Mach
</td>
</tr>
</table>
<p class="note">Примечание: По мере адатации InterBase к другим платформам и другому оборудованию в этот список добавяться новые значения</p>
<p>Включив ibase.h в начало вашего исходного текста, Вы можете использовать серии #defines, чтобы заменить на жестко закодированные числовые дескрипторы в векторе состояния для подпрограмм синтаксического анализа которые Вы напишите. Преимущества использования этих #defines следующие:</p>
<p>- Ваш код будет более легким для чтения.</p>
<p>- Сопровождение кода будет проще, схема нумерации числовых дескрипторов изменится в будущем выпуске InterBase.</p>
<p>- Следующая таблица перечисляет #define эквиваленты каждого числового дескриптора:</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Значение</p>
</td>
<td><p>#define</p>
</td>
<td><p>Значение</p>
</td>
<td><p>#define</p>
</td>
</tr>
<tr>
<td><p>0</p>
</td>
<td><p>isc_arg_end</p>
</td>
<td><p>8</p>
</td>
<td><p>isc_arg_domain</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_arg_gds</p>
</td>
<td><p>9</p>
</td>
<td><p>isc_arg_dos</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>isc_arg_string</p>
</td>
<td><p>10</p>
</td>
<td><p>isc_arg_mpexl</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_arg_cstring</p>
</td>
<td><p>11</p>
</td>
<td><p>isc_arg_mpexl_ipc</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_arg_number</p>
</td>
<td><p>12</p>
</td>
<td><p>isc_arg_next_mach</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>isc_arg_interpreted</p>
</td>
<td><p>13</p>
</td>
<td><p>isc_arg_netware</p>
</td>
</tr>
<tr>
<td><p>6</p>
</td>
<td><p>isc_arg_vms</p>
</td>
<td><p>14</p>
</td>
<td><p>isc_arg_win32</p>
</td>
</tr>
<tr>
<td><p>7</p>
</td>
<td><p>isc_arg_unix</p>
</td>
<td>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
&nbsp;</p>
<p>Значение второго long в кластере</p>
<p>В&nbsp; второй long в кластере - всегда один из пяти элементов:</p>
<p>- Код ошибки InterBase (1-ый long = 1).</p>
<p>- Адрес строки(1-ый long = 2 или 5).</p>
<p>- Длина строки(1-ый long = 3).</p>
<p>- Числовое значение (1-ый long = 4).</p>
<p>- Код ошибки операционной системы (1-ый long &gt; 5).</p>
<p>Ошибочные коды Interbase</p>
<p>Коды ошибки InterBase имеют два применения. Сначала, они используются внутренними функциями InterBase, чтобы формировать и отображать&nbsp; строки сообщения об ошибках. Например, isc_interprete () вызывает другую функцию, которая использует код ошибки InterBase, чтобы получить основное сообщение об ошибках из которого она уже формирует строку сообщения об ошибках, которую Вы можете отображать или сохранять в журнале.</p>
<p>Во-вторых, когда Вы пишете вашу собственную подпрограмму обработки ошибок, Вы можете проверять вектор состояния, напрямую, обрабатывая и реагируя на определенные коды ошибок InterBase.</p>
<p>Когда во втором элементе кластера - код ошибки InterBase, тогда последующие кластеры могут содержать дополнительные параметры для строки сообщения об ошибках, связанной с кодом ошибки. Например, универсальное сообщение об ошибках InterBase может содержать переменный строковый параметр для имени таблицы, где ошибка произошла, или она может содержать переменный числовой параметр для кода триггера, который получил условие ошибки.</p>
<p>Если Вы пишите ваши собственные подпрограммы синтаксического анализа, Вы могут были должны исследовать и использовать эти дополнительные кластеры информации ошибки.</p>
<p>СТРОКОВЫЕ АДРЕСА</p>
<p>Строка адресуется указателем текста сообщения об ошибках. Когда первый элемент в кластере равен 2 (isc_arg_string), адрес указывает часто на имя базы данных, таблицы, или столбца, на который воздействует ошибка. В этих случаях, функции InterBase, которые формируют строку сообщения об ошибках заменяют параметр в универсальном сообщении об ошибках InterBase  строкой, указанной этим адресом. В другихслучаях адрес указывают на сообщение об ошибках, жестко закодированное в триггеах базы данных.</p>
<p>Когда первый элемент в кластере равен 5 (isc_arg_interpreted), то адрес указывает на текстовое сообщение, которое не требует никакой дальнейшей обработки перед выодом. Иногда это сообщение может быть жестко закодировано в InterBase непосредственно, и может быть сообщение об ошибках&nbsp; системы.</p>
<p>В любом из этих случаев, функции InterBase типа isc_print_status () и isc_interprete () могут форматировать и отображать заканчивающееся сообщение об ошибках для Вас.</p>
<p>181-182 не переведена</p>
<p>Пример анализа статус-вектора</p>
<p>Следующий пример C иллюстрирует простой пример, анализ&nbsp; "в лоб" вектора состояния. При возникновении ошибки блок обработки ошибок анализирует кластер массива вектора состояния, печатая содержание каждого кластера и интерпретируя его для Вас.</p>
<pre>#include &lt;ibase.h&gt;
. . .
ISC_STATUS status_vector[20];
main()
{
 int done, v; /* если аргументов нет то 1, есть 0?, индекс статус-вектора */
 int c, extra; /* счетчик кластеров, 3 long cluster flag */
 static char *meaning[] = {"End of error information",
                           "n InterBase error code",
                           " string address",
                           " string length",
                           " numeric value",
                           " system code"};
/* здесь устанавливается соединение с БД и начинается транзакция */
 if (status_vector[0] == 1 &amp;&amp; status_vector[1] &gt; 0) error_exit();
  . . .
}
 
void error_exit(void)
{
 done = v = 0;
 c = 1;//анализ начинаем с первого кластера
 while (!done)
 {
  extra = 0;
  printf("Cluster %d:\n", c);//выводит номер кластера
    //выводит индекс и содержимое кластера по индексу
  printf("Status vector %d: %ld: ", v, status_vector[v]);
  if (status_vector[v] != gds_arg_end)//если не достигнут конец  аргументов, выводим сообщение
        printf("Next long is a");
  switch (status_vector[v++])
  {
   case gds_arg_end:
    printf("%s\n", meaning[0]);//если встретили конец аргументов, то покидаем цикл
    done = 1;
    break;
   case gds_arg_gds:
    printf("%s\n", meaning[1]);
    break;
   case gds_arg_string:
   case gds_arg_interpreted:
    break;
   case gds_arg_number:
    printf("%s\n", meaning[4]);
    break;
   case gds_arg_cstring:
    printf("%s\n", meaning[3]);
    extra = 1;
    break;
   default:
    printf("%s\n", meaning[5]);
    break;
  }
 
 if (!done)
 {
  printf("Status vector %d: %ld", v, status_vector[v]);
  v++;/* передвинуть указатель вектора */
  c++;/* увеличить счетчик кластера */
  if (extra)
  {
   printf(": Next long is a %s\n", meaning[2]);
   printf("Status vector: %d: %ld\n\n", v,
   status_vector[v]);
   v++;
  }
  else
   printf("\n\n");
 }
}
 
 isc_rollback_transaction(status_vector, &amp;trans);
 isc_detach_database(&amp;db1);
 return(1);
}
</pre>

<p>Здесь пример вывода результатов этой программы</p>
<p>Cluster 1:</p>
<p>Status vector 0: 1: Next long is an InterBase error code</p>
<p>Status vector 1: 335544342</p>
<p>Cluster 2:</p>
<p>Status vector 2: 4: Next long is a numeric value</p>
<p>Status vector 3: 1</p>
<p>Cluster 3:</p>
<p>Status vector 4: 1: Next long is an InterBase error code</p>
<p>Status vector 5: 335544382</p>
<p>Cluster 4:</p>
<p>Status vector 6: 2: Next long is a string address</p>
<p>Status vector 7: 156740</p>
<p>Cluster 5:</p>
<p>Status vector 8: 0: End of error informationРабота с BLOB данными</p>
&nbsp;</p>
<p>Эта глава описывает тип данных переменной длины, называемый BLOB (Binary Large Object, большой двоичный обьект) . Обычно этот тип данных применяется для хранения изображений, аудио- , видео- информации и вообще может применяться для любых типов данных. Если хочется как то преобразовывать BLOB, то для этого существуют специальные функции называемые BLOB фильтры, их можно даже писать самому.</p>
<p>Следующая таблица представляет в алфавитном порядке функции используемые для работы с BLOB.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Функция</p>
</td>
<td><p>Описание</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_blob_default_desc()</p>
</td>
<td><p>Загружает BLOB дескриптор с информацией по умолчанию о BLOB, включающую инфо подтипах, кодовой табл, и размере сегмента BLOB.</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>isc_blob_gen_bpb()</p>
</td>
<td><p>Создает буфер параметров (BPB) для исходного и целевого BLOB дескрипторов и разрешает динамический доступ к BLOB подтипу и кодовой таблице символов.</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_blob_info()</p>
</td>
<td><p>Возвращает информацию о открытом BLOBE.</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_blob_lookup_desc()</p>
</td>
<td><p>Определяет подтип, набор символов, и размер сегмента BLOB, учитывая название таблицы и название столбца BLOB.</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>isc_blob_set_desc()</p>
</td>
<td><p>Инициализирует дескриптор BLOB из переданных ей параметров</p>
</td>
</tr>
<tr>
<td><p>6</p>
</td>
<td><p>isc_cancel_blob()</p>
</td>
<td><p>Отмена&nbsp; BLOB</p>
</td>
</tr>
<tr>
<td><p>7</p>
</td>
<td><p>isc_close_blob()</p>
</td>
<td><p>Закрытие открытого BLOB</p>
</td>
</tr>
<tr>
<td><p>8</p>
</td>
<td><p>isc_create_blob2()</p>
</td>
<td><p>Создает и открывает BLOB для&nbsp; записи, и при желании пользователя определяет фильтр, который нужно использовать, чтобы конвертировать BLOB из одного подтипа в другой</p>
</td>
</tr>
<tr>
<td><p>9</p>
</td>
<td><p>isc_get_segment()</p>
</td>
<td><p>Возвращает данные из BLOB столбца в строке, возвращенной выполнением инструкции SELECT</p>
</td>
</tr>
<tr>
<td><p>10</p>
</td>
<td><p>isc_open_blob2()</p>
</td>
<td><p>Открывает существующий&nbsp; BLOB для&nbsp; поиска, и при желании пользователя определяет фильтр, который нужно использовать, чтобы конвертировать BLOB из одного подтипа в другой</p>
</td>
</tr>
<tr>
<td><p>11</p>
</td>
<td><p>isc_put_segment()</p>
</td>
<td><p>Пишет данные в BLOB
</td>
</tr>
</table>
&nbsp;</p>
<p>Кроме управления BLOB данными обычными способами, подобными управлению другими типами данных, Interbase предоставляет&nbsp; более гибкие правила&nbsp; типов данных для данных BLOB. Поскольку существует много собственных типов данных разработчика, то вы можете определять их как данные BLOB, Interbase работает с ними как со своими и позволяет Вам определять ваш собственный тип данных, называемый подтип BLOB. Interbase также предоставляет два своих предопределенных подтипа: 0, неструктурированный подтип, вообще применимый к любым двоичным данным или данным неопределенного типа, и 1, применимый&nbsp; к простому тексту.</p>
&nbsp;</p>
<p>Пользовательские данные должны быть всегда представлены как отрицательные числа от &#8211;1 до &#8211;32678. Подтип BLOB определяет как определен BLOB столбец.</p>
<p>Приложение ответственно за то, чтобы данные, хранимые в столбце BLOB согласовывались с его подтипом; Interbase не проверяет тип или формат данных BLOB.</p>
<p>Конечно чем&nbsp; хранить данные Blob непосредственно в поле Blob записи таблицы, InterBase хранит там Blob ID. Blob ID является уникальным числовым значением которое ссылается на данные Blob. Данные Blob хранятся в другом месте в базы данных, в ряде сегментов Blob, по сегментам и осуществляется чтение и запись BLOB. Сегменты Blob могут иметь изменяющуюся длину. Длина индивидуального сегмента определяется при записи. Сегменты удобны при работе с данными, который является слишком большим для одного&nbsp; буфера памяти приложения. Но не необходимо использовать множественные сегменты; Вы можете помещать все ваши данные Blob на единственном сегменте.</p>
<p>Операции над BLOB данными</p>
<p>Interbase поддерживает следующие операции над BLOB данными:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Чтение из BLOB.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td> Вставка новой строки включающей BLOB данные</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Замена данных ссылающихся на&nbsp; BLOB столбец.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Обновление данных ссылающихся на&nbsp; BLOB столбец.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Удаление BLOB.</td></tr></table></div>
<p>API Функции динамического SQL (DSQL) и&nbsp; структура данных XSQLDA необходимы, чтобы выполнить SELECT, INSERT, и инструкции UPDATE, требующиеся, чтобы выбирать, вставлять, или модифицировать уместные данные Blob.</p>
<p>Чтение данных из BLOB.</p>
<p>Эти шесть шагов требуются для чтения данных из существующего BLOB:</p>
<p>1.&nbsp; Создается обычная инструкция SELECT для выбора строки содержащей BLOB столбец.</p>
<p>2. Подготавливается структура для вывода данных XSQLDA.</p>
<p>3. Подготавливается SELECT инструкция.</p>
<p>4. Выполняется инструкция.</p>
<p>5. Выбираем строки одну за другой</p>
<p>6. Читаем и обрабатываем BLOB данные для каждой строки.</p>
<p>Опишем все это подробнее, для непонимающих.</p>
<p> Создание SELECT инструкции</p>
<pre>char *str =
"SELECT PROJ_NAME, PROJ_DESC, PRODUCT FROM PROJECT WHERE \
PRODUCT IN ("software", "hardware", "other") ORDER BY PROJ_NAME";
</pre>

<p>Подготовка структуры вывода XSQLDA</p>
<p>1. Объявляем переменную содержащую XSQLDA</p>
<p>XSQLDA *out_sqlda;</p>
<p>2. Выделяем память</p>
<p>out_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(3));</p>
<p>3.Ставим версию и число выходных параметров</p>
<p>out_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p>out_sqlda-&gt;sqln = 3;</p>
<p>Подготовка SELECT инструкции для выполнения</p>
<p>После создания XSQLDA для содержания данных столбцов каждой выбранной строки,</p>
<p>Строку инструкции нужно подготовить к выполнению.</p>
<p>1. Обьявляеи и инициализируем дескриптор SQL инструкции,</p>
<p>с помощью известной нам функции isc_dsql_allocate_statement():</p>
<p>isc_stmt_handle stmt; /* Обьявление дескриптора инструкции */</p>
<p>stmt = NULL; /* Установка дескриптора в NULL перед выполнением */</p>
<p>isc_dsql_allocate_statement(status_vector, &amp;db_handle, &amp;stmt);</p>
<p>3.&nbsp; Подготавливаем строку для выполнения с помощью isc_dsql_prepare(), которая проверяет строку(str) на синтаксические ошибки, переводит строку в формат для эффективного выполнения, и устанавливает в дескриптор инструкции (stmt) ссылку на этот созданный формат (blr что ли). Дескриптор инструкции используется позднее в функции isc_dsql_execute().</p>
<p>Если isc_dsql_prepare() передан указатель на XSQLDA вывода, как в следующем примере, она будет заполнять большинство полей в XSQLDA и всех подструктур XSQLVAR информацией о типа данных, длине, и имени столбца&nbsp; в инструкции.</p>
<p>Пример вызова isc_dsql_prepare():</p>
<pre>isc_dsql_prepare(
status_vector,
&amp;trans, /* Устанавливается предварительным вызовом isc_start_transaction()*/
&amp;stmt, /*Дескриптор инструкции устанавливается в вызове этой функции. */
0, /* Определяет что инструкция - строка заканчиается 0*/
str, /* Инструкция - строкаа */
SQLDA_VERSION1,/* Номер версии XSQLDA */
out_sqlda /* XSQLDA для хранения данных столбцов после выполнения инструкции */
)
</pre>
<p>3. Устанавливаем XSQLVAR структуру для каждого столбца:</p>
<p>- Определяем тип столбца ( если он не был установлен isc_dsql_prepare())</p>
<p>- Связываем указатель структуры XSQLVAR&nbsp; sqldata с соответствующей локальной переменной.</p>
<p>Для столбцов чьи типы неизветсны к этому моменту:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Приводим элементы типо данных (необязательно), к примеру, из SQL_VARYING к SQL_TEXT.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Динамически выделяем место для хранения данных на которые указывает sqldata</td></tr></table></div><p>Для обоих:</p>
<p>- Определяем число байт данных передаваемых в sqldata</p>
<p>- Предоставляем значение NULL индикатора для параметров</p>
<p>Выбранные данные для Blob (и массивов) столбцов отличаются от других типов столбцов, так что поля XSQLVAR должны быть установлены по-другому. Для не -BLOB (и не-массивов) столбцов, isc_dsql_prepare () устанавливают для каждый sqltype  к соответствующему&nbsp; типу поля, и выбранные данные помещаются в область памяти на которую указывают соответствующие sqldata, при каждой операции fetch. Для столбцов Blob, тип должен быть установлен в SQL _Blob (или SQL _Blob + 1, если нужен индикатор NULL). InterBase сохраняет внутренний идентификатор Blob (Blob ID),&nbsp; а не данные Blob, в памяти на которую кажет sqldata, когда&nbsp; строки данных выбраны, так что&nbsp; sqldata  должна указывать на память с размером нужным для хранения Blob ID.</p>
<p>Следующий пример кода иллюстрирует назначения для Blob и столбцов не-Blob, чей тип известен ко времени компиляции.</p>
<pre>#define PROJLEN 20
#define TYPELEN 12
ISC_QUAD blob_id;
char proj_name[PROJLEN + 1];
char prod_type[TYPELEN + 1];
short flag0, flag1, flag2;
out_sqlda-&gt;sqlvar[0].sqldata = proj_name;
out_sqlda-&gt;sqlvar[0].sqltype = SQL_TEXT + 1;
out_sqlda-&gt;sqlvar[0].sqllen = PROJLEN;
out_sqlda-&gt;sqlvar[0].sqlind = &amp;flag0;
out_sqlda-&gt;sqlvar[1].sqldata = (char *) &amp;blob_id;
out_sqlda-&gt;sqlvar[1].sqltype = SQL_Blob + 1;
out_sqlda-&gt;sqlvar[1].sqllen = sizeof(ISC_QUAD);
out_sqlda-&gt;sqlvar[1].sqlind = &amp;flag1;
out_sqlda-&gt;sqlvar[2].sqldata = prod_type;
out_sqlda-&gt;sqlvar[2].sqltype = SQL_TEXT + 1;
out_sqlda-&gt;sqlvar[2].sqllen = TYPELEN;
out_sqlda-&gt;sqlvar[2].sqlind = &amp;flag2;
</pre>

<p>Выполнение инструкции</p>
<p>После того как инструкция подготовлена можно ее выполнить.</p>
<pre>isc_dsql_execute(
status_vector,
&amp;trans, /* Устанавливается предвартельным вызовом isc_start_transaction()*/
&amp;stmt, /* выделяется isc_dsql_allocate_statement() */
1, /* XSQLDA version number */
NULL /* NULL так как нет входных параметров */
);
</pre>
<p>Эта инструкция создает список выбора, это строки возвращаемые после выполения инструкции.</p>
<p>Извлечение выбранных строк</p>
<p>Конструкция&nbsp; цикла извлечения используется, чтобы извлечь (в&nbsp; XSQLDA вывода) данные столбцов для отдельной строки из списка выбора и обработать каждую строку прежде, чем следующая строка будет выбрана. Каждое выполнение isc_dsql_fetch () выбирает данные столбцов в соответствующие подструктруы XSQLVAR структуры out_sqlda. Для столбца Blob, выбирается Blob ID неявляющийся фактическими данными, а просто указатель на них.</p>
<pre>ISC_STATUS fetch_stat;
long SQLCODE;
. . .
while ((fetch_stat =
isc_dsql_fetch(status_vector, &amp;stmt, 1, out_sqlda))
== 0)
{
proj_name[PROJLEN] = ’\0’;
prod_type[TYPELEN] = ’\0’;
printf("\nPROJECT: %–20s TYPE: %–15s\n\n",
proj_name, prod_type);
/* Read and process the Blob data (see next section) */
}
if (fetch_stat != 100L)
{
/* isc_dsql_fetch returns 100 if no more rows remain to be
retrieved */
SQLCODE = isc_sqlcode(status_vector);
isc_print_sqlerror(SQLCODE, status_vector);
return(1);
}
</pre>

<p>Чтение и обработка BLOB данных</p>
<p>Для чтения и обработки BLOB данных</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Объявите и инициализируйте BLOB дескриптор</td></tr></table></div><p> &nbsp;&nbsp;&nbsp;&nbsp; isc_blob_handle blob_handle; /* Обьявление BLOB дескритора. */</p>
blob_handle = NULL; /* Устанвите его в NULL перед использованием*/</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Создайте буфер для хранения каждого прочитанного BLOB сегмента. Его размер должен быть максимальным размером сегмента в вашей программе используемой для чтения BLOB.</td></tr></table></div><p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; char blob_segment[80];</p>
<p> &nbsp;&nbsp;&nbsp; 3. Обьявите беззнаковую short переменную в которую IB будет хранить фактическую длину каждого прочитанного сегмента:</p>
<p>unsigned short actual_seg_len;</p>
<p>4. Открываем BLOB c извлеченным ранее blob_id</p>
<pre>isc_open_blob2(
status_vector,
&amp;db_handle,
&amp;trans,
&amp;blob_handle,/* Устанавливается этой функцией для ссылки на BLOB */
&amp;blob_id, /* Blob ID полученный из out_sqlda которую заполнил isc_dsql_fetch() */
0, /* BPB length = 0; фильтр не будем использовать */
NULL /* NULL BPB, фильтр не будем использовать */
);
</pre>
<p>5.Читаем все BLOB данные вызывая повторно isc_get_segment(), берущую каждый Blob сегмент и его длину. Обрабатываем каждый прочитанны сегмент.</p>
<pre>blob_stat = isc_get_segment(
status_vector,
&amp;blob_handle, /* Устанавливается isc_open_blob2()*/
&amp;actual_seg_len, /* Длина прочитанного сегмента */
sizeof(blob_segment), /* Длина буфера сегмента */
blob_segment /* буфер сегмента */
);
while (blob_stat == 0 || status_vector[1] == isc_segment)
{
/* isc_get_segment возвращает 0 если сегмент был полностью прочитан.
*/
/* status_vector[1] утанавливается в  isc_segment только часть */
/* сегмента была прочитана из-за буфера (blob_segment) не являющегося */
/* достаточно большим. В этом случае придется делать дополнительные вызовы */
/* isc_get_segment() для дочитывания. */
printf("%*.*s", actual_seg_len, actual_seg_len, blob_segment);
blob_stat = isc_get_segment(status_vector, &amp;blob_handle,
&amp;actual_seg_len, sizeof(blob_segment), blob_segment);
printf("\n");
};
printf("\n");
</pre>
<p>6. Закрываем BLOB</p>
<p>isc_close_blob(status_vector, &amp;blob_handle);</p>
<p>Запись данных в BLOB</p>
<p>Перед тем как создать новый BLOB&nbsp; и записать туда данные вы должны сделать следующее.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Включить BLOB данные в строку втавляемую в таблицу</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Заменить данные ссылающиеся на BLOB столбец строки</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Обновить данные ссылающиеся на BLOB столбец строки</td></tr></table></div>
<p>Вносимый&nbsp; в столбец Blob фактически не содержит данных Blob. Он содержит Blob ID ссылающийся на данные, которыe сохранены в другом месте. Так, чтобы устанавить или изменить столбец Blob, Вы должны установить (или сбросить) Blob ID, сохраненный в нем. Если столбец Blob содержит Blob ID, и Вы изменяете столбцы относящиеся к различным&nbsp; Blob (или содержащим NULL), Blob на который ссылается предварительно сохраненный Blob ID будет удален в течение следующей сборки "мусора".(????)</p>
<p>Все эти операции требуют следующих шагов:</p>
<p>1. Подготовьте соответствующую инструкцию DSQL. Это будет инструкция INSERT, если Вы вставляете новую строку в таблицу, или инструкция UPDATE для изменения строки. Каждая из этих инструкций будет нуждаться в соответствующей&nbsp; структуре ввода XSQLDA для передачи параметров&nbsp; инструкции во время выполнения. Blob ID нового Blob будет одним переданных значений</p>
<p>2. Создайте новый BLOB, и запишите в него данные.</p>
<p>3. Свяжите BLOB ID нового BLOB со столбцом таблицы строк над которой вы будете выполнять INSERT и UPDATE.</p>
<p class="note">Примечание: вы не можете непосредственно обновлять BLOB данные. Если вы желаете модифицировать BLOB данные, вы должны:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Создать новый BLOB</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Прочитать данные из старого BLOBA в буфер где вы сможете отредактировать и модифицировать их.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Записать измененные данные в новый BLOB.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Подготовить и выполнить инструкцию UPDATE которая модифицирует BLOB столбец содержащий BLOB ID нового BLOB, заменяющий старый BLOB ID.</td></tr></table></div><p>Секция ниже описывает шаги требуемые для вставки, обновления, и замены BLOB данных.</p>
<p>Подготовка UPDATE или INSERT инструкции.</p>
<p>1. Создаем саму строку для обновления</p>
<pre>
 char *upd_str =
  "UPDATE PROJECT SET PROJ_DESC = ? WHERE PROJ_ID = ?";
</pre>
<p> или для вставки</p>
<pre>char *in_str = "INSERT INTO PROJECT (PROJ_NAME, PROJ_DESC, PRODUCT,
         PROJ_ID) VALUES (?, ?, ?, ?)";
</pre>
<p>2. Обьявляем переменную содержащую структуру входных параметров</p>
<p>XSQLDA *in_sqlda;</p>
<p>3. in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(2));</p>
<p>4. in_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p> &nbsp; in_sqlda-&gt;sqln = 2;</p>
<p>5. Установить XSQLVAR структуру в XSQLDA для каждого передаваемого параметра.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Определяем типы данных элементов</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Для параметров типы которых известны во время компиляции: указатель sqldata&nbsp; связываем с локальной перемнной содержаещей передаваемый данные.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Для параметров типы которых неизвестны во время выполнения: выделяем память для хранения данных на которые указывает sqldata</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Определяем число байт данных (размер)</td></tr></table></div>
<p>Следующий код иллюстрирует все это для столбца BLOB и одного столбца тип данных которого известен во время компиляции.</p>
<pre>#define PROJLEN 5
char proj_id[PROJLEN + 1];
ISC_QUAD blob_id;
in_sqlda-&gt;sqlvar[0].sqldata = (char *) &amp;blob_id;
in_sqlda-&gt;sqlvar[0].sqltype = SQL_Blob + 1;
in_sqlda-&gt;sqlvar[0].sqllen = sizeof(ISC_QUAD);
in_sqlda-&gt;sqlvar[1].sqldata = proj_id;
in_sqlda-&gt;sqlvar[1].sqltype = SQL_TEXT;
in_sqlda-&gt;sqlvar[1].sqllen = 5;
</pre>
<p>Proj_id&nbsp; должна быть инициализирована во время выполнения (если значение не известно во времени компиляции). Blob_id должна быть установлена, чтобы обращаться к недавно созданному Blob, как описано в следующих секциях</p>
<p>Создание нового BLOB и хранения данных</p>
<p>1. Объявление и инициализация BLOB дескриптора:</p>
<pre>isc_blob_handle blob_handle; /* Обьявления BLOB дескриптора */
blob_handle = NULL; /* Устанавливаем дескриптор в NULL перед использованием*/
2. Обьявление и инициализация BLOB ID:
ISC_QUAD blob_id; /* Объявление Blob ID. */
blob_id = NULL; /* Установка его в NULL перед использованеим*/
</pre>
<p>3. Создание нового BLOB вызовом isc_create_blob2():</p>
<pre>isc_create_blob2(
status_vector,
&amp;db_handle,
&amp;trans,
&amp;blob_handle, /* устанавливается этой функцией ссылка на новый Blob */
&amp;blob_id, /* Blob ID устанавливается этой функцией*/
0, /* Blob Parameter Buffer length = 0; no filter will be used*/
NULL /* NULL Blob Parameter Buffer, since no filter will be used*/
);
</pre>
<p>Эта функция создает новый BLOB открывает его для записи, и устанавливает blob_handle к указателю на новый BLOB</p>
<p>isc_create_blob2() также связывает BLOB с BLOB ID, и устанавливает blob_id к указателю на BLOB ID.</p>
<p>4. Записываем все данные, которые будут записаны в Blob,&nbsp; делая ряд вызовов isc_put_segment (). Следующий пример читает строки данных, и связывает каждый Blob с упомянутым blob_handle. (Get_line () читает следующую строку данных, которые будут написаны.)</p>
<pre>char *line;
unsigned short len;
. . .
line = get_line();
while (line)
{
len = strlen(line);
isc_put_segment(
status_vector,
&amp;blob_handle,/* set by previous isc_create_blob2() */
len, /* длина буфера содержащего ланные для записи */
line /* буфер содержащий данные для записи в BLOB */
);
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
isc_print_status(status_vector);
return(1);
};
line = get_line();
};
</pre>
<p>5. Закрываем BLOB</p>
<p>isc_close_blob(status_vector, &amp;blob_handle);</p>
<p>Связывание нового BLOB с BLOB столбцом</p>
<p>Выполнение инструкции UPDATE связывает новый BLOB с BLOB столбцом в строке выбранной инструкции.</p>
<p>isc_dsql_execute_immediate(</p>
<p>status_vector,</p>
<p>&amp;db_handle,</p>
<p>&amp;trans,</p>
<p>0,</p>
<p>upd_str,</p>
<p>1,</p>
<p>in_sqlda</p>
<p>);</p>
<p>Удаление BLOB</p>
<p>Cуществуют четыре способа удаления BLOB.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Удаляем строку содержащую BLOB. Вы можете использовать DSQL для выполнения DELETE инструкции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Заменяем различные BLOB. Если Blob столбец содержит Blob ID, и вы модифицируете столбец ссылающийся на разные BLOB, ранее сохраненный BLOB будет удален слудующей сборкой “мусора”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Сбрасываем в NULL столбец ссылающийся на BLOB, к примеру, используя DSQL инструкцию&nbsp; как следующую:</td></tr></table></div>UPDATE PROJECT SET PROJ_DESC = NULL WHERE PROJ_ID = "VBASE"</p>
<p>Blob на который указывал удаленный blob_id будет удален следующей сборкой «мусора»</p>
<p>- Отказываемся от BLOB, после того как он был создан но, не был связан еще с определенным столбцом в таблице, используя isc_cancel_blob() функцию.</p>
<p>isc_cancel_blob(status_vector, &amp;blob_handle);</p>
<p>Запрос информации об открытом BLOB</p>
<p>После того, как приложение открывает Blob, оно может получить информацию о Blob.</p>
<p>Isc_blob_info ()&nbsp; позволяет приложению сделать запрос для информации о Blob типа общего количества</p>
<p>числа сегментов в Blob, или о длине, в байтах, самого длинного сегмента. В дополнение к указателю на вектор состояния ошибки и дескриптор Blob, isc_blob_info () требует двух предоставляемых приложением буферов, буфера списков элементов, где приложение определяет информацию, которая требуется, и буфер результатов, куда InterBase возвращает требуемую информацию. Приложение заполняет буфер списков элементов с информационными запросами для isc_blob_info (), и передает ему&nbsp; указатель на буфер списков элементов, а также размер, в байтах, этого буфера.</p>
<p>Приложение должно также создать буфер результата, достаточно большой, чтобы хранить информацию, возвращенную InterBase. Оно передает указатель на буфер результата, и размер, в байтах, этого буфера в isc_blob_info (). Если InterBase пытается поместить, больше информации чем может вместить буфер результатов, она помещает значение, isc_info_truncated, определенное в ibase.h, в последний байт буфера результатов.&nbsp;</p>
<p>Буфер списка элементов запрашиваемой информации и буфер результатов.</p>
<p>Буфер списка элементов это char массив содержащий запрашиваемые байты значений. Каждый байт есть пункт определяющий тип желаемой информации.</p>
<p>Соответствующие констаннты опеределены в ibase.h</p>
<p>#define isc_info_blob_num_segments 4</p>
<p>#define isc_info_blob_max_segment 5</p>
<p>#define isc_info_blob_total_length 6</p>
<p>#define isc_info_blob_type 7</p>
<p>Буфер результатов содержит серию кластеров информации по каждому запрошенному элементу.&nbsp; Каждый кластер содержит три части.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Первый байт определяет тип возвращенной информации.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Второй байт &#8211; число определяющее число байт до конца кластера (длина инфо)</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Значение хранимое в переменном числе байт, которое интерпретируется в зависимости от типа первого байта кластера</td></tr></table></div>
<p>Следующая таблица показывает элементы информацию о которых можно получить</p>
<p>Элемент &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Возвращаемое занчение</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Запрашиваемый и возвращаемый элемент</p>
</td>
<td><p>Возвращаемое значение</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_info_blob_num_segments</p>
</td>
<td><p>Полное число сегментов</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>isc_info_blob_max_segment</p>
</td>
<td><p>Длина самого длинного сегмента</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_info_blob_total_length</p>
</td>
<td><p>Полный размер в байтах BLOB</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_info_blob_type</p>
</td>
<td><p>Тип BLOB(0:сегментированный, 1:поток)
</td>
</tr>
</table>
<p>В дополнение к этой информации IB возвращенной в ответ на запрос, IB&nbsp; может также возвратить один или несколько сообщений состояния в буфер результата. Каждое сообщение состояния есть беззнаковый байт в длине</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Элемент</p>
</td>
<td><p>Описание</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_info_end</p>
</td>
<td><p>Конец сообщений</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td>isc_info_truncated</p>
</td>
<td><p>Результирующий буфер слишком маленький для хранения запрашиваемой информации</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_info_error</p>
</td>
<td><p>Запрашиваемая информация неопеределена. Проверьте status_vector&nbsp; и сообщения.</p>
</td>
</tr>
<tr>
<td>
</td>
<td>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>Пример вызова isc_blob_info( )</p>
<p>Следующий код запрашивает число сегментов и максимальный размер сегмента для BLOB после открытия, получаемая информация помещается в буфер результатов</p>
<pre>char blob_items[] = {
isc_info_blob_max_segment, isc_info_blob_num_segments};
char res_buffer[20], *p, item;
short length;
SLONG max_size = 0L, num_segments = 0L;
ISC_STATUS status_vector[20];
isc_open_blob2(
status_vector,
&amp;db_handle, /* database handle, set by isc_attach_database() */
&amp;tr_handle, /* transaction handle, set by isc_start_transaction()
*/
&amp;blob_handle, /* set by this function to refer to the Blob */
&amp;blob_id, /* Blob ID of the Blob to open */
0, /* BPB length = 0; no filter will be used */
NULL /* NULL BPB, since no filter will be used */
);
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
isc_print_status(status_vector);
return(1);
}
isc_blob_info(
status_vector,
&amp;blob_handle, /* Set in isc_open_blob2() call above. */
sizeof(blob_items),/* Length of item-list buffer. */
blob_items, /* Item-list buffer. */
sizeof(res_buffer),/* Length of result buffer. */
res_buffer /* Result buffer */
);
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
/* An error occurred. */
isc_print_status(status_vector);
isc_close_blob(status_vector, &amp;blob_handle);
return(1);
};
/* Extract the values returned in the result buffer. */
for (p = res_buffer; *p != isc_info_end ;)
{
item = *p++
length = (short)isc_vax_integer(p, 2);
p += 2;
switch (item)
{
case isc_info_blob_max_segment:
max_size = isc_vax_integer(p, length);
break;
case isc_info_blob_num_segments:
num_segments = isc_vax_integer(p, length);
break;
case isc_info_truncated:
/* handle error */
break;
default:
break;
}
p += length;
};
</pre>
<p>Blob дескрипторы</p>
<p>Blob дескриптор используется для предоставления динамического доступа к BLOB информации. К примеру, он может быть использован для хранения информации о BLOB данных для фильтрации, еще как кодовая страница для текстовых BLOB данных и информации о подтипе текстовых данных и не текстовых данных.</p>
<p>Два дескриптора Blob необходимы всякий раз, когда фильтр используется при записи&nbsp; или чтении&nbsp; Blob: один описывать данные источника фильтра, и другой&nbsp; цель.</p>
<p>BLOB дескриптор это структура определенная в заголовочном файле ibase.h как следующая:</p>
<p>typedef struct {</p>
<p>short blob_desc_subtype; /* type of Blob data */</p>
<p>short blob_desc_charset; /* character set */</p>
<p>short blob_desc_segment_size; /* segment size */</p>
<p>unsigned char blob_desc_field_name [32]; /* Blob column name */</p>
<p>unsigned char blob_desc_relation_name [32]; /* table name */</p>
<p>} ISC_Blob_DESC;</p>
<p>Размер сегмента BLOB есть максимальное число юайт в приложении</p>
<p>Размер сегмента Blob - максимальное число байтов, которые приложение, как ожидается,&nbsp; запишет&nbsp; или будет читать из Blob. Вы можете использовать этот размер, чтобы выделить ваши собственные буфера. Blob_desc_relation_name и blob_desc_field_name поля содержащие строки с нулевым символом в конце.</p>
<p>Заполнение blob дескриптора</p>
<p>Есть четыре варианта для заполнения blob дескриптора</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Вызываем isc_blob_default_desc().&nbsp; И заполняем ей поля дескриптора значениями по умолчанию. Подтип по умолчанию есть 1 (TEXT), сегмент размером 80 байт, кодовая страница по умолчанию есть страница установленная для вашего процесса.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Вызываем isc_blob_lookup_desc(). Она обращается к системным таблицам и берет оттуда информацию о BLOB и заполняет ею поля дескриптора.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Вызываем isc_blob_set_desc(). Она инициализирует дескриптор из парметров вызова, быстрее нежели получать доступ к метаданным.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Устанавливаем поля дескриптора напрямую.</td></tr></table></div>&nbsp;</p>
<p>Следующий пример вызывает isc_blob_lookup_desc () чтобы узнать текущий подтип и информацию о наборе символов для столбца Blob по имени PROJ_DESC в таблице&nbsp; PROJECT. Функция сохраняет информацию в исходном описателе from_desс.</p>
<p>isc_blob_lookup_desc (</p>
<p>status_vector,</p>
<p>&amp;db_handle; /* Set by previous isc_attach_database() call. */</p>
<p>&amp;tr_handle, /* Set by previous isc_start_transaction() call. */</p>
<p>"PROJECT", /* имя таблицы */</p>
<p>"PROJ_DESC", /* название столбца */</p>
<p>&amp;from_desc, /* Blob дескриптор заполняется этой функцией. */</p>
<p>&amp;global /* глобальное название колонки возвращаемое этой функцией */</p>
<p>)</p>
<p>Фильтрация BLOB данных</p>
<p>Фильтр Blob это подпрограмма, которая транслирует данные Blob из одного подтипа в другой.</p>
<p>InterBase включает набор специальных внутренних фильтров Blob, которые преобразовывают подтип 0</p>
<p>( Неструктурные данные) в подтип 1 (ТЕКСТ), и из подтипа 1 к подтипу 0.</p>
<p>В дополнение к использованию этих стандартных фильтров, Вы можете создавать ваши собственные внешние фильтры, чтобы обеспечивать специальное конвертирование данных. Например, Вы могли бы разрабатывать фильтр, чтобы преобразовывать один формат изображения к другому, например отображать то же самое изображение на мониторах с различными разрешающими способностями. Или Вы могли бы конвертировать двоичный Blob к простому тексту , чтобы легко файл переносить от одной системы к другой. Если Вы определяете фильтры, Вы можете назначать их идентификаторы подтипа от -32,768 до -1. Следующие разделы дают краткий обзор того, как писать фильтры Blob, и сопровождаются подробностями , как написать приложение, которое требует фильтрации.</p>
<p>Обратите внимание, что фильтры Blob доступны для баз данных, находящихся на всех платформах сервера InterBase кроме Системы Netware, где фильтры Blob не могут быть созданы.</p>
<p>Использование ваших собственных фильтров</p>
<p>В отличие от стандарта фильтров InterBase, которые конвертируют подтипом 0 в подтип 1 и наоборот, внешний фильтр Blob - вообще часть библиотеки подпрограмм, которые Вы создаете и связываете с приложением. Вы можете писать, Blob на C или Паскаль (или любой язык, который может называться из C). Чтобы использовать ваши собственные фильтры, следуйте по этим шагами:</p>
<p>1. Решите, какой фильтр Вы, должны написать.</p>
<p>2. Напишите фильтры в базовом языке.</p>
<p>3. Сформируйте общедоступную библиотеку фильтров.</p>
<p>4. Сделайте библиотеку фильтров доступной.</p>
<p>5. Определить фильтры для базы данных.</p>
<p>6. Напишите приложение, которое требует фильтрацию.</p>
<p>Шаги 2, 5 и 6 будут лучше описаны в следующих разделах.</p>
<p>Объявление внешнего фильтра BLOB для БД</p>
<p>Для объявления внешнего фильтра для БД, используйте иснтрукции DECLARE FILTER. К примеру, следующая инструкция объявляет фильтр, SAMPLE:</p>
<p>DECLARE FILTER SAMPLE</p>
<p>INPUT TYPE &#8211;1 OUTPUT_TYPE &#8211;2</p>
<p>ENTRY POINT "FilterFunction"</p>
<p>MODULE_NAME "filter.dll";</p>
<p>В примере, входной подтип фильтра определен как -1 и его выходной подтип&nbsp; как -2. Если подтип -1 определяет текст нижнего регистра, а подтип -2 текст верхнего регистра, то цель фильтра SAMPLE&nbsp; состояла бы в том, чтобы перевести данные Blob из текста нижнего регистра в текст верхнего регистра.</p>
<p>Параметры ENTRY_POINT И MODULE_NAME определяют внешнюю подпрограмму, которую InterBase вызывает, когда вызывается фильтр. Параметр MODULE_NAME определяет filter.dll, динамически загружаемую библиотеку, содержащую выполнимый код фильтра. Параметр ENTRY_POINT определяет точку входа в DLL. Хотя пример показывает только простое имя файла, это - хорошая практика для определения полного квалифицированного пути, начиная с пользователей вашего приложения желающих загрузить файл.</p>
<p>Создание внешних Blob фильтров</p>
<p>Если Вы хотите создавать ваши собственные фильтры, Вы должны иметь детальное понимание типов данных , которые Вы планируете конвертировать. InterBase не делает строгой проверки&nbsp; типа данных на данные Blob; это - ваша ответственность.</p>
<p>Определений функций фильтров</p>
<p>При написании фильтра, Вы должны включить точку входа, известной&nbsp; функции фильтра, в секции объявления программы. InterBase вызывает функцию фильтра, когда приложение выполняет операции&nbsp; на Blob, определенные для исполязования фильтра. Вся связь между InterBase и фильтром происходит через функцию фильтра. Функция самого фильтра может вызывать другие функции, которые включает исполняемая программу фильтра.</p>
<p>Вы объявляете имя функции фильтра и имя выполняемой программы - фильтра с параметрами ENTRY_POINT И MODULE_NAME в инструкции DECLARE FILTER.</p>
<p>Функция фильтра должна иметь следующее объявление, вызывающее последовательность:</p>
<p>filter_function_name(short action, isc_blob_ctl control);</p>
<p>Параметр, action, является одним из восьми возможных макроопределений действия, и параметр, control - элемент isc_blob_ctl, управляющей структуры Blob, определенной в файле заголовка InterBase, ibase.h. Эти параметры обсуждаются позже в этой главе.</p>
<p>Следующий листинг скелетного фильтра описывает функцию фильтра, jpeg_filter:</p>
<pre>#include &lt;ibase.h&gt;
#define SUCCESS 0
#define FAILURE 1
ISC_STATUS jpeg_filter(short action, isc_blob_ctl control)
{
ISC_STATUS status = SUCCESS;
switch (action)
{
case isc_blob_filter_open:
. . .
break;
case isc_blob_filter_get_segment:
. . .
break;
case isc_blob_filter_create:
. . .
break;
case isc_blob_filter_put_segment:
. . .
break;
case isc_blob_filter_close:
. . .
break;
case isc_blob_filter_alloc:
. . .
break;
case isc_blob_filter_free:
. . .
break;
case isc_blob_filter_seek:
. . .
break;
default:
. . .
break;
}
return status;
}
</pre>
<p>InterBase передает одно из восьми возможных действий к функции фильтра, jpeg_filter, посредством параметра action, и также передает экземпляр управляющей структуры Blob, isc_blob_ctl, посредством параметра, control. ellipses (…) в предыдущем листинге представляют код, который выполняет некоторые операции, для каждого действии, или случая, который перечислен в инструкции case.</p>
<p>Определение управляющей структруры BLOB</p>
<p>Управляющая структура BLOB предоставляет основные методы обмена данными между фильтром и Interbase.</p>
<p>Управляющая структура BLOB определена при помощи typedef, isc_blob_ctl. в ibase.h вот так:</p>
<pre>typedef struct isc_blob_ctl {
ISC_STATUS (*ctl_source)();
/* Указатель на внутреннюю InterBase Blob подпрограмму доступа.(функтор) */
struct isc_blob_ctl *ctl_source_handle;
/* Экземпляр of isc_blob_ctl передаваемый во внутреннюю подпрограмму доступа IB*/
short ctl_to_sub_type;/* Целевой подтип */
short ctl_from_sub_type;/* Исходный подтип */
unsigned short ctl_buffer_length; /* Длина ctl_buffer. */
unsigned short ctl_segment_length; /* Длина текущего сегмента */
unsigned short ctl_bpb_length; /* Длина буфера параметров BLOB. */
char *ctl_bpb; /* Указатель на буфер параметров BLOB */
unsigned char *ctl_buffer; /* Указатель на сегментный буфер */
ISC_LONG ctl_max_segment; /* Длина самого длинного BLOB сегмента */
ISC_LONG ctl_number_segments; /* Полное число сегментов */
ISC_LONG ctl_total_length; /* Полная длина BLOB */
ISC_STATUS *ctl_status;/* Указатель на статус вектор */
long ctl_data[8];/* Данные определяемые приложением */
} *ISC_Blob_CTL;
</pre>
<p>Семантика некоторых isc_blob_ctl полей зависит от выполняемого действия.</p>
<p>Например, когда приложение вызывает isc_put_segment () функцию API, InterBase передает isc_blob_filter_put_segment - действие функции фильтра. Буфер, указатель на буфер, ctl_buffer - поле управляющей структуры, передаваемый функции фильтра, содержит сегмент данных, которые будут записано, как определено приложением в его запросе к isc_put_segment (). Поскольку буфер содержит информацию, передаваемую в функцию фильтра, это называется полем IN. Функция фильтра должна включить инструкции в инструкцию case под isc_blob_filter_put_segment для выполнения фильтрации и затем передачи данных для записи в базу данных. Это может быть сделано,&nbsp; вызывом *ctl_source подпрограммы доступной внутри Interbase подпрограммы. Для подробной информации относительно ctl_source, см. Руководство Программиста.</p>
<p>С другой стороны, когда приложение вызывает isc_get_segment () функцию API,и буфер, на него указывает ctl_buffer в управляющей структуре переденной функции фильтра,&nbsp; пуст. В этом случае, InterBase передает isc_blob_filter_get_segment&nbsp; действие- функции фильтра. Обработка действия- функции isc_blob_filter_get_segment фильтра должна включить команды для заполнения ctl_buffer сегментом данных из базы данных, чтобы возвратить его приложению. Это может быть сделано,&nbsp; вызывом *ctl_source подпрограммы доступной внутри IB. В этом случае, буфер используется для вывода информации функцией фильтра, и называется полем OUT.</p>
<p>Следующая таблица описывает каждое из полей в isc_blob_ctl управляющей структуре Blob,&nbsp; используются ли они для ввода функции фильтра (IN), или вывода (OUT).</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Название поля</p>
</td>
<td><p>Описание</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>(*ctl_source)()</p>
</td>
<td><p>Указатель на функцию к которой происходит обращение из IB BLOB</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>*ctl_source_handle</p>
</td>
<td><p>Указатель на экземпляр isc_blob_ctl передаваемый внутренней IB BLOB подпрограмме(IN)</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>ctl_to_sub_type</p>
</td>
<td><p>Целевой подтип: информационное поле, предоставляет поддержку многоцелевых фильтров, которые могут исполнять больше одного типа трансляции; это поле и следующее позволяют такому фильтру решить какую трансляцию выолнить (IN)</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>ctl_from_sub_type</p>
</td>
<td><p>Исходный подтип: информационное поле, обеспечивающее поддержку многоцелевых фильтров, которые могут выполнять больше чем один вид трансляции; это поле и предыдущее позволяют такому фильтру решить которую трансляцию выполнить (IN)</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>ctl_buffer_length</p>
</td>
<td><p>Для isc_blob_filter_put_segment, поле - поле IN, которое содержит длину сегмента данных , содержащихся в ctl_buffer.</p>
<p>Для isc_blob_filter_get_segment, поле -&nbsp; поле IN, устанавливающее размер буфера на который указывает ctl_buffer, который используется, чтобы сохранить полученные данные Blob</p>
</td>
</tr>
<tr>
<td><p>6</p>
</td>
<td><p>ctl_segment_length</p>
</td>
<td><p>Длина текущего сегмента. Для isc_blob_filter_put_segment, поле не используется</p>
<p>Для isc_blob_filter_get_segment, поле - поле OUT устанавливающее размер полученного сегмента (или части сегмент, в случае, когда буферная длина ctl_buffer_length - меньше чем фактическая длина сегмента)</p>
</td>
</tr>
<tr>
<td><p>7</p>
</td>
<td>ctl_bpb_length</p>
</td>
<td><p>Длина буфера параметров BLOB</p>
</td>
</tr>
<tr>
<td><p>8</p>
</td>
<td><p>*ctl_bpb</p>
</td>
<td><p>Указатель на буфер параметров BLOB</p>
</td>
</tr>
<tr>
<td><p>9</p>
</td>
<td><p>*ctl_buffer</p>
</td>
<td><p>Указатель на буфер сегмента. Для isc_blob_filter_put_segment, поле есть поле IN которое содержит сегмент данных.</p>
<p>Для isc_blob_filter_get_segment, поле есть поле OUT заполняемое функцией фильтра сегментом данных возвращаемым приложению</p>
</td>
</tr>
<tr>
<td><p>10</p>
</td>
<td><p>ctl_max_segment</p>
</td>
<td><p>Длина в байтах, самого длинного сегмента BLOB. Инициализируется в 0. Функция фильтра устанавливает это поле. Это информационное поле.</p>
</td>
</tr>
<tr>
<td><p>11</p>
</td>
<td><p>ctl_number_segments</p>
</td>
<td><p>Полное число сегментов в BLOB. Инициализирующее значение 0. Устанавливается функцией фильтра, информационное.</p>
</td>
</tr>
<tr>
<td><p>12</p>
</td>
<td><p>ctl_total_length</p>
</td>
<td><p>Полная длина BLOB, в байтах. Устанавливается функцией фильтра, информационное.</p>
</td>
</tr>
<tr>
<td><p>13</p>
</td>
<td>*ctl_status</p>
</td>
<td><p>Указатель на IB статус вектор (OUT)</p>
</td>
</tr>
<tr>
<td><p>14</p>
</td>
<td><p>ctl_data [8]</p>
</td>
<td><p> 8 &#8211; элементный массив данных определяемых приложением. Используйте это поле для хранения указателей, таких как указатели на область памяти и дескрипторы файлов созданные isc_blob_filter_open дескриптором, к примеру. Тогда, в следующий раз, в который функция фильтра вызывается указатели, будут доступны для использования.(IN, OUT)</p>
</td>
</tr>
<tr>
<td>
</td>
<td>
</td>
<td><p>&nbsp;
</td>
</tr>
</table>
<p>Программирование действий функции фильтра</p>
<p>Когда приложение вызывает функцию API Blob для Blob, который будет отфильтрован, InterBase передает соответствующее сообщение&nbsp; о действии в функцию фильтра посредством параметра действия. Существуют восемь возможных действий. Следующие макроопределения действий объявлены в ibase.h file:</p>
<p>#define isc_blob_filter_open 0</p>
<p>#define isc_blob_filter_get_segment 1</p>
<p>#define isc_blob_filter_close 2</p>
<p>#define isc_blob_filter_create 3</p>
<p>#define isc_blob_filter_put_segment 4</p>
<p>#define isc_blob_filter_alloc 5</p>
<p>#define isc_blob_filter_free 6</p>
<p>#define isc_blob_filter_seek 7</p>
<p>Следующая таблица перечисляет действия, и определяет, когда функция фильтра вызвается для каждого специфического действия. Большинство действий - результат событий, которые происходят, когда приложение вызывает функцию API Blob.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Действие</p>
</td>
<td><p>Когда вызывается фильтр с соответствующим действием</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_blob_filter_open</p>
</td>
<td><p>Вызывается когда приложение вызывает isc_open_blob2()</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>isc_blob_filter_get_segment</p>
</td>
<td><p>Вызывается когда приложение вызывает isc_get_segment()</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_blob_filter_close</p>
</td>
<td><p>Вызывается когда приложение вызывает isc_close_blob()</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_blob_filter_create</p>
</td>
<td><p>Вызывается когда приложение вызывает isc_create_blob2()</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>isc_blob_filter_put_segment</p>
</td>
<td><p>Вызывается когда приложение вызывает isc_put_segment()</p>
</td>
</tr>
<tr>
<td><p>6</p>
</td>
<td><p>isc_blob_filter_alloc</p>
</td>
<td><p>Вызывается когда InterBase инициализирует обработку фильтром; это не результат действия приложения</p>
</td>
</tr>
<tr>
<td><p>7</p>
</td>
<td><p>isc_blob_filter_free</p>
</td>
<td><p>Вызывается когда InterBase заканчивает обработку фильтром; это не результат действия приложения</p>
</td>
</tr>
<tr>
<td><p>8</p>
</td>
<td><p>isc_blob_filter_seek</p>
</td>
<td><p>Зарезервирован для внутреннего использования фильтра; не используется внешними фильтрами
</td>
</tr>
</table>
<p>Написание приложений которые требуют фильтрации</p>
<p>Требование фильтрации BLOB данных, читыемых или пишущихся в BLOB, происходи по следующим шагам.</p>
<p>1. Создается буфер параметров BLOB (BPB) определяющий целевой или исходный подтип, и необязательный кодовый набор символов (для текстовых подтипов)</p>
<p>2. Вызовите или isc_open_blob2 () или isc_create_blob2 () чтобы открыть Blob для чтения или для записи, соответственно. В запросе, передайте BPB, чью информацию, InterBase будет использовать, чтобы определить который фильтр должен быть вызван.</p>
<p>Понятие буфера параметров BLOB</p>
<p>Буфер параметров Blob (BPB) необходим всякий раз, когда фильтр будет использоваться при записи&nbsp; или чтении&nbsp; Blob. BPB - переменная типа массив символов, объявленная в приложении, которое содержит исходные и целевые подтипы. Когда данные читаются&nbsp; или записываются в&nbsp; Blob, связанный с BPB, InterBase автоматически вызовет соответствующий фильтр, основанный на исходных и целевых подтипах, указанных в BPB.</p>
<p>Если исходные и целевые подтипы являются 1 (ТЕКСТОМ), и BPB также определяет различные исходные и целевые наборы символов, то, когда данные читаются от или записываются в Blob, связанный с BPB, InterBase автоматически преобразуе) каждый символ&nbsp; источника в символ целевого набора символов.</p>
<p>Буфер параметров Blob может быть сгенерирован двумя способами:</p>
<p>1. Косвенно, через ВЫЗОВЫ API, создают исходные и целевые дескрипторы, а затем генерируют BPB исходя из информации находящейся в описателях.</p>
<p>2. Напрямую,&nbsp; заполняя BPB массив соответствующими значениями.</p>
<p>Если Вы генерируете BPB через ВЫЗОВЫ API, Вы не надо знать формат&nbsp; BPB. Но если Вы желаете непосредственно генерировать BPB, тогда Вы должны знать формат. Оба подхода описаны в следующих секциях. Формат BPB документирован в секции о прямом заполнении BPB.</p>
<p>Генерация буфера BLOB параметров используя API вызовы</p>
<p>Чтобы генерировать BPB косвенно, используйте ВЫЗОВЫ API, чтобы создать исходный и целевой дескрипторы Blob, и затем вызывовите isc_blob_gen_bpb () чтобы генерировать BPB из то информации, что в описателях. Следуйте&nbsp; этими шагами:</p>
<p>1. Объявите два дескриптора Blob, один для источника, а другой для цели.</p>
<p>Например,</p>
<p> #include "Ibase.h"</p>
<p>ISC_Blob_DESC from_desc, to_desc;</p>
<p>2. Сохраните соответствующую информацию в дескрипторах Blob, вызывая одну из функций isc_blob_default_desc (), isc_blob_lookup_desc (), или isc_blob_set_desc (), или,&nbsp; заполните дескрипторные поля напрямую. Следующий пример просматривает текущий подтип и информацию о наборе символов для столбца Blob по имени GUIDEBOOK в таблице по имени TOURISM, и сохраняет это в исходном дескрипторе, from_desc. Он устанавливает целевой дескриптор , to_desc к заданному по умолчанию подтипу (ТЕКСТ) и набору символов, так, чтобы исходные данные были преобразованы к простому тексту</p>
<pre>
140 INTERBASE 5
isc_blob_lookup_desc 
status_vector,
&amp;db_handle; /* set in previous isc_attach_database() call */
&amp;tr_handle, /* set in previous isc_start_transaction() call */
"TOURISM", /* table name */
"GUIDEBOOK", /* column name */
&amp;from_desc, /* Blob descriptor filled in by this function call */
&amp;global);
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
/* process error */
isc_print_status(status_vector);
return(1);
};
isc_blob_default_desc (
&amp;to_desc, /* Blob descriptor filled in by this function call */
"", /* NULL table name; it's not needed in this case */
""); /* NULL column name; it's not needed in this case */
</pre>
<p>3. Обьявите&nbsp; массив символов который будет использоваться как BPB. Удостоверьтесь чтобы он был достаточного размера.</p>
<p>char bpb[20];</p>
<p>4. Объявите&nbsp; переменную unsigned short в которою IB будет сохранять фактическую длину данных BPB:</p>
<p>unsigned short actual_bpb_length;</p>
<p>5. Вызовите isc_blob_gen_bpb() для инициализации BPB информацией из исходных и целевых BLOB дескрипторов. К примеру:</p>
<pre>isc_blob_gen_bpb(
status_vector,
&amp;to_desc, /* target Blob descriptor */
&amp;from_desc, /* source Blob descriptor */
sizeof(bpb), /* length of BPB buffer */
bpb, /* buffer into which the generated BPB will be stored*/
&amp;actual_bpb_length /* actual length of generated BPB */
);
</pre>

<p>Создание буфера параметров BLOB напрямую</p>
<p>BPB можно создавать напрямую.</p>
<p>BPB состоит из следующих частей:</p>
<p>1. Байт определяющий версию BPB, это константа isc_bpb_version1.</p>
<p>2. Ряд кластеров из одного или нескольких байт</p>
<p>Каждый кластер состоит из следующих частей:</p>
<p>1. Первый байт это тип параметра. Это одна из онстант определенная для всех типов параметров (например, isc_bpb_target_type).</p>
<p>2. Второй байт определяет число байт оставшихся до конца кластера (это и есть длина самого параметра)</p>
<p>3. Переменное число байт интерпертирующееся в зависимости от типа параметра.</p>
<p class="note">Примечание: Все числа в BPB представляются в универсальном формате сначала идет младший байт потом более старший.</p>
<p>Следующая таблица показывает список типов параметров</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Параметр типа</p>
</td>
<td><p>Описание</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_bpb_target_type</p>
</td>
<td><p>Целевой подтип</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td>isc_bpb_source_type</p>
</td>
<td><p>Исходный подтип</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_bpb_target_interp</p>
</td>
<td><p>Целевой набор символов</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_bpb_source_interp</p>
</td>
<td><p>Исходный набор символов
</td>
</tr>
</table>
<p>BPB должен содержать isc_bpb_version1 в первом байте, и должен содержать кластеры, определяющие исходные и целевые подтипы. Кластеры кодовой таблицы символов необязательны. Если исходные и целевые подтипы являются 1 (ТЕКСТ), и BPB также определяет различные исходный и целевой наборы символов, то, когда данные читаются или пишутся в&nbsp; Blob, связанный с BPB, InterBase автоматически преобразует каждый символ источника в символ целевого набора символов.</p>
<p>В следущем примере напрямую создается BPB для фильтра который исходный подтип &#8211;4 переводит в целевой подтип 1(ТЕКСТ)</p>
<pre>char bpb[] = {
isc_bpb_version1,
isc_bpb_target_type,
1, /* # bytes that follow which specify target subtype */
1, /* target subtype (TEXT) */
isc_bpb_source_type,
1, /* # bytes that follow which specify source subtype */
–4, /* source subtype*/
};
</pre>
<p>Конечно, если Вы не знаете исходные и целевые подтипы до времени выполнения, Вы можете инициализировать BPB в соответствующих местах во время выполнения.</p>
<p>Запрос на использование фильтра</p>
<p>Вы запрашиваете использование фильтра при открытии или создании Blob для чтения или&nbsp; для записи. При вызове isc_open_blob2 () или isc_create_blob2 (), передайте BPB, чью информация, InterBase будет использовать, чтобы определить который фильтр должен быть вызван.</p>
<p>Следующий пример показывает создание и открытие BLOB для записи.</p>
<pre>isc_blob_handle blob_handle; /* declare at beginning */
ISC_QUAD blob_id; /* declare at beginning */
. . .
isc_create_blob2(
status_vector,
&amp;db_handle,
&amp;tr_handle,
&amp;blob_handle, /* to be filled in by this function */
&amp;blob_id, /* to be filled in by this function */
actual_bpb_length, /* length of BPB data */
&amp;bpb /* Blob parameter buffer */
)
if (status_vector[0] == 1 &amp;&amp; status_vector[1])
{
isc_print_status(status_vector);
return(1);
}
</pre>

<p>Работа&nbsp; с массивом данных</p>
<p>Эта глава описываетмассивы типов данных и как работать с ними используя API функции. Она показывает как установитьдескрптор массива определяющий однозначно массив или массив подмножеств для выборки или для записи, и как использовать две API функции которые управляют доступом к массивам.</p>
<p>Следующая таблица содержит все API функции для работы с массивами. Первые функции показаны те которые могут быть использованы для иниициализации дескриптора массива, а другие для доступа к массиву данным.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Функция</p>
</td>
<td><p>Описание</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_array_lookup_desc()</p>
</td>
<td><p>Ищет и сохраняет в дескрипторе массива тип данных, длину, масштаб, и размеры для всех элементов в указанного столбца массива указанной таблицы</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>isc_array_lookup_bounds()</p>
</td>
<td><p>Делает тоже что и функция isc_array_lookup_desc (), а также ищет и сохраняет верхние и нижние границы каждой величины</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_array_set_desc()</p>
</td>
<td><p>Инициализируетдескриптор массива параметрами переданными ей</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_array_get_slice()</p>
</td>
<td><p>Ищет данные в массиве</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>isc_array_put_slice()</p>
</td>
<td><p>Пишет данные в массив
</td>
</tr>
</table>
<p>Введение в массивы</p>
<p>InterBase поддерживает массивы большинства типов данных. Использование массива позволяет множественным элементам данных быть сохраненным в одном столбце. InterBase может обращаться с массивом как отдельным модулем, или как рядом отдельных модулей, называемых секторами. Использование массива уместно когда:</p>
<p>Элементы данных естественно образуют набор того же самого типа данных.</p>
<p>Полный набор элементов данных в отдельном)столбце базы данных должен быть представлен и управляться как модуль, в противоположность сохранению каждого элемента в отдельном столбце.</p>
<p>Каждый элемент должен также быть идентифицирован и иметь индивидуальный доступ.</p>
<p>Элементы данных в массиве называются элементами массива. Массив может содержать элементы любого типа данных InterBase кроме Blob, а также&nbsp; не может быть массив массивов. Все элементы определенного массива имеют тот же самый тип данных.</p>
<p>InterBase поддерживает многомерные массивы, массивы с от 1 до 16 размерностей. Многомерные массивы хранятся в строке - в основном порядок).</p>
<p>Размерности Массива имеют определенный диапазон верхних и нижних границ, называемых нижними индексами. Нижние индексы массива определяются, когда столбец массива создается.</p>
<p>Хранение массивов БД</p>
<p>IB не хранит непосредственно массив данных в поле записи таблицы. Там она хранит ID массива. ID массива есть уникальное числовое занчение которое ссылаетс на массив данных, который хранится в другом месте БД.</p>
<p>Дескрипторы массива</p>
<p>Дескрипор массива описывает как массив или подмножество массива выбираться илизаписываться в ISC_ARRAY_DESC структуру. ISC_ARRAY_DESC определена в заголовочном файле ibase.h&nbsp; в таком виде:</p>
<pre>typedef struct {
unsigned char array_desc_dtype; /* Datatype */
char array_desc_scale; /* Scale for numeric datatypes */
unsigned short array_desc_length;
/* Length in bytes of each array element */
char array_desc_field_name [32]; /* Column name */
char array_desc_relation_name [32]; /* Table name */
short array_desc_dimensions; /* Number of array dimensions */
short array_desc_flags;
/* Specifies whether array is to be accessed in row-major or
column-major order */
ISC_ARRAY_BOUND array_desc_bounds [16];
/* Lower and upper bounds for each dimension */
} ISC_ARRAY_DESC;
ISC_ARRAY_BOUND определен как:
typedef struct {
short array_bound_lower; /* lower bound */
short array_bound_upper; /* upper bound */
} ISC_ARRAY_BOUND;
</pre>
<p>Дескриптор массива содержит 16 ISC_ARRAY_BOUND структур, одну для каждой возможной размерности. Массив с n размерностями устанавливает верхние и нижние границы для первых n ISC_ARRAY_BOUND структур. Число фактических размерностей массива определено в array_desc_dimensions поле дескриптора массива.</p>
<p>Когда Вы выбираете данные из массива, Вы применяете Дескриптор массива определяющий сектор массива (полный массив или подмножество смежных элементов массива) для выборки. Точно так же, когда Вы записываете данные в массив, Вы применяете Дескриптор массива определяющий сектор массива который будет записан .</p>
<p>Инициализация дескриптора массива</p>
<p>Существуют 4 способа для инициализации дескриптора массива:</p>
<p>- Вызовите isc_array_lookup_desc(), который найдет ( в системной таблице метаданных) и сохранит в дескрипторе массива тип данных, длину, масштаб и размерности для определенного для массива столбца в определенной таблице. Эта функция также сохранит название таблицы и столбца в дескрипторе, и инициализирует его array_desc_flags поле показывающее какой массив доступен в первой строке. К примеру:</p>
<p>isc_array_lookup_desc(</p>
<p>status_vector,</p>
<p>&amp;db_handle, /* Set by isc_attach_database() */</p>
<p>&amp;tr_handle, /* Set by isc_start_transaction() */</p>
<p>"PROJ_DEPT_BUDGET",/* table name */</p>
<p>"QUART_HEAD_CNT",/* array column name */</p>
<p>&amp;desc /* Инициализируемый дескриптор */</p>
<p>);</p>
<p>- Вызовите isc_array_lookup_bounds (), который найдет и выполниттот же самый вызов isc_array_lookup_desc (), за исключением того, что функция isc_array_lookup_bounds () также выбирает и сохраняет в Дескрипторе массива верхние и нижние границы каждой размерности</p>
<p>- Вызовите isc_array_set_desc(), которая инициализирует дескриптор параметрами, быстрее нежели она стала бы обращаться к метаданным для инициализиции. Например:</p>
<p>short dtype = SQL_TEXT;</p>
<p>short len = 8;</p>
<p>short numdims = 2;</p>
<p>isc_array_set_desc(</p>
<p>status_vector,</p>
<p>"TABLE1", /* table name */</p>
<p>"CHAR_ARRAY", /* array column name */</p>
<p>&amp;dtype, /* datatype of elements */</p>
<p>&amp;len, /* length of each element */</p>
<p>&amp;numdims, /* number of array dimensions */</p>
<p>&amp;desc /* descriptor to be filled in */</p>
<p>);</p>
<p>- Установите дескриптор полей напрямую. Например, установка поля array_desc_dimensions в дескрипторе desc происходит так:</p>
<p>desc.array_desc_dimensions = 2;</p>
<p>Доступ к массиву данных</p>
<p>Interbase поддерживает следующие операции над массивом данных:</p>
<p>- Чтение из массива или сектора массива</p>
<p>- Запись в масссив:</p>
<p>Включение нового массива в строку вставляемую в таблицу.</p>
<p>Замена массива ссылающегося на столбец массива строкой с новым массивом</p>
<p>Обновление массива ссылающегося на столбец массива строкой с модифицированными данными и сектора с данными</p>
<p>- Удаление массива</p>
<p> DSQL API функции и структуры данных XSQLDA</p>
<p>DSQL функции API&nbsp; и структуры данных XSQLDA необходимы, чтобы выполнить SELECT, INSERT, и инструкции UPDATE. Следующие секции включают описания DSQL, программные методы, нужные для выполнения этих инструкций</p>
<p class="note">Примечание:</p>
<p>Следующие операции над массивом не поддерживаются:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Ссылка на размеры массива динамичекси в DSQL</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Установка элемента массива в NULL</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Использование аггрегативных функций, таких как min(), max(), с массивами.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Ссылка на массивыв GROUP BY</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Создание представлений которые производят выборку из секторов массива</td></tr></table></div>
<p>Чтение данных из массива</p>
<p>Есть 7 шагов для чтения данных из массива или сектора массива:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Создание инструкции SELECT, которая выбирает соответствущий столбец</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Подготовка структуры вывода XSQLDA для хранения данных столбца для каждой выбраной строки</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Подготовка инструкции SELECT для выполнения</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Выполнение инструкции</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Заполнение дескриптора массива информацией о описывающей массив или сетор массива для выборки</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">6.</td><td>Выбираем отобранные строки по одной</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">7.</td><td>Читаем и обрабатываем массив данных из каждой строки</td></tr></table></div>
<p>Создание строки SELECT</p>
<p>char *sel_str =</p>
<p>"SELECT DEPT_NO, QUART_HEAD_CNT FROM PROJ_DEPT_BUDGET \</p>
<p>WHERE year = 1994 AND PROJ_ID = &#8217;VBASE&#8217;";</p>
<p>Подготовка XSQLDA ля вывода</p>
<p>XSQLDA *out_sqlda;</p>
<p>out_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(2));</p>
<p>out_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p>out_sqlda-&gt;sqln = 2;</p>
<p>Подготовка SELECT инструкции к выполнению</p>
<p>isc_stmt_handle stmt; /* Declare a statement handle. */</p>
<p>stmt = NULL; /* Set handle to NULL before allocation. */</p>
<p>isc_dsql_allocate_statement(status_vector, &amp;db_handle, &amp;stmt);</p>
<p>isc_dsql_prepare(</p>
<p>status_vector,</p>
<p>&amp;trans, /* Set by previous isc_start_transaction() call. */</p>
<p>&amp;stmt, /* Statement handle set by this function call. */</p>
<p>0, /* Specifies statement string is null-terminated. */</p>
<p>sel_str, /* Statement string. */</p>
<p>1, /* XSQLDA version number. */</p>
<p>out_sqlda /* XSQLDA for storing column data. */</p>
<p>);</p>
<p>Устанавливаем XSQLVAR структуру дл я каждого столбца.</p>
<p>Для столбцов чьи типы известны во время компиляции</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Определяем тип столбца (если он не был установлен isc_dsql_prepare())</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Уквзатель sqldata&nbsp; связывает с локальными переменными</td></tr></table></div>
<p>Для столбцов чьи типы неизвестны вр время компиляции</p>
<p>- Приводим типы элементов (необязательно). Например, SQL_VARYING к SQL_TEXT.</p>
<p>- Динамичаски выделяем память для локального хранения данных, и указатель на нее присваиваем sqldata</p>
<p>Не забываем кому нужно про NULL индикатор</p>
<p>Поиск данных для массивов (и Blob) столбцов отличаются от других типов столбцов, так что поля XSQLVAR должны быть установлены по-другому. Для не-массива (и не-BLOB) столбцов, isc_dsql_prepare () устанавливают каждый XSQLVAR sqltype поле к соответствующему полевому типу найденных данных, когда отобранные данные строки списка выбраны. Для столбцов массива, тип установливается в SQL _ARRAY (или SQL _ARRAY + 1, если столбцу массива позволяют быть NULL). InterBase сохраняет внутренний идентификатор массива (array ID), не данные массива, в sqldata когда&nbsp; строки данных выбраны, так что Вы должны направить sqldata на область размером ID array.</p>
<p>Пример внизу:</p>
<p>ISC_QUAD array_id = 0L;</p>
<p>char dept_no[6];</p>
<p>short flag0, flag1;</p>
<p>out_sqlda-&gt;sqlvar[0].sqldata = (char *) dept_no;</p>
<p>out_sqlda-&gt;sqlvar[0].sqltype = SQL_TEXT + 1;</p>
<p>out_sqlda-&gt;sqlvar[0].sqlind = &amp;flag0;</p>
<p>out_sqlda-&gt;sqlvar[1].sqldata = (char *) &amp;array_id;</p>
<p>out_sqlda-&gt;sqlvar[1].sqltype = SQL_ARRAY + 1;</p>
<p>out_sqlda-&gt;sqlvar[1].sqlind = &amp;flag1;</p>
<p>Выполнение инструкции</p>
<p>isc_dsql_execute(</p>
<p>status_vector,</p>
<p>&amp;trans, /* set by previous isc_start_transaction() call */</p>
<p>&amp;stmt, /* set above by isc_dsql_prepare() */</p>
<p>1, /* XSQLDA version number */</p>
<p>NULL /* NULL since stmt doesn&#8217;t have input values */</p>
<p>);</p>
<p>Заполнение дескриптора массива</p>
<p>1. Создаем дескриптор массива</p>
<p>ISC_ARRAY_DESC desc;</p>
<p>2. И заполняем дескриптор массива как было описано выше</p>
<p>isc_array_lookup_bounds(</p>
<p>status_vector,</p>
<p>&amp;db_handle,</p>
<p>&amp;trans,</p>
<p>"PROJ_DEPT_BUDGET",/* table name */</p>
<p>"QUART_HEAD_CNT",/* array column name */</p>
<p>&amp;desc);</p>
<p>Предположим столбец массива, QUART_HEAD_CNT, - одномерный массив, состоящий из четырех элементов, и он был объявлен нижний индекс 1 и верхним&nbsp; 4, когда это был создан. Тогда после вышеупомянутого запроса к isc_array_lookup_bounds (), поля Дескриптора массива для границ будут содержать следующую информацию:</p>
<p>desc.array_desc_bounds[0].array_bound_lower == 1</p>
<p>desc.array_desc_bounds[0].array_bound_upper == 4</p>
<p>Если Вы хотите читать только сектор массива, то измените верхние или нижние границы соответственно. Например, если Вы только хотите читать первые два элемента массива, измените верхнюю границу к значению 2, как в:</p>
<p>desc.array_desc_bounds[0].array_bound_upper = 2</p>
<p>Извлечение выбранных строк</p>
<pre>ISC_STATUS fetch_stat;
long SQLCODE;
. . .
while ((fetch_stat = j
isc_dsql_fetch(status_vector, &amp;stmt, 1, out_sqlda))
== 0)
{
/* Read and process the array data */
}
if (fetch_stat != 100L)
{
/* isc_dsql_fetch returns 100 if no more rows remain to be
retrieved */
SQLCODE = isc_sqlcode(status_vector);
isc_print_sqlerror(SQLCODE, status_vector);
return(1);
}
</pre>
<p>Чтение и обработка массива данных</p>
<p>Чтение и обработка массива или массива сектора данных:</p>
<p>1. Создаем буфер для хранения читаемых данных. Сделайте его достаточного размера для хранения всех элементов читаемого сектора. Например, следующий код делает объявление буфера массива для хранения 4 long элементов.</p>
<p>long hcnt[4];</p>
<p>2. Обьявляем short переменную для определения размера буфера массива</p>
<p>short len;</p>
<p>3. Устанавливаем переменную в длину буфера:</p>
<p>len = sizeof(hcnt);</p>
<p>4. Читаем массив или массив сектора данных в буфер вызвав isc_array_get_slice(). Обрабатываем прочитанные данные. В следующем примере массив читается в hcnt буфер массива, и обрабатывается.</p>
<p>isc_array_get_slice(</p>
<p>status_vector,</p>
<p>&amp;db_handle,/* set by isc_attach_database()*/</p>
<p>&amp;trans, /* set by isc_start_transaction() */</p>
<p>&amp;array_id, /* array ID put into out_sqlda by isc_dsql_fetch()*/</p>
<p>&amp;desc, /* array descriptor specifying slice to be read */</p>
<p>(void *) hcnt,/* buffer into which data will be read */</p>
<p>(long *) &amp;len/* length of buffer */</p>
<p>);</p>
<p>if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
<p>{</p>
<p>isc_print_status(status_vector);</p>
<p>return(1);</p>
<p>}</p>
<p>/* Make dept_no a null-terminated string */</p>
<p>dept_no[out_sqlda-&gt;sqlvar[0].sqllen] = &#8217;\0&#8217;;</p>
<p>printf("Department #: %s\n\n", dept_no);</p>
<p>printf("\tCurrent head counts: %ld %ld %ld %ld\n",</p>
<p>hcnt[0], hcnt[1], hcnt[2], hcnt[3]);</p>
<p>Запись данных в массив</p>
<p> Isc_array_put_slice() вызывается для записи данных в массив или массив секторов</p>
<p>Следующие шаги требуются для вставки, замены, или обновления массива данных</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Подготовка дескриптора с информацией описывающей массив (или сектор) для записи</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Подготовка буфера массива с данными для записи.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Подготовка соответствующей DSQL инструкции.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>Вызовите isc_array_put_slice() для создание нового массива, и для записи данных из буфера массива в массив или сектор массива</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>Свяжите новый массив со столбцом массива, установив его значение к ID массива</td></tr></table></div>
<p>Подготовка дескриптора массива</p>
<p> 1. Создайте дескриптор массива:</p>
<p>ISC_ARRAY_DESC desc;</p>
<p>2. Заполните дескриптор информацией</p>
<p>Заполните Дескриптор&nbsp; информацией относительно столбца массива, куда данные будут записаны. Делайте это или,&nbsp; вызывая одну из функций isc_array_lookup_bounds (), isc_array_lookup_desc (), или isc_array_set_desc (), или,&nbsp; непосредственно заполняя Дескриптор.</p>
<p>isc_array_lookup_bounds(</p>
<p>status_vector,</p>
<p>db_handle,</p>
<p>&amp;trans,</p>
<p>"PROJ_DEPT_BUDGET",/* table name */</p>
<p>"QUART_HEAD_CNT",/* array column name */</p>
<p>&amp;desc);</p>
<p>Подготовка буфера с данными</p>
<p>long hcnt[4];</p>
<p>short len;</p>
<p>len = sizeof(hcnt);</p>
<p>заполняем буфер данными</p>
<p>hcnt[0] = 4;</p>
<p>hcnt[1] = 5;</p>
<p>hcnt[2] = 6;</p>
<p>hcnt[3] = 6;</p>
<p>Подготовка инструкции вставки и обновления</p>
<p>char *upd_str =</p>
<p>"UPDATE PROJ_DEPT_BUDGET SET QUART_HEAD_CNT = ? WHERE \</p>
<p>YEAR = 1994 AND PROJ_ID = "MKTPR" AND DEPT_NO = ?";</p>
<p>XSQLDA *in_sqlda;</p>
<p>in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(2));</p>
<p>in_sqlda-&gt;version = SQLDA_VERSION1;</p>
<p>in_sqlda-&gt;sqln = 2;</p>
<p>#define NUMLEN 4</p>
<p>char dept_no[NUMLEN + 1];</p>
<p>ISC_QUAD array_id;</p>
<p>in_sqlda-&gt;sqlvar[0].sqldata = &amp;array_id;</p>
<p>in_sqlda-&gt;sqlvar[0].sqltype = SQL_ARRAY + 1;</p>
<p>in_sqlda-&gt;sqlvar[0].sqllen = sizeof(ISC_QUAD);</p>
<p>in_sqlda-&gt;sqlvar[1].sqldata = dept_no;</p>
<p>in_sqlda-&gt;sqlvar[1].sqltype = SQL_TEXT;</p>
<p>in_sqlda-&gt;sqlvar[1].sqllen = 4;</p>
<p>Вызов isc_array_put_slice()</p>
<p>1. Обьявляем ID массива</p>
ISC_QUAD array_id; /* Declare an array ID. */</p>
<p>2. Инициализируем его</p>
<p>array_id = NULL;/* Set handle to NULL before using it */</p>
<p>3. Вызываем isc_array_put_slice().</p>
<p>isc_array_put_slice(</p>
<p>status_vector,</p>
<p>&amp;db_handle,</p>
<p>&amp;trans,</p>
<p>&amp;array_id,/* array ID (NULL, or existing array&#8217;s array ID) */</p>
<p>&amp;desc, /* array descriptor describing where to write data */</p>
<p>hcnt, /* array buffer containing data to write to array */</p>
<p>&amp;len /* length of array buffer */</p>
<p>);</p>
<p>Связываем новый массив с массивом столбцом</p>
<p>isc_dsql_execute_immediate(</p>
<p>status_vector,</p>
<p>&amp;db_handle,</p>
<p>&amp;trans,</p>
<p>0, /* indicates string to execute is null-terminated */</p>
<p>upd_str, /* UPDATE statement string to be executed */</p>
<p>1, /* XSQLDA version number */</p>
<p>in_sqlda /* XSQLDA supplying parameters to UPDATE statement */</p>
<p>);</p>
<p>Удаление массива</p>
<p>Существует три способа удаления</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>Удалите строку содержащую массив обычной инструкцией DELETE</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>Замените массив други, как описано выше. Если массив столбец содержит ID массива, и вы модифицируете столбец&nbsp; ссылкой на другой массив, то массив со старым ID будет удален во время следующей сборки “мусора”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>Сьросьте в NULL столбец ссылающийся на массив. Например, используя DSQL инструкцию:</td></tr></table></div><p>"UPDATE JOB SET LANGUAGE_REQ = NULL \</p>
<p>WHERE JOB_CODE = "SA12" AND JOB_GRADE = 10"</p>
<p>И массив, ссылка на который стала NULL, будет удален при следующей сборке “мусора”</p>

<p>Работа с событиями</p>
<p>Эта глава описывает, как работать с событиями, передающими сообщение&nbsp; от триггера или хранимой процедуры в приложение, чтобы сообщить о возникновении указанного состояния или действия, обычно это изменения базы данных типа вставки, модификации, или удаления записи. Она объясняет, как устанавливать буфера событий, и использовать функции API, чтобы делать синхронные и асинхронные вызовы событий В следующей таблице, функции перечислены в том порядке в каком они обычно появляются в приложении:</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>№</p>
</td>
<td><p>Функция</p>
</td>
<td><p>Описание</p>
</td>
</tr>
<tr>
<td><p>1</p>
</td>
<td><p>isc_event_block()</p>
</td>
<td><p>Создать буфер параметров событий</p>
</td>
</tr>
<tr>
<td><p>2</p>
</td>
<td><p>isc_wait_for_event()</p>
</td>
<td><p>Ожидание синхронного события которое будет зарегистрировано</p>
</td>
</tr>
<tr>
<td><p>3</p>
</td>
<td><p>isc_que_events()</p>
</td>
<td><p>Установите асинхронное событие и возвратите управление приложению</p>
</td>
</tr>
<tr>
<td><p>4</p>
</td>
<td><p>isc_event_counts()</p>
</td>
<td><p>Определите исзменение значения счетчика событий в буфере параметров событий</p>
</td>
</tr>
<tr>
<td><p>5</p>
</td>
<td><p>isc_cancel_events()</p>
</td>
<td><p>Отказаться от интересующего события
</td>
</tr>
</table>
<p>Для асинхронных событий, эта глава описывает, как создать асинхронное прерывание (СИНХРОННОЕ СИСТЕМНОЕ ПРЕРЫВАНИЕ), - функцию , которая отвечает на зарегистрированные события.</p>
<p>Понятие механизма событий</p>
<p>Механизм событий в InterBase состоит из&nbsp; четырех частей.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Ядра InterBase, которое обслуживает очередь событий и уведомляет приложения, когда событие происходит.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Буфера параметров событий, созданного приложением, где оно может получать уведомление о событиях .</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td> Приложение, которое регистрирует&nbsp;&nbsp; одно или несколько интересующих определенных, именованных событиямй и&nbsp; ждет уведомление, когда произойдет синхронное событие, или передает указатель на функцию AST, которая обрабатывает уведомления так, чтобы работа приложения могла продолжаться (асинхронное событие).</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">-</td><td>Триггера или хранимой процедуры, которая уведомляет ядро что определенное, именованное событие&nbsp; произошло. Уведомление вызывается POSTING.</td></tr></table></div>
<p>Механизм событий InterBase позволяет приложениям отвечать на действия и изменения базы данных, сделанные другими, одновременно выполняющимися&nbsp; программами без потребности других приложений, для связи непосредственно друг с другом, и без траты ПРОЦЕССОРНОГО ВРЕМЕНИ, требуемого для периодического опроса, чтобы определить произошло событие или нет.</p>
<p>Буфера параметров событий</p>
<p>Если приложение должно получать уведомление о событиях, оно должно установить два буфера параметров событий одинакового размера (EPBs) используя&nbsp; isc_event_block (). Первый буфер, event_buffer, используется, чтобы хранить счетчик возникновений события до того как приложение зарегистрирует заинтересованность в событии. Второй буфер, result_buffer, впоследствии заполняется изменениями счетчика возникновений события, когда наступает событие, представляющее интерес для приложения. Вторая функция API, isc_event_counts (), определяет различия между счетчиками в этих буферах, чтобы определить, которое событие или события произошело.</p>
<p>Уведомление о синхронном событии</p>
<p>Когда приложение зависит от возникновения определенного события для обработки, оно должно использовать синхронное уведомление события, чтобы приостановить свое собственное выполнение, пока событие не произойдет. Например, автоматизированное приложение торговли акциями, которое покупает или продает акции, когда происходят определенные изменения цен, оно могло бы начинать выполнение, установив EPB и зарегистрировав свой интерес в соответствующих событиях, а затем приостановить свое&nbsp; выполнение, пока&nbsp; изменения цен не происходят .</p>
<p>Isc_wait_for_event () функция обеспечивает синхронную обработку события для приложения.</p>
<p>Уведомление об асинхронном событии</p>
<p>Приложение должно реагировать на возможные события базы данных, но также и должно продолжать работу не ожидая возникновения события, в таком случае оно должно создать асинхронную функцию (AST) ловушку, и использовать асинхронное уведомление события, чтобы зарегистрировать интерес в событиях при продолжении своей работы. Например, акции, посредничающее приложение требует постоянного доступа к базе данных акций, чтобы позволить брокеру покупать и продавать акцию, но, в то же самое время, оно может&nbsp; использовать события, чтобы привести в готовность брокера к особенно существенным&nbsp; изменениям цен.</p>
<p>Isc_que_events () предоставляет асинхронную обработку событий</p>
<p>Управление событиями в транзакции</p>
<p>События происходят под управлением транзакции и могут поэтому быть подтверждены или откачены назад. Заинтересованные приложения не получают уведомление о событии пока транзакция в которой произошла регистрация события не завершиться подтверждением. Если регистрация события откачена назад, уведомления не происходит.</p>
<p>Транзакция может регистрировать то же самое событие не один раз перед подтверждением, но независимо от того сколько раз событие было зарегистрировано, это расценивается как единственное возникновение события при&nbsp; уведомлении о&nbsp; событии.</p>
<p>Прежде, чем приложение зарегистрирует интерес в событи, оно должно установить и заполнить два буфера параметров событий (EPBs), один для хранения начальных значений счетчика возникновения события для каждого события&nbsp; представляющего интерес, и другой для хранения измененных значений счетчика возникновения события. Эти буфера передаются как параметры в несколько API функций событий.</p>
<p>В C, каждый EPB объявлен как указатель на char следующим образом:</p>
<p>char *event_buffer, *result_buffer;</p>
<p>Как только буфера объявлены, isc_event_block () вызывается, чтобы выделить память для них, и заполнить их&nbsp; начальными значениями.</p>
<p>Isc_event_block () также требует по крайней мере двух дополнительных параметров: число событий, к которым приложение регистрирует свой интерес, и для каждого события, строка названия события. Один вызов isc_event_block () может передать 15 строк названий событий. Названия события должны соответствовать названиям событий, зарегистрированных хранимыми процедурами или триггерами. Isc_event_block () выделяет одинаковое количество памяти для каждого EPB, достаточного, чтобы обработать каждое именованное событие. Она возвращает единственное значение, указывая размер в байтах каждого буфера.</p>
<p>Синтаксис для isc_event_block ():</p>
<p>ISC_LONG isc_event_block(</p>
<p>char **event_buffer,</p>
<p>char **result_buffer,</p>
<p>unsigned short id_count,</p>
<p>. . . );</p>
<p>Например, следующий код устанавливает EPB для трех событий:</p>
<p>#include &lt;ibase.h&gt;;</p>
<p>. . .</p>
<p>char *event_buffer, *result_buffer;</p>
<p>long blength;</p>
<p>. . .</p>
<p>blength = isc_event_block(&amp;event_buffer, &amp;result_buffer, 3, "BORL",</p>
<p>"INTEL", "SUN");</p>
<p>. . .</p>
<p>Этот код предполагает, что имеются триггера или хранимые процедуры, определенные для базы данных, которые устанавливают события по имени “BORL”, “INTEL”, и “SUN”.</p>
<p>Приложения, которые должны ответить на больше чем 15 событий, могут делать множественные запросы к isc_event_block (), определяя различные EPB и списки событий для каждого запроса.</p>
<p>После установки EPB и определения событий, представляющих интерес с помощью isc_event_block (), приложение может использовать isc_wait_for_event () чтобы зарегистрировать интерес в этих событиях и приостанавливать свое выполнение, пока одно из событий не произойдет.</p>
<p class="note">Примечание: Isc_wait_for_event () не может использоваться в приложениях Microsoft Windows или под любой другой операционной системой, которая не разрешает процессам делать паузу. Приложения на этих платформах должны использовать асинхронную обработку события.</p>
<p>Синтаксис для isc_wait_for_event():</p>
<p>ISC_STATUS isc_wait_for_event(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_db_handle *db_handle,</p>
<p>short length,</p>
<p>char *event_buffer,</p>
<p>char *result_buffer);</p>
<p>Например следующий код устанавливает EPB для трех событий, потом вызывает isc_wait_for_event() чтобы остановить выполнение программыц пока одно их событий не произойдет.</p>
<p>#include &lt;ibase.h&gt;;</p>
<p>. . .</p>
<p>char *event_buffer, *result_buffer;</p>
<p>long blength;</p>
<p>ISC_STATUS status_vector[20];</p>
<p>isc_db_handle db1;</p>
<p>. . .</p>
<p>/* Assume database db1 is attached here and a transaction started. */</p>
<p>blength = isc_event_block(&amp;event_buffer, &amp;result_buffer, 3, "BORL",</p>
<p>"INTEL", "SUN");</p>
<p>isc_wait_for_event(status_vector, &amp;db1, (short)blength,</p>
<p>event_buffer, result_buffer);</p>
<p>/* Application processing is suspended here until an event occurs. */</p>
<p>. . .</p>
<p>Как isc_wait_for_event () вызвана, так&nbsp; приложение останавливает обработку, пока одно из требуемых событий не произойдет. Когда событие происходит, приложение обрабатывает результат в следующей исполняемой инструкции после запроса к isc_wait_for_event (). Если приложение ожидает&nbsp; больше чем одно событие, оно должно использовать isc_event_counts () чтобы определить, какое событие произошло</p>
<p>Один вызов isc_wait_for_event() может ожидать максимум 15 событий.</p>
<p>Приложения которым нужно ожидать более чем 15 событий должны в другом вызове продолжать ожидание.</p>
<p>Продолжение обработки с помощью isc_que_event()</p>
<p> Isc_que_events () вызывается, чтобы запрашивать асинхронное уведомление о событиях, перечисленных в буфере событий переданного как параметр. После завершения вызова, но перед тем как&nbsp; любое событие произойдет, управление возвращается приложению , чтобы оно могло продолжать обработку.</p>
<p>Когда требуемое событие произошло, InterBase вызывает асинхронную функцию ловушку(AST) , также переданную как параметр в isc_que_events (), для обработки проишедшего события. СИНХРОННОЕ СИСТЕМНОЕ ПРЕРЫВАНИЕ (AST) - функция или подпрограмма в приложении запроса, единственная цель которого состоит в том, чтобы обработать наступление события для приложения.</p>
<p>Синтаксис для isc_que_events ()</p>
<p>ISC_STATUS isc_que_events(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_db_handle *db_handle,</p>
<p>ISC_LONG *event_id,</p>
<p>short length,</p>
<p>char *event_buffer,</p>
<p>isc_callback event_function,</p>
<p>void *event_function_arg);</p>
<p>Event_id - длинный указатель, который используется как дескриптор в последующих запросах к isc_cancel_events () чтобы закончить уведомление о событии. Он должен бть проинициализирован когда передается. Параметр length - это размер event_buffer, который содержит текущий счетчик событий, которые нужно ждать. Event_function - указатель на функцию AST, которую InterBase должна вызывать, когда событие, представляющее интерес произошло.</p>
<p>It is up to the AST function to notify the application that it has been called, perhaps by setting a global flag of some kind. Event_function_arg - указатель на первый параметр, передаваемый AST</p>
<p>Создание AST</p>
<p>Функция события, event_function, должна быть написана с тремя входными параметрами:</p>
<p>1. Event_function_arg, указывается в вызове isc_que_events (). Обычно это указатель на буфер параметров событий, который должен быть заполнен измененными счетчиками события.</p>
<p>2. Длина&nbsp; буфера events_list.</p>
<p>3.Указатель на буфер events_list, временный буфер параметров события совершенно сходен с переданным isc_que_events (), исключение для модификаций счетчиков события. Буфер результатов автоматически не модифицируется возникновением события;</p>
<p> Это происходит до event_function, чтобы скопировать временный буфер events_list в&nbsp; постоянный буфер, который&nbsp; использует приложение.</p>
<p>Буфер результатов автоматически не обновляется при возникновении события; это - до event_function, чтобы копировать временный буфер events_list на более постоянный буфер, который приложение использует.</p>
<p>Event_function также должна разрешить приложению знать, что был вызов, например, устанавливая глобальный флажок.</p>
<p>Образец event_function представлен в следующем примере:</p>
<p>isc_callback event_function</p>
<p>(char *result, short length, char *updated)</p>
<p>{</p>
<p>/* Set the global event flag. */</p>
<p>event_flag++</p>
<p>/* Copy the temporary updated buffer to the result buffer. */</p>
<p>while (length--)</p>
<p>*result++ = *updated++;</p>
<p>return(0);</p>
<p>};</p>
<p>Полный пример с isc_que_events( )</p>
<p>Следующий фрагмент программы иллюстрирует вызов isc_que_events ()&nbsp; асинхронно ждущей возникновения события. В пределах цикла, она исполняет другую обработку, и проверяет флажок события (возможно установленный указанной функцией события) чтобы определить, когда событие было отмечено. Если событие отмечено, программа сбрасывает флажок события, вызывает isc_event_counts () чтобы определить, какие события были отмечены начиная с последнего вызова isc_que_events (), и вызывает isc_que_events () чтобы инициализировать другое асинхронное ожидание.</p>
<p>#include &lt;ibase.h&gt;</p>
<p>#define number_of_stocks 3;</p>
<p>#define MAX_LOOP 10</p>
<p>char *event_names[] = {"DEC", "HP", "SUN"};</p>
<p>char *event_buffer, *result_buffer;</p>
<p>ISC_STATUS status_vector[20];</p>
<p>short length;</p>
<p>ISC_LONG event_id;</p>
<p>int i, counter;</p>
<p>int event_flag = 0;</p>
<p>length = (short)isc_event_block(</p>
<p>&amp;event_buffer,</p>
<p>&amp;result_buffer,</p>
<p>number_of_stocks,</p>
<p>"DEC", "HP", "SUN");</p>
<p>isc_que_events(</p>
<p>status_vector,</p>
<p>&amp;database_handle, /* Set in previous isc_attach_database(). */</p>
<p>&amp;event_id,</p>
<p>length, /* Returned from isc_event_block(). */</p>
<p>event_buffer,</p>
<p>(isc_callback)event_function,</p>
<p>result_buffer);</p>
<p>if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
<p>{</p>
<p>isc_print_status(status_vector); /* Display error message. */</p>
<p>return(1);</p>
<p>};</p>
<p>counter = 0;</p>
<p>while (counter &lt; MAX_LOOP)</p>
<p>{</p>
<p>counter++;</p>
<p>if (!event_flag)</p>
<p>{</p>
<p>/* Do whatever other processing you want. */</p>
<p>;</p>
<p>}</p>
<p>else</p>
<p>{ event_flag = 0;</p>
<p>isc_event_counts(</p>
<p>status_vector,</p>
<p>length,</p>
<p>event_buffer,</p>
<p>result_buffer);</p>
<p>if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
<p>{</p>
<p>isc_print_status(status_vector); /*Display error message.*/</p>
<p>return(1);</p>
<p>};</p>
<p>for (i=0; i&lt;number_of_stocks; i++)</p>
<p>if (status_vector[i])</p>
<p>{</p>
<p>/* The event has been posted. Do whatever is appropriate,</p>
<p>such as initiating a buy or sell order.</p>
<p>Note: event_names[i] tells the name of the event</p>
<p>corresponding to status_vector[i]. */</p>
<p>;</p>
<p>}</p>
<p>isc_que_events(</p>
<p>status_vector,</p>
<p>&amp;database_handle,</p>
<p>&amp;event_id,</p>
<p>length,</p>
<p>event_buffer,</p>
<p>(isc_callback)event_function,</p>
<p>result_buffer);</p>
<p>if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
<p>{</p>
<p>isc_print_status(status_vector); /*Display error message.*/</p>
<p>return(1);</p>
<p>}</p>
<p>} /* End of else. */</p>
<p>} /* End of while. */</p>
<p>/* Let InterBase know you no longer want to wait asynchronously. */</p>
<p>isc_cancel_events(</p>
<p>status_vector,</p>
<p>&amp;database_handle,</p>
<p>&amp;event_id);</p>
<p>if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
<p>{</p>
<p>isc_print_status(status_vector); /* Display error message. */</p>
<p>return(1);</p>
<p>}</p>
<p>Определение какое событие произошло с помощью isc_event_counts( )</p>
<p>Когда приложение регистрирует заинтересованность в множественных событиях и получает уведомление, что событие произошло, дальше оно должно использовать isc_event_counts () чтобы определить, каккое событие или события произошли. isc_event_counts () вычитает значения массива event_buffer из значений&nbsp; массива result_buffer, чтобы определить сколько раз, каждый событие произошло начиная с того момента как приложения зарегистрировали интерес в наборе событий. Event_buffer и result_buffer - переменные, объявленные в&nbsp; приложении, и созданные и инициализированные isc_event_block ().</p>
<p>Разность для каждого элемента возвращается в массиве состояний ошибок, который передан в isc_event_counts (). Чтобы определить, какие события произошли, приложение должно проверить каждый элемент массива на значения отличные от нуля. Счетчик отличный от нуля указывает число событий зарегистрированых между моментом вызова isc_event_block ()&nbsp; и моментом времени когда событие было зарегистрировано, после вызовов isc_wait_for_event () или isc_que_events () . Где много приложений обращаются к той же самой базе данных, там определенный счетчик события может быть 1 или больше, и больше чем один элемент счетчика события может быть отличен от нуля.</p>
<p>Обратите внимание Когда первый раз устанавливают AST, чтобы поймать в ловушку события с помощью isc_que_events (), InterBase инициализирует все значения счетчика в статус вкеторе в 1, а не в 0. Чтобы убрать значения, вызовите isc_event_counts ().</p>
<p>В дополнение к определению которое событие произошело, isc_event_counts () повторно инициализирует массив event_buffer в ожидании другого вызова isc_wait_for_event () или isc_que_events (). Значения в event_buffer установлены в те же самые значения как переданные значения в result_buffer.</p>
<p>Полный синтаксис для isc_event_counts ():</p>
<p>void isc_event_counts(</p>
<p>ISC_STATUS status_vector,</p>
<p>short buffer_length,</p>
<p>char *event_buffer,</p>
<p>char *result_buffer);</p>
<p>Например, следующий код обьявляет интерес в трех событиях, ожидает их, затем использует isc_event_counts() чтобы определить какое событие произошло.</p>
<p>#include &lt;ibase.h&gt;;</p>
<p>. . .</p>
<p>char *event_buffer, *result_buffer;</p>
<p>long blength;</p>
<p>ISC_STATUS status_vector[20];</p>
<p>isc_db_handle db1;</p>
<p>long count_array[3];</p>
<p>int i;</p>
<p>. . .</p>
<p>/* Assume database db1 is attached here and a transaction started. */</p>
<p>blength = isc_event_block(&amp;event_buffer, &amp;result_buffer, 3, "BORL",</p>
<p>"INTEL", "SUN");</p>
<p>isc_wait_for_event(status_vector, &amp;db1, (short)blength,</p>
<p>event_buffer, result_buffer);</p>
<p>/* Application processing is suspended here until an event occurs. */</p>
<p>isc_event_counts(status_vector, (short)blength, event_buffer,</p>
<p>result_buffer);</p>
<p>for (i = 0; i &lt; 3; i++)</p>
<p>{</p>
<p>if (status_vector[i])</p>
<p>{</p>
<p>/* Process the event here. */</p>
<p>;</p>
<p>}</p>
<p>}</p>
<p>Отказ от интереса в асинхронном событии с помощью isc_cancel_events( )</p>
<p>Приложение, которое требовало асинхронное уведомление о событии с помощью isc_que_events () может впоследствии отменять требование уведомления в любое время с помощью&nbsp; isc_cancel_events () используя следующий синтаксис:</p>
<p>ISC_STATUS isc_cancel_events(</p>
<p>ISC_STATUS *status_vector,</p>
<p>isc_db_handle *db_handle,</p>
<p>ISC_LONG *event_id);</p>
<p>Event_id - набор дескрипторов событий в предыдущем вызове isc_que_events (). Например, следующий код отменяет интерес в событии или событиях, идентифицированных event_id:</p>
<p>include &lt;ibase.h&gt;;</p>
<p>. . .</p>
<p>/* For example code leading up to this call, see the code example</p>
<p>in "Continuous Processing with isc_event_que(), earlier in this</p>
<p>chapter. */</p>
<p>isc_cancel_events(status_vector, &amp;db_handle, &amp;event_id);</p>





<p>&nbsp;</p>
<p>Работа с сервисами</p>
<p>Эта глава охватывает InterBase API функции сервисов. Это средство позволяет Вам писать приложения, которые контролируют и управляют серверами InterBase и базами данных. Задачи, которые Вы можете выполнять с этими API, включают:</p>
<p>- Выполнение задачи обслуживания базы данных типа резервного копирования и восстановление, остановка и перезапуск, сборка "мусора", и сканирование на предмет испорченных структур данных</p>
<p>- Создание, изменение, и удаление пользователе в базе данных защиты</p>
<p>- Управление программными сертификатами</p>
<p>- Запросы информации о конфигурации баз данных и сервера</p>
<p>Обзор сервисных API</p>
<p>Этот раздел описывает основные коцепции сервисных API, использование буфера параметров сервисов, и методы для подключение и отключение к Service Manager</p>
<p>Общая информация</p>
<p>Сервисные API это группа функций в клиентской библиотеке (gds32.dll&nbsp; в Windows, libgds.a&nbsp; в UNIX/Linux). Сервисные API включены в утилиты gbak, gfix, gsec, gstat и iblicense, но естественно не все.</p>
<p>Все серверы InterBase включают средство называемое Менеджером Сервисов(Services Manager). API Сервисы позволяют клиентским приложениям делать запросы к Менеджеру Сервисов сервера InterBase, и Менеджер Сервисов исполняет задачи. Сервер может быть локальный (на том же самом главном компьютере что и ваше приложение), или удаленный (на другом главном компьютере на сети). API Сервисы предлагают те же самые особенности когда подлючены к локальному или удаленному серверу InterBase.</p>
<p>Семейство API Сервисов состоит из&nbsp; четырех функции:</p>
<p>Isc_service_attach () инициализирует связь с указанным Services Manager</p>
<p>Isc_service_start () вызывает сервисную задачу</p>
<p>Isc_service_query () запрашивает информацию, или задачу из Services Manager</p>
<p>Isc_service_detach () отключает от Services Manager</p>
<p>Использование буфера параметров сервисов</p>
<p>Вы можете настраивать ваше приложение для подключения к Services Manager,&nbsp; создавая буфер параметров сервисов (SPB), заполняя его нужными свойствами, и передать адрес SPB в isc_service_attach () или в другие функции в группе API Сервисов. Например, SPB может содержать имя пользователя и пароль для подключения к удаленному серверу.</p>
<p>SPB это символьный массив обьявленный в вашем приложении. Он содержит следующие элементы:</p>
<p>1. Первый байт включающий информацию о версии фрмата&nbsp; SPB, это константа isc_spb_version.</p>
<p>2. Второй байт определяет число версии котороя определена как макрос, и как рекомендуемая версия SPB для каждого релиза InterBase.</p>
<p>3. Далее идут один или несколько кластеров байт, каждый кластер описывает один параметр.</p>
<p>Кластера в свою очередь состоят из следующих частей</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="29">1.</td><td>Первый байт определяет что за параметр будет описан в кластере.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="29">2.</td><td>Второй байт определяет длину описфываемого параметра</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="29">3.</td><td>Дальше идет столько байт сколько определил  второй байт кластера.</td></tr></table></div>
<p>Пример заполнения буфера для имени пользователя</p>
<p>1 char spb_buffer[128], *spb = spb_buffer;</p>
<p>2 *spb++ = isc_spb_version;</p>
<p>3 *spb++ = isc_spb_current_version;</p>
<p>4 *spb++ = isc_spb_user_name;</p>
<p>5 *spb++ = strlen("SYSDBA");</p>
<p>6 strcpy(spb, "SYSDBA");</p>
<p>7 spb += strlen("SYSDBA");</p>
<p>Все числа представлены в нашем любимом универсальном формате.</p>
<p>Подключение к Services Manager с помощью isc_service_attach()</p>
<p>Используйте isc_service_attach() для подключения к удаленному IB Services Manager</p>
<p>Вы можете применять локальное или удаленное имя сервиса для опеределения к какому хосту будем подключаться.</p>
<p>Пример:</p>
<p>char *user = "SYSDBA",</p>
<p>*password = "masterkey", /* see security tip below */</p>
<p>*service_name = "jupiter:service_mgr";</p>
<p>ISC_STATUS status[20];</p>
<p>isc_svc_handle *service_handle = NULL;</p>
<p>spb_buffer[128], *spb = spb_buffer;</p>
<p>unsigned short spb_length;</p>
<p>*spb++ = isc_spb_version;</p>
<p>*spb++ = isc_spb_current_version;</p>
<p>*spb++ = isc_spb_user_name;</p>
<p>*spb++ = strlen(user);</p>
<p>strcpy(spb, user);</p>
<p>spb += strlen(user);</p>
<p>*spb++ = isc_spb_password;</p>
<p>*spb++ = strlen(password)</p>
<p>strcpy(spb, password);</p>
<p>spb += strlen(password);</p>
<p>spb_length = spb - spb_buffer;</p>
<p>if (isc_service_attach(status, 0, service_name,</p>
<p>&amp;service_handle, spb_length, spb_buffer))</p>
<p>{</p>
<p>isc_print_status(status);</p>
<p>exit(1);</p>
<p>}</p>
<p>Отключение от Service Manager c помощью isc_service_detach()</p>
<p>isc_service_detach(status, &amp;service_handle);</p>
<p>Вызов сервисных задач с помощью isc_service_start()</p>





&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
Справочник по API функциям</p>
&nbsp;</p>
isc_vax_integer()</p>
&nbsp;</p>
Изменяет порядок байт целого числа.</p>
<p>Синтакс ISC_LONG isc_vax_integer(char *buffer,short length);</p>
&nbsp;</p>
Параметр &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Тип &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Описание</p>
<p>buffer  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;char * &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Указатель на целое число для конвертации</p>
<p>length  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;short &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Длина в байтах целого числа для конвертации</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Может быть 1,2 или 4</p>
<p>Описание  isc_vax_integer ()&nbsp; меняет порядок байт целого числа находящегося в буфере и возвращает новое&nbsp; значение.</p>
<p>Обычное применение этой функции&nbsp; это преобразование целочисленных значений, переданных&nbsp; в буфер параметров базы данных к формату, где самый младший байт должен быть первым и cамый старший&nbsp; байт последним. В InterBase целочисленные значения должны быть представлены во буферах параметров&nbsp; ввода(например, DPB) и возвращены в буферах результатов в универсальном формате, где самый младший байт первый, и cамый cтарший байт последний. Isc_vax_integer () используется, чтобы преобразовать целые числа к универсальному формату и обратно.</p>
<p>Пример</p>
Следующий фрагмент кода преобразовывает 2-байтовое значение, хранимое в символьном буфере, который является буфером результатов, возвращенным функцией типа isc_database_info ():</p>
<p>#include &lt;ibase.h&gt;</p>
<p>char *p;</p>
<p>. . .</p>
<p>for(p = res_buffer; *p != isc_info_end;)</p>
<p>{</p>
<p>/* Чтение типа элемента следующего кластера в буфере результатов */</p>
<p>item = *p++;</p>
<p>/* Читает длину следующего значения в буфере результатов и преобразовует его. */</p>
<p>len = isc_vax_integer(p, 2);</p>
<p>p += len;</p>
<p>/* Теперь обработайте настоящее значение размером len байт. */</p>
<p>. . .</p>
<p>}</p>
<p>Возвращаемое значение isc_vax_integer () всегда возвращает полностью измененное побайтно длинное целочисленное значение.</p>
<p>Комментарий переводчика:</p>
<p>Если в буфере расположено число 0x00 0x04 0x00 x00, длиной 4 байта, p &#8211; указатель на символьный буфер этого числа, то соответствующий вызов isc_vax_integer(p, 4) даст ответ 1024.</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
Примеры программ</p>
&nbsp;</p>
/*==============================================================================================</p>
 &nbsp; &nbsp; &nbsp; &nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;применения функции isc_dsql_execute2</p>
 Функция позволяет выполнять запрос с параметрами возвращающий данные</p>
 Ошибки:</p>
 функция правильно работает если возвращает только одну строку данных,</p>
  т.е для нее не надо даже курсор открывать в этом случае,</p>
  но если возвращается несколько строк пишет SQLCODE=811, isc_print_sqlcode дает</p>
  multiple singleton rows. В документации написано что вроде бы функция может возвращать</p>
  несколько строк, но даже пример с ней приведен как возвращающий одну строку</p>
 Замечания:</p>
  Если вы желаете чтоб функция возвратила только одну группу данных&nbsp;</p>
 &nbsp; или не возвращала никаких данных, то лучше воспользоваться isc_dsql_exec_immed2()</p>
 &nbsp; вместо isc_dsql_prepare () и isc_dsql_execute2 ().</p>
  Инструкции CREATE DATABASE и SET TRANSACTION не выполняются с помощью isc_dsql_execute2,</p>
  а с помощью isc_dsql_execute_immediate().</p>
&nbsp;</p>
&nbsp;</p>
Описание примера:</p>
&nbsp;</p>
  скомпилированное с помощью этого кода приложение подключается к учебной базе данных</p>
 &nbsp; employee.gdb поставляемой с дистрибутивом ib6 и выполняет запрос следующего типа</p>
 &nbsp; "select currency from country where country=?", где вместо маркера ? можно ставить</p>
 &nbsp;&nbsp; любое название страны, в данном случае выбрана Australia.</p>
 &nbsp; &nbsp; &nbsp; &nbsp;После выполнения будет результат 'Currency=ADollar'</p>
 *============================================================================================*/</p>
#include &lt;stdio.h&gt;</p>
#include &lt;stdlib.h&gt;</p>
#include &lt;string.h&gt;</p>
#include &lt;ibase.h&gt;</p>
&nbsp;</p>
isc_db_handle db;</p>
isc_tr_handle tr;</p>
ISC_STATUS status_vector[20];</p>
short dpb_buf_len=20;</p>
char dpb_buf[]={</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_version1,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_user_name,6, 'S','Y','S','D','B','A',</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_dpb_password,9, 'm','a','s','t','e','r','k','e','y'</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;};</p>
char tpb_buf[]&nbsp; = &nbsp; &nbsp; &nbsp; &nbsp;{</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_version3,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_write,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_read_committed,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_no_rec_version,</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;isc_tpb_wait</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;};</p>
&nbsp;</p>
&nbsp;</p>
int main()</p>
{</p>
 int i;</p>
 long fetch_stat,SQLCODE;</p>
 short dtype;</p>
 char str[]="d:\\Interbase\\Examples\\V5\\Employee.gdb";</p>
 char *query = "SELECT CURRENCY FROM COUNTRY WHERE COUNTRY=?";</p>
 char currency[20];</p>
 isc_stmt_handle stmt;</p>
 XSQLDA *in_sqlda,*out_sqlda;</p>
 XSQLVAR *in_var,*out_var;</p>
&nbsp;</p>
&nbsp;</p>
 in_sqlda = (XSQLDA *)malloc(XSQLDA_LENGTH(1));</p>
 out_sqlda= (XSQLDA *)malloc(XSQLDA_LENGTH(1));</p>
 in_sqlda-&gt;version =out_sqlda-&gt;version = SQLDA_VERSION1;</p>
 in_sqlda-&gt;sqln = out_sqlda-&gt;sqln = 1;</p>
 stmt = NULL;</p>
 db=NULL;</p>
 tr=NULL;</p>
&nbsp;</p>
 isc_attach_database(status_vector, strlen(str), str, &amp;db,dpb_buf_len,dpb_buf);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
 isc_start_transaction(status_vector,&amp;tr,1,&amp;db,(unsigned short) sizeof(tpb_buf),tpb_buf);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 isc_dsql_allocate_statement(status_vector, &amp;db, &amp;stmt);</p>
 isc_dsql_prepare(status_vector, &amp;tr, &amp;stmt, 0,query, 1, out_sqlda);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
 isc_dsql_describe_bind(status_vector, &amp;stmt, 1, in_sqlda);</p>
&nbsp;</p>
&nbsp;</p>
 for (i=0, in_var = in_sqlda-&gt;sqlvar; i &lt; in_sqlda-&gt;sqld; i++, in_var++)</p>
 {</p>
  dtype = (in_var-&gt;sqltype &amp; ~1);</p>
  switch(dtype)</p>
  {</p>
 &nbsp; case SQL_VARYING:</p>
 &nbsp; in_var-&gt;sqltype = SQL_TEXT;</p>
 &nbsp; in_var-&gt;sqldata = (char *)malloc(sizeof(char)*in_var-&gt;sqllen);</p>
 &nbsp; strcpy(in_var-&gt;sqldata,"Australia");</p>
 &nbsp; in_var-&gt;sqllen=9;</p>
 &nbsp; break;</p>
  }</p>
  if (in_var-&gt;sqltype &amp; 1)</p>
  {</p>
&nbsp;</p>
 &nbsp; in_var-&gt;sqlind = (short *)malloc(sizeof(short));</p>
  }</p>
 }</p>
&nbsp;</p>
 isc_dsql_describe(status_vector, &amp;stmt,1, out_sqlda);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 for (i=0, out_var = out_sqlda-&gt;sqlvar; i &lt; out_sqlda-&gt;sqld; i++, out_var++)</p>
 {</p>
  dtype = (out_var-&gt;sqltype &amp; ~1);</p>
  switch(dtype)</p>
  {</p>
 &nbsp; case SQL_VARYING:</p>
 &nbsp; out_var-&gt;sqltype = SQL_TEXT;</p>
 &nbsp; out_var-&gt;sqldata = (char *)malloc(sizeof(char)*out_var-&gt;sqllen);</p>
 &nbsp; break;</p>
  }</p>
  if (out_var-&gt;sqltype &amp; 1)</p>
  {</p>
&nbsp;</p>
 &nbsp; out_var-&gt;sqlind = (short *)malloc(sizeof(short));</p>
  }</p>
 }</p>
&nbsp;</p>
 isc_dsql_execute2(status_vector, &amp;tr, &amp;stmt, 1,in_sqlda, out_sqlda);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  SQLCODE = isc_sqlcode(status_vector);</p>
  isc_print_sqlerror(SQLCODE, status_vector);</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 for(i=0;i&lt;out_sqlda-&gt;sqlvar-&gt;sqllen;++i )currency[i]=out_sqlda-&gt;sqlvar-&gt;sqldata[i];</p>
 currency[i]=0;</p>
 printf("\nCurrency=%s\n",currency);</p>
 isc_commit_transaction(status_vector,&amp;tr);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
ex:</p>
&nbsp;</p>
 if(db)</p>
  isc_detach_database(status_vector, &amp;db);</p>
 free(in_sqlda);</p>
 free(out_sqlda);</p>
 return 0;</p>
}</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
/*</p>
Пример с возвратом нескольких строк</p>
int main()</p>
{</p>
 int i,j;</p>
 long fetch_stat,SQLCODE;</p>
 short dtype;</p>
 char str[]="d:\\Interbase\\Examples\\V5\\Employee.gdb";</p>
 //char *query = "SELECT CURRENCY FROM COUNTRY";</p>
 char *query = "select currency from country where country ='USA' or country = 'Australia'";</p>
 char currency[20];</p>
 isc_stmt_handle stmt;</p>
 XSQLDA *out_sqlda;</p>
 XSQLVAR *out_var;</p>
&nbsp;</p>
 out_sqlda= (XSQLDA *)malloc(XSQLDA_LENGTH(1));</p>
 out_sqlda-&gt;version = SQLDA_VERSION1;</p>
 out_sqlda-&gt;sqln = 1;</p>
 stmt = NULL;</p>
 db=NULL;</p>
 tr=NULL;</p>
&nbsp;</p>
 isc_attach_database(status_vector, strlen(str), str, &amp;db,dpb_buf_len,dpb_buf);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
 isc_start_transaction(status_vector,&amp;tr,1,&amp;db,(unsigned short) sizeof(tpb_buf),tpb_buf);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 isc_dsql_allocate_statement(status_vector, &amp;db, &amp;stmt);</p>
 isc_dsql_prepare(status_vector, &amp;tr, &amp;stmt, 0,query, 1, out_sqlda);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 isc_dsql_describe(status_vector, &amp;stmt,1, out_sqlda);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 for (i=0, out_var = out_sqlda-&gt;sqlvar; i &lt; out_sqlda-&gt;sqld; i++, out_var++)</p>
 {</p>
&nbsp;</p>
  dtype = (out_var-&gt;sqltype &amp; ~1);</p>
  switch(dtype)</p>
  {</p>
 &nbsp; case SQL_VARYING:</p>
 &nbsp; out_var-&gt;sqltype = SQL_TEXT;</p>
 &nbsp; out_var-&gt;sqldata = (char *)malloc(sizeof(char)*out_var-&gt;sqllen);</p>
 &nbsp; break;</p>
  }</p>
  if (out_var-&gt;sqltype &amp; 1)</p>
  {</p>
 &nbsp; out_var-&gt;sqlind = (short *)malloc(sizeof(short));</p>
  }</p>
 }</p>
&nbsp;</p>
 isc_dsql_execute2(status_vector, &amp;tr, &amp;stmt, 1,NULL, out_sqlda);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  SQLCODE = isc_sqlcode(status_vector);</p>
  isc_print_sqlerror(SQLCODE, status_vector);</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
 isc_dsql_set_cursor_name(status_vector, &amp;stmt, "dyn_cursor", NULL);</p>
&nbsp;</p>
 while ((fetch_stat =isc_dsql_fetch(status_vector, &amp;stmt, 1, out_sqlda)) == 0)</p>
 {</p>
  for (i = 0; i &lt; out_sqlda-&gt;sqld; i++)</p>
  {</p>
 &nbsp; for(j=0;j&lt;out_sqlda-&gt;sqlvar-&gt;sqllen;++j )currency[j]=out_sqlda-&gt;sqlvar-&gt;sqldata[j];</p>
 &nbsp; currency[j]=0;</p>
 &nbsp; printf("Currency=%s\n",currency);</p>
  }</p>
 }</p>
 if (fetch_stat != 100L)</p>
 {</p>
&nbsp;</p>
  SQLCODE = isc_sqlcode(status_vector);</p>
  isc_print_sqlerror(SQLCODE, status_vector);</p>
 }</p>
 isc_dsql_free_statement(status_vector, &amp;stmt, DSQL_close);</p>
&nbsp;</p>
 isc_commit_transaction(status_vector,&amp;tr);</p>
 if (status_vector[0] == 1 &amp;&amp; status_vector[1])</p>
 {</p>
  isc_print_status(status_vector);goto ex;</p>
 }</p>
&nbsp;</p>
ex:</p>
&nbsp;</p>
 if(db)</p>
  isc_detach_database(status_vector, &amp;db);</p>
 free(out_sqlda);</p>
 return 0;</p>
}*/</p>

