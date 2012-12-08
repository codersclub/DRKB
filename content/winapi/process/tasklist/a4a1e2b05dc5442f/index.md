---
Title: Как стать невидимым в Windows NT (статья)?
Date: 01.01.2007
---

Как стать невидимым в Windows NT (статья)?
==========================================

::: {.date}
01.01.2007
:::

Как стать невидимым в Windows NT

Author: Holy\_Father \<holy\_father\@phreaker.net\>

Version: 1.2 russian

Date: 05.08.2003

Translation: Kerk \<kerk\_p\@yahoo.com\>

Вступление

Эта статья описывает техники скрытия объектов, файлов, сервисов,

процессов и т.д. в ОС Windows NT. Эти методы основаны на перехвате
функций

Windows API, что описано в моей статье \"Hooking Windows API\".

Данная информация была получена мною в процессе написания rootkit\'а,

поэтому есть вероятность, что это может быть реализовано более
эффективно или

намного более просто.

Под скрытием объектов в этой статье подразумевается замена некоторых

системных функций, которые работают с этим объектом таким образом, чтобы
они

его пропускали. В случае, если объект - всего лишь возвращаемое значение

функции, мы просто возвратим значение, как будто бы объекта не
существует.

Простейший метод (исключая случаи, когда сказано обратное) - это

вызов оригинальной функции с оригинальными аргументами и замена ее
выходных

данных.

В этой версии статьи описаны методы скрытия файлов, процессов,

ключей и значений реестра, системных сервисов и драйверов, выделенной
памяти и

хэндлов.

Файлы

Существует несколько способов скрытия файлов, чтобы ОС не могла их

видеть. Мы сконцентрируемся на изменении API и отбросим такие техники,
как

использование возможностей файловой системы. К тому же это намного
проще, т.к.

в этом случае нам не нужно знать как работает конкретная файловая
система.

NtQueryDirectoryFile

Поиск файла в wNT в какой-либо директории заключается в просмотре всех

файлов этой директории и файлов всех ее поддиректорий. Для перечисления
файлов

используется функция NtQueryDirectoryFile.

NTSTATUS NtQueryDirectoryFile(

IN HANDLE FileHandle,

IN HANDLE Event OPTIONAL,

IN PIO\_APC\_ROUTINE ApcRoutine OPTIONAL,

IN PVOID ApcContext OPTIONAL,

OUT PIO\_STATUS\_BLOCK IoStatusBlock,

OUT PVOID FileInformation,

IN ULONG FileInformationLength,

IN FILE\_INFORMATION\_CLASS FileInformationClass,

IN BOOLEAN ReturnSingleEntry,

IN PUNICODE\_STRING FileName OPTIONAL,

IN BOOLEAN RestartScan

);

Для нас важны параметры FileHandle, FileInformation

и FileInformationClass. FileHandle - хэндл объекта директории, который
может

быть получен с использованием функции NtOpenFile. FileInformation -
указатель

на выделенную память, куда функция запишет необходимые данные.

FileInformationClass определяет тип записей в FileInformation.

FileInformationClass перечислимого типа, но нам необходимы только

четыре его значения, используемые для просмотра содержимого директории.

\#define FileDirectoryInformation 1

\#define FileFullDirectoryInformation 2

\#define FileBothDirectoryInformation 3

\#define FileNamesInformation 12

структура записи в FileInformation для FileDirectoryInformation:

typedef struct \_FILE\_DIRECTORY\_INFORMATION {

ULONG NextEntryOffset;

ULONG Unknown;

LARGE\_INTEGER CreationTime;

LARGE\_INTEGER LastAccessTime;

LARGE\_INTEGER LastWriteTime;

LARGE\_INTEGER ChangeTime;

LARGE\_INTEGER EndOfFile;

LARGE\_INTEGER AllocationSize;

ULONG FileAttributes;

ULONG FileNameLength;

WCHAR FileName\[1\];

} FILE\_DIRECTORY\_INFORMATION, \*PFILE\_DIRECTORY\_INFORMATION;

для FileFullDirectoryInformation:

typedef struct \_FILE\_FULL\_DIRECTORY\_INFORMATION {

ULONG NextEntryOffset;

ULONG Unknown;

LARGE\_INTEGER CreationTime;

LARGE\_INTEGER LastAccessTime;

LARGE\_INTEGER LastWriteTime;

LARGE\_INTEGER ChangeTime;

LARGE\_INTEGER EndOfFile;

LARGE\_INTEGER AllocationSize;

ULONG FileAttributes;

ULONG FileNameLength;

ULONG EaInformationLength;

WCHAR FileName\[1\];

} FILE\_FULL\_DIRECTORY\_INFORMATION,
\*PFILE\_FULL\_DIRECTORY\_INFORMATION;

для FileBothDirectoryInformation:

typedef struct \_FILE\_BOTH\_DIRECTORY\_INFORMATION {

ULONG NextEntryOffset;

ULONG Unknown;

LARGE\_INTEGER CreationTime;

LARGE\_INTEGER LastAccessTime;

LARGE\_INTEGER LastWriteTime;

LARGE\_INTEGER ChangeTime;

LARGE\_INTEGER EndOfFile;

LARGE\_INTEGER AllocationSize;

ULONG FileAttributes;

ULONG FileNameLength;

ULONG EaInformationLength;

UCHAR AlternateNameLength;

WCHAR AlternateName\[12\];

WCHAR FileName\[1\];

} FILE\_BOTH\_DIRECTORY\_INFORMATION,
\*PFILE\_BOTH\_DIRECTORY\_INFORMATION;

и для FileNamesInformation:

typedef struct \_FILE\_NAMES\_INFORMATION {

ULONG NextEntryOffset;

ULONG Unknown;

ULONG FileNameLength;

WCHAR FileName\[1\];

} FILE\_NAMES\_INFORMATION, \*PFILE\_NAMES\_INFORMATION;

Функция записывает набор этих структур в буфер FileInformation.

Во всех этих типах структур для нас важны только три переменных.

NextEntryOffset - размер данного элемента списка. Первый элемент

расположен по адресу FileInformation + 0, а второй элемент по адресу

FileInformation + NextEntryOffset первого элемента. У последнего
элемента

поле NextEntryOffset содержит нуль.

FileName - это полное имя файла.

FileNameLength - это длина имени файла.

Для скрытия файла, необходимо сравнить имя каждой возвращаемой записи

и имя файла, который мы хотим скрыть. Если мы хотим скрыть первую
запись,

нужно сдвинуть следующие за ней структуры на размер первой записи. Это
приведет

к тому, что первая запись будет затерта. Если мы хотим скрыть другую
запись,

мы можем просто изменить значение NextEntryOffset предыдущей записи.
Новое

значение NextEntryOffset будет нуль, если мы хотим скрыть последнюю
запись,

иначе значение будет суммой полей NextEntryOffset записи, которую мы
хотим

скрыть и предыдущей записи. Затем необходимо изменить значение поля
Unknown

предыдущей записи, которое предоставляет индекс для последующего поиска.

Значение поля Unknown предыдущей записи должно равняться значению поля
Unknown

записи, которую мы хотим скрыть.

Если нет ниодной записи, которую можно видеть, мы должны вернуть ошибку

STATUS\_NO\_SUCH\_FILE.

