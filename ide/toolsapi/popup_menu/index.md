---
Title: Создание pop-up меню своего компонента и кое-что еще о классе TComponentExpert
Author: Раструсный Владислав Юрьевич
Date: 01.01.2007
Source: <https://www.delphimaster.ru/>
---


Создание pop-up меню своего компонента и кое-что еще о классе TComponentExpert
==============================================================================

Давайте рассмотрим создание простейшего одно уровневого контекстного
меню на своем компоненте, которое будет открываться при щелчке правой
кнопкой по нему в самом верху контекстного меню Delphi.

Прежде всего вам следует разделить код вашего компонента на Design-time
и Run-time. Для этого перенесите ваш компонент в модуль, с названием,
например, MyComponent.pas, а процедуры регистрации его в палитре
компонентов (procedure Register и т.д.) в модуль, с названием, например,
MyComponentReg. На такие меры приходится идти из-за того, что Borland не
включила в исходные коды исходник файла Proxies.pas.

Итак, получим два файла:

MyComponent.pas:

    unit MyComponent;
     
    interface
     
    uses
      SysUtils, Classes;
     
    type
      TMyComponent = class(TComponent)
      private
        { Private declarations }
      protected
        { Protected declarations }
      public
        { Public declarations }
      published
        { Published declarations }
      end;

MyComponentReg.pas

    unit MyComponentReg;
     
    interface
    uses DesignIntf, DesignEditors, MyComponent, Classes, Dialogs;
     
    type
       TMyComponentEditor = class(TComponentEditor)
       private
          procedure ExecuteVerb(Index: Integer); override;
          function GetVerbCount: Integer; override;
          function GetVerb(Index: Integer): string; override;
          procedure Edit; override;
       end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
       RegisterComponents('Samples', [TMyComponent]);
       RegisterComponentEditor(TMyComponent, TMyComponentEditor);
    end;
     
    { TMyComponentEditor }
     
    procedure TMyComponentEditor.Edit;
    begin
      ShowMessage('TMyComponent component v1.0 by Rastrusny Vladislav');
    end;
     
    procedure TMyComponentEditor.ExecuteVerb(Index: Integer);
    begin
       inherited;
       case Index of
          0: //Действие при выборе первого определенного пункта меню
       end;
    end;
     
    function TMyComponentEditor.GetVerb(Index: Integer): string;
    begin
       case Index of
          0: Result := 'Demo Menu Item 1'; //Название первого пункта меню 
       end;
    end;
     
    function TMyComponentEditor.GetVerbCount: Integer;
    begin
       Result := 1;
    end;
     
    end.

Рассмотрим теперь, что же тут написано. В первом файле просто определен
компонент MyComponent. В нем вы определяете все свойства и методы вашего
компонента. Все как обычно. Теперь - второй файл MyComponentReg. Он
содержит процедуры регистрации компонента и процедуру регистрации
редактора компонента (TComponentEditor). Этот редактор и будет
отображать меню и прочие безобразия. Итак:

Определяем TMyComponentEditor как потомка TComponentEditor. Сам по себе
этот класс является "воплотителем" интерфейса IComponentEditor, хотя
нам все равно. Для того, чтобы все это заработало нам нужно будет
переопределить стандартные методы класса TComponentEditor. Рассмотрим
его:

    type
      TComponentEditor = class(TBaseComponentEditor, IComponentEditor)
      private
        FComponent: TComponent;
        FDesigner: IDesigner;
      public
        constructor Create(AComponent: TComponent; ADesigner: IDesigner); override;
        procedure Edit; virtual;
        function GetVerbCount: Integer; virtual;
        function GetVerb(Index: Integer): string; virtual;
        procedure ExecuteVerb(Index: Integer); virtual;
        procedure Copy; virtual;
        procedure PrepareItem(Index: Integer; const AItem: IMenuItem); virtual;
        property Component: TComponent;
        property Designer: IDesigner;
      end;

