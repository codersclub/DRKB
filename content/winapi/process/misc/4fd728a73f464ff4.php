<h1>Синхронизация процессов при работе с Windows (статья)</h1>
<div class="date">01.01.2007</div>


<p>Задача синхронизации встает при одновременном доступе нескольких процессов (или нескольких потоков одного процесса) к какому-либо ресурсу. Поскольку поток в Win32 может быть остановлен в любой, заранее ему неизвестный момент времени возможна ситуация, когда один из потоков не успел завершить модификацию ресурса (например, отображенной на файл области памяти), но был остановлен, а другой поток попытался обратиться к этому же ресурсу. В этот момент ресурс находится в несогласованном состоянии, и последствия обращения к нему могут быть самыми неожиданными &#8211; от порчи данных, до нарушения защиты памяти.</p>
<p>Главной идеей, положенной в основу синхронизации потоков в Win32 является использование объектов синхронизации и функций ожидания. Объекты могут находиться в одном из двух состояний &#8211; Signaled или Not Signaled. Функции ожидания блокируют выполнение потока до тех пор, пока заданный объект находится в состоянии Not Signaled. Таким образом, поток, которому необходим эксклюзивный доступ к ресурсу, должен выставить какой-либо объект синхронизации в несигнальное состояние, а по окончании &#8211; сбросить его в сигнальное. Остальные потоки должны перед доступом к этому ресурсу вызвать функцию ожидания, которая позволит им дождаться освобождения ресурса.</p>
<p>Рассмотрим, какие объекты и функции синхронизации предоставляет нам Win32 API.</p>
Функции синхронизации</p>
<p>Функции синхронизации делятся на две основные категории &#8211; это функции, ожидающие единственного объекта и функции, ожидающие одного из нескольких объектов</p>
Функции, ожидающие единственного объекта</p>
<p>Простейшей функцией ожидания является </p>
<p>function WaitForSingleObject(</p>
<p>  hHandle: THandle;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // идентификатор объекта</p>
<p>  dwMilliseconds: DWORD&nbsp;&nbsp; // период ожидания</p>
<p>): DWORD; stdcall;</p>
<p>Функция ожидает перехода объекта hHandle в сигнальное состояние в течении dwMilliseconds миллисекунд. Если в качестве параметра dwMilliseconds передать значение INFINITE, функция будет ждать в течение неограниченного времени. Если dwMilliseconds равен 0, то функция проверяет состояние объекта и немедленно возвращает управление. </p>
<p>Функция возвращает одно из следующих значений:</p>
<p>WAIT_ABANDONED &nbsp; &nbsp; &nbsp; &nbsp;Поток, владевший объектом, завершился, не переведя объект в сигнальное состояние. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>WAIT_OBJECT_0 &nbsp; &nbsp; &nbsp; &nbsp;Объект перешел в сигнальное состояние &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>WAIT_TIMEOUT &nbsp; &nbsp; &nbsp; &nbsp;Истек срок ожидания. Обычно в этом случае генерируется ошибка, либо функция вызывается в цикле до получения другого результата &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>WAIT_FAILED &nbsp; &nbsp; &nbsp; &nbsp;Произошла ошибка, например неверное значение hHandle. Более подробную информацию можно получить, вызвав GetLastError &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Следующий фрагмент кода запрещает Action1 до перехода объекта ObjectHandle в сигнальное состояние. Например, таким образом можно дожидаться завершения процесса, предав в качестве ObjectHandle его идентификатор, полученный функцией CreateProcess.</p>
<pre>
var
  Reason: DWORD;
  ErrorCode: DWORD;
 
Action1.Enabled := FALSE;
try
  repeat
    Application.ProcessMessages;
    Reason := WailForSingleObject(ObjectHandle, 10);
    if Reason = WAIT_FAILED then begin
      ErrorCode := GetLastError;
      raise Exception.CreateFmt(
        'Wait for object failed with error: %d', [ErrorCode]);
    end;
  until Reason &lt;&gt; WAIT_TIMEOUT;
finally
  Actionl.Enabled := TRUE;
end;
 
</pre>
<p>В случае, когда требуется одновременно с ожиданием объекта, перевести в сигнальное состояние другой объект может использоваться функция:</p>
<p>function SignalObjectAndWait(</p>
<p>  hObjectToSignal: THandle;&nbsp; // объект, который будет переведен в</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // сигнальное состояние </p>
<p>  hObjectToWaitOn: THandle;&nbsp; // объект, которого ожидает функция</p>
<p>  dwMilliseconds: DWORD;&nbsp;&nbsp;&nbsp;&nbsp; // период ожидания</p>
<p>  bAlertable: BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // задает, должна ли функция возвращать</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // управление в случае запроса на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // завершение операции ввода-вывода</p>
<p>): DWORD; stdcall;</p>
<p>Возвращаемые значения аналогичны функции WaitForSingleObject.</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">!</td><td>В модуле Windows.pas эта функция ошибочно объявлена, как возвращающая значение BOOL. Если Вы намерены её использовать &#8211; объявите её корректно или используйте приведение типа возвращенного значения к DWORD</td></tr></table>
<p>Объект hObjectToSignal может быть семафором, событием (event), либо мутексом. Параметр bAlertable определяет, будет ли прерываться ожидание объекта, в случае, если операционная система запросит у потока окончание операции асинхронного ввода-вывода, либо асинхронный вызов процедуры. Более подробно это обсуждается ниже.</p>
&nbsp;</p>
Функции, ожидающие нескольких объектов</p>
<p>Иногда требуется задержать выполнение потока до срабатывания одного или всех сразу из группы объектов. Для решения подобной задачи служат следующие функции:</p>
<p>type</p>
<p>  TWOHandleArray = array[0..MAXIMUM_WAIT_OBJECTS - 1] of THandle;</p>
<p>  PWOHandleArray = ^TWOHandleArray;</p>
<p>function WaitForMultipleObjects(</p>
<p>  nCount: DWORD;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Задает количество объектов</p>
<p>  lpHandles: PWOHandleArray;&nbsp; // Адрес массива объектов</p>
<p>  bWaitAll: BOOL;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Задает, требуется ожидание всех</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // объектов или любого</p>
<p>  dwMilliseconds: DWORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Период ожидания</p>
<p>): DWORD; stdcall;</p>
<p>Функция возвращает одно из следующих значений:</p>
<p>Число в диапазоне от WAIT_OBJECT_0 до WAIT_OBJECT_0 + nCount &#8211; 1 &nbsp; &nbsp; &nbsp; &nbsp;Если bWaitAll равно TRUE, то это число означает, что все объекты перешли в сигнальное состояние. Если FALSE &#8211; то, вычтя из возвращенного значения WAIT_OBJECT_0, мы получим индекс объекта в массиве lpHandles. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Число в диапазоне от WAIT_ABANDONED_0 до WAIT_ABANDONED_0 + nCount &#8211; 1 &nbsp; &nbsp; &nbsp; &nbsp;Если bWaitAll равно TRUE &#8211; это означает, что все перешли в сигнальное состояние, но хотя бы один из владевших ими потоков завершился, не сделав объект сигнальным. Если FALSE &#8211; то, вычтя из возвращенного значения WAIT_ABANDONED_0,&nbsp; мы получим индекс объекта в массиве lpHandles, поток, владевший которым, завершился, не сделав его сигнальным. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>WAIT_TIMEOUT &nbsp; &nbsp; &nbsp; &nbsp;Истек период ожидания &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>WAIT_FAILED &nbsp; &nbsp; &nbsp; &nbsp;Произошла ошибка &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Например, в следующем фрагменте кода программа пытается модифицировать два различных ресурса, разделяемых между потоками. </p>
<pre>
var
  Handles: array[0..1] of THandle;
  Reason: DWORD;
  RestIndex: Integer;
 
