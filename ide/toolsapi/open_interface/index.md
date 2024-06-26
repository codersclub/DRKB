---
Title: Использование открытых интерфейсов
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Использование открытых интерфейсов
==================================

Одной и наиболее сильных сторон среды программирования Delphi является
ее открытая архитектура, благодаря которой Delphi допускает своего рода
метапрограммирование, позволяя "программировать среду
программирования". Такой подход переводит Delphi на качественно новый
уровень систем разработки приложений и позволяет встраивать в этот
продукт дополнительные инструментальные средства, поддерживающие
практически все этапы создания прикладных систем. Столь широкий спектр
возможностей открывается благодаря реализованной в Delphi концепции так
называемых открытых интерфейсов, являющихся связующим звеном между IDE
(Integrated Development Environment) и внешними инструментами. Данная
статья посвящена открытым интерфейсам Delphi и представляет собой обзор
представляемых ими возможностей.

В Delphi определены шесть открытых интерфейсов: Tool Interface, Design
Interface, Expert Interface, File Interface, Edit Interface и Version
Control Interface. Вряд ли в рамках данной статьи нам удалось бы
детально осветить и проиллюстрировать возможности каждого из них. Более
основательно разобраться в рассматриваемых вопросах вам помогут исходные
тексты Delphi, благо разработчики снабдили их развернутыми
комментариями. Объявления классов, представляющих открытые интерфейсы,
содержатся в соответствующих модулях в каталоге
`...\Delphi\Source\ToolsAPI`.

Design Interface (модуль DsgnIntf.pas)
: предоставляет средства для создания редакторов свойств и редакторов
компонентов. Редакторы свойств и компонентов - это тема, достойная
отдельного разговора, поэтому напомним лишь, что редактор свойства
контролирует поведение Инспектора Объектов при попытке изменить значение
соответствующего свойства, а редактор компонента активизируется при
двойном нажатии левой кнопки мыши на изображении помещенного на форму
компонента.

Version Control Interface (модуль VCSIntf.pas)
: предназначен для создания систем контроля версий. Начиная с версии 2.0,
Delphi поддерживает интегрированную систему контроля версий Intersolv
PVCS, поэтому в большинстве случаев в разработке собственной системы нет
необходимости. По этой причине рассмотрение Version Control Interface мы
также опустим.

File Interface (модуль FileIntf.pas)
: позволяет переопределить рабочую файловую систему IDE, что дает
возможность выбора собственного способа хранения файлов (в Memo-полях на
сервере БД, например).

Edit Interface (модуль EditIntf.pas)
: предоставляет доступ к буферу исходных текстов, что позволяет проводить
анализ кода и выполнять его генерацию, определять и изменять позицию
курсора в окне редактора кода, а также управлять синтаксическим
выделением исходного текста. Специальные классы предоставляют интерфейсы
к помещенным на форму компонентам (определение типа компонента,
получение ссылок на родительский и дочерние компоненты, доступ к
свойствам, передача фокуса, удаление и т.д.), к самой форме и к
ресурсному файлу проекта. Также Edit Interface позволяет
идентифицировать так называемые модульные нотификаторы, определяющие
реакцию на такие события, как изменение исходного текста модуля,
модификация формы, переименование компонента, сохранение, переименование
или удаление модуля, изменение ресурсного файла проекта и т. д.

Tool Interface (модуль ToolIntf.pas)
: предоставляет разработчикам средства для получения общей информации о
состоянии IDE и выполнения таких действий, как открытие, сохранение и
закрытие проектов и отдельных файлов, создание модуля, получение
информации о текущем проекте (число модулей и форм, их имена и т. д.),
регистрация файловой системы, организация интерфейсов к отдельным
модулям и т.д. В дополнение к модульным нотификаторам Tool Interface
определяет add-in нотификаторы, уведомляющие о таких событиях, как
открытие/закрытие файлов и проектов, загрузка и сохранение desktop-файла
проекта, добавление/исключение модулей проекта,
инсталляция/деинсталляция пакетов, компиляция проекта, причем в отличие
от модульных нотификаторов add-in нотификаторы позволяют отменить
выполнение некоторых событий. Кроме того, Tool Interface предоставляет
средства доступа к главному меню IDE Delphi, позволяя встраивать в него
дополнительные пункты.

