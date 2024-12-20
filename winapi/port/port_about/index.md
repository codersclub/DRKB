---
Title: Что такое порт? Правила для работы с портами
Author: Дмитрий Кузан, kuzan@fsskomi.parma.ru
Date: 01.01.2007
Source: http://blackman.km.ru/myfaq/cont4.phtml
---


Что такое порт? Правила для работы с портами
============================================

Известно, что в компьютере очень много собрано различных устройств.
Возникает вопрос, как операционная система общается с ними. Для этого и
служит порт, то есть это «дверь», через которую программа (операционная
система) может управлять данным устройством (считывать данные, заносить
их).

Причем я разделяю порты на две категории (это чисто мое разделение) -
порты общеизвестные (COM LPT) и порты внутренние, служащие для связи с
внутренними устройствами ЭВМ.

**Некоторые правила для работы с портами**

Следует иметь в виду, что при разработке программ, имеющих дело
с работой с портами, следует учитывать следующие факторы:

а) Стараться использовать функции высокого уровня для доступа к портам
(в частности WinAPI) и не прибегать к низкоуровневым операциям
чтения/записи портов. Если вы все-таки решили писать низкоуровневое
чтение, то эти процедуры нужно выносить в отдельную DLL или VXD, по
следующим причинам - известно, что операционная система Windows95/98 а
особенно NT являются по своей сути многозадачными системами. То есть
если ваша программа обращается конкретно к порту не через динамический
вызов функции DLL или VXD (использования механизма DLL) а напрямую то
это может сказаться на корректной работе системы или даже завалить ее. И
даже если в Windows95/98 такой подход вполне может работать то в Windows
NT вследствие его архитектуры не разрешит непосредственное чтение/запись
напрямую, а использование механизма DLL или VXD позволяет обойти эту
проблему.

б) Если вы работаете с каким-то нестандартным портом ввода-вывода
(например портом хранящим состояние кнопок пульта ДУ TVTunera, то
наверняка в комплекте поставки родного софта найдется DLL или VXD для
управления этим устройством и отпадет нужда писать код, так я при работе
с пультом ДУ TVTunerа использую стандартную DLL, поставляемую в
комплекте, это сразу решило вопросы связанные с управлением портами
данного тюнера)Итак, отступление - немного практики...

**Маленький пример для работы с портами**

(первый пример был уже опубликован в королевстве Дельфи
и представлял собой пример работы с весами ПетрВес)

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
      if (f < 0) or not Windows.SetupComm(f, 2048, 2048)or not
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
      while size > 0 do 
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

Данный пример был взят мной из многочисленный FAQ посвященных в DELPHI в
сети ФИДО

Итак, для работы с портами COM и LPT нам понадобится знание функций
Windows API. Вот подробное описание функций, которые нам нужны (в
эквиваленте C) для работы с портами.

(извините за возможный местами неточный перевод, если что - поправьте меня,
если что не так перевел)

    CreateFile HANDLE CreateFile(
      LPCTSTR lpFileName,// указатель на строку PCHAR с именем файла
      DWORD dwDesiredAccess,// режим доступа
      DWORD dwShareMode,// share mode
      LPSECURITY_ATTRIBUTES lpSecurityAttributes,// указатель на атрибуты
      DWORD dwCreationDistribution,// how to create
      DWORD dwFlagsAndAttributes,// атрибуты файла
      HANDLE hTemplateFile // хендл на temp файл
    );

Пример кода на Дельфи

    < вырезано >
    CommPort := 'COM2'; 
    hCommFile := CreateFile(Pchar(CommPort), GENERIC_WRITE, 0, nil, 
      OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, 0);
    < вырезано >

Параметры

- LpFileName - Указатель на строку с нулевым символом в конце (PCHAR),
которая определяет название создаваемого объекта (файл,
канал, почтовый слот, ресурс связи (в данном случае порты),
дисковое устройство, приставка, или каталог)