...
 
Handles[0] := OpenMutex(SYNCHRONIZE, FALSE, 'FirstResource');
Handles[1] := OpenMutex(SYNCHRONIZE, FALSE, 'SecondResource');
// Ждем первого из объектов
Reason := WaitForMultipleObjects(2, @Handles, FALSE, INFINITE);
case Reason of
  WAIT_FAILED: RaiseLastWin32Error;
  WAIT_OBJECT_0, WAIT_ABANDONED_0:
    begin
      ModifyFirstResource;
      RestIndex := 1;
    end;
  WAIT_OBJECT_0 + 1, WAIT_ABANDONED_0 + 1:
    begin
      ModifySecondResource;
      RestIndex := 0;
    end;
  // WAIT_TIMEOUT возникнуть не может
end;
// Теперь ожидаем освобождения следующего объекта
if WailForSingleObject(Handles[RestIndex], 
     INFINITE) = WAIT_FAILED then
       RaiseLastWin32Error;
// Дождались, модифицируем оставшийся ресурс.
if RestIndex = 0 then
  ModifyFirstResource
else
 ModifySecondResource;
</pre>
<p>Описанную выше технику можно применять, если Вы точно знаете, что задержка ожидания объекта окажется небольшой. В противном случае Ваша программа окажется "замороженной" и не сможет даже перерисовать своё окно. Если период задержки может оказаться значительным, то необходимо дать программе возможность реагировать на сообщения Windows. Выходом может служить использование функций с ограниченным периодом ожидания (и повторный вызов, в случае возврата WAIT_TIMEOUT), либо использование функции:</p>
<p>function MsgWaitForMultipleObjects(</p>
<p>  nCount: DWORD;&nbsp;&nbsp;&nbsp;&nbsp; // количество объектов синхронизации</p>
<p>  var pHandles;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // адрес массива объектов</p>
<p>  fWaitAll: BOOL;&nbsp;&nbsp;&nbsp; // Задает, требуется ожидание всех</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // объектов или любого</p>
<p>  dwMilliseconds,&nbsp;&nbsp;&nbsp; // Период ожидания</p>
<p>  dwWakeMask: DWORD&nbsp; // Тип события, прерывающего ожидание</p>
<p>): DWORD; stdcall;</p>
<p>Главное отличие этой функции от предыдущей &#8211; параметр dwWakeMask, который является комбинацией битовых флагов QS_XXX и задает типы сообщений, которые прерывают ожидание функции, независимо от состояния ожидаемых объектов. Например, маска QS_KEY позволяет прервать ожидание при появлении в очереди сообщений WM_KEYUP, WM_KEYDOWN, WM_SYSKEYUP или WM_SYSKEYDOWN, а маска QS_PAINT - сообщения WM_PAINT. Полный список значений, допустимых для dwWakeMask имеется в документации по Windows SDK. При появлении в очереди потока, вызвавшего функцию, сообщений, соответствующих заданной маске функция возвращает значение WAIT_OBJECT_0 + nCount. Получив это значение, Ваша программа может обработать его и снова вызвать функцию ожидания. Рассмотрим пример с запуском внешнего приложения. Необходимо, чтобы на время его работы вызывающая программа не реагировала на ввод пользователя, однако её окно должно продолжать перерисовываться.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  PI: TProcessInformation;
  SI: TStartupInfo;
  Reason: DWORD;
  Msg: TMsg;
begin
  // Инициализируем структуру TStartupInfo
  FillChar(SI, SizeOf(SI), 0);
  SI.cb := SizeOf(SI);
  // Запускаем внешнюю программу
  Win32Check(CreateProcess(NIL, 'COMMAND.COM', NIL,
    NIL, FALSE, 0, NIL, NIL, SI, PI));
//**************************************************
// Попробуйте заменить нижеприведенный код на строку
// WaitForSingleObject(PI.hProcess, INFINITE);
// и посмотреть, как будет реагировать программа на
// перемещение других окон над её окном
//**************************************************
  repeat
    // Ожидаем завершения дочернего процесса или сообщения 
    // перерисовки WM_PAINT
    Reason := MsgWaitForMultipleObjects(1, PI.hProcess, FALSE,
      INFINITE, QS_PAINT);
    if Reason = WAIT_OBJECT_0 + 1 then begin
      // В очереди сообщений появился WM_PAINT – Windows
      // требует обновить окно программы.
      // Удаляем сообщение из очереди
      PeekMessage(Msg, 0, WM_PAINT, WM_PAINT, PM_REMOVE);
      // И перерисовываем наше окно
      Update;
    end;
    // Повторяем цикл, пока не завершится дочерний процесс
  until Reason = WAIT_OBJECT_0;
  // Удаляем из очереди накопившиеся там сообщения
  while PeekMessage(Msg, 0, 0, 0, PM_REMOVE) do;
  CloseHandle(PI.hProcess);
  CloseHandle(PI.hThread)