Expert Interface (модуль ExptIntf.pas)
: представляет собой основу для создания экспертов --- программных
модулей, встраиваемых в IDE c целью расширения ее функциональности. В
качестве примера эксперта можно привести входящий в Delphi Database Form
Wizard, выполняющий генерацию формы для просмотра и изменения
содержимого таблицы БД.

Эксперты бывают нескольких типов (стилей):

Стиль | Описание
------|----------
esStandard | Для каждого эксперта такого стиля IDE добавляет пункт меню Tools/..., при выборе которого эксперт активизируется (IDE вызывает его метод Execute)
esForm<br>esProject | IDE рассматривает эксперты данного стиля как шаблоны форм/проектов и помещает активизирующие их изображения в галерею Object Repository.
esAddIn | Эксперты подобного стиля обеспечивают собственный интерфейс с IDE

Класс каждого эксперта является потомком базового класса TIExpert,
содержащего серию абстрактных методов, которые необходимо перекрыть в
порождаемом классе:

Метод | Описание
------|----------
GetName | Должен возвращать имя эксперта
GetAuthor | Должен возвращать имя автора эксперта. Это имя отображается в Object Repository
GetComment | Должен возвращать комментарий (1-2 предложения), поясняющий назначение эксперта. Используется в Object Repository
GetPage | Должен возвращать название страницы Object Repository, на которую IDE поместит соответствующее эксперту изображение
GetGlyph | Должен возвращать дескриптор (HICON, в Delphi 1.0 - HBITMAP) соответствующего эксперту изображения в ObjectRepository
GetStyle | Должен возвращать константу, соответствующую стилю эксперта (esStandard/esForm/esProject/esAddIn)
GetState | Если возвращаемое множество содержит константу esChecked, IDE пометит соответствующий эксперту пункт меню "галочкой", а если множество содержит константу esEnabled, то IDE сделает этот пункт меню доступным для выбора
GetIDString | Должен возвращать строку - идентификатор эксперта, уникальную среди всех установленных экспертов. По соглашению, формат этой строки таков:<br>Имя\_Компании.Назначение\_эксперта,<br>например: `Borland.WidgetExpert`
GetMenuText | Должен возвращать текст, отображаемый в пункте меню эксперта. Этот метод вызывается каждый раз, когда раскрывается родительское меню, что позволяет сделать пункт меню контекстно-чувствительным
Execute | Вызывается при вызове эксперта через меню или Object Repository (в зависимости от стиля)

Набор методов, подлежащих перекрытию, зависит от стиля эксперта:

Метод |esStandard |esForm |esProject |esAddIn
------|--|--|--|----
GetName |+ |+ |+ |+
GetAuthor | |+ |+ |
GetComment | |+ |+ |
GetPage | |+ |+ |
GetGlyph | |+ |+ |
GetStyle |+ |+ |+ |+
GetState |+ |  |  |   
GetIDString |+ |+ |+ |+
GetMenuText |+ |  |  |   
Execute |+ |+ |+ |


Определив класс эксперта, необходимо позаботиться о том, чтобы Delphi
"узнала" о нашем эксперте. Для этого его нужно зарегистрировать
посредством вызова процедуры RegisterLibraryExpert, передав ей в
качестве параметра экземпляр класса эксперта.

В качестве иллюстрации создадим простой эксперт в стиле esStandard,
который при выборе соответствующего ему пункта меню Delphi выводит
сообщение о том, что он запущен. Как видно из вышеприведенной таблицы,
стиль esStandard обязывает перекрыть шесть методов:

```delphi
unit exmpl_01;
 
{ STANDARD EXPERT }
 
interface
 
uses
  Dialogs, ExptIntf;
 
type
  { класс эксперта является потомком базового класса TIExpert }
  TEMyExpert = class( TIExpert)
    function GetName: string; override;
    function GetStyle: TExpertStyle; override;
    function GetIDString: string; override;
    function GetMenuText: string; override;
    function GetState: TExpertState; override;
    procedure Execute; override;
end;
 
procedure register;
 
implementation
 
{ возвращаем имя эксперта }
function TEMyExpert.GetName: string;
begin
  Result := 'My Simple Expert 1';
end;
 
{ возвращаем стиль эксперта }
function TEMyExpert.GetStyle: TExpertStyle;
begin
  Result := esStandard;
end;
 
{ возвращаем строку - идентификатор эксперта }
function TEMyExpert.GetIDString: string;
begin
  Result := 'Doomy.SimpleAddInExpert_1';
end;
 
{ возвращаем текст пункта меню }
function TEMyExpert.GetMenuText: string;
begin
  Result := 'Simple Expert 1';
end;
 
{ возвращаем множество, характеризующее состояние пункта меню эксперта }
{ (доступность, наличие "галочки"); в данном случае пункт меню доступен, }
{ а "галочка" отсутствует }
function TEMyExpert.GetState: TExpertState;
begin
  Result := [esEnabled];
end;
 
{ при выборе пункта меню эксперта отображаем сообщение }
procedure TEMyExpert.Execute;
begin
  MessageDlg('Standard Expert Started!', mtInformation, [mbOK], 0);
end;
 
{ регистрируем эксперт }
procedure register;
begin
  RegisterLibraryExpert( TEMyExpert.Create);
end;
 
end.
```

Для того чтобы эксперт был "приведен в действие", необходимо выбрать
пункт меню Component/Install Component ..., выбрать в диалоге Browse
модуль, содержащий эксперт (в нашем случае exmpl\_01.pas), нажать ОК, и
после компиляции пакета dclusr30.dpk в главном меню Delphi в разделе
Help должен появиться пункт Simple Expert 1, при выборе которого
появляется информационное сообщение "Standard Expert started!".

Почему Delphi помещает пункт меню эксперта в раздел Help, остается
загадкой. Если вам не нравится то, что пункт меню появляется там, где
угодно Delphi, а не там, где хотите вы, возможен следующий вариант:
создать эксперт в стиле add-in, что исключает автоматическое создание
пункта меню, а пункт меню добавить "вручную", используя средства Tool
Interface. Это позволит задать местоположение нового пункта в главном
меню произвольным образом.

