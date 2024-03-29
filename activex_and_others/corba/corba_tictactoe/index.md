---
Title: Крестики-нолики с CORBA
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Крестики-нолики с CORBA
=======================

Известно расшифровывается как Common Object Request Broker Architecture,
и представляет собой объектно-ориентированную архитектуру связи между
клиентом и сервером. Приложения на основе CORBA состоят из двух частей:
CORBA-сервер и CORBA-клиент. И сервер и клиент могут быть реализованы на
любом языке и запущены на любой платформе. CORBA представляет собой
независимую от языка программирования и операционной системы технологию.
Это возможно, так как все параметры и типы, возвращаемые методами
транспортируются через сеть в специально универсальном формате. А вот
для того чтобы сервер и клиент понимали друг друга необходимо определить
интерфейс CORBA-сервера, при этом необходимо учитывать независимость от
операционной системы и языка на котором происходит разработка
приложения. Для этой цели и был разработан интерфейс общения клиента и
сервера Interface Definition Language (IDL). Используя IDL, можно
определять специфические объекты с присущими им методами и свойствами.
Данные методы подобны функциям, которые могут быть вызваны клиентом, и
которые могут быть реализованы сервером. В Delphi например для
реализации подобного интерфейса прийдеться компилировать
специализированный IDL-файл. Вообще же преобразование из стандартного
внутреннего стандарта языка программирования в подобный переносимый
формат обозначают как marshalling. Обратный процесс преобразования из
универсального формата в стандарт понятный программе называется
unmarshalling.

Особенности установки VisiBroker

В стандартный набор Delphi 6 Enterprise входит поддержка CORBA в двух
вариантах. Во время инсталляции Delphi необходимо выбрать поддержку
VisiBroker 3.3 или VisiBroker 4. Это связано с тем, что VisiBroker 3.3 и
VisiBroker 4 не могут быть установлены одновременно. В противном случаи,
возможны проблемы при работе с Delphi 6. В более ранней версии
VisiBroker 3.3 существует полезная возможность динамического вызова
интерфейса. В VisiBroker 4 это функциональная особенность не
поддерживается. Несмотря на это VisiBroker 4 представляет собой более
совершенную реализацию стандарта CORBA, поэтому вопросы, связанные с
предыдущей версией VisiBroker 3.3 рассматриваться не будут.

TicTacToe

А теперь рассмотрим возможности технологии CORBA в Delphi, с
использованием VisiBroker 4, на примере практического создания небольшой
программы. Ниже представлена конструкция IDL известной всем игры в
"крестики-нолики", которая имеет гордое английское название TicTacToe.
Модуль TTT с интерфейсом TicTacToe реализуется CORBA сервером, и CORBA
клиент может соединяться с сервером во время игры.

    module TTT
    {
      interface TicTacToe
      {
        typedef long TGame;
        typedef long TPlace; // 0,1..9
        enum TPlayer
        {
          user,
          computer,
          none
        };
        exception PlaceTaken
        {
          TPlayer TakenBy;
        };
     
        TGame NewGame();
        void MakeMove(in TGame Game, in TPlayer player, in TPlace Place)
        raises(PlaceTaken);
        TPlace NextMove(in TGame Game, in TPlayer player);
        TPlayer IsWinner(in TGame Game);
        TPlayer GetValue(in TGame Game, in TPlace Place);
      };
    };

Модуль TTT имеет интерфейс TicTacToe. Это интерфейс содержит определения
ряда типов (видимы только внутри области интерфейса), определение
исключения и определения ряда методов. Обратите внимание, что метод
MakeMove может вызывать исключение PlaceTaken. Исключение PlaceTaken -
фактически структура, которая также будет обработана.

IDL2Pas Wizard

Для использования IDL файла, его необходимо скомпилировать для Server
Skeletons и Client Stubs. Для этого используется файл IDL2Pas, который
является частью VisiBroker for Delphi. Но более простой путь,
использовать мастера CORBA Server Application и CORBA Client Найти их
можно в File \| New \| Other, закладка Corba.

При выборе мастера CORBA Server Application появится окно и вы можете
добавить туда IDL.

