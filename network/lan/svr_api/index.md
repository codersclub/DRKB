---
Title: SVR API для непродвинутых
Author: Александр Терехов
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


SVR API для непродвинутых
=========================

_Специально для Королевства Delphi_

**Вступление...**

Для тех, кто считает мои примеры и статьи "плагиатом без зазрения
совести" ( были прецеденты от анонимных авторов), оговорюсь сразу: не я
придумал систему Windows и API-функции к ней, а также не я писал хелп по
этому поводу. Но это не значит, что использование полученной оттуда
информации - есть плагиат, так как вся информация заранее застолблена
авторским правом Б.Гейтса & сотоварищи. А раз она принадлежит им и
только им, то какое-либо ее использование ни как не может подпадать под
понятие "плагиат".

Иное дело алгоритмы...

Итак хелп.

**Предыстория**

Как-то потребовалось программным способом открыть доступ к сетевому
ресурсу. После прочтения (в очередной раз) хелпа от Дельфи стало ясно,
что сетевым администрированием занимаются функции семейства Net\*. А в
частности для открытия, закрытия доступа к сетевому ресурсу, а также
получения или изменения информации о нем применяются функции
подсемейства NetShare\*. Однако, как написано в хелпе, все эти функции
работают только под WinNT. К сожалению...

Но раз Win\'9x открывает (закрывает) доступ, значит, можно сделать то же
самое и программно. И тут начались поиски.

