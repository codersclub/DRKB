---
Title: Интерфейсы и published-свойства
Date: 01.01.2007
---


Интерфейсы и published-свойства
===============================

::: {.date}
01.01.2007
:::

Итак, мы уже знаем, как найти VTBL. Но в каком порядке хранятся в ней
методы ? Ответ можно получить, посмотрев на ассемблерный листинг и
сравнив его с исходным кодом VCL. И выяснится, что новые методы
дописыватся в конец VTBL, по мере произведения новых классов. Я
проследил генеалогию классов до TWinControl и вот что у меня получилось
(цифра означает смещение в VTBL):

  --- ---------
  ·   TObject
  --- ---------

Виртуальные методы этого класса расположены в VTBL по отрицательным
индексам. Смотрите моё описание RTTI в предыдущей статье

  --- -------------
  ·   TPersistent
  --- -------------

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------
  ·   0x00 AssignTo
  --- ---------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------------
  ·   0x01 DefineProperties
  --- -----------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------
  ·   0x02 Assign
  --- -------------
:::

  --- ------------
  ·   TComponent
  --- ------------

В нём, помимо всего прочего, реализуется также интерфейсы IUnknown &
IDispatch, поэтому объекты-производные от него могут быть серверами
OLE-Automation

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------
  ·   0x03 Loaded
  --- -------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------------
  ·   0x04 Notification
  --- -------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------
  ·   0x05 ReadState
  --- ----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- --------------
  ·   0x06 SetName
  --- --------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------------
  ·   0x07 UpdateRegistry
  --- ---------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------------
  ·   0x08 ValidateRename
  --- ---------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------
  ·   0x09 WriteState
  --- -----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------------
  ·   0x0A QueryInterface
  --- ---------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------------------------
  ·   0x0B Create(AOwner: TComponent)
  --- ---------------------------------
:::

  --- ----------
  ·   TControl
  --- ----------

Его производные классы могут быть помещены на форму во время
проектрирования и умеют отображать себя ( так называемые "видимые"
компоненты )

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------------
  ·   0x0C UpdateLastResize
  --- -----------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------
  ·   0x0D CanResize
  --- ----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- --------------------
  ·   0x0E CanAutoResize
  --- --------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------------
  ·   0x0F ConstrainedResize
  --- ------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------------
  ·   0x10 GetClientOrigin
  --- ----------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- --------------------
  ·   0x11 GetClientRect
  --- --------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------------
  ·   0x12 GetDeviceContext
  --- -----------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- --------------------
  ·   0x13 GetDragImages
  --- --------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------
  ·   0x14 GetEnabled
  --- -----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------
  ·   0x15 GetFloating
  --- ------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------------------------
  ·   0x16 GetFloatingDockSiteClass
  --- -------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------
  ·   0x17 SetDragMode
  --- ------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------------------------------------------------------------------------------------------------
  ·   0x18 SetEnabled - полезный метод, особенно для всяких кнопок в диалогах регистрации серийных номеров...
  --- ----------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------
  ·   0x19 SetParent
  --- ----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------------
  ·   0x1A SetParentBiDiMode
  --- ------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------
  ·   0x1B SetBiDiMode
  --- ------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   0x1C WndProc - адрес оконной процедуры. Если она не находит обработчика у себя, вызывается метод TObject::Dispatch. И уже последний метод вызывает dynamic функцию по индексу, равному номеру сообщения Windows.
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------------
  ·   0x1D InitiateAction
  --- ---------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------
  ·   0x1E Invalidate
  --- -----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------------------------------------------
  ·   0x1F Repaint - адрес функции отрисовки компонента
  --- ---------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------
  ·   0x20 SetBounds
  --- ----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------
  ·   0x21 Update
  --- -------------
:::

  --- -------------
  ·   TWinControl
  --- -------------