Закладка Options содержит ряд специфических установок, который будут
выполнены в командной строке IDL2Pas. Обратите внимание на опцию
"Overwrite Implementation Units", она не установлена по умолчанию.
Кстати, при повторной компиляции данную опцию необходима снять - иначе
созданная до этого IDL-файл будет перекомпилировать.

Установки закладки Options мастера IDL2Pas хранятся в секции [idl2pas]
файла defproj.dof, находящегося в директории Delphi6\\bin, и все
выбранные установки будут использованы при следующей загрузки мастера
IDL2Pas.

CORBA Server Skeleton

После того как вы нажмете на кнопку ОК в CORBA Server Application
Wizard, будут сгенерировано несколько файлов: TTT.IDL будет использован
для генерации файла TTT\_c.pas (client stubs и helpers), TTT\_i.pas
будет содержать определения интерфейса, TTT\_impl.pas будет использован
для реализации интерфейса и TTT\_s.pas содержащий server skeletons.
Далее можно будет только модифицировать файл TTT\_impl.pas, тогда как
другие могут быть сгенерированы заново с помощью IDL2Pas.

Interface Definitions (TTT\_i.pas)

Файл интерфейса ТТТ TTT\_i.pas содержит определение интерфейса
TicTacToe. Причиной использования в определениях типов префикса
TicTacToe\_ является использование этих типов внутри интерфейса. Если мы
определяем их вне интерфейса TicTacToe, то транслироваться они буду без
префикса TicTacToe\_.

    unit TTT_i;
     
    interface
     
    uses CORBA;
     
    type
      TicTacToe_TPlayer = (user, computer, none);
     
    type
      TicTacToe = interface;
      TicTacToe_TGame = Integer;
      TicTacToe_TPlace = Integer;
     
      TicTacToe = interface ['{50B30FC5-4B18-94AB-1D5F-4148BB7467B4}']
        function NewGame: TTT_i.TicTacToe_TGame;
        procedure MakeMove (const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer;
        const Place: TTT_i.TicTacToe_TPlace);
        function NextMove (const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer):
        TTT_i.TicTacToe_TPlace;
        function IsWinner (const Game: TTT_i.TicTacToe_TGame):
        TTT_i.TicTacToe_TPlayer;
        function GetValue (const Game: TTT_i.TicTacToe_TGame;
        const Place: TTT_i.TicTacToe_TPlace):
        TTT_i.TicTacToe_TPlayer;
    end;

Можно заметить, что здесь не видны определения исключения. Оно появится
в файле Client Stub TTT\_c.pas.

Client Stubs and Helpers (TTT\_c.pas)

