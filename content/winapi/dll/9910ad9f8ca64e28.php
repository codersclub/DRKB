<h1>Использование DLL в качестве плагина</h1>
<div class="date">01.01.2007</div>


<p>В темах для написания статей раздела "Hello World" присутствует вопрос о динамических библиотеках и модуле ShareMem. Я хотел бы несколько расширить постановку вопроса: Пусть нам надо построить систему безболезненно расширяемую функционально. Напрашивающее ся само собой решение &#8212; библиотеки динамической компоновки. И какие же грабельки разбросаны на этой тропинке? </p>

<p>Грабли </p>

<p>В месте моей текущей трудовой деятельности вопрос о такой системе всплыл давно. И поскольку он не собирался тонуть, создать такую систему пришлось. Так что всё изложенное ниже &#8212; из собственного опыта. </p>

<p>Первый вопрос возникающий при создании библиотеки (DLL): А что это тут написано в закомментированной части исходного кода библиотеки. А рассказывается там следующее &#8212; если вы используете динамические массивы, длинные строки (что и является динамическим ма ссивом) как результат функции, то необходимо чтобы первым в секции uses стоял модуль ShareMem. Причём и в основном проекте! От себя добавлю, что это относится более широко к тем случаям, когда вы выделяете память в одной библиотеке, а освобождаете в друго й, что и произойдёт когда вы создадите динамический массив в одной Dll-ке, а освободите его в другой. </p>

<p>Использовать ли ShareMem &#8212; вопрос конкретной постановки задачи. Если можно обойтись без таких выделений памяти, то вперёд, с песней! Иначе придётся вместе с программой таскать borlndmm.dll, которая и реализует безболезненный обмен указателями между библио теками. </p>

<p>Можно задаться вопросом "А почему?". И получить ответ "Так надо!". По всей видимости, Delphi работает с Heap (кучей, откуда выделяется память) по-своему. Некоторое время назад мы на работе обсуждали этот вопрос, ползали по исходникам и к единому мнению та к и не пришли. Но есть предположение, что Delphi выделяет сразу большой кусок памяти в куче и уже потом по запросу отрезает от него требуемые кусочки, тем самым не доверяя системе выделять память. Возможно, это не так и если кто подправит меня, буду благо дарен. Так или иначе &#8212; проблема существует, и решение имеется. </p>

<p>Вопрос второй, он освещался уже на этом сайте &#8212; а вот хочется положить форму в нашу библиотеку. Нет проблем, кладём, запускаем. Форма создаёт свою копию на панели задач. Почему? Если вы создавали окно средствами WinAPI, то обращали внимание на то, что заг оловок окна и текст соответствующей кнопки на панели задач совпадают и сделать их (тексты) различными невозможно. Т.е. когда процесс создаёт первое окно, у которого владелец &#8212; пустая ссылка (если точнее то Handle &#8212; дескриптор), то окно выводится на панель задач. А как же Delphi? В переменной Application:TApplication, которая имеется всегда, когда вы используете модуль Forms, при создании Application содаётся невидимое окно, которое становится владельцем для всех окон приложения. А поскольку у библиотеки н е происходит действий по инициализации окна переменной Application, то создаваемая форма не имеет окна владельца и как следствие &#8212; появление кнопки на панели задач. Решение уже описано, это передача ссылки на экземпляр объекта Application из вызывающей пр ограммы в вызываемый модуль и присвоение переменной Application переданного значения. Главное перед выгрузкой библиотеки не забыть вернуть старое значение Application. </p>

<p>Совпадение свойств Name разных окон будет вызывать исключительную ситуацию. Избегнуть этого не сложно, а возникает ошибка видимо из-за того, что разные типы классов имеют одно имя в пределах одного контейнера. </p>

<p>Достаточно важным является уничтожение окна перед выгрузкой библиотеки и завершением программы. Delphi расслабляет: за выделенными ресурсами следить не надо, окна сами создаются и уничтожаются и ещё много чего делается за программиста. Накидал компонентик ов, установил связи и всё готово... Представим: библиотека выгружена, окно из библиотеки существует, система за библиотекой уже почистила дескрипторы, да остальные ресурсики и что получается? Секунд пять Delphi при закрытии программы висит, а затем "Acces s violation ..." далее вырезано цензурой... </p>

<p>Больше граблей замечено не было. Да и упомянутые &#8212; серьёзной проблемы не представляют, единственное, что нужно, писАть аккуратно, текст вылизывать, да и думать почаще. </p>

<p>Построение программы с Plug In-ами </p>