end;
</pre>
<p>Если в потоке, вызывающем функции ожидания явно (функцией CreateWindow) или неявно (используя TForm, DDE, COM) создаются окна Windows &#8211; поток должен обрабатывать сообщения. Поскольку широковещательные сообщения посылаются всем окнам в системе &#8211; поток, не обрабатывающий сообщения может вызвать взаимоблокировку, (система ждет, когда поток обработает сообщение, поток &#8211; когда система или другие потоки освободят объект) и привести к зависанию Windows. Если в Вашей программе имеются подобные фрагменты &#8211; необходимо использовать MsgWaitForMultipleObjects или MsgWaitForMultipleObjectsEx и позволять прервать ожидание для обработки сообщений. Алгоритм аналогичен вышеприведенному примеру.</p>
&nbsp;</p>
Прерывание ожидания по запросу на завершение операции ввода-вывода или APC</p>
<p>Windows поддерживает асинхронные вызовы процедур. При создании каждого потока (thread) с ним ассоциируется очередь асинхронных вызовов процедур (APC queue). Операционная система (или приложение пользователя, при помощи функции QueueUserAPC) может помещать в неё запросы на выполнение функций в контексте этого потока. Эти функции не могут быть выполнены немедленно, поскольку поток может быть занят. Поэтому, операционная система вызывает их, когда поток вызывает одну из следующих функций ожидания:</p>
<p>function SleepEx(</p>
<p>  dwMilliseconds: DWORD;&nbsp;&nbsp; // Период ожидания</p>
<p>  bAlertable: BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // задает, длжна ли функция возвращать</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // управление в случае запроса на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // асинхронный вызов процедуры</p>
<p>): DWORD; stdcall;</p>
<p>function WaitForSingleObjectEx(</p>
<p>  hHandle: THandle;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Идентификатор объекта</p>
<p>  dwMilliseconds: DWORD; // Период ожидания</p>
<p>  bAlertable: BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // задает, длжна ли функция возвращать</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // управление в случае запроса на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // асинхронный вызов процедуры</p>
<p>): DWORD; stdcall;</p>
<p>function WaitForMultipleObjectsEx(</p>
<p>  nCount: DWORD;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // количество объектов</p>
<p>  lpHandles: PWOHandleArray;// адрес массива идентификаторов объектов</p>
<p>  bWaitAll: BOOL;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Задает, требуется ожидание всех</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // объектов или любого</p>
<p>  dwMilliseconds: DWORD;&nbsp;&nbsp;&nbsp; // Период ожидания</p>
<p>  bAlertable: BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // задает, должна ли функция возвращать</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // управление в случае запроса на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // асинхронный вызов процедуры</p>
<p>): DWORD; stdcall;</p>
<p>function SignalObjectAndWait(</p>
<p>  hObjectToSignal: THandle;&nbsp; // объект, который будет переведен в</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // сигнальное состояние </p>
<p>  hObjectToWaitOn: THandle;&nbsp; // объект, которого ожидает функция</p>
<p>  dwMilliseconds: DWORD;&nbsp;&nbsp;&nbsp;&nbsp; // период ожидания</p>
<p>  bAlertable: BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // задает, должна ли функция возвращать</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // управление в случае запроса на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // асинхронный вызов процедуры</p>
<p>): DWORD; stdcall;</p>
<p>function MsgWaitForMultipleObjectsEx(</p>
<p>nCount: DWORD;&nbsp;&nbsp;&nbsp;&nbsp; // количество объектов синхронизации</p>
<p>  var pHandles;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // адрес массива объектов</p>
<p>  fWaitAll: BOOL;&nbsp;&nbsp;&nbsp; // Задает, требуется ожидание всех</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // объектов или любого</p>
<p>  dwMilliseconds,&nbsp;&nbsp;&nbsp; // Период ожидания</p>
<p>  dwWakeMask: DWORD&nbsp; // Тип события, прерывающего ожидание</p>
<p>  dwFlags: DWORD&nbsp;&nbsp;&nbsp;&nbsp; // Дополнительные флаги</p>
<p>): DWORD; stdcall;</p>
<p>Если параметр bAlertable равен TRUE (либо dwFlags в функции MsgWaitForMultipleObjectsEx содержит MWMO_ALERTABLE) , то при появлении в очереди APC запроса на асинхронный вызов процедуры операционная система выполняет вызовы всех имеющихся в очереди процедур, после чего функция возвращает значение WAIT_IO_COMPLETION.</p>
<p>Такой механизм позволяет реализовать, например, асинхронный ввод-вывод. Поток может инициировать фоновое выполнение одной или нескольких операций ввода-вывода функциями ReadFileEx или WriteFileEx, передав им адреса функций-обработчиков завершения операции. По завершении вызовы этих функций будут поставлены в очередь асинхронного вызова процедур. В свою очередь, инициировавший операции поток, когда он будет готов обработать результаты, может, используя одну из вышеприведенных функций ожидания, позволить операционной системе вызвать функции-обработчики. Поскольку очередь APC реализована на уровне ядра ОС, она более эффективна, чем очередь сообщений и позволяет реализовать гораздо более эффективный ввод-вывод.</p>
&nbsp;</p>
Объекты синхронизации</p>
<p>Объектами синхронизации называются объекты Windows, идентификаторы которых могут использоваться в функциях синхронизации. Они делятся на две группы &#8211; объекты, использующиеся только для синхронизации и объекты, которые используются в других целях, но могут вызывать срабатывание функций ожидания. К первой группе относятся:</p>
<p>Event (событие)</p>
<p>Позволяет известить один или несколько ожидающих потоков о наступлении события. Event бывает</p>
<p>Отключаемый вручную &nbsp; &nbsp; &nbsp; &nbsp;Будучи установленным в сигнальное состояние, остается в нем до тех пор, пока не будет переключен явным вызовом функции ResetEvent &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Автоматически отключаемый &nbsp; &nbsp; &nbsp; &nbsp;Автоматически переключается в несигнальное состояние операционной системой, когда один из ожидающих его потоков завершается. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Для создания объекта используется функция:</p>
<p>function CreateEvent(</p>
<p>  lpEventAttributes: PSecurityAttributes;&nbsp; // Адрес структуры</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // TSecurityAttributes</p>
<p> &nbsp; bManualReset,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Задает, будет Event переключаемым </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // вручную (TRUE) или автоматически (FALSE)</p>
<p> &nbsp; bInitialState: BOOL;&nbsp; // Задает начальное состояние. Если TRUE - </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // объект в сигнальном состоянии</p>
<p> &nbsp; lpName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя или NIL, если имя не требуется</p>
<p>): THandle; stdcall;&nbsp;&nbsp;&nbsp;&nbsp; // Возвращает идентификатор созданного</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // объекта</p>
<p>Структура TSecurityAttributes описана, как:</p>
<p>TSecurityAttributes = record</p>
<p>  nLength: DWORD;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Размер структуры, должен </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // инициализироваться как </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // SizeOf(TSecurityAttributes)</p>
<p>  lpSecurityDescriptor: Pointer; // Адрес дескриптора защиты. В </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Windows 95 и 98 игнорируется</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Обычно можно указывать NIL</p>
<p>  bInheritHandle: BOOL;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Задает, могут ли дочерние </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // процессы наследовать объект</p>
<p>end;</p>
<p>Если не требуется задание особых прав доступа под Windows NT или возможности наследования объекта дочерними процессами, в качестве параметра lpEventAttributes можно передавать NIL. В этом случае объект не может наследоваться дочерними процессами и ему задается дескриптор защиты «по умолчанию». </p>
<p>Параметр lpName позволяет разделять объекты между процессами. Если lpName совпадает с именем уже существующего объекта типа Event, созданного текущим или любым другим процессом, функция не создает нового объекта, а возвращает идентификатор уже существующего. При этом игнорируются параметры bManualReset, bInitialState и lpSecurityDescriptor. Проверить, был объект создан, или используется уже существующий можно следующим образом:</p>
<p>hEvent := CreateEvent(NIL, TRUE, FALSE, 'EventName');</p>
<p>if hEvent = 0 then</p>
<p>  RaiseLastWin32Error;</p>
<p>if GetLastError = ERROR_ALREADY_EXISTS then begin</p>
<p>  // Используем ранее созданный объект</p>
<p>end;</p>
<p>Если объект используется для синхронизации внутри одного процесса, его можно объявить как глобальную переменную и создавать без имени.</p>
<p>Имя объекта не должно совпадать с именем любого из существующих объектов типов Semaphore, Mutex, Job, Waitable Timer или FileMapping. В случае совпадения имен, функция возвращает ошибку.</p>
<p>Если известно, что Event уже создан, для получения доступа к нему можно вместо CreateEvent воспользоваться функцией:</p>
<p>function OpenEvent(</p>
<p>  dwDesiredAccess: DWORD;&nbsp; // Задает права доступа к объекту</p>
<p>  bInheritHandle: BOOL;&nbsp;&nbsp;&nbsp; // Задает, может ли объект наследоваться </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // дочерними процессами</p>
<p>  lpName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя объекта</p>
<p>): THandle; stdcall;</p>
<p>Функция возвращает идентификатор объекта, либо 0, в случае ошибки. Параметр dwDesiredAccess может принимать одно из следующих значений:</p>
<p>EVENT_ALL_ACCESS &nbsp; &nbsp; &nbsp; &nbsp;Приложение получает полный доступ к объекту &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>EVENT_MODIFY_STATE &nbsp; &nbsp; &nbsp; &nbsp;Приложение может изменять состояние объекта функциями SetEvent и ResetEvent &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>SYNCHRONIZE &nbsp; &nbsp; &nbsp; &nbsp;Только для Windows NT &#8211; приложение может использовать объект только в функциях ожидания &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>После получения идентификатора можно приступать к его использованию. Для этого имеются следующие функции:</p>
<p>function SetEvent(hEvent: THandle): BOOL; stdcall;</p>
<p>Устанавливает объект в сигнальное состояние</p>
<p>function ResetEvent(hEvent: THandle): BOOL; stdcall;</p>
<p>Сбрасывает объект, устанавливая его в несигнальное состояние</p>
<p>function PulseEvent(hEvent: THandle): BOOL; stdcall</p>
<p>Устанавливает объект в сигнальное состояние, дает отработать всем функциям ожидания, ожидающим этот объект, а затем снова сбрасывает его.</p>
<p>В WinAPI события используются, для выполнения операций асинхронного ввода-вывода. Следующий пример показывает, как приложение инициирует запись одновременно в два файла, а затем ожидает завершения записи перед продолжением работы. Такой подход может обеспечить более высокую производительность при высокой интенсивности ввода-вывода, чем последовательная запись.</p>
<pre>
var
  Events: array[0..1] of THandle;  // Массив объектов синхронизации
  Overlapped: array[0..1] of TOverlapped; 
 