- DwDesiredAccess - Указывает тип доступа к объекту, принимает значение

    * GENERIC\_READ - для чтения
    * GENERIC\_WRITE - для записи (смешивание с GENERIC\_READ
      операцией GENERIC\_READ and GENERIC\_WRITE предостовляет полный доступ )

- dwShareMode - Набор разрядных флагов, которые определяют как объект может быть
разделен по доступу к нему.
Если dwShareMode - 0, объект не может быть разделен.

    Последовательные операции открытия объекта будут терпеть неудачу,
    пока маркер (дескриптор) открытого объекта не будет закрыт.

    Фактически предоставляется монопольный доступ. Чтобы разделять
    объект (цель), используйте комбинацию одного или большее количество
    следующих значений:

    * FILE\_SHARE\_DELETE (Только для Windows NT)
    * FILE\_SHARE\_READ
    * FILE\_SHARE\_WRITE

- LpSecurityAttributes - Указатель на структуру SECURITY\_ATTRIBUTES, которая определяет
может ли возвращенный дескриптор быть унаследован дочерними процессами.

    Если lpSecurityAttributes НУЛЕВОЙ, маркер не может быть унаследован.

    Используется только в windows NT.

- dwCreationDistribution -
Определяет поведение функции если объект уже существует и
как он будет открыт в этом случае Принимает одно из следующих значений:

    * CREATE\_NEW - Создает новый объект (файл) Выдает ошибку если указанный объект (файл)
    уже существует.
    * CREATE\_ALWAYS - Создает новый объект (файл) Функция перезаписывает существующий объект
    (файл)
    * OPEN\_EXISTING - Открывает объект (файл) Выдает ошибку если указанный объект (файл) не
    существует.(Для более детального смотрите SDK)
    * OPEN\_ALWAYS - Открывает объект (файл), если он существует. Если объект (файл) не
    существует, функция создает его, как будто dwCreationDistribution были CREATE\_NEW.
    * TRUNCATE\_EXISTING - Открывает объект (файл). После этого объект (файл) будет
    усечен до нулевого размера.Выдает ошибку если указанный объект (файл) не
    существует.

- DwFlagsAndAttributes - Атрибуты объекта (файла), атрибуты могут комбинироваться

    * FILE\_ATTRIBUTE\_ARCHIVE
    * FILE\_ATTRIBUTE\_COMPRESSED
    * FILE\_ATTRIBUTE\_HIDDEN
    * FILE\_ATTRIBUTE\_NORMAL
    * FILE\_ATTRIBUTE\_OFFLINE
    * FILE\_ATTRIBUTE\_READONLY
    * FILE\_ATTRIBUTE\_SYSTEM
    * FILE\_ATTRIBUTE\_TEMPORARY

- HTemplateFile - Определяет дескриптор с GENERIC\_READ доступом к временному
объекту(файлу).

    Временный объект(файл)поставляет атрибуты файла и расширенные атрибуты
    для создаваемого объекта (файла)

    ИСПОЛЬЗУЕТСЯ ТОЛЬКО В WINDOWS NT Windows 95: Это значение должно быть
    установлено в Nil.

Возвращаемые значения:

Если функция преуспевает, возвращаемое значение - открытый дескриптор
к указанному объекту(файлу). Если файл не существует - 0.

Если произошли функциональные сбои, возвращаемое значение -
INVALID\_HANDLE\_VALUE.

Чтобы получить расширенные данные об ошибках, вызовите GetLastError.
Обратите внимание !

Для портов, dwCreationDistribution параметр должен быть OPEN\_EXISTING,
и hTemplate должен быть Nil. Доступ для чтения-записи должен быть
определен явно. SECURITY\_ATTRIBUTES Структура содержит описание защиты
для объекта и определяет,
может ли дескриптор быть унаследован дочерними процессами.

    typedef struct _SECURITY_ATTRIBUTES {
      DWORD nLength;
      LPVOID lpSecurityDescriptor;
      BOOL bInheritHandle;
    } SECURITY_ATTRIBUTES;

Параметры:

- NLength - Определяет размер, в байтах, этой структуры.

    Набор это значение к размеру структуры SECURITY\_ATTRIBUTES В Windows NT
    функции которые используют структуру SECURITY\_ATTRIBUTES, не

