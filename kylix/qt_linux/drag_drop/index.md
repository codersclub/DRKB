---
Title: Межплатформенный Drag & Drop
Date: 01.01.2007
---


Межплатформенный Drag & Drop
============================

::: {.date}
01.01.2007
:::

\"Межплатформенный\" Drag & Drop

Сначала рассмотрим технологию Drag&Drop в Windows так как большинство
знакомых мне программистов работает именно в этой ОС.

Немного Windows API

Итак, чтоб заставить приложение реагировать на события Drag&Drop, нам
нужно воспользоваться функциями DragAcceptFiles, DragQueryFile и
DragFinish из модуля ShellAPI.pas.

Первая из них имеет вид:

procedure DragAcceptFiles (Wnd: HWND; Accept: BOOL); stdcall;

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------------------------------------
  ·   Wnd - дескриптор окна, для которого будет установлено разрешение на прием перетаскиваемых объектов;
  --- -----------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------------------------------------------------------------------------
  ·   Accept - собственно разрешение (True - разрешить прем объектов; False - запретить).
  --- -------------------------------------------------------------------------------------
:::

При установленном флаге Accept реакция приложения распространяется на
все файлы и папки, расположенные на любых дисках. Реакция приложения не
распространяется на метаелементы оболочки - то есть на Панель
управления, Принтеры, Сетевое окружение, иконки дисков в Моем
компьютере...После этого при перетаскивании файлов или папок на
\"допущенный\" элемент приложения курсор меняет свою форму При
\"отпускании\" объекта на элементе тому посылается сообщение
WM\_DROPFILES, которое оповещает о произошедшем событии Drag&Drop.
Параметр wParam сообщения содержит идентификатор события и потребуется
нам дальше.

Вторая функция используется для получения списка файлов (как мы помним,
перетаскивать можно несколько файлов, папок...), которые были
передвинуты на наш компонент:

function DragQueryFile (Drop: HDROP; FileIndex: UINT; FileName: PChar;\

cb: UINT): UINT; stdcall;

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------------------------------------------------
  ·   Drop - идентификатор, который был передан нам через сообщение WM\_DROPFILES;
  --- ------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------
  ·   FileIndex - номер запрашиваемого файла;
  --- -----------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------------------------------------------------------
  ·   FileName - указатель на строку, которая содержит имя файла с индексом (FileIndex);
  --- ------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------
  ·   Cb - размер буфера FileName.
  --- ------------------------------
:::

При передаче параметру FileIndex значения \$FFFFFFFF DragQueryFile
возвращает количество файлов, которые были перетащены на компонент; в
других случаях возвращаемое значение - количество скопированных в буфер
FileName символов.

DragFinish - используется для освобождения памяти занятой при
перетаскивании. Формат функции:

procedure DragFinish (Drop: HDROP); stdcall;

Алгоритм работы

Во-первых, мы разрешим \"системное\" перетаскивание на какой-нибудь
компонент посредством DragAcceptFiles. Далее мы каким-либо образом
должны отследить возникновение сообщения WM\_DROPFILES и записать из
полученных при его отправке данных значение wParam, которое потом
используем вместе с DragQueryFile, для того чтоб вывести список
перетасканных файлов. Ну и под конец - завершаем эту процедуру
освобождением памяти (DragFinish).

В первом приближении все очень просто. Трудности начинают возникать,
когда мы доходим до отлавливания сообщения WM\_DROPFILES. И тут есть
несколько вариантов. Во-первых, можно создать новый класс, в котором
перехватывается это сообщение. Например, так:

    TMyListBox = class (TListBox)
    private
    FOnDropFiles:TNotifyEvent;
    FDrop:THandle;
    protected
    procedure WMDropFiles (var Message:TMessage); message WM_DROPFILES;
    public
    property Drop:THandle read FDrop write FDrop;
    property OnDropFiles:TNotifyEvent read FOnDropFiles write FOnDropFiles;
    end;

Кроме того, можно создать универсальный компонент, который подменял бы
метод WindowProc заданного компонента и таким образом давал нам
возможность реагировать на сообщение. Этот метод более сложен при
начальной реализации (написании компонента), но дает ощутимый прирост в
скорости проектирования приложений.

В этой статье мы рассмотрим первый метод, а кто захочет \"пойти другим
путем\", может скачать компонент ShellDragDrop c моего сайта
(www.g299792458.boom.ru).

Реализация

Для демонстрации мы сначала нарисуем форму и разместим на ней кнопку. В
секции private нашей формы разместим декларацию объекта LB типа
TMyListBox и добавим метод:

procedure DoDropFiles (Sender:TObject);

