<h1>Создание именных каналов</h1>
<div class="date">01.01.2007</div>


<p>Создание именных каналов. Автор: Стас Пономарёв.<br>
 <br>
В этой статье мы будем разбирать связь двух приложений с помощью именных каналов (named pipes). Рассмотрим типы каналов, а также создадим клиент и <br>
сервер.<br>
 <br>
1.Для чего именные каналы нужны:<br>
Именные каналы являются средством &#171;общения&#187; программ. Они широко используются в UNIX-подобных системах, однако и в Windows они нашли применение. С помощью именных каналов можно передать любую информацию, так как все каналы работают через файлы. Даже для чтения\записи данных в канале используется функция WinAPI для работы с файлами - ReadFile() и WriteFile(). Передаваться может переменная любого типа (Integer, Boolean, Tbitmap и так далее). Однако, надо заметить, что для передачи строки, она должна быть ограничена - String[40]; Иначе при чтении канала будет появляться ошибка.<br>
 <br>
2. Пример отправяемой переменной:<br>
<p>Далее в статье я буду использовать отправляемую переменную типа TpipeData, этот тип будет такой:</p>
<pre>
type TpipeData = packed record  //Имя можно изменить, а тип packed record оставьте
  pEvent:byte;
  ClientName: string[40]; //Заметьте, ограниченная строка
  Date:TdateTime;
End;
</pre>

<p> <br>
 <br>
Как я уже сказал, здесь можно передавать любые переменные<br>
 <br>
==========СЕРВЕРНАЯ ЧАСТЬ==========<br>
 <br>
3.Использование потоков (TThread):<br>
Как такового события записи в канал нет, поэтому придётся запускать цикл чтения. Как известно, циклы подвешивают программы (а точнее зацикливают). Application.ProcessMessages при работе с функцией ReadFile не поможет, так как ReadFile будет выполнятся до тех пор, пока кто-то что-то не запишет. Поэтому надо использовать потоки (TThread). Хочу заметить, что обращение к визуальным компонентам (формам, кнопкам, лэйблам и так далее) из дополнительных потоков невозможно. Для того, чтобы полученные данные не остались в дополнительном потоке, надо его синхронизироватьс главным. Для этого есть функция TThread.Synchronize(method: TtreadMethod); Параметром этой функции надо передовать Какой-нибудь метод(нами созданный) дополнительного потока, где есть обращение к визуальным компонентам. <br>
А теперь напишем код нашего потока:<br>
<p></p>
<pre>
type
  TPipeThread = class(TThread)
  private
  PipeData:TPipeData; //Вот он – наша приёмная переменная, а точнее буфер.
  Protected
    procedure Execute; override; //Здесь мы будем создавать канал и читать данные из него
  public
    procedure ShowData; //Здесь будем передовать данные форме
    constructor Create(CreateSuspended: Boolean); reintroduce; overload; //Создание потока
  end;
</pre>
<p> <br>
4. Работа сименными каналами:<br>
Здесь мы рассмотрим нашу процедуру TpipeThread.Execute; но сначала рассмотрим &#171;настройку&#187; наших каналов. Функция CreateNamedPipe доступна только серверу. Ей должны быть переданы следующие параметры:<br>
1. lpName - имя нашего канала, а точнее его директория. Если сервер будет расположен на той-же машине, что и клиент, то первый параметр должен быть такой: '\\.\PIPE\ИмяКанала', где имя канала - ваше название, только латинскими буквами<br>
2. dwOpenMode - работа канала может быть:<br>
PIPE_ACCESS_INBOUND - сервер может только читать канал<br>
PIPE_ACCESS_OTTBOUND - сервет может только записывать<br>
PIPE_ACCESS_DUPLEX - сервер может и писать и читать<br>
3. dwPipeMode - режим канала здесь говорится о синхронности\асинхронности канала, и о том, каким методом будетпроизводится обмен данных в канале. Значения:<br>
PIPE_WAIT - синхронный канал<br>
PIPE_NOWAIT - асинхронный канал<br>
PIPE_READMODE_BYTE - метод чтения - байты<br>
PIPE_READMODE_MESSAGE - метод чтения пакеты<br>
PIPE_TYPE_BYTE - тип канала - байты<br>
PIPE_TYPE_MESSAGE - тип канала пакеты.<br>
В dwPipeMode надо передавать три параметра, например, в нашем примере: PIPE_WAIT or PIPE_READMODE_MESSAGE or PIPE_TYPE_MESSAGE. А теперь, давайте вспомним наш тип TpipeData - он у нас packed, то есть - пакет. Поэтому наш канал работает с пакетами.<br>
4. hMaxInstances - максимальное число одновременных подключений - любое ваше число, однако можно указать PIPE_UNLIMITED_INSTANCES для безконечного числа клиентов.<br>
5. nOutBufferSize - разбер буфера чтения. Можно найти так - SizeOf(TpipeData) Это как раз тип нашего буфера.<br>
6. nInBufferSize - размер буфера записи. Обычно такой же как и буфер чтения.<br>
7. nDefaultTimeOut - максимальное время чтения (в милисекундах)<br>
8. lpSecurityArtributes - просто пишем nil.<br>
Также нам понядобятся фцнкции ConnectNamedPipe, ReadFile и DisconnectNamedPipe, но их параметры мы рассмотрим в процессе написания кода. И так, а теперь наша процедура:<br>
<p></p>
<pre>
procedure TPipeThread.Execute;
var
  hPipe: THandle; //Указатель на наш канал
  bytesRead: DWORD;  //Количество прочитанных байт