Для добавления пункта меню используется класс
TIToolServices - основа Tool Interface - и классы TIMainMenuIntf,
TIMenuItemIntf, реализующие интерфейсы к главному меню IDE и его
пунктам. Экземпляр ToolServices класса TIToolServices создается самой
IDE при ее инициализации. Обратите внимание на то, что ответственность
за освобождение интерфейсов к главному меню Delphi и его пунктам целиком
ложится на разработчика. Попутно немного усложним функциональную
нагрузку эксперта: при активизации своего пункта меню он будет выдавать
справку об имени проекта, открытого в данный момент в среде:

    unit exmpl_02;
     
    { ADD-IN EXPERT, ДОБАВЛЕНИЕ ПУНКТА В ГЛАВНОЕ МЕНЮ IDE DELPHI }
    interface
     
    uses
      Classes, Dialogs, ToolIntF, ExptIntf, Menus;
     
    type
      { класс эксперта является потомком базового класса TIExpert }
      TEMyExpert = class( TIExpert)
      private
        MenuItem: TIMenuItemIntf;
      public
        constructor Create;
        destructor Destroy; override;
        function GetName: string; override;
        function GetStyle: TExpertStyle; override;
        function GetIDString: string; override;
        procedure MenuItemClick( Sender: TIMenuItemIntf);
    end;
     
    procedure register;
     
    function AddIDEMenuItem( const Caption, name, PreviousItemName: string;
    const ShortCutKey: Char; OnClick: TIMenuClickEvent): TIMenuItemIntf;
     
    implementation
     
    { добавляем пункт в главное меню IDE Delphi: }
    { 1) текст вставляемого пункта меню - 'Simple Expert 2'; }
    { 2) идентификатор вставляемого пункта меню - 'ViewMyExpertItem2'; }
    { 3) идентификатор пункта меню, перед которым добавляется новый }
    { пункт меню - 'ViewWatchItem' (для Delphi 5 - 'ViewWatchesItem');}
    { 4) горячая клавиша вставляемого пункта - 'Ctrl + 2'; }
    { 5) обработчик события, соответствующего выбору вставляемого пункта }
    { меню - MenuItemClick }
    constructor TEMyExpert.Create;
    begin
      inherited Create;
      MenuItem:= AddIDEMenuItem( 'Simple Expert 2', 'ViewMyExpertItem2',
      {$IFDEF VER130}
      'ViewWatchesItem', '2', MenuItemClick);
      {$ELSE}
      'ViewWatchItem', '2', MenuItemClick);
      {$ENDIF}
    end;
     
    destructor TEMyExpert.Destroy;
    begin
      if Assigned( MenuItem) then
        MenuItem.Free;
      inherited Destroy;
    end;
     
    { при выборе пункта меню эксперта отображаем сообщение, содержащее }
    { имя активного проекта }
    procedure TEMyExpert.MenuItemClick( Sender: TIMenuItemIntf);
    begin
      MessageDlg( 'Current project name is ' + ToolServices.GetProjectName,
      mtInformation, [mbOK], 0);
    end;
     
    { возвращаем имя эксперта }
    function TEMyExpert.GetName: string;
    begin
      Result := 'My Simple Expert 2';
    end;
     
    { возвращаем стиль эксперта }
    function TEMyExpert.GetStyle: TExpertStyle;
    begin
      Result := esAddIn;
    end;
     
    { возвращаем строку - идентификатор эксперта }
    function TEMyExpert.GetIDString: string;
    begin
      Result := 'Doomy.SimpleAddInExpert_2';
    end;
     
     
    function AddIDEMenuItem( const Caption, name, PreviousItemName: string;
    const ShortCutKey: Char; OnClick: TIMenuClickEvent): TIMenuItemIntf;
    var
      MainMenu: TIMainMenuIntf;
      MenuItems, PreviousItem, ParentItem: TIMenuItemIntf;
    begin
      Result:= nil;
      { получаем интерфейс пунктов главного меню IDE }
      MainMenu:= ToolServices.GetMainMenu;
      if Assigned( MainMenu) then
        try
          { получаем интерфейс пунктов верхнего уровня меню }
          MenuItems:= MainMenu.GetMenuItems;
          if Assigned( MenuItems) then
            try
              { ищем пункт меню перед которым необходимо вставить новый пункт }
              PreviousItem:= MainMenu.FindMenuItem( PreviousItemName);
              if Assigned( PreviousItem) then
                try
                  { получаем интерфейс к родительскому пункту меню }
                  ParentItem:= PreviousItem.GetParent;
                  if Assigned( ParentItem) then
                    try
                      { вставляем новый пункт меню и в качестве результата функции }
                      { возвращаем его интерфейс }
                      Result:= ParentItem.InsertItem( PreviousItem.GetIndex, Caption,
                      name, '', ShortCut( Word( ShortCutKey), [ssCtrl]), 0, 0,
                      [mfVisible, mfEnabled], OnClick);
                    finally
                      { освобождаем интерфейс родительского пункта меню }
                      ParentItem.Free;
                    end;
                finally
                  { освобождаем интерфейс пункта меню перед которым вставили }
                  { новый пункт }
                  PreviousItem.Free;
                end;
            finally
              { освобождаем интерфейс пунктов верхнего уровня меню }
              MenuItems.Free;
            end;
        finally
          { освобождаем интерфейс главного меню IDE }
          MainMenu.Free;
        end;
    end;
     
    procedure register;
    begin
      { регистрируем эксперт }
      RegisterLibraryExpert( TEMyExpert.Create);
    end;
     
    end.