В хелпе сказано, что для Си++ надо применять заголовочный модуль
LmShare.h, в котором даны прототипы функций библиотеки netapi32.dll.
Посмотрев эту библиотеку утилитой tdump.exe (лежит в директории
Delphi\_X\\Bin), я увидел, что библиотека netapi32.dll (для Win\'9x)
кроме одной экспортируемой функции netbios более ничего не содержит.
Далее включаю обычный поиск текста "NetShareAdd" в файлах \*.dll.
Поиск выдал результат - среди нескольких библиотек эту строку содержит и
библиотека svrapi.dll.

Следуя проторенным путем, т.е. через tdump.exe, увидел, что эта
библиотека содержит почти все экспортируемые функции с названиями Net\*.
Ура! Место, где "собака порылась" найдено! Осталось только эту собаку
откопать.

Ясно, что без знания прототипов этих функций, сами по себе их названия -
пустой хлам. Включаю поиск в Интернет строки "svrapi". И вот он,
заветный заголовочный модуль! SvrApi.pas. Лежит, голубчик на JEDI!
Написал его Petr Vones, за что ему большое спасибо! В этом модуле даны
прототипы следующих классов Net-функций:

- ACCESS
- SHARE
- SESSION
- CONNECTION
- FILE
- SERVER
- SECURITY

Описание Net-функций приведено в хелпе от Дельфи. Их работа одинакова
как для WinNT, так и для Win\'9x. Правда, для Win\'9x следует
использовать несколько другие аргументы. О чем ниже и пойдет речь.

Все семейство NetShare\*, а это:

- NetShareAdd - открывает доступ к сетевому ресурсу
- NetShareDel - закрывает доступ к сетевому ресурсу
- NetShareEnum - показывает количество и свойства ресурсов с открытым доступом
- NetShareGetInfo - дает полную информацию об открытом сетевом ресурсе
- NetShareSetInfo - меняет некоторые значения открытого сетевого ресурса

здесь я описывать не буду, т.к. намереваюсь выложить примеры для работы
со всеми функциями NetShare\* на своем сайте. Опишу только одну -
NetShareAdd

Итак **функция NetShareAdd**. Вот ее прототип:

    function NetShareAdd(const pszServer: PChar; sLevel: SmallInt; pbBuffer:
             Pointer; cbBuffer: Word): NET_API_STATUS; stdcall;

Описание аргументов функции будут даны ниже. Сейчас рассмотрим, как
следует подключать эту функцию.

**Подключение внешней функции**

Если не вдаваться в подробности, то в подключении внешних функций
оказывается нет ничего сложного. В Unit.pas после описания класса TForm
и до клаузы implementation следует написать:

    function NetShareAdd(ServerName: PChar; Level: Integer;
                         pbBuffer: Pointer;
                         BufferSize: Integer): Integer;
                         stdcall; external 'svrapi.dll';

На что следует обратить внимание. Во-первых, я вольно заменил типы
некоторых переменных на более привычный Integer (хотя по большому счету
этого делать не следует). Во-вторых, stdcall - это способ передачи
данных через стек, применяемый для Паскаля. И, в-третьих, external
\'svrapi.dll\' - означает, что функция находится во внешней библиотеке с
названием svrapi.dll.

Теперь к аргументам.

**Аргументы функции**

`ServerName` - сетевое имя компьютера, для локального можно писать Nill.

Что можно сказать об этом аргументе. Для работы с локальной машиной
проблем не возникает. Например, если сетевое имя машины Toshiba, то в
этот параметр надо писать \'\\\\Toshiba\' или указать Nill. А вот для
сетевой машины возникают проблемы. Испытывая NetShareAdd в сети, я
постоянно результатом работы функции получал значение 65, что означает -
"Нет доступа к сети". Оказалось, чтобы открыть доступ к сети для
NetShare-функций, надо "Разрешить удаленное управление этим сервером"
(делается в "Пароли" из "Панели управления"). Тогда директории
Windows присваивается сетевое имя ADMIN$ и после подключения этого
имени в качестве сетевого диска, "сезам" открывается. Все это можно
сделать программно: с помощью описываемой функции открыть доступ с
именем ADMIN$ к любой директории, в том числе несуществующей (см. ниже)
и с помощью одной из трех WNetAddConnection подключить сетевой диск для
этого имени. Тогда все сработает на ура.

`Level` - уровень администрирования. Для WinNT применяют три уровня 1,2 и
502, для Win\'9x следует применять уровень 50.

`pbBuffer` - указатель на структуру, в которую будем заносить все данные,
необходимые для открытия доступа к ресурсу. На этой структуре следует
остановиться более подробно. Вот она сама:

    type
      TShareInfo50 = packet record
        shi50_netname: array[0..LM20_NNLEN] of Char; //сетевое имя
        shi50_type: Byte; //тип ресурса
        shi50_flags: Short; //флаг доступа
        shi50_remark: PChar; // комментарий
        shi50_path: PChar; // путь к ресурсу
        shi50_rw_password: array[0..SHPWLEN] of Char; //пароль полного доступа
        shi50_ro_password: array[0..SHPWLEN] of Char;
        //пароль "только чтение" доступа
      end;

`shi50_netname` - сетевое имя, по обращению к которому, будет доступен
сетевой ресурс. Сетевое имя должно быть уникальным. Константа
LM20\_NNLEN имеет значение 12, т.е. сетевое имя не должно быть более
12-ти символов.

`shi50_type` - тип ресурса, может иметь следующие значения:

- `STYPE_DISKTREE = 0;` - будем открывать доступ к директории;
- `STYPE_PRINTQ = 1;` - будем открывать доступ к принтеру;

Есть еще две константы, но честно говоря, я их не тестировал:

- `STYPE_DEVICE = 2;` - будем открывать доступ к коммуникационному устройству;
- `STYPE_IPC = 3;` - открывает доступ к межпроцессорной коммуникации.

`shi50_flags` - флаг доступа, может иметь следующие значения:

- `SHI50F_RDONLY = $0001;` - доступ только на чтение;
- `SHI50F_FULL = $0002;` - полный доступ;
- `SHI50F_DEPENDSON = SHI50F_RDONLY or SHI50F_FULL;` - доступ в зависимости от введенного пароля;
- `SHI50F_ACCESSMASK = SHI50F_RDONLY or SHI50F_FULL` - доступ в зависимости от введенного пароля;
- `SHI50F_PERSIST = $0100;` - ресурс будет записан в Registry и при
перезагрузке компьютера доступ будет открываться в автомате. Для Win\'95
почему-то доступ запоминается и без указания этого параметра.
- `SHI50F_SYSTEM = $0200;` - в проводнике не будет видно, что доступ к этому ресурсу открыт.

`shi50_remark` - комментарий

`shi50_path` - полный физический путь к устройству. Здесь надо учесть следующее:

Если путь указать строчными (маленькими) буквами, то в проводнике не
будет видно, что доступ к устройству открыт.

Если указать несуществующий путь, то доступ к такому устройству все
равно будет открыт. Например, если открыть доступ к несуществующей папке
C:\\TEST333 и присвоить ей сетевое имя TEST66, то в сетевом окружении
будет видно сетевое имя TEST66. Если затем создать папку с именем
TEST333, то под этой папкой появится "синяя ручка".

`shi50_rw_password` - пароль для полного доступа;

`shi50_ro_password` - пароль "только чтение", где SHPWLEN = 8, т.е.
максимальное количество символов в пароле с учетом символа под номером 0
составляет 9 штук.

И наконец, последний аргумент

`BufferSize` - размер буфера, в котором находятся необходимые для открытия
доступа данные.

Теперь перейдем к значению, возвращаемому функцией NetShareAdd.

**Результат функции**

В случае успешного выполнения функции возвращается 0. В случае неудачи
возвращается числовое значение. Обработка этого значения в большинстве
случаев позволяет локализировать причину неудачи.

Для функции NetShareAdd предлагаются следующие виды ошибок (в моем
вольном переводе):

    NO_ERROR = 0; 'Все в порядке'

    // из LmErr.pas:
    NERR_BASE = 2100; базовая ошибка для NERR_;
    NERR_NetNotStarted = NERR_BASE + 2 'Сеть недоступна';
    NERR_UnknownServer = NERR_BASE + 3 'Неизвестный сервер';
    NERR_ServerNotStarted = NERR_BASE + 14 'Сервер не работает';
    NERR_UnknownDevDir = NERR_BASE + 16 'Сетевое устройство отсутствует';
    NERR_RedirectedPath = NERR_BASE + 17 'Переназначенное устройство';
    NERR_DuplicateShare = NERR_BASE + 18 'Сетевое имя уже существует';
    NERR_BufTooSmall = NERR_BASE + 23 'Слишком маленький буфер для данных!';
    NERR_NetNameNotFound = NERR_BASE + 210 'Сетевое имя не существует';
    NERR_InvalidComputer = NERR_BASE + 251 'Неверное имя компьютера';
    NERR_ShareNotFound = NERR_BASE + 292 'Сетевое устройство не обнаружено';

Однако бывают и другие ошибки. Почему-то функции
SysErrorMessage(GetLastError) и WNetGetLastError при работе с NetShare\*
(по крайней мере у меня) не срабатывают, поэтому значения ошибок, коды
которых менее 2100, я взял из ошибок, общих для всей операционной
системы. (из Windows.pas:)

    ERROR_NOT_ENOUGH_MEMORY = 8 'Недостаточно памяти';
    ERROR_BAD_NETPATH = 53 'Неверное сетевое имя';
    ERROR_NETNAME_DELETED = 64 'Сетевой ресурс более недоступен';
    ERROR_NETWORK_ACCESS_DENIED = 65 'Отсутствует доступ к сети';
    ERROR_BAD_DEV_TYPE = 66 'Неверный тип сетевого ресурса';
    ERROR_BAD_NET_NAME = 67 'Не найдено сетевое имя';
    ERROR_INVALID_PARAMETER = 87 'Неверный параметр';
    ERROR_INVALID_LEVEL = 124 'Неверный уровень администрирования';

Т.е. если результатом функции возвращается число больше, чем 2100, то
смотри модуль LmErr.pas, если меньше - то модуль Windows.pas.

На этом вроде все. Но, лучше один раз увидеть, чем... Поэтому
посмотрим, как все работает на практике.

**Пример работы NetShareAdd**

Для директории C:\\Temp локальной машины откроем доступ с именем
"TEST", паролем для чтения "QWE", для полного доступа "ASDF",
комментарием "This is a network machine\'s commentary", с
автоматическим открытием доступа при перезагрузке компьютера. И заодно
закроем доступ.

На новую форму следует положить две кнопочки и привести вид Unit1.pas в
соответствие с ниже приведенным кодом.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    //подключаем две функции из библиотеки svrapi.dll
    function NetShareAdd(Servername: PChar; Level: Integer; Buffer: Pointer;
      BufferSize: Integer): Integer; stdcall; external 'svrapi.dll';
    function NetShareDel(Servername: PChar; NetName: PChar; Reserved: DWORD): DWORD;
    stdcall; external 'svrapi.dll';
     
    //необходимые константы
    const
      {см. LmCons.pas}
      LM20_NNLEN = 12;
      SHPWLEN = 8;
      SHI50F_RDONLY = 1;
      SHI50F_FULL = 2;
      STYPE_DISKTREE = 0;
      SHI50F_PERSIST = $0100;
      SHI50F_SYSTEM = $0200;
      {см. LmErr.pas}
      NERR_BASE = 2100;
      NERR_NetNotStarted = NERR_BASE + 2;
      NERR_UnknownServer = NERR_BASE + 3;
      NERR_ServerNotStarted = NERR_BASE + 14;
      NERR_UnknownDevDir = NERR_BASE + 16;
      NERR_RedirectedPath = NERR_BASE + 17;
      NERR_DuplicateShare = NERR_BASE + 18;
      NERR_BufTooSmall = NERR_BASE + 23;
      NERR_NetNameNotFound = NERR_BASE + 210;
      NERR_InvalidComputer = NERR_BASE + 251;
      NERR_ShareNotFound = NERR_BASE + 292;
      //формируем тип для записи с необходимыми параметрами
    type
      TShareInfo50 = record
        shi50_netname: array[0..LM20_NNLEN] of Char; //сетевое имя
        shi50_type: Byte; //тип ресурса
        shi50_flags: Short; //флаг доступа
        shi50_remark: PChar; // комментарий
        shi50_path: PChar; // путь к ресурсу
        shi50_rw_password: array[0..SHPWLEN] of Char; //пароль полного доступа
        shi50_ro_password: array[0..SHPWLEN] of Char;
          //пароль "только чтение" доступа
      end; {Record}
    var
      Form1: TForm1;
    implementation
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      info50: TShareInfo50;
      rc, cb: Integer;
      ServerName, Path, NetName, ErrMes, ErrCap, Comment: string;
      MessIconBtn: Byte;
    begin
      //установим необходимые параметры
      ServerName := '';
      Path := 'C:\TEMP';
      NetName := 'TEST';
      Comment := 'This is a network machines commentary';
      //заполним буфер
      FillChar(info50, sizeof(info50), 0);
      with info50 do
      begin {With}
        StrCopy(shi50_netname, PChar(NetName)); //сетевое имя
        shi50_type := STYPE_DISKTREE; //подключать будем диск
        shi50_remark := PChar(Comment); //комментарий
        shi50_flags := SHI50F_RDONLY or SHI50F_FULL //доступ определяется паролем
        or SHI50F_PERSIST; //и пишется в Registry
        shi50_path := PChar(Path); //путь
        StrPCopy(shi50_rw_password, 'ASDF'); //пароль для полного доступа
        StrPCopy(shi50_ro_password, 'QWE'); // пароль для "только чтение"
      end; {With}
      //установим размер буфера
      cb := sizeof(info50);
      //основная функция
      rc := NetShareAdd(PChar(ServerName), 50, @info50, cb);
      //сформируем текст сообщений об успехе или ошибках
      ErrMes := 'Доступ к устройству "' + NetName + '" открыт!';
      ErrCap := 'Все в порядке!';
      MessIconBtn := MB_OK or MB_ICONINFORMATION;
      //проверка ошибок
      if rc <> 0 then
      begin {ошибка}
        ErrCap := 'Ошибка!';
        MessIconBtn := MB_OK or MB_ICONERROR;
        case rc of
          //расшифровка ошибок
          ERROR_NOT_ENOUGH_MEMORY: ErrMes := 'Недостаточно памяти';
          ERROR_BAD_NETPATH: ErrMes := '"' + Servername +
            '" - неверное сетевое имя!';
          ERROR_NETNAME_DELETED: ErrMes := 'Сетевой ресурс более недоступен';
          ERROR_NETWORK_ACCESS_DENIED: ErrMes := 'Отсутствует доступ к сети';
          ERROR_BAD_DEV_TYPE: ErrMes := 'Неверный тип сетевого ресурса';
          ERROR_BAD_NET_NAME: ErrMes := 'Не найдено сетевое имя';
          ERROR_INVALID_PARAMETER: ErrMes := 'Неверный параметр';
          ERROR_INVALID_LEVEL: ErrMes := 'Неверный уровень администрирования';
     
          NERR_InvalidComputer: ErrMes := 'Неверное имя компьютера!';
          NERR_UnknownServer: ErrMes := 'Неизвестный сервер!';
          NERR_UnknownDevDir: ErrMes := 'Устройство "' + Path + '" отсутствует!';
          NERR_ServerNotStarted: ErrMes := 'Сервер не работает!';
          NERR_RedirectedPath: ErrMes := 'Переназначенный путь!';
          NERR_DuplicateShare: ErrMes := 'Сетевое имя "' + NetName +
            '" уже существует!';
          NERR_BufTooSmall: ErrMes := 'Слишком маленький буфер для данных!';
        else
        end; {Case}
      end; {ошибка}
      //выдадим сообщение
      MessageBox(Application.Handle, PChar(ErrMes), PChar(ErrCap), MessIconBtn);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      rc: DWord;
      Servername, NetName, ErrMes, ErrCap: string;
      MessIconBtn: Byte;
    begin
      ServerName := '';
      NetName := 'TEST';
      rc := NetShareDel(PChar(ServerName), PChar(NetName), 0);
      ErrMes := 'Доступ к устройству "' + NetName + '" закрыт!';
      ErrCap := 'Все в порядке!';
      MessIconBtn := MB_OK or MB_ICONINFORMATION;
     
      if rc <> 0 then
      begin {ошибка}
        //ошибка
        ErrCap := 'Ошибка!';
        MessIconBtn := MB_OK or MB_ICONERROR;
     
        case rc of
          //расшифровка ошибок
          ERROR_BAD_NETPATH: ErrMes := '"' + Servername +
            '" - неверное сетевое имя!';
          ERROR_INVALID_PARAMETER: ErrMes := 'Неверный параметр!';
          NERR_NetNotStarted: ErrMes := 'Сеть недоступна!';
          NERR_ServerNotStarted: ErrMes := 'Сервер не работает!';
          NERR_NetNameNotFound: ErrMes := 'Устройство не существует!';
          NERR_ShareNotFound: ErrMes := 'Сетевое имя "' + NetName + '" не найдено!';
        else
          //смотри ошибки для NetShareAdd или
          ErrMes := 'Неизвестная сетевая ошибка!';
        end; {Case}
      end; {ошибка}
      MessageBox(Application.Handle, PChar(ErrMes), PChar(ErrCap), MessIconBtn);
    end;
     
    end.
     
     

Итак, о чем пойдет речь. Мы уже умеем открывать доступ к сетевому
ресурсу. Теперь хотелось бы получить информацию об уже открытых сетевых
ресурсах. Для этих целей в SvrAPI применяется функция NetShareGetInfo.
Однако аргументы этой функции предполагают, что мы уже знаем имя
удаленной машины и имена имеющиеся в ней доступных сетевых устройств.
Однако, это не всегда так... Можно, конечно, все посмотреть
стандартными средствами Windows, например, проводником или открыть
сетевое окружение... Да по большому счету, все что мы пытаемся
напрограммировать уже давно сделано... Ну, да ладно, вернемся к нашим
баранам. Для наглядности изобретем еще один велосипед - напишем
небольшую программку позволяющую получать значения, которые приобретает
сетевое устройство при открытии к нему доступа.

- Первый предварительный шаг - получение имен доступных сетевой машины.
- Второй предварительный шаг - получение имен доступных сетевых устройств.
- Постучимся в двери - третий предварительный шаг. Ну и, наконец,
- последнее - получение информации о конкретном сетевом устройстве.

**Шаг первый. Получение имен доступных сетевых машин**

Для получения имен доступных сетевых машин воспользуемся функцией
SHBrowseForFolder. Эта функция проживает в модуле ShlObj.pas, модуль
автоматически не подключается, поэтому в клаузу Uses надо "ручками"
добавить ShrObj. Сама функция имеет всего один аргумент - указатель на
структуру типа TBrowseInfo.

    TBrowserInfo = record
      hwndOwner: Integer; //хендл "хозяина" диалогового окна
      pidlRoot: PItemIDList; //указатель на спец.структуру - о ней ниже
      pszDisplayName: PChar; //сюда получим имя компьютера
      lpszTitle: PChar; //заголовок диалогового окна
      ulFlags: Integer; //флаг, указывающий, что именно покажет диалоговое окно
      lpfn: TFNBFFCallBack; //адрес процедуры, обрабатывающей действия пользователя - Nil
      lParam: Integer; //доп. параметр для lpfn - 0
      iImage: Integer; //номер иконки в списке системных иконок
    end;

Чтобы получить pidlRoot надо использовать еще одну функцию -
SHGetSpecialFolderLocation

Ну, начали!

    function TForm1.GetComputerNetName: string;
    var
      RootItemIDList: PItemIDList;
      //идентификатор объекта в пространстве имен проводника
      BrowseInfo: TBrowseInfo; //структура, в которой содержится информация о диалоге
      Buffer: PChar; //сюда получим имя компьютера
    begin
      Result := '';
      //получим нужный идентификатор PItemIDList, CSIDL_NETWORK - в сетевом окружении
      if not (SHGetSpecialFolderLocation(0, CSIDL_NETWORK, RootItemIDList) =
        NO_ERROR) then
        Exit;
      //подготовим буфер, в который получим имя компьютера
      GetMem(Buffer, Max_Path);
      FillChar(BrowseInfo, SizeOf(BrowseInfo), 0);
      //подготовим структуру TBrowseInfo
      with BrowseInfo do
      begin {With BrowseInfo}
        hwndOwner := Application.Handle; //хозяин окна - наше приложение
        pidlRoot := RootItemIDList;
          //полученный ранее идентификатор объекта в списке объектов проводника
        pszDisplayName := Buffer; //имя компьютера будем принимать в Buffer
        lpszTitle := 'Подключенные компьютеры'; //заголовок диалога
        ulFlags := BIF_BROWSEFORCOMPUTER; //будут показаны имена только компьютеров
      end; {With BrowseInfo}
      //выполним нужную функцию
      if SHBrowseForFolder(BrowseInfo) = nil then
        Exit;
      Result := string(Buffer); //вот оно - сетевое имя компьютера
      FreeMem(Buffer);
    end;

**Шаг второй. NetShareEnum - получение имен сетевых ресурсов**

Зная доступное сетевое имя машины, с помощью функции NetShareEnum мы
можем получить список имен доступных сетевых устройств этой машины.
Вышеуказанная функция помещает информацию о сетевом ресурсе в массив
элементов типа TShareInfo50. Размерность этого массива определяется
константой MaxNetArrayItems равной 512, т.е. максимально возможное число
открытых сетевых ресурсов для одной машины не может превышать 512. Вот
прототип этой функции:

    function NetShareEnum(const pszServer: PChar; sLevel: SmallInt;
      pbBuffer: Pointer; cbBuffer: Word; var pcEntriesRead: Word;
      var pcTotalAvail: Word): DWORD;

где:

`pszServer` - сетевое имя машины;

`sLevel` - уровень доступа, для Win\'9X всегда 50;

`pbBuffer` - указатель буфера, в который будет помещен массив с
информацией о сетевых ресурсах

`cbBuffer` - размер этого буфера;

`pcEntriesRead` - количество доступных сетевых ресурсов;

`pcTotalAvail` - общее количество байт, считанных функцией.

Так как мы рассматриваем работу NetShare* функций на конкретном
примере, немного модифицируем функцию, в нашем случае процедуру,
получающую информацию о доступных сетевых ресурсах. В качестве аргумента
нашей процедуры передадим переменную типа TStrings, в которую будем
помещать имена сетевых ресурсов.

    procedure TForm1.FillShareEnum(Items: TStrings);
    var
      ShareInfo: array[0..MaxNetArrayItems - 1] of TShareInfo50;
      EntriesRead, TotalAvial: Word;
      Res: Integer;
      N: Integer;
    begin
      Items.Clear; //почистим Items
      FillChar(ShareInfo, SizeOf(ShareInfo), #0); //заполним буфер нолями
      Res := NetShareEnum(PChar('\\' + edComputerNetName.Text), 50, @ShareInfo,
        SizeOf(ShareInfo),
        EntriesRead, TotalAvial); //имя сетевой машины возьмем из строки ввода,
      //предварительно озаглавив его двумя обратными слэшами
      if Res = No_Error then //функция выполнена без ошибок
        for N := 0 to EntriesRead - 1 do
          //пройдемся по буферу считанных имен ресурсов
          if not (string(ShareInfo[N].shi50_netname) = '') then
            Items.Add(string(ShareInfo[N].shi50_netname));
              //добавим имя машины в список
    end;

В принципе, обрабатывая ShareInfo[N], мы уже можем видеть все
параметры открытого доступа для сетевого ресурса. На этом можно было бы
и остановиться. Но... пойдем дальше.

**Шаг третий. NetShareGetInfo - получение информации о сетевом ресурсе.**

Зная имя сетевой машины и имя конкретного сетевого ресурса, мы можем
получить достаточно подробную информацию об этом ресурсе, но не более,
чем может это предоставить переменная TShareInfo50, описание которой
дано в первой статье. Функция NetShareGetInfo в отличие от ранее
описанной имеет одну особенность - мы должны заранее указать размер
считываемых байт. Для этого пойдем на небольшую хитрость - сначала
посмотрим сколько байт в памяти занимает информация о ресурсе, а затем
укажем это количество в качестве размерности буфера. Ну и напишем нашу
функцию с учетом конкретной прикладной задачи. В аргументы функции
поместим имя машины и имя ресурса, а в качестве результата выдадим
определенную нами (см. листинг программы) переменную типа TShareEvent.

Но, вначале прототип самой функции:

    function NetShareGetInfo(const pszServer: PChar; const pszNetName: PChar;
      sLevel: SmallInt; pbBuffer: Pointer; cbBuffer: Word;
      var pcTotalAvail: Word): DWORD;

где:

`pszServer` - имя сетевой машины;

`pszNetName` - имя сетевого ресурса;

`sLevel` - уровень доступа;

`pbBuffer` - указатель на буфер, в нашем случае указатель на буфер типа TShareInfo50;

`cbBuffer` - размерность буфера;

`pcTotalAvail` - количество считанных байт.

А теперь пример ее использования.

    function TForm1.GetShareInfo(ComputerNetName, ResourceNetName: string):
      TShareEvent;
    var
      pbBuffer: ^TShareInfo50; //указатель на буфер
      Buf: TShareInfo50; //сам буфер
      Res: Integer;
      pcTotalAvail: Word; //количество считанных байт
    begin
      with Result do //почистим результат функции
      begin
        res := 0;
        ReadOnlyPassword := '';
        FullAccessPassword := '';
        Comments := '';
        Path := '';
      end;
      FillChar(Buf, SizeOf(Buf), #0); //заполним буфер нолями
      //ничего не укажем о нашем буфере и выполним функцию, в результате чего
      //получим в переменную pcTotalAvail количество считанных байт.
      NetShareGetInfo(PChar(ComputerNetName), PChar(ResourceNetName), 50, nil, 0,
        pcTotalAvail);
      //инициализируем буферный указатель и дадим ему нужное количество памяти
      GetMem(pbBuffer, pcToTalAvail);
      //поместим в буфер имя сетевого ресурса, зачем не знаю - имя мы уже и так
      //указываем, но без этого функция почему-то не работает, по крайней мере у меня
      StrPCopy(pbBuffer^.shi50_netname, ResourceNetName);
      //выполним функцию еще раз уже указав параметры буфера
      Res := NetShareGetInfo(PChar(ComputerNetName), PChar(ResourceNetName), 50,
        pbBuffer, pcTotalAvail, pcTotalAvail);
      if Res = 0 then //все в порядке
      begin
        //передадим данные из указателя в "обычную" переменную
        Buf := pbBuffer^;
        //заполним результат полученными значениями
        Result.ReadOnlyPassword := string(Buf.shi50_ro_password);
        Result.FullAccessPassword := string(Buf.shi50_rw_password);
        Result.Comments := string(Buf.shi50_remark);
        Result.Path := string(Buf.shi50_path);
      end;
      //освободим указатель
      FreeMem(pbBuffer);
    end;

Все бы хорошо. Но... есть одно "но".

Сетевая машина не покажет Вам
параметры своих сетевых устройств, пока не услышит "Сезам, откройся!".

**Шаг четвертый. "Сезам, откройся! Я - магический ADMIN$".**

Вообще-то в рассматриваемой программе это не четвертый шаг, а второй. Но
для описания работы программы будет лучше, если будем ее рассматривать
именно в такой последовательности. Да, еще - рассказ о сетевом имени
ADMIN$ был в предыдущей статье, поэтому - сразу к делу.

    procedure TForm1.ConnectAdmin;
    var
      CompName: string;
      Res: Integer;
      lpNetResource: TNetResource;
      ComputerName: array[0..MAX_COMPUTERNAME_LENGTH] of Char;
      BufSize: Integer;
    begin
      //получим имя локальной машины
      BufSize := MAX_COMPUTERNAME_LENGTH + 1;
      GetComputerName(@ComputerName, BufSize);
      CompName := string(ComputerName);
      //если имя локальной машины совпадает с сетевым именем машины,
      //значит идет запрос о сетевом ресурсе локальной машины -
      //в этом случае ADMIN$ не нужен
      if AnsiUpperCase(CompName) = AnsiUpperCase(edComputerNetName.Text) then
        Exit;
      //заполним нолями значение указателя
      ZeroMemory(@lpNetResource, SizeOf(lpNetResource));
      //укажем нужные значения
      with lpNetResource do
      begin
        dwType := RESOURCETYPE_ANY;
        lpRemoteName := '';
        lpRemoteName := PChar('\\' + edComputerNetName.Text + '\ADMIN$' + #0);
      end;
      //Сезам, откройся!
      Res := WNetAddConnection3(Application.Handle, lpNetResource, nil, nil,
        CONNECT_INTERACTIVE);
      //Сезам, к сожалению не открылся...
      if not (Res = NO_ERROR) then
      begin
        ShowMessage('Without connected resource ''ADMIN$'' a work impossible!');
        Application.Terminate;
      end;
    end;

**Шаг пятый и последний. Листинг программы.**

Что надо положить на форму смотрите в описании TForm1 = class(TForm) или
откройте вложенный в качестве примера проект программы.

    unit Unit1;
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ShlObj, Buttons;
    //необходимые константы
    const
      LM20_NNLEN = 12;
      SHPWLEN = 8;
      SHI50F_RDONLY = 1;
      SHI50F_FULL = 2;
      STYPE_DISKTREE = 0;
     
      MaxNetArrayItems = 512;
     
      //формируем тип для записи с необходимыми параметрами
    type
      //для Win'9x
      TShareInfo50 = packed record
        shi50_netname: array[0..LM20_NNLEN] of Char; //сетевое имя
        shi50_type: Byte; //тип ресурса
        shi50_flags: Short; //флаг доступа
        shi50_remark: PChar; // комментарий
        shi50_path: PChar; // путь к ресурсу
        shi50_rw_password: array[0..SHPWLEN] of Char; //пароль полного доступа
        shi50_ro_password: array[0..SHPWLEN] of Char;
          //пароль "только чтение" доступа
      end;
     
      TShareEvent = record //информация о сетевом ресурсе
        Res: Integer;
        ReadOnlyPassword: string;
        FullAccessPassword: string;
        Comments: string;
        Path: string;
      end;
     
      TForm1 = class(TForm)
        edComputerNetName: TEdit;
        Button1: TButton;
        ComboBox1: TComboBox;
        BitBtn1: TBitBtn;
        BitBtn2: TBitBtn;
        lbReadOnlyPassword: TLabel;
        edReadOnlyPassword: TEdit;
        lbFullAccessPassword: TLabel;
        edFullAccessPassword: TEdit;
        lbComments: TLabel;
        edComments: TEdit;
        lbPhysicalPath: TLabel;
        edPhysicalPath: TEdit;
        Label1: TLabel;
        Label2: TLabel;
        procedure Button1Click(Sender: TObject);
        procedure BitBtn1Click(Sender: TObject);
        procedure BitBtn2Click(Sender: TObject);
      private
        { Private declarations }
        procedure FillShareEnum(Items: TStrings);
        function GetComputerNetName: string;
        function GetShareInfo(ComputerNetName, ResourceNetName: string):
          TShareEvent;
        procedure ConnectAdmin;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
    function NetShareGetInfo(const pszServer: PChar; const pszNetName: PChar;
      sLevel: SmallInt; pbBuffer: Pointer; cbBuffer: Word;
      var pcTotalAvail: Word): DWORD; stdcall; External 'svrapi.dll' name
        'NetShareGetInfo';
    function NetShareEnum(const pszServer: PChar; sLevel: SmallInt;
      pbBuffer: Pointer; cbBuffer: Word; var pcEntriesRead: Word;
      var pcTotalAvail: Word): DWORD; stdcall; external 'svrapi.dll';
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.ConnectAdmin;
    var
      CompName: string;
      Res: Integer;
      lpNetResource: TNetResource;
      ComputerName: array[0..MAX_COMPUTERNAME_LENGTH] of Char;
      BufSize: Integer;
    begin
      //получим имя локальной машины
      BufSize := MAX_COMPUTERNAME_LENGTH + 1;
      GetComputerName(@ComputerName, BufSize);
      CompName := string(ComputerName);
      //если имя локальной машины совпадает с сетевым именем машины,
      //значит идет запрос о сетевом ресурсе локальной машины -
      //в этом случае ADMIN$ не нужен
      if AnsiUpperCase(CompName) = AnsiUpperCase(edComputerNetName.Text)ThenExit;
      //заполним нолями значение указателя
      ZeroMemory(@lpNetResource, SizeOf(lpNetResource));
      //укажем нужные значения
      with lpNetResource do
      begin
        dwType := RESOURCETYPE_ANY;
        lpRemoteName := '';
        lpRemoteName := PChar('\\' + edComputerNetName.Text + '\ADMIN$' + #0);
      end;
      //Сезам, откройся!
      Res := WNetAddConnection3(Application.Handle, lpNetResource, nil, nil,
        CONNECT_INTERACTIVE);
      //Сезам, к сожалению не открылся...
      if not (Res = NO_ERROR) then
      begin
        ShowMessage('With out connected resource ''ADMIN$'' a work impossible!');
        Application.Terminate;
      end;
    end;
     
    function TForm1.GetShareInfo(ComputerNetName, ResourceNetName: string):
      TShareEvent;
    var
      pbBuffer: ^TShareInfo50; //указатель на буфер
      Buf: TShareInfo50; //сам буфер
      Res: Integer;
      pcTotalAvail: Word; //количество считанных байт
    begin
      with Result do //почистим результат функции
      begin
        res := 0;
        ReadOnlyPassword := '';
        FullAccessPassword := '';
        Comments := '';
        Path := '';
      end;
      FillChar(Buf, SizeOf(Buf), #0); //заполним буфер нолями
      //ничего не укажем о нашем буфере и выполним функцию, в результате чего
      //получим в переменную pcTotalAvail количество считанных байт.
      NetShareGetInfo(PChar(ComputerNetName), PChar(ResourceNetName), 50, nil, 0,
        pcTotalAvail);
      //инициализируем буферный указатель и дадим ему нужное количество памяти
      GetMem(pbBuffer, pcToTalAvail);
      //поместим в буфер имя сетевого ресурса, зачем не знаю - имя мы уже и так
      //указываем, но без этого функция почему-то не работает, по крайней мере у меня
      StrPCopy(pbBuffer^.shi50_netname, ResourceNetName);
      //выполним функцию еще раз уже указав параметры буфера
      Res := NetShareGetInfo(PChar(ComputerNetName), PChar(ResourceNetName), 50,
        pbBuffer, pcTotalAvail, pcTotalAvail);
      if Res = 0 then //все в порядке
      begin
        //передадим данные из указателя в "обычную" переменную
        Buf := pbBuffer^;
        //заполним результат полученными значениями
        Result.ReadOnlyPassword := string(Buf.shi50_ro_password);
        Result.FullAccessPassword := string(Buf.shi50_rw_password);
        Result.Comments := string(Buf.shi50_remark);
        Result.Path := string(Buf.shi50_path);
      end;
      //освободим указатель
      FreeMem(pbBuffer);
    end;
     
    procedure TForm1.FillShareEnum(Items: TStrings);
    var
      ShareInfo: array[0..MaxNetArrayItems - 1] of TShareInfo50;
      EntriesRead, TotalAvial: Word;
      Res: Integer;
      N: Integer;
    begin
      Items.Clear; //почистим Items
      FillChar(ShareInfo, SizeOf(ShareInfo), #0); //заполним буфер нолями
      Res := NetShareEnum(PChar('\\' + edComputerNetName.Text), 50, @ShareInfo,
        SizeOf(ShareInfo),
        EntriesRead, TotalAvial); //имя сетевой машины возьмем из строки ввода,
      //предварительно озаглавив его двумя обратными слэшами
      if Res = No_Error then //функция выполнена без ошибок
        for N := 0 to EntriesRead - 1 do
          //пройдемся по буферу считанных имен ресурсов
          if not (string(ShareInfo[N].shi50_netname) = '') then
            Items.Add(string(ShareInfo[N].shi50_netname));
              //добавим имя машины в список
    end;
     
    function TForm1.GetComputerNetName: string;
    var
      RootItemIDList: PItemIDList;
        //идентификатор объекта в пространстве имен проводника
      BrowseInfo: TBrowseInfo; //структура, в которой содержится информация о диалоге
      Buffer: PChar; //сюда получим имя компьютера
    begin
      Result := '';
      //получим нужный идентификатор PItemIDList, CSIDL_NETWORK - в сетевом окружении
      if not (SHGetSpecialFolderLocation(0, CSIDL_NETWORK, RootItemIDList) =
        NO_ERROR) then
        Exit;
      //подготовим буфер, в который получим имя компьютера
      GetMem(Buffer, Max_Path);
      FillChar(BrowseInfo, SizeOf(BrowseInfo), 0);
      //подготовим структуру TBrowseInfo
      with BrowseInfo do
      begin {With BrowseInfo}
        hwndOwner := Application.Handle; //хозяин окна - наше приложение
        pidlRoot := RootItemIDList; //полученный ранее идентификатор
        // объекта в списке объектов проводника
        pszDisplayName := Buffer; //имя компьютера будем принимать в Buffer
        lpszTitle := 'Подключенные компьютеры'; //заголовок диалога
        ulFlags := BIf_BROWSEFORCOMPUTER; //будут показаны имена только компьютеров
      end; {With BrowseInfo}
     
      //выполним нужную функцию
      if SHBrowseForFolder(BrowseInfo) = nil ThenExit;
      Result := string(Buffer); //вот оно - сетевое имя компьютера
      FreeMem(Buffer);
    end;
     
    procedure TForm1.Button1Click(Snder: TObject);
    begin
      edComputerNetName.Text := GetComputerNetName;
      FillShareEnum(ComboBox1.Items);
      ComboBox1.ItemIndex := 0;
    end;
     
    procedure TForm1.BitBtn1Click(Sender: TObject);
    var
      ShareEvent: TShareEvent;
    begin
      if (edComputerNetName.Text = '') or (ComboBox1.Text = '') then
      begin
        edComputerNetName.SetFocus;
        Exit;
      end;
      ConnectAdmin;
      ShareEvent := GetShareInfo('\\' + edComputerNetName.Text, ComboBox1.Text);
      edReadOnlyPassword.Text := ShareEvent.ReadOnlyPassword;
      edFullAccessPassword.Text := ShareEvent.FullAccessPassword;
      edComments.Text := ShareEvent.Comments;
      edPhysicalPath.Text := ShareEvent.Path;
    end;
     
    procedure TForm1.BitBtn2Click(Sender: TObject);
    begin
      Close;
    end;
     
    end.
     
     