Конструктор нам переопределять не нужно. Поэтому начнем с описания
метода Edit.

Метод Edit
: вызывается при двойном щелчке по компоненту. Вот так просто!
При двойном щелчке на компоненте! Если метод не определен, то при
двойном щелчке будет выполнен первый пункт меню, которое вы определили.

Метод GetVerbCount
: Integer должен возвращать количество определенных
вами пунктов меню.

Метод GetVerb(Index: Integer): string
: должен возвращать название пункта меню № Index.

Метод ExecuteVerb(Index: Integer)
: вызывается при щелчке на пункте меню,
определенном вами. Index - номер меню из метода GetVerb. В нем вы
определяете действия, которые будут происходить при нажатии на ваш пункт
меню.

Метод Copy
: вызывается при копировании вашего компонента в буфер обмена

Свойство Component
: как вы уже наверное догадались позволяет получить
доступ к компоненту, на котором щелкнули мышью и т.п.

Метод PrepareItem(Index: Integer; const AItem: IMenuItem)
: вызывается для
каждого определенного вами пункта меню № Index и через параметр AItem
передает сам пункт меню для настройки. Для работы нам нужно будет
рассмотреть саму реализацию интерфейса IMenuItem. Он определен в модуле
DesignMenus.pas и является потомком интерфейса IMenuItems.

```delphi
IMenuItems = interface
  ['{C9CC6C38-C96A-4514-8D6F-1D121727BFAF}']
 
  // public
  function SameAs(const AItem: IUnknown): Boolean;
  function Find(const ACaption: WideString): IMenuItem;
  function FindByName(const AName: string): IMenuItem;
  function Count: Integer;
  property Items[Index: Integer]: IMenuItem read GetItem;
  procedure Clear;

  function AddItem(const ACaption: WideString; AShortCut: TShortCut;
    AChecked, AEnabled: Boolean; AOnClick: TNotifyEvent = nil;
    hCtx: THelpContext = 0; const AName: string = ''): IMenuItem; overload;

  function AddItem(AAction: TBasicAction;
    const AName: string = ''): IMenuItem; overload;

  function InsertItem(const ACaption: WideString;
    AShortCut: TShortCut; AChecked, AEnabled: Boolean; AOnClick: TNotifyEvent = nil;
    hCtx: THelpContext = 0; const AName: string = ''): IMenuItem; overload;
  function InsertItem(Index: Integer; const ACaption: WideString;
    AShortCut: TShortCut; AChecked, AEnabled: Boolean; AOnClick: TNotifyEvent = nil;
    hCtx: THelpContext = 0; const AName: string = ''): IMenuItem; overload;

  function InsertItem(AAction: TBasicAction;
    const AName: string = ''): IMenuItem; overload;
  function InsertItem(Index: Integer; AAction: TBasicAction;
    const AName: string = ''): IMenuItem; overload;

  function AddLine(const AName: string = ''): IMenuItem;

  function InsertLine(const AName: string = ''): IMenuItem; overload;
  function InsertLine(Index: Integer; const AName: string = ''): IMenuItem; overload;
end;
 
 
IMenuItem = interface(IMenuItems)
  ['{DAF029E1-9592-4B07-A450-A10056A2B9B5}']

  // public
  function Name: TComponentName;
  function MenuIndex: Integer;
  function Parent: IMenuItem;
  function HasParent: Boolean;
  function IsLine: Boolean;

  property Caption: WideString;
  property Checked: Boolean;
  property Enabled: Boolean;
  property GroupIndex: Byte;
  property HelpContext: THelpContext;
  property Hint: string;
  property RadioItem: Boolean;
  property ShortCut: TShortCut;
  property Tag: LongInt;
  property Visible: Boolean;
end;
```

