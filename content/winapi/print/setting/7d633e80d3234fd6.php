<h1>Мониторинг принтера</h1>
<div class="date">28.09.2005</div>


</p>
<p> <br>
<p>Если организация оказывает вычислительные услуги, то в один прекрасный момент перед ней неизбежно встанет проблема тарификации, напрямую связанная с автоматическим учетом ресурсов. Эта статья рассказывает о том, как автоматизировать учет использования принтера.</p>
<p>В перечень услуг интернет-кафе давно уже входит распечатка текстовых и других документов. Однако организация этого дела все еще остается на этапе минимальной автоматизации. Вот если бы удалось написать программку, которая отслеживала бы, кто, когда и сколько напечатал, да интегрировать ее в систему контроля компьютерного клуба, то это не только избавило бы администраторов от лишнего диалога с клиентом, но и придало клубу более современный вид.</p>
 <br>
<p>Теоретические основы мониторинга</p>
<p> <br>
<p>В теории мониторинг принтера в Windows 98 не является чем-то неимоверно сложным &#8212; те же драйверы не просто осуществляют этот самый мониторинг, но и предоставляют возможности по управлению работой принтера. Мы же пока будем довольствоваться лишь отслеживанием посылаемых на печать задачами. Для этого в арсенале Windows предусмотрено два метода.</p>
<p> <br>
<p>Первый &#8212; использование метода отслеживания сообщения WM_SPOOLERSTATUS, которое система посылает всякий раз при добавлении в очередь нового задания или же при удалении оного.</p>
<p> <br>
<p>Второй способ &#8212; использование функций FindFirstPrinterChangeNotification, FindNextPrinterChangeNotification и FindClosePrinterChangeNotification. В этой заметке мы рассмотрим первый из них.</p>
<p> <br>
<p>Как и большинство сообщений Windows, WM_SPOOLERSTATUS возвращает в структуре TMessage некоторую полезную информацию, которую вы можете иcпользовать в своих нуждах. Но, к сожалению, никакой действительно важной и нужной информации (помимо количества оставшихся в очереди заданий) эта структура не несет. К счастью, в Windows есть дополнительные методы для определения необходимой нам информации. Так, среди прочих в модуле WinSpool присутствует функция EnumJobs, возвращающая количество и характеристики заданий печати, в которых содержится требуемая информация &#8212; от названия документа, машины и имени пользователя, отправившего этот документ на печать, до времени, когда это было сделано и количества страниц, посланных на печать.</p>
<p> <br>
<p>Эта функция выглядит следующим образом:</p>
<p>function EnumJobs(hPrinter: THandle; FirstJob, NoJobs, Level: DWORD; pJob: Pointer; cbBuf: DWORD;<br>
<p>var pcbNeeded, pcReturned: DWORD): BOOL; stdcall;</p>
<p>где:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>hPrinter &#8212; идентификатор принтера, к которому производится запрос;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>FirstJob &#8212; номер первого запрашиваемого задания;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>NoJobs &#8212; количество запрашиваемых заданий;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Level &#8212; тип структуры, которая передается в pJob;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>PJob &#8212; указатель на массив переменных типа JOB_INFO_1 при Level=1 и JOB_INFO_2 при Level=2 (см. таблицу 1 и 2);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>CbBuf &#8212; размер буфера данных;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>PcbNeeded &#8212; переменная, в которую заносится количество записанных в буфер данных (при удачном завершении функции) или же необходимый размер буфера в байтах (при неудачном завершении);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>PcReturned &#8212; количество занесенных в буфер записей, в которых содержится актуальная информация.</td></tr></table></div>
<p><img src="/pic/clip0258.gif" width="324" height="339" border="0" alt="clip0258"><img src="/pic/clip0259.gif" width="320" height="340" border="0" alt="clip0259"></p>
<p>Для нормальной работы этой функции, прежде всего, необходимо раздобыть идентификатор принтера, который мы должны поместить в параметр hPrinter. Для этого предназначена функция OpenPrinter, открывающая соответствующий принтер и выдающая необходимый идентификатор:</p>
<p>function OpenPrinter(pPrinterName: PChar; var phPrinter: THandle; pDefault: PPrinterDefaults): BOOL; stdcall;</p>
<p>где:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>ppPrinterName &#8212; имя принтера, который следует открыть;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>phPrinter &#8212; переменная, в которую будет записан идентификатор открытого принтера;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>pDefault &#8212; структура, содержащая необходимые для инициализации принтера данные.</td></tr></table></div>
<p>Если в системе присутствует лишь один принтер (подключенный к компьютеру админа), то параметр ppPrinterName может быть строго зафиксирован в самом коде приложения. Если же принтеров в сети несколько (подключенный к серверу, к компьютеру администратора, к компьютеру кассы и т.д.), то лучше всего предоставить пользователю возможность самостоятельно выбирать, какой из принтеров следует инспектировать. Для этого можно воспользоваться функцией перечисления доступных принтеров:</p>
<p>function EnumPrinters(Flags: DWORD; Name: PChar; Level: DWORD;<br>
<p>pPrinterEnum: Pointer; cbBuf: DWORD; var pcbNeeded, pcReturned: DWORD): BOOL; stdcall;</p>
<p>где:</p>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Flags &#8212; флаги, которые дазают особенности перечисления принтеров (см. таблицу 3);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Name &#8212; название принт-объекта; значение этого параметра используется в паре с Level (таблица 4);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Level &#8212; индекс уровня; используется вместе с Name (таблица 4);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>PPrinterEnum &#8212; указатель на массив элементов одного из типов TPrinterInfo1, TPrinterInfo2, TPrinterInfo4, TPrinterInfo5 (таблица 4);</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>CbBuf &#8212; размер буфера pPrinterEnum;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>PcbNeeded &#8212; переменная. в которой содержится количество байт, скопированных при удачном завершении операции, или же размер недостающей памяти, если значение cbBuf слишком мало;</td></tr></table></div>
<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>PcReturned &#8212; количество актуальных записей, занесенных в буфер.</td></tr></table></div>
<p><img src="/pic/clip0260.gif" width="322" height="381" border="0" alt="clip0260"><img src="/pic/clip0261.gif" width="325" height="278" border="0" alt="clip0261"></p>
<p>Практическая реализация</p>
<p> <br>
<p>Для практической реализации мы, как всегда, воспользуемся Delphi и создадим сначала свежее приложение (New р Application). Далее для демонстрации работы мы перенесем на форму 2 компонента: TreeView и ListBox</p>
<p>Далее занесем в OnCreate код для перечисления доступных принтеров:</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var PI:array[0..1023] of PRINTER_INFO_1;
Needed,Returned:Cardinal;i:integer;
begin
PrintersRoot:=TreeView1.Items.AddFirst(nil,'Printers');
if not EnumPrinters(PRINTER_ENUM_LOCAL,nil,1,@PI,SizeOf(PI),Needed,Returned) then
ListBox1.Items.Add(SysErrorMessage(GetLastError));
For i:=0 to Returned-1 do
TreeView1.Items.AddChild(PrintersRoot,PI[i].pName);
end;
</pre>
<p>Здесь мы сначала создаем в TreeView родительский узел, куда будем записывать все найденные принтеры. Далее запускаем поиск локальных принтеров посредством передачи в EnumPrinters флага PRINTER_ENUM_LOCAL. После этого при успешном завершении функции мы переносим названия всех принтеров в TreeView или же выводим сообщение об ошибке.</p>
<p> <br>
<p>Теперь у нас есть список всех доступных принтеров &#8212; и мы со спокойной душей можем предложить пользователю выбрать и открыть один из них. Для этого в реакцию на событие OnDblClick компонента TreeView1 следует записать следующий код:</p>
<pre>procedure TForm1.TreeView1Click(Sender: TObject);
begin
if not OpenPrinter(PChar(TreeView1.Selected.Text),PH,nil) then
ListBox1.Items.Add(SysErrorMessage(GetLastError));
end;
</pre>
<p>После двойного щелчка на названии принтера мы открываем его и записываем полученный идентификатор в переменную PH, которая объявлена в секции private нашей формы. А для пущей правильности кода в OnDestroy нашей формы напишем:</p>
<pre>procedure TForm1.FormDestroy(Sender: TObject);
begin
ClosePrinter(PH);
end;
</pre>