В этом примере центральное место занимает функция AddIDEMenuItem,
осуществляющая добавление пункта меню в главное меню IDE Delphi. В
качестве параметров ей передаются текст нового пункта меню, его
идентификатор, идентификатор пункта, перед которым вставляется новый
пункт, символьное представление клавиши, которая вместе с клавишей Ctrl
может использоваться для быстрого доступа к новому пункту, и обработчик
события, соответствующего выбору нового пункта. Мы добавили новый пункт
меню в раздел View перед пунктом Watches.

Теперь познакомимся с нотификаторами. Определим add-in нотификатор,
отслеживающий моменты закрытия/открытия проектов и корректирующий
соответствующим образом поле, хранящее имя активного проекта (реализацию
методов, не претерпевших изменений по сравнению с предыдущим примером,
для краткости опустим):

    unit exmpl_03;
     
    { ИСПОЛЬЗОВАНИЕ ADD-IN НОТИФИКАТОРОВ }
    interface
     
    uses
      Classes, Dialogs, ToolIntF, ExptIntf, Menus;
     
    type
      TEMyExpert = class;
     
      { касс add-in нотификатора порождаем от TIAddInNotifier}
      TAddInNotifier = class(TIAddInNotifier)
      private
        Expert: TEMyExpert;
      public
        constructor Create( anExpert: TEMyExpert);
        procedure FileNotification( NotifyCode: TFileNotification;
        const FileName: string; var Cancel: Boolean); override;
    end;
     
      { класс эксперта является потомком базового класса TIExpert }
      TEMyExpert = class( TIExpert)
      private
        ProjectName: string;
        MenuItem: TIMenuItemIntf;
        AddInNotifier: TAddInNotifier;
      public
        constructor Create;
        destructor Destroy; override;
        function GetName: string; override;
        function GetStyle: TExpertStyle; override;
        function GetIDString: string; override;
        procedure MenuItemClick( Sender: TIMenuItemIntf);
    end;
     
    procedure register;
     
    function AddIDEMenuItem( const Caption, name, PreviousItemName: string;
    const ShortCutKey: Char; OnClick: TIMenuClickEvent): TIMenuItemIntf;
     
    implementation
     
    constructor TAddInNotifier.Create;
    begin
      inherited Create;
      Expert := anExpert;
    end;
     
    procedure TAddInNotifier.FileNotification( NotifyCode: TFileNotification;
    const FileName: string; var Cancel: Boolean);
    begin
      with Expert do
        case NotifyCode of
          fnProjectOpened:
            ProjectName:= FileName; { открытие проекта }
          fnProjectClosing:
            ProjectName:= 'unknown' { закрытие проекта }
        end;
    end;
     
    constructor TEMyExpert.Create;
    begin
      inherited Create;
      { добавляем пункт в главное меню IDE Delphi }
      MenuItem:= AddIDEMenuItem( 'Simple Expert 3', 'ViewMyExpertItem3',
      {$IFDEF VER130}
      'ViewWatchesItem', '3', MenuItemClick);
      {$ELSE}
      'ViewWatchItem', '3', MenuItemClick);
      {$ENDIF}
      try
        { создаем add-in нотификатор }
        AddInNotifier:= TAddInNotifier.Create( Self);
        { регистрируем add-in нотификатор }
        ToolServices.AddNotifier( AddInNotifier);
      except
        AddInNotifier:= nil;
      end;
      { инициализируем поле, хранящее имя активного проекта }
      ProjectName:= ToolServices.GetProjectName;
    end;
     
    destructor TEMyExpert.Destroy;
    begin
      if Assigned( MenuItem) then
        MenuItem.Free;
      if Assigned( AddInNotifier) then
      begin
        { снимаем регистрацию add-in нотификатора }
        ToolServices.RemoveNotifier( AddInNotifier);
        { уничтожаем add-in нотификатор }
        AddInNotifier.Free;
      end;
      inherited Destroy;
    end;
     
    { при выборе пункта меню эксперта отображаем сообщение, содержащее }
    { имя активного проекта }
    procedure TEMyExpert.MenuItemClick( Sender: TIMenuItemIntf);
    begin
      MessageDlg( 'Current project name is ' + ProjectName,
      mtInformation, [mbOK], 0);
    end;
     
    ...
     
    end.