\#define STATUS\_NO\_SUCH\_FILE 0xC000000F

NtVdmControl

По неизвестной причине эмуляция DOS - NTVDM может получить список

файлов еще и с помощью функции NtVdmControl.

NTSTATUS NtVdmControl(

IN ULONG ControlCode,

IN PVOID ControlData

);

ControlCode указывает подфункцию, которая будет применена к данным

в буфере ControlData. Если ControlCode равняется VdmDirectoryFile, эта

функция делает то же, что и NtQueryDirectoryFile с FileInformationClass

равным FileBothDirectoryInformation.

\#define VdmDirectoryFile 6

Тогда буфер ControlData используется как FileInformation. Единственная

разница в том, что мы не знаем длину этого буфера. Поэтому мы должны
вычислить

ее вручную. Мы можем сложить NextEntryOffset всех записей,
FileNameLength

последней записи и 0x5E (длина последней записи исключая длину имени
файла).

Методы скрытия такие же как и в случае с NtQueryDirectoryFile.

Процессы

Различная системная информация доступна через NtQuerySystemInformation.

NTSTATUS NtQuerySystemInformation(

IN SYSTEM\_INFORMATION\_CLASS SystemInformationClass,

IN OUT PVOID SystemInformation,

IN ULONG SystemInformationLength,

OUT PULONG ReturnLength OPTIONAL

);

SystemInformationClass указывает тип информации, которую мы хотим

получить, SystemInformation - это указатель на результирующий буфер,

SystemInformationLength - размер этого буфера и ReturnLength -
количество

записанных байт.

Для перечисления запущенных процессов мы устанавливаем в параметр

SystemInformationClass значение SystemProcessesAndThreadsInformation.

\#define SystemInformationClass 5

Возвращаемая структура в буфере SystemInformation:

typedef struct \_SYSTEM\_PROCESSES {

ULONG NextEntryDelta;

ULONG ThreadCount;

ULONG Reserved1\[6\];

LARGE\_INTEGER CreateTime;

LARGE\_INTEGER UserTime;

LARGE\_INTEGER KernelTime;

UNICODE\_STRING ProcessName;

KPRIORITY BasePriority;

ULONG ProcessId;

ULONG InheritedFromProcessId;

ULONG HandleCount;

ULONG Reserved2\[2\];

VM\_COUNTERS VmCounters;

IO\_COUNTERS IoCounters; // только Windows 2000

SYSTEM\_THREADS Threads\[1\];

} SYSTEM\_PROCESSES, \*PSYSTEM\_PROCESSES;

Скрытие процессов похоже на скрытие файлов. Мы должны изменить

NextEntryDelta записи предшествующей записи скрываемого процесса. Обычно

не требуется скрывать первую запись, т.к. это процесс Idle.

Реестр

Реестр Windows - это достаточно большая древовидная структура,

содержащая два важных типа записей, которые мы можем захотеть скрыть.
Первый

тип - ключи реестра, второй - значения реестра. Благодаря структуре
реестра

скрытие его ключей не так тривиально, как скрытие файлов или процессов.

NtEnumerateKey

Благодаря структуре реестра, мы не можем запросить список всех ключей

в какой-либо его части. Мы можем получить информацию только об одном
ключе,

указанном его индексом. Используется функция NtEnumerateKey.

NTSTATUS NtEnumerateKey(

IN HANDLE KeyHandle,

IN ULONG Index,

IN KEY\_INFORMATION\_CLASS KeyInformationClass,

OUT PVOID KeyInformation,

IN ULONG KeyInformationLength,

OUT PULONG ResultLength

);

KeyHandle - это дескриптор ключа, в котором мы хотим получить

информацию о подключе, указанном параметром Index. Тип полученной
информации

определяется полем KeyInformationClass. Данные записываются в буфер

KeyInformation, длина которого указана в параметре KeyInformationLength.

Количество записанных байт возвращается в ResultLength.

Наиболее важным является понимание того, что если мы скроем ключ, то

индексы всех последующих ключей будут сдвинуты. И так как нам придется
получать

информацию о ключе с большим индексом запрашивая ключ с меньшим
индексом, мы

должны подсчитать количество записей до скрытой и вернуть правильное
значение.

Давайте разберем пример. Допустим в какой-то части реестра есть ключи с

именами A, B, C, D, E и F. Индекс начинается с нуля, это означает, что
ключ E

имеет индекс 4. Теперь, если мы хотим скрыть ключ B и приложение вызвало

NtEnumerateKey с Index равным 4, мы должны вернуть информацию о ключе F,
так

как индекс сдвинут. Проблема в том, что нам неизвестно, что нужно
произвести

сдвиг. А если мы не позаботимся о сдвиге, то вернем E вместо F, когда
будет

запрашиваться ключ с индексом 4, или ничего не вернем для ключа с
индексом 1,

хотя должны вернуть C. В обоих случаях ошибка. Вот почему мы должны
подумать

о сдвиге.

Если мы будем вычислять сдвиг вызовом функции для каждого индекса

от 0 до Index, иногда нам придется ждать годами (на 1ГГц процессоре это
может

занять до 10 секунд со стандартным реестром, который очень большой).
Поэтому

мы должны придумать более совершенный метод.

Мы знаем, что ключи (исключая ссылки) отсортированы по алфавиту. Если

мы пренебрежем ссылками (которые мы не хотим скрывать), мы сможем
вычислить

сдвиг следующим методом. Мы отсортируем по алфавиту список имен ключей,
которые

необходимо скрыть (используя RtlCompareUnicodeString), затем, когда
приложение

вызывает NtEnumerateKey, мы не будем перевызывать ее с неизмененными

аргументами, а определим имя записи указанной параметром Index.

NTSTATUS RtlCompareUnicodeString(

IN PUNICODE\_STRING String1,

IN PUNICODE\_STRING String2,

IN BOOLEAN CaseInSensitive

);

String1 и String2 - строки, которые необходимо сравнить,

CaseInSensitive - True, если мы хотим провести сравнение, игнорируя
регистр.

Результат функции описывает отношение между String1 и String2:

result \> 0: String1 \> String2

result = 0: String1 = String2

result \< 0: String1 \< String2

Теперь мы должны найти границу. Мы сравним имя, указанное параметром
Index с

именами в нашем списке. Границей будет последнее меньшее имя из нашего
списка.

Мы знаем, что сдвиг не превышает номер граничного элемента в нашем
списке.

Но не все элементы списка являются действительными ключами в той части
реестра,

где мы находимся. Поэтому мы должны определить элементы списка до
границы,

которые являются частью реестра. Мы можем сделать это используя
NtOpenKey.

NTSTATUS NtOpenKey(

OUT PHANDLE KeyHandle,

IN ACCESS\_MASK DesiredAccess,

IN POBJECT\_ATTRIBUTES ObjectAttributes

);

KeyHandle - это хэндл родительского ключа. Мы будем использовать

значение, переданное в NtEnumerateKey. DesiredAccess - права доступа,

используем значение KEY\_ENUMERATE\_SUB\_KEYS. ObjectAttributes
описывают

подключ, которых мы хотим открыть (включая его имя).

\#define KEY\_ENUMERATE\_SUB\_KEYS 8

Если NtOpenKey вернет 0 - ключ был открыт успешно - это значит, что