<p>Далее нам предстоит реализовать слежение за сообщением WM_SPOOLERSTATUS &#8212; для этого я рекомендовал бы выбрать способ, предоставляемый Delphi посредством служебного слова message:</p>
<pre>TForm1 = class(TForm)
TreeView1: TTreeView;
ListBox1: TListBox;
procedure FormCreate(Sender: TObject);
procedure TreeView1Click(Sender: TObject);
procedure FormDestroy(Sender: TObject);
private
PrintersRoot:TTreeNode;
PH:Cardinal;
procedure WMPrinterStatus(var Msg:TMessage); message WM_SPOOLERSTATUS;
{ Private declarations }
public
{ Public declarations }
end;
</pre>

<p>Здесь метод WMPrinterStatus будет вызываться только при поступлении сообщения WM_SPOOLERSTATUS. В коде реализации этого метода мы с вами напишем вот что:</p>
<pre>procedure TForm1.WMPrinterStatus(var Msg:TMessage);
var i:integer;
Job2:Array[0..1023] of JOB_INFO_2;Needed,Returned:Cardinal;
begin
Msg.Result:=0;
ListBox1.Items.Add('Jobs Left:'+IntToStr(Msg.WParamLo));
if not EnumJobs(PH,0,1024,2,@Job2,SizeOf(Job2),Needed,Returned) then ShowMessage(SysErrorMessage(GetLastError));
For i:=0 to Returned-1 do
With Job2[i] do
ListBox1.Items.Add(Format('%s %s %s',[pPrinterName,pDocument,pUserName]))
end;
</pre>

