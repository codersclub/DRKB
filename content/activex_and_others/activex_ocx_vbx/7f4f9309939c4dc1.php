<h1>Управление свойством Font через сервер автоматизации</h1>
<div class="date">01.01.2007</div>

Данный документ предназначен главным образом тем программистам, кто использует OLE/COM и хочет встроить объект Font (типа Delphi-го TFont) в свой сервер автоматизации. Интерфейс IFontDisp для COM будет иметь ту же функциональность, что и Delphi-ий TFont. Например, если у вас имеется клиент автоматизации, содержащий объект со свойством Font, и в сервере автоматизации для изменения атрибутов текста вы хотите иметь те же методы (наприр, имя шрифта, жирное или наклонное начертание). Для хранения и управления шрифтом сервер автоматизации может применять реализацию интерфейса IFontDisp.</p>
<p>Приведенный ниже демонстрационный проект содержит элементы и шаги, необходимые для реализации интерфейса IFontDisp в сервере автоматизации COM, и осуществление взаимодействия между клиентом автоматизации COM и интерфейсом. Ниже вы найдете полный листинг исходных модулей, и некоторые комментарии относительно проекта.</p>
<p>Демонстрационный проект содержит следующие модули:</p>
<p>Project1_TLB: Паскалевская обертка для библиотеки типов, содержащей определение интерфейса.</p>
<p>Unit1: Реализация интерфейса: код, содержащий описание свойств интерфейса и реализующий его методы.</p>
<p>Unit2: Главная форма сервера автоматизации. Данный модуль не является обязательным, но он в ходе тестирования обеспечивает обратную связь, так что мы можем видеть как отрабатываются вызовы наших методов.</p>
<p>FontCli: Клиент автоматизации, получающий ссылку на интерфейс, и использующий его методы.</p>
<p>Ниже приведены общие шаги для достижения цели. Вы можете сравнить каждый из этих шагов с кодом модулей, приведенных ниже.</p>
<p>Выберите пункт меню File|New|ActiveX|Automation Object и в Мастере Automation Object Wizard выберите в качестве имени класса MyFontServer. Создайте единственное свойство с именем MyFont и типом IFontDisp. Для получения дополнительной информции смотри Developer's Guide, chapter 42 (руководство разработчика, глава 42), там подробно описана работа с библиотеками типов и создание интерфейсов в редакторе библиотеки типов.</p>
<p>В предыдущем шаге при добавлении интерфейса с помошью редактора библиотеки типов вы должны были получить паскалевский модуль-обертку (в нашем примере модуль имеет имя Unit1). Unit1 будет содержать обертку реализаций методов получения и назначения свойства MyFont. На данном этапе вы обеспечите хранение значений свойства MyFont в форме FFont (TFont) и добавите код реализации, наполняющий функциональностью методы получения и установки (get/set).</p>
<p>Unit1 использует Unit2. Unit2 содержит форму, компонент Memo и StatusBar для отображения каждого реализованного метода, для диагностических целей.</p>
<p>Создайте Unit2, содержащий форму с компонентами TMemo и TStatusBar. Форма используется для отображения жизнедеятельности в модуле Unit1.pas. Это шаг не является строго обязательным, он помогает понять что происходит в данный момент между клиентом автоматизации и сервером.</p>
<p>Создайте клиент автоматизации. В нашем случае модуль имеет имя FontCli, содержит метку, показывающую текущий шрифт и кнопку, устанавливающую MyFont на сервере.</p>
<pre>
unit Project1_TLB;
 
{ Данный файл содержит паскалевские декларации, импортированные из
библиотеки типов. Данный файл записывается во время каждого импорта
или обновления (refresh) в редакторе библиотеки типов. Любые изменения
в данном файле будут потеряны в процессе очередного обновления. }
 
{ Библиотека Project1 }
{ Версия 1.0 }
 
interface
 
uses Windows, ActiveX, Classes, Graphics, OleCtrls, StdVCL;
 
const
 
  LIBID_Project1: TGUID = '{29C7AC94-0807-11D1-B2BA-0020AFF2F575}';
 