Начнем с конца. Т.е. с IMenuItem. Как видно, почти все члены интерфейса
соответствуют членам класса TMenuItem. Т.е. обратившись в методе
PrepareItem к AItem.Enabled:=false мы запретим выбор этого элемента
меню. Что же касается класса TMenuItems, то они, видимо, предназначены
для манипулирования элементом меню в качестве родительского для
нескольких других. Думаю, в них опытным путем разобраться тоже не
составит труда.

Что же касается процедуры RegisterComponentEditor, то она принимает два
параметра: первый - класс компонента, для которого создается редактор
свойств и второй - собственно сам класс редактора свойств.

**Создание редакторов свойств**

Для создания редактора свойств нужно написать класс, унаследованный от
TBasePropertyEditor. Но мы рассмотрим более функционального его потомка
TPropertyEditor

    TPropertyEditor = class(TBasePropertyEditor, IProperty, IProperty70)
    protected
      procedure SetPropEntry(Index: Integer; AInstance: TPersistent;
        APropInfo: PPropInfo); override;
    protected
      function GetFloatValue: Extended;
      function GetFloatValueAt(Index: Integer): Extended;
      function GetInt64Value: Int64;
      function GetInt64ValueAt(Index: Integer): Int64;
      function GetMethodValue: TMethod;
      function GetMethodValueAt(Index: Integer): TMethod;
      function GetOrdValue: Longint;
      function GetOrdValueAt(Index: Integer): Longint;
      function GetStrValue: string;
      function GetStrValueAt(Index: Integer): string;
      function GetVarValue: Variant;
      function GetVarValueAt(Index: Integer): Variant;
      function GetIntfValue: IInterface;
      function GetIntfValueAt(Index: Integer): IInterface;
      procedure Modified;
      procedure SetFloatValue(Value: Extended);
      procedure SetMethodValue(const Value: TMethod);
      procedure SetInt64Value(Value: Int64);
      procedure SetOrdValue(Value: Longint);
      procedure SetStrValue(const Value: string);
      procedure SetVarValue(const Value: Variant);
      procedure SetIntfValue(const Value: IInterface);
    protected
      { IProperty }
      function GetEditValue(out Value: string): Boolean;
      function HasInstance(Instance: TPersistent): Boolean;
      { IProperty70 } 
      function GetIsDefault: Boolean; virtual;
    public
      constructor Create(const ADesigner: IDesigner; APropCount: Integer); override;
      destructor Destroy; override;
      procedure Activate; virtual;
      function AllEqual: Boolean; virtual;
      function AutoFill: Boolean; virtual;
      procedure Edit; virtual;
      function GetAttributes: TpropertyAttributes; virtual;
      function GetComponent(Index: Integer): TPersistent;
      function GetEditLimit: Integer; virtual;
      function GetName: string; virtual;
      procedure GetProperties(Proc: TGetPropProc); virtual;
      function GetPropInfo: PPropInfo; virtual;
      function GetPropType: PTypeInfo;
      function GetValue: string; virtual;
      function GetVisualValue: string;
      procedure GetValues(Proc: TGetStrProc); virtual;
      procedure Initialize; override;
      procedure Revert;
      procedure SetValue(const Value: string); virtual;
      function ValueAvailable: Boolean;
      property Designer: IDesigner read FDesigner;
      property PrivateDirectory: string read GetPrivateDirectory;
      property PropCount: Integer read FPropCount;
      property Value: string read GetValue write SetValue;
    end;

Предположим, нам нужно создать редактор для текстового свойства, при
нажатии кнопки "..." в Object Inspector.

Объявим специальный тип этого свойства

    TMyComponentStringProperty = string;