...
 
// Создаем объекты синхронизации
Events[0] := CreateEvent(NIL, TRUE, FALSE, NIL);
Events[1] := CreateEvent(NIL, TRUE, FALSE, NIL);
 
// Инициализируем структуры TOverlapped
FillChar(Overlapped, SizeOf(Overlapped), 0);
Overlapped[0].hEvent := Events[0];
Overlapped[1].hEvent := Events[1];
 
// Начинаем асинхронную запись в файлы
WriteFile(hFirstFile, FirstBuffer, SizeOf(FirstBuffer),
  FirstFileWritten, @Overlapped[0]);
WriteFile(hSecondFile, SecondBuffer, SizeOf(SecondBuffer),
  SecondFileWritten, @Overlapped[1]);
 
// Ожидаем завершения записи в оба файла
WaitForMultipleObjects(2, @Events, TRUE, INFINITE);
 
// Уничтожаем объекты синхронизации
CloseHandle(Events[0]);
CloseHandle(Events[1]);
</pre>
<p>По завершении работы с объектом, он должен быть уничтожен функцией CloseHandle.</p>
<p>Delphi предоставляет класс TEvent, инкапсулирующий функциональность объекта Event. Класс расположен в модуле SyncObjs.pas и объявлен следующим образом:</p>
<pre>
type
  TWaitResult = (wrSignaled, wrTimeout, wrAbandoned, wrError);
 
  TEvent = class(THandleObject)
  public
    constructor Create(EventAttributes: PSecurityAttributes;
      ManualReset, InitialState: Boolean; const Name: string);
    function WaitFor(Timeout: DWORD): TWaitResult;
    procedure SetEvent;
    procedure ResetEvent;
  end;
</pre>

<p>Назначение методов очевидно из их названий. Использование этого класса позволяет не вдаваться в тонкости реализации вызываемых функций Windows API. Для простейших случаев объявлен еще один класс с упрощенным конструктором.</p>
<pre>
type
  TSimpleEvent = class(TEvent)
  public
    constructor Create;
  end;
 
…
 
constructor TSimpleEvent.Create;
begin
  FHandle := CreateEvent(nil, True, False, nil);
end;
</pre>

<p>Mutex (Mutually Exclusive)</p>
<p>Мутекс &#8211; это объект синхронизации, который находится в сигнальном состоянии только тогда, когда он не принадлежит ни одному из процессов. Как только хотя бы один процесс запрашивает владение мутексом, он переходит в несигнальное состояние и остается в нем до тех пор, пока не будет освобожден владельцем. Такое поведение позволяет использовать мутексы для синхронизации совместного доступа нескольких процессов к разделяемому ресурсу. Для создания мутекса используется функция:</p>
<p>function CreateMutex(</p>
<p>  lpMutexAttributes: PSecurityAttributes;&nbsp; // Адрес структуры </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // TSecurityAttributes</p>
<p>  bInitialOwner: BOOL;&nbsp; // Задает, будет ли процесс владеть</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // мутексом сразу после создания</p>
<p>  lpName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя мутекса</p>
<p>): THandle; stdcall;</p>
<p>Функция возвращает идентификатор созданного объекта, либо 0. Если мутекс с заданным именем уже был создан, возвращается его идентификатор. В этом случае функция GetLastError вернет код ошибки ERROR_ALREDY_EXISTS. Имя не должно совпадать с именем уже существующего объекта типов Semaphore, Event, Job, Waitable Timer или FileMapping</p>
<p>Если неизвестно, существует ли уже мутекс с таким именем, программа не должна запрашивать владение объектом при создании (т.е. должна передать в качестве bInitialOwner значение FALSE).</p>
<p>Если мутекс уже существует, приложение может получить его идентификатор функцией</p>
<p>function OpenMutex(</p>
<p>  dwDesiredAccess: DWORD;&nbsp; // Задает права доступа к объекту</p>
<p>  bInheritHandle: BOOL;&nbsp;&nbsp;&nbsp; // Задает, может ли объект наследоваться </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // дочерними процессами</p>
<p>  lpName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя объекта</p>
<p>): THandle; stdcall;</p>
<p>Параметр dwDesiredAccess может принимать одно из следующих значений</p>
<p>MUTEX_ALL_ACCESS &nbsp; &nbsp; &nbsp; &nbsp;Приложение получает полный доступ к объекту &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>SYNCHRONIZE &nbsp; &nbsp; &nbsp; &nbsp;Только для Windows NT &#8211; приложение может использовать объект только в функциях ожидания и функции ReleaseMutex &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Функция возвращает идентификатор открытого мутекса, либо 0, в случае ошибки. Мутекс переходит в сигнальное состояние после срабатывания функции ожидания, в которую был передан его идентификатор. Для возврата в несигнальное состояние служит функция</p>
<p>function ReleaseMutex(hMutex: THandle): BOOL; stdcall;</p>
<p>Если несколько процессов обмениваются данными, например, через файл, отображенный на память, каждый из них должен содержать следующий код для обеспечения корректного доступа к общему ресурсу:</p>
<pre>
var
  Mutex: THandle;
 
// При инициализации программы
Mutex := CreateMutex(NIL, FALSE, 'UniqueMutexName');
if Mutex = 0 then
  RaiseLastWin32Error;
 
...
// Доступ к ресурсу
WaitForSingleObject(Mutex, INFINITE);
try
  // Доступ к ресурсу, захват мутекса гарантирует,
  // что остальные процессы пытающиеся получить доступ
  // будут остановлены на функции WaitForSingleObject
  ...
finally
  // Работа с ресурсом окончена, освобождаем его
  // для остальных процессов
  ReleaseMutex(Mutex);
end;
 
...
// При завершении программы
CloseHandle(Mutex);
</pre>