<p>Возможно 2 подхода к построению такой программы </p>

<p>плагины получают информацию от ядра программы, но сами к ядру не обращаются. Назовём такой подход пассивным. в активном подходе плагины инициируют некоторые события и заставляют ядро их слушаться. </p>

<p>Второй подход требует более сложного алгоритмического построения, поэтому я рассмотрю только первый. </p>

<p>Пусть у нас есть программа, умеющая подключать динамические библиотеки (любые). Но для эффективной работы необходимо, чтобы эти библиотеки предоставляли стандартный интерфейс по передаче данных. По-русски, должен существовать стандартный набор экспортируе мых функций библиотеки, через которые программа будет с ними общаться. </p>

<p>В процессе работы выяснилось, что для пассивной модели достаточно 6 функций: </p>

<p>Получение внутренней информации о плагине (в программе function GetModuleInfo:TModuleInfo). При наличии в библиотеке такой функции и правильном её вызове, мы будем знать что эта DLL &#8212; наш плагин. Сама функция может возвращать что угодно, например название и тип плагина. </p>

<p>Формирование начальных значений (в программе procedure Initialize). Плагин приводит себя в порядок после загрузки, т.е. заполняет переменные значениями по умолчанию. Передача данных в плагин (в программе procedure SetData(Kind:TDataKind;const Buffer;Size:Integer)). Позволяет передавать данные в плагин. Получение данных &#8212; в программе не реализована, но делается по типу SetData. Запуск плагина (в программе Run). Запускается плагин. Действия могут быть различными: показ окна, модальный показ окна, расчёт какого-либо параметра и т.д. И есесьно останов плагина. Здесь действия обратные пункту 2. </p>

<p>Немного остановлюсь на передаче данных. Паскаль при всей своей жёсткой типизации предоставляет приятное средство передачи в функцию нетипизированных данных. Если программа знает о том, какие именно данные пришли, оттипизировать :) их достаточно просто. Эт от способ передачи используется в SetData. В модуле SharedTypes.Pas, используемом всеми тремя проектами описаны соответствующие константы TDataKind для типов передаваемых данных. </p>

<p>Теперь о реализации </p>

<p>Пусть ядро, т.е. exe-файл, ищет плагины, запускает их и по таймеру передаёт в них два цифровых значения, которые один плагин будет изображать в текстовом виде, а второй в виде диаграмм. Реализация плагинов отличается минимально, поэтому расскажу об одном &#8212; Digital.dll. Начнём перечисление функций: </p>

<pre>
// получение информации о плагине
function GetModuleInfo:TModuleInfo;stdcall;
var
  Buffer:array [byte] of char;
begin
  with Result do begin
    Name:='Отображение цифровых данных';
    Kind:=mkDigital;
    if GetModuleFileName(hInstance,@Buffer,SizeOf(Buffer)-1)&gt;0 then
      Path:=ExtractFilePath(StrPas(Buffer));
  end;
end;
 
// Функция возвращает информацию о модуле. В данном
// случае это цифровое отображение, путь и тип модуля.
 
// инициализация
procedure Initialize;stdcall;
begin
  // запоминание старого Application
  OldApp:=Application;
  fmDigitalMain:=nil;
end;
 
// Процедура запоминает переменную Application
// и делает нулевой ссылку на форму плагина.
 
// запуск
procedure Run;stdcall;
begin
  // создание окна плагина
  if fmDigitalMain=nil then
    fmDigitalMain:=TfmDigitalMain.Create(Application);
end;
 
// Процедура запуска плагина созда?т окно.
// Окно созда?тся видимым.
 
// останов
procedure Terminate;stdcall;
begin
  // освобождение окна
  fmDigitalMain.Free;
  fmDigitalMain:=nil;
  // восстановление старого TApplication
  Application:=OldApp;
end;
 
// Процедура уничтожает окно и возвращает старый TApplication.
 
// при?м данных
procedure SetData(Kind:TDataKind;const Buffer;Size:Integer);stdcall;
begin
  case Kind of
    // передача TApplication
    dkApplication:if Size=SizeOf(TApplication) then
      Application:=TApplication(Buffer);
    // передача данных во время работы
    dkInputData:if fmDigitalMain&lt;&gt;nil then begin
      fmDigitalMain.SetData(Buffer,Size);
    end;
  end;
end;
 
// Процедура получения данных. В зависимости от полученного
// типа данных с данные в переменной Buffer соответственно
// типизируются. Здесь происходит обращение к форме плагина,
// расписывать я его не буду, там вс? просто, см. исходники.
// Типы, которые используются  здесь, описаны в SharedTypes.pas
</pre>


