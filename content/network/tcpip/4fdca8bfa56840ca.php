<h1>Получение TCP/UDP статистики</h1>
<div class="date">01.01.2007</div>


<pre>
////////////////////////////////////////////////////////////////////////////////
//
//  ****************************************************************************
//  * Unit Name : Unit1
//  * Purpose   : Демо получения ТСР статистики
//  * Author    : Александр (Rouse_) Багель
//  * Version   : 1.03
//  ****************************************************************************
//
 
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls, Winsock;
 
// так как в примере используются недокументированные функции присутствующие
// только в ХР и выше - то часть кода сделал через директивы компилятора
// (лень было делать динамическую загрузку)
// Если они вам нужны раскоментируйте директиву USES_NATIVE_API
 
{.$DEFINE USES_NATIVE_API}
 
const
  TH32CS_SNAPPROCESS  = $00000002;
 
  // Константы состояний порта
  MIB_TCP_STATE_CLOSED     = 1;
  MIB_TCP_STATE_LISTEN     = 2;
  MIB_TCP_STATE_SYN_SENT   = 3;
  MIB_TCP_STATE_SYN_RCVD   = 4;
  MIB_TCP_STATE_ESTAB      = 5;
  MIB_TCP_STATE_FIN_WAIT1  = 6;
  MIB_TCP_STATE_FIN_WAIT2  = 7;
  MIB_TCP_STATE_CLOSE_WAIT = 8;
  MIB_TCP_STATE_CLOSING    = 9;
  MIB_TCP_STATE_LAST_ACK   = 10;
  MIB_TCP_STATE_TIME_WAIT  = 11;
  MIB_TCP_STATE_DELETE_TCB = 12;
 
type
  TForm1 = class(TForm)
    Memo1: TMemo;
    Button1: TButton;
    Button2: TButton;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    function PortStateToStr(const State: DWORD): String;
  end;
 
  // Стандартная структура для получения ТСР статистики
  PTMibTCPRow = ^TMibTCPRow;
  TMibTCPRow = packed record
    dwState: DWORD;
    dwLocalAddr: DWORD;
    dwLocalPort: DWORD;
    dwRemoteAddr: DWORD;
    dwRemotePort: DWORD;
  end;
 
  // В данную структуру будет передаваться результат GetTcpTable
  PTMibTCPTable = ^TMibTCPTable;
  TMibTCPTable = packed record
    dwNumEntries: DWORD;
    Table: array[0..0] of TMibTCPRow;
  end;
 
  // Стандартная структура для получения UDP статистики
  PTMibUdpRow = ^TMibUdpRow;
  TMibUdpRow = packed record
    dwLocalAddr: DWORD;
    dwLocalPort: DWORD;
  end;
 
  // В данную структуру будет передаваться результат GetUDPTable
  PTMibUdpTable = ^TMibUdpTable;
  TMibUdpTable = packed record
    dwNumEntries: DWORD;
    table: array [0..0] of TMibUdpRow;
  end;
 
 
  {$IFDEF USES_NATIVE_API}
    // Расширенные варианты данных структур
 
    PTMibTCPExRow = ^TMibTCPExRow;
    TMibTCPExRow = packed record
      dwState: DWORD;
      dwLocalAddr: DWORD;
      dwLocalPort: DWORD;
      dwRemoteAddr: DWORD;
      dwRemotePort: DWORD;
      dwProcessID: DWORD;
    end;
 
    PTMibTCPExTable = ^TMibTCPExTable;
    TMibTCPExTable = packed record
      dwNumEntries: DWORD;
      Table: array[0..0] of TMibTCPExRow;
    end;
 
    PTMibUdpExRow = ^TMibUdpExRow;
    TMibUdpExRow = packed record
      dwLocalAddr: DWORD;
      dwLocalPort: DWORD;
      dwProcessID: DWORD;
    end;
 
    PTMibUdpExTable = ^TMibUdpExTable;
    TMibUdpExTable = packed record
      dwNumEntries: DWORD;
      table: array [0..0] of TMibUdpExRow;
    end;
 
    // Структура для получения списка текущий процессов и их параметров
    TProcessEntry32 = packed record
      dwSize: DWORD;
      cntUsage: DWORD;
      th32ProcessID: DWORD;
      th32DefaultHeapID: DWORD;
      th32ModuleID: DWORD;
      cntThreads: DWORD;
      th32ParentProcessID: DWORD;
      pcPriClassBase: Longint;
      dwFlags: DWORD;
      szExeFile: array [0..MAX_PATH - 1] of WideChar;
    end;
 
  {$ENDIF}
 
  function GetTcpTable(pTCPTable: PTMibTCPTable; var pDWSize: DWORD;
    bOrder: BOOL): DWORD; stdcall; external 'IPHLPAPI.DLL';
 
  function GetUdpTable(pUDPTable: PTMibUDPTable; var pDWSize: DWORD;
    bOrder: BOOL): DWORD; stdcall; external 'IPHLPAPI.DLL';
 
  {$IFDEF USES_NATIVE_API}
 
    function AllocateAndGetTcpExTableFromStack(pTCPExTable: PTMibTCPExTable;
      bOrder: BOOL; heap: THandle; zero: DWORD; flags: DWORD): DWORD; stdcall;
      external 'IPHLPAPI.DLL';
 
    function AllocateAndGetUdpExTableFromStack(pUDPExTable: PTMibUDPExTable;
      bOrder: BOOL; heap: THandle; zero: DWORD; flags: DWORD): DWORD; stdcall;
      external 'IPHLPAPI.DLL';
 
    function CreateToolhelp32Snapshot(dwFlags, th32ProcessID: DWORD): THandle;
      stdcall; external 'KERNEL32.DLL';
 
    function Process32First(hSnapshot: THandle; var lppe: TProcessEntry32): BOOL;
      stdcall; external 'KERNEL32.DLL' name 'Process32FirstW';
 
    function Process32Next(hSnapshot: THandle; var lppe: TProcessEntry32): BOOL;
      stdcall; external 'KERNEL32.DLL' name 'Process32NextW';
 
  {$ENDIF}
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
// Получение TCP/UDP статистики при помощи стандартных методов
procedure TForm1.Button1Click(Sender: TObject);
var
  Size: DWORD;
  TCPTable: PTMibTCPTable;
  UDPTable: PTMibUdpTable;
  I: DWORD;
