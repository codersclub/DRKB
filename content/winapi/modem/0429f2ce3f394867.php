<h1>Как прочитать из модема?</h1>
<div class="date">01.01.2007</div>


<p>После предварительной настройки переменных, COM порт открывается как обычный файл. Так же пример показывает, как очищать буфер COM порта и читать из него.</p>
<pre>
Var 
PortSpec : array[0..255] of char; 
PortNo   : Word; 
success : Boolean; 
error:integer; 
begin 
FillChar(PortSpec,Sizeof(PortSpec),#0); 
StrPCopy(PortSpec,'Com1:19200,n,8,1'); 
PortSpec[3]:=Char(Ord(PortSpec[3])+Ord(PortNo)); 
 
if not BuildCommDCB(PortSpec,Mode) Then 
  Begin 
//какая-то ошибка... 
  Exit; 
  End; 
 
PortSpec[5]:=#0;    { 'Com1:' } 
 
Mode.Flags:=EV_RXCHAR +   EV_EVENT2;  { $1001 } 
 
  Com := CreateFile(PortSpec,GENERIC_READ or GENERIC_WRITE, 
                    0,    //* comm устройство открывается с эксклюзивным доступом*/ 
                    Nil, //* нет security битов */ 
                    OPEN_EXISTING, //* comm устройства должны использовать OPEN_EXISTING*/ 
                    0,    //* not overlapped I/O */ 
                    0  //* hTemplate должен быть NULL для comm устройств */ 
                     ); 
  if Com = INVALID_HANDLE_VALUE then Error := GetLastError; 
  Success := GetCommState(Com,Mode); 
 
  if not Success then  // Обработчик ошибки. 
  begin 
 
  end; 
 
  Mode.BaudRate := 19200; 
  Mode.ByteSize := 8; 
  Mode.Parity := NOPARITY; 
  Mode.StopBits := ONESTOPBIT;//нужен был для перезаписи в NT 
 
  Success := SetCommState(Com, Mode); 
 
  if not Success then  // Обработчик ошибки. 
  begin 
 
  end; 
end; 
</pre>

<p>Переменная "com" типа dword.</p>

<p>Вы так же можете очистить буфер COM порта PurgeComm(Com,PURGE_RXCLEAR or PURGE_TXCLEAR); И прочитать из него</p>

<pre>
Function ReadCh(Var Ch:Byte):dword; 
var 
n : dword; 
Begin 
  Readfile(Com,ch,1,result,nil); 
End;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


