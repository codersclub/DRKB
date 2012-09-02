<h1>Как стать невидимым в Windows NT (статья)?</h1>
<div class="date">01.01.2007</div>



<p>Как стать невидимым в Windows NT</p>

<p>Author: Holy_Father &lt;holy_father@phreaker.net&gt;</p>
<p>Version: 1.2 russian</p>
<p>Date: 05.08.2003</p>
<p>Translation: Kerk &lt;kerk_p@yahoo.com&gt;</p>

<p>Вступление </p>

<p>Эта статья описывает техники скрытия объектов, файлов, сервисов,</p>
<p>процессов и т.д. в ОС Windows NT. Эти методы основаны на перехвате функций</p>
<p>Windows API, что описано в моей статье "Hooking Windows API".</p>
<p>Данная информация была получена мною в процессе написания rootkit'а,</p>
<p>поэтому есть вероятность, что это может быть реализовано более эффективно или</p>
<p>намного более просто. </p>
<p>Под скрытием объектов в этой статье подразумевается замена некоторых</p>
<p>системных функций, которые работают с этим объектом таким образом, чтобы они</p>
<p>его пропускали. В случае, если объект - всего лишь возвращаемое значение</p>
<p>функции, мы просто возвратим значение, как будто бы объекта не существует.</p>
<p>Простейший метод (исключая случаи, когда сказано обратное) - это</p>
<p>вызов оригинальной функции с оригинальными аргументами и замена ее выходных</p>
<p>данных.</p>
<p>В этой версии статьи описаны методы скрытия файлов, процессов,</p>
<p>ключей и значений реестра, системных сервисов и драйверов, выделенной памяти и</p>
<p>хэндлов.</p>


<p>Файлы </p>

<p>Существует несколько способов скрытия файлов, чтобы ОС не могла их</p>
<p>видеть. Мы сконцентрируемся на изменении API и отбросим такие техники, как</p>
<p>использование возможностей файловой системы. К тому же это намного проще, т.к.</p>
<p>в этом случае нам не нужно знать как работает конкретная файловая система.</p>

<p>NtQueryDirectoryFile </p>

<p>Поиск файла в wNT в какой-либо директории заключается в просмотре всех</p>
<p>файлов этой директории и файлов всех ее поддиректорий. Для перечисления файлов</p>
<p>используется функция NtQueryDirectoryFile.</p>

<p>NTSTATUS NtQueryDirectoryFile(</p>
<p>IN HANDLE FileHandle,</p>
<p>IN HANDLE Event OPTIONAL,</p>
<p>IN PIO_APC_ROUTINE ApcRoutine OPTIONAL,</p>
<p>IN PVOID ApcContext OPTIONAL,</p>
<p>OUT PIO_STATUS_BLOCK IoStatusBlock,</p>
<p>OUT PVOID FileInformation,</p>
<p>IN ULONG FileInformationLength,</p>
<p>IN FILE_INFORMATION_CLASS FileInformationClass,</p>
<p>IN BOOLEAN ReturnSingleEntry,</p>
<p>IN PUNICODE_STRING FileName OPTIONAL,</p>
<p>IN BOOLEAN RestartScan</p>
<p>);</p>

<p>Для нас важны параметры FileHandle, FileInformation</p>
<p>и FileInformationClass. FileHandle - хэндл объекта директории, который может</p>
<p>быть получен с использованием функции NtOpenFile. FileInformation - указатель</p>
<p>на выделенную память, куда функция запишет необходимые данные.</p>
<p>FileInformationClass определяет тип записей в FileInformation.</p>
<p>FileInformationClass перечислимого типа, но нам необходимы только</p>
<p>четыре его значения, используемые для просмотра содержимого директории.</p>

<p>#define FileDirectoryInformation 1</p>
<p>#define FileFullDirectoryInformation 2</p>
<p>#define FileBothDirectoryInformation 3</p>
<p>#define FileNamesInformation 12</p>

<p>структура записи в FileInformation для FileDirectoryInformation:</p>

<p>typedef struct _FILE_DIRECTORY_INFORMATION { </p>
<p>ULONG NextEntryOffset;</p>
<p>ULONG Unknown;</p>
<p>LARGE_INTEGER CreationTime;</p>
<p>LARGE_INTEGER LastAccessTime;</p>
<p>LARGE_INTEGER LastWriteTime;</p>
<p>LARGE_INTEGER ChangeTime;</p>
<p>LARGE_INTEGER EndOfFile;</p>
<p>LARGE_INTEGER AllocationSize; </p>
<p>ULONG FileAttributes;</p>
<p>ULONG FileNameLength;</p>
<p>WCHAR FileName[1];</p>
<p>} FILE_DIRECTORY_INFORMATION, *PFILE_DIRECTORY_INFORMATION;</p>

<p>для FileFullDirectoryInformation:</p>

<p>typedef struct _FILE_FULL_DIRECTORY_INFORMATION {</p>
<p>ULONG NextEntryOffset;</p>
<p>ULONG Unknown;</p>
<p>LARGE_INTEGER CreationTime;</p>
<p>LARGE_INTEGER LastAccessTime;</p>
<p>LARGE_INTEGER LastWriteTime;</p>
<p>LARGE_INTEGER ChangeTime;</p>
<p>LARGE_INTEGER EndOfFile;</p>
<p>LARGE_INTEGER AllocationSize;</p>
<p>ULONG FileAttributes;</p>
<p>ULONG FileNameLength;</p>
<p>ULONG EaInformationLength;</p>
<p>WCHAR FileName[1];</p>
<p>} FILE_FULL_DIRECTORY_INFORMATION, *PFILE_FULL_DIRECTORY_INFORMATION;</p>

<p>для FileBothDirectoryInformation:</p>

<p>typedef struct _FILE_BOTH_DIRECTORY_INFORMATION { </p>
<p>ULONG NextEntryOffset;</p>
<p>ULONG Unknown;</p>
<p>LARGE_INTEGER CreationTime;</p>
<p>LARGE_INTEGER LastAccessTime;</p>
<p>LARGE_INTEGER LastWriteTime;</p>
<p>LARGE_INTEGER ChangeTime;</p>
<p>LARGE_INTEGER EndOfFile;</p>
<p>LARGE_INTEGER AllocationSize;</p>
<p>ULONG FileAttributes;</p>
<p>ULONG FileNameLength;</p>
<p>ULONG EaInformationLength;</p>
<p>UCHAR AlternateNameLength;</p>
<p>WCHAR AlternateName[12];</p>
<p>WCHAR FileName[1];</p>
<p>} FILE_BOTH_DIRECTORY_INFORMATION, *PFILE_BOTH_DIRECTORY_INFORMATION; </p>

<p>и для FileNamesInformation:</p>

<p>typedef struct _FILE_NAMES_INFORMATION {</p>
<p>ULONG NextEntryOffset;</p>
<p>ULONG Unknown;</p>
<p>ULONG FileNameLength;</p>
<p>WCHAR FileName[1];</p>
<p>} FILE_NAMES_INFORMATION, *PFILE_NAMES_INFORMATION;</p>

<p>Функция записывает набор этих структур в буфер FileInformation.</p>
<p>Во всех этих типах структур для нас важны только три переменных.</p>
<p>NextEntryOffset - размер данного элемента списка. Первый элемент</p>
<p>расположен по адресу FileInformation + 0, а второй элемент по адресу</p>
<p>FileInformation + NextEntryOffset первого элемента. У последнего элемента</p>
<p>поле NextEntryOffset содержит нуль.</p>
<p>FileName - это полное имя файла.</p>
<p>FileNameLength - это длина имени файла.</p>

<p>Для скрытия файла, необходимо сравнить имя каждой возвращаемой записи</p>
<p>и имя файла, который мы хотим скрыть. Если мы хотим скрыть первую запись,</p>
<p>нужно сдвинуть следующие за ней структуры на размер первой записи. Это приведет</p>
<p>к тому, что первая запись будет затерта. Если мы хотим скрыть другую запись,</p>
<p>мы можем просто изменить значение NextEntryOffset предыдущей записи. Новое</p>
<p>значение NextEntryOffset будет нуль, если мы хотим скрыть последнюю запись,</p>
<p>иначе значение будет суммой полей NextEntryOffset записи, которую мы хотим</p>
<p>скрыть и предыдущей записи. Затем необходимо изменить значение поля Unknown</p>
<p>предыдущей записи, которое предоставляет индекс для последующего поиска.</p>
<p>Значение поля Unknown предыдущей записи должно равняться значению поля Unknown</p>
<p>записи, которую мы хотим скрыть.</p>
<p>Если нет ниодной записи, которую можно видеть, мы должны вернуть ошибку</p>
<p>STATUS_NO_SUCH_FILE.</p>

<p>#define STATUS_NO_SUCH_FILE 0xC000000F</p>

<p>NtVdmControl </p>