Файл TTT\_s.pas содержит не только Client Stubs, но и классы helper.
Конечно, лучше было бы если Client Stubs был включен в TTT\_c.pas, а
классы helper в TTT\_h.pas. Но раз все обстоит не так, придется включить
файл TTT\_c.pas в предложение uses нашего файла Server Skeleton
TTT\_s.pas.

    unit TTT_c;
     
    interface
     
    uses CORBA, TTT_i;
     
    type
      TTicTacToeHelper = class;
      TTicTacToeStub = class;
      TTicTacToe_TGameHelper = class;
      TTicTacToe_TPlaceHelper = class;
      TTicTacToe_TPlayerHelper = class;
      ETicTacToe_PlaceTaken = class;
     
      TTicTacToeHelper = class
        class procedure Insert (var _A: CORBA.Any; const _Value: TTT_i.TicTacToe);
        class function Extract(var _A: CORBA.Any): TTT_i.TicTacToe;
        class function TypeCode: CORBA.TypeCode;
        class function RepositoryId: string;
        class function read (const _Input: CORBA.InputStream): TTT_i.TicTacToe;
        class procedure write(const _Output: CORBA.OutputStream; const _Value:
        TTT_i.TicTacToe);
        class function Narrow(const _Obj: CORBA.CORBAObject; _IsA: Boolean = False):
        TTT_i.TicTacToe;
        class function Bind(const _InstanceName: string = ''; _HostName: string = ''):
        TTT_i.TicTacToe; overload;
        class function Bind(_Options: BindOptions; const _InstanceName: string = '';
        _HostName: string = ''): TTT_i.TicTacToe; overload;
      end;
     
      TTicTacToeStub = class(CORBA.TCORBAObject, TTT_i.TicTacToe)
      public
        function NewGame: TTT_i.TicTacToe_TGame; virtual;
        procedure MakeMove(const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer;
        const Place: TTT_i.TicTacToe_TPlace); virtual;
        function NextMove(const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer):
        TTT_i.TicTacToe_TPlace; virtual;
        function IsWinner(const Game: TTT_i.TicTacToe_TGame):
        TTT_i.TicTacToe_TPlayer; virtual;
        function GetValue(const Game: TTT_i.TicTacToe_TGame;
        const Place: TTT_i.TicTacToe_TPlace):
        TTT_i.TicTacToe_TPlayer; virtual;
      end;
     
      TTicTacToe_TGameHelper = class
        class procedure Insert (var _A: CORBA.Any; const _Value: TTT_i.TicTacToe_TGame);
        class function Extract(const _A: CORBA.Any): TTT_i.TicTacToe_TGame;
        class function TypeCode: CORBA.TypeCode;
        class function RepositoryId: string;
        class function read (const _Input: CORBA.InputStream): TTT_i.TicTacToe_TGame;
        class procedure write(const _Output: CORBA.OutputStream; const _Value:
        TTT_i.TicTacToe_TGame);
      end;
     
      TTicTacToe_TPlaceHelper = class
        class procedure Insert (var _A: CORBA.Any; const _Value: TTT_i.TicTacToe_TPlace);
        class function Extract(const _A: CORBA.Any): TTT_i.TicTacToe_TPlace;
        class function TypeCode: CORBA.TypeCode;
        class function RepositoryId: string;
        class function read (const _Input: CORBA.InputStream): TTT_i.TicTacToe_TPlace;
        class procedure write(const _Output: CORBA.OutputStream; const _Value:
        TTT_i.TicTacToe_TPlace);
      end;
     
      TTicTacToe_TPlayerHelper = class
        class procedure Insert (var _A: CORBA.Any; const _Value: TTT_i.TicTacToe_TPlayer);
        class function Extract(const _A: CORBA.Any): TTT_i.TicTacToe_TPlayer;
        class function TypeCode: CORBA.TypeCode;
        class function RepositoryId: string;
        class function read (const _Input: CORBA.InputStream): TTT_i.TicTacToe_TPlayer;
        class procedure write(const _Output: CORBA.OutputStream; const _Value:
        TTT_i.TicTacToe_TPlayer);
      end;
     
      ETicTacToe_PlaceTaken = class(UserException)
      private
        FTakenBy: TTT_i.TicTacToe_TPlayer;
      protected
        function _get_TakenBy: TTT_i.TicTacToe_TPlayer; virtual;
      public
        property TakenBy: TTT_i.TicTacToe_TPlayer read _get_TakenBy;
        constructor Create; overload;
        constructor Create(const TakenBy: TTT_i.TicTacToe_TPlayer); overload;
        procedure Copy(const _Input: InputStream); override;
        procedure WriteExceptionInfo(var _Output: OutputStream); override;
      end;

На что следует обратить внимание, так это на декларацию исключения
ETicTacToe\_PlaceTaken, которое имеет два конструктора: по умолчанию без
аргументов и с одним аргументом TakenBy, который автоматически
инициализируя исключение.

Server Skeletons (TTT\_s.pas)

Класс TticTacToeSkeleton единственный класс, который мы используем для
создания экземпляра CORBA Server TicTacToe, принимающего в качестве
аргументов имя InstanceName и экземпляр интерфейса TicTacToe .

    unit TTT_s;
     
    interface
     
    uses CORBA, TTT_i, TTT_c;
     
    type
      TTicTacToeSkeleton = class;
     
      TTicTacToeSkeleton = class(CORBA.TCorbaObject, TTT_i.TicTacToe)
      private
        FImplementation: TicTacToe;
      public
        constructor Create(const InstanceName: string; const Impl: TicTacToe);
        destructor Destroy; override;
        function GetImplementation: TicTacToe;
     
        function NewGame: TTT_i.TicTacToe_TGame;
        procedure MakeMove(const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer;
        const Place: TTT_i.TicTacToe_TPlace);
        function NextMove(const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer):
        TTT_i.TicTacToe_TPlace;
        function IsWinner(const Game: TTT_i.TicTacToe_TGame):
        TTT_i.TicTacToe_TPlayer;
        function GetValue(const Game: TTT_i.TicTacToe_TGame;
        const Place: TTT_i.TicTacToe_TPlace):
        TTT_i.TicTacToe_TPlayer;
      published
        procedure _NewGame(const _Input: CORBA.InputStream; _Cookie: Pointer);
        procedure _MakeMove(const _Input: CORBA.InputStream; _Cookie: Pointer);
        procedure _NextMove(const _Input: CORBA.InputStream; _Cookie: Pointer);
        procedure _IsWinner(const _Input: CORBA.InputStream; _Cookie: Pointer);
        procedure _GetValue(const _Input: CORBA.InputStream; _Cookie: Pointer);
    end;