<p>Подобный код удобно инкапсулировать в класс, который создает защищенный ресурс, мутекс, имеет свойства и методы для оперирования ресурсом, защищая их при помощи функций синхронизации.</p>
<p>Разумеется, если работа с ресурсом может потребовать значительного времени, то необходимо либо использовать функцию MsgWaitForSingleObject, либо вызывать WaitForSingleObject в цикле с нулевым периодом ожидания, проверяя код возврата. В противном случае Ваше приложение окажется замороженным. Всегда защищайте захват-освобождение объекта синхронизации при помощи блока try ... finally, иначе ошибка во время работы с ресурсом приведет к блокированию работы всех процессов, ожидающих его освобождения.</p>
<p>Semaphore (семафор)</p>
<p>Семафор представляет собой счетчик, содержащий целое число в диапазоне от 0 до заданной при его создании максимальной величины. Счетчик уменьшается каждый раз, когда поток успешно завершает функцию ожидания, использующую семафор и увеличивается вызовом функции ReleaseSemaphore. При достижении семафором значения 0 он переходит в несигнальное состояние, при любых других значениях счетчика &#8211; его состояние сигнальное. Такое поведение позволяет использовать семафор в качестве ограничителя доступа к ресурсу, поддерживающему заранее заданное количество подключений.</p>
<p>Для создания семафора служит функция:</p>
<p>function CreateSemaphore(</p>
<p>  lpSemaphoreAttributes: PSecurityAttributes; // Адрес структуры </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // TSecurityAttributes</p>
<p>  lInitialCount,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Начальное значение счетчика</p>
<p>  lMaximumCount: Longint;&nbsp; // Максимальное значение счетчика</p>
<p>  lpName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя объекта</p>
<p>): THandle; stdcall;</p>
<p>Функция возвращает идентификатор созданного семафора, либо 0, если создать объект не удалось. </p>
<p>Параметр lMaximumCount задает максимальное значение счетчика семафора, lInitialCount задает начальное значение счетчика и должен быть в диапазоне от 0 до lMaximumCount. lpName задает имя семафора. Если в системе уже есть семафор с таким именем, то новый не создается, а возвращается идентификатор существующего семафора. В случае если семафор используется внутри одного процесса, можно создать его без имени, передав в качестве lpName значение NIL. Имя семафора не должно совпадать с именем уже существующего объекта типов event, mutex, waitable timer, job, или file-mapping.</p>
<p>Идентификатор ранее созданного семафора может быть, также, получен функцией:</p>
<p>function OpenSemaphore(</p>
<p>  dwDesiredAccess: DWORD;&nbsp; // Задает права доступа к объекту</p>
<p>  bInheritHandle: BOOL;&nbsp;&nbsp;&nbsp; // Задает, может ли объект наследоваться </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // дочерними процессами</p>
<p>  lpName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя объекта</p>
<p>): THandle; stdcall;</p>
<p>Параметр dwDesiredAccess может принимать одно из следующих значений:</p>
<p>SEMAPHORE_ALL_ACCESS &nbsp; &nbsp; &nbsp; &nbsp;Поток получает все права на семафор &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>SEMAPHORE_MODIFY_STATE &nbsp; &nbsp; &nbsp; &nbsp;Поток может увеличивать счетчик семафора функцией ReleaseSemaphore &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>SYNCHRONIZE &nbsp; &nbsp; &nbsp; &nbsp;Только Windows NT &#8211; поток может использовать семафор в функциях ожидания &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Для увеличения счетчика семафора используется функция:</p>
<p>function ReleaseSemaphore(</p>
<p>  hSemaphore: THandle;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Идентификатор семафора</p>
<p>  lReleaseCount: Longint;&nbsp;&nbsp; // Счетчик будет увеличен на эту величину</p>
<p>  lpPreviousCount: Pointer&nbsp; // Адрес 32-битной переменной, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // принимающей предыдущее значение</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // счетчика</p>
<p>): BOOL; stdcall;</p>
<p>Если значение счетчика после выполнения функции превысит заданный для него функцией CreateSemaphore максимум, то ReleaseSemaphore возвращает FALSE и значение семафора не изменяется. В качестве параметра lpPreviousCount можно передать NIL, если это значение нам не нужно.</p>
<p>Рассмотрим пример приложения, запускающего на выполнение несколько заданий в отдельных потоках (например, программа для фоновой загрузки файлов из Internet). Если количество одновременно выполняющихся заданий будет слишком велико, то это приведет к неоправданной загрузке канала. Поэтому реализуем потоки, в которых будет выполняться задание таким образом, чтобы при превышении их количества заранее заданной величины поток останавливался и ожидал завершения работы ранее запущенных заданий.</p>
<pre>
unit LimitedThread;
 
interface
 
uses Classes;
 
type
  TLimitedThread = class(TThread)
    procedure Execute; override;
  end;
 
implementation
 
uses Windows;
 
const
  MAX_THREAD_COUNT = 10;
 
var
  Semaphore: THandle;
 
procedure TLimitedThread.Execute;
begin
  // Уменьшаем счетчик семафора. Если к этому моменту уже запущено
  // MAX_THREAD_COUNT потоков – счетчик равен 0 и семафор в 
  // несигнальном состоянии. Поток будет заморожен до завершения 
  // одного из запущенных ранее.
  WaitForSingleObject(Semaphore, INFINITE);
 
  // Здесь располагается код, отвечающий за функциональность потока,
  // например загрузка файла
  ...
 
  // Поток завершил работу, увеличиваем счетчик семафора и позволяем
  // начать обработку другим потокам.
  ReleaseSemaphore(Semaphore, 1, NIL);
end;
 
initialization
  // Создаем семафор при старте программы
  Semaphore := CreateSemaphore(NIL, MAX_THREAD_COUNT, 
    MAX_THREAD_COUNT, NIL);
 
finalization
  // Уничтожаем семафор по завершении программы
  CloseHandle(Semaphore);
end;
</pre>

<p>Waitable timer (таймер ожидания)</p>
<p>Таймер ожидания отсутствует в Windows 95 и для его использования необходима Windows 98 или Windows NT 4.0 и выше.</p>
<p>Таймер ожидания переходит в сигнальное состояние по завершении заданного интервала времени. Для его создания используется функция:</p>
<p>function CreateWaitableTimer(</p>
<p>  lpTimerAttributes: PSecurityAttributes;&nbsp;&nbsp;&nbsp;&nbsp; // Адрес структуры </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // TSecurityAttributes</p>
<p>  bManualReset: BOOL;&nbsp; // Задает, будет ли таймер переходить в </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // сигнальное состояние по завершении функции</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // ожидания</p>
<p>  lpTimerName: PChar&nbsp;&nbsp; // Имя объекта</p>
<p>): THandle; stdcall; </p>
<p>Если параметр bManualReset равен TRUE, то таймер после срабатывания функции ожидания остается в сигнальном состоянии до явного вызова SetWaitableTimer, если FALSE - таймер автоматически переходит в несигнальное состояние. </p>
<p>Если lpTimerName совпадает с именем уже существующего в системе таймера &#8211; функция возвращает его идентификатор, позволяя использовать объект для синхронизации между процессами. Имя таймера не должно совпадать с именем уже существующих объектов типов event, semaphore, mutex, job или file-mapping.</p>
<p>Идентификатор уже существующего таймера можно получить функцией:</p>
<p>function OpenWaitableTimer(</p>
<p>  dwDesiredAccess: DWORD;&nbsp; // Задает права доступа к объекту</p>
<p>  bInheritHandle: BOOL;&nbsp;&nbsp;&nbsp; // Задает, может ли объект наследоваться </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // дочерними процессами</p>
<p>  lpTimerName: PChar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя объекта</p>
<p>): THandle; stdcall;</p>
<p>Параметр dwDesiredAccess может принимать следующие значения:</p>
<p>TIMER_ALL_ACCESS &nbsp; &nbsp; &nbsp; &nbsp;Разрешает полный доступ к объекту &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>TIMER_MODIFY_STATE &nbsp; &nbsp; &nbsp; &nbsp;Разрешает изменять состояние таймера функциями SetWaitableTimer и CancelWaitableTimer &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>SYNCHRONIZE &nbsp; &nbsp; &nbsp; &nbsp;Только Windows NT &#8211; разрешает использовать таймер в функциях ожидания &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>После получения идентификатора таймера, поток может задать время его срабатывания функцией </p>
<p>function SetWaitableTimer(</p>
<p>  hTimer: THandle;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Идентификатор таймера</p>
<p>  const lpDueTime: TLargeInteger;&nbsp;&nbsp; // Время срабатывания</p>
<p>  lPeriod: Longint;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Период повторения срабатывания</p>
<p>  pfnCompletionRoutine: TFNTimerAPCRoutine;&nbsp; // Процедура-обработчик</p>
<p>  lpArgToCompletionRoutine: Pointer;// Параметр процедуры-обработчика</p>
<p>  fResume: BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Задает, будет ли операционная </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // система «пробуждаться»</p>
<p>): BOOL; stdcall;</p>
<p>Рассмотрим параметры подробнее.</p>
<p>lpDueTime</p>
<p>Задает время срабатывания таймера. Время задается в формате TFileTime и базируется на coordinated universal time (UTC), т.е. должно указываться по Гринвичу. Для преобразования системного времени в TFileTime используется функция SystemTimeToFileTime. Если время имеет положительный знак, оно трактуется как абсолютное, если отрицательный &#8211; как относительное от момента запуска таймера.</p>
<p>lPeriod</p>
<p>Задает срок между повторными срабатываниями таймера. Если lPeriod равен 0 &#8211; таймер сработает один раз.</p>
<p>pfnCompletionRoutine</p>
<p>Адрес функции, объявленной как:</p>
<p>procedure TimerAPCProc(</p>
<p>  lpArgToCompletionRoutine: Pointer;&nbsp; // данные</p>
<p>  dwTimerLowValue: DWORD;&nbsp;&nbsp; // младшие 32 разряда значения таймера</p>
<p>  dwTimerHighValue: DWORD;&nbsp; // старшие 32 разряда значения таймера</p>
<p>); stdcall;</p>
<p>Эта функция вызывается, когда срабатывает таймер, если поток, ожидающий его срабатывания, использует функцию ожидания, поддерживающую асинхронный вызов процедур. В функцию передаются 3 параметра:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>lpArgToCompletionRoutine &#8211; значение, переданное в качестве одноименного параметра в функцию SetWaitableTimer. Приложение может использовать его для передачи в процедуру обработки адреса блока данных, необходимых для её работы</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>dwTimerLowValue и dwTimerHighValue &#8211; соответственно члены dwLowDateTime и dwHighDateTime структуры TFileTime. Они описывают время срабатывания таймера. Время задается в UTC формате (по Гринвичу).</td></tr></table></div><p>Если дополнительная функция обработки не нужна, в качестве этого параметра можно передать NIL.</p>
<p>lpArgToCompletionRoutine</p>
<p>Это значение передается в функцию pfnCompletionRoutine при её вызове.</p>
<p>fResume</p>
<p>Определяет необходимость "пробуждения" системы, если на момент срабатывания таймера она находится в режиме экономии электроэнергии (suspended). Если операционная система не поддерживает пробуждение и fResume равно TRUE, функция SetWaitableTimer выполнится успешно, однако последующий вызов GetLastError вернет результат ERROR_NOT_SUPPORTED.</p>
<p>Если необходимо перевести таймер в неактивное состояние, это можно сделать функцией:</p>
<p>function CancelWaitableTimer(hTimer: THandle): BOOL; stdcall;</p>
<p>Эта функция не изменяет состояния таймера и не приводит к срабатыванию функций ожидания и вызову процедур-обработчиков.</p>
<p>По завершении работы объект должен быть уничтожен функцией CloseHandle</p>
<p>Создадим класс, который ожидает в отдельном потоке наступления заданного времени, а затем вызывает процедуру главного потока приложения. Такой класс может использоваться, например, в планировщике заданий. Поскольку таймер ожидания позволяет задавать время срабатывания в абсолютных величинах, отпадает необходимость постоянно анализировать текущее время, используя обычный таймер Windows.</p>
<pre>
unit WaitThread;
 