const
 
  { GUID'ы класса компоненты }
 
  Class_MyFontServer: TGUID = '{29C7AC96-0807-11D1-B2BA-0020AFF2F575}';
 
type
 
  { Предварительные объявления: Интерфейсы }
 
  IMyFontServer = interface;
  IMyFontServerDisp = dispinterface;
 
  { Предварительные объявления: CoClasse'ы }
 
  MyFontServer = IMyFontServer;
 
  { Диспинтерфейс для объекта MyFontServer }
 
  IMyFontServer = interface(IDispatch)
    ['{29C7AC95-0807-11D1-B2BA-0020AFF2F575}']
    function Get_MyFont: IFontDisp; safecall;
    procedure Set_MyFont(const Value: IFontDisp); safecall;
    property MyFont: IFontDisp read Get_MyFont write Set_MyFont;
  end;
 
  { Объявление диспинтерфейса для дуального интерфейса IMyFontServer }
 
  IMyFontServerDisp = dispinterface
    ['{29C7AC95-0807-11D1-B2BA-0020AFF2F575}']
    property MyFont: IFontDisp dispid 1;
  end;
 
  { MyFontServerObject }
 
  CoMyFontServer = class
    class function Create: IMyFontServer;
    class function CreateRemote(const MachineName: string): IMyFontServer;
  end;
 
implementation
 
uses ComObj;
 
class function CoMyFontServer.Create: IMyFontServer;
begin
 
  Result := CreateComObject(Class_MyFontServer) as IMyFontServer;
end;
 
class function CoMyFontServer.CreateRemote(const MachineName: string):
 
IMyFontServer;
begin
 
  Result := CreateRemoteComObject(MachineName, Class_MyFontServer) as
    IMyFontServer;
end;
 
end.
</pre>

<pre>
unit Unit1;
 
interface
 
uses
 
  ComObj, Project1_TLB, ActiveX, Graphics;
 
type
 
  TMyFontServer = class(TAutoObject, IMyFontServer)
  private
    FFont: TFont;
  public
    procedure Initialize; override;
    destructor Destroy; override;
    function Get_MyFont: IFontDisp; safecall;
    procedure Set_MyFont(const Value: IFontDisp); safecall;
  end;
 
implementation
 
uses ComServ, AxCtrls, Unit2;
 
procedure TMyFontServer.Initialize;
begin
 
  inherited Initialize;
  FFont := TFont.Create;
end;
 
destructor TMyFontServer.Destroy;
begin
 
  FFont.Free;
  inherited Destroy;
end;
 
function TMyFontServer.Get_MyFont: IFontDisp;
begin
 
  FFont.Assign(Form2.Label1.Font);
  GetOleFont(FFont, Result);
end;
 
procedure TMyFontServer.Set_MyFont(const Value: IFontDisp);
begin
 
  SetOleFont(FFont, Value);
  Form2.Label1.Font.Assign(FFont);
end;
 
initialization
 
  TAutoObjectFactory.Create(ComServer, TMyFontServer, Class_MyFontServer,
    ciMultiInstance);
end.
</pre>

<pre>
unit Unit2;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls;
 
type
 
  TForm2 = class(TForm)
    Label1: TLabel;
  end;
 
var
 
  Form2: TForm2;
 
implementation
 
{$R *.DFM}
 
end.
</pre>

<pre>
unit FontCli1;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, StdVCL, Project1_TLB;
 
type
 
  TForm1 = class(TForm)
    Button1: TButton;
    Label1: TLabel;
    FontDialog1: TFontDialog;
    procedure Button1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  public
    MyFontServer: IMyFontServer;
  end;
 
var
 
  Form1: TForm1;
 
implementation
 
uses ActiveX, AxCtrls;
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
var
 
  Temp: IFontDisp;
begin
 
  if (FontDialog1.Execute) then
  begin
    Label1.Font.Assign(FontDialog1.Font);
    GetOleFont(Label1.Font, Temp);
    MyFontServer.Set_MyFont(Temp);
  end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 
  MyFontServer := CoMyFontServer.Create;
end;
 
end.
</pre>

<p>Так для чего нам Unit1, создающий реализацию интерфейса? Интерфейс Ole, такой как, например, IFontDisp, может считаться соглашением о том, что свойства и функции будут определены в заданном формате, а функции будут реализованы как определено (для получения дополнительной информации смотри Руководство Разработчика, главу 36, "An Overview of COM" (Обзор COM). Тот факт, что интерфейс определен, не означает, что он реализован. Например, чтобы заставить определенный вами интерфейс IFontDisp быть полезным, необходимо обеспечить хранение шрифта и механизм добавления и извлечения информации об атрибутах шрифта, таких, как имя шрифта, наклонное начертание, размер и пр.</p>
<p class="note">Примечание:</p>
<p>GetOleFont и SetOleFont определены в AxCtrls.pas. IFontDisp определен в ActiveX.pas</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