Его производные классы имеют собственное окно

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------------
  ·   0x22 AdjustClientRect
  --- -----------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- --------------------
  ·   0x23 AlignControls
  --- --------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------------
  ·   0x24 CreateHandle
  --- -------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------------
  ·   0x25 CreateParams
  --- -------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -------------------------
  ·   0x26 CreateWindowHandle
  --- -------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ----------------
  ·   0x27 CreateWnd
  --- ----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- --------------------------
  ·   0x28 DestroyWindowHandle
  --- --------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- -----------------
  ·   0x29 DestroyWnd
  --- -----------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------------
  ·   0x2A GetControlExtents
  --- ------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------
  ·   0x2B PaintWindow
  --- ------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ------------------
  ·   0x2C ShowControl
  --- ------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 27px;"}
  --- ---------------
  ·   0x2D SetFocus
  --- ---------------
:::

А где же хранятся методы интерфейсов, спросите Вы ? Хороший вопрос,
учитывая, что классы Delphi могут иметь только одного предка, но в то же
самое время реализовывать несколько интерфейсов. Чтобы выяснить это, я
написал ещё одну тестовую программу, на сей раз из нескольких файлов.
Unit1.pas - главная форма приложения.

    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, Project1_TLB;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    uses
     Unit2;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     My_Object: TRP_Server;
     My_Interface: IRP_Server;
    begin
     My_Object := Nil;
     My_Interface := Nil;
     Try
      My_Object := TRP_Server.Create;
      My_Interface := My_Object;
      My_Interface.RP_Prop := PChar('Строка');
      MessageDlg(Format('My Method1: %d, string is %s, refcount is %d',
         [My_Interface.Method1(1), My_Interface.RP_Prop, My_Object.RefCount]),
        mtConfirmation,[mbOk],0);
     finally
       if My_Interface <> Nil then
        My_Interface := Nil;
    { это не правильно - My_Object уже не существует здесь }
       MessageDlg(Format('refcount is %d',[My_Object.RefCount]),
        mtConfirmation,[mbOk],0);
     end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
     RP_IO: IRP_Server;
    begin
     try
      RP_IO := CoRP_Server.Create;
      RP_IO.RP_Prop := 'Yet one string';
      MessageDlg(Format('String is %s, Method1 return %d',
         [RP_IO.RP_Prop, RP_IO.Method1(123)]), mtConfirmation,[mbOk],0);
     except
     On e:Exception do
      MessageDlg(Format('Exception occured: %s, reason %s',
        [e.ClassName, e.Message]), mtError,[mbOk],0);
     end;
    end;

Unit2.pas - объект - сервер OLE-Automation

    interface
     
    uses
      ComObj, ActiveX, Project1_TLB, Dialogs, SysUtils;
     
    type
      TRP_Server = class(TAutoObject, IRP_Server)
      private
        MyString: String;
      protected
        function Get_RP_Prop: PChar; safecall;
        function Method1(a: Integer): Integer; safecall;
        procedure Set_RP_Prop(Value: PChar); safecall;
        { Protected declarations }
      public
        destructor Destroy; override;
      end;
     
    implementation
     
    uses ComServ;
     
    Destructor TRP_Server.Destroy;
    begin
      MessageDlg('Destroy',mtConfirmation,[mbOk],0);
      Inherited Destroy;
    end;
     
    function TRP_Server.Get_RP_Prop: PChar;
    begin
     if MyString <> '' then
       Result := PChar(MyString)
     else
       Result := PChar('');
    end;
     
    function TRP_Server.Method1(a: Integer): Integer;
    begin
     MessageDlg(Format('My Method1: %d', [a]),mtConfirmation,[mbOk],0);
     if MyString <> '' then
       Result := Length(MyString)
     else
       Result := 0;
    end;
     
    procedure TRP_Server.Set_RP_Prop(Value: PChar);
    begin
     if Value <> nil then
      MyString := Value
     else
      MyString := '';
    end;
     
    initialization
      TAutoObjectFactory.Create(ComServer, TRP_Server, Class_RP_Server,
        ciMultiInstance, tmApartment);
      MessageDlg('Initializtion part',mtConfirmation,[mbOk],0);
    end.