<p>По плагинам это всё. </p>

<p>Ядро </p>

<p>Прежде всего следует подумать об инкапсуляции функций подключённого плагина в класс. Этот класс реализован в Modules.pas. При создании экземпляра класса происходит поиск и запоминание всех адресов функций плагина. Последующие вызовы функций происходят в о дноимённых методах класса в том случае, если они не равны. Я приведу только описание типа класса: </p>

<pre>
type
  // описания типов функций модуля
  TGetModuleInfo=function:TModuleInfo;stdcall;
  TInitialize=procedure;stdcall;
  TRun=procedure;stdcall;
  TTerminate=procedure;stdcall;
  TSetData=procedure(Kind:TDataKind;const Buffer;Size:Integer);stdcall;
 
  // непосресдвенно сам класс
  TModule=class
  private
    FFileName:String;  //имя файла
    FHandle:THandle;   // дескриптор библиотеки
    FModuleInfo:TModuleInfo;  // информация о модуле
    // адреса функций плагина
    FGetModuleInfo:TGetModuleInfo; // функция получения информации о модуле
    FInitialize:TInitialize;  // процедура инициализации 
    FRun:TRun;  // процедура запуска
    FTerminate:TTerminate;  // процедура останова
    FSetData:TSetData;  // процедура передачи данных
  public
    constructor Create(AFileName:String;var IsValidModule:Boolean);
    destructor Destroy;override;
    // вызов функций плагина
    function GetModuleInfo:TModuleInfo;
    procedure Initialize;
    procedure Run;
    procedure Terminate;
    procedure SetData(Kind:TDataKind;const Buffer;Size:Integer);
    // свойства плагина
    property FileName:String read FFileName;
    property Handle:THandle read FHandle;
    property ModuleInfo:TModuleInfo read FModuleInfo;
  end;
</pre>



<p>Как видно из текста, это простая надстройка над плагином, не добавляющая функциональности, но позволяющая хранить всё в одном объекте. </p>

<p>Теперь осталось только собрать плагины и запустить. Сбор информации и запуск происходит по нажатию одноимённой кнопки на главной форме. Как собирать плагины &#8212; дело вкуса. В этом примере я сканирую заданный каталог, можно хранить в INI-файле, реестре, можн о придумать свой формат хранения. Сбор плагинов: </p>

<pre>
// нажатие кнопки запуска
procedure TfmMain.btStartClick(Sender: TObject);
  // добавление плагинов в список
  procedure AppendModulesList(FileName:String);
  var
    Module:TModule;
    IsValid:Boolean;
  begin
    // создание экземпляра плагина
    Module:=TModule.Create(FileName,IsValid);
    // если создан некорректно
    if not IsValid then
      // удаление
      Module.Free
    else begin
      // добавление
      SetLength(ModulesList,Length(ModulesList)+1);
      ModulesList[Length(ModulesList)-1]:=Module;
    end;
  end;
 
var
  sr:TSearchRec;
  i:Integer;
begin
  // построение списка модулей
  SetLength(ModulesList,0);
  // поиск файлов *.dll
  if FindFirst(edPath.Text+'*.dll',faAnyFile and not faDirectory,sr)=0 then begin
    AppendModulesList(edPath.Text+sr.Name);
    while FindNext(sr)=0 do
      AppendModulesList(edPath.Text+sr.Name);
  end;
  // запуск найденных модулей
  if Length(ModulesList)&gt;0 then begin
    for i:=0 to Length(ModulesList)-1 do begin
      // инициализация
      ModulesList[i].Initialize;
      // передача Application
      ModulesList[i].SetData(dkApplication,Application,SizeOf(Application));
      // запуск плагина
      ModulesList[i].Run;
    end;
    // старт таймера
    Events.Enabled:=True;
  end;
end;
</pre>

<p>Мне кажется, что я достаточно подробно описал в комментариях производимые действия :) Ну и последнее &#8212; засылка данных по таймеру: </p>

<pre>
procedure TfmMain.EventsTimer(Sender: TObject);
var
  Values:array [0..1] of Word;
  i:Integer;
begin
  // формирование случайных значений
  Values[0]:=Random($ffff);
  Values[1]:=Random($ffff);
  // передача данных
  if Length(ModulesList)&gt;0 then
    for i:=0 to Length(ModulesList)-1 do begin
      ModulesList[i].SetData(dkInputData,Values,SizeOf(Values));
    end;
end;
</pre>
<p>Желательно не забывать об освобождении модулей</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