Далее запишем реакцию кнопки на нажатие:

    procedure TForm1.Button1Click (Sender: TObject);
    begin
    LB:=TMyListBox.Create (Self);
    LB.Parent:=Self;
    LB.SetBounds (10,10,100,100);
    LB.OnDropFiles:=Self.DoDropFiles;
    DragAcceptFiles (LB.Handle,True);
    end;

И формы на уничтожение:

    procedure TForm1.FormDestroy (Sender: TObject);
    begin
    DragAcceptFiles (LB.Handle,False);
    LB.Free;
    end;

Теперь перейдем к реализации нашего вновь созданного компонента
TmyListBox (см. листинг 1):

    procedure TMyListBox.WMDropFiles (var Message:TMessage);
    begin
    Drop:=Message.WParam;
    if Assigned (OnDropFiles) then OnDropFiles (Self);
    end;

И наконец - реализация собитыя OnDropFiles:

    procedure TForm1.DoDropFiles (Sender:TObject);
    var CB:Integer;I,j:Integer;
    Str:Array [0..MAX_PATH] of Char;
    begin
    I:=DragQueryFile ((Sender as TMyListBox).Drop,$FFFFFFFF,nil,cb);
    (Sender as TMyListBox).Items.Add (IntToStr (I));
    For j:=0 to i-1 do
    begin
    FillChar (Str,SizeOf (Str),0);
    DragQueryFile ((Sender as TMyLIstBox).Drop,j,Str,MAX_PATH);
    (Sender as TMyListBox).Items.Add (Str);
    end;
    end;

После запуска приложения появляется главная форма с кнопкой, по нажатии
которой создается компонент LB. Теперь попробуем перетащить на него один
или несколько ярлыков, которые находятся на рабочем столе. Как видим, в
нашем боксе появилась требуемая информация. Полный текст программы
приведен в листинге 1.

А теперь - Kylix\...

Те из вас, кто уже пробовал Kylix, могут заметить, что переход на него
действительно не вызывает сложностей, пока вы не выходите за рамки
готовых компонент, но теперь мы покажем, как можно проделать такое
\"нестандартное\" действие под Linux.

 \

Определения

Для начала, чтоб не было неясностей, скажу, что испытания проводились на
ASPLinux 7.3, которая поставлялась на диске \"К + П\" № 2/2003г.
Программа была написана на Borland Kylix v1.0 Server Developer. При
проверке приложения использовался Konqueror (рис. 3) - стандартный
проводник KDE.

Немного теории

Во-первых, наше приложение будет основываться на работе с модулем
Qt.pas, в котором объявлены все жизненно важные объекты, переменные,
типы и т.д. Заметим также, что работа приложений под Linux (на мой
взгляд) кардинально отличается от работы приложений в Windows. Так, если
Windows API основано на обработке сообщений, то в Linux роль сообщений
играют сигналы и слоты, а при использовании Qt - события (отдаленно
напоминающие события компонентов Delphi). Взаимодействие с системой
осуществляется не путем перехвата сообщений, а путем создания реакции на
событие и его регистрации.

Лезем в \"дебри\" Qt

Сначала воспользуемся функцией QEvent\_hook\_create для создания
экземпляра объекта, который бы реагировал на события:

function QEvent\_hook\_create (handle: QObjectH): QEvent\_hookH; cdecl;

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------------------------------------------------------
  ·   Handle - идентификатор объекта, для которого создается реакция на событие;
  --- ----------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------------------------------------
  ·   Результат - идентификатор реагирующего объекта.
  --- -------------------------------------------------
:::

По завершении работы приложения надо будет освободить реагирующий
объект:

procedure QEvent\_hook\_destroy (handle: QEvent\_hookH); cdecl;

Теперь нам нужно создать собственно реакцию на событие, которое должно
иметь следующий вид:

TEventFilterMethod = function (Sender: QObjectH; Event: QEventH):\

Boolean of object cdecl;

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------
  ·   Sender - идентификатор объекта который должен реагировать на событие;
  --- -----------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------------------------------------------------
  ·   Event - идентификатор события, на которое должен реагировать объект.
  --- ----------------------------------------------------------------------
:::

После этого нам необходимо инициализировать ее:

procedure Qt\_hook\_hook\_events (handle: QObject\_hookH;\

hook: QHookH); cdecl;

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------------------------------
  ·   Handle - идентификатор объекта-реакции на событие;
  --- ----------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------------------------------------
  ·   Hook - метод, который собственно и реагирует на события объекта.
  --- ------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ----------------------------------------------------------------------------
  ·   результат - True, если на событие успешно отреагировали; False - если нет.
  --- ----------------------------------------------------------------------------
:::

Поскольку мы пишем реакцию, которая должна незаметно влиять на работу
нашего компонента, то результат всегда должен быть равен False.

 \