begin
  // для успешного получения стстаистики первоначально необходимо определиться
  // сколько памяти потребует данная операция
  // для этого делаем так:
  // Вделяем память под TCP таблицу (под один элемент)
  GetMem(TCPTable, SizeOf(TMibTCPTable));
  try
    // Показываем что памяти у нас не выделено
    Size := 0;
    // Выполняем функцию и после этого переменная Size
    // будет содержать кол-во необходимой памяти
    if GetTcpTable(TCPTable, Size, True) &lt;&gt; ERROR_INSUFFICIENT_BUFFER then Exit;
  finally
    // освобождаем память занятую под один элемент
    FreeMem(TCPTable);
  end;
  // Теперь выделяем уже требуемое кол-во памяти
  GetMem(TCPTable, Size);
  try
    // Выполняем функцию
    if GetTcpTable(TCPTable, Size, True) = NO_ERROR then
    begin
      Memo1.Lines.Add('');
      Memo1.Lines.Add('Standart TCP Stats');
      Memo1.Lines.Add(Format('%15s: | %5s %-12s', ['Host', 'Port', 'State']));
      Memo1.Lines.Add('==================================================');
    // и насинаем выводить данные по ТСР
    for I := 0 to TCPTable^.dwNumEntries - 1 do
      Memo1.Lines.Add(Format('%15s: | %5d %s', [inet_ntoa(in_addr(TCPTable^.Table[I].dwLocalAddr)),
        htons(TCPTable^.Table[I].dwLocalPort), PortStateToStr(TCPTable^.Table[I].dwState)]));
    end;
  finally
    // Не забываем освободить память
    FreeMem(TCPTable);
  end;
 
  // По аналогии поступаем и с UDP статистикой
  GetMem(UDPTable, SizeOf(TMibUDPTable));
  try
    Size := 0;
    if GetUdpTable(UDPTable, Size, True) &lt;&gt; ERROR_INSUFFICIENT_BUFFER then Exit;
  finally
    FreeMem(UDPTable);
  end;
  GetMem(UDPTable, Size);
  try
    if GetUdpTable(UDPTable, Size, True) = NO_ERROR then
    begin
      Memo1.Lines.Add('');
      Memo1.Lines.Add('Standart UDP Stats');
      Memo1.Lines.Add(Format('%15s: | %5s', ['Host', 'Port']));
      Memo1.Lines.Add('======================================');
    for I := 0 to UDPTable^.dwNumEntries - 1 do
      Memo1.Lines.Add(Format('%15s: | %5d', [inet_ntoa(in_addr(UDPTable^.Table[I].dwLocalAddr)),
        htons(UDPTable^.Table[I].dwLocalPort)]));
    end;
  finally
    FreeMem(UDPTable);
  end;
end;
 
{$IFNDEF USES_NATIVE_API}
procedure TForm1.Button2Click(Sender: TObject);
begin
  Memo1.Lines.Add('');
  Memo1.Lines.Add('USES_NATIVE_API are disabled.');
end;
 
{$ELSE}
 