этот элемент списка существует. Открытый ключ следует закрыть, используя

NtClose.

NTSTATUS NtClose(

IN HANDLE Handle

);

При каждом вызове функции NtEnumerateKey мы должны вычислять сдвиг,

как количество ключей из нашего списка, которые существуют в данной
части

реестра. Затем мы должны прибавить этот сдвиг к аргументу Index и,
наконец,

вызвать оригинальную NtEnumerateKey.

Для получения имени ключа, указанного параметром Index, мы используем

KeyBasicInformation в качестве значения для KeyInformationClass.

\#define KeyBasicInformation 0

NtEnumerateKey вернет в буфере KeyInformation структуру:

typedef struct \_KEY\_BASIC\_INFORMATION {

LARGE\_INTEGER LastWriteTime;

ULONG TitleIndex;

ULONG NameLength;

WCHAR Name\[1\];

} KEY\_BASIC\_INFORMATION, \*PKEY\_BASIC\_INFORMATION;

Единственное что нам нужно - это Name, и его длина - NameLength.

Если ключа для сдвинутого параметра Index не существует, мы

должны вернуть ошибку STATUS\_EA\_LIST\_INCONSISTENT.

\#define STATUS\_EA\_LIST\_INCONSISTENT 0x80000014

NtEnumerateValueKey

Значения реестра не отсортированы. К счастью, их количество в одном

ключе достаточно мало, поэтому мы можем перевызывать функцию, чтобы
получить

сдвиг. API для получения информации об одном значении реестра

назывется NtEnumarateValueKey.

NTSTATUS NtEnumerateValueKey(

IN HANDLE KeyHandle,

IN ULONG Index,

IN KEY\_VALUE\_INFORMATION\_CLASS KeyValueInformationClass,

OUT PVOID KeyValueInformation,

IN ULONG KeyValueInformationLength,

OUT PULONG ResultLength

);

KeyHandle - это снова хэндл родительского ключа. Index - это индекс

в списке значений данного ключа. KeyValueInformationClass описывает тип

информации, которая будет помещена в буфер KeyValueInformation размером

KeyValueInformationLength байт. Количество записанных в буфер байт
возвращается

в ResultLength.

И снова мы должны вычислить сдвиг, перевызывая функцию для всех

индексов от 0 до Index. Имя значения может быть получено при
использовании

KeyValueBasicInformation в качестве значения для
KeyValueInformationClass.

\#define KeyValueBasicInformation 0

Тогда в буфере KeyValueInformation мы получим следующую структуру:

typedef struct \_KEY\_VALUE\_BASIC\_INFORMATION {

ULONG TitleIndex;

ULONG Type;

ULONG NameLength;

WCHAR Name\[1\];

} KEY\_VALUE\_BASIC\_INFORMATION, \*PKEY\_VALUE\_BASIC\_INFORMATION;

Нас снова интересуют только Name и NameLength.

Если для сдвинутого параметра Index не существует соответствующего

значения реестра, то мы должны вернуть STATUS\_NO\_MORE\_ENTRIES.

\#define STATUS\_NO\_MORE\_ENTRIES 0x8000001A

Сервисы и драйверы

Системные сервисы и драйверы обрабатываются четырьмя независимыми

API-функциями. Их связи различны в каждой версии Windows. Поэтому мы
вынуждены

перехватывать все четыре функции.

BOOL EnumServicesStatusA(

SC\_HANDLE hSCManager,

DWORD dwServiceType,

DWORD dwServiceState,

LPENUM\_SERVICE\_STATUS lpServices,

DWORD cbBufSize,

LPDWORD pcbBytesNeeded,

LPDWORD lpServicesReturned,

LPDWORD lpResumeHandle

);

BOOL EnumServiceGroupW(

SC\_HANDLE hSCManager,

DWORD dwServiceType,

DWORD dwServiceState,

LPBYTE lpServices,

DWORD cbBufSize,

LPDWORD pcbBytesNeeded,

LPDWORD lpServicesReturned,

LPDWORD lpResumeHandle,

DWORD dwUnknown

);

BOOL EnumServicesStatusExA(

SC\_HANDLE hSCManager,

SC\_ENUM\_TYPE InfoLevel,

DWORD dwServiceType,

DWORD dwServiceState,

LPBYTE lpServices,

DWORD cbBufSize,

LPDWORD pcbBytesNeeded,

LPDWORD lpServicesReturned,

LPDWORD lpResumeHandle,

LPCTSTR pszGroupName

);

BOOL EnumServicesStatusExW(

SC\_HANDLE hSCManager,

SC\_ENUM\_TYPE InfoLevel,

DWORD dwServiceType,

DWORD dwServiceState,

LPBYTE lpServices,

DWORD cbBufSize,

LPDWORD pcbBytesNeeded,

LPDWORD lpServicesReturned,

LPDWORD lpResumeHandle,

LPCTSTR pszGroupName

);

Наиболее важен здесь параметр lpServices, которое указывает на буфер,

где должен быть размещен список сервисов. lpServicesReturned, которое
указывает

на количество записей в буфере, также важно. Структура данных в выходном
буфере

зависит от типа функции. Для функций EnumServicesStatusA и
EnumServicesGroupW

возвращается структура:

typedef struct \_ENUM\_SERVICE\_STATUS {

LPTSTR lpServiceName;

LPTSTR lpDisplayName;

SERVICE\_STATUS ServiceStatus;

} ENUM\_SERVICE\_STATUS, \*LPENUM\_SERVICE\_STATUS;

typedef struct \_SERVICE\_STATUS {

DWORD dwServiceType;

DWORD dwCurrentState;

DWORD dwControlsAccepted;

DWORD dwWin32ExitCode;

DWORD dwServiceSpecificExitCode;

DWORD dwCheckPoint;

DWORD dwWaitHint;

} SERVICE\_STATUS, \*LPSERVICE\_STATUS;

а для EnumServicesStatusExA и EnumServicesStatusExW:

typedef struct \_ENUM\_SERVICE\_STATUS\_PROCESS {

LPTSTR lpServiceName;

LPTSTR lpDisplayName;

SERVICE\_STATUS\_PROCESS ServiceStatusProcess;

} ENUM\_SERVICE\_STATUS\_PROCESS, \*LPENUM\_SERVICE\_STATUS\_PROCESS;

typedef struct \_SERVICE\_STATUS\_PROCESS {

DWORD dwServiceType;

DWORD dwCurrentState;

DWORD dwControlsAccepted;

DWORD dwWin32ExitCode;

DWORD dwServiceSpecificExitCode;

DWORD dwCheckPoint;

DWORD dwWaitHint;

DWORD dwProcessId;

DWORD dwServiceFlags;

} SERVICE\_STATUS\_PROCESS, \*LPSERVICE\_STATUS\_PROCESS;

Нас интересует только поле lpServiceName, которое содержит имя

сервиса. Записи имеют фиксированный размер, поэтому, если мы хотим
скрыть

одну, мы передвинем все последующие записи на ее размер. Здесь мы должны

помнить о различии размеров SERVICE\_STATUS и SERVICE\_STATUS\_PROCESS.

Перехват и распространение

Чтобы получить желаемый эффект, мы должны заразить все запущенные

процессы, а также процессы, которые будут запущены позже. Новые процессы
должны