Implementation (TTT\_impl.pas)

Файл TTT\_impl.pas, единственный файл который редактируется и в который
вставляется код реализации CORBA сервера. Тут использован модуль Magic,
который использовался для ITicTacToe web service в Delphi 6.

    unit TTT_impl;
     
    interface
     
    uses
      SysUtils, CORBA, TTT_i, TTT_c,
      Magic; // implementation of Magic.TTicTacToe
     
    type
      TTicTacToe = class(TInterfacedObject, TTT_i.TicTacToe)
      protected
        TTT: Magic.TTicTacToe;
      public
        constructor Create;
        function NewGame:TTT_i.TicTacToe_TGame;
        procedure MakeMove(const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer;
        const Place: TTT_i.TicTacToe_TPlace);
        function NextMove(const Game: TTT_i.TicTacToe_TGame;
        const player: TTT_i.TicTacToe_TPlayer):
        TTT_i.TicTacToe_TPlace;
        function IsWinner(const Game: TTT_i.TicTacToe_TGame):
        TTT_i.TicTacToe_TPlayer;
        function GetValue(const Game: TTT_i.TicTacToe_TGame;
        const Place: TTT_i.TicTacToe_TPlace):
        TTT_i.TicTacToe_TPlayer;
    end;
     
    implementation
     
    constructor TTicTacToe.Create;
    begin
      inherited;
      { *************************** }
      { *** User code goes here *** }
      { *************************** }
      TTT := Magic.TTicTacToe.Create;
    end;
     
    function TTicTacToe.NewGame: TTT_i.TicTacToe_TGame;
    begin
      { *************************** }
      { *** User code goes here *** }
      { *************************** }
      Result := TTT.NewGame
    end;
     
    procedure TTicTacToe.MakeMove(const Game: TTT_i.TicTacToe_TGame;
    const player: TTT_i.TicTacToe_TPlayer;
    const Place: TTT_i.TicTacToe_TPlace);
    begin
      { *************************** }
      { *** User code goes here *** }
      { *************************** }
      TTT.MakeMove(Game, Ord(Player), Place);
    end;
     
    function TTicTacToe.NextMove(const Game: TTT_i.TicTacToe_TGame;
    const player: TTT_i.TicTacToe_TPlayer):
    TTT_i.TicTacToe_TPlace;
    begin
      { *************************** }
      { *** User code goes here *** }
      { *************************** }
      Result := TTT.NextMove(Game, Ord(Player))
    end;
     
    function TTicTacToe.IsWinner(const Game: TTT_i.TicTacToe_TGame):
    TTT_i.TicTacToe_TPlayer;
    begin
      { *************************** }
      { *** User code goes here *** }
      { *************************** }
      Result := TTT_i.TicTacToe_TPlayer(TTT.IsWinner(Game))
    end;
     
    function TTicTacToe.GetValue(const Game: TTT_i.TicTacToe_TGame;
    const Place: TTT_i.TicTacToe_TPlace):
    TTT_i.TicTacToe_TPlayer;
    begin
      { *************************** }
      { *** User code goes here *** }
      { *************************** }
      Result := TTT_i.TicTacToe_TPlayer(TTT.GetValue(Game, Place))
    end;
     
    initialization
     
    end.

Теперь мы имеем на руках практически все части для создания приложения с
использованием технологии CORBA . Пусть даже это и игрушка.

CORBA Server Application