Далее, в компоненте укажем свойство данного типа property MyProperty:
TMyComponentStringProperty, далее в Run-time части компонента
(MyComponentReg.pas) объявим класс TMyCSPEditor (в переводе:
TMyComponentStringPropertyEditor), унаследовав его от класса
TStringProperty, который в свою очередь является потомком
рассматриваемого класса TPropertyEditor: type TMyCSPEditor =
class(TStringProperty) . Переопределим в нем несколько методов таким
образом (фрагменты файла):

    type
       TVRSIDBListViewExcludeColumnsPropertyEditor = class(TStringProperty)
          function GetAttributes: TPropertyAttributes; override;
          procedure Edit; override;
       end;
     
     
    procedure TVRSIDBListViewExcludeColumnsPropertyEditor.Edit;
    var Text: string;
    begin
       if InputQuery('Введите строковое значение',Text)=False then Exit;
       Self.SetValue(Text);
    end;
     
    function TVRSIDBListViewExcludeColumnsPropertyEditor.GetAttributes: TPropertyAttributes;
    begin
       Result:=[paDialog];
    end;

Итак, приступаем к рассмотрению методов класса TPropertyEditor. Начнем с
тех, которые мы уже использовали.

Метод Edit
: Просто вызывается при щелчке на кнопке "..." в Object
Inspector. В TStringProperty не переопределен.

Метод SetValue(Text: string)
: Должен устанавливать значение свойства в
переданную строку. В TStringProperty переопределен. Этот метод
вызывается самим Object Inspector, когда пользователь вводит значение
поля. Вы можете переопределить этот метод для установки вашего свойства
в зависимости от значения, введенного пользователем. Если вы
обнаруживаете ошибку в переданном параметре - вызовите исключение.

Метод GetAttributes: TPropertyAttributes
: Задает параметры свойства.
Рассмотрим их по порядку.

- paValueList - указывает, что редактор свойств возвращает список
допустимых значений свойства через метод GetValues. В редакторе свойств
рядом со свойством появляется раскрывающийся список

- paSortList - указывает, что список, возвращенный GetValues нужно
сортировать

- paSubProperties - указывает, что у свойства имеются подсвойства (типа
подсвойства Name у свойства Font класса TFont). Подсвойства, если этот
флаг установлен, должны возвращаться методом GetProperties.

- paDialog - указывает, что рядом со свойством должна быть кнопка "...",
по нажатию которой вызывается метод Edit для редактирования значения
свойства. Что мы и указали в нашем примере.

- paMultiSelect - Разрешает отображать свойство в Object Inspector, даже
если выделено более одного объекта

- paAutoUpdate - указывает, что метод SetValue нужно вызывать при каждом
изменении значения свойства, а не после нажатия Enter или выхода из
Object Inspector (Пример: свойство Caption у формы изменяется
одновременно с набором на клавиатуре)

- paReadOnly - указывает, что значение через Object Inspector изменить
нельзя. Оно устанавливается в классе TClassProperty, от которого
унаследованы все классовые редакторы свойств типа TStrings, TFont и т.п.
При установке рядом со значением свойства отображается строка,
возвращенная методом GetValue и значение это изменить нельзя.

- paRevertable - указывает, изменение значения свойства можно отменить.
Это не касается вложенных подсвойств.

- paFullWidthName - указывает Object Inspector, что прорисовка значения
свойства не требуется и можно занять под имя свойства всю длину панели.

- paVolatileSubProperties - установка этого значения указывает, что при
любом изменении свойства нужно повторить сборку подсвойств
(GetProperties)

- paVCL - ???

- paReference - указывает, что свойство является указателем на что-либо.
Используется вместе с paSubProperties для указания отображения объекта,
на которое ссылается в качестве подсвойств (TFont).

- paNotNestable - указывает, что отображать значение свойства в момент,
когда его подсвойства развернуты - небезопасно (этот пункт мне пока
непонятен)

Методы GetXXXValue и SetXXXValue
: Используются для внутренней установки
реального значения свойства. Как правило, используются методом GetValue
и SetValue. В принципе, все эти методы уже определены в классе
TPropertyEditor, и переопределять их не нужно.

Метод Modified
: вызывается для указания того факта, что значение свойства
изменено. Это метод уже определен в TPropertyEditor и переопределять его
не требуется.

