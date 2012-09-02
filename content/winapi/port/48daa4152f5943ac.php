<h1>Посылать и считывать данные с COM порта, а также менять параметры (биты данных, четность)</h1>
<div class="date">01.01.2007</div>


<p>Ниже представлен класс для работы с COM-портом. Протестирован в Windows 95. Класс выдернут из контекста, так что не ручаюсь в компиляции с первого раза, однако все функции работы с COM очевидны. </p>

<pre>
unit Unit1;
 
interface
 
uses
  Windows;
 
type
  TComPort = class
  private
    hFile: THandle;
  public
    constructor Create;
    destructor Destroy; override;
    function InitCom(BaudRate, PortNo: Integer; Parity: Char;
      CommTimeOuts: TCommTimeouts): Boolean;
    procedure CloseCom;
    function ReceiveCom(var Buffer; Size: DWORD): Integer;
    function SendCom(var Buffer; Size: DWORD): Integer;
    function ClearInputCom: Boolean;
  end;
 
implementation
 
uses
  SysUtils;
 
constructor TComPort.Create;
begin
  inherited;
  CloseCom;
end;
 
destructor TComPort.Destroy;
begin
  CloseCom;
  inherited;
end;
 
function TComPort.InitCom(BaudRate, PortNo: Integer; Parity: Char;
  CommTimeOuts: TCommTimeouts): Boolean;
var
  FileName: string;
  DCB: TDCB;
  PortParam: string;
begin
  result := FALSE;
  FileName := 'Com' + IntToStr(PortNo); {имя файла}
  hFile := CreateFile(PChar(FileName),
    GENERIC_READ or GENERIC_WRITE, 0, nil,
    OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
  if hFile = INVALID_HANDLE_VALUE then
    exit;
 
  //установка требуемых параметров
  GetCommState(hFile, DCB); //чтение текущих параметров порта
  PortParam := 'baud=' + IntToStr(BaudRate) + ' parity=' + Parity +
    ' data=8 stop=1 ' +
    'octs=off';
  if BuildCommDCB(PChar(PortParam), DCB) then
  begin
    result := SetCommState(hFile, DCB) and
      SetCommTimeouts(hFile, CommTimeOuts);
  end;
  if not result then
    CloseCom;
end;
 
procedure TComPort.CloseCom;
begin
  if hFile &lt; &gt; INVALID_HANDLE_VALUE then
    CloseHandle(hFile);
  hFile := INVALID_HANDLE_VALUE;
end;
 
function TComPort.ReceiveCom(var Buffer; Size: DWORD): Integer;
var
  Received: DWORD;
begin
  if hFile = INVALID_HANDLE_VALUE then
    raise Exception.Create('Не открыта запись в Com порт');
  if ReadFile(hFile, Buffer, Size, Received, nil) then
  begin
    Result := Received;
  end
  else
    raise Exception.Create('Ошибка приема данных: ' + IntToStr(GetLastError));
end;
 
function TComPort.SendCom(var Buffer; Size: DWORD): Integer;
var
  Sended: DWORD;
begin
  if hFile = INVALID_HANDLE_VALUE then
    raise Exception.Create('Не открыта запись в Com порт');
  if WriteFile(hFile, Buffer, Size, Sended, nil) then
  begin
    Result := Sended;
  end
  else
    raise Exception.Create('Ошибка передачи данных: ' + IntToStr(GetLastError));
end;
 
function TComPort.ClearInputCom: Boolean;
begin
  if hFile = INVALID_HANDLE_VALUE then
    raise Exception.Create('Не открыта запись в Com порт');
  Result := PurgeComm(hFile, PURGE_RXCLEAR);
end;
 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