Помимо сгенерированных файлов должен же быть и сам проект с главным
модулем формы. Сохранив проект как TTTServer.dpr а модуль главной формы
как GameUnit. Если заменить фактический ТТТ на объект skeleton типа
TicTacToe, код модуля будет выглядеть следующим образом. Тут следует
обратить внимание на использование четырех модулей в предложении uses
секции interface:

    unit GameUnit;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, Corba, TTT_i, TTT_c, TTT_s, TTT_impl;
     
    type
      TForm1 = class(TForm)
      private
        { private declarations }
      protected
        { protected declarations }
        TTT: TicTacToe; // skeleton object
        procedure InitCorba;
      public
        { public declarations }
    end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.InitCorba;
    begin
      CorbaInitialize;
      TTT := TTicTacToeSkeleton.Create('TTT', TTicTacToe.Create);
      BOA.ObjIsReady(TTT as _Object)
    end;
     
    end.

Вызов InitCorba будем производить из обработчика события OnCreate формы:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      InitCorba;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      TTT := nil;
    end;

Можно сделать вывод, что сервер лучше иметь в виде консольного
приложения. Ниже оно представлено. Там используется старомодный оператор
writeln, с помощью которого и сообщается пользователю о запуске новой
игры. Консольное приложение использует те же самые элементы, что и
визуальная версия, но в конце добавлен вызов BOA.ImplIsReady.

    program TTTCServer;
    {$APPTYPE CONSOLE}
     
    uses
      SysUtils, CORBA, TTT_c, TTT_i, TTT_s, TTT_impl;
     
    var
      TTT: TicTacToe; // skeleton object
     
    begin
      writeln('CorbaInitialize');
      CorbaInitialize;
      writeln('TTicTacToe.Create');
      TTT := TTicTacToeSkeleton.Create('TTT', TTicTacToe.Create);
      writeln('BOA.ObjIsReady');
      BOA.ObjIsReady(TTT as _Object);
      writeln('BOA.ImplIsReady');
      BOA.ImplIsReady
    end.

Теперь можно приступать к созданию CORBA-клиента.

CORBA Client Application

Для создания CORBA-клента так же можно использовать CORBA Wizard.
Проделываем тоже самое что мы делали для формирования сервера CORBA.
Только не следует создавать снова TTT\_impl.pas. Кроме уже описанных
выше файлов, в наличие есть и файл главной формы и файл проекта.
Сохраним их как MainForm.pas и TTTClient.dpr. Модуль MainForm.pas
содержит подсказки, чтобы показать вам как создать экземпляр CORBA
сервера:

    unit MainForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, Corba;
     
    type
      TForm1 = class(TForm)
      private
        { private declarations }
      protected
        { protected declarations }
        // declare your Corba interface variables like this
        // Acct : Account;
        procedure InitCorba;
      public
        { public declarations }
    end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.InitCorba;
    begin
      CorbaInitialize;
      // Bind to the Corba server like this
      // Acct := TAccountHelper.bind;
    end;
     
    end.

Здесь нужно вызвать метод InitCorba из обработчика OnCreate формы. Надо
включить в предложение uses модуля MainForm модули TTT\_c, TTT\_i и
TTT\_impl, без которых не будут доступны классы helpers. Непосредственно
же объявление переменной типа интерфейса CORBA, может выглядеть
следующим образом:

    private
      TicTacToe: TicTacToe;

Фактическое связывание интерфейса TicTacToe с CORBA сервером реализуется
следующим образом:

    TicTacToe := TTicTacToeHelper.bind;

Теперь можно использовать TicTacToe как обыкновенный класс, включающий
поддержку Code Insight.

Action!