Метод GetEditValue
: возвращает true, если значение можно редактировать

Метод GetIsDefault
: возвращает true, если значение свойства в текущий
момент является значением свойства по умолчанию. Т.е. метод должен
возвращать true, если НЕ нужно сохранять значение свойства в .dfm файле.

Метод Activate
: вызывается при выборе свойства в Object Inspector. При
использовании переопределения этого метода для отображения значения
свойства исключительно в момент активизации нужно быть осторожным, если
указаны параметры свойства paSubProperties и paMultiSelect.

Метод AllEqual
: вызывается всякий раз, когда выделяется более одного
компонента. Если этот метод вернет true, будет вызван метод GetValue, в
противоположном случае будет отображена пустая строка. Вызывается
только, если указано свойство paMultiSelect. Очевидно, метод должен
проверять совпадение свойств у все выбранных компонентов путем опроса
метода GetComponent.

Метод AutoFill
: вызывается для определения, могут ли элементы списка быть
выбраны по возрастанию. Указывается, только если указан параметр
paValueList.

Метод GetComponent
: возвращает компонент с заданным индексом из выбранных
компонентов.

Метод GetEditLimit
: возвращает максимальное количество символов, которые
можно ввести в текстовое значение свойства. По умолчанию 255.

Метод GetName
: возвращает имя свойства, в котором знаки подчеркивания
заменены на пробелы. Свойство метод должен переопределяться только, если
свойство не предназначено для отображения в Object Inspector

Метод GetComponentValue
: возвращает значение свойства типа TComponent в
том и только в том случае, если свойство унаследовано от TComponent.
Этот метод переопределяется в классе TComponentEditor

Метод GetProperties
: вызывается для каждого подсвойства, которое
редактируется. В метод передается параметр типа TGetPropertyProc. Это
указатель на процедуру для обработки каждого свойства. Например,
TClassProperty вызывает процедуру TGetPropertyProc для каждого published
элемента класса, а TSetProperty - для каждого элемента множества. Т.е.
при использовании подсвойств вы должны определить процедуру
TGetPropertyProc, чтобы она определяла каждое подсвойство.

Метод GetPropType
: возвращает указатель на информацию о типе
редактируемого свойства (TypeInfo (Type))

Метод GetValue
: возвращает значение свойства в виде текстовой строки.
Например, в TClassProperty этот метод переопределен для возвращения в
качестве результата имени типа класса (TStrings и т.п.).

Метод ValueAvailable
: возвращает true, если можно получить доступ к
значению свойства, не вызывая исключения.

Описания для остальных методов и свойств, к сожалению, найти не удалось,
поэтому исследовать их можно только опытным путем.

По завершении создания редактора свойств не забудьте зарегистрировать
его внутри метода register вызовом

    RegisterPropertyEditor(TypeInfo(<тип свойства>),
                           <тип компонента>,
                           <имя свойства>,
                           <тип редактора свойства>);

    RegisterPropertyEditor(TypeInfo(TMyComponentsStringProperty),
                           TMyComponent, '', TMCSPEditor);

Передав вместо имени свойства пустую строку, мы указали тем самым, что
имя может быть любым. Так же пустую строку можно передать вместо имени
компонента.

Вот, собственно, и все. Пишите свой редактор свойств, переопределяйте
нужные методы и вперед!

**Delphi 7 ToolsAPI: Эксперты**

**Написание простейшего эксперта**

Какой же код нужно написать для создания простейшего эксперта? Для этого
нужно написать класс, унаследованный от IOTAWizard (определен в файле
ToolsAPI.pas) или одного из его потомков, расположить в модуле процедуру
Register, как мы это делали с компонентами, и вызвать внутри ее
процедуру

    RegisterPackageWizard (const Wizard: IOTAWizard);

например:

    RegisterPackageWizard (TMyExpert.Create as IOTAWizard);

передав ей в качестве параметра экземпляр заранее созданного эксперта.