быть заражены до выполнения первой инструкции их кода, иначе они смогут
увидеть

наши скрытые объекты до того, как функции будут перехвачены.

Привелегии

Нам нужны как минимум администраторские права, чтобы получить доступ ко

всем запущенным процессам. Лучшая возможность - это запуск нашего
процесса как

системного сервиса, который работает с правами пользователя SYSTEM.
Чтобы

установить сервис нам тоже нужны специальные привелегии.

Также очень полезно получение привелегии SeDebugPrivilege. Это может

быть сделано с помощью функций OpenProcessToken, LookupPrivilegeValue и

AdjustTokenPrivileges.

BOOL OpenProcessToken(

HANDLE ProcessHandle,

DWORD DesiredAccess,

PHANDLE TokenHandle

);

BOOL LookupPrivilegeValue(

LPCTSTR lpSystemName,

LPCTSTR lpName,

PLUID lpLuid

);

BOOL AdjustTokenPrivileges(

HANDLE TokenHandle,

BOOL DisableAllPrivileges,

PTOKEN\_PRIVILEGES NewState,

DWORD BufferLength,

PTOKEN\_PRIVILEGES PreviousState,

PDWORD ReturnLength

);

Игнорируя возможные ошибки, это может быть сделано так:

\#define SE\_PRIVILEGE\_ENABLED 0x0002

\#define TOKEN\_QUERY 0x0008

\#define TOKEN\_ADJUST\_PRIVILEGES 0x0020

HANDLE hToken;

LUID DebugNameValue;

TOKEN\_PRIVILEGES Privileges;

DWORD dwRet;

OpenProcessToken(GetCurrentProcess(),

TOKEN\_ADJUST\_PRIVILEGES \| TOKEN\_QUERY,hToken);