// Получение TCP/UDP статистики при помощи недокументрированных методов
// Работает только на ХР или Win 2003
procedure TForm1.Button2Click(Sender: TObject);
 
  // данная функция ищет процесс с th32ProcessID совпадающий с ProcessId
  // и возвращает его имя
  function ProcessPIDToName(const hProcessSnap: THandle; ProcessId: DWORD): String;
  var
    processEntry: TProcessEntry32;
  begin
    // Подготовительные действия
    Result := '';
    FillChar(processEntry, SizeOf(TProcessEntry32), #0);
    processEntry.dwSize := SizeOf(TProcessEntry32);
    // Прыгаем на первый процесс в списке
    if not Process32First(hProcessSnap, processEntry) then Exit;
    repeat
      // Сравнение
      if processEntry.th32ProcessID = ProcessId then
      begin
        // Если нашли нужный процесс - выводим результат и выходим
        Result := String(processEntry.szExeFile);
        Exit;
      end;
    // ищем пока не кончатся процессы
    until not Process32Next(hProcessSnap, processEntry);
  end;
 
var
  TCPExTable: PTMibTCPExTable;
  UDPExTable: PTMibUdpExTable;
  I: DWORD;
  hProcessSnap: THandle;
begin
  // для определения каким процессом открыт тот или иной порт
  // получаем список процессов
  hProcessSnap := CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
  if (hProcessSnap = INVALID_HANDLE_VALUE) then
  begin
    Memo1.Lines.Add('');
    Memo1.Lines.Add('CreateToolhelp32Snapshot failed');
    Exit;
  end;
  try
    // Выполняем вот такую вот функцию
    // она не документтрованна, но как видно из названия - она сама выделяет необходимую для работы
    // память и нам остается только прочитать результат по завершении ее выполнения
    if AllocateAndGetTcpExTableFromStack(@TCPExTable, False, GetProcessHeap, 2, 2) = NO_ERROR then
    try
      Memo1.Lines.Add('');
      Memo1.Lines.Add('Extended TCP Stats');
      Memo1.Lines.Add(Format('%15s: | %5s | %-12s | %20s | (%s)', ['Host', 'Port', 'State', 'Process name', 'ID']));
      Memo1.Lines.Add('==========================================================================');
      // начинаем выводить информацию
      for I := 0 to TCPExTable^.dwNumEntries - 1 do
        Memo1.Lines.Add(Format('%15s: | %5d | %-12s | %20s | (%d)',
          [inet_ntoa(in_addr(TCPExTable^.Table[I].dwLocalAddr)),
          htons(TCPExTable^.Table[I].dwLocalPort),
          PortStateToStr(TCPExTable^.Table[I].dwState),
          // Вот здесь у нас происходит сопоставление процесса открытому порту
          ProcessPIDToName(hProcessSnap, TCPExTable^.Table[I].dwProcessID),
          TCPExTable^.Table[I].dwProcessID]));
    finally
      // Не забываем освободить память занятую функцией
      GlobalFreePtr(TCPExTable);
    end;
 
    // По аналогии поступаем и с UDP статистикой
    if AllocateAndGetUdpExTableFromStack(@UDPExTable, False, GetProcessHeap, 2, 2) = NO_ERROR then
    try
      Memo1.Lines.Add('');
      Memo1.Lines.Add('Extended UDP Stats');
      Memo1.Lines.Add(Format('%15s: | %5s | %20s | (%s)', ['Host', 'Port', 'Process name', 'ID']));
      Memo1.Lines.Add('==============================================================');
      // начинаем выводить информацию
      for I := 0 to UDPExTable^.dwNumEntries - 1 do
        Memo1.Lines.Add(Format('%15s: | %5d | %20s | (%d)',
          [inet_ntoa(in_addr(UDPExTable^.Table[I].dwLocalAddr)),
          htons(UDPExTable^.Table[I].dwLocalPort),
          ProcessPIDToName(hProcessSnap, UDPExTable^.Table[I].dwProcessID),
          UDPExTable^.Table[I].dwProcessID]));
    finally
      GlobalFreePtr(UDPExTable);
    end;
  finally
    // Закрываем хэндл полученый от CreateToolhelp32Snapshot
    CloseHandle(hProcessSnap);
  end;
end;
 
{$ENDIF}
 
// Функция преобразует состояние порта в строковый эквивалент
function TForm1.PortStateToStr(const State: DWORD): String;
begin
  case State of
    MIB_TCP_STATE_CLOSED: Result := 'CLOSED';
    MIB_TCP_STATE_LISTEN: Result := 'LISTEN';
    MIB_TCP_STATE_SYN_SENT: Result := 'SYN SENT';
    MIB_TCP_STATE_SYN_RCVD: Result := 'SYN RECEIVED';
    MIB_TCP_STATE_ESTAB: Result := 'ESTABLISHED';
    MIB_TCP_STATE_FIN_WAIT1: Result := 'FIN WAIT 1';
    MIB_TCP_STATE_FIN_WAIT2: Result := 'FIN WAIT 2';
    MIB_TCP_STATE_CLOSE_WAIT: Result := 'CLOSE WAIT';
    MIB_TCP_STATE_CLOSING: Result := 'CLOSING';
    MIB_TCP_STATE_LAST_ACK: Result := 'LAST ACK';
    MIB_TCP_STATE_TIME_WAIT: Result := 'TIME WAIT';
    MIB_TCP_STATE_DELETE_TCB: Result := 'DELETE TCB';
  else
    Result := 'UNKNOWN';
  end;
end;
 
 
end.
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>Проект также доступен по адресу: http://rouse.front.ru/tcpstat.zip </p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Rouse_</div>
