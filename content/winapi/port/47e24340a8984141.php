<h1>Что такое порт? Правила для работы с портами</h1>
<div class="date">01.01.2007</div>


<p>Известно что в компьютере очень много собрано различных устройств , возникает вопрос как операционная система общается с ними. Для этого и служит порт, то есть эта «дверь» через которую программа (операционная система) может управлять данным устройством (считывать данные, заносить их).Причем я разделяю порты на две категории (это чисто мое разделение) - порты общеизвестные (COM LPT) и порты внутренние ,служащие для связи с внутренними устройствами ЭВМ. 2.Некоторые правила для работы с портами Следует иметь в виду что при разработке программ имеющих дело
<p>работы с портами следует учитывать следующие факторы :</p>
<p>а) Стараться использовать функции высокого уровня для доступа к портам (в частности WinAPI) и не прибегать к низкоуровневым операциям чтения/записи портов. Если вы все-таки решили писать низкоуровневое чтение то эти процедуры нужно выносить в отдельную DLL или VXD, по следующим причинам - известно, что операционная система Windows95/98 а особенно NT являются по своей сути многозадачными системами. То есть если ваша программа обращается конкретно к порту не через динамический вызов функции DLL или VXD ( использования механизма DLL) а напрямую то это может сказаться на корректной работе системы или даже завалить ее. И даже если в Windows95/98 такой подход вполне может работать то в Windows NT вследствие его архитектуры не разрешит непосредственное чтение/запись напрямую, а использование механизма DLL или VXD позволяет обойти эту проблему.</p>
<p>б)Если вы работаете с каким-то нестандартным портом ввода-вывода</p>
<p>(например портом хранящим состояние кнопок пульта ДУ TVTunera то наверняка в комплекте поставки родного софта найдется DLL или VXD для управления этим устройством и отпадет нужда писать код, так я при работе с пультом ДУ TVTunerа использую стандартную DLL поставляемую в комплекте, это сразу решило вопросы связанные с управлением портами данного тюнера)Итак, отступление &#8212; немного практики…</p>
<p>Маленький пример для работы с портами</p>
<p>(первый пример был уже опубликован в королевстве Дельфи</p>
<p>и представлял собой пример работы с весами ПетрВес)</p>
<pre>
function PortInit : boolean; //инициализация
var f: THandle; 
    ct: TCommTimeouts;
    dcb: TDCB;
begin
f := Windows.CreateFile(PChar('COM1'), GENERIC_READ or 
GENERIC_WRITE,
FILE_SHARE_READ or FILE_SHARE_WRITE,
nil, OPEN_EXISTING,
FILE_ATTRIBUTE_NORMAL, 0);
if (f &lt; 0) or not Windows.SetupComm(f, 2048, 2048)or not
Windows.GetCommState(f, dcb) then exit; //init error dcb.BaudRate := скоpость;
dcb.StopBits := стоп-биты;
dcb.Parity := ?етность;
dcb.ByteSize := 8;
if not Windows.SetCommState(f, dcb) or 
   not Windows.GetCommTimeouts(f, ct) then exit; //error
ct.ReadTotalTimeoutConstant := 50;
ct.ReadIntervalTimeout := 50;
ct.ReadTotalTimeoutMultiplier := 1;
ct.WriteTotalTimeoutMultiplier := 0;
ct.WriteTotalTimeoutConstant := 10;
if not Windows.SetCommTimeouts(f, ct)
   or not Windows.SetCommMask(f, EV_RING + EV_RXCHAR + EV_RXFLAG + EV_TXEMPTY)
  then exit; //error
result := true;
end;
 
function DoneComm: boolean; //закpыть поpт
begin
  result := Windows.CloseHandle(f);
end; 
 
function PostComm(var Buf; size: word): integer; //пеpеда?а в поpт
  var p: pointer; i: integer;
begin
p := @Buf;
result := 0;
while size &gt; 0 do 
begin
  if not WriteFile(f, p^, 1, i, nil) then exit;
  inc(result, i); inc(integer(p)); dec(size);
  Application.ProcessMessages;
end;
end; 
 
function ReadComm(var Buf; size: word): integer; //пpием из поpта
  var i: integer; ovr: TOverlapped;