LookupPrivilegeValue(NULL,\"SeDebugPrivilege\",&DebugNameValue);

Privileges.PrivilegeCount=1;

Privileges.Privileges\[0\].Luid=DebugNameValue;

Privileges.Privileges\[0\].Attributes=SE\_PRIVILEGE\_ENABLED;

AdjustTokenPrivileges(hToken,FALSE,&Privileges,sizeof(Privileges),

NULL,&dwRet);

CloseHandle(hToken);

Перехват

Перечисление процессов производится уже упомянутой API-функцией

NtQuerySystemInformation. Для перехвата функций используется метод
перезаписи

ее первых инструкций. Это делается для каждого запущеного процесса. Мы
выделим

память в нужном процессе, где запишем новый код для функций, которые
хотим

перехватить. Затем заменим первые пять байт этих функций на инструкцию
jmp.

Эта инструкция будет перенаправлять выполнение на наш код. Так,
инструкция jmp

будет выполнена сразу, как только функция будет вызвана. Мы должны
сохранить

первые инструкции каждой перезаписанной функции - они необходимы для
вызова

оригинального кода перехваченной функции. Сохранение инструкций
описывается в

разделе 3.2.3 статьи \"Hooking Windows API\".

Сначала мы должны открыть нужный процесс с помощью NtOpenProcess и

получить его хэндл. Произойдет ошибка, если у нас недостаточно
привелегий.

NTSTATUS NtOpenProcess(

OUT PHANDLE ProcessHandle,

IN ACCESS\_MASK DesiredAccess,

IN POBJECT\_ATTRIBUTES ObjectAttributes,

IN PCLIENT\_ID ClientId OPTIONAL

);

ProcessHandle - указатель на хэндл, где будет сохранен результат.

DesiredAccess следует установить равным PROCESS\_ALL\_ACCESS. Мы
установим

поле UniqueProcess структуры ClientId равным PID нужного процесса,
UniqueThread

должно быть равно нулю. Открытый хэндл должен быть закрыт с помощью
NtClose.

\#define PROCESS\_ALL\_ACCESS 0x001F0FFF

Теперь мы выделим память для нашего кода. Это может быть сделано

с помощью функции NtAllocateVirtualMemory.

NTSTATUS NtAllocateVirtualMemory(

IN HANDLE ProcessHandle,

IN OUT PVOID BaseAddress,

IN ULONG ZeroBits,

IN OUT PULONG AllocationSize,

IN ULONG AllocationType,

IN ULONG Protect

);

Используется значение ProcessHandle возвращенное функцией

NtOpenProcess. BaseAddress - указатель на указатель на желаемое начало
блока

выделенной памяти. Здесь будет сохранен указатель на выделенную память.

Входное значение может быть равно NULL. AllocationSize - указатель на

переменную, содержащую размер буфера, который мы хотим выделить. И также

здесь будет сохранено количество реально выделенных байт. Рекомендую
включить

значение MEM\_TOP\_DOWN в параметр AllocationType в дополнение к
MEM\_COMMIT, т.к.

в этом случае память будет выделена как можно выше рядом с DLL.

\#define MEM\_COMMIT 0x00001000

\#define MEM\_TOP\_DOWN 0x00100000

Теперь мы можем записать наш код, используя NtWriteVirtualMemory.

NTSTATUS NtWriteVirtualMemory(

IN HANDLE ProcessHandle,

IN PVOID BaseAddress,

IN PVOID Buffer,

IN ULONG BufferLength,

OUT PULONG ReturnLength OPTIONAL

);

В параметре BaseAddress используем значение возвращенное

NtAllocateVirtual. Buffer указывает на байты, которые мы хотим записать,

BufferLength - количество этих байтов.

Теперь мы перехватим функции. Единственная DLL, которая загружается в

каждый процесс - ntdll.dll. Так, мы должны проверить импортирована ли
функция,

которую мы хотим перехватить, в процесс, если эта функция не из
ntdll.dll.

Но память, которую эта функция (из другой DLL) могла бы занимать может
быть

выделена, и перезапись этих байт повлечет за собой сбой в процессе.
Поэтому

мы должны проверить загружена ли эта библиотека (в которой нужная нам
функция)

в процесс.

Мы должны получить PEB (Process Environment Block) нужного процесса,

используя NtQueryInformationProcess.

NTSTATUS NtQueryInformationProcess(

IN HANDLE ProcessHandle,

IN PROCESSINFOCLASS ProcessInformationClass,

OUT PVOID ProcessInformation,

IN ULONG ProcessInformationLength,

OUT PULONG ReturnLength OPTIONAL

);

Присвоим значение ProcessBasicInformation параметру

ProcessInformationClass. Тогда в буфер ProcessInformation, размер
которого

указан в параметре ProcessInformationLength, будет возвращена структура

PROCESS\_BASIC\_INFORMATION.

\#define ProcessBasicInformation 0

typedef struct \_PROCESS\_BASIC\_INFORMATION {

NTSTATUS ExitStatus;

PPEB PebBaseAddress;

KAFFINITY AffinityMask;

KPRIORITY BasePriority;

ULONG UniqueProcessId;

ULONG InheritedFromUniqueProcessId;

} PROCESS\_BASIC\_INFORMATION, \*PPROCESS\_BASIC\_INFORMATION;

PebBaseAddress - то, что мы ищем. PebBaseAddress+0x0C - это адрес

PPEB\_LDR\_DATA. Он может быть получен вызовом NtReadVirtualMemory.

NTSTATUS NtReadVirtualMemory(

IN HANDLE ProcessHandle,

IN PVOID BaseAddress,

OUT PVOID Buffer,

IN ULONG BufferLength,

OUT PULONG ReturnLength OPTIONAL

);

Параметры такие же как и у NtWriteVirtualMemory.

PPEB\_LDR\_DATA+0x1C - адрес InInitializationOrderModuleList. Это список

библиотек, загруженных в процесс. Нас интересует только часть этой
структуры.

typedef struct \_IN\_INITIALIZATION\_ORDER\_MODULE\_LIST {

PVOID Next,

PVOID Prev,

DWORD ImageBase,

DWORD ImageEntry,

DWORD ImageSize,

\...

);

Next - указатель на следующую запись, Prev - на предыдущую. Последняя

запись указывает на первую. ImageBase - адрес модуля в памяти.
ImageEntry - это

точка входа модуля, ImageSize - его размер.

Для каждой библиотеки, функции которой мы хотим перехватить, мы получим

ImageBase (например, используя GetModuleHandle или LoadLibrary). Эту
ImageBase

мы сравним с ImageBase каждого элемента в
InInitializationOrderModuleList.

Теперь мы готовы к перехвату. Из-за того, что мы перехватываем функции

в работающих процессах, существует вероятность, что код, который мы
будем

перезаписывать в тот момент будет выполняться. Это может вызвать ошибку,

поэтому сначала мы остановим все потоки этого процесса. Список потоков
можно

получить, используя функцию NtQuerySystemInformation с классом

SystemProcessesAndThreadsInformation. Результат работы этой функции
описан в

разделе 4, необходимо лишь добавить описание структуры SYSTEM\_THREADS,
которая

содержит информацию о потоке.

typedef struct \_SYSTEM\_THREADS {

LARGE\_INTEGER KernelTime;

LARGE\_INTEGER UserTime;

LARGE\_INTEGER CreateTime;

ULONG WaitTime;

PVOID StartAddress;

CLIENT\_ID ClientId;

KPRIORITY Priority;

KPRIORITY BasePriority;

ULONG ContextSwitchCount;

THREAD\_STATE State;

KWAIT\_REASON WaitReason;

} SYSTEM\_THREADS, \*PSYSTEM\_THREADS;

Для каждого потока мы должны получить его хэндл, используя

NtOpenThread. Мы используем для этого ClientId.

NTSTATUS NtOpenThread(

OUT PHANDLE ThreadHandle,

IN ACCESS\_MASK DesiredAccess,

IN POBJECT\_ATTRIBUTES ObjectAttributes,

IN PCLIENT\_ID ClientId

);

Хэндл, который нам нужен, будет сохранен в ThreadHandle. Параметр

DesiredAccess должен быть равен THREAD\_SUSPEND\_RESUME.

\#define THREAD\_SUSPEND\_RESUME 2

ThreadHandle будет использован при вызове NtSuspendThread.

NTSTATUS NtSuspendThread(

IN HANDLE ThreadHandle,

OUT PULONG PreviousSuspendCount OPTIONAL

);

Приостановленный процесс готов к перезаписи. Мы поступим, как описано

в разделе 3.2.2 статьи \"Hooking Windows API\". Единственная разница в
том, что

функции будут использоваться для других процессов.

После перехвата мы возобновим работу всех потоков процесса, используя

NtResumeThread.

NTSTATUS NtResumeThread(

IN HANDLE ThreadHandle,

OUT PULONG PreviousSuspendCount OPTIONAL

);

Новые процессы

Заражение всех запущенных процессов не затронет процессы, которые будут

запущены позже. Мы должны получить список процессов, через некоторое
время

получить новый, сравнить их, а затем заразить те процессы, которые есть
во

втором списке и отсутствуют в первом. Но этот метод очень ненадежен.

Намного лучше перехватить функцию, которая вызывается, когда стартует

новый процесс. Так как все запущенные в системе процессы заражены, мы не
сможем

пропустить ни один новый процесс, используя данный метод. Мы можем
перехватить

NtCreateThread, но это не самый простой путь. Мы будем перехватывать
функцию

NtResumeThread, которая также всегда вызывается при старте нового
процесса.

Она вызвается после NtCreateThread.

Единственная проблема с NtResumeThread состоит в том, что она

вызывается не только при запуске нового процесса. Но мы легко решим эту

проблему. NtQueryInformationThread предоставит нам информацию о том,
какой

процесс владеет данным потоком. Мы должны просто проверить, заражен ли
этот

процесс. Это можно определить прочитав первые байты любой из функций,
которые

мы перехватываем.

NTSTATUS NtQueryInformationThread(

IN HANDLE ThreadHandle,

IN THREADINFOCLASS ThreadInformationClass,

OUT PVOID ThreadInformation,

IN ULONG ThreadInformationLength,

OUT PULONG ReturnLength OPTIONAL

);

В нашем случае параметр ThreadInformationClass должен быть равен

ThreadBasicInformation. ThreadInformation - это буфер для результата,
размер

этого буфера указан в параметре ThreadInformationLength.

\#define ThreadBasicInformation 0

Для класса ThreadBasicInformation возвращается такая структура:

typedef struct \_THREAD\_BASIC\_INFORMATION {

NTSTATUS ExitStatus;

PNT\_TIB TebBaseAddress;

CLIENT\_ID ClientId;

KAFFINITY AffinityMask;

KPRIORITY Priority;

KPRIORITY BasePriority;

} THREAD\_BASIC\_INFORMATION, \*PTHREAD\_BASIC\_INFORMATION;

В параметре ClientId находится PID процесса, владеющего этим потоком.

Теперь мы должны заразить новый процесс. Проблема в том, что процесс

имеет в своей памяти только ntdll.dll. Все остальные модули загружаются
сразу

после вызова NtResumeThread. Существует несколько путей решения этой
проблемы.

Например, можно перехватить функцию LdrInitializeThunk, которая
вызывается при

инициализации процесса.

NTSTATUS LdrInitializeThunk(

DWORD Unknown1,

DWORD Unknown2,

DWORD Unknown3

);

Сначала нужно выполнить оригинальный код, а замет перехватить все

нужные функции в новом процессе. Затем лучше снять перехват
LdrInitializeThunk,

так как она будет вызвана позже много раз, а мы не хватим заново
перехватывать

все функции. Все это будет сделано до выполнения первых инструкций
процесса,

поэтому нет вероятности того, что этот процесс вызовет какую-нибудь из

перехватываемых функций до того, как мы ее перехватим.

Перехват функций в своем процессе такой же как и перехват в запущенном

процессе, но нам не нужно беспокоиться о потоках.

DLL

В каждом процессе в системе есть копия ntdll.dll. Это значит, что мы

можем перехватить любую функцию этого модуля при инициализации процесса.

Но как быть с функциями из других модулей, например, kernel32.dll или

advapi32.dll? Есть несколько процессов, у которых есть только ntdll.dll.

Все остальные модули могут быть загружены динамически в середине кода
после

перехвата процесса. Вот почему мы должны перехватить LdrLoadDll, которая

загружает новые модули.

NTSTATUS LdrLoadDll(

PWSTR szcwPath,

PDWORD pdwLdrErr,

PUNICODE\_STRING pUniModuleName,

PHINSTANCE pResultInstance

);

Наиболее важно для нас pUniModuleName - имя модуля. pResultInstance

будет адресом модуля, если вызов был успешен.

Мы вызовем оригинальную LdrLoadDll и затем перехватим все функции в

загруженном модуле.

Память

Когда мы перехватываем функцию, мы изменяем ее первые байты. Вызвав

NtReadVirtualMemory, кто угодно сможет определить, что функция
перехвачена.

Поэтому мы должны перехватить NtReadVirtualMemory, чтобы избежать
обнаружения.

NTSTATUS NtReadVirtualMemory(

IN HANDLE ProcessHandle,

IN PVOID BaseAddress,

OUT PVOID Buffer,

IN ULONG BufferLength,

OUT PULONG ReturnLength OPTIONAL

);

Мы заменили байты в начале тех функций, которые перехватили, и еще

выделили память для нового кода. Необходимо проверить читает ли функция

какие-либо из этих байт. Если наши байты находятся в диапазоне от
BaseAddress

до (BaseAddress + BufferLength), мы должны заменить некоторые байты в
Buffer.

Если кто-либо пытается прочитать байты из нашей выделенной памяти,

следует вернуть пустой Buffer и ошибку STATUS\_PARTIAL\_COPY. Это
значение

говорит о том, что не все запрошенные байты были скопированы в буфер
Buffer.

Это также происходит при попытке доступа к невыделенной памяти.
ReturnLength

должно быть установлено в нуль в данном случае.

\#define STATUS\_PARTIAL\_COPY 0x8000000D

Если кто-нибудь запрашивает первые байты перехваченной нами функции,

мы должны вызвать оригинальный код, а затем скопировать оригинальные
байты

(мы их сохранили) в буфер Buffer.

Теперь процесс не сможет определить, что функции перехвачены, чтением

памяти. Также, если вы отлаживаете перехватываченные функции, у
отладчика будут

проблемы. Он будет показывать оригинальные байты, но выполнять наш код.

Чтобы сделать скрытие совершенным, мы еще должны перехватить функцию

NtQueryVirtualMemory, которая используется для получения информации о

виртуальной памяти. Мы можем перехватить ее, чтобы предотвратить
обнаружение

выделенной нами памяти.

NTSTATUS NtQueryVirtualMemory(

IN HANDLE ProcessHandle,

IN PVOID BaseAddress,

IN MEMORY\_INFORMATION\_CLASS MemoryInformationClass,

OUT PVOID MemoryInformation,

IN ULONG MemoryInformationLength,

OUT PULONG ReturnLength OPTIONAL

);

MemoryInformationClass определяет тип возвращаемых данных. Нас

интересуют первые два типа.

\#define MemoryBasicInformation 0

\#define MemoryWorkingSetList 1

Для MemoryBasicInformation возвращается структура:

typedef struct \_MEMORY\_BASIC\_INFORMATION {

PVOID BaseAddress;

PVOID AllocationBase;

ULONG AllocationProtect;

ULONG RegionSize;

ULONG State;

ULONG Protect;

ULONG Type;

} MEMORY\_BASIC\_INFORMATION, \*PMEMORY\_BASIC\_INFORMATION;

Каждая секция памяти имеет размер - RegionSize и тип - Type. Свободная

память имеет тип MEM\_FREE.

\#define MEM\_FREE 0x10000

Если секция перед нашей имеет тип MEM\_FREE, следует прибавить размер

нашей секции к ее RegionSize. Если следующая секция также имеет тип
MEM\_FREE,

следует прибавить размер следующей секции к RegionSize.

Если секция перед нашей имеет другой тип, мы вернем MEM\_FREE для нашей

секции. Ее размер должен быть вычислен, учитывая также следующую секцию.

Для MemoryWorkingSetList возвращается структура:

typedef struct \_MEMORY\_WORKING\_SET\_LIST {

ULONG NumberOfPages;

ULONG WorkingSetList\[1\];

} MEMORY\_WORKING\_SET\_LIST, \*PMEMORY\_WORKING\_SET\_LIST;

NumberOfPages - количество элементов в WorkingSetList. Это число должно

быть уменьшено. Мы должны найти нашу секцию в WorkingSetList и
передвинуть

следующие записи на нее. WorkingSetList - массив DWORD\'ов, где старшие
20 бит -

это старшие 20 бит адреса секции, а младшие 12 бит содержат флаги.

Хэндлы

Вызов NtQuerySystemInformation с классом SystemHandleInformation дает

нам массив всех открытых хэндлов в структуре
\_SYSTEM\_HANDLE\_INFORMATION\_EX.

\#define SystemHandleInformation 0x10

typedef struct \_SYSTEM\_HANDLE\_INFORMATION {

ULONG ProcessId;

UCHAR ObjectTypeNumber;

UCHAR Flags;

USHORT Handle;

PVOID Object;

ACCESS\_MASK GrantedAccess;

} SYSTEM\_HANDLE\_INFORMATION, \*PSYSTEM\_HANDLE\_INFORMATION;

typedef struct \_SYSTEM\_HANDLE\_INFORMATION\_EX {

ULONG NumberOfHandles;

SYSTEM\_HANDLE\_INFORMATION Information\[1\];

} SYSTEM\_HANDLE\_INFORMATION\_EX, \*PSYSTEM\_HANDLE\_INFORMATION\_EX;

ProcessId указывает процесс, владеющий этим хэндлом. ObjectTypeNumber -

это тип хэндла. NumberOfHandles - количество записей в массиве
Information.

Скрытие одного элемента тривиально. Нужно сдвинуть последующие записи на
одну

и уменьшить значение NumberOfHandles. Сдвиг последующих записей
требуется,

потому что хэндлы в массиве сгруппированы по ProcessId. Это значит, что
все

хэндлы одного процесса расположены последовательно. И для каждого
процесса

значение поля Handle растет.

Вспомните структуру \_SYSTEM\_PROCESSES, которая возвращается этой

функцией с классом SystemProcessesAndThreadsInformation. Здесь мы можем

увидеть, что каждый процесс имеет информацию о количестве хэндлов в

HandleCount. Если мы хотим сделать все идеально, нам следует изменить
поле

HandleCount (в соответствии с тем, сколько хэндлов мы скрыли), когда
функция

будет вызвана с классом SystemProcessesAndThreadsInformation. Но эта
поправка

может требовать слишком много времени. Множество хэндлов открываются и

закрываются в течении очень короткого времени при нормальной работе
системы.

Легко может случиться, что количество хэндлов изменилось между двумя
вызовами

функции, поэтому нам не нужно изменять здесь поле HandleCount.

Именование хэндлов и получение типа

Скрытие хэндлов тривиально, но немного сложнее определить какие хэндлы

мы должны скрыть. Если у нас есть, например, скрытый процесс, нас
следует

скрыть все его хэндлы и все хэндлы связанные с ним. Скрытие хэндлов
этого

процесса также тривиально. Мы просто сравниваем ProcessId хэндла и PID
нашего

процесса, если они равны мы прячем хэндл. Но хэндлы других процессов
должны

быть проименованы прежде, чем мы сможем сравнивать их с чем-либо.
Количество

хэндлов в системе обычно очень велико, поэтому лучшее, что мы можем
сделать -

это сравнить тип хэндла прежде, чем попытаться проименовать его.
Именование

типов сохранит много времени для хэндлов, которые нас не интересуют.

Именование хэндла и типа хэндла может быть выполнено с помощью функции

NtQueryObject.

NTSTATUS ZwQueryObject(

IN HANDLE ObjectHandle,

IN OBJECT\_INFORMATION\_CLASS ObjectInformationClass,

OUT PVOID ObjectInformation,

IN ULONG ObjectInformationLength,

OUT PULONG ReturnLength OPTIONAL

);

ObjectHandle - хэндл, информацию о котором мы хотим получить,

ObjectInformationClass - тип информации, которая будет сохранена в буфер

ObjectInformation размером ObjectInformationLength байт.

Мы будем использовать классы ObjectNameInformation и

ObjectAllTypesInformation. Класс ObjectNameInfromation заполнит буфер

структурой OBJECT\_NAME\_INFORMATION, а класс ObjectAllTypesInformation

структурой OBJECT\_ALL\_TYPES\_INFORMATION.

\#define ObjectNameInformation 1

\#define ObjectAllTypesInformation 3

typedef struct \_OBJECT\_NAME\_INFORMATION {

UNICODE\_STRING Name;

} OBJECT\_NAME\_INFORMATION, \*POBJECT\_NAME\_INFORMATION;

Поле Name определяет имя хэндла.

typedef struct \_OBJECT\_TYPE\_INFORMATION {

UNICODE\_STRING Name;

ULONG ObjectCount;

ULONG HandleCount;

ULONG Reserved1\[4\];

ULONG PeakObjectCount;

ULONG PeakHandleCount;

ULONG Reserved2\[4\];

ULONG InvalidAttributes;

GENERIC\_MAPPING GenericMapping;

ULONG ValidAccess;

UCHAR Unknown;

BOOLEAN MaintainHandleDatabase;

POOL\_TYPE PoolType;

ULONG PagedPoolUsage;

ULONG NonPagedPoolUsage;

} OBJECT\_TYPE\_INFORMATION, \*POBJECT\_TYPE\_INFORMATION;

typedef struct \_OBJECT\_ALL\_TYPES\_INFORMATION {

ULONG NumberOfTypes;

OBJECT\_TYPE\_INFORMATION TypeInformation;

} OBJECT\_ALL\_TYPES\_INFORMATION, \*POBJECT\_ALL\_TYPES\_INFORMATION;

Поле Name определяет имя типа объекта, которое следует сразу после

каждой структуры OBJECT\_TYPE\_INFORMATION. Следующая структура

OBJECT\_TYPE\_INFORMATION расположена после этого имени и выровнена на
границу

четырех байт.

ObjectTypeNumber из структуры SYSTEM\_HANDLE\_INFORMATION - это индекс

в массиве TypeInformation.

Сложнее получить имя хэндла из другого процесса. Существуют два способа

сделать это. Первый состоит в том, чтобы скопировать хэндл функцией

NtDuplicateObject в наш процесс и затем проименовать его. Этот метод не

сработает для некоторых специфических типов хэндлов. Но он не
срабатывает

довольно редко, поэтому мы можем оставаться спокойными и использовать
его.

NtDuplicateObject(

IN HANDLE SourceProcessHandle,

IN HANDLE SourceHandle,

IN HANDLE TargetProcessHandle,

OUT PHANDLE TargetHandle OPTIONAL,

IN ACCESS\_MASK DesiredAccess,

IN ULONG Attributes,

IN ULONG Options

);

SourceProcessHandle - хэндл процесса, который владеет SourceHandle,

то есть хэндлом, который мы хотим скопировать. TargetProcessHandle - это
хэндл

процесса, в который мы хотим копировать. Это хэндл нашего процесса в
нашем

случае. TargetHandle - указатель, куда будет сохранена копия хэндла.
Параметр

DesiredAccess должен быть равен PROCESS\_QUERY\_INFORMATION, а
Attribures

и Options - нулю.

Второй способ именования, работающий со всеми хэндлами, состоит в

использовании системного драйвера. Исходный код этого метода доступен в

проекте OpHandle на моем сайте http://rootkit.host.sk.

Порты

Самый простой путь для перечисления открытых портов - это использование

функций AllocateAndGetTcpTableFromStack и
AllocateAndGetUdpTableFromStack,

и/или AllocateAndGetTcpExTableFromStack и
AllocateAndGetUdpExTableFromStack из

iphlpapi.dll. Ex-функции доступны начиная с Windows XP.

typedef struct \_MIB\_TCPROW {

DWORD dwState;

DWORD dwLocalAddr;

DWORD dwLocalPort;

DWORD dwRemoteAddr;

DWORD dwRemotePort;

} MIB\_TCPROW, \*PMIB\_TCPROW;

typedef struct \_MIB\_TCPTABLE {

DWORD dwNumEntries;

MIB\_TCPROW table\[ANY\_SIZE\];

} MIB\_TCPTABLE, \*PMIB\_TCPTABLE;

typedef struct \_MIB\_UDPROW {

DWORD dwLocalAddr;

DWORD dwLocalPort;

} MIB\_UDPROW, \*PMIB\_UDPROW;

typedef struct \_MIB\_UDPTABLE {

DWORD dwNumEntries;

MIB\_UDPROW table\[ANY\_SIZE\];

} MIB\_UDPTABLE, \*PMIB\_UDPTABLE;

typedef struct \_MIB\_TCPROW\_EX

{

DWORD dwState;

DWORD dwLocalAddr;

DWORD dwLocalPort;

DWORD dwRemoteAddr;

DWORD dwRemotePort;

DWORD dwProcessId;

} MIB\_TCPROW\_EX, \*PMIB\_TCPROW\_EX;

typedef struct \_MIB\_TCPTABLE\_EX

{

DWORD dwNumEntries;

MIB\_TCPROW\_EX table\[ANY\_SIZE\];

} MIB\_TCPTABLE\_EX, \*PMIB\_TCPTABLE\_EX;

typedef struct \_MIB\_UDPROW\_EX

{

DWORD dwLocalAddr;

DWORD dwLocalPort;

DWORD dwProcessId;

} MIB\_UDPROW\_EX, \*PMIB\_UDPROW\_EX;

typedef struct \_MIB\_UDPTABLE\_EX

{

DWORD dwNumEntries;

MIB\_UDPROW\_EX table\[ANY\_SIZE\];

} MIB\_UDPTABLE\_EX, \*PMIB\_UDPTABLE\_EX;

DWORD WINAPI AllocateAndGetTcpTableFromStack(

OUT PMIB\_TCPTABLE \*pTcpTable,

IN BOOL bOrder,

IN HANDLE hAllocHeap,

IN DWORD dwAllocFlags,

IN DWORD dwProtocolVersion;

);

DWORD WINAPI AllocateAndGetUdpTableFromStack(

OUT PMIB\_UDPTABLE \*pUdpTable,

IN BOOL bOrder,

IN HANDLE hAllocHeap,

IN DWORD dwAllocFlags,

IN DWORD dwProtocolVersion;

);

DWORD WINAPI AllocateAndGetTcpExTableFromStack(

OUT PMIB\_TCPTABLE\_EX \*pTcpTableEx,

IN BOOL bOrder,

IN HANDLE hAllocHeap,

IN DWORD dwAllocFlags,

IN DWORD dwProtocolVersion;

);

DWORD WINAPI AllocateAndGetUdpExTableFromStack(

OUT PMIB\_UDPTABLE\_EX \*pUdpTableEx,

IN BOOL bOrder,

IN HANDLE hAllocHeap,

IN DWORD dwAllocFlags,

IN DWORD dwProtocolVersion;

);

Есть и другой способ. Когда программа создает сокет и начинает его

слушать, она, конечно, имеет открытый хэндл для него и для открытого
порта.

Мы можем перечислить все открытые хэндлы в системе и послать им
специальный

буфер, используя функцию NtDeviceIoControlFile, чтобы определить хэндлы

для открытых портов. Это также даст нам информацию о портах. Так как
открытых

хэндлов очень много, мы будем тестировать только хэндлы с типом File и
именем

\\Device\\Tcp или \\Device\\Udp. Открытые порты имеют только этот тип и
имя.

Когда мы смотрели код перечисленных функций в iphlpapi.dll, мы

обнаружили, что эти функции вызывают NtDeviceIoControlFile и посылают

специальный буфер для того, чтобы получить список всех открытых портов в

системе. Это значит, что единственная функция, которую нужно перехватить
для

скрытия портов - это NtDeviceIoControlFile.

NTSTATUS NtDeviceIoControlFile(

IN HANDLE FileHandle

IN HANDLE Event OPTIONAL,

IN PIO\_APC\_ROUTINE ApcRoutine OPTIONAL,

IN PVOID ApcContext OPTIONAL,

OUT PIO\_STATUS\_BLOCK IoStatusBlock,

IN ULONG IoControlCode,

IN PVOID InputBuffer OPTIONAL,

IN ULONG InputBufferLength,

OUT PVOID OutputBuffer OPTIONAL,

IN ULONG OutputBufferLength

);

Интересующие нас параметры - это FileHandle (определяет хэндл

устройства), IoStatusBlock (указывает на переменную, которая получает

информацию о статусе выполнения и информацию об операции), IoControlCode

(число, определяющее тип устройства, метод, права доступа и функцию).

InputBiffer содержит данные размером InputBufferLength байт. И тоже
самое в

OutputBuffer и OutputbufferLength.

Netstat, OpPorts в WinXP, FPort в WinXP

Получение списка открытых портов в первую очередь использутеся,

например, в OpPorts и FPort в Windows XP, а также Netstat.

Программы вызывают NtDeviceIoControlFile дважды с IoControlCode равным

0x000120003. OutputBuffer заполняется после второго вызова. Имя
FileHandle

здесь всегда \\Device\\Tcp. InputBuffer различается для разных типов
вызова:

1\) Для получения массива из MIB\_TCPROW InputBuffer должен быть таким:

первый вызов:

0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

второй вызов:

0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x01 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

2\) Чтобы получить массив из MIB\_UDPROW:

первый вызов:

0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

второй вызов:

0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x01 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

3\) Чтобы получить массив из MIB\_TCPROW\_EX:

первый вызов:

0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

второй вызов:

0x00 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x02 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

4\) Чтобы получить массив из MIB\_UDPROW\_EX:

Первый вызов:

0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

Второй вызов:

0x01 0x04 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x02 0x00 0x00 0x00 0x01
0x00 0x00

0x02 0x01 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00 0x00
0x00 0x00

0x00 0x00 0x00 0x00

Вы можете заметить, что буферы различаются только в нескольких байтах.

Мы можем объяснить это.

Интересующие нас вызовы имеют в InputBuffer\[1\] 0x04 и, в основном,

InputBuffer\[17\] содержит 0x01. Только при таких входных данных мы
получим

в OutputBuffer нужные таблицы. Если мы хотим получить информацию о
TCP-портах,

нужно установить в InputBuffer\[0\] значение 0x00, или 0x01 для
получения

информации о UDP-портах. Если нам нужны Ex-таблицы (MIB\_TCPROW\_EX или

MIB\_UDPROW\_EX), нужно во втором вызове установить в Inputbuffer\[16\]
0x02.