begin
  try
   hPipe := CreateNamedPipe('\\.\PIPE\OurPipe', //Наше имя
      PIPE_ACCESS_INBOUND, // сервер может только читать канал
      PIPE_WAIT or               // Синхронная работа
      PIPE_READMODE_MESSAGE or   // метод чтения - пакеты
      PIPE_TYPE_MESSAGE,
      PIPE_UNLIMITED_INSTANCES,        // Бесконечно много клиентов
      SizeOf(Tpipedata), //размер буфера чтения
      SizeOf(Tpipedata), // размер буфера записи
                        100,                  // Тайм-аут
      nil);                      // Артребуты безопасности.
    if hPipe = INVALID_HANDLE_VALUE then Exit; //Если не удалось создать канал, то выходим
 
    while true do //Теперь читаем, пока не надоест!
    begin
      try
        ConnectNamedPipe(hPipe, nil); //Подключаемся к каналу, второй параметр 
                                      //нужен только, если вместо PIPE_WAIT вы указали PIPE_NOWAIT
 
        //Теперь читаем, параметры – указатель на канал, наш буфер, 
        //кол-во прочитанных байт, и последнее опять таки только для PIPE_NOWAIT.
        if ReadFile(hPipe, PipeData, SizeOf(TpipeData), bytesRead, nil) then
        begin
        Synchronize(ShowData); //Синхронизируемся с главным потоком
        end;
      finally
        DisconnectNamedPipe(hPipe); //Закрываем канал, параметры – только указатель
      end;
     end;
  finally
  end;
end;
</pre>
<br>
Ну вот, это большая часть нашего сервера. Функцию ShowData можно сделать такую:<br>
<p></p>
<pre>
procedure TPipeThread.ShowData;
begin
Case PipeData.pEvent of
1:form1.Memo1.Lines.Add('======Событие 1======');
2:form1.Memo1.Lines.Add('=========Событие 2==========');
end;
form1.Memo1.Lines.Add('Программа '+PipeData.Clientname+' открыла канал');
form1.Memo1.Lines.Add(DateTostr(PipeData.Date));
form1.Memo1.Lines.Add('');
end;
</pre>
<p class="p_CodeExample" style="white-space: normal;"> <br>
 <br>
==========КЛИЕНТ==========<br>
<p>Теперь пришло время написать наш клиент. Так как нам нужо только подключиться и выкинуть данные серверу, а затем сразу отключиться, то весь код клиета можно поместить в одну процедуру:</p>
<pre>
procedure SendToServer; // Замечу, что должна быть переменная такого же 
                        //типа TpipeData, как и у сервера. Допустим, это Data
var
  hPipe: THandle;
  bytesWritten: DWORD;
begin
  hPipe := CreateFile('\\.\PIPE\OurPipe', //Как видите, здесь мы подключаемся 
                                          //даже не к каналу, а к файлу
    GENERIC_WRITE, //Только запись
    FILE_SHARE_READ or // Обмениваемся чтенью\записью
    FILE_SHARE_WRITE,
    nil, //Артрибуты безопасности
    OPEN_EXISTING,   // Канал должен быть создан
    0, 0);
  if hPipe = INVALID_HANDLE_VALUE then Exit; //Если произошла ошибка, выходим
 
 if WriteFile(hPipe, Data, SizeOf(TpipeData), bytesWritten,
    nil) then  DisconnectNamedPipe(hpipe); //Если удачно запиали, закрываем канал.
end;
</pre>

<p> <br>
Исходник клиента - так же можно найти в аттаче!<br>
Всё. Теперь вы знаете, как передовать кучу переменных своим программам из других!<br>
 <br>
Хочу поблагодарить www.sources.ru, www.delphimasters.ru а также Alex-Eraser <br>

<div class="author">Автор: Стас Пономарёв</div>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