interface
 
uses Classes, Windows;
 
type
  TWaitThread = class(TThread)
    WaitUntil: TDateTime;
    procedure Execute; override;
  end;
 
implementation
 
uses SysUtils;
 
procedure TWaitThread.Execute;
var
  Timer: THandle;
  SystemTime: TSystemTime;
  FileTime, LocalFileTime: TFileTime;
begin
  Timer := CreateWaitableTimer(NIL, FALSE, NIL);
  try
    DateTimeToSystemTime(WaitUntil, SystemTime);
    SystemTimeToFileTime(SystemTime, LocalFileTime);
    LocalFileTimeToFileTime(LocalFileTime, FileTime);
    SetWaitableTimer(Timer, TLargeInteger(FileTime), 0, 
      NIL, NIL, FALSE);
    WaitForSingleObject(Timer, INFINITE);
  finally
    CloseHandle(Timer);
  end;
end;
 
end.
Использовать этот класс можно, например, следующим образом:
type
  TForm1 = class(TForm)
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  private
    procedure TimerFired(Sender: TObject);
  end;
 
...
 
 
implementation
 
uses WaitThread;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  T: TDateTime;
begin
  with TWaitThread.Create(TRUE) do
  begin
    OnTerminate := TimerFired;
    FreeOnTerminate := TRUE;
    // Срок ожидания закончится через 5 секунд
    WaitUntil := Now + 1 / 24 / 60 / 60 * 5;
    Resume;
  end;
end;
 
procedure TForm1.TimerFired(Sender: TObject);
begin
  ShowMessage('Timer fired !');
end;
</pre>

Дополнительные объекты синхронизации</p>
<p>Некоторые объекты Win32 API не предназначены исключительно для целей синхронизации, однако могут использоваться с функциями синхронизации. Такими объектами являются:</p>
<p>Сообщение об изменении папки (change notification)</p>
<p>Windows позволяет организовать слежение за изменениями объектов файловой системы. Для этого служит функция</p>
<p>function FindFirstChangeNotification(</p>
<p>  lpPathName: PChar;&nbsp;&nbsp;&nbsp;&nbsp; // Путь к папке, изменения в которой нас </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // интересуют</p>
<p>  bWatchSubtree: BOOL;&nbsp;&nbsp; // Задает необходимость слежения за </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // изменениями во вложенных папках</p>
<p>  dwNotifyFilter: DWORD&nbsp; // Фильтр событий</p>
<p>): THandle; stdcall;</p>
<p>Параметр dwNotifyFilter &#8211; это битовая маска из одного или нескольких следующих значений:</p>
<p>FILE_NOTIFY_CHANGE_FILE_NAME &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Слежение ведется за любым изменением имени файла, в т.ч. созданием и удалением файлов &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>FILE_NOTIFY_CHANGE_DIR_NAME &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Слежение ведется за любым изменением имени папки, в т.ч. созданием и удалением папок &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>FILE_NOTIFY_CHANGE_ATTRIBUTES &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Слежение ведется за любым изменением аттрибутов &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>FILE_NOTIFY_CHANGE_SIZE &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Слежение ведется за изменением размера файлов. Изменение размера происходит при записи в файл. Функция ожидания срабатывает только после успешного сброса дискового кэша &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>FILE_NOTIFY_CHANGE_LAST_WRITE &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Слежение за изменением времени последней записи в файл, т.е., фактически, за любой записью в файл. Функция ожидания срабатывает только после успешного сброса дискового кэша. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>FILE_NOTIFY_CHANGE_SECURITY &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Слежение за любыми изменениями дескрипторов защиты &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Идентификатор, возвращенный этой функцией, может использоваться в любой функции ожидания. Он переходит в сигнальное состояние, когда в папке происходят запрошенные для слежения изменения. Продолжить слежение можно, используя функцию:</p>
<p>function FindNextChangeNotification(</p>
<p>  hChangeHandle: THandle</p>
<p>): BOOL; stdcall;</p>
<p>По завершении работы, идентификатор должен быть закрыт при помощи функции:</p>
<p>function FindCloseChangeNotification(</p>
<p>  hChangeHandle: THandle</p>
<p>): BOOL; stdcall;</p>
<p>Чтобы не блокировать исполнение основного потока программы функцией ожидания, удобно реализовать ожидание изменений в отдельном потоке. Реализуем поток на базе класса TThread. Для того чтобы можно было прервать исполнение потока методом Terminate необходимо, чтобы функция ожидания, реализованная в методе Execute, также прерывалась при вызове Terminate. Для этого будем использовать вместо WaitForSingleObject функцию WaitForMultipleObjects, и прерывать ожидание по событию (event), устанавливаемому в Terminate.</p>
<pre>
type
  TCheckFolder = class(TThread)
  private
    FOnChange: TNotifyEvent;
    Handles: array[0..1] of THandle;  // Идентификаторы объектов
                                      // синхронизации
    procedure DoOnChange;
  protected
    procedure Execute; override;
  public
    constructor Create(CreateSuspended: Boolean;
      PathToMonitor: String; WaitSubTree: Boolean;
      OnChange: TNotifyEvent; NotifyFilter: DWORD);
    destructor Destroy; override;
    procedure Terminate;
  end;
 