- LpSecurityDescriptor - Дескриптор указывающий на описатель защиты для объекта,
Если дескриптор ПУСТОЙ объект может быть назначен в наследование
дочерними процессами.

- BInheritHandle - Определяет, унаследован ли возвращенный дескриптор, когда новый
дескриптор, создан.

    Если это значение принимает ИСТИНУ новый дескриптор наследует от
    головного.

**Замечания**

Указатель на структуру SECURITY\_ATTRIBUTES используется
как параметр в большинстве функций работы с окнами в Win32 API.


**Структура DCB**

Структура DCB определяет установку управления для
последовательного порта ввода-вывода
(нам она понадобится для разбора примера с программой управления весами
ПетрВес)

**Примечание:**
В местах где нельзя дать точный перевод
будет дано определение на английском из MSDK и приблизительный его перевод.

Описание в эквиваленте C

    typedef struct \_DCB { // dcb
      DWORD DCBlength; // Размер DCB
      DWORD BaudRate; // Скорость пересылки данных в бодах;
      // текущая скорость в бодах
      DWORD fBinary: 1; // binary mode, no EOF check
      // двоичный режим, не проверять конец данных (по умолчанию значение = 1)
      DWORD fParity: 1; // Включить проверку четность (по умолчанию значение = 1)
      DWORD fOutxCtsFlow:1; // CTS управление потоком выхода
      DWORD fOutxDsrFlow:1; // DSR управление потоком выхода
      DWORD fDtrControl:2; // DTR Тип управления потоком скорости передачи данных
      DWORD fDsrSensitivity:1; // DSR sensitivity (чувствительность)
      DWORD fTXContinueOnXoff:1; // XOFF continues Tx (стоп-сигнал продолжает выполнение)
      DWORD fOutX: 1; // XON/XOFF out flow control
      // (СТАРТ-СИГНАЛ / СТОП-СИГНАЛ для управления выходящим потоком
      // (по умолчанию значение = 1)
      DWORD fInX: 1; // XON/XOFF in flow control
      // (СТАРТ-СИГНАЛ / СТОП-СИГНАЛ для управления входящим потоком
      // (по умолчанию значение = 1)
      DWORD fErrorChar: 1; // enable error replacement
      // (включить проверку погрешностей по умолчанию=1)
      DWORD fNull: 1; // enable null stripping
      // (отвергать пустой поток данных (по умолчанию=1))
      DWORD fRtsControl:2; // RTS управление потоком данных
      DWORD fAbortOnError:1; // abort reads/writes on error
      // (проверять операции чтения/записи по умолчанию=1)
      DWORD fDummy2:17; // reserved ЗАРЕЗЕРВИРОВАНО
      WORD wReserved; // not currently used (НЕ ДЛЯ ИСПОЛЬЗОВАНИЯ)
      WORD XonLim; // transmit XON threshold (порог чувствительности старт-сигнала)
      WORD XoffLim; // transmit XOFF threshold (порог чувствительности стоп-сигнала)
      BYTE ByteSize; // Бит в байте (обычно 8)
      BYTE Parity; // 0-4=no,odd,even,mark,space (четность байта)
      BYTE StopBits; // 0,1,2 = 1, 1.5, 2 (стоповые биты)
      char XonChar; // Tx and Rx XON character (вид старт сигнал в потоке)
      char XoffChar; // Tx and Rx XOFF character (вид стоп сигнал в потоке)
      char ErrorChar; // error replacement character (какой сигнал погрешности,его вид)
      char EofChar; // end of input character (сигнал окончания потока)
      char EvtChar; // received event character РЕЗЕРВ
      WORD wReserved1; // reserved; do not use (НЕ ДЛЯ ИСПОЛЬЗОВАНИЯ)
    } DCB;

Вызов на Дельфи:

    with Mode do
    Begin
      BaudRate := 9600;
      ByteSize := 8;
      Parity := NOPARITY;
      StopBits := ONESTOPBIT; // одиночный стоп-бит
      Flags := EV_RXCHAR + EV_EVENT2;
    End;