В самом методе Hook нам необходимо разобрать, на какие события следует
реагировать, так как ему передаются все без исключения события,
связанные с прикрепленным (через QEvent\_hook\_create) объектом. Для
выделения необходимого события используются методы QEvent\_isXXXXXX, где
XXXX - название события.

Для наших нужд потребуется только одни метод -
QEvent\_isQDropEventEvent:

function QEvent\_isQDropEventEvent (e: QEventH): Boolean; cdecl;

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------------------------------------------------------------
  ·   e - значение, переданное параметру Event из шаблона TeventFilterMethod;
  --- -------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------------------
  ·   результат - True, если событие относится к Drag&Drop; False - в противном случае.
  --- -----------------------------------------------------------------------------------
:::

После того как QEvent\_isQDropEventEvent вернул true, нам следует
перекодировать событие в QMimeSourceH посредством метода:

function QDropEvent\_to\_QMimeSource (handle: QDropEventH):\

QMimeSourceH; cdecl;

далее принять на обработку это событие:

procedure QDropEvent\_acceptAction (handle: QDropEventH;\

y: Boolean); cdecl;

и, наконец, декодировать событие в приятный нашему взгляду вид:

function QTextDrag\_decode (e: QMimeSourceH; s: PWideString):\

Boolean; overload; cdecl;

После этого мы можем спокойно обрабатывать наши \"перетасканные\" файлы.

К делу

Итак, для начала создадим форму и разместим на ней кнопку и компонент
TListBox, который, собственно, и будет играть роль приемника
перетаскиваний. В кнопке запишем код, который будет инициализировать наш
TListBox на обработку событий Drag&Drop:

    procedure TForm1.Button1Click (Sender: TObject);
    begin
    QWidget_setAcceptDrops (ListBox1.Handle,True);
    Evt:=QEvent_hook_create (Self.ListBox1.Handle);
    //Filter:=Self.EvtFilter;
    TEventFilterMethod (H):=EvtFilter;
    Qt_hook_hook_events (Evt,H);
    end;

При закрытии формы мы должны освободить наш объект Evt от исполняемых им
обязанностей:

    procedure TForm1.FormDestroy (Sender: TObject);
    begin
    QEvent_hook_destroy (Evt);
    end;

Теперь нам осталось только написать необходимую реакцию на события:

    function TForm1.EvtFilter (Sender:QObjectH; Event:QEventH):Boolean;
    var QMS:QMimeSourceH;
    S:WideString;
    begin
    Result:=False;
    if QEvent_isQDropEventEvent (Event) then
    begin
    QMS:=QDropEvent_to_QMimeSource (QDropEventH (Event));
    QDropEvent_acceptAction (QDropEventH (Event),QTextDrag_canDecode (QMS));
    if QTextDrag_canDecode (QMS) then
    begin
    ListBox1.Items.Clear;
    QTextDrag_decode (QMS,@S);
    ListBox1.Items.Add (S);
    end
    end else
    if QEvent_isQCloseEvent (Event) then
    QEvent_hook_destroy (Evt);
    end;

Код:

if QEvent\_isQCloseEvent (Event) then\

QEvent\_hook\_destroy (Evt);

\- добавлен просто так, на всякий случай. У меня Kylix время от времени
зависал при закрытии приложения, а вот после добавления такой строчки
кода - ни разу.

В листинге 2 показан код приложения, о котором шла речь в этой статье.

Послесловие

Сразу же хочу предупредить тех, кто, читая эту статью, уже \"сидит\" в
Kylix\'е: в портированном Borland экземпляре Qt.pas (в версии Kylix 1.0,
а, возможно, и в других) неправильно определена функция
QEvent\_isQDropEventEvent. Для правильной работы вам необходимо в модуле
Qt.pas в секции реализации заменить имя функции на которую ссылается
QEvent\_isQDropEventEvent c QEvent\_isQDropEventEvent на
QEvent\_isQDropEvent.

Несколько слов для тех, кто хочет самостоятельно попробовать написать
универсальный компонент для работы с Drag&Drop. Во-первых, дерзайте -
ибо лучше наступать на свои \"грабли\", нежели на чужые (да и обиды
будет меньше, если что не так). Не забывайте освобождать занятые
ресурсы; и, если вы пишите в моем стиле, будьте осторожны при отладке
компонента и при закрытии приложения. Ну а если уж совсем ничего не
получается, используйте мой компонент.

А для юзающих Kylix скажу, что здесь также можно \"пойти другим путем\"
- созданием собственного компонента, на который возлагалась бы задача по
захвату событий и освобождению занятых ресурсов по окончании работы. Мы
бы только трудились над реакцией компонента на те или иные события. В
модуле QControls.pas есть некое подобие такого компонента
(TX11DragFilter), и хотя этот компонент и не подходит под концепцию
\"визуального программирования\", он может зато послужить основой для
создания собственных компонентов.