begin
  fillChar(buf, size, 0);
  fillChar(ovr, sizeOf(ovr), 0); i := 0; result := -1;
  if not windows.ReadFile(f, buf, size, i, @ovr) then exit;
  result := i;
end; 
</pre>

<p>Данный пример был взят мной из многочисленный FAQ посвященных в DELPHI в сети ФИДО</p>
<p>Итак,для работы с портами COM и LPT нам понадобится знание функций Windows API. Вот подробное описание функций, которые нам нужны (в эквиваленте C) для работы с портами.</p>
<p>(извините за возможный местами неточный перевод ,если что поправьте меня если что не так перевел)</p>
<pre>
CreateFile HANDLE CreateFile( LPCTSTR lpFileName,// указатель на строку PCHAR с именем файла
DWORD dwDesiredAccess,// режим доступа
DWORD dwShareMode,// share mode
LPSECURITY_ATTRIBUTES lpSecurityAttributes,// указатель на атрибуты
DWORD dwCreationDistribution,// how to create
DWORD dwFlagsAndAttributes,// атрибуты файла
HANDLE hTemplateFile // хендл на temp файл
); Пример кода на Дельфи
&lt; вырезано&gt;
CommPort := 'COM2'; 
hCommFile := CreateFile(Pchar(CommPort), 
GENERIC_WRITE, 0, nil, 
OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL,
0);
</pre>