Параметры:

- DCBlength - Размер DCB структуры.

- BaudRate - Определяет скорость в бодах, в которых порт оперирует.

    Этот параметр может принимать фактическое значение скорости в бодах,
    или один из следующих стандартных индексов скорости в бодах:

    * CBR\_110 CBR\_19200
    * CBR\_300 CBR\_38400
    * CBR\_600 CBR\_56000
    * CBR\_1200CBR\_57600
    * CBR\_2400CBR\_115200
    * CBR\_4800CBR\_128000
    * CBR\_9600CBR\_256000
    * CBR\_14400 fBinary

    Определяет, допускается ли двоичный (бинарный) способ передачи данных.

    Win32 API не поддерживает недвоичные (небинарные)
    способы передачи данных в потоке порта, так что этот параметр
    должен быть всегда ИСТИНЕН.

    Попытка использовать ЛОЖЬ в этом параметре не будет работать.

**Примечание:**
Под Windows 3.1 небинарный способ передачи допускается,
но для работы данного способа необходимо заполнит параметр
EofChar который будет восприниматься конец данных.

- fParity - Определяет, допускается ли проверка четности.

    Если этот параметр ИСТИНЕН, проверка четности допускается

- fOutxCtsFlow - CTS (clear-to-send) управление потоком выхода

- fOutxDsrFlow - DSR (data-set-ready) управление потоком выхода

- fDtrControl - DTR (data-terminal-ready) управление потоком выхода

    Принимает следующие значения :

* DTR\_CONTROL\_DISABLE - Отключает линию передачи дынных
* DTR\_CONTROL\_ENABLE - Включает линию передачи дынных
* DTR\_CONTROL\_HANDSHAKE - Enables DTR handshaking. If handshaking is enabled,
it is an error for the application to adjust the line by using the
EscapeCommFunction function.

    Допускает подтверждению связи передачи данных.

    Если подтверждение связи допускается, это - погрешность для того чтобы
    регулировать(корректировать)
    линию связи, используя функцию EscapeCommFunction.

- fDsrSensitivity - Specifies whether the communications driver is sensitive to the state of
the DSR signal.

    If this member is TRUE, the driver ignores any bytes received, unless
    the DSR modem input line is high.

    Определяет возможна ли по порту двухсторонняя передача в ту и в другую
    сторону сигнала.

- fTXContinueOnXoff - Определяет, останавливается ли передача потока,
когда входной буфер становится полный, и драйвер передает сигнал
XoffChar.

    Если этот параметр ИСТИНЕН, передача продолжается после того,
    как входной буфер становится в пределах XoffLim байтов, и драйвер
    передает сигнал XoffChar, чтобы прекратить прием байтов из потока .

    Если этот параметр ЛОЖНЫЙ, передача не продолжается до тех пор,
    пока входной буфер не в пределах XonLim байтов,
    и пока не получен сигнал XonChar, для возобновления приема .

- fOutX - Определяет, используется ли управление потоком СТАРТ-СИГНАЛА /
СТОП-СИГНАЛА в течение передачи потока порту. Если этот параметр ИСТИНЕН, передача
останавливается,
когда получен сигнал XoffChar и начинается снова, когда получен сигнал
XonChar.

- fInX - Specifies whether XON/XOFF flow control is used during reception. If
this member is TRUE,
the XoffChar character is sent when the input buffer comes
within XoffLim bytes of being full, and the XonChar character is sent
when the input buffer comes within XonLim bytes of being empty.

    Определяет, используется ли управление потоком СТАРТ-СИГНАЛА /
    СТОП-СИГНАЛА в течение приема потока портом. Если этот параметр ИСТИНЕН,сигнал
    XoffChar посылается,
    когда входной буфер находится в пределах XoffLim байтов, а сигнал
    XonChar посылается,
    тогда когда входной буфер находится в пределах XonLim байтов или
    является пустым.

