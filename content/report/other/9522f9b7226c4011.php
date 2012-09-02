<h1>Crystal Reports 8.0 через API</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Андрей Зубарев</p>
<p>Специально для Королевства Delphi </p>

<p>Вступление </p>

<p>Crystal Reports (далее как CR) на сегодняшний день является лидирующим пакетом для разработки отчетности в крупных компаниях. Для доступа к отчетам компания Seagate предоставляет несколько вариантов: </p>

<p>Элемент управления Crystal ActiveX </p>
<p>Компонент Report Designer Component </p>
<p>Компоненты VCL сторонних разработчиков. </p>
<p>Automation Server </p>
<p>Вызовы API реализуются через Report Engine API (далее RE). </p>
<p>По моему мнению, лучшим является доступ посредством API функций, т.к.: </p>

<p>вы полностью контролируете все, что происходит. </p>
<p>узнаете, как все это работает. </p>
<p>не зависите от фирмы разработчика компонент и их версий. </p>
<p>не платите денег (хотя этот момент расплывчат J). </p>
<p>В 90% случаев необходимо только вывести отчет и передать входящие параметры, т.е. вы получаете "тонкое" приложения на основе своих же наработок, что согласитесь, греет душу программиста. Предполагается, что читатель знаком с работой в Crystal Reports и понимает концепцию разработки отчетов в данной среде. </p>

<p class="note">Примечание Vit</p>
<p>Позволю себе внести поправку, фирма Seagate имеет свой собственный VCL компонент для работы со всеми версиями Crystal Report начиная с 4й и заканчивая 9й. К сожалению разработка VCL компонента обычно задерживается на пол-года, а иногда и дольше со времени выхода очередного релиза. Мне доводилось не однократно самому переделывать компонент от старой версии для более новой и обычно это не очень сложная задача. Компонент можно взять с FTP Seagate. </p>

<p>Необходимые файлы </p>

<p>Библиотека [crpe32.dll] содержит интерфейс вызовов API функций. </p>
<p>Модуль [uCrystalApi.pas] с описаниями API функций. Он был подправлен мной, так как было несколько синтаксических ошибок. </p>
<p>Для работы примера необходим источник данных, в качестве которого используется демонстрационная БД MS Access 2000 [source_db.mdb]. В качестве драйвера связи используется OLE DB для MS Jet 4.0. БД должна находиться в той же папке, где и пример отчета. </p>
<p>Если вы хотите распространять ваше приложение с отчетами, тогда ознакомьтесь с содержимым файла [crpe32.dep], который содержит список необходимых файлов для работы RE. </p>
<p>Пример реализован на Delphi 6.0.</p>
<p>Программируем </p>

<p>Первым надо "запустить машину" CR, посредством вызова функции PEOpenEngine для инициализации механизма отчетов. Надо заметить, что вызов данной функции справедлив только для одного потока. </p>

<p>Теперь можно и начать подготовку отчета для вывода. Вызов PEOpenPrintJob дает нам дескриптор задачи (отчета), который необходимо передавать в другие функции. </p>


<p>// Синтаксис функции</p>
<p>PEOpenPrintJob(PathToReport: PChar): SmallInt;</p>
<p>{</p>
<p>где,</p>
<p>  PathToReport - путь к файлу отчета.</p>
<p>  Результат функции - дескриптор полученной задачи.</p>
<p>Пример:</p>
<p>  FHandleJob := PEOpenPrintJob(PChar(edtPathReport.Text));</p>
<p>}</p>


<p>Получив дескриптор, мы можем, манипулировать отчетом как нам будет угодно. Получать информацию о параметрах, об источнике данных, управлять разделами отчета и формулами. </p>

<p>Далее необходимо сказать системе, куда выводить отчет: в окно предварительного просмотра (…ToWindow) или на принтер (…ToPrinter). </p>


<p>// Синтаксис функций:</p>
<p>PEOutputToWindow(printJob : Smallint; title: PChar;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; left: Integer; top: Integer;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; width: Integer; height: Integer;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; style: DWord;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; parentWindow : HWnd): Bool;</p>

<p>PEOutputToPrinter(printJob: Word;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; nCopies: Integer)): Bool;</p>
<p>{</p>
<p>где,</p>
<p> printJob - дескриптор задачи</p>
<p> title - заголовок окна</p>
<p> left, top, width, height - координаты окна</p>
<p> style - стиль окна (типа WS_VSCROLL, WS_VISIBLE и т.д.)</p>
<p> parentWindow - дескриптор окна в котором будет окно отчета.</p>
<p> nCopies - количество копий.</p>
<p>Пример:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Result:= PEOutputToWindow(FHandleJob,</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PChar(TForm(Self).Caption),</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0, 0, 0, 0, 0, FWindow);</p>
<p>}</p>


<p>Подготовив механизм вывода отправляем отчет для вывода функцией PEStartPrintJob. </p>