<p>Все. Проект готов, осталось только скомпилить его.</p>
<p> <br>
<p>После запуска приложения на экране появляется уже знакомое нам окно, в компоненте TreeView которого присутствует список доступных локальных принтеров (рисунок ниже). Открываем принтер (двойной щелчок на названии) и запускаем любой текстовый редактор. Открываем документ (для пробы можно воспользоваться и графическим редактором). А теперь: Файл р Печать &#8212; и мы видим...</p>
 <br>
<p>Послесловие</p>
<p> <br>
<p>Итак, теперь мы в курсе, как отслеживать состояние очереди на печать. И не просто отслеживать, а еще и автоматически обрабатывать эту информацию в корыстных целях :).</p>
<p> <br>
<p>Впрочем, этот метод не единственный в своем роде. К примеру, помимо реакции на событие WM_SPOOLERSTATUS, можно реализовать обработку очереди посредством функций FindFirstPrinterChangeNotification, FindNextPrinterChangeNotification, FindClosePrinterChangeNotification, которые позволяют отслеживать не только добавление и удаление заданий в(из) очереди, но и состояние очереди в процессе печати, а также предоставляют ряд дополнительных возможностей. Кроме того, эти методы позволяют настроить реакцию программы под более конкретные задачи (Printer, PrinterDriver, Form, Job...), что, конечно, позитивно сказывается на работоспособности системы в целом, особенно при больших нагрузках на нее.</p>
<p> <br>
<p>К отрицательным же сторонам вопроса можно отнести тот факт, что при обработке FindFirstPrinterChangeNotification, FindNextPrinterChangeNotification, FindClosePrinterChangeNotification необходимо реализовывать отдельный поток для отслеживания этих действий, что само по себе непростая задача для человека, никогда не работавшего с потоками вплотную.</p>
<p></p>
<div class="author">Автор: Михаил Продан</div>
<a href="https://www.cpp.com.ua" target="_blank">https://www.cpp.com.ua</a></p>