- fErrorChar - Определяет, заменены ли байты, полученные с ошибками четности
особенностью,
указанной параметром ErrorChar Если этот параметр ИСТИНЕН, и fParity
ИСТИНЕН, замена происходит.

- fNull - Определяет, отвергнуты ли нулевые(пустые) байты. Если этот параметр
ИСТИНЕН, нулевые(пустые) байты, будут отвергнуты при получении их.

- fRtsControl - RTS управление потоком " запрос пересылки " .

    Если это значение нулевое, то по умолчанию устанавливается
    RTS\_CONTROL\_HANDSHAKE.

    Принимает одно из следующих значений:

    * RTS\_CONTROL\_DISABLE - Отключает строку RTS, когда устройство открыто
    * RTS\_CONTROL\_ENABLE - Включает строку RTS
    * RTS\_CONTROL\_HANDSHAKE - Enables RTS handshaking. The driver raises the RTS line
    when the " type-ahead" (input)
    buffer is less than one-half full and lowers
    the RTS line when the buffer is more than three-quarters full.
    If handshaking is enabled, it is an error for the application
    to adjust the line by using the EscapeCommFunction function.

        Допускает RTS подтверждение связи. Драйвер управляет потоком пересылки.

        RTS выравнивается, когда входной буфер - меньше чем половина полного и
        понижается, когда буфер - больше 2/3 полного .Если подтверждение связи
        допускается, это используется для регулирования передачи данных
        EscapeCommFunction.

    * RTS\_CONTROL\_TOGGLE - Specifies that the RTS line will be high if bytes are available for
    transmission.

        After all buffered bytes have been sent, the RTS line will be low.

        Определяет, что буфер будет высокий при подготовке данных для передачи.

        После того, как все байты отосланы, буфер RTS будет низок.

- FAbortOnError - Определяет, закончена ли операции чтения/записи, если происходит
погрешность.

    Если этот параметр ИСТИНЕН, драйвер закрывает все операции
    чтения/записи с состоянием погрешности при возникновении оной.

    Драйвер не будет принимать никакие дальнейшие действия,
    пока не дождется подтверждения погрешности в передоваемых
    (принимаемых) данных, вызывая функцию ClearCommError.

- fDummy2 - ЗАРЕЗЕРВИРОВАНО Microsoft

- wReserved - ЗАРЕЗЕРВИРОВАНО Microsoft

- XonLim - Определяет минимальное число байтов, находящихся во в

- XoffLim - Определяет максимальное число байтов, находящихся во входном буфере
прежде, чем будет генерирована подача СТОП-СИГНАЛА. Максимальное число байтов,
позволенных во входном буфере вычитается из размеров, в байтах, самого
входного буфера.

- ByteSize - Определяет число битов в байтах, переданных и полученных.

- Parity - Определяет схему четности, которую нужно использовать.

    Этот параметр может быть одним из следующих значений:

    * EVENPARITY
    * MARKPARITY
    * NOPARITY
    * ODDPARITY

- StopBits - Определяет число стоповых битов, которые нужно использовать.

    Этот параметр может быть одним из следующих значений:

    * ONESTOPBIT1 stop bit
    * ONE5STOPBITS1.5 stop bits
    * TWOSTOPBITS2 stop bits

- XonChar - Определяет значение СТАРТ-СИГНАЛА для передачи и приема.

- XoffChar - Определяет значение СТОП-СИГНАЛА для передачи и приема.

- ErrorChar - Определяет значение СИГНАЛА ОШИБКИ (генерируемого при ошибке четности)
для передачи и приема.

- EofChar - Определяет значение сигнала конца данных.

- EvtChar - Определяет значение сигнала события.

- wReserved1 - ЗАРЕЗЕРВИРОВАНО Microsoft

**Дополнение:**
Когда структура DCB использует «ручной» выбор конфигурации,
следующие ограничения используются для ByteSize и StopBits параметров:

- Число информационных разрядов должно быть от 5 до 8 битов.
- Использование 5 информационных разрядов с 2 стоповыми битами -
недопустимая комбинация, как - 6, 7, или 8 информационных разрядов с 1.5
стоповыми битами.