Для реализации нотификатора мы определили класс TAddInNotifier,
являющийся потомком TIAddInNotifier, и перекрыли метод FileNotification.
IDE будет вызывать этот метод каждый раз, когда происходит событие, на
которое способен среагировать add-in нотификатор (каждое такое событие
обозначается соответствующей константой типа TFileNotification). Поле
Expert в классе TAddInNotifier служит для обратной связи с экспертом
(метод TAddInNotifier.FileNotification). В деструкторе эксперта
регистрация нотификатора снимается, и нотификатор уничтожается.

А теперь проиллюстрируем использование модульных нотификаторов. Создадим
add-in эксперт, выдающий сообщения о каждом акте сохранения проектного
файла (реализацию уже знакомых нам методов для краткости не приводим):

    unit exmpl_04;
     
    { ИСПОЛЬЗОВАНИЕ МОДУЛЬНЫХ НОТИФИКАТОРОВ }
     
    interface
     
    uses
      Classes, Dialogs, ToolIntF, ExptIntf, Menus
      {$IFDEF VER130}, EditIntf{$ENDIF};
     
    type
      { класс модульного нотификатора порождаем от TIModuleNotifier }
      TModuleNotifier = class( TIModuleNotifier)
      private
        FileName: string;
      public
        constructor Create(const aFileName: string);
        procedure Notify( NotifyCode: TNotifyCode); override;
        {$IFDEF VER130}
        procedure ComponentRenamed(ComponentHandle: Pointer;
        const OldName, NewName: string); override;
        {$ELSE}
        procedure ComponentRenamed( const oldName, newName: string); override;
        {$ENDIF}
    end;
     
      TEMyExpert = class;
     
      { класс add-in нотификатора порождаем от TIAddInNotifier}
      TAddInNotifier = class(TIAddInNotifier)
      private
        Expert: TEMyExpert;
      public
        constructor Create( anExpert: TEMyExpert);
        procedure FileNotification( NotifyCode: TFileNotification;
        const FileName: string; var Cancel: Boolean); override;
    end;
     
      { класс эксперта является потомком базового класса TIExpert }
      TEMyExpert = class( TIExpert)
      private
        AddInNotifier: TAddInNotifier;
        ModuleInterface: TIModuleInterface;
        ModuleNotifier: TModuleNotifier;
      public
        constructor Create;
        destructor Destroy; override;
        function GetName: string; override;
        function GetStyle: TExpertStyle; override;
        function GetIDString: string; override;
        procedure AddModuleNotifier( const FileName: string);
        procedure RemoveModuleNotifier;
    end;
     
    procedure register;
     
    implementation
     
    constructor TModuleNotifier.Create(const aFileName: string);
    begin
      inherited Create;
      FileName := aFileName;
    end;
     
    procedure TModuleNotifier.Notify( NotifyCode: TNotifyCode);
    begin
      { если произошло сохранение соответствующего нотификатору файла, }
      { то выдаем сообщение об этом }
      if NotifyCode = ncAfterSave then
        MessageDlg(FileName + 'saved', mtInformation, [mbOK], 0);
    end;
     
    procedure TModuleNotifier.ComponentRenamed;
    begin
      { ничего здесь не делаем, но метод необходимо перекрыть }
    end;
     
    procedure TAddInNotifier.FileNotification( NotifyCode: TFileNotification;
    const FileName: string; var Cancel: Boolean);
    begin
      with Expert do
        case NotifyCode of
          fnProjectOpened: { открытие проекта }
            { добавляем модульный нотификатор }
            AddModuleNotifier( FileName);
          fnProjectClosing: { закрытие проекта }
            { освобождаем модульный нотификатор }
            RemoveModuleNotifier;
        end;
    end;
     
    constructor TEMyExpert.Create;
    begin
      inherited Create;
      try
        { создаем add-in нотификатор }
        AddInNotifier:= TAddInNotifier.Create( Self);
        { регистрируем add-in нотификатор }
        ToolServices.AddNotifier( AddInNotifier);
      except
        AddInNotifier:= nil;
      end;
      { добавляем модульный нотификатор }
      AddModuleNotifier( ToolServices.GetProjectName);
    end;
     
    destructor TEMyExpert.Destroy;
    begin
      if Assigned( AddInNotifier) then
      begin
        { снимаем регистрацию add-in нотификатора }
        ToolServices.RemoveNotifier( AddInNotifier);
        { уничтожаем add-in нотификатор }
        AddInNotifier.Free;
      end;
      { освобождаем модульный нотификатор }
      RemoveModuleNotifier;
      inherited Destroy;
    end;
     
    procedure TEMyExpert.AddModuleNotifier;
    begin
      { если модульный нотификатор для проектного файла уже зарегистрирован, }
      { то никаких действий не выполняем, во избежание появления дубликатов }
      { нотификаторов; в противном случае дубликаты могли бы появиться, }
      { например, при открытии Delphi: один нотификатор добавился бы при }
      { создании эксперта (в конструкторе класса эксперта), а второй - при }
      { открытии проекта (в TAddNotifier.FileNotification }
      if Assigned( ModuleInterface) and Assigned( ModuleNotifier) then
        Exit;
      try
        { получаем интерфейс модуля }
        ModuleInterface:= ToolServices.GetModuleInterface( FileName);
        try
          { создаем модульный нотификатор }
          ModuleNotifier:= TModuleNotifier.Create( FileName);
          { регистрируем модульный нотификатор }
          ModuleInterface.AddNotifier( ModuleNotifier);
        except
          ModuleNotifier:= nil;
        end;
      except
        ModuleInterface:= nil;
      end;
    end;
     
    procedure TEMyExpert.RemoveModuleNotifier;
    begin
      if Assigned(ModuleNotifier) then
      begin
        if Assigned( ModuleInterface) then
          { снимаем регистрацию модульного нотификатора }
          ModuleInterface.RemoveNotifier( ModuleNotifier);
        { уничтожаем модульный нотификатор }
        ModuleNotifier.Free;
        ModuleNotifier:= nil;
      end;
      if Assigned( ModuleInterface) then
      begin
        { освобождаем модульный интерфейс }
        ModuleInterface.Free;
        ModuleInterface:= nil;
      end;
    end;
     
    ...
     
    end.

В данном примере add-in эксперт отслеживает события, соответствующие
открытию/закрытию проектов. При каждом открытии проекта регистрируется
модульный нотификатор, соответствующий файлу проекта. В плане реализации
модульные нотификаторы схожи с add-in нотификаторами: мы определяем
класс TModuleNotifier, являющийся потомком TIModuleNotifier и
перекрываем его методы Notify и ComponentRenamed. IDE вызывает метод
Notify при возникновении определенных событий, имеющих отношение к
данному модулю; внутри этого метода и определяется реакция на то или
иное событие.

Метод ComponentRenamed вызывается при изменении имени
компонента, лежащего на форме модуля. Обратите внимание на то, что мы не
используем этот метод, но обязаны его перекрыть, иначе при изменении
имени компонента будет происходить вызов абстрактного метода базового
класса, что приводит к непредсказуемым последствиям. Регистрация
модульного нотификатора является несколько более сложным процессом по
сравнению с регистрацией add-in нотификатора: сначала мы получаем
интерфейс модуля (TIModuleInterface), а затем с помощью интерфейса
модуля регистрируем нотификатор. При закрытии проекта регистрация
модульного нотификатора снимается (снова с использованием
TIModuleInterface), и нотификатор уничтожается.

В заключение покажем, как можно определять позицию курсора в окне
редактора кода. Создадим эксперт, который при выборе соответствующего
пункта меню выдавал бы сообщение, содержащее имя активного файла и
позицию курсора в нем (приведена реализация только существенных для
данного примера методов):

    unit exmpl_05;
     
    { ОПРЕДЕЛЕНИЕ ПОЗИЦИИ КУРСОРА }
    interface
     
    uses
      SysUtils, Classes, Dialogs, ToolIntF, ExptIntf, EditIntf, Menus;
     
    type
      { класс эксперта является потомком базового класса TIExpert }
      TEMyExpert = class( TIExpert)
      private
        MenuItem: TIMenuItemIntf;
      public
        constructor Create;
        destructor Destroy; override;
        function GetName: string; override;
        function GetStyle: TExpertStyle; override;
        function GetIDString: string; override;
        procedure MenuItemClick( Sender: TIMenuItemIntf);
        function GetCursorPos: TEditPos;
    end;
     
    procedure register;
     
    function AddIDEMenuItem( const Caption, name, PreviousItemName: string;
    const ShortCutKey: Char; OnClick: TIMenuClickEvent): TIMenuItemIntf;
     
    implementation
     
    { при выборе пункта меню эксперта отображаем сообщение, содержащее }
    { имя активного проекта }
    procedure TEMyExpert.MenuItemClick( Sender: TIMenuItemIntf);
    var
      CurPos: TEditPos;
    begin
      CurPos:= GetCursorPos;
      if CurPos.Line > 0 then
        MessageDlg( 'Current file: ' + ToolServices.GetCurrentFile + #13 +
        'Current cursor position: ' + IntToStr( CurPos.Line) +
        ', ' + IntToStr( CurPos.Col), mtInformation, [mbOK], 0);
    end;
     
    function TEMyExpert.GetCursorPos: TEditPos;
    var
      ModuleInterface: TIModuleInterface;
      EditorInterface: TIEditorInterface;
      EditView: TIEditView;
      FileName: string;
    begin
      { определяем имя активного файла }
      FileName:= ToolServices.GetCurrentFile;
      Result.Line:= 0;
      Result.Col:= 0;
      { для простоты определяем позицию только в pas-файлах }
      if ExtractFileExt( FileName) = '.pas' then
      begin
        { получаем интерфейс модуля }
        ModuleInterface:= ToolServices.GetModuleInterface( FileName);
        try
          { получаем интерфейс редактора кода }
          EditorInterface:= ModuleInterface.GetEditorInterface;
          try
            { получаем интерфейс представления модуля в редакторе }
            { передавая методу GetView индекс нужного нам представления; }
            { если файл открыт в нескольких окнах редактора кода, то для }
            { простоты берем первое (хотя конечно, это не совсем }
            { правильно }
            EditView:= EditorInterface.GetView( 0);
            try
              Result:= EditView.CursorPos;
            finally
              EditView.Free;
            end;
          finally
            EditorInterface.Free;
          end;
        finally
          ModuleInterface.Free;
        end;
      end;
    end;
     
    ...

Для определения позиции курсора мы должны получить следующую
последовательность интерфейсов:

- модульный интерфейс (TIModuleInterface);
- интерфейс редактора кода (TIEditorInterface);
- интерфейс представления модуля в окне редактора (TIEditView).

Если при выборе пункта меню эксперта активным является файл с исходным
текстом (*.pas), то выдается сообщение, содержащее имя активного файла
и текущую позицию курсора в нем. Если активным является не pas-файл, то
сообщение не выдается.

Для получения имени активного файла используется метод GetCurrentFile
класса TIToolServices.

Итак, в данной статье в общих чертах рассмотрены открытые интерфейсы и
приведены примеры их использования. Еще раз повторим: благодаря наличию
исходных текстов открытых интерфейсов вы без труда сможете разобраться в
интересующих вас деталях. Надеемся, что многообразие возможностей,
предоставляемых открытыми интерфейсами, породит у вас не одну смелую и
полезную идею.

