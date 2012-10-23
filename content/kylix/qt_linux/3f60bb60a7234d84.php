<h1>Перехватчики событий, сигналы и слоты</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Андрей Боровский (<a href="https://www.myhomepage.com/index.html" target="_blank">www.kylixportal.chat.ru</a>)</div>

<p>Перехватчики событий</p>

<p>В предыдущей статье была рассмотрена обработка событий Qt в обработчике события OnEvent Kylix класса TApplication. В этой статье будет показан другой метод обработки событий Qt - использование перехватчиков событий (event hooks). Перехватчики событий подобны обработчику события OnEvent, с той разницей, что перехватчики событий позволяют подойти к обработке событий более дифференцировано. Перехватчики назначаются для отдельных объектов Qt, причем каждому объекту может быть назначено несколько перехватчиков для обработки разных типов событий.</p>

<p>Перехватчик может быть процедурой или функцией, являющейся методом объекта Object Pascal и использующей формат вызова cdecl. Для того, чтобы назначить перехватчик какому-либо экземпляру класса Qt, необходимо создать экземпляр класса перехватчика для данного объекта Qt и связать его с методом-обработчиком. Функции, позволяющие сделать это, как и другие функции CLXDisplay API, декларируются в модуле Qt (файл Qt.pas).</p>

<p>В предыдущей статье было писано демонстрационное приложение, позволяющее перемещать фрагменты текста методом Drag and Drop. Теперь мы перепишем это приложение, используя перехватчики событий. Перехватчик назначается компоненту TLabel в конструкторе главной формы. Ниже приводятся декларация класса и исходный текст конструктора.</p>

<pre>
TForm1 = class(TForm)
    Label1: TLabel;
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure FormCreate(Sender: TObject);
    procedure Label1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
    DropHook : QEvent_hookH;
    function EventHandler(Handle : QObjectH; e : QEventH) : Boolean; cdecl;
 end;
 ...
 procedure TForm1.FormCreate(Sender: TObject);
 var
   M : TMethod;
 begin
   DropHook:=QEvent_hook_create(Label1.Handle);
   EventFunc(M):=EventHandler;
   Qt_hook_hook_events(DropHook, M);
 end;
</pre>


<p>DropHook - переменная типа QEvent_hookH, ссылка на объект-перехватчик событий. Не путайте этот объект с объектом, события которого перехватываются. В CLXDisplay API определено несколько объектов перехватчиков различных типов, и для создания каждого из них используется специальная функция. В данном примере мы создаем наиболее общий объект-перехватчик, перехватывающий события разных типов. Функция QEvent_hook_create создает экземпляр такого объекта и связывает его с экземпляром класса, события которого необходимо обрабатывать (в нашем случае - экземпляр QLabel).</p>

<p>Далее мы присваиваем переменной M указатель на метод перехватчик EventHandler. Обратите внимание на преобразование типов. Для того, чтобы выполнить преобразование корректно, необходимо определить тип-функцию</p>

<p>EventFunc = function(Handle : QObjectH; e : QEventH) : Boolean of object; cdecl;</p>

<p>декларация которой в точности соответствует декларации метода-перехватчика.</p>

<p>Связывание метода перехватчика с объектом-перехватчиком выполняется функцией Qt_hook_hook_events. Первый параметр функции - указатель на объект-перехватчик, второй параметр - указатель на метод. Учтите, что для каждой пары "объект-перехватчик / тип перехватываемых событий" в модуле Qt определена своя функция, связывающая объекты и методы перехватчики.</p>

<p>Сам метод перехватчик похож на метод обработки событий из предыдущего примера. Ссылка на объект события передается в переменной e, а значение, указывающее на то, следует ли вызывать обработчик события, назначенный объекту по умолчанию, возвращается в качестве результата функции. Обратите внимание на то, что в новом примере мы не проверяем, с каким Qt объектом связано обрабатываемое событие. В этом нет необходимости, так как метод перехватчик связан лишь с одним экземпляром Qt класса. Однако мы могли бы связать этот метод с несколькими объектами, и тогда параметр Handle позволил бы нам определить, каким Qt объектом вызван перехватчик.</p>

<p>Уничтожение объекта-перехватчика выполняется в деструкторе формы. Для этого служит функция QEvent_hook_destroy.</p>

<p>Исходный текст демонстрационного приложения находится здесь. Как и пример из предыдущей статьи, это приложение может быть скомпилировано и в Kylix (для Linux), и в Delphi 6 (для Windows). Для того, чтобы это приложение выполнялось корректно, Вам возможно придется исправить ошибку в модуле Qt (см. предыдущую статью).</p>