procedure TCheckFolder.DoOnChange;
// Эта процедура вызывается в контексте главного потока приложения
// В ней можно использовать вызовы VCL, изменять состояние формы,
// например перечитать содержимое TListBox, отображающего файлы
begin
  if Assigned(FOnChange) then
    FOnChange(Self);
end;
 
procedure TCheckFolder.Terminate;
begin
  inherited; // Вызываем TThread.Terminate, устанавливаем 
             // Terminated = TRUE
  SetEvent(Handles[1]);  // Сигнализируем о необходимости
                         // прервать ожидание
end;
 
constructor TCheckFolder.Create(CreateSuspended: Boolean;
      PathToMonitor: String; WaitSubTree: Boolean;
      OnChange: TNotifyEvent; NotifyFilter: DWORD);
var
  BoolForWin95: Integer;
begin
  // Создаем поток остановленным
  inherited Create(TRUE);
  // Windows 95 содержит не очень корректную реализацию функции
  // FindFirstChangeNotification. Для корректной работы, необходимо,
  // чтобы:
  // - lpPathName - не содержал завершающего слэша "\" для
  //                некорневого каталога
  // - bWatchSubtree - TRUE должен передаваться как BOOL(1)
  if WaitSubTree then
    BoolForWin95 := 1
  else
    BoolForWin95 := 0;
  if (Length(PathToMonitor) &gt; 1) and
     (PathToMonitor[Length(PathToMonitor)] = '\') and
     (PathToMonitor[Length(PathToMonitor)-1] &lt;&gt; ':') then
     Delete(PathToMonitor, Length(PathToMonitor), 1);
  Handles[0] := FindFirstChangeNotification(
    PChar(PathToMonitor), BOOL(BoolForWin95), NotifyFilter);
  Handles[1] := CreateEvent(NIL, TRUE, FALSE, NIL);
  FOnChange := OnChange;
  // И, при необходимости, запускаем
  if not CreateSuspended then
    Resume;
end;
 
destructor TCheckFolder.Destroy;
begin
  FindCloseChangeNotification(Handles[0]);
  CloseHandle(Handles[1]); 
  inherited;
end;
 
procedure TCheckFolder.Execute;
var
  Reason: Integer;
  Dummy: Integer;
begin
  repeat
    // Ожидаем изменения в папке, либо сигнала о завершении 
    // потока
    Reason := WaitForMultipleObjects(2, @Handles, FALSE, INFINITE);
    if Reason = WAIT_OBJECT_0 then begin
      // Изменилась папка, вызываем обработчик в контексте
      // главного потока приложения
      Synchronize(DoOnChange);
      // И продолжаем поиск
      FindNextChangeNotification(Handles[0]);
    end;
  until Terminated;
end;
</pre>

<p>Поскольку метод TThread.Terminate не виртуальный, этот класс нельзя использовать с переменной типа TThread, т.к. в этом случае будет вызываться Terminate от TThread, который не может прервать ожидания, и поток будет выполняться до изменения в папке, за которой ведется слежение.</p>
<p>Устройство стандартного ввода с консоли (console input)</p>
<p>Идентификатор, стандартного устройства ввода с консоли, полученный при помощи вызова функции GetStdHandle(STD_INPUT_HANDLE), можно использовать в функциях ожидания. Он находится в сигнальном состоянии, если очередь ввода консоли непустая и в несигнальном, если пустая. Это позволяет организовать ожидание ввода символов, либо, при помощи функции WaitForMultipleObjects совместить его с ожиданием каких-то других событий.</p>
<p>Задание (Job)</p>
<p>Job &#8211; это новый механизм Windows 2000, позволяющий объединить группу процессов в одно задание и манипулировать ими одновременно. Идентификатор задания находится в сигнальном состоянии, если все процессы, ассоциированные с ним завершились по причине истечения лимита времени на выполнение задания.</p>
<p>Процесс (Process)</p>
<p>Идентификатор процесса, полученный при помощи функции CreateProcess, переходит в сигнальное состояние по завершении процесса. Это позволяет организовать ожидание завершения процесса, например, при запуске из приложения внешней программы.</p>
<p>var</p>
<p>  PI: TProcessInformation;</p>
<p>  SI: TStartupInfo;</p>
<p>...</p>
<p>  FillChar(SI, SizeOf(SI), 0);</p>
<p>  SI.cb := SizeOf(SI);</p>
<p>  Win32Check(CreateProcess(NIL, 'COMMAND.COM', NIL,</p>
<p> &nbsp;&nbsp; NIL, FALSE, 0, NIL, NIL, SI, PI));</p>
<p>  // Задерживаем исполнение программы до завершения процесса</p>
<p>  WaitForSingleObject(PI.hProcess, INFINITE);</p>
<p>  CloseHandle(PI.hProcess);</p>
<p>  CloseHandle(PI.hThread);</p>
<p>Следует понимать, что в этом случае вызывающий процесс будет заморожен полностью и не сможет обрабатывать сообщения. Поэтому, если дочерний процесс может выполняться в течение длительного времени, лучше использовать более корректный вариант ожидания, описанный в разделе, посвященном функции MsgWaitForMultipleObjects.</p>
<p>Поток (thread)</p>
<p>Идентификатор потока находится в несигнальном состоянии до тех пор, пока поток выполняется. По его завершении идентификатор переходит в сигнальное состояние. Это позволяет легко узнать, завершился ли поток, либо при помощи функции, ожидающей нескольких объектов, организовать ожидание завершения одного из, либо всех интересующих потоков.</p>
&nbsp;</p>
Дополнительные механизмы синхронизации</p>
<p>Критические секции</p>
<p>Критические секции &#8211; это механизм, предназначенный для синхронизации потоков внутри одного процесса. Как и мутекс, критическая секция может в один момент времени принадлежать только одному потоку, однако, она предоставляет более быстрый и эффективный механизм, чем мутексы. Перед использованием критической секции необходимо инициализировать её функцией:</p>
<p>procedure InitializeCriticalSection(</p>
<p>  var lpCriticalSection: TRTLCriticalSection</p>
<p>); stdcall;</p>
<p>После создания объекта поток, перед доступом к защищаемому ресурсу должен вызвать функцию:</p>
<p>procedure EnterCriticalSection(</p>
<p>  var lpCriticalSection: TRTLCriticalSection</p>
<p>); stdcall;</p>
<p>Если в этот момент ни один из потоков в процессе не владеет объектом, то поток становится владельцем критической секции и продолжает выполнение. Если секция уже захвачена другим потоком то выполнение потока, вызвавшего функцию приостанавливается до её освобождения.</p>
<p>Поток, владеющий критической секцией, может повторно вызывать функцию EnterCriticalSection без блокирования своего исполнения. По завершению работы с защищаемым ресурсом поток должен вызвать функцию:</p>
<p>procedure LeaveCriticalSection(</p>
<p>  var lpCriticalSection: TRTLCriticalSection</p>
<p>); stdcall;</p>
<p>Эта функция освобождает объект независимо от количества предыдущих вызовов потоком функции EnterCriticalSection. Если имеются другие потоки, ожидающие освобождения секции, один из них становится её владельцем и продолжает исполнение. Если поток завершился, не освободив критическую секцию, её состояние становится неопределенным, что может вызвать блокировку работы программы.</p>
<p>Имеется возможность попытаться захватить объект без замораживания потока. Для этого служит функция:</p>
<p>function TryEnterCriticalSection(</p>
<p>  var lpCriticalSection: TRTLCriticalSection</p>
<p>): BOOL; stdcall;</p>
<p>Она проверяет, захвачена секция ли в момент её вызова. Если да &#8211; функция возвращает FALSE, в противном случае &#8211; захватывает секцию и возвращает TRUE. </p>
<p>По завершении работы с критической секцией, она должна быть уничтожена вызовом функции:</p>
<p>procedure DeleteCriticalSection(</p>
<p>  var lpCriticalSection: TRTLCriticalSection</p>
<p>); stdcall;</p>
<p>Рассмотрим пример приложения, осуществляющего в нескольких потоках загрузку данных по сети. Глобальные переменные BytesSummary и TimeSummary хранят общее количество загруженных байт и время загрузки. Эти переменные каждый поток обновляет по мере считывания данных. Для предотвращения конфликтов приложение должно защитить общий ресурс при помощи критической секции.</p>
<pre>
var
  // Глобальные переменные
  CriticalSection: TRTLCriticalSection;
  BytesSummary: Cardinal;
  TimeSummary: TDateTime;
  AverageSpeed: Float;
 
...
 
// При инициализации приложения
InitializeCriticalSection(CriticalSection);
BytesSummary := 0;
TimeSummary := 0;
AverageSpeed := 0;
 
 
//В методе Execute потока, загружающего данные.
repeat
  BytesRead := ReadDataBlockFromNetwork;
  EnterCriticalSection(CriticalSection);
  try
    BytesSummary := BytesSummary + BytesRead;
    TimeSummary := TimeSummary + (Now - ThreadStartTime);
    if TimeSummary &gt; 0 then
      AverageSpeed := BytesSummary / (TimeSummary/24/60/60);
  finally
    LeaveCriticalSection(CriticalSection)
  end;
until LoadComplete;
 
// При завершении приложения
DeleteCriticalSection(CriticalSection);
</pre>
<p>Delphi предоставляет класс, инкапсулирующий функциональность критической секции. Класс объявлен в модуле SyncObjs.pas</p>
<p>type</p>
<p>  TCriticalSection = class(TSynchroObject)</p>
<p>  public</p>
<p> &nbsp;&nbsp; constructor Create;</p>
<p> &nbsp;&nbsp; destructor Destroy; override;</p>
<p> &nbsp;&nbsp; procedure Acquire; override;</p>
<p> &nbsp;&nbsp; procedure Release; override;</p>
<p> &nbsp;&nbsp; procedure Enter;</p>
<p> &nbsp;&nbsp; procedure Leave;</p>
<p>  end;</p>
<p>Методы Enter и Leave являются синонимами методов Acquire и Release соответственно и добавлены для лучшей читаемости исходного кода.</p>
<p>procedure TCriticalSection.Enter;</p>
<p>begin</p>
<p>  Acquire;</p>
<p>end;</p>
<p>procedure TCriticalSection.Leave;</p>
<p>begin</p>
<p>  Release;</p>
<p>end;</p>
<p>Защищенный доступ к переменным (Interlocked Variable Access)</p>
<p>Часто возникает необходимость совершения операций над разделяемыми между потоками 32-разрядными переменными. Для упрощения решения этой задачи WinAPI предоставляет функции для защищенного доступа к ним, не требующие использования дополнительных (и более сложных) механизмов синхронизации. Переменные, используемые в этих функциях, должны быть выровнены на границу 32-разрядного слова. Применительно к Delphi это означает, что если переменная объявлена внутри записи (record), то эта запись не должна быть упакованной (packed) и при её объявлении должна быть активна директива компилятора {$A+}. Несоблюдение этого требования может привести к возникновению ошибок на многопроцессорных конфигурациях.</p>
<pre>
type
  TPackedRecord = packed record
    A: Byte;
    B: Integer;
  end;   
// TPackedRecord.B нельзя использовать в функциях InterlockedXXX
 
  TNotPackedRecord = record
    A: Byte;
    B: Integer;
  end;
 
{$A-}
var
  A1: TNotPackedRecord;
// A1.B нельзя использовать в функциях InterlockedXXX
  I: Integer
// I можно использовать в функциях InterlockedXXX, т.к. переменные в
// Delphi всегда выравниваются на границу слова безотносительно
// к состоянию директивы компилятора $A
 
{$A+}
var
  A2: TNotPackedRecord;
// A2.B можно использовать в функциях InterlockedXXX
 
function InterlockedIncrement(
  var Addend: Integer
): Integer; stdcall;
</pre>
<p>Функция увеличивает переменную Addend на 1. Возвращаемое значение зависит от операционной системы:</p>
<p>Windows 98, Windows NT 4.0 и старше &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Возвращается новое значение переменной Addend &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Windows 95, Windows NT 3.51 &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> &nbsp; &nbsp; &nbsp; &nbsp;Если после изменения Addend &lt; 0 возвращается отрицательное число, не обязательно равное Addend&nbsp; Если Addend = 0 &#8211; возвращается 0 Если после изменения Addend &gt; 0 возвращается положительное число, не обязательно равное Addend. &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>function InterlockedDecrement(</p>
<p>  var Addend: Integer</p>
<p>): Integer; stdcall;</p>
<p>Функция уменьшает переменную Addend на 1. Возвращаемое значение аналогично функции InterlockedIncrement.</p>
<p>function InterlockedExchange(</p>
<p>  var Target: Integer; </p>
<p>  Value: Integer</p>
<p>): Integer; stdcall;</p>
<p>Функция записывает в переменную Target значение Value и возвращает предыдущее значение Target</p>
<p>Следующие функции для выполнения требуют Windows 98 или Windows NT 4.0 и старше.</p>
<p>function InterlockedCompareExchange(</p>
<p>  var Destination: Pointer;</p>
<p>  Exchange: Pointer;</p>
<p>  Comperand: Pointer</p>
<p>): Pointer; stdcall;</p>
<p>Функция сравнивает значения Destination и Comperand. Если они совпадают, значение Exchange записывается в Destination. Функция возвращает начальное значение Destination.</p>
<p>function InterlockedExchangeAdd(</p>
<p>  Addend: PLongint; </p>
<p>  Value: Longint</p>
<p>): Longint; stdcall;</p>
<p>Функция добавляет к переменной, на которую указывает Addend значение Value и возвращает начальное значение Addend.</p>
Резюме</p>
<p>Многозадачная и многопоточная среда Win32 предоставляет широкие возможности для написания высокоэффективных приложений. Однако, написание приложений, использующих многопоточность и взаимодействующих друг с другом, при неаккуратном программировании может привести к их неверной работе, неоправданной загрузке и даже блокировке всей системы. Во избежание этого следуйте нижеприведенным рекомендациям:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Если приложения или потоки одного процесса изменяют общий ресурс &#8211; защищайте доступ к нему при помощи критических секций или мутексов.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Если доступ осуществляется только на чтение &#8211; защищать ресурс не обязательно.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Критические секции более эффективны, но применимы только внутри одного процесса, мутексы могут использоваться для синхронизации между процессами.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Используйте семафоры для ограничения количества обращений к одному ресурсу.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Используйте события (event) для информирования потока о наступлении какого-либо события.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Если разделяемый ресурс &#8211; 32-битная переменная &#8211; для синхронизации доступа к нему можно использовать функции, обеспечивающие разделяемый доступ к переменным.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Многие объекты Win32 позволяют организовать эффективное слежение за своим состоянием при помощи функций ожидания. Это наиболее эффективный с точки зрения расхода системных ресурсов метод.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#8226;</td><td>Если Ваш поток создает (даже неявно, при помощи CoInitialize или функций DDE) окна &#8211; он должен обрабатывать сообщения. Не используйте в таком потоке функций не позволяющих прервать ожидание по приходу сообщения с большим или неограниченным периодом ожидания. Используйте функции MsgWaitForXXX</td></tr></table></div>&nbsp;</p>
<p>Тенцер А. Л.</p>
<p>ICQ UIN 15925834</p>
<p>tolik@katren.nsk.ru</p>
&nbsp;</p>
<div class="author">Автор: Тенцер А. Л.</div>
