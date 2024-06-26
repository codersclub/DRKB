---
Title: Получение информации о компьютере по IP
Author: Rouse\_
Date: 30.12.2004
Source: <https://rouse.drkb.ru>
---


Получение информации о компьютере по IP
==========================

Демонстрационная программа получения информации о компьютере на основе
IP адреса. Позволяет узнать:

- Имя компьютера
- Список залогиненных пользователей
- Коментарий к компьютеру
- Провайдер (не тот который вы подумали :)
- MAC адрес
- Открытые сетевые ресурсы
- Домен в который входит компьютер
- Если сеть доменная, то дополнительно определяет имя сервера домена
  и группы, в которые входит текущий пользователь на удаленной машине


```delphi
// Демонстрационная программа получения информации о компьютере
// на основе IP адреса
// Автор: Александр (Rouse_) Багель
// 30 декабря 2004 
// =============================================================
// Специально для FAQ сайта Мастера Дельфи и Исходники.RU
// http://www.delphimaster.ru
// http://forum.sources.ru
 
// Windows9x, Windows Millenium не поддерживются 
 
// Примечание: Я не любитель венгерской нотации в отношении переменных
// и давно выработал собственный, удобный для меня, стиль написания кода,
// (да и начальство не против :) поэтому не судить строго ;)
 
unit uMain;
 
{$DEFINE RUS}
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, ComCtrls, CommCtrl, Winsock;
 
const
  {$IFDEF RUS}
    RES_UNKNOWN = 'Неизвестно';
    RES_IP      = 'IP адрес: ';
    RES_CMP     = 'Имя компьютера: ';
    RES_USR     = 'Имя пользователя: ';
    RES_DOM     = 'Домен: ';
    RES_SER     = 'Сервер домена: ';
    RES_COM     = 'Коментарий: ';
    RES_PROV    = 'Провайдер: ';
    RES_GRP     = 'Группы: ';
    RES_MAC     = 'MAC адресс: ';
    RES_SHARES  = 'Доступные ресурсы: ';
    RES_TIME    = 'Времени затрачено: ';
    RES_COM_NO  = 'Отсутствует';
  {$ELSE}
    RES_UNKNOWN = 'Unknown';
    RES_IP      = 'IP adress: ';
    RES_CMP     = 'Computer name: ';
    RES_USR     = 'User name: ';
    RES_DOM     = 'Domen: ';
    RES_SER     = 'Domen server: ';
    RES_COM     = 'Comment: ';
    RES_PROV    = 'Provider: ';
    RES_GRP     = 'Groups: ';
    RES_MAC     = 'MAC adress: ';
    RES_SHARES  = 'Available shares: ';
    RES_TIME    = 'Expended time: ';
    RES_COM_NO  = 'Absent';
  {$ENDIF}
 
  WSA_TYPE = $101; //$202;
 
  // Для работы с ARP (Address Resolution Protocol) таблицей
  IPHLPAPI = 'IPHLPAPI.DLL';
  MAX_ADAPTER_ADDRESS_LENGTH = 7;
 
type
 
  LMSTR = LPWSTR;
  NET_API_STATUS = DWORD;
 
  // Следующие три типа используются для работы с Iphlpapi.dll
  // Выдрал из Iphlpapi.h
 
  // Так будет выглядеть МАС
  TMacAddress = array[0..MAX_ADAPTER_ADDRESS_LENGTH] of byte;
 
  // Это структура для единичного запроса
  TMibIPNetRow = packed record
    dwIndex         : DWORD;
    dwPhysAddrLen   : DWORD;
    bPhysAddr       : TMACAddress;  // Вот здесь и лежит МАС!!!
    dwAddr          : DWORD;
    dwType          : DWORD;
  end;
 
  // Как и в статье не будем выделять память динамически,
  // а сразу создадим массив... (хотя, чесно говоря, это не правильно,
  // но я иду простым путем :)
  TMibIPNetRowArray = array [0..512] of TMibIPNetRow;
 
  // А это, как и во всей библиотеке, такая вот...
  // запрашиваемая структура (в моей статье уже видел пример...)
  PTMibIPNetTable = ^TMibIPNetTable;
  TMibIPNetTable = packed record
    dwNumEntries    : DWORD;
    Table: TMibIPNetRowArray;
  end;
 
  // Структура для перечисления залогиненных пользователей
  _WKSTA_USER_INFO_1 = record
    wkui1_username: LPWSTR;
    wkui1_logon_domain: LPWSTR;
    wkui1_oth_domains: LPWSTR;
    wkui1_logon_server: LPWSTR;
  end;
  WKSTA_USER_INFO_1 = _WKSTA_USER_INFO_1;
  PWKSTA_USER_INFO_1 = ^_WKSTA_USER_INFO_1;
  LPWKSTA_USER_INFO_1 = ^_WKSTA_USER_INFO_1;
 
  // Структура для определения принадлежности пользователя к группам
  PGroupUsersInfo0 = ^_GROUP_USERS_INFO_0;
  _GROUP_USERS_INFO_0 = packed record
    grui0_name: LPWSTR;
  end;
  TGroupUsersInfo0 = _GROUP_USERS_INFO_0;
  GROUP_USERS_INFO_0 = _GROUP_USERS_INFO_0;
 
  // Структура для отределения доступных сетевых ресурсов
  PSHARE_INFO_1 = ^SHARE_INFO_1;
  _SHARE_INFO_1 = record
    shi1_netname: LMSTR;
    shi1_type: DWORD;
    shi1_remark: LMSTR;
  end;
  SHARE_INFO_1 = _SHARE_INFO_1;
  TShareInfo1 = SHARE_INFO_1;
  PShareInfo1 = PSHARE_INFO_1;
 
  TMainForm = class(TForm)
    gbIP: TGroupBox;
    gbInfo: TGroupBox;
    memInfo: TMemo;
    btnGetInfo: TButton;
    procedure btnGetInfoClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    IP, Font: Integer;  // Это переменные для работы с
    edIP: HWND;         // WC_IPADDRESS классом
    function GetNameFromIP(const IP: String): String;
    function GetUsers(const CompName: String): String;
    function GetDomain(const CompName, Provider: String): String;
    function GetComment(CompName, Provider: String): String;
    function GetProvider(const CompName: String): String;
    function GetMacFromIP(const IP: String): String;
    function GetDomainServer(const DomainName: String): String;
    function GetGroups(DomainServer: String; UserName: String): String;
    function GetShares(const CompName: String): String;
  end;
 
  // Объявим функции, так как их объявлений нет в Дельфи.
  // Здесь идет статическая загрузка библиотек, только потому,
  // что данные функции есть во всех системах, начиная с W95...
 
  {$EXTERNALSYM WNetGetResourceInformation}
  function WNetGetResourceInformation(lpNetResource: PNetResource;
    lpBuffer: Pointer; var lpcbBuffer: DWORD; lplpSystem: Pointer): DWORD; stdcall;
  {$EXTERNALSYM GetIpNetTable}
  function GetIpNetTable(pIpNetTable: PTMibIPNetTable;
    pdwSize: PULONG; bOrder: Boolean): DWORD; stdcall;
 
  function WNetGetResourceInformation; external mpr name 'WNetGetResourceInformationA';
  function GetIpNetTable; external IPHLPAPI name 'GetIpNetTable';
 
  function NetGetAnyDCName(servername: LPCWSTR;  domainname: LPCWSTR;
    bufptr: Pointer): Cardinal;
    stdcall; external 'netapi32.dll';
 
  function NetShareEnum(servername: LMSTR; level: DWORD; var bufptr: Pointer;
    prefmaxlen: DWORD; entriesread, totalentries,
    resume_handle: LPDWORD): NET_API_STATUS; stdcall; external 'Netapi32.dll';
 
  function NetApiBufferFree(buffer: Pointer): Cardinal;
    stdcall; external 'netapi32.dll';
 
  function NetWkstaUserEnum(ServerName: LPCWSTR;
                          Level: DWORD;
                          BufPtr: Pointer;
                          PrefMaxLen: DWORD;
                          EntriesRead: LPDWORD;
                          TotalEntries: LPDWORD;
                          ResumeHandle: LPDWORD): LongInt; stdcall; external 'netapi32.dll';
 
  function NetUserGetGroups(ServerName: LPCWSTR;
                          UserName: LPCWSTR;
                          level: DWORD;
                          bufptr: Pointer;
                          prefmaxlen: DWORD;
                          var entriesread: DWORD;
                          var totalentries: DWORD): LongInt; stdcall; external 'netapi32.dll';
 
var
  MainForm: TMainForm;
 
implementation
 
{$R *.dfm}
 
// Для ввода IP адреса будем использовать класс WC_IPADDRESS
// именно для этого и предназначеный...
procedure TMainForm.FormCreate(Sender: TObject);
begin
  // Зададим первоначальный IP адрес (это адрес моей машины)
  IP := MAKEIPADDRESS(192, 168, 2, 108);
  // Инициализируем дополнительные классы библиотеки ComCtl32.dll.
  InitCommonControl(ICC_INTERNET_CLASSES);
  // Создадим само окошко (предком ему будет gbIP)
  edIP:= CreateWindow(WC_IPADDRESS, nil, WS_CHILD or WS_VISIBLE,
    6, 16, 100, 21, gbIP.Handle, 0, hInstance, nil);
  // Укажем ему какой IP показывать
  SendMessage(edIP, IPM_SETADDRESS, 0, IP);
  // Подберем нужный шрифтик для него...
  Font := CreateFont(-11, 0, 0, 0, 400, 0, 0, 0, DEFAULT_CHARSET,
    OUT_DEFAULT_PRECIS, CLIP_DEFAULT_PRECIS, DEFAULT_QUALITY,
    DEFAULT_PITCH or FF_DONTCARE, 'MS Sans Serif');
  // и скажем, чтоб он был с этим шрифтом (а то больно уж неказистый...)
  SendMessage(edIP, WM_SETFONT, Font, 0);
end;
 
// Ну это короче понятно...
procedure TMainForm.btnGetInfoClick(Sender: TObject);
var
  TmpCompName, TmpProvider, TmpGroup, TmpUser, TmpServer: String;
  Time: Cardinal;
  IPStr: String;
begin
  Time := GetTickCount;  // Засечем время...
 
  // Узнаем, что за адрес введен... (он появится в IP)
  SendMessage(edIP, IPM_GETADDRESS, 0, Longint(PDWORD(@IP)));
 
  // Преобразуем эту абракадабру в нормальный "Dotted IP"
  IPStr := IntToStr(FIRST_IPADDRESS(IP));
  IPStr := IPStr + '.' + IntToStr(SECOND_IPADDRESS(IP));
  IPStr := IPStr + '.' + IntToStr(THIRD_IPADDRESS(IP));
  IPStr := IPStr + '.' + IntToStr(FOURTH_IPADDRESS(IP));
 
  // Ну и начнем работать...
  with memInfo, memInfo.Lines do                        // Вывод информации
  begin
    Clear;                                              // Очищаем экран
    Refresh;                                            // Ну и обновляем...
                                                        // (при вызове первой функции может не обновиться)
 
    Add(RES_IP + IPStr);                                // Выводим IP адрес
    TmpCompName := GetNameFromIP(IPStr);
    if TmpCompName = RES_UNKNOWN then Exit;
    Add(RES_CMP + TmpCompName);                         // Выводим имя компьютера
    TmpUser := GetUsers(IPStr);
    Add(RES_USR + TmpUser);                             // Выводим имя пользователя
    TmpProvider := GetProvider(TmpCompName);
    Add(RES_PROV + TmpProvider);                        // Выводим провайдера
    Add(RES_COM + GetComment(TmpCompName,
      TmpProvider));                                    // Выводим комментарий к ресурсу
    TmpGroup := GetDomain(TmpCompName, TmpProvider);
    Add(RES_DOM + TmpGroup);                            // Выводим группу
    TmpServer := GetDomainServer(TmpGroup);
    if TmpServer <> '' then
    begin
      Add(RES_SER + TmpServer);                         // Выводим имя сервера
      Add(RES_GRP + GetGroups(TmpServer, TmpUser));     // Выводим группы домена в которые входит пользователь
    end;
    Add(RES_SHARES + GetShares(TmpCompName));           // Выводим список доступных ресурсов
    Add(RES_MAC + GetMacFromIP(IPStr));                 // Выводим МАС адрес
    Add(RES_TIME + IntToStr(GetTickCount - Time));      // Сколько времени затрачено
  end;
end;
 
// Вообщето желательно запускать данную функцию отдельным потоком.
// Поясню: при отсутствии компьютера с заданным IP программа будет
// ожидать выполнения gethostbyaddr и на это время подвиснет.
function TMainForm.GetNameFromIP(const IP: String): String;
var
  WSA: TWSAData;
  Host: PHostEnt;
  Addr: Integer;
  Err: Integer;
begin
  Result := RES_UNKNOWN;
  Err := WSAStartup(WSA_TYPE, WSA);
  if Err <> 0 then  // Лучше пользоваться такой конструкцией,
  begin             // чтобы в случае ошибки можно было увидеть ее код.
    ShowMessage(SysErrorMessage(GetLastError));
    Exit;
  end;
  try
    Addr := inet_addr(PChar(IP));
    if Addr = INADDR_NONE then
    begin
      ShowMessage(SysErrorMessage(GetLastError));
      WSACleanup;
      Exit;
    end;
    Host := gethostbyaddr(@Addr, SizeOf(Addr), PF_INET);
    if Assigned(Host) then  // Обязательная проверка, в противном случае, при
      Result := Host.h_name // отсутствии компьютера с заданым IP, получим AV
    else
      ShowMessage(SysErrorMessage(GetLastError));
  finally
    WSACleanup;
  end;
end;
 
// Перечисляем всех залогиненных на машине пользователей
// начинаем перечисления со второго пользователя, потомчто
// первым будет "имя компьютера"$
function TMainForm.GetUsers(const CompName: String): String;
var
  Buffer, tmpBuffer: Pointer;
  PrefMaxLen       : DWORD;
  Resume_Handle    : DWORD;
  EntriesRead      : DWORD;
  TotalEntries     : DWORD;
  I, Size          : Integer;
  PSrvr            : PWideChar;
begin
  PSrvr := nil;
  try
    // Переводим имя компьютера типа PWideChar
    Size := Length(CompName);
    GetMem(PSrvr, Size * SizeOf(WideChar) + 1);
    StringToWideChar(CompName, PSrvr, Size + 1);
 
    PrefMaxLen := DWORD(-1);
    EntriesRead := 0;
    TotalEntries := 0;
    Resume_Handle := 0;
    Buffer := nil;
 
    // Получаем список пользователей на компьютере из PSrvr
    if NetWkstaUserEnum( PSrvr, 1, @Buffer, PrefMaxLen, @EntriesRead,
      @TotalEntries, @Resume_Handle) = S_OK then
    begin
      tmpBuffer := Pointer(DWORD(Buffer) + SizeOf(WKSTA_USER_INFO_1));
      for I := 1 to TotalEntries - 1 do
      begin
        Result := Result + WKSTA_USER_INFO_1(tmpBuffer^).wkui1_username + ', ';
        tmpBuffer := Pointer(DWORD(tmpBuffer) + SizeOf(WKSTA_USER_INFO_1));
      end;
      Result := Copy(Result, 1, Length(Result) - 2);
  end
  else
    ShowMessage(SysErrorMessage(GetLastError));
  finally
    NetApiBufferFree(Buffer);
    FreeMem(PSrvr);
  end;
end;
 
// Все-таки будем сканировать сеть, НО!!!
// Мы не будем производить рекурсивное сканирование ресурсов с
// dwDisplayType равным RESOURCEDISPLAYTYPE_SERVER!!!
// В основном все торможение происходить именно здесь,
// так как эти ресурсы являются так называемыми корневыми
// для компьютеров. Если компьютер отключен его имя может сохраниться
// в кэше и при попытке сканирования получим ненужные нам тормоза.
// В принципе, у меня эта функция выдавала неплохие результаты по скорости...
// (Около 31 мс - максимум с отображением на memInfo, сеть 100Мб, 28 компов)
 
function TMainForm.GetComment(CompName, Provider: String): String;
var
  StopScan: Boolean;
  TmpRes: TNetResource;
 
  // Само сканирование
  procedure Scan(Res: TNetResource; Root: boolean);
  var
    Enum, I: Cardinal;
    ScanRes: array [0..512] of TNetResource; // Можно сделать и больший размер массива
    Size, Entries, Err: DWORD;               // но, как показывает практика, такого достаточно
  begin
 
    if StopScan then Exit; // Используем флаг для выхода из рекурсии
 
    // Ну тут думаю все понятно... просто два типа начала сканирования
    if Root = True then
      Err := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_DISK,
        0, nil, Enum) // корневой...
    else
      Err := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_DISK,
        0, @Res, Enum); // и рекурсионный для поиска вложений...
 
    if Err = NO_ERROR then
    begin
      Size := SizeOf(ScanRes);
      Entries := DWORD(-1);
      Err := WNetEnumResource(Enum, Entries, @ScanRes, Size);
      if Err = NO_ERROR then
      try
        for I := 0 to Entries - 1 do
        begin
          if StopScan then Exit; // Еще один флаг, так как выход на верхний вызов
          with ScanRes[i] do     // может осуществиться из цикла
          begin
            if dwDisplayType = RESOURCEDISPLAYTYPE_SERVER then
              if lpRemoteName = CompName then // если нашли наш компьютер...
              begin
                Result :=  lpComment;     // вытаскиваем комментарий
                StopScan := True;         // и выставляем флаг для выхода из рекуссии
                Exit;
              end;
            if dwDisplayType <> RESOURCEDISPLAYTYPE_SERVER then  // не будем сканировать шары у компов...
              Scan(ScanRes[i], False);
          end;
        end;
      finally
        WNetCloseEnum(Enum);
      end
      else
        if Err <> ERROR_NO_MORE_ITEMS then  // Нет элементов для отображения...
          MessageDlg(SysErrorMessage(GetLastError), mtError, [mbOK], 0);
    end
    else
      ShowMessage(SysErrorMessage(GetLastError));
  end;
 
// Основная процедура
begin
 
  // Подготовительные действия...
  Result := RES_UNKNOWN;
 
  if CompName = RES_UNKNOWN then Exit;    // Если имя компа не найдено,
                                          // незачем и продолжать.
 
  CompName := '\\' + CompName;            // Подправим имя,
                                          // чтоб не делать это далее в цикле...
 
  StopScan := False;    // Снимем флаг выхода из рекурсии.
                        // Здесь обязательно инициализирование переменной
                        // типа Boolean, так как было замечено, что
                        // некоторые версии Дельфи криво инициализируют
                        // значение по умолчанию, после чего логические
                        // операторы типа AND - OR - NOT перестают работать.
                        // Например: по умолчанию переменная StopScan равна False
                        // без инициализации, после StopScan := not StopScan;
                        // переменная StopScan НЕ ВСЕГДА станет True!!!
 
  // Запускаем сканирование...
  // (можно и в потоке, но у меня время на сканирование уходит 8 мс.)
  Scan(TmpRes, True);
 
  // И смотрим результаты...
  if Result = '' then Result := RES_COM_NO;
end;
 
// Задача этой функции предельно проста:
// При известном имени компьютера мы можем заполнить структуру
// и передать ее функции WNetGetResourceParent которая и вернет
// нам предка, в моем случае группу.
// Да, чуть не забыл, если имя компьютера есть в кэше, а сам
// компьютер отключен, то в качестве результата будет либо
// пустая строка либо 'Нет данных'...
// Поэтому опять придется сканировать, если слишком уж критично...
function TMainForm.GetDomain(const CompName, Provider: String): String;
var
  CurrRes: TNetResource;
  ParentName: array [0..1] of TNetResource;
  Enum: DWORD;
  Err: Integer;
begin
  with CurrRes do
  begin
    dwScope := RESOURCE_GLOBALNET;
    dwType := RESOURCETYPE_DISK;
    dwDisplayType := RESOURCEDISPLAYTYPE_SERVER;
    dwUsage := RESOURCEUSAGE_CONTAINER;
    lpLocalName := '';
    lpRemoteName := PChar('\\' + CompName);
    lpComment := '';
    lpProvider := PChar(Provider);
  end;
  Enum := SizeOf(ParentName);
  Err := WNetGetResourceParent(@CurrRes, @ParentName, Enum);
  if Err = NO_ERROR then
  begin
    Result := ParentName[0].lpRemoteName;
    if Result = '' then Result := RES_COM_NO;
  end
  else
    ShowMessage(SysErrorMessage(GetLastError));
end;
 
// А этой функцией мы можем узнать провайдера
// (в основном это Microsoft Network).
function TMainForm.GetProvider(const CompName: String): String;
var
  Buffer: array [0..255] of Char;
  Size: DWORD;
begin
  Size := SizeOf(Buffer);
  if WNetGetProviderName(WNNC_NET_LANMAN, @Buffer, Size) <> NO_ERROR then
    Result := RES_COM_NO
  else
    Result := String(Buffer);
end;
 
// Из всех приведенных функций эта самая интересная.
// Я много раз говорил о незаслуженном невнимании программистов
// к IPHLPAPI.DLL. Данный пример подтверждает это. На всех форумах
// можно услышать о получании МАС адреса посредством посылки IPX пакета
// и разбора заголовка ответа от удаленного компьютера
// (что само по себе геморой, если не принимать во внимание,
// что IPX уже практически вымер, и его мало где встретишь).
// Здесь же строится полная ARP таблица, на основании которой мы
// можем спокойно произвести выборку по нужному IP адресу,
// а так как все берется из кэша, то мы сможем узнать МАС адреса
// даже выключенных компьютеров... 
// Единственный минус: в таблице (не всегда) отсутсвует информация
// по локальному компьютеру, т.е. таким образом можно получить
// все МАС адреса за исключением своего,
// но для этого есть уже другие функции...
 
// Приведу выдержку из MSDN:
// You can use IP Helper to perform Address Resolution Protocol (ARP) operations for the local computer. 
// Use the following functions to retrieve and modify the ARP table.
// The GetIpNetTable retrieves the ARP table. 
// The ARP table contains the mapping of IP addresses to physical addresses. 
// Physical addresses are sometimes referred to as Media Access Controller (MAC) addresses. 
 
// Хочу заметить что для NT есть очень интересная функция SendARP - позволяющая
// напрямую получить требуемый МАС без построения таблицы, поэтому советую
// модифицировать код программы для более эффективного исполнения участков кода 
// под различными системами.
 
function TMainForm.GetMacFromIP(const IP: String): String;
 
  // (Будем использовать функцию приведения из статьи)
  // В качестве первого значения массив, второе значение,
  // размер данных в массиве
  function GetMAC(Value: TMacAddress; Length: DWORD): String;
  var
    I: Integer;
  begin
    if Length = 0 then Result := '00-00-00-00-00-00' else
    begin
      Result := '';
      for i:= 0 to Length -2 do
        Result := Result + IntToHex(Value[i], 2) + '-';
      Result := Result + IntToHex(Value[Length-1], 2);
    end;
  end;
 
  // Получаем IP адрес, заметь в отличии от работы с классом WC_IPADDRESS
  // здесь преобразование идет в обратном порядке!
  function GetDottedIPFromInAddr(const InAddr: Integer): String;
  begin
    Result := '';
    Result := IntToStr(FOURTH_IPADDRESS(InAddr));
    Result := Result + '.' + IntToStr(THIRD_IPADDRESS(InAddr));
    Result := Result + '.' + IntToStr(SECOND_IPADDRESS(InAddr));
    Result := Result + '.' + IntToStr(FIRST_IPADDRESS(InAddr));
  end;
 
  // Основная функция
var
  Table: TMibIPNetTable;
  Size: Integer;
  CatchIP: String;
  Err, I: Integer;
begin
  Result := RES_UNKNOWN;
  Size := SizeOf(Table);                      // Ну тут все просто...
  Err := GetIpNetTable(@Table, @Size, False); // Выполняем...
  if Err <> NO_ERROR then                     // Проверка на ошибку...
  begin
    ShowMessage(SysErrorMessage(GetLastError));
    Exit;
  end;
  // Теперь мы имеем таблицу из IP адресов и соответсвующих им MAC адресов
  for I := 0 to Table.dwNumEntries - 1 do     // Ищем нужный IP ...
  begin
    CatchIP := GetDottedIPFromInAddr(Table.Table[I].dwAddr);
    if CatchIP = IP then                      // И выводим его МАС ...
    begin
      Result := GetMAC(Table.Table[I].bPhysAddr, Table.Table[I].dwPhysAddrLen);
      Break;
    end;
  end;
end;
 
// Полуение доступных сетевых ресурсов на удаленном компьютере
function TMainForm.GetShares(const CompName: String): String;
type TShareInfo1Array = array of TShareInfo1;
var
  entriesread, totalentries: DWORD;
  Info: Pointer;
  I: Integer;
  CN: PWideChar;
begin
  CN := StringToOleStr(CompName);
  // так как нам нужны только имена ресурсов, воспользуемся струтурой TShareInfo1
  // тогда, не нужно будет получать привилегии администратора на удаленной машине :)
  if NetShareEnum(CN, 1, Info, DWORD(-1), @entriesread,
    @totalentries, nil) = 0 then
    try // список ресурсов смотрим здесь
      if entriesread > 0 then
        for I := 0 to entriesread - 1 do
          Result := Result + TShareInfo1Array(@(Info^))[I].shi1_netname + ' ';
    finally
      NetApiBufferFree(Info);
    end;
end;
 
// Вот таким простым путем будем получать имя сервера домена
function TMainForm.GetDomainServer(const DomainName: String): String;
var
  Domain, Server: PWideChar;
begin
  GetMem(Domain, MAX_PATH);
  try
    StringToWideChar(DomainName, Domain, MAX_PATH);
    if NetGetAnyDCName(nil, Domain, @Server)= NO_ERROR then
    try
      Result := WideCharToString(Server);
      finally
      NetApiBufferFree(Server);
    end;
  finally
    FreeMem(Domain, MAX_PATH);
  end;
end;
 
// перечисление доменных групп в которые входит пользователь
function TMainForm.GetGroups(DomainServer: String; UserName: String): String;
type
  TGroupUsersInfoArray = array of TGroupUsersInfo0;
var
  Info: PGroupUsersInfo0;
  Sn, Un: PWideChar;
  entriesread, totalentries: DWORD;
  I, A, B, Size: Integer;
  P: Pointer;
begin
  // нам нужно только имя сервера домена
  Sn := StringToOLEStr(DomainServer);
  // и имя пользователя
  Un := StringToOleStr(UserName);
  // делаем запрос
  if NetUserGetGroups(Sn, Un, 0, @Info, DWORD(-1), entriesread, totalentries) = NO_ERROR  then
  try // и смотрим, что там у нас получилось
    if entriesread > 0 then
      for I := 0 to entriesread - 1 do
        Result := Result + TGroupUsersInfoArray(@(Info^))[I].grui0_name + ' ';
  finally
    NetApiBufferFree(Info);
  end;
end;
 
end.
```

Скачать демонстрационный пример: [infofromip.zip](infofromip.zip) 14K