<p>Еще один пример использования перехватчиков - приложение, отслеживающее состояние буфера обмена Qt. Это приложение отображает информацию о mime-типах данных, скопированных в буфер обмена. Кроме того, если в буфере обмена присутствуют данные в текстовом формате, приложение отображает и сами данные. Информация обновляется при изменении содержимого буфера обмена. Для того, чтобы контролировать состояние буфера обмена, мы создаем объект-перехватчик QClipboard_hook и связываем его с методом перехватчиком, имеющим тип QClipboard_dataChanged_Event. Этот метод вызывается всякий раз при изменении содержимого буфера обмена. Ниже приводится исходный текст метода перехватчика.</p>
<pre>
procedure TForm1.ClipboardDataChanged;
var
  QMS : QMimeSourceH;
  S : WideString;
  S1 : String;
  i : Integer;
begin
  QMS:=QClipboard_data(CB);
  Memo1.Lines.Clear;
  (* enumerating clipboard data formats *)
  i:=0;
  S1:=QMimeSource_format(QMS, i);
  while S1&lt;&gt;'' do
  begin
    Memo1.Lines.Add(S1);
    Inc(i);
    S1:=QMimeSource_format(QMS, i);
  end;
  Label3.Caption:='';
  (* if text data is available, we retrieve it *)
  if QTextDrag_canDecode(QMS) then
  begin
    QTextDrag_Decode(QMS, @S);
    Label3.Caption:=S;
  end;
end;
</pre>



<p>Переменная CB указывает на объект буфера обмена. При помощи функции QClipboard_data мы получаем ссылку на объект QMimeSourceH, являющийся контейнером данных, содержащихся в буфере обмена. Этот объект позволяет также получить информацию о типах данных, для чего используется функция QMimeSource_format. Эта функция возвращает строку с именем типа данных. Первый параметр функции - указатель на объект-контейнер, второй параметр - номер типа данных. Типы нумеруются с нуля. Если значение этого параметра превышает номер последнего типа, возвращается пустая строка. В нашем примере мы добавляем строки с именами типов в объект Memo1. Далее с помощью функции QTextDrag_canDecode мы проверяем, содержит ли объект-контейнер данные в текстовом формате и если содержит, извлекаем эти данные при помощи функции QTextDrag_Decode.</p>

<p>Полный исходный текст демонстрационного приложения находится здесь. Отслеживание содержимого буфера обмена работает корректно только для приложений, использующих Qt буфер. С учетом этих ограничений демонстрационное приложение работает и в Windows (будучи скомпилировано в Delphi 6). Для демонстрации его работы Вы можете воспользоваться либо Qt приложениями (в Linux) либо примерами использования CLXDisplay API, поставляемыми с Delphi 6 (в Windows).</p>

<p>В демонстрационном приложении содержится также другой пример использования перехватчиков, в котором с одним объектом-перехватчиком связываются два метода перехватчика. Метод ButtonPressed вызывается в момент, когда кнопка Button1 нажата, метод ButtonReleased в момент, когда кнопка отпущена.</p>

<p>Сигналы и слоты</p>
<p>В приложениях, построенных на основе иерархии объектов часто бывает необходимо, чтобы в ответ на событие, связанное с одним из объектов, вызывался метод другого объекта. Рассмотрим такой пример: пусть в нашем приложении требуется ввести обработку события SomeEvent, связанного с каким-либо объектом VCL. В объекте определено свойство OnSomeEvent процедурного типа TSomeEvent. Когда мы назначаем обработчик событию, мы инициализируем свойство OnSomeEvent значением указателя на метод, список параметров которого соответствует типу TSomeEvent. Как правило метод-обработчик не является методом того объекта, которому принадлежит свойство OnSomeEvent. Таким образом мы устанавливаем связь между двумя объектами. Когда в системе происходит событие SomeEvent, в объекте, с которым связано это событие, выполняется проверка содержимого свойства OnSomeEvent, и если это свойство инициализировано, вызывается соответствующий метод-обработчик.</p>