<p>// Синтаксис функции:</p>
<p>function PEStartPrintJob(printJob: Word;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; waitUntilDone: Bool): Bool;</p>
<p>{</p>
<p>где,</p>
<p>  printJob - дескриптор задачи.</p>
<p>  WaitUntilDone - зарезервирован. Всегда должен быть True.</p>
<p>Пример:</p>
<p>  PEStartPrintJob(FHandleJob, True);</p>
<p>}</p>


<p>После отправки отчета, если не надо производить с ним операций, закрываем задание функцией PEClosePrintJob.</p>


<p>// Синтаксис функции:</p>
<p>function PEClosePrintJob (printJob: Word): Bool;</p>
<p>{</p>
<p>где,</p>
<p>  printJob - дескриптор задачи.</p>
<p>Пример:</p>
<p>  PEClosePrintJob(FHandleJob);</p>
<p>}</p>


<p>Между вызовами функций PEOpenPrintJob и PEClosePrintJob может стоять сколько угодно вызовов функций PEOutputTo…, PEStartPrintJob. </p>

<p>В итоге получается схема вызовов: </p>

<p>PEOpenEngine </p>
<p> &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>PEOpenPrintJob </p>
<p> &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>PEOutputToWindow </p>
<p> &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>PEStartPrintJob </p>
<p> &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>PEClosePrintJob </p>
<p> &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>PECloseEngine </p>

<p>Пример просмотра отчета </p>

<p>Ниже приведен код процедуры для просмотра отчета из примера </p>

<pre>
procedure TFrmMain.btnReportPreviewClick(Sender: TObject);
var
  // Дескриптор окна в котором производится просмотр отчета
  FWindow: THandle;
  // Информация об источнике данных.
  // См. раздел "Получение параметров и свойств источника"
  lt: PELogOnInfo;
begin
  // В зависимости от флага устанавливаем дескриптор окна.
  // При нуле, отчет будет показан в независимом внешнем окне.
  if chkWindow.Checked then
    FWindow := 0
  else
    FWindow := pnlPreview.Handle;
  // Открываем отчет и получаем дескриптор задачи.
  FHandleJob := PEOpenPrintJob(PChar(edtPathReport.Text));
  // Получение параметров источника данных отчета.
  FillChar(lt, SizeOf(PELogOnInfo), 0);
  lt.StructSize := SizeOf(PELogOnInfo);
  PEGetNthTableLogOnInfo(FHandleJob, 0, lt);
  // Устанавливаем новые параметры источника данных отчета.
  StrPCopy(@lt.ServerName, ExtractFilePath(edtPathReport.Text) +
    'source_db.mdb');
  PESetNthTableLogOnInfo(FHandleJob, 0, lt, False);
  // Настраиваем окно вывода.
  PEOutputToWindow(FHandleJob, PChar(TForm(Self).Caption), 0, 0, 0, 0, 0,
    FWindow);
  // Выводим отчет.
  PEStartPrintJob(FHandleJob, True);
  // Закрываем дескриптор задания.
  PEClosePrintJob(FHandleJob);
end;
</pre>



<p>Получение и установка свойств источника </p>

<p>Теперь когда мы научились выводить отчет, расширим наши познания в области манипуляций отчетом, такими как получение параметров отчета и свойств источника данных. </p>

<p>Свойства источника данных можно получить или установить через функции PEGetNthTableLogOnInfo и PESetNthTableLogOnInfo. Здесь надо отметить довольно тонкий момент, связанный с обработкой данных в CR. Источником данных может выступать любая СУБД как файловая, так и серверная, текстовый файл и т.п. В свою очередь к примеру из серверной СУБД данные можно получить через хранимую процедуру (stored procedure), представление (view), таблицу (table) или через набор таблиц которые обрабатываются уже внутри отчета. Поэтому используются различные API функции зависящие от возможностей источника. </p>

<p>Обратите внимание на название в именах функций - сокращение Nth обозначает, что функция вызывается для определенной таблицы. </p>

<p>Получение свойств через функцию довольно просто. Описываем структуру данных, передаем дескриптор задачи и порядковый номер таблицы. После вызова функции получаем заполненную структуру параметров. </p>


<p>// Синтаксис функции:</p>
<p>function PEGetNthTableLogOnInfo</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (printJob: Word;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; tableN: Integer;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; var logOnInfo: PELogOnInfo): Bool;</p>
<p>{</p>
<p>где,</p>
<p>  printJob - дескриптор задачи.</p>
<p>  tableN - номер таблицы.</p>
<p>  location - струкура со свойствами источника.</p>
<p>Пример:</p>
<p>  PEGetNthTableLogOnInfo(FHandleJob, 0, lt);</p>
<p>}</p>


<p>Структура PELogOnInfo содержит свойства источника. Перед ее передачей в функцию обязательно заполните поле StructSize. Например: </p>