Если мы перехватили вызов с этими параметрами, нужно просто изменить

выходной буфер. Чтобы получить количество строк в выходном буфере,
просто

разделите Information из IoStatusBlock на размер строки. Скрыть одну
строку

очень просто. Просто перезапишите ее последующими строками и удалить
последнюю

строку. Не забудьте изменить OutputBufferLength и IoStatusBlock.

OpPorts в Win2k и NT4, FPort в Win2k

Мы используем NtDeviceIoControlFile с IoControlCode равным 0x00210012,

чтобы определить, что хэндл с типом File и именем \\Device\\Tcp или
\\Device\\Udp -

это хэндл открытого порта.

Во-первых, мы сравним IoControlCode, а затем тип и имя хэндла. Если

он нас все еще интересует, мы проверим длину входного буфера, который
должен

быть равным длине структуры TDI\_CONNECTION\_IN. Ее длина 0x18. Выходной
буфер -

TDI\_CONNETION\_OUT.

typedef struct \_TDI\_CONNETION\_IN

{

ULONG UserDataLength,

PVOID UserData,

ULONG OptionsLength,

PVOID Options,

ULONG RemoteAddressLength,

PVOID RemoteAddress

} TDI\_CONNETION\_IN, \*PTDI\_CONNETION\_IN;