<p>По неизвестной причине эмуляция DOS - NTVDM может получить список</p>
<p>файлов еще и с помощью функции NtVdmControl.</p>

<p>NTSTATUS NtVdmControl( </p>
<p>IN ULONG ControlCode,</p>
<p>IN PVOID ControlData</p>
<p>);</p>

<p>ControlCode указывает подфункцию, которая будет применена к данным</p>
<p>в буфере ControlData. Если ControlCode равняется VdmDirectoryFile, эта</p>
<p>функция делает то же, что и NtQueryDirectoryFile с FileInformationClass</p>
<p>равным FileBothDirectoryInformation.</p>

<p>#define VdmDirectoryFile 6</p>

<p>Тогда буфер ControlData используется как FileInformation. Единственная</p>
<p>разница в том, что мы не знаем длину этого буфера. Поэтому мы должны вычислить</p>
<p>ее вручную. Мы можем сложить NextEntryOffset всех записей, FileNameLength</p>
<p>последней записи и 0x5E (длина последней записи исключая длину имени файла).</p>
<p>Методы скрытия такие же как и в случае с NtQueryDirectoryFile.</p>


<p>Процессы </p>

<p>Различная системная информация доступна через NtQuerySystemInformation.</p>

<p>NTSTATUS NtQuerySystemInformation(</p>
<p>IN SYSTEM_INFORMATION_CLASS SystemInformationClass,</p>
<p>IN OUT PVOID SystemInformation,</p>
<p>IN ULONG SystemInformationLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>SystemInformationClass указывает тип информации, которую мы хотим</p>
<p>получить, SystemInformation - это указатель на результирующий буфер,</p>
<p>SystemInformationLength - размер этого буфера и ReturnLength - количество</p>
<p>записанных байт.</p>
<p>Для перечисления запущенных процессов мы устанавливаем в параметр</p>
<p>SystemInformationClass значение SystemProcessesAndThreadsInformation.</p>

<p>#define SystemInformationClass 5</p>

<p>Возвращаемая структура в буфере SystemInformation:</p>

<p>typedef struct _SYSTEM_PROCESSES { </p>
<p>ULONG NextEntryDelta;</p>
<p>ULONG ThreadCount;</p>
<p>ULONG Reserved1[6];</p>
<p>LARGE_INTEGER CreateTime;</p>
<p>LARGE_INTEGER UserTime;</p>
<p>LARGE_INTEGER KernelTime;</p>
<p>UNICODE_STRING ProcessName; </p>
<p>KPRIORITY BasePriority;</p>
<p>ULONG ProcessId;</p>
<p>ULONG InheritedFromProcessId;</p>
<p>ULONG HandleCount;</p>
<p>ULONG Reserved2[2];</p>
<p>VM_COUNTERS VmCounters;</p>
<p>IO_COUNTERS IoCounters; // только Windows 2000</p>
<p>SYSTEM_THREADS Threads[1];</p>
<p>} SYSTEM_PROCESSES, *PSYSTEM_PROCESSES;</p>

<p>Скрытие процессов похоже на скрытие файлов. Мы должны изменить</p>
<p>NextEntryDelta записи предшествующей записи скрываемого процесса. Обычно</p>
<p>не требуется скрывать первую запись, т.к. это процесс Idle.</p>

<p>Реестр </p>

<p>Реестр Windows - это достаточно большая древовидная структура,</p>
<p>содержащая два важных типа записей, которые мы можем захотеть скрыть. Первый</p>
<p>тип - ключи реестра, второй - значения реестра. Благодаря структуре реестра</p>
<p>скрытие его ключей не так тривиально, как скрытие файлов или процессов.</p>

<p>NtEnumerateKey </p>

<p>Благодаря структуре реестра, мы не можем запросить список всех ключей</p>
<p>в какой-либо его части. Мы можем получить информацию только об одном ключе,</p>
<p>указанном его индексом. Используется функция NtEnumerateKey.</p>

<p>NTSTATUS NtEnumerateKey(</p>
<p>IN HANDLE KeyHandle,</p>
<p>IN ULONG Index,</p>
<p>IN KEY_INFORMATION_CLASS KeyInformationClass, </p>
<p>OUT PVOID KeyInformation,</p>
<p>IN ULONG KeyInformationLength,</p>
<p>OUT PULONG ResultLength</p>
<p>);</p>

<p>KeyHandle - это дескриптор ключа, в котором мы хотим получить</p>
<p>информацию о подключе, указанном параметром Index. Тип полученной информации</p>
<p>определяется полем KeyInformationClass. Данные записываются в буфер</p>
<p>KeyInformation, длина которого указана в параметре KeyInformationLength.</p>
<p>Количество записанных байт возвращается в ResultLength.</p>
<p>Наиболее важным является понимание того, что если мы скроем ключ, то</p>
<p>индексы всех последующих ключей будут сдвинуты. И так как нам придется получать</p>
<p>информацию о ключе с большим индексом запрашивая ключ с меньшим индексом, мы</p>
<p>должны подсчитать количество записей до скрытой и вернуть правильное значение.</p>
<p>Давайте разберем пример. Допустим в какой-то части реестра есть ключи с</p>
<p>именами A, B, C, D, E и F. Индекс начинается с нуля, это означает, что ключ E</p>
<p>имеет индекс 4. Теперь, если мы хотим скрыть ключ B и приложение вызвало</p>
<p>NtEnumerateKey с Index равным 4, мы должны вернуть информацию о ключе F, так</p>
<p>как индекс сдвинут. Проблема в том, что нам неизвестно, что нужно произвести</p>
<p>сдвиг. А если мы не позаботимся о сдвиге, то вернем E вместо F, когда будет</p>
<p>запрашиваться ключ с индексом 4, или ничего не вернем для ключа с индексом 1,</p>
<p>хотя должны вернуть C. В обоих случаях ошибка. Вот почему мы должны подумать</p>
<p>о сдвиге.</p>
<p>Если мы будем вычислять сдвиг вызовом функции для каждого индекса</p>
<p>от 0 до Index, иногда нам придется ждать годами (на 1ГГц процессоре это может</p>
<p>занять до 10 секунд со стандартным реестром, который очень большой). Поэтому</p>
<p>мы должны придумать более совершенный метод.</p>
<p>Мы знаем, что ключи (исключая ссылки) отсортированы по алфавиту. Если</p>
<p>мы пренебрежем ссылками (которые мы не хотим скрывать), мы сможем вычислить</p>
<p>сдвиг следующим методом. Мы отсортируем по алфавиту список имен ключей, которые</p>
<p>необходимо скрыть (используя RtlCompareUnicodeString), затем, когда приложение</p>
<p>вызывает NtEnumerateKey, мы не будем перевызывать ее с неизмененными</p>
<p>аргументами, а определим имя записи указанной параметром Index.</p>

<p>NTSTATUS RtlCompareUnicodeString( </p>
<p>IN PUNICODE_STRING String1, </p>
<p>IN PUNICODE_STRING String2, </p>
<p>IN BOOLEAN CaseInSensitive </p>
<p>);</p>

<p>String1 и String2 - строки, которые необходимо сравнить,</p>
<p>CaseInSensitive - True, если мы хотим провести сравнение, игнорируя регистр.</p>
<p>Результат функции описывает отношение между String1 и String2:</p>

<p>result &gt; 0: String1 &gt; String2</p>
<p>result = 0: String1 = String2</p>
<p>result &lt; 0: String1 &lt; String2</p>

<p>Теперь мы должны найти границу. Мы сравним имя, указанное параметром Index с</p>
<p>именами в нашем списке. Границей будет последнее меньшее имя из нашего списка.</p>
<p>Мы знаем, что сдвиг не превышает номер граничного элемента в нашем списке.</p>
<p>Но не все элементы списка являются действительными ключами в той части реестра,</p>
<p>где мы находимся. Поэтому мы должны определить элементы списка до границы,</p>
<p>которые являются частью реестра. Мы можем сделать это используя NtOpenKey.</p>

<p>NTSTATUS NtOpenKey(</p>
<p>OUT PHANDLE KeyHandle,</p>
<p>IN ACCESS_MASK DesiredAccess,</p>
<p>IN POBJECT_ATTRIBUTES ObjectAttributes</p>
<p>);</p>

<p>KeyHandle - это хэндл родительского ключа. Мы будем использовать</p>
<p>значение, переданное в NtEnumerateKey. DesiredAccess - права доступа,</p>
<p>используем значение KEY_ENUMERATE_SUB_KEYS. ObjectAttributes описывают</p>
<p>подключ, которых мы хотим открыть (включая его имя).</p>

<p>#define KEY_ENUMERATE_SUB_KEYS 8</p>

<p>Если NtOpenKey вернет 0 - ключ был открыт успешно - это значит, что</p>
<p>этот элемент списка существует. Открытый ключ следует закрыть, используя</p>
<p>NtClose.</p>

<p>NTSTATUS NtClose(</p>
<p>IN HANDLE Handle</p>
<p>);</p>

<p>При каждом вызове функции NtEnumerateKey мы должны вычислять сдвиг,</p>
<p>как количество ключей из нашего списка, которые существуют в данной части</p>
<p>реестра. Затем мы должны прибавить этот сдвиг к аргументу Index и, наконец,</p>
<p>вызвать оригинальную NtEnumerateKey.</p>
<p>Для получения имени ключа, указанного параметром Index, мы используем</p>
<p>KeyBasicInformation в качестве значения для KeyInformationClass.</p>

<p>#define KeyBasicInformation 0</p>

<p>NtEnumerateKey вернет в буфере KeyInformation структуру:</p>

<p>typedef struct _KEY_BASIC_INFORMATION {</p>
<p>LARGE_INTEGER LastWriteTime;</p>
<p>ULONG TitleIndex;</p>
<p>ULONG NameLength;</p>
<p>WCHAR Name[1]; </p>
<p>} KEY_BASIC_INFORMATION, *PKEY_BASIC_INFORMATION;</p>

<p>Единственное что нам нужно - это Name, и его длина - NameLength.</p>
<p>Если ключа для сдвинутого параметра Index не существует, мы</p>
<p>должны вернуть ошибку STATUS_EA_LIST_INCONSISTENT.</p>

<p>#define STATUS_EA_LIST_INCONSISTENT 0x80000014</p>

<p>NtEnumerateValueKey </p>

<p>Значения реестра не отсортированы. К счастью, их количество в одном</p>
<p>ключе достаточно мало, поэтому мы можем перевызывать функцию, чтобы получить</p>
<p>сдвиг. API для получения информации об одном значении реестра</p>
<p>назывется NtEnumarateValueKey.</p>

<p>NTSTATUS NtEnumerateValueKey(</p>
<p>IN HANDLE KeyHandle,</p>
<p>IN ULONG Index,</p>
<p>IN KEY_VALUE_INFORMATION_CLASS KeyValueInformationClass,</p>
<p>OUT PVOID KeyValueInformation,</p>
<p>IN ULONG KeyValueInformationLength,</p>
<p>OUT PULONG ResultLength</p>
<p>);</p>

<p>KeyHandle - это снова хэндл родительского ключа. Index - это индекс</p>
<p>в списке значений данного ключа. KeyValueInformationClass описывает тип</p>
<p>информации, которая будет помещена в буфер KeyValueInformation размером</p>
<p>KeyValueInformationLength байт. Количество записанных в буфер байт возвращается</p>
<p>в ResultLength.</p>
<p>И снова мы должны вычислить сдвиг, перевызывая функцию для всех</p>
<p>индексов от 0 до Index. Имя значения может быть получено при использовании</p>
<p>KeyValueBasicInformation в качестве значения для KeyValueInformationClass.</p>

<p>#define KeyValueBasicInformation 0</p>

<p>Тогда в буфере KeyValueInformation мы получим следующую структуру:</p>

<p>typedef struct _KEY_VALUE_BASIC_INFORMATION {</p>
<p>ULONG TitleIndex;</p>
<p>ULONG Type;</p>
<p>ULONG NameLength;</p>
<p>WCHAR Name[1];</p>
<p>} KEY_VALUE_BASIC_INFORMATION, *PKEY_VALUE_BASIC_INFORMATION;</p>

<p>Нас снова интересуют только Name и NameLength.</p>

<p>Если для сдвинутого параметра Index не существует соответствующего</p>
<p>значения реестра, то мы должны вернуть STATUS_NO_MORE_ENTRIES.</p>

<p>#define STATUS_NO_MORE_ENTRIES 0x8000001A</p>


<p>Сервисы и драйверы </p>

<p>Системные сервисы и драйверы обрабатываются четырьмя независимыми</p>
<p>API-функциями. Их связи различны в каждой версии Windows. Поэтому мы вынуждены</p>
<p>перехватывать все четыре функции.</p>

<p>BOOL EnumServicesStatusA(</p>
<p>SC_HANDLE hSCManager,</p>
<p>DWORD dwServiceType,</p>
<p>DWORD dwServiceState,</p>
<p>LPENUM_SERVICE_STATUS lpServices,</p>
<p>DWORD cbBufSize,</p>
<p>LPDWORD pcbBytesNeeded,</p>
<p>LPDWORD lpServicesReturned,</p>
<p>LPDWORD lpResumeHandle</p>
<p>);</p>

<p>BOOL EnumServiceGroupW(</p>
<p>SC_HANDLE hSCManager,</p>
<p>DWORD dwServiceType,</p>
<p>DWORD dwServiceState,</p>
<p>LPBYTE lpServices,</p>
<p>DWORD cbBufSize,</p>
<p>LPDWORD pcbBytesNeeded,</p>
<p>LPDWORD lpServicesReturned,</p>
<p>LPDWORD lpResumeHandle,</p>
<p>DWORD dwUnknown</p>
<p>);</p>

<p>BOOL EnumServicesStatusExA(</p>
<p>SC_HANDLE hSCManager,</p>
<p>SC_ENUM_TYPE InfoLevel,</p>
<p>DWORD dwServiceType,</p>
<p>DWORD dwServiceState,</p>
<p>LPBYTE lpServices,</p>
<p>DWORD cbBufSize,</p>
<p>LPDWORD pcbBytesNeeded,</p>
<p>LPDWORD lpServicesReturned,</p>
<p>LPDWORD lpResumeHandle,</p>
<p>LPCTSTR pszGroupName</p>
<p>);</p>

<p>BOOL EnumServicesStatusExW(</p>
<p>SC_HANDLE hSCManager,</p>
<p>SC_ENUM_TYPE InfoLevel,</p>
<p>DWORD dwServiceType,</p>
<p>DWORD dwServiceState,</p>
<p>LPBYTE lpServices,</p>
<p>DWORD cbBufSize,</p>
<p>LPDWORD pcbBytesNeeded,</p>
<p>LPDWORD lpServicesReturned,</p>
<p>LPDWORD lpResumeHandle,</p>
<p>LPCTSTR pszGroupName</p>
<p>);</p>

<p>Наиболее важен здесь параметр lpServices, которое указывает на буфер,</p>
<p>где должен быть размещен список сервисов. lpServicesReturned, которое указывает</p>
<p>на количество записей в буфере, также важно. Структура данных в выходном буфере</p>
<p>зависит от типа функции. Для функций EnumServicesStatusA и EnumServicesGroupW</p>
<p>возвращается структура:</p>

<p>typedef struct _ENUM_SERVICE_STATUS {</p>
<p>LPTSTR lpServiceName;</p>
<p>LPTSTR lpDisplayName;</p>
<p>SERVICE_STATUS ServiceStatus;</p>
<p>} ENUM_SERVICE_STATUS, *LPENUM_SERVICE_STATUS;</p>

<p>typedef struct _SERVICE_STATUS {</p>
<p>DWORD dwServiceType;</p>
<p>DWORD dwCurrentState;</p>
<p>DWORD dwControlsAccepted;</p>
<p>DWORD dwWin32ExitCode;</p>
<p>DWORD dwServiceSpecificExitCode;</p>
<p>DWORD dwCheckPoint;</p>
<p>DWORD dwWaitHint;</p>
<p>} SERVICE_STATUS, *LPSERVICE_STATUS;</p>

<p>а для EnumServicesStatusExA и EnumServicesStatusExW: </p>

<p>typedef struct _ENUM_SERVICE_STATUS_PROCESS {</p>
<p>LPTSTR lpServiceName;</p>
<p>LPTSTR lpDisplayName;</p>
<p>SERVICE_STATUS_PROCESS ServiceStatusProcess;</p>
<p>} ENUM_SERVICE_STATUS_PROCESS, *LPENUM_SERVICE_STATUS_PROCESS;</p>

<p>typedef struct _SERVICE_STATUS_PROCESS {</p>
<p>DWORD dwServiceType;</p>
<p>DWORD dwCurrentState;</p>
<p>DWORD dwControlsAccepted;</p>
<p>DWORD dwWin32ExitCode;</p>
<p>DWORD dwServiceSpecificExitCode;</p>
<p>DWORD dwCheckPoint;</p>
<p>DWORD dwWaitHint;</p>
<p>DWORD dwProcessId;</p>
<p>DWORD dwServiceFlags;</p>
<p>} SERVICE_STATUS_PROCESS, *LPSERVICE_STATUS_PROCESS;</p>

<p>Нас интересует только поле lpServiceName, которое содержит имя</p>
<p>сервиса. Записи имеют фиксированный размер, поэтому, если мы хотим скрыть</p>
<p>одну, мы передвинем все последующие записи на ее размер. Здесь мы должны</p>
<p>помнить о различии размеров SERVICE_STATUS и SERVICE_STATUS_PROCESS.</p>


<p>Перехват и распространение </p>

<p>Чтобы получить желаемый эффект, мы должны заразить все запущенные</p>
<p>процессы, а также процессы, которые будут запущены позже. Новые процессы должны</p>
<p>быть заражены до выполнения первой инструкции их кода, иначе они смогут увидеть</p>
<p>наши скрытые объекты до того, как функции будут перехвачены.</p>

<p>Привелегии </p>

<p>Нам нужны как минимум администраторские права, чтобы получить доступ ко</p>
<p>всем запущенным процессам. Лучшая возможность - это запуск нашего процесса как</p>
<p>системного сервиса, который работает с правами пользователя SYSTEM. Чтобы</p>
<p>установить сервис нам тоже нужны специальные привелегии.</p>
<p>Также очень полезно получение привелегии SeDebugPrivilege. Это может</p>
<p>быть сделано с помощью функций OpenProcessToken, LookupPrivilegeValue и</p>
<p>AdjustTokenPrivileges.</p>

<p>BOOL OpenProcessToken(</p>
<p>HANDLE ProcessHandle,</p>
<p>DWORD DesiredAccess,</p>
<p>PHANDLE TokenHandle</p>
<p>);</p>

<p>BOOL LookupPrivilegeValue(</p>
<p>LPCTSTR lpSystemName,</p>
<p>LPCTSTR lpName,</p>
<p>PLUID lpLuid</p>
<p>);</p>

<p>BOOL AdjustTokenPrivileges(</p>
<p>HANDLE TokenHandle,</p>
<p>BOOL DisableAllPrivileges,</p>
<p>PTOKEN_PRIVILEGES NewState,</p>
<p>DWORD BufferLength,</p>
<p>PTOKEN_PRIVILEGES PreviousState,</p>
<p>PDWORD ReturnLength</p>
<p>);</p>

<p>Игнорируя возможные ошибки, это может быть сделано так:</p>

<p>#define SE_PRIVILEGE_ENABLED 0x0002</p>
<p>#define TOKEN_QUERY 0x0008</p>
<p>#define TOKEN_ADJUST_PRIVILEGES 0x0020</p>

<p>HANDLE hToken;</p>
<p>LUID DebugNameValue;</p>
<p>TOKEN_PRIVILEGES Privileges;</p>
<p>DWORD dwRet;</p>

<p>OpenProcessToken(GetCurrentProcess(),</p>
<p>TOKEN_ADJUST_PRIVILEGES | TOKEN_QUERY,hToken);</p>
<p>LookupPrivilegeValue(NULL,"SeDebugPrivilege",&amp;DebugNameValue);</p>
<p>Privileges.PrivilegeCount=1;</p>
<p>Privileges.Privileges[0].Luid=DebugNameValue;</p>
<p>Privileges.Privileges[0].Attributes=SE_PRIVILEGE_ENABLED;</p>
<p>AdjustTokenPrivileges(hToken,FALSE,&amp;Privileges,sizeof(Privileges),</p>
<p>NULL,&amp;dwRet);</p>
<p>CloseHandle(hToken);</p>

<p>Перехват </p>

<p>Перечисление процессов производится уже упомянутой API-функцией</p>
<p>NtQuerySystemInformation. Для перехвата функций используется метод перезаписи</p>
<p>ее первых инструкций. Это делается для каждого запущеного процесса. Мы выделим</p>
<p>память в нужном процессе, где запишем новый код для функций, которые хотим</p>
<p>перехватить. Затем заменим первые пять байт этих функций на инструкцию jmp.</p>
<p>Эта инструкция будет перенаправлять выполнение на наш код. Так, инструкция jmp</p>
<p>будет выполнена сразу, как только функция будет вызвана. Мы должны сохранить</p>
<p>первые инструкции каждой перезаписанной функции - они необходимы для вызова</p>
<p>оригинального кода перехваченной функции. Сохранение инструкций описывается в</p>
<p>разделе 3.2.3 статьи "Hooking Windows API".</p>
<p>Сначала мы должны открыть нужный процесс с помощью NtOpenProcess и</p>
<p>получить его хэндл. Произойдет ошибка, если у нас недостаточно привелегий.</p>

<p>NTSTATUS NtOpenProcess(</p>
<p>OUT PHANDLE ProcessHandle,</p>
<p>IN ACCESS_MASK DesiredAccess,</p>
<p>IN POBJECT_ATTRIBUTES ObjectAttributes,</p>
<p>IN PCLIENT_ID ClientId OPTIONAL</p>
<p>);</p>

<p>ProcessHandle - указатель на хэндл, где будет сохранен результат.</p>
<p>DesiredAccess следует установить равным PROCESS_ALL_ACCESS. Мы установим</p>
<p>поле UniqueProcess структуры ClientId равным PID нужного процесса, UniqueThread</p>
<p>должно быть равно нулю. Открытый хэндл должен быть закрыт с помощью NtClose.</p>

<p>#define PROCESS_ALL_ACCESS 0x001F0FFF</p>

<p>Теперь мы выделим память для нашего кода. Это может быть сделано</p>
<p>с помощью функции NtAllocateVirtualMemory.</p>

<p>NTSTATUS NtAllocateVirtualMemory(</p>
<p>IN HANDLE ProcessHandle,</p>
<p>IN OUT PVOID BaseAddress,</p>
<p>IN ULONG ZeroBits,</p>
<p>IN OUT PULONG AllocationSize,</p>
<p>IN ULONG AllocationType,</p>
<p>IN ULONG Protect</p>
<p>);</p>

<p>Используется значение ProcessHandle возвращенное функцией</p>
<p>NtOpenProcess. BaseAddress - указатель на указатель на желаемое начало блока</p>
<p>выделенной памяти. Здесь будет сохранен указатель на выделенную память.</p>
<p>Входное значение может быть равно NULL. AllocationSize - указатель на</p>
<p>переменную, содержащую размер буфера, который мы хотим выделить. И также</p>
<p>здесь будет сохранено количество реально выделенных байт. Рекомендую включить</p>
<p>значение MEM_TOP_DOWN в параметр AllocationType в дополнение к MEM_COMMIT, т.к.</p>
<p>в этом случае память будет выделена как можно выше рядом с DLL.</p>

<p>#define MEM_COMMIT 0x00001000</p>
<p>#define MEM_TOP_DOWN 0x00100000 </p>

<p>Теперь мы можем записать наш код, используя NtWriteVirtualMemory.</p>

<p>NTSTATUS NtWriteVirtualMemory(</p>
<p>IN HANDLE ProcessHandle,</p>
<p>IN PVOID BaseAddress,</p>
<p>IN PVOID Buffer,</p>
<p>IN ULONG BufferLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>В параметре BaseAddress используем значение возвращенное</p>
<p>NtAllocateVirtual. Buffer указывает на байты, которые мы хотим записать,</p>
<p>BufferLength - количество этих байтов.</p>

<p>Теперь мы перехватим функции. Единственная DLL, которая загружается в</p>
<p>каждый процесс - ntdll.dll. Так, мы должны проверить импортирована ли функция,</p>
<p>которую мы хотим перехватить, в процесс, если эта функция не из ntdll.dll.</p>
<p>Но память, которую эта функция (из другой DLL) могла бы занимать может быть</p>
<p>выделена, и перезапись этих байт повлечет за собой сбой в процессе. Поэтому</p>
<p>мы должны проверить загружена ли эта библиотека (в которой нужная нам функция)</p>
<p>в процесс.</p>
<p>Мы должны получить PEB (Process Environment Block) нужного процесса,</p>
<p>используя NtQueryInformationProcess.</p>

<p>NTSTATUS NtQueryInformationProcess(</p>
<p>IN HANDLE ProcessHandle,</p>
<p>IN PROCESSINFOCLASS ProcessInformationClass,</p>
<p>OUT PVOID ProcessInformation,</p>
<p>IN ULONG ProcessInformationLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>Присвоим значение ProcessBasicInformation параметру</p>
<p>ProcessInformationClass. Тогда в буфер ProcessInformation, размер которого</p>
<p>указан в параметре ProcessInformationLength, будет возвращена структура</p>
<p>PROCESS_BASIC_INFORMATION.</p>

<p>#define ProcessBasicInformation 0</p>

<p>typedef struct _PROCESS_BASIC_INFORMATION {</p>
<p>NTSTATUS ExitStatus;</p>
<p>PPEB PebBaseAddress;</p>
<p>KAFFINITY AffinityMask;</p>
<p>KPRIORITY BasePriority;</p>
<p>ULONG UniqueProcessId;</p>
<p>ULONG InheritedFromUniqueProcessId;</p>
<p>} PROCESS_BASIC_INFORMATION, *PPROCESS_BASIC_INFORMATION;</p>

<p>PebBaseAddress - то, что мы ищем. PebBaseAddress+0x0C - это адрес</p>
<p>PPEB_LDR_DATA. Он может быть получен вызовом NtReadVirtualMemory.</p>

<p>NTSTATUS NtReadVirtualMemory(</p>
<p>IN HANDLE ProcessHandle,</p>
<p>IN PVOID BaseAddress,</p>
<p>OUT PVOID Buffer,</p>
<p>IN ULONG BufferLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>Параметры такие же как и у NtWriteVirtualMemory.</p>
<p>PPEB_LDR_DATA+0x1C - адрес InInitializationOrderModuleList. Это список</p>
<p>библиотек, загруженных в процесс. Нас интересует только часть этой структуры.</p>

<p>typedef struct _IN_INITIALIZATION_ORDER_MODULE_LIST {</p>
<p>PVOID Next,</p>
<p>PVOID Prev,</p>
<p>DWORD ImageBase,</p>
<p>DWORD ImageEntry,</p>
<p>DWORD ImageSize,</p>
<p>...</p>
<p>);</p>

<p>Next - указатель на следующую запись, Prev - на предыдущую. Последняя</p>
<p>запись указывает на первую. ImageBase - адрес модуля в памяти. ImageEntry - это</p>
<p>точка входа модуля, ImageSize - его размер.</p>

<p>Для каждой библиотеки, функции которой мы хотим перехватить, мы получим</p>
<p>ImageBase (например, используя GetModuleHandle или LoadLibrary). Эту ImageBase</p>
<p>мы сравним с ImageBase каждого элемента в InInitializationOrderModuleList.</p>
<p>Теперь мы готовы к перехвату. Из-за того, что мы перехватываем функции</p>
<p>в работающих процессах, существует вероятность, что код, который мы будем</p>
<p>перезаписывать в тот момент будет выполняться. Это может вызвать ошибку,</p>
<p>поэтому сначала мы остановим все потоки этого процесса. Список потоков можно</p>
<p>получить, используя функцию NtQuerySystemInformation с классом</p>
<p>SystemProcessesAndThreadsInformation. Результат работы этой функции описан в</p>
<p>разделе 4, необходимо лишь добавить описание структуры SYSTEM_THREADS, которая</p>
<p>содержит информацию о потоке.</p>

<p>typedef struct _SYSTEM_THREADS {</p>
<p>LARGE_INTEGER KernelTime;</p>
<p>LARGE_INTEGER UserTime;</p>
<p>LARGE_INTEGER CreateTime;</p>
<p>ULONG WaitTime;</p>
<p>PVOID StartAddress;</p>
<p>CLIENT_ID ClientId;</p>
<p>KPRIORITY Priority;</p>
<p>KPRIORITY BasePriority;</p>
<p>ULONG ContextSwitchCount;</p>
<p>THREAD_STATE State;</p>
<p>KWAIT_REASON WaitReason;</p>
<p>} SYSTEM_THREADS, *PSYSTEM_THREADS; </p>

<p>Для каждого потока мы должны получить его хэндл, используя</p>
<p>NtOpenThread. Мы используем для этого ClientId.</p>

<p>NTSTATUS NtOpenThread(</p>
<p>OUT PHANDLE ThreadHandle,</p>
<p>IN ACCESS_MASK DesiredAccess,</p>
<p>IN POBJECT_ATTRIBUTES ObjectAttributes,</p>
<p>IN PCLIENT_ID ClientId</p>
<p>);</p>

<p>Хэндл, который нам нужен, будет сохранен в ThreadHandle. Параметр</p>
<p>DesiredAccess должен быть равен THREAD_SUSPEND_RESUME.</p>

<p>#define THREAD_SUSPEND_RESUME 2</p>

<p>ThreadHandle будет использован при вызове NtSuspendThread.</p>

<p>NTSTATUS NtSuspendThread(</p>
<p>IN HANDLE ThreadHandle,</p>
<p>OUT PULONG PreviousSuspendCount OPTIONAL</p>
<p>);</p>

<p>Приостановленный процесс готов к перезаписи. Мы поступим, как описано</p>
<p>в разделе 3.2.2 статьи "Hooking Windows API". Единственная разница в том, что</p>
<p>функции будут использоваться для других процессов.</p>

<p>После перехвата мы возобновим работу всех потоков процесса, используя</p>
<p>NtResumeThread.</p>

<p>NTSTATUS NtResumeThread(</p>
<p>IN HANDLE ThreadHandle,</p>
<p>OUT PULONG PreviousSuspendCount OPTIONAL</p>
<p>);</p>

<p>Новые процессы </p>

<p>Заражение всех запущенных процессов не затронет процессы, которые будут</p>
<p>запущены позже. Мы должны получить список процессов, через некоторое время</p>
<p>получить новый, сравнить их, а затем заразить те процессы, которые есть во</p>
<p>втором списке и отсутствуют в первом. Но этот метод очень ненадежен.</p>
<p>Намного лучше перехватить функцию, которая вызывается, когда стартует</p>
<p>новый процесс. Так как все запущенные в системе процессы заражены, мы не сможем</p>
<p>пропустить ни один новый процесс, используя данный метод. Мы можем перехватить</p>
<p>NtCreateThread, но это не самый простой путь. Мы будем перехватывать функцию</p>
<p>NtResumeThread, которая также всегда вызывается при старте нового процесса.</p>
<p>Она вызвается после NtCreateThread.</p>
<p>Единственная проблема с NtResumeThread состоит в том, что она</p>
<p>вызывается не только при запуске нового процесса. Но мы легко решим эту</p>
<p>проблему. NtQueryInformationThread предоставит нам информацию о том, какой</p>
<p>процесс владеет данным потоком. Мы должны просто проверить, заражен ли этот</p>
<p>процесс. Это можно определить прочитав первые байты любой из функций, которые</p>
<p>мы перехватываем.</p>

<p>NTSTATUS NtQueryInformationThread(</p>
<p>IN HANDLE ThreadHandle,</p>
<p>IN THREADINFOCLASS ThreadInformationClass,</p>
<p>OUT PVOID ThreadInformation,</p>
<p>IN ULONG ThreadInformationLength, </p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>В нашем случае параметр ThreadInformationClass должен быть равен</p>
<p>ThreadBasicInformation. ThreadInformation - это буфер для результата, размер</p>
<p>этого буфера указан в параметре ThreadInformationLength.</p>

<p>#define ThreadBasicInformation 0</p>

<p>Для класса ThreadBasicInformation возвращается такая структура:</p>

<p>typedef struct _THREAD_BASIC_INFORMATION {</p>
<p>NTSTATUS ExitStatus;</p>
<p>PNT_TIB TebBaseAddress;</p>
<p>CLIENT_ID ClientId;</p>
<p>KAFFINITY AffinityMask;</p>
<p>KPRIORITY Priority;</p>
<p>KPRIORITY BasePriority;</p>
<p>} THREAD_BASIC_INFORMATION, *PTHREAD_BASIC_INFORMATION;</p>

<p>В параметре ClientId находится PID процесса, владеющего этим потоком.</p>

<p>Теперь мы должны заразить новый процесс. Проблема в том, что процесс</p>
<p>имеет в своей памяти только ntdll.dll. Все остальные модули загружаются сразу</p>
<p>после вызова NtResumeThread. Существует несколько путей решения этой проблемы.</p>
<p>Например, можно перехватить функцию LdrInitializeThunk, которая вызывается при</p>
<p>инициализации процесса.</p>

<p>NTSTATUS LdrInitializeThunk(</p>
<p>DWORD Unknown1,</p>
<p>DWORD Unknown2,</p>
<p>DWORD Unknown3</p>
<p>);</p>

<p>Сначала нужно выполнить оригинальный код, а замет перехватить все</p>
<p>нужные функции в новом процессе. Затем лучше снять перехват LdrInitializeThunk,</p>
<p>так как она будет вызвана позже много раз, а мы не хватим заново перехватывать</p>
<p>все функции. Все это будет сделано до выполнения первых инструкций процесса,</p>
<p>поэтому нет вероятности того, что этот процесс вызовет какую-нибудь из</p>
<p>перехватываемых функций до того, как мы ее перехватим.</p>
<p>Перехват функций в своем процессе такой же как и перехват в запущенном</p>
<p>процессе, но нам не нужно беспокоиться о потоках.</p>

<p>DLL </p>

<p>В каждом процессе в системе есть копия ntdll.dll. Это значит, что мы</p>
<p>можем перехватить любую функцию этого модуля при инициализации процесса.</p>
<p>Но как быть с функциями из других модулей, например, kernel32.dll или</p>
<p>advapi32.dll? Есть несколько процессов, у которых есть только ntdll.dll.</p>
<p>Все остальные модули могут быть загружены динамически в середине кода после</p>
<p>перехвата процесса. Вот почему мы должны перехватить LdrLoadDll, которая</p>
<p>загружает новые модули.</p>

<p>NTSTATUS LdrLoadDll( </p>
<p>PWSTR szcwPath,</p>
<p>PDWORD pdwLdrErr, </p>
<p>PUNICODE_STRING pUniModuleName,</p>
<p>PHINSTANCE pResultInstance</p>
<p>);</p>

<p>Наиболее важно для нас pUniModuleName - имя модуля. pResultInstance</p>
<p>будет адресом модуля, если вызов был успешен.</p>
<p>Мы вызовем оригинальную LdrLoadDll и затем перехватим все функции в</p>
<p>загруженном модуле.</p>


<p>Память </p>

<p>Когда мы перехватываем функцию, мы изменяем ее первые байты. Вызвав</p>
<p>NtReadVirtualMemory, кто угодно сможет определить, что функция перехвачена.</p>
<p>Поэтому мы должны перехватить NtReadVirtualMemory, чтобы избежать обнаружения.</p>

<p>NTSTATUS NtReadVirtualMemory(</p>
<p>IN HANDLE ProcessHandle,</p>
<p>IN PVOID BaseAddress,</p>
<p>OUT PVOID Buffer,</p>
<p>IN ULONG BufferLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>Мы заменили байты в начале тех функций, которые перехватили, и еще</p>
<p>выделили память для нового кода. Необходимо проверить читает ли функция</p>
<p>какие-либо из этих байт. Если наши байты находятся в диапазоне от BaseAddress</p>
<p>до (BaseAddress + BufferLength), мы должны заменить некоторые байты в Buffer.</p>
<p>Если кто-либо пытается прочитать байты из нашей выделенной памяти,</p>
<p>следует вернуть пустой Buffer и ошибку STATUS_PARTIAL_COPY. Это значение</p>
<p>говорит о том, что не все запрошенные байты были скопированы в буфер Buffer.</p>
<p>Это также происходит при попытке доступа к невыделенной памяти. ReturnLength</p>
<p>должно быть установлено в нуль в данном случае.</p>

<p>#define STATUS_PARTIAL_COPY 0x8000000D</p>

<p>Если кто-нибудь запрашивает первые байты перехваченной нами функции,</p>
<p>мы должны вызвать оригинальный код, а затем скопировать оригинальные байты</p>
<p>(мы их сохранили) в буфер Buffer.</p>
<p>Теперь процесс не сможет определить, что функции перехвачены, чтением</p>
<p>памяти. Также, если вы отлаживаете перехватываченные функции, у отладчика будут</p>
<p>проблемы. Он будет показывать оригинальные байты, но выполнять наш код.</p>

<p>Чтобы сделать скрытие совершенным, мы еще должны перехватить функцию</p>
<p>NtQueryVirtualMemory, которая используется для получения информации о</p>
<p>виртуальной памяти. Мы можем перехватить ее, чтобы предотвратить обнаружение</p>
<p>выделенной нами памяти.</p>

<p>NTSTATUS NtQueryVirtualMemory(</p>
<p>IN HANDLE ProcessHandle,</p>
<p>IN PVOID BaseAddress,</p>
<p>IN MEMORY_INFORMATION_CLASS MemoryInformationClass,</p>
<p>OUT PVOID MemoryInformation,</p>
<p>IN ULONG MemoryInformationLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>MemoryInformationClass определяет тип возвращаемых данных. Нас</p>
<p>интересуют первые два типа.</p>

<p>#define MemoryBasicInformation 0</p>
<p>#define MemoryWorkingSetList 1</p>

<p>Для MemoryBasicInformation возвращается структура:</p>

<p>typedef struct _MEMORY_BASIC_INFORMATION {</p>
<p>PVOID BaseAddress;</p>
<p>PVOID AllocationBase;</p>
<p>ULONG AllocationProtect;</p>
<p>ULONG RegionSize;</p>
<p>ULONG State;</p>
<p>ULONG Protect;</p>
<p>ULONG Type;</p>
<p>} MEMORY_BASIC_INFORMATION, *PMEMORY_BASIC_INFORMATION;</p>

<p>Каждая секция памяти имеет размер - RegionSize и тип - Type. Свободная</p>
<p>память имеет тип MEM_FREE.</p>

<p>#define MEM_FREE 0x10000</p>

<p>Если секция перед нашей имеет тип MEM_FREE, следует прибавить размер</p>
<p>нашей секции к ее RegionSize. Если следующая секция также имеет тип MEM_FREE,</p>
<p>следует прибавить размер следующей секции к RegionSize.</p>
<p>Если секция перед нашей имеет другой тип, мы вернем MEM_FREE для нашей</p>
<p>секции. Ее размер должен быть вычислен, учитывая также следующую секцию.</p>

<p>Для MemoryWorkingSetList возвращается структура:</p>

<p>typedef struct _MEMORY_WORKING_SET_LIST { </p>
<p>ULONG NumberOfPages;</p>
<p>ULONG WorkingSetList[1];</p>
<p>} MEMORY_WORKING_SET_LIST, *PMEMORY_WORKING_SET_LIST;</p>

<p>NumberOfPages - количество элементов в WorkingSetList. Это число должно</p>
<p>быть уменьшено. Мы должны найти нашу секцию в WorkingSetList и передвинуть</p>
<p>следующие записи на нее. WorkingSetList - массив DWORD'ов, где старшие 20 бит -</p>
<p>это старшие 20 бит адреса секции, а младшие 12 бит содержат флаги.</p>


<p>Хэндлы </p>

<p>Вызов NtQuerySystemInformation с классом SystemHandleInformation дает</p>
<p>нам массив всех открытых хэндлов в структуре _SYSTEM_HANDLE_INFORMATION_EX.</p>

<p>#define SystemHandleInformation 0x10</p>

<p>typedef struct _SYSTEM_HANDLE_INFORMATION {</p>
<p>ULONG ProcessId;</p>
<p>UCHAR ObjectTypeNumber;</p>
<p>UCHAR Flags;</p>
<p>USHORT Handle;</p>
<p>PVOID Object;</p>
<p>ACCESS_MASK GrantedAccess;</p>
<p>} SYSTEM_HANDLE_INFORMATION, *PSYSTEM_HANDLE_INFORMATION;</p>

<p>typedef struct _SYSTEM_HANDLE_INFORMATION_EX {</p>
<p>ULONG NumberOfHandles;</p>
<p>SYSTEM_HANDLE_INFORMATION Information[1];</p>
<p>} SYSTEM_HANDLE_INFORMATION_EX, *PSYSTEM_HANDLE_INFORMATION_EX;</p>

<p>ProcessId указывает процесс, владеющий этим хэндлом. ObjectTypeNumber -</p>
<p>это тип хэндла. NumberOfHandles - количество записей в массиве Information.</p>
<p>Скрытие одного элемента тривиально. Нужно сдвинуть последующие записи на одну</p>
<p>и уменьшить значение NumberOfHandles. Сдвиг последующих записей требуется,</p>
<p>потому что хэндлы в массиве сгруппированы по ProcessId. Это значит, что все</p>
<p>хэндлы одного процесса расположены последовательно. И для каждого процесса</p>
<p>значение поля Handle растет.</p>
<p>Вспомните структуру _SYSTEM_PROCESSES, которая возвращается этой</p>
<p>функцией с классом SystemProcessesAndThreadsInformation. Здесь мы можем</p>
<p>увидеть, что каждый процесс имеет информацию о количестве хэндлов в</p>
<p>HandleCount. Если мы хотим сделать все идеально, нам следует изменить поле</p>
<p>HandleCount (в соответствии с тем, сколько хэндлов мы скрыли), когда функция</p>
<p>будет вызвана с классом SystemProcessesAndThreadsInformation. Но эта поправка</p>
<p>может требовать слишком много времени. Множество хэндлов открываются и</p>
<p>закрываются в течении очень короткого времени при нормальной работе системы.</p>
<p>Легко может случиться, что количество хэндлов изменилось между двумя вызовами</p>
<p>функции, поэтому нам не нужно изменять здесь поле HandleCount.</p>

<p>Именование хэндлов и получение типа</p>

<p>Скрытие хэндлов тривиально, но немного сложнее определить какие хэндлы</p>
<p>мы должны скрыть. Если у нас есть, например, скрытый процесс, нас следует</p>
<p>скрыть все его хэндлы и все хэндлы связанные с ним. Скрытие хэндлов этого</p>
<p>процесса также тривиально. Мы просто сравниваем ProcessId хэндла и PID нашего</p>
<p>процесса, если они равны мы прячем хэндл. Но хэндлы других процессов должны</p>
<p>быть проименованы прежде, чем мы сможем сравнивать их с чем-либо. Количество</p>
<p>хэндлов в системе обычно очень велико, поэтому лучшее, что мы можем сделать -</p>
<p>это сравнить тип хэндла прежде, чем попытаться проименовать его. Именование</p>
<p>типов сохранит много времени для хэндлов, которые нас не интересуют.</p>
<p>Именование хэндла и типа хэндла может быть выполнено с помощью функции</p>
<p>NtQueryObject.</p>

<p>NTSTATUS ZwQueryObject(</p>
<p>IN HANDLE ObjectHandle,</p>
<p>IN OBJECT_INFORMATION_CLASS ObjectInformationClass,</p>
<p>OUT PVOID ObjectInformation,</p>
<p>IN ULONG ObjectInformationLength,</p>
<p>OUT PULONG ReturnLength OPTIONAL</p>
<p>);</p>

<p>ObjectHandle - хэндл, информацию о котором мы хотим получить,</p>
<p>ObjectInformationClass - тип информации, которая будет сохранена в буфер</p>
<p>ObjectInformation размером ObjectInformationLength байт.</p>
<p>Мы будем использовать классы ObjectNameInformation и</p>
<p>ObjectAllTypesInformation. Класс ObjectNameInfromation заполнит буфер</p>
<p>структурой OBJECT_NAME_INFORMATION, а класс ObjectAllTypesInformation</p>
<p>структурой OBJECT_ALL_TYPES_INFORMATION.</p>

<p>#define ObjectNameInformation 1</p>
<p>#define ObjectAllTypesInformation 3</p>

<p>typedef struct _OBJECT_NAME_INFORMATION {</p>
<p>UNICODE_STRING Name;</p>
<p>} OBJECT_NAME_INFORMATION, *POBJECT_NAME_INFORMATION;</p>

<p>Поле Name определяет имя хэндла.</p>

<p>typedef struct _OBJECT_TYPE_INFORMATION {</p>
<p>UNICODE_STRING Name;</p>
<p>ULONG ObjectCount;</p>
<p>ULONG HandleCount;</p>
<p>ULONG Reserved1[4];</p>
<p>ULONG PeakObjectCount;</p>
<p>ULONG PeakHandleCount;</p>
<p>ULONG Reserved2[4];</p>
<p>ULONG InvalidAttributes;</p>
<p>GENERIC_MAPPING GenericMapping;</p>
<p>ULONG ValidAccess;</p>
<p>UCHAR Unknown;</p>
<p>BOOLEAN MaintainHandleDatabase;</p>
<p>POOL_TYPE PoolType;</p>
<p>ULONG PagedPoolUsage;</p>
<p>ULONG NonPagedPoolUsage;</p>
<p>} OBJECT_TYPE_INFORMATION, *POBJECT_TYPE_INFORMATION;</p>

<p>typedef struct _OBJECT_ALL_TYPES_INFORMATION {</p>
<p>ULONG NumberOfTypes;</p>
<p>OBJECT_TYPE_INFORMATION TypeInformation;</p>
<p>} OBJECT_ALL_TYPES_INFORMATION, *POBJECT_ALL_TYPES_INFORMATION;</p>

<p>Поле Name определяет имя типа объекта, которое следует сразу после</p>
<p>каждой структуры OBJECT_TYPE_INFORMATION. Следующая структура</p>
<p>OBJECT_TYPE_INFORMATION расположена после этого имени и выровнена на границу</p>
<p>четырех байт.</p>

<p>ObjectTypeNumber из структуры SYSTEM_HANDLE_INFORMATION - это индекс</p>
<p>в массиве TypeInformation.</p>

<p>Сложнее получить имя хэндла из другого процесса. Существуют два способа</p>
<p>сделать это. Первый состоит в том, чтобы скопировать хэндл функцией</p>
<p>NtDuplicateObject в наш процесс и затем проименовать его. Этот метод не</p>
<p>сработает для некоторых специфических типов хэндлов. Но он не срабатывает</p>
<p>довольно редко, поэтому мы можем оставаться спокойными и использовать его.</p>

<p>NtDuplicateObject(</p>
<p>IN HANDLE SourceProcessHandle,</p>
<p>IN HANDLE SourceHandle,</p>
<p>IN HANDLE TargetProcessHandle,</p>
<p>OUT PHANDLE TargetHandle OPTIONAL,</p>
<p>IN ACCESS_MASK DesiredAccess,</p>
<p>IN ULONG Attributes,</p>
<p>IN ULONG Options</p>
<p>);</p>

<p>SourceProcessHandle - хэндл процесса, который владеет SourceHandle,</p>
<p>то есть хэндлом, который мы хотим скопировать. TargetProcessHandle - это хэндл</p>
<p>процесса, в который мы хотим копировать. Это хэндл нашего процесса в нашем</p>
<p>случае. TargetHandle - указатель, куда будет сохранена копия хэндла. Параметр</p>
<p>DesiredAccess должен быть равен PROCESS_QUERY_INFORMATION, а Attribures</p>
<p>и Options - нулю.</p>

<p>Второй способ именования, работающий со всеми хэндлами, состоит в</p>
<p>использовании системного драйвера. Исходный код этого метода доступен в</p>
<p>проекте OpHandle на моем сайте http://rootkit.host.sk.</p>


<p>Порты </p>

<p>Самый простой путь для перечисления открытых портов - это использование</p>
<p>функций AllocateAndGetTcpTableFromStack и AllocateAndGetUdpTableFromStack,</p>
<p>и/или AllocateAndGetTcpExTableFromStack и AllocateAndGetUdpExTableFromStack из</p>
<p>iphlpapi.dll. Ex-функции доступны начиная с Windows XP.</p>

<p>typedef struct _MIB_TCPROW {</p>
<p>DWORD dwState;</p>
<p>DWORD dwLocalAddr;</p>
<p>DWORD dwLocalPort;</p>
<p>DWORD dwRemoteAddr;</p>
<p>DWORD dwRemotePort;</p>
<p>} MIB_TCPROW, *PMIB_TCPROW;</p>

<p>typedef struct _MIB_TCPTABLE {</p>
<p>DWORD dwNumEntries;</p>
<p>MIB_TCPROW table[ANY_SIZE];</p>
<p>} MIB_TCPTABLE, *PMIB_TCPTABLE;</p>

<p>typedef struct _MIB_UDPROW {</p>
<p>DWORD dwLocalAddr;</p>
<p>DWORD dwLocalPort;</p>
<p>} MIB_UDPROW, *PMIB_UDPROW;</p>

<p>typedef struct _MIB_UDPTABLE {</p>
<p>DWORD dwNumEntries;</p>
<p>MIB_UDPROW table[ANY_SIZE];</p>
<p>} MIB_UDPTABLE, *PMIB_UDPTABLE;</p>

<p>typedef struct _MIB_TCPROW_EX</p>
<p>{</p>
<p>DWORD dwState;</p>
<p>DWORD dwLocalAddr;</p>
<p>DWORD dwLocalPort;</p>
<p>DWORD dwRemoteAddr;</p>
<p>DWORD dwRemotePort;</p>
<p>DWORD dwProcessId;</p>
<p>} MIB_TCPROW_EX, *PMIB_TCPROW_EX;</p>

<p>typedef struct _MIB_TCPTABLE_EX</p>
<p>{</p>
<p>DWORD dwNumEntries;</p>
<p>MIB_TCPROW_EX table[ANY_SIZE];</p>
<p>} MIB_TCPTABLE_EX, *PMIB_TCPTABLE_EX;</p>

<p>typedef struct _MIB_UDPROW_EX</p>
<p>{</p>
<p>DWORD dwLocalAddr;</p>
<p>DWORD dwLocalPort;</p>
<p>DWORD dwProcessId;</p>
<p>} MIB_UDPROW_EX, *PMIB_UDPROW_EX;</p>

<p>typedef struct _MIB_UDPTABLE_EX</p>
<p>{</p>
<p>DWORD dwNumEntries;</p>
<p>MIB_UDPROW_EX table[ANY_SIZE];</p>
<p>} MIB_UDPTABLE_EX, *PMIB_UDPTABLE_EX;</p>

<p>DWORD WINAPI AllocateAndGetTcpTableFromStack(</p>
<p>OUT PMIB_TCPTABLE *pTcpTable,</p>
<p>IN BOOL bOrder,</p>
<p>IN HANDLE hAllocHeap,</p>
<p>IN DWORD dwAllocFlags,</p>
<p>IN DWORD dwProtocolVersion;</p>
<p>);</p>

<p>DWORD WINAPI AllocateAndGetUdpTableFromStack(</p>
<p>OUT PMIB_UDPTABLE *pUdpTable,</p>
<p>IN BOOL bOrder,</p>
<p>IN HANDLE hAllocHeap,</p>
<p>IN DWORD dwAllocFlags,</p>
<p>IN DWORD dwProtocolVersion;</p>
<p>);</p>

<p>DWORD WINAPI AllocateAndGetTcpExTableFromStack(</p>
<p>OUT PMIB_TCPTABLE_EX *pTcpTableEx,</p>
<p>IN BOOL bOrder,</p>
<p>IN HANDLE hAllocHeap,</p>
<p>IN DWORD dwAllocFlags,</p>
<p>IN DWORD dwProtocolVersion;</p>
<p>);</p>

<p>DWORD WINAPI AllocateAndGetUdpExTableFromStack(</p>
<p>OUT PMIB_UDPTABLE_EX *pUdpTableEx,</p>
<p>IN BOOL bOrder,</p>
<p>IN HANDLE hAllocHeap,</p>
<p>IN DWORD dwAllocFlags,</p>
<p>IN DWORD dwProtocolVersion;</p>
<p>);</p>


<p>Есть и другой способ. Когда программа создает сокет и начинает его</p>
<p>слушать, она, конечно, имеет открытый хэндл для него и для открытого порта.</p>
<p>Мы можем перечислить все открытые хэндлы в системе и послать им специальный</p>
<p>буфер, используя функцию NtDeviceIoControlFile, чтобы определить хэндлы</p>
<p>для открытых портов. Это также даст нам информацию о портах. Так как открытых</p>
<p>хэндлов очень много, мы будем тестировать только хэндлы с типом File и именем</p>
<p>\Device\Tcp или \Device\Udp. Открытые порты имеют только этот тип и имя.</p>

<p>Когда мы смотрели код перечисленных функций в iphlpapi.dll, мы</p>
<p>обнаружили, что эти функции вызывают NtDeviceIoControlFile и посылают</p>
<p>специальный буфер для того, чтобы получить список всех открытых портов в</p>
<p>системе. Это значит, что единственная функция, которую нужно перехватить для</p>
<p>скрытия портов - это NtDeviceIoControlFile.</p>

<p>NTSTATUS NtDeviceIoControlFile(</p>
<p>IN HANDLE FileHandle</p>
<p>IN HANDLE Event OPTIONAL,</p>
<p>IN PIO_APC_ROUTINE ApcRoutine OPTIONAL,</p>
<p>IN PVOID ApcContext OPTIONAL,</p>
<p>OUT PIO_STATUS_BLOCK IoStatusBlock,</p>
<p>IN ULONG IoControlCode,</p>
<p>IN PVOID InputBuffer OPTIONAL,</p>
<p>IN ULONG InputBufferLength,</p>
<p>OUT PVOID OutputBuffer OPTIONAL,</p>
<p>IN ULONG OutputBufferLength</p>
<p>); </p>

<p>Интересующие нас параметры - это FileHandle (определяет хэндл</p>
<p>устройства), IoStatusBlock (указывает на переменную, которая получает</p>
<p>информацию о статусе выполнения и информацию об операции), IoControlCode</p>
<p>(число, определяющее тип устройства, метод, права доступа и функцию).</p>
<p>InputBiffer содержит данные размером InputBufferLength байт. И тоже самое в</p>
<p>OutputBuffer и OutputbufferLength.</p>

<p>Netstat, OpPorts в WinXP, FPort в WinXP</p>

<p>Получение списка открытых портов в первую очередь использутеся,</p>
<p>например, в OpPorts и FPort в Windows XP, а также Netstat.</p>
<p>Программы вызывают NtDeviceIoControlFile дважды с IoControlCode равным</p>
<p>0x000120003. OutputBuffer заполняется после второго вызова. Имя FileHandle</p>
<p>здесь всегда \Device\Tcp. InputBuffer различается для разных типов вызова:</p>

<p>1) Для получения массива из MIB_TCPROW InputBuffer должен быть таким:</p>

<p>первый вызов:</p>
<p>0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>второй вызов:</p>
<p>0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x01 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>2) Чтобы получить массив из MIB_UDPROW:</p>

<p>первый вызов:</p>
<p>0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>второй вызов:</p>
<p>0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x01 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>3) Чтобы получить массив из MIB_TCPROW_EX:</p>

<p>первый вызов:</p>
<p>0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>второй вызов:</p>
<p>0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x02 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>4) Чтобы получить массив из MIB_UDPROW_EX:</p>

<p>Первый вызов:</p>
<p>0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>Второй вызов:</p>
<p>0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01 0x00 0x00 </p>
<p>0x02 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 </p>
<p>0x00 0x00 0x00 0x00 </p>

<p>Вы можете заметить, что буферы различаются только в нескольких байтах.</p>
<p>Мы можем объяснить это.</p>

<p>Интересующие нас вызовы имеют в InputBuffer[1] 0x04 и, в основном,</p>
<p>InputBuffer[17] содержит 0x01. Только при таких входных данных мы получим</p>
<p>в OutputBuffer нужные таблицы. Если мы хотим получить информацию о TCP-портах,</p>
<p>нужно установить в InputBuffer[0] значение 0x00, или 0x01 для получения</p>
<p>информации о UDP-портах. Если нам нужны Ex-таблицы (MIB_TCPROW_EX или</p>
<p>MIB_UDPROW_EX), нужно во втором вызове установить в Inputbuffer[16] 0x02.</p>

<p>Если мы перехватили вызов с этими параметрами, нужно просто изменить</p>
<p>выходной буфер. Чтобы получить количество строк в выходном буфере, просто</p>
<p>разделите Information из IoStatusBlock на размер строки. Скрыть одну строку</p>
<p>очень просто. Просто перезапишите ее последующими строками и удалить последнюю</p>
<p>строку. Не забудьте изменить OutputBufferLength и IoStatusBlock.</p>

<p>OpPorts в Win2k и NT4, FPort в Win2k</p>

<p>Мы используем NtDeviceIoControlFile с IoControlCode равным 0x00210012,</p>
<p>чтобы определить, что хэндл с типом File и именем \Device\Tcp или \Device\Udp -</p>
<p>это хэндл открытого порта.</p>

<p>Во-первых, мы сравним IoControlCode, а затем тип и имя хэндла. Если</p>
<p>он нас все еще интересует, мы проверим длину входного буфера, который должен</p>
<p>быть равным длине структуры TDI_CONNECTION_IN. Ее длина 0x18. Выходной буфер -</p>
<p>TDI_CONNETION_OUT.</p>

<p>typedef struct _TDI_CONNETION_IN</p>
<p>{</p>
<p>ULONG UserDataLength,</p>
<p>PVOID UserData,</p>
<p>ULONG OptionsLength,</p>
<p>PVOID Options,</p>
<p>ULONG RemoteAddressLength,</p>
<p>PVOID RemoteAddress</p>
<p>} TDI_CONNETION_IN, *PTDI_CONNETION_IN;</p>

<p>typedef struct _TDI_CONNETION_OUT</p>
<p>{</p>
<p>ULONG State,</p>
<p>ULONG Event,</p>
<p>ULONG TransmittedTsdus,</p>
<p>ULONG ReceivedTsdus,</p>
<p>ULONG TransmissionErrors,</p>
<p>ULONG ReceiveErrors,</p>
<p>LARGE_INTEGER Throughput</p>
<p>LARGE_INTEGER Delay,</p>
<p>ULONG SendBufferSize,</p>
<p>ULONG ReceiveBufferSize,</p>
<p>ULONG Unreliable,</p>
<p>ULONG Unknown1[5],</p>
<p>USHORT Unknown2</p>
<p>} TDI_CONNETION_OUT, *PTDI_CONNETION_OUT;</p>

<p>Конкретная реализация, того как определить то, что хэндл - это хэндл</p>
<p>открытого порта, доступна в исходном коде OpPorts на моем сайте</p>
<p>https://rootkit.host.sk. Сейчас нам необходимо скрыть определенные порты. Мы</p>
<p>уже проверили InputBufferLength и IoControlCode. Теперь мы должны проверить</p>
<p>RemoteAddressLength - для открытого порта всегда 3 или 4. Наконец, мы должны</p>
<p>сравнить поле ReceivedTsdus из OutputBuffer, которое содержит порт в</p>
<p>сетевой форме, со списком портов, которые мы хотим скрыть. Мы можем различать</p>
<p>TCP и UDP в соответствии с именем хэндла. Удалив OutputBuffer, изменив</p>
<p>IoStatusBlock и вернув значение STATUS_INVALID_ADDRESS, мы скроем порт.</p>


<p>Окончание </p>

<p>Конкретная реализация описанных техник доступна в исходном коде</p>
<p>Hacker Defender Rootkit версии 1.0.0 на сайте http://rootkit.host.sk и на</p>
<p>https://www.rootkit.com.</p>
<p>Возможно, я добавлю информацию о невидимости в Windows NT в будущем.</p>
<p>Новые версии документа также будут содержать улучшения описаных методов и новые</p>
<p>комментарии.</p>
<p>Отдельное спасибо Ratter'у, который дал мне много ноу-хау, которые были</p>
<p>необходимы для написания этой статьи и кода проекта Hacker Defender.</p>
<p>Все комментарии присылаете на holy_father@phreaker.net или на доску на</p>
<p>сайте http://rootkit.host.sk.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