Внизу представлен небольшой компонент, основанный на оригинальном
компоненте игры TicTacToe. Результирующий код, реализован в MagicTTT.pas
- содержит в предложении uses модули TTT\_i, TTT\_c and TTT\_impl и
создает экземпляр интерфейса TicTacToe:

    unit MagicTTT;
     
    interface
     
    uses
      SysUtils, Classes, Controls, StdCtrls, Dialogs, TTT_c, TTT_i, TTT_impl;
     
    const
      NoneID = 0;
      UserID = 1;
      CompID = 2;
     
    const
      chrUser = 'X';
      chrComp = '@';
     
    const
      FirstPlace = 1;
      LastPlace = 9;
     
    type
      TPlace = FirstPlace..LastPlace;
     
    type
      TTTTControl = class(TWinControl)
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        procedure SetBounds(ALeft, ATop, AWidth, AHeight: Integer); override;
     
      private
        TicTacToe: TicTacToe;
     
      private { 9 game buttons }
        Game: Integer;
        Button: array[TPlace] of TButton;
        procedure ButtonClick(Sender: TObject);
        procedure ComputerMove;
        procedure UserMove(Move: TPlace);
     
      private { start button }
        TheStartButton: TButton;
        procedure StartButtonClick(Sender: TObject);
     
      private { game properties }
        FStartButton: Boolean;
        FUserStarts: Boolean;
        FUserChar: Char;
        FCompChar: Char;
     
      protected { design interface }
        procedure SetStartButton(Value: Boolean);
        procedure SetUserStarts(Value: Boolean);
        procedure SetUserChar(Value: Char);
        procedure SetCompChar(Value: Char);
        function GetCaption: string;
        procedure SetCaption(Value: string);
     
      published { user interface }
        property StartButton: Boolean
        read FStartButton write FStartButton default False;
        property Caption: string
        read GetCaption write SetCaption;
        property UserStarts: Boolean
        read FUserStarts write SetUserStarts default False;
        property UserChar: Char
        read FUserChar write SetUserChar default chrUser;
        property CompChar: Char
        read FCompChar write SetCompChar default chrComp;
    end {TTTTControl};
     
    procedure register;
     
    implementation
     
    uses Forms;
     
    constructor TTTTControl.Create(AOwner: TComponent);
    var
      ButtonIndex: TPlace;
    begin
      inherited Create(AOwner);
      Game := 0;
      UserStarts := False;
      FUserChar := chrUser;
      FCompChar := chrComp;
      TheStartButton := TButton.Create(Self);
      TheStartButton.Parent := Self;
      TheStartButton.Visible := True;
      TheStartButton.Caption := 'Humor me...';
      TheStartButton.OnClick := StartButtonClick;
      CorbaInitialize;
      TicTacToe := TTicTacToeHelper.bind;
      for ButtonIndex := Low(ButtonIndex) to High(ButtonIndex) do
      begin
        Button[ButtonIndex] := TButton.Create(Self);
        Button[ButtonIndex].Parent := Self;
        Button[ButtonIndex].Caption := '';
        Button[ButtonIndex].Visible := False;
        Button[ButtonIndex].OnClick := ButtonClick;
      end;
      SetBounds(Left,Top,132,132)
    end {Create};
     
    destructor TTTTControl.Destroy;
    var
      ButtonIndex: TPlace;
    begin
      TheStartButton.Destroy;
      for ButtonIndex := Low(ButtonIndex) to High(ButtonIndex) do
        Button[ButtonIndex].Destroy;
      TicTacToe := nil; { explicit! }
      inherited Destroy;
    end; {Destroy};
     
    procedure TTTTControl.SetBounds(ALeft, ATop, AWidth, AHeight: Integer);
    const
      Grid = 3;
      GridX = 2;
      GridY = 2;
    var
      X,DX,W,Y,DY,H: Word;
    begin
      inherited SetBounds(ALeft,ATop,AWidth,AHeight);
      TheStartButton.SetBounds(0,0,Width,Height);
      X := GridX;
      DX := (Width div (Grid * (GridX+GridX))) * (GridX+GridX);
      W := DX - GridX;
      Y := GridY;
      DY := (Height div (Grid * (GridY+GridY))) * (GridY+GridY);
      H := DY - GridY;
      Button[8].SetBounds(X, Y, W,H);
      Button[1].SetBounds(X, Y+DY, W,H);
      Button[6].SetBounds(X, Y+DY+DY, W,H);
      Inc(X,DX);
      Button[3].SetBounds(X, Y, W,H);
      Button[5].SetBounds(X, Y+DY, W,H);
      Button[7].SetBounds(X, Y+DY+DY, W,H);
      Inc(X,DX);
      Button[4].SetBounds(X, Y, W,H);
      Button[9].SetBounds(X, Y+DY, W,H);
      Button[2].SetBounds(X, Y+DY+DY, W,H)
    end {SetBounds};
     
    procedure TTTTControl.StartButtonClick(Sender: TObject);
    var
      ButtonIndex: TPlace;
    begin
      try
        Game := TicTacToe.NewGame;
        if Parent is TForm then
          (Parent as TForm).Caption := IntToStr(Game);
        TheStartButton.Visible := False;
        for ButtonIndex := Low(ButtonIndex) to High(ButtonIndex) do
          Button[ButtonIndex].Visible := True;
        if UserStarts then
        begin
          MessageDlg('You may start...', mtInformation, [mbOk], 0);
          Button[5].SetFocus; { hint... }
        end
        else
          ComputerMove
      except
        on E: Exception do
          MessageDlg('Sorry: '+E.message, mtError, [mbOk], 0)
      end
    end {StartButtonClick};
     
    procedure TTTTControl.ButtonClick(Sender: TObject);
    var
      ButtonIndex: TPlace;
    begin
      Enabled := False;
      for ButtonIndex := Low(ButtonIndex) to High(ButtonIndex) do
        if Button[ButtonIndex] = Sender as TButton then
          UserMove(ButtonIndex)
    end {ButtonClick};
     
    procedure TTTTControl.ComputerMove;
    var
      Move: Integer;
    begin
      Move := TicTacToe.NextMove(Game,TicTacToe_TPlayer(CompID));
      if Move = 0 then
        MessageDlg('Neither has won, the game is a draw!', mtInformation, [mbOk], 0)
      else
      begin
        TicTacToe.MakeMove(Game,TicTacToe_TPlayer(CompID),Move);
        Button[Move].Caption := CompChar;
        Button[Move].Update;
        if TicTacToe.IsWinner(Game) = TicTacToe_TPlayer(CompID) then
          MessageDlg('I have won!', mtInformation, [mbOk], 0)
        else
        begin
          Move := TicTacToe.NextMove(Game,TicTacToe_TPlayer(UserID));
          if Move = 0 then
            MessageDlg('Neither has won, the game is a draw!', mtInformation, [mbOk], 0)
          else
          if Move in [FirstPlace..LastPlace] then
          begin
            Enabled := True;
            Button[Move].SetFocus { hint... }
          end
          else
          if Parent is TForm then
            (Parent as TForm).Caption := IntToStr(Move)
        end
      end
    end {ComputerMove};
     
    procedure TTTTControl.UserMove(Move: TPlace);
    begin
      if Button[Move].Caption <> '' then
        MessageDlg('This place is occupied!', mtWarning, [mbOk], 0)
      else
      begin
        Button[Move].Caption := UserChar;
        Button[Move].Update;
        TicTacToe.MakeMove(Game,TicTacToe_TPlayer(UserID),Move);
        if TicTacToe.IsWinner(Game) = TicTacToe_TPlayer(UserID) then
          MessageDlg('Congratulations, you have won!', mtInformation, [mbOk], 0)
        else
        ComputerMove
      end
    end {UserMove};
     
    procedure TTTTControl.SetUserChar(Value: Char);
    begin
      if Value = FCompChar then
        MessageDlg('Character '+Value+' already in use by CompChar!', mtError, [mbOk], 0)
      else
        FUserChar := Value
    end {SetUserChar};
     
    procedure TTTTControl.SetCompChar(Value: Char);
    begin
      if Value = FUserChar then
        MessageDlg('Character '+Value+' already in use by UserChar!', mtError, [mbOk], 0)
      else
        FCompChar := Value
    end {SetCompChar};
     
    procedure TTTTControl.SetUserStarts(Value: Boolean);
    begin
      FUserStarts := Value;
    end {SetUserStarts};
     
    procedure TTTTControl.SetStartButton(Value: Boolean);
    begin
      FStartButton := Value
    end {SetStartButton};
     
    function TTTTControl.GetCaption: string;
    begin
      GetCaption := TheStartButton.Caption
    end {GetCaption};
     
    procedure TTTTControl.SetCaption(Value: string);
    begin
      TheStartButton.Caption := Value
    end {SetCaption};
     
    procedure register;
    begin
      RegisterComponents('DrBob42', [TTTTControl])
    end {Register};
     
    end.

Обратите внимание, что конструктор TTTControl также вызывает
CorbaInitialize для того чтобы Smart Agent был запущен до того как вы
фактически создаете этот компонент.