Рассмотрим класс IOTAWizard.

    IOTAWizard = interface(IOTANotifier)
        ['{B75C0CE0-EEA6-11D1-9504-00608CCBF153}']
        { Expert UI strings }
        function GetIDString: string;
        function GetName: string;
        function GetState: TWizardState;
     
        { Launch the AddIn }
        procedure Execute;
      end;

Интерфейс IOTANotifier нам не понадобится, поэтому давайте рассмотрим
методы IOTAWizard: Метод GetIDString должен возвращать уникальный
идентификатор эксперта. Например: MyCompany.MyExpert

Метод GetName должен возвращать название эксперта.

Метод GetState должен возвращать [wsEnabled], если эксперт
функционирует, wsChecked если выбран.

Метод Execute вызывается при запуске эксперта из среды IDE.

Итак, если вы хотите сами программировать действия вашего эксперта,
включая добавление в меню IDE и прочее и прочее, унаследуйте его от
IOTAWizard.

Если вы хотите, чтобы ваш эксперт отображался в репозитории Delphi на
произвольной странице и по щелчку по его иконке вызывался его метод
Execute - унаследуйте его от IOTARepositoryWizard

      IOTARepositoryWizard = interface(IOTAWizard)
        ['{B75C0CE1-EEA6-11D1-9504-00608CCBF153}']
        function GetAuthor: string;
        function GetComment: string;
        function GetPage: string;
        function GetGlyph: Cardinal;
      end;

Метод GetAuthor должен возвращать имя автора,  
Метод GetComment - комментарий,  
Метод GetPage - страницу на которой будет расположена иконка эксперта,  
Метод GetGlyph - дескриптор иконки

Если вы хотите, чтобы эксперт появлялся на странице форм в репозитории -
унаследуйте его от IOTAFormWizard. Он имеет все те же методы и свойства,
что и IOTARepositoryWizard, если на странице проектов - от
IOTAProjectWizard. Он тоже аналогичен IOTARepositoryWizard.

Если же вы хотите, чтобы пункт меню для вызова метода вашего эксперта
Execute помещался в мень Help главного меню IDE, унаследуйте вашего
эксперта от IOTAMenuWizard:

      IOTAMenuWizard = interface(IOTAWizard)
        ['{B75C0CE2-EEA6-11D1-9504-00608CCBF153}']
        function GetMenuText: string;
      end;

Метод GetMenuText должен возвращать имя пункта меню для отображения, а
метод GetState возвращает стиль элемента меню (Enabled, Checked)

Вот так все просто, оказывается!

**Расположение эксперта внутри DLL библиотеки**

Если вы хотите расположить вашего эксперта не в пакете, а в DLL
библиотеке, библиотека должна экспортировать функцию INITWIZARD0001
следующего формата:

    type TWizardRegisterProc = function(const Wizard: IOTAWizard): Boolean;

    type TWizardTerminateProc = procedure;

    function INITWIZARD0001(const BorlandIDEServices: IBorlandIDEServices;
      RegisterProc: TWizardRegisterProc; var Terminate: TWizardTerminateProc):
      Boolean stdcall;

Для регистрации вашего эксперта вызовите внутри этой функции
RegisterProc и передайте ей экземпляр заранее созданного класса вашего
эксперта. BorlandIDEServices - указатель на основной интерфейс для
работы со всей IDE. Отдельные части его мы рассмотрим далее. По
окончании работы IDE или при принудительной выгрузке вашего эксперта
будет вызвана функция Terminate, которую вы должны передать среде.

Поместите полный путь к DLL в ключ реестра

    HKEY_CURRENT_USER\Software\Borland\Delphi\7.0\Experts

или

    HKEY_LOCAL_MACHINE\SOFTWARE\Borland\Delphi\7.0\Experts

Именем ключа может быть произвольная строка.

Эксперт будет запущен только при перезапуске среды, если она
выполнялась. Вуаля!