Листинг 1. Создание компонента TmyListBox под Windows

    unit Unit1; 
    interface 
    uses 
    Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms, 
    Dialogs, StdCtrls; 
    type 
    TMyListBox = class (TListBox) 
    private 
    FOnDropFiles:TNotifyEvent; 
    FDrop:THandle; 
    protected 
    procedure WMDropFiles (var Message:TMessage); message WM_DROPFILES; 
    public 
    property Drop:THandle read FDrop write FDrop; 
    property OnDropFiles:TNotifyEvent read FOnDropFiles write FOnDropFiles; 
    end; 
    TForm1 = class (TForm) 
    Button1: TButton; 
    procedure Button1Click (Sender: TObject); 
    procedure FormDestroy (Sender: TObject); 
    private 
    LB:TMyListBox; 
    procedure DoDropFiles (Sender:TObject); 
    {Private declarations} 
    public 
    {Public declarations} 
    end; 
    var 
    Form1: TForm1; 
    implementation 
    Uses ShellAPI; 
    {$R *.dfm} 
    procedure TMyListBox.WMDropFiles (var Message:TMessage); 
    begin 
    Drop:=Message.WParam; 
    if Assigned (OnDropFiles) then OnDropFiles (Self); 
    end; 
    procedure TForm1.DoDropFiles (Sender:TObject); 
    var CB:Integer;I,j:Integer; 
    Str:Array [0..MAX_PATH] of Char; 
    begin 
    I:=DragQueryFile ((Sender as TMyListBox).Drop,$FFFFFFFF,nil,cb); 
    (Sender as TMyListBox).Items.Add (IntToStr (I)); 
    For j:=0 to i-1 do 
    begin 
    FillChar (Str,SizeOf (Str),0); 
    DragQueryFile ((Sender as TMyLIstBox).Drop,j,Str,MAX_PATH); 
    (Sender as TMyListBox).Items.Add (Str); 
    end; 
    end; 
    procedure TForm1.Button1Click (Sender: TObject); 
    begin 
    LB:=TMyListBox.Create (Self); 
    LB.Parent:=Self; 
    LB.SetBounds (10,10,300,100); 
    LB.OnDropFiles:=Self.DoDropFiles; 
    DragAcceptFiles (LB.Handle,True); 
    end; 
    procedure TForm1.FormDestroy (Sender: TObject); 
    begin 
    DragAcceptFiles (LB.Handle,False); 
    LB.Free; 
    end; 
    end. 

Листинг 2. Создание компонента TmyListBox под Kylix

    unit Unit1; 
    interface 
    uses 
    SysUtils, Types, Classes, Variants, QGraphics, QControls, QForms, QDialogs,Qt, 
    QStdCtrls; 
    type 
    TForm1 = class (TForm) 
    ListBox1: TListBox; 
    Button1: TButton; 
    procedure Button1Click (Sender: TObject); 
    procedure FormDestroy (Sender: TObject); 
    private 
    Evt:QEvent_hookH; 
    H:TMethod; 
    // FFilter:TEventFilterMethod; 
    function EvtFilter (Sender: QObjectH; Event: QEventH): Boolean; cdecl; 
    {Private declarations} 
    public 
    {Public declarations} 
    // property Filter:TEventFilterMethod read FFilter write FFilter; 
    end; 
    var 
    Form1: TForm1; 
    implementation 
    {$R *.xfm} 
    function TForm1.EvtFilter (Sender:QObjectH; Event:QEventH):Boolean; 
    var QMS:QMimeSourceH; 
    S:WideString; 
    begin 
    Result:=False; 
    if QEvent_isQDropEventEvent (Event) then 
    begin 
    QMS:=QDropEvent_to_QMimeSource (QDropEventH (Event)); 
    QDropEvent_acceptAction (QDropEventH (Event),QTextDrag_canDecode (QMS)); 
    if QTextDrag_canDecode (QMS) then 
    begin 
    ListBox1.Items.Clear; 
    QTextDrag_decode (QMS,@S); 
    ListBox1.Items.Add (S); 
    end 
    end else 
    if QEvent_isQCloseEvent (Event) then 
    QEvent_hook_destroy (Evt); 
    end; 
    procedure TForm1.Button1Click (Sender: TObject); 
    begin 
    QWidget_setAcceptDrops (ListBox1.Handle,True); 
    Evt:=QEvent_hook_create (Self.ListBox1.Handle); 
    //Filter:=Self.EvtFilter; 
    TEventFilterMethod (H):=EvtFilter; 
    Qt_hook_hook_events (Evt,H); 
    end; 
    procedure TForm1.FormDestroy (Sender: TObject); 
    begin 
    QEvent_hook_destroy (Evt); 
    end; 
    end. 

 \
2004.05.14 Автор: Михаил Продан\
<https://www.cpp.com.ua>