typedef struct \_TDI\_CONNETION\_OUT

{

ULONG State,

ULONG Event,

ULONG TransmittedTsdus,

ULONG ReceivedTsdus,

ULONG TransmissionErrors,

ULONG ReceiveErrors,

LARGE\_INTEGER Throughput

LARGE\_INTEGER Delay,

ULONG SendBufferSize,

ULONG ReceiveBufferSize,

ULONG Unreliable,

ULONG Unknown1\[5\],

USHORT Unknown2

} TDI\_CONNETION\_OUT, \*PTDI\_CONNETION\_OUT;

Конкретная реализация, того как определить то, что хэндл - это хэндл

открытого порта, доступна в исходном коде OpPorts на моем сайте

https://rootkit.host.sk. Сейчас нам необходимо скрыть определенные
порты. Мы

уже проверили InputBufferLength и IoControlCode. Теперь мы должны
проверить

RemoteAddressLength - для открытого порта всегда 3 или 4. Наконец, мы
должны

сравнить поле ReceivedTsdus из OutputBuffer, которое содержит порт в

сетевой форме, со списком портов, которые мы хотим скрыть. Мы можем
различать

TCP и UDP в соответствии с именем хэндла. Удалив OutputBuffer, изменив

IoStatusBlock и вернув значение STATUS\_INVALID\_ADDRESS, мы скроем
порт.

Окончание

Конкретная реализация описанных техник доступна в исходном коде

Hacker Defender Rootkit версии 1.0.0 на сайте http://rootkit.host.sk и
на

https://www.rootkit.com.

Возможно, я добавлю информацию о невидимости в Windows NT в будущем.

Новые версии документа также будут содержать улучшения описаных методов
и новые

комментарии.

Отдельное спасибо Ratter\'у, который дал мне много ноу-хау, которые были

необходимы для написания этой статьи и кода проекта Hacker Defender.

Все комментарии присылаете на holy\_father\@phreaker.net или на доску на

сайте http://rootkit.host.sk.

Взято из <https://forum.sources.ru>