Projcet1\_TLB.pas - файл, автоматически сгенерированный Delphi для
классов, являющихся серверами OLE-Automation

    unit Project1_TLB;
    ...
    interface
     
    uses Windows, ActiveX, Classes, Graphics, OleCtrls, StdVCL;
     
    // *********************************************************************//
    // GUIDS declared in the TypeLibrary. Following prefixes are used:      //
    //   Type Libraries     : LIBID_xxxx                                    //
    //   CoClasses          : CLASS_xxxx                                    //
    //   DISPInterfaces     : DIID_xxxx                                     //
    //   Non-DISP interfaces: IID_xxxx                                      //
    // *********************************************************************//
    const
      LIBID_Project1: TGUID = '{198C3180-6073-11D3-908D-00104BB6F968}';
      IID_IRP_Server: TGUID = '{198C3181-6073-11D3-908D-00104BB6F968}';
      CLASS_RP_Server: TGUID = '{198C3183-6073-11D3-908D-00104BB6F968}';
    type
     
    // *********************************************************************//
    // Forward declaration of interfaces defined in Type Library            //
    // *********************************************************************//
      IRP_Server = interface;
      IRP_ServerDisp = dispinterface;
     
    // *********************************************************************//
    // Declaration of CoClasses defined in Type Library                     //
    // (NOTE: Here we map each CoClass to its Default Interface)            //
    // *********************************************************************//
      RP_Server = IRP_Server;
     
    // *********************************************************************//
    // Interface: IRP_Server
    // Flags:     (4416) Dual OleAutomation Dispatchable
    // GUID:      {198C3181-6073-11D3-908D-00104BB6F968}
    // *********************************************************************//
      IRP_Server = interface(IDispatch)
        ['{198C3181-6073-11D3-908D-00104BB6F968}']
        function Method1(a: Integer): Integer; safecall;
        function Get_RP_Prop: PChar; safecall;
        procedure Set_RP_Prop(Value: PChar); safecall;
        property RP_Prop: PChar read Get_RP_Prop write Set_RP_Prop;
      end;
     
    // *********************************************************************//
    // DispIntf:  IRP_ServerDisp
    // Flags:     (4416) Dual OleAutomation Dispatchable
    // GUID:      {198C3181-6073-11D3-908D-00104BB6F968}
    // *********************************************************************//
      IRP_ServerDisp = dispinterface
        ['{198C3181-6073-11D3-908D-00104BB6F968}']
        function Method1(a: Integer): Integer; dispid 1;
        property RP_Prop: {??PChar} OleVariant dispid 2;
      end;
     
      CoRP_Server = class
        class function Create: IRP_Server;
        class function CreateRemote(const MachineName: string): IRP_Server;
      end;
     
    implementation
     
    uses ComObj;
     
    class function CoRP_Server.Create: IRP_Server;
    begin
      Result := CreateComObject(CLASS_RP_Server) as IRP_Server;
    end;
     
    class function CoRP_Server.CreateRemote(const MachineName: string): IRP_Server;
    begin
      Result := CreateRemoteComObject(MachineName, CLASS_RP_Server) as IRP_Server;
    end;

Меня всегда интересовало, как же это так Delphi позволят иметь код,
запускаемый при инициализации и деинициализации модуля ? Просмотрев
исходный код в файле Rtl/Sys/System.pas ( я рекомендую иметь исходные
тексты, поставляемые вместе с Delphi при исследовании написанных на ней
программ ) и сравнив его с ассемблерным листингом, выясняется, что это
легко и непринуждённо. Итак, существуют несколько довольно простых
структур:

     
    PackageUnitEntry = record
        Init, FInit : procedure;
      end;
     
      { Compiler generated table to be processed sequentially to init & finit all package units }
      { Init: 0..Max-1; Final: Last Initialized..0                                              }
      UnitEntryTable = array [0..9999999] of PackageUnitEntry;
      PUnitEntryTable = ^UnitEntryTable;
     
      PackageInfoTable = record
        UnitCount : Integer;      { number of entries in UnitInfo array; always > 0 }
        UnitInfo : PUnitEntryTable;
      end;
     
      PackageInfo = ^PackageInfoTable;