<p>&lt; вырезано&gt;</p>
<p>Параметры</p>
<p>LpFileName</p>
<p>Указатель на строку с нулевым символом в конце (PCHAR) ,</p>
<p>которая определяет название создаваемого объекта (файл,</p>
<p>канал, почтовый слот, ресурс связи (в данном случае порты),</p>
<p>дисковое устройство, приставка, или каталог)</p>
<p>DwDesiredAccess</p>
<p>Указывает тип доступа к объекту ,принимает значение</p>
<p>GENERIC_READ - для чтения</p>
<p>GENERIC_WRITE - для записи (смешивание с GENERIC_READ</p>
<p>операцией GENERIC_READ and GENERIC_WRITE предостовляет полный доступ )</p>
<p>dwShareMode</p>
<p>Набор разрядных флагов, которые определяют как объект может быть разделен по доступу к нему.</p>
<p>Если dwShareMode - 0, объект не может быть разделен.</p>
<p>Последовательные операции открытия объекта будут терпеть неудачу,</p>
<p>пока маркер(дескриптор) открытого объекта не будет закрыт.</p>
<p>Фактически предоставляется монопольный доступ. Чтобы разделять объект(цель), используйте комбинацию одних или большее количество следующих значений:</p>
<p>FILE_SHARE_DELETE (Только для Windows NT)</p>
<p>FILE_SHARE_READ</p>
<p>FILE_SHARE_WRITE</p>
<p>LpSecurityAttributes</p>
<p>Указатель на структуру SECURITY_ATTRIBUTES, которая определяет</p>
<p>может ли возвращенный дескриптор быть унаследован дочерними процессами.</p>
<p>Если lpSecurityAttributes НУЛЕВОЙ, маркер не может быть унаследован.</p>
<p>Используется только в windows NT.</p>
<p>dwCreationDistribution</p>
<p>Определяет поведение функции если объект уже существует и</p>
<p>как он будет открыт в этом случае Принимает одно из следующих значений :</p>
<p>CREATE_NEW</p>
<p>Создает новый объект (файл) Выдает ошибку если указанный объект (файл) уже существует.</p>
<p>CREATE_ALWAYS</p>
<p>Создает новый объект (файл) Функция перезаписывает существующий объект (файл)</p>
<p>OPEN_EXISTING</p>
<p>Открывает объект (файл) Выдает ошибку если указанный объект (файл) не существует.(Для более детального смотрите SDK)</p>
<p>OPEN_ALWAYS</p>
<p>Открывает объект (файл), если он существует. Если объект (файл) не существует,</p>
<p>функция создает его, как будто dwCreationDistribution были CREATE_NEW.</p>
<p>TRUNCATE_EXISTING</p>
<p>Открывает объект (файл). После этого объект (файл) будет</p>
<p>усечен до нулевого размера.Выдает ошибку если указанный объект (файл) не существует.</p>
<p>DwFlagsAndAttributes</p>
<p>Атрибуты объекта (файла) , атрибуты могут комбинироваться</p>
<p>FILE_ATTRIBUTE_ARCHIVE</p>
<p>FILE_ATTRIBUTE_COMPRESSED</p>
<p>FILE_ATTRIBUTE_HIDDEN</p>
<p>FILE_ATTRIBUTE_NORMAL</p>
<p>FILE_ATTRIBUTE_OFFLINE</p>
<p>FILE_ATTRIBUTE_READONLY</p>
<p>FILE_ATTRIBUTE_SYSTEM</p>
<p>FILE_ATTRIBUTE_TEMPORARY</p>
<p>HTemplateFile</p>
<p>Определяет дескриптор с GENERIC_READ доступом к временному объекту(файлу).</p>
<p>Временный объект(файл)поставляет атрибуты файла и расширенные атрибуты</p>
<p>для создаваемого объекта (файла)</p>
<p>ИСПОЛЬЗУЕТСЯ ТОЛЬКО В WINDOWS NT Windows 95: Это значение должно быть установлено в Nil.</p>
<p>Возвращаемые значения Если функция преуспевает, возвращаемое значение - открытый дескриптор</p>
<p>к указанному объекту(файлу). Если файл не существует - 0.</p>
<p>Если произошли функциональные сбои, возвращаемое значение - INVALID_HANDLE_VALUE.</p>
<p>Чтобы получить расширенные данные об ошибках, вызовите GetLastError. Обратите внимание !</p>
<p>Для портов, dwCreationDistribution параметр должен быть OPEN_EXISTING,</p>
<p>и hTemplate должен быть Nil. Доступ для чтения-записи должен быть определен явно. SECURITY_ATTRIBUTES Структура содержит описание защиты для объекта и определяет,</p>
<p>может ли дескриптор быть унаследован дочерними процессами.</p>
<p>typedef struct _SECURITY_ATTRIBUTES</p>
<p>{ DWORD nLength;</p>
<p>LPVOID lpSecurityDescriptor;</p>
<p>BOOL bInheritHandle;</p>
<p>} SECURITY_ATTRIBUTES; Параметры NLength</p>
<p>Определяет размер, в байтах, этой структуры.</p>
<p>Набор это значение к размеру структуры SECURITY_ATTRIBUTES В Windows NT</p>
<p>функции которые используют структуру SECURITY_ATTRIBUTES, не</p>
<p>LpSecurityDescriptor</p>
<p>Дескриптор указывающий на описатель защиты для объекта,</p>
<p>Если дескриптор ПУСТОЙ объект может быть назначен в наследование дочерними процессами.</p>
<p>BInheritHandle</p>
<p>Определяет, унаследован ли возвращенный дескриптор, когда новый дескриптор, создан.</p>
<p>Если это значение принимает ИСТИНУ новый дескриптор наследует от головного.</p>
<p>Замечания</p>
<p>Указатель на структуру SECURITY_ATTRIBUTES используется</p>
<p>как параметр в большинстве функций работы с окнами в Win32 API.</p>
<p>---------------------</p>
<p>Структура DCB Структура DCB определяет установку управления для последовательного порта ввода-вывода</p>
<p>(нам она понадобится для разбора примера с программой управления весами ПетрВес) Примечание : В местах где нельзя дать точный перевод</p>
<p>будет дано определение на английском из MSDK и приблизительный его перевод</p>
<p>Описание в эквиваленте C typedef struct _DCB { // dcb</p>
<p>DWORD DCBlength; // Размер DCB</p>
<p>DWORD BaudRate; // Скорость пересылки данных в бодах;</p>
<p>// текущая скорость в бодах</p>
<p>DWORD fBinary: 1; // binary mode, no EOF check</p>
<p>// двоичный режим , не проверять конец</p>
<p>// данных (по умолчанию значение = 1)</p>
<p>DWORD fParity: 1; // Включить проверку четность (по умолчанию</p>
<p>// значение = 1)</p>
<p>DWORD fOutxCtsFlow:1; // CTS управление потоком выхода</p>
<p>DWORD fOutxDsrFlow:1; // DSR управление потоком выхода</p>
<p>DWORD fDtrControl:2; // DTR Тип управления потоком скорости</p>
<p>// передачи данных</p>
<p>DWORD fDsrSensitivity:1; // DSR sensitivity (чувствительность)</p>
<p>DWORD fTXContinueOnXoff:1; // XOFF continues Tx (стоп-сигнал</p>
<p>// продалжает выполнение)</p>
<p>DWORD fOutX: 1; // XON/XOFF out flow control (СТАРТ-</p>
<p>// СИГНАЛ / СТОП-СИГНАЛ для управления</p>
<p>// выходящим потоком (по умолчанию</p>
<p>// значение = 1)</p>
<p>DWORD fInX: 1; // XON/XOFF in flow control (СТАРТ-</p>
<p>// СИГНАЛ / СТОП-СИГНАЛ для управления</p>
<p>// входящим потоком (по умолчанию</p>
<p>// значение = 1)</p>
<p>DWORD fErrorChar: 1; // enable error replacement (включить</p>
<p>// проверку погрешностей по умолчанию=1)</p>
<p>DWORD fNull: 1; // enable null stripping (отвергать</p>
<p>// пустой поток данных (по умолчанию=1))</p>
<p>DWORD fRtsControl:2; // RTS управление потоком данных</p>
<p>DWORD fAbortOnError:1; // abort reads/writes on error</p>
<p>// (проверять операции чтения/записи</p>
<p>// по умолчанию=1)</p>
<p>DWORD fDummy2:17; // reserved ЗАРЕЗЕРВИРОВАНО</p>
<p>WORD wReserved; // not currently used НЕ ДЛЯ</p>
<p>// ИСПОЛЬЗОВАНИЯ</p>
<p>WORD XonLim; // transmit XON threshold (порог</p>
<p>// чувствительности старт-сигнала)</p>
<p>WORD XoffLim; // transmit XOFF threshold (порог</p>
<p>// чувствительности стоп-сигнала)</p>
<p>BYTE ByteSize; // Бит в байте (обычно 8)</p>
<p>BYTE Parity; // 0-4=no,odd,even,mark,space</p>
<p>// (четность байта)</p>
<p>BYTE StopBits; // 0,1,2 = 1, 1.5, 2 (стоповые биты)</p>
<p>char XonChar; // Tx and Rx XON character (вид</p>
<p>// старт сигнал в потоке)</p>
<p>char XoffChar; // Tx and Rx XOFF character (вид</p>
<p>// стоп сигнал в потоке)</p>
<p>char ErrorChar; // error replacement character (какой</p>
<p>// сигнал погрешности,его вид)</p>
<p>char EofChar; // end of input character (сигнал</p>
<p>// окончания потока)</p>
<p>char EvtChar; // received event character РЕЗЕРВ</p>
<p>WORD wReserved1; // reserved; do not use НЕ ДЛЯ</p>
<p>// ИСПОЛЬЗОВАНИЯ</p>
<p>} DCB;</p>
<pre>
with Mode do
Begin
BaudRate := 9600;
ByteSize := 8;
Parity := NOPARITY;
StopBits := ONESTOPBIT; // одино?ный стоп-бит
Flags := EV_RXCHAR + EV_EVENT2;
End;
</pre>
</p>
<p>Параметры : DCBlength</p>
<p>Размер DCB структуры.</p>
<p>BaudRate</p>
<p>Определяет скорость в бодах, в которых порт оперирует.</p>
<p>Этот параметр может принимать фактическое значение скорости в бодах,</p>
<p>или один из следующих стандартных индексов скорости в бодах:</p>
<p>CBR_110 CBR_19200</p>
<p>CBR_300 CBR_38400</p>
<p>CBR_600 CBR_56000</p>
<p>CBR_1200CBR_57600</p>
<p>CBR_2400CBR_115200</p>
<p>CBR_4800CBR_128000</p>
<p>CBR_9600CBR_256000</p>
<p>CBR_14400 fBinary</p>
<p>Определяет, допускается ли двоичный (бинарный) способ передачи данных.</p>
<p>Win32 API не поддерживает недвоичные (небинарные)</p>
<p>способы передачи данных в потоке порта, так что этот параметр</p>
<p>должен быть всегда ИСТИНЕН.</p>
<p>Попытка использовать ЛОЖЬ в этом параметре не будет работать.</p>
<p class="note">Примечание : Под Windows 3.1 небинарный способ передачи допускается,</p>
<p>но для работы данного способа необходимо заполнит параметр</p>
<p>EofChar который будет восприниматься конец данных.</p>
<p>fParity</p>
<p>Определяет, допускается ли проверка четности.</p>
<p>Если этот параметр ИСТИНЕН, проверка четности допускается</p>
<p>fOutxCtsFlow</p>
<p>CTS (clear-to-send) управление потоком выхода</p>
<p>fOutxDsrFlow</p>
<p>DSR (data-set-ready) управление потоком выхода</p>
<p>fDtrControl</p>
<p>DTR (data-terminal-ready) управление потоком выхода</p>
<p>Принимает следующие значения :</p>
<p>DTR_CONTROL_DISABLE</p>
<p>Отключает линию передачи дынных</p>
<p>DTR_CONTROL_ENABLE</p>
<p>Включает линию передачи дынных</p>
<p>DTR_CONTROL_HANDSHAKE</p>
<p>Enables DTR handshaking. If handshaking is enabled,</p>
<p>it is an error for the application to adjust the line by using the EscapeCommFunction function.</p>
<p>Допускает подтверждению связи передачи данных</p>
<p>Если подтверждение связи допускается, это - погрешность для того чтобы регулировать(корректировать)</p>
<p>линию связи, используя функцию EscapeCommFunction.</p>
<p>fDsrSensitivity</p>
<p>Specifies whether the communications driver is sensitive to the state of the DSR signal.</p>
<p>If this member is TRUE, the driver ignores any bytes received, unless the DSR modem input line is high.</p>
<p>Определяет возможна ли по порту двухсторонняя передача в ту и в другую сторону сигнала.</p>
<p>fTXContinueOnXoff</p>
<p>Определяет, останавливается ли передача потока ,</p>
<p>когда входной буфер становится полный, и драйвер передает сигнал XoffChar.</p>
<p>Если этот параметр ИСТИНЕН, передача продолжается после того,</p>
<p>как входной буфер становится в пределах XoffLim байтов, и драйвер передает</p>
<p>сигнал XoffChar, чтобы прекратить прием байтов из потока .</p>
<p>Если этот параметр ЛОЖНЫЙ, передача не продолжается до тех пор ,</p>
<p>пока входной буфер не в пределах XonLim байтов,</p>
<p>и пока не получен сигнал XonChar, для возобновления приема .</p>
<p>fOutX</p>
<p>Определяет, используется ли управление потоком СТАРТ-СИГНАЛА / СТОП-СИГНАЛА</p>
<p>в течение передачи потока порту. Если этот параметр ИСТИНЕН, передача останавливается,</p>
<p>когда получен сигнал XoffChar и начинается снова, когда получен сигнал XonChar.</p>
<p>fInX</p>
<p>Specifies whether XON/XOFF flow control is used during reception. If this member is TRUE,</p>
<p>the XoffChar character is sent when the input buffer comes</p>
<p>within XoffLim bytes of being full, and the XonChar character is sent</p>
<p>when the input buffer comes within XonLim bytes of being empty.</p>
<p>Определяет, используется ли управление потоком СТАРТ-СИГНАЛА / СТОП-СИГНАЛА</p>
<p>в течение приема потока портом. Если этот параметр ИСТИНЕН,сигнал XoffChar посылается ,</p>
<p>когда входной буфер находится в пределах XoffLim байтов, а сигнал XonChar посылается</p>
<p>тогда когда входной буфер находится в пределах XonLim байтов или является пустым</p>
<p>fErrorChar</p>
<p>Определяет, заменены ли байты, полученные с ошибками четности особенностью,</p>
<p>указанной параметром ErrorChar Если этот параметр ИСТИНЕН, и fParity ИСТИНЕН, замена происходит.</p>
<p>fNull</p>
<p>Определяет, отвергнуты ли нулевые(пустые) байты. Если этот параметр ИСТИНЕН,</p>
<p>нулевые(пустые) байты, будут отвергнуты при получении их.</p>
<p>fRtsControl</p>
<p>RTS управление потоком " запрос пересылки " .</p>
<p>Если это значение нулевое, то по умолчанию устанавливается RTS_CONTROL_HANDSHAKE.</p>
<p>Принимает одно из следующих значений:</p>
<p>RTS_CONTROL_DISABLE</p>
<p>Отключает строку RTS, когда устройство открыто</p>
<p>RTS_CONTROL_ENABLE</p>
<p>Включает строку RTS</p>
<p>RTS_CONTROL_HANDSHAKE</p>
<p>Enables RTS handshaking. The driver raises the RTS line</p>
<p>when the " type-ahead" (input)</p>
<p>buffer is less than one-half full and lowers</p>
<p>the RTS line when the buffer is more than three-quarters full.</p>
<p>If handshaking is enabled, it is an error for the application</p>
<p>to adjust the line by using the EscapeCommFunction function.</p>
<p>Допускает RTS подтверждение связи. Драйвер управляет потоком пересылки.</p>
<p>RTS выравнивается , когда входной буфер - меньше чем половина полного и</p>
<p>понижается, когда буфер - больше 2/3 полного .Если подтверждение связи</p>
<p>допускается, это используется для регулирования передачи данных</p>
<p>EscapeCommFunction.</p>
<p>RTS_CONTROL_TOGGLE</p>
<p>Specifies that the RTS line will be high if bytes are available for transmission.</p>
<p>After all buffered bytes have been sent, the RTS line will be low.</p>
<p>Определяет, что буфер будет высокий при подготовке данных для передачи.</p>
<p>После того, как все байты отосланы, буфер RTS будет низок.</p>
<p>FAbortOnError</p>
<p>Определяет, закончена ли операции чтения/записи, если происходит погрешность.</p>
<p>Если этот параметр ИСТИНЕН, драйвер закрывает все операции</p>
<p>чтения/записи с состоянием погрешности при возникновении оной.</p>
<p>Драйвер не будет принимать никакие дальнейшие действия,</p>
<p>пока не дождется подтверждения погрешности в передоваемых</p>
<p>(принимаемых) данных, вызывая функцию ClearCommError.</p>
<p>fDummy2</p>
<p>ЗАРЕЗЕРВИРОВАНО Microsoft</p>
<p>wReserved</p>
<p>ЗАРЕЗЕРВИРОВАНО Microsoft</p>
<p>XonLim</p>
<p>Определяет минимальное число байтов, находящихся во в</p>
<p>XoffLim</p>
<p>Определяет максимальное число байтов, находящихся во входном буфере прежде,</p>
<p>чем будет генерирована подача СТОП-СИГНАЛА. Максимальное число байтов,</p>
<p>позволенных во входном буфере вычитается из размеров, в байтах, самого входного буфера.</p>
<p>ByteSize</p>
<p>Определяет число битов в байтах, переданных и полученных.</p>
<p>Parity</p>
<p>Определяет схему четности, которую нужно использовать.</p>
<p>Этот параметр может быть одним из следующих значений:</p>
<p>EVENPARITY</p>
<p>MARKPARITY</p>
<p>NOPARITY</p>
<p>ODDPARITY</p>
<p>StopBits</p>
<p>Определяет число стоповых битов, которые нужно использовать.</p>
<p>Этот параметр может быть одним из следующих значений:</p>
<p>ONESTOPBIT1 stop bit</p>
<p>ONE5STOPBITS1.5 stop bits</p>
<p>TWOSTOPBITS2 stop bits</p>
<p>XonChar</p>
<p>Определяет значение СТАРТ-СИГНАЛА для передачи и приема.</p>
<p>XoffChar</p>
<p>Определяет значение СТОП-СИГНАЛА для передачи и приема.</p>
<p>ErrorChar</p>
<p>Определяет значение СИГНАЛА ОШИБКИ (генерируемого при ошибке четности) для передачи и приема.</p>
<p>EofChar</p>
<p>Определяет значение сигнала конца данных.</p>
<p>EvtChar</p>
<p>Определяет значение сигнала события.</p>
<p>wReserved1</p>
<p>ЗАРЕЗЕРВИРОВАНО Microsoft</p>
<p>Дополнение : Когда структура DCB использует «ручной» выбор конфигурации ,</p>
<p>следующие ограничения используются для ByteSize и StopBits параметров :</p>
<p>Число информационных разрядов должно быть от 5 до 8 битов.</p>
<p>Использование 5 информационных разрядов с 2 стоповыми битами -</p>
<p>недопустимая комбинация, как - 6, 7, или 8 информационных разрядов с 1.5 стоповыми битами.</p>

<div class="author">Автор: Дмитрий Кузан, kuzan@fsskomi.parma.ru</div>
<p>Взято из FAQ:http://blackman.km.ru/myfaq/cont4.phtml</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