<p>В Qt library взаимодействие между объектами осуществляется при помощи механизма сигналов и слотов. Объект Qt генерирует (в терминологии Qt "эмитирует") сигнал в ответ на событие. Для приема и обработки сигналов служат слоты. Также как и сигналы, слоты являются частью объектов Qt. Каждому слоту в данном объекте сопоставлен какой-либо метод этого объекта. Для того, чтобы объект реагировал на некоторый сигнал, необходимо связать этот сигнал с одним из слотов объекта. В этом случае после генерации сигнала будет вызван метод, соответствующий данному слоту. Если сигнал несет какие-либо данные о событии, эти данные могут быть переданы методу обработчику через его параметры. Связывание сигналов и слотов похоже на назначение обработчиков событий объектов Object Pascal, однако между реализацией взаимодействия объектов в Object Pascal и Qt есть существенные различия. Многие объекты библиотеки Qt library уже имеют слоты для обработки определенных сигналов и для связывания их друг с другом не требуется перекрывать их методы в объектах-потомках. Во-вторых механизм взаимодействия сигналов и слотов позволяет связывать сигналы и слоты разных типов, не заботясь о соответствии списков параметров. Если список параметров сигнала не соответствует списку параметров обработчика, при вызове обработчик получает значения параметров, установленные по умолчанию. Третье отличие заключается в возможности связывать один сигнал с несколькими слотами и один слот с несколькими сигналами. Это означает, что событию может быть сопоставлено несколько обработчиков, являющихся методами разных объектов, и в ответ на событие будут вызываться все назначенные ему обработчики.</p>

<p>CLXDisplay API предоставляет средства для работы с сигналами и слотами Qt. Для связывания сигналов и слотов служит функция QObject_connect. Функции передается четыре параметра. Первый параметр - указатель на объект-источник сигнала. Второй параметр - строка типа PChar. В этой строке передается имя сигнала, соответствующее синтаксису языка C++. Имя сигнала должно предваряться символом "2". Третий параметр функции QObject_connect - указатель на метод-приемник. Четвертый параметр - строка типа PChar, содержащая имя слота, соответствующее синтаксису C++ и предваряемое символом "1".</p>

<p>Рассмотрим пример:</p>
<p>В Qt классе QLineEdit, лежащем в основе компонента VisualCLX TEdit, определен сигнал textChanged, который эмитируется при изменении строки в окне компонента. В классе QLabel, на котором основан компонент TLabel, определен слот setText, который позволяет задать строку в компоненте Label. Если связать сигнал textChanged экземпляра класса QLineEdit со слотом setText экземпляра класса QLabel, изменения в строке ввода будут немедленно отображаться в строке QLabel. Для того, чтобы связать указанные сигнал и слот, необходимо вызвать функцию QObject_connect со следующими значениями:</p>

<p>QObject_connect(Edit1.Handle, PChar('2textChanged ( const QString &amp; )'), Label2.Handle, PChar('1setText( const QString &amp; )'));</p>

<p>Первый параметр - указатель на объект-источник сигнала, в данном случае QEdit. Второй параметр - имя сигнала, определенное в заголовочном файле C++ qlineedit.h, с прибавлением двойки, указывающей на то, что это сигнал. Третий параметр - ссылка на объект-приемник сигнала (QLabel). Четвертый параметр - имя слота из файла qlabel.h с прибавлением единицы. Обратите внимание на то, что в данном случае списки параметров сигнала и слота совпадают, так что в ответ на сигнал слоту будет передана строка измененного текста. Приложение, демонстрирующее связывание сигналов и слотов в Object Pascal, можно скачать здесь. Следует отметить, что в Delphi 6 это приложение работает не совсем корректно.</p>

<p>Для разрыва связи между сигналом и слотом используется функция QObject_disconnect. Обычно в обращении к этой функции нет необходимости, так как при уничтожении экземпляра Qt объекта все связи с его сигналами и слотами разрываются автоматически. Функцию QObject_disconnect следует использовать если необходимо разорвать связь между сигналом и слотом до уничтожения соответствующих объектов. Список параметров у функции QObject_disconnect такой же, как и у функции QObject_connect. Значение nil, переданное функции QObject_connect в том или ином параметре (сигнал, слот, объект приемник), интерпретируется функцией как "групповой символ" и позволяет выполнять операцию разрыва связи сразу над множеством элементов. Например, вызов</p>

<p>QObject_disconnect(SomeControl.Handle, PChar('2SomeSignal ()'), nil, nil);</p>

<p>отсоединяет все слоты, связанные с сигналом SomeSignal Qt объекта, соответствующего SomeControl.</p>

<p>В рамках CLXDisplay API определено большое количество сигналов и слотов. Если же Вы захотите добавить свои сигналы и слоты, Вам придется объединить фрагменты программ, написанные на Object Pascal и C++.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

