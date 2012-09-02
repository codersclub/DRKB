<h1>Собираем тестовый пример</h1>
<div class="date">01.01.2007</div>


<p>Теперь, давайте соберем код. Прошу учесть, что практически не делается никаких проверок - это демонстрационный код. Но работающий.</p>
<p>В начале код dll c объектом.</p>
<pre>
library CalcDll;
 
uses
  SysUtils,
  Classes;
 
type
 
 HResult=Longint;
 
 ICalcBase=interface                      //чисто абстрактный интерфейс
   procedure SetOperands(x,y:integer);
   procedure Release;
 end;
 
 ICalc=interface(ICalcBase)
   ['{149D0FC0-43FE-11D6-A1F0-444553540000}']
   function Sum:integer;
   function Diff:integer;
 end;
 
 ICalc2=interface(ICalcBase)
   ['{D79C6DC0-44B9-11D6-A1F0-444553540000}']
   function Mult:integer;
   function Divide:integer;
 end;
 
 MyCalc=class(TObject,ICalc,ICalc2)  //два интерфейса
   fx,fy:integer;
 public
   procedure SetOperands(x,y:integer);
   function Sum:integer;
   function Diff:integer;
   function Divide:integer;
   function Mult:integer;
   procedure Release;
   function QueryInterface(const IID: TGUID; out Obj): HResult; stdcall;
   function _AddRef:Longint; stdcall;
   function _Release:Longint; stdcall;
 end;
 
const
 S_OK = 0;
 E_NOINTERFACE = HRESULT($80004002);
 
procedure MyCalc.SetOperands(x,y:integer);
begin
 fx:=x; fy:=y;
end;
 
function MyCalc.Sum:integer;
begin
  result:=fx+fy;
end;
 
function MyCalc.Diff:integer;
begin
  result:=fx-fy;
end;
 
function MyCalc.Divide:integer;
begin
  result:=fx div fy;
end;
 
function MyCalc.Mult:integer;
begin
  result:=fx*fy;
end;
 
procedure MyCalc.Release;
begin
 Free;
end;
 
function MyCalc.QueryInterface(const IID: TGUID; out Obj): HResult;
begin
  if GetInterface(IID, Obj) then
    Result := S_OK
  else
    Result := E_NOINTERFACE;
end;
 
function MyCalc._AddRef;
begin
end;
 
function MyCalc._Release;
begin
end;
 
procedure CreateObject(const IID: TGUID; var ACalc);
var
 Calc:MyCalc;
begin
 Calc:=MyCalc.Create;
 if not Calc.GetInterface(IID,ACalc) then
  Calc.Free;
end;
 
exports
 CreateObject;
 
begin
end.
</pre>
<p>А теперь тестер.</p>
<pre>
unit tstcl;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls,ComObj;
 
type
 
 //обратите внимание! Используем один унифицированный интерфейс
  IUniCalc=interface   
    procedure SetOperands(x,y:integer);
    procedure Release;
    function Sum:integer;
    function Diff:integer;
  end;
 
  TForm1 = class(TForm)
    Button1: TButton;
    Button2: TButton;
    Button3: TButton;
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure Button3Click(Sender: TObject);
  end;
 
var
  Form1: TForm1;
  _Mod:Integer;  //хэндл модуля
  СreateObject:procedure (IID:TGUID; out Obj); //процедура из dll.
 
  Calc:IUniCalc;        //это указатель на интерфейс котрый мы будем получать
  ICalcGUID:TGUID;   
  ICalc2GUID:TGUID; 
  flag:boolean;         // какой интерфейс активный.
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  _Mod:=LoadLibrary(PChar('C:\Kir\COM\SymplDll\CalcDll.dll'));
 
  //Эти GUID я просто скопировал из исходника CalcDll.dll
  ICalcGUID:=StringToGUID('{149D0FC0-43FE-11D6-A1F0-444553540000}');
  ICalc2GUID:=StringToGUID('{D79C6DC0-44B9-11D6-A1F0-444553540000}');
  flag:=true;
 
  СreateObject:=GetProcAddress(_Mod,'CreateObject');
 
  СreateObject(ICalcGUID,Calc);
  if Calc&lt;&gt;nil then
    Calc.SetOperands(10,5);
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  if Calc&lt;&gt;nil then
   Calc.Release;
  FreeLibrary(_Mod);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
   ShowMessage(IntToStr(Calc.diff));
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
   ShowMessage(IntToStr(Calc.Sum));
end;
 
procedure TForm1.Button3Click(Sender: TObject);
var
   tmpCalc:IUniCalc;
begin
   if flag then
     Calc.QueryInterface(ICalc2GUID,tmpCalc)
   else
     Calc.QueryInterface(ICalcGUID,tmpCalc);
   flag:=not flag;  
   Calc:=tmpCalc;
end;
 
end.
</pre>

<p>Обратите вснимание, что происходит при нажатии на кнопку3. Мы используем ту же самую переменную, для работы со вторым интерфейсом! Этот пример показывает, что получая указатель на интерфейс, его методы мы получаем за счет смещения, от адреса который этот указатель содержит. Короче, мы получаем адрес таблицы методов.</p>
<p>Потыкайте, посмотрите что происходит.</p>