При startupе указатель на PackageInfoTable передаётся единственным
аргументом функции InitExe:

     
    start        proc near
                 push    ebp
                 mov     ebp, esp
                 add     esp, 0FFFFFFF4h
                 mov     eax, offset dword_0_445424
                 call    @@InitExe       ; ::`intcls'::InitExe

По адресу 0x445424 хранится DWORD 0x29 и указатель на таблицу структур
PackageUnitEntry, где, в частности, на предпоследнем месте содержатся и
адреса моих процедур инициализации и деинициализации.

Delphi помещает список реализуемых классом интерфейсов в отдельную
структуру, указатель на которую помещает в RTTI по смещению 0x4. Сама
эта структура описана во всё том же Rtl/Sys/System.pas:

      PGUID = ^TGUID;
      TGUID = record
        D1: LongWord;
        D2: Word;
        D3: Word;
        D4: array[0..7] of Byte;
      end;
     
      PInterfaceEntry = ^TInterfaceEntry;
      TInterfaceEntry = record
        IID: TGUID;
        VTable: Pointer;
        IOffset: Integer;
        ImplGetter: Integer;
      end;
     
      PInterfaceTable = ^TInterfaceTable;
      TInterfaceTable = record
        EntryCount: Integer;
        Entries: array[0..9999] of TInterfaceEntry;
      end;

Указатель на TInterfaceTable и помещается в RTTI по смещению 0x4 ( если
класс реализует какие-либо интерфейсы ). TGUID - это обычная структура
UID, используемая в OLE, VTable - указатель на VTBL интерфейса, IOffset
- смещение в данном классе на экземпляр, содержащий данные данного
интерфейса. Когда вызывается метод интерфейса, он вызывается обычно от
указателя на интерфейс, а не на класс, реализующий этот интерфейс. Мы же
пишем методы нашего класса, которые ожидают видеть в качестве нулевого
аргумента указатель на экземпляр нашего класса. Поэтому Delphi
автоматически генерирует для VTable код, настраивающий свой нулевой
аргумент соответствующим образом. Например, для моего класса TRP\_Server
значение поля IOffset составляет 0x34. Функции же, содержащиеся в
VTable, выглядят так:

loc\_0\_444B39: ; функция, вызываемая по интерфейсу

               add     dword ptr [esp+4], 0FFFFFFCCh

               jmp     MyMethod1        ; вызов функции в классе

Напомню, что все методы интерфейсов должны объявляться как safecall -
параметры передаются как в C, справо налево, но очистку стека производит
вызываемая процедура. Поэтому в [esp+4] содержится нулевой параметр
функции - указатель на экземпляр интерфейса - класса IRP\_Server. Затем
вызывается метод класса TRP\_Server, которому должен нулевым параметром
передаваться указатель на экземпляр TRP\_Server - поэтому происходит
настройка этого параметра, 0x0FFFFFFCC = -0x34.

Самый же значимый резльтат всех этий ковыряний в коде - мне удалось
обнаружить в RTTI полное описание всех published свойств ! Из системы
помощи Delphi: ( файл del4op.hlp, перевод мой ):

Published члены имеют такую же видимость, как public члены. Разница
заключается в том, что для published членов генерируется информация о
типе времени исполнения (RTTI). RTTI позволяет приложению динамически
обращаться к полям и свойствам объектов и отыскивать их методы. Delphi
использует RTTI для доступа к значениям свойств при сохранении и
загрузке файлов форм (.DFM), для показа свойств в Object Inspector и для
присваивания некоторых методов (называемых обработчиками событий)
определённым свойствам (называемых событиями)

Published свойства ограничены по типу данных. Они могут иметь типы
Ordinal, string, класса, интерфейса и указателя на метод класса. Также
могут быть использованы наборы (set), если верхний и нижний пределы их
базового типа имеют порядковые значения между 0 и 31 (другими словами,
набор должен помещаться в байте, слове или двойном слове ). Также можно
иметь published свойство любого вещественного типа (за исключением
Real48). Свойство-массив не может быть published. Все методы могут быть
published, но класс не может иметь два или более перегруженных метода с
одинаковыми именами. Члены класса могут быть published, только если они
являются классом или интерфейсом.

Класс не может содержать published свойств, если он не скомпилирован с
ключом {$M+} или является производным от класса, скомпилированного с
этим ключом. Подавляющее большинство классов с published свойствами
являются производными от класса TPersistent, который уже скомпилирован с
ключом {$M+}, так что Вам редко потребуется использовать эту директиву.

Что сиё может означать для reverse engeneerов ? Значение вышесказанного
трудно переоценить - мы можем извлечь из RTTI названия, типы и
местоположение в классе всех published свойств любого класса ! Если
вспомнить, что такие свойства, как Enable, Text, Caption, Color, Font и
многие другие для таких компонентов, как TEdit,TButton,TForm и проч.,
обычно изменяющиеся, предположим, в диалоге регистрации в зависимости от
правильности-неправильности серийного номера, имеют как раз тип
published... Поскольку все формы Delphi и компоненты в них имеют
published свойства, моя фантазия рисует мне куда более сочную и
красочную картину... Одна из главных структур, применяющихся для
идентификации published свойств - TPropInfo

      TPropInfo = packed record
        PropType: PPTypeInfo;
        GetProc: Pointer;
        SetProc: Pointer;
        StoredProc: Pointer;
        Index: Integer;
        Default: Longint;
        NameIndex: SmallInt;
        Name: ShortString;
      end;

После структуры наследования ( по смещению 10h в RTTI ) расположен WORD
- количество расположенных следом за ним структур TPropInfo, по одной на
каждое published свойство. В этой структуре поля имеют следующие
значения:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   PropType - указатель на структуру, описывающую тип данного свойства. Структуры, содержащиеся в TypeInfo, довольно сложные, так что я не буду объяснять, как именно они работают, Вам достаточно знать, что мой IDC script потрошит её в 99 % случаев. Они описаны в файле vcl/typeinfo.pas.
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   GetProc,SetProc,StoredProc - поля, указывающие на методы Get ( извлечение свойства ), Set ( изменение свойства ) и Stored ( признак сохранения значения свойства ). Для всех них есть недокументрированные правила:
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Если старший байт этих полей равен 0xFF, то в остальных байтах находится смещение в экземпляре класса, по которому находятся данные, представляющие данное свойство. В таком случае все манипуляции со свойством производятся напрямую.
  --- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Если старший байт равен 0xFE, то в остальных байтах содержится смещение в VTBL класса, т.е. все манипуляции со свойством производятся через виртуальную функцию.
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- ----------------------------------------------------------------------------------------------------------------
  ·   Если значение поля равно 0x80000000 - метод не определён ( скажем, метод Set для read-only published свойств )
  --- ----------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- ------------------------------------------------------------------------------------
  ·   Значение 1 для поля StoredProc означает обязательное сохранение значения свойства.
  --- ------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- --------------------------------------------------------------------------
  ·   Все остальные значения полей рассматриваются как ссылка на метод класса.
  --- --------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Index - значение не выяснено. Есть подозрение, что это поле связано со свойствами типа массив и подчиняется тем же правилам, что и предыдущие три поля. Во время тестирования мне не встретилось ни одного поля Index со значением, отличным от 0x80000000
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ------------------------------------------
  ·   Default - значение свойства по умолчанию
  --- ------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ------------------------------------------------------------------------------------------------
  ·   NameIndex - порядковый номер published свойства в данном классе, отсчёт ведётся почему-то с 2.
  --- ------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ------------------------------------------
  ·   Name - Имя свойства, pascal-style строка
  --- ------------------------------------------
:::

 

Как видите, можно узнать о published-свойствах практически всё, включая
адрес, на который нужно ставить точку останова.

Я изменил свой IDC script для анализа RTTI классов Delphi 4, чтобы он
поддерживал все обнаруженные структуры.

Желаю удачи...

Взято с <https://delphiworld.narod.ru>