<p>// Чистим структуру.</p>
<p>FillChar(lt, SizeOf(PELogOnInfo), 0);</p>
<p>// Заполняем поле размера.</p>
<p>lt.StructSize := SizeOf(PELogOnInfo);</p>
<p>// Вызываем функцию для таблицы с порядковым номером 0 (ноль)</p>
<p>PEGetNthTableLogOnInfo(FHandleJob, 0, lt);</p>


<p>Описание структуры: </p>


<p>type</p>
<p>  PELogonServerType = array[0..PE_SERVERNAME_LEN - 1] of Сhar;</p>
<p>  PELogonDBType = array[0..PE_DATABASENAME_LEN - 1] of Сhar;</p>
<p>  PELogonUserType = array[0..PE_USERID_LEN - 1] of Сhar;</p>
<p>  PELogonPassType = array[0..PE_PASSWORD_LEN - 1] of Сhar;</p>
<p>  PELogOnInfo = record</p>
<p> &nbsp;&nbsp; StructSize: Word;</p>
<p> &nbsp;&nbsp; ServerName: PELogonServerType;</p>
<p> &nbsp;&nbsp; DatabaseName: PELogonDbType;</p>
<p> &nbsp;&nbsp; UserId: PELogonUserType;</p>
<p> &nbsp;&nbsp; Password: PELogonPassType;</p>
<p>  end;</p>
<p>{</p>
<p>  где,</p>
<p> &nbsp;&nbsp; StructSize - размер структуры.Заполняется обязательно.</p>
<p> &nbsp;&nbsp; ServerName - имя сервера или путь к файлу БД.</p>
<p> &nbsp;&nbsp; DatabaseName - имя БД.</p>
<p> &nbsp;&nbsp; UserId - пользователь.</p>
<p> &nbsp;&nbsp; Password - пароль пользователя.</p>
<p>}</p>


<p>Функция установки параметров PESetNthTableLogOnInfo аналогично предыдущей (в смысле параметров, а действует наоборот - устанавливает новые свойства источника). У данной функции есть один дополнительный логический параметр propagateAcrossTables, который указывает как обработать информацию из структуры PELogOnInfo. Если значение параметра TRUE, тогда свойства из структуры применяются для всех таблиц в отчете, иначе только для таблицы с с номером tableN. Например: </p>


<p>// Скопировать в поле ServerName путь к БД отчета.</p>
<p>StrPCopy(@lt.ServerName, ExtractFilePath(edtPathReport.Text) + 'source_db.mdb');</p>
<p>// Установить параметры для таблицы 0 и только для нее.</p>
<p>PESetNthTableLogOnInfo(FHandleJob, 0, lt, False);</p>


<p>Получение параметров отчета </p>

<p>Теперь о том как получить параметры отчета с помощью которых производится управление. </p>

<p>Используя PEGetNParameterFields вы получаете общее количество параметров в отчете. Передавая в функцию PEGetNthParameterField порядковый номер параметра получаем структуру с данными об имени, размере, значениях и т.п. Функция PEConvertPFInfoToVInfo позволяет получить значение параметра. </p>

<p>Функция PEGetNParameterFields имеет только один параметр - дескриптор задачи, в результате возвращается количество параметров. В примере показано как работать с параметрами: </p>

<pre>
var
  ParameterInfo: PEParameterFieldInfo;
  ValueInfo: PEValueInfo;
...
 
// Получить количество параметров.
CountParams := PEGetNParameterFields(FHandleJob);
if CountParams &lt;&gt; -1 then
begin
  for i := 0 to CountParams - 1 do
  begin
    // Запросить информацию о параметре i.
    PEGetNthParameterField(FHandleJob, i, ParameterInfo);
    ValueInfo.ValueType := ParameterInfo.valueType;
    // Получить значение параметра.
    PEConvertPFInfoToVInfo(@ParameterInfo.DefaultValue,
      ValueInfo.ValueType,
      ValueInfo);
    ...
  end;
end;
</pre>




<p>Описания структур довольно большие, поэтому я опишу только те поля которые используются в примере. </p>


<p>ParameterInfo.Name // - имя параметра.</p>
<p>ParameterInfo.ValueType // - тип данных параметра.</p>
<p>ParameterInfo.DefaultValue&nbsp; // - значение по умолчанию.</p>


<p>Структура ValueInfo содержит в одном из своих полей значение параметра. Вы можете посмотреть в примере функцию FormatCrystalValue, чтобы разобраться с полями структуры. </p>

<p>Заключение </p>

<p>Дополнительные сведения о программировании с использованием API вы может посмотреть в справочных файлах, которые идут с CR (PROGRAM FILES\SEAGATSOFTWARE\CRYSTAL REPORTS\DEVELOPER FILES\HELP\), файлы DEVELOPR.HLP и RUNTIME.HLP. Если их у вас нет, то скачайте с FTP сервера Seagate. </p>

<p>В будущем я надеюсь развить тему CR более углубленно, но это зависит от интереса читателей и наличия времени :-). </p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
