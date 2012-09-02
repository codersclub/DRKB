<h1>Указатель на функцию</h1>
<div class="date">01.01.2007</div>

Это то, что я нашел при создании простой машины состояний: </p>
<p>Ниже приведен простой пример для Borland Delphi, использующий указатели функций для управления программным потоком. Просто создайте простую форму с единственной кнопкой и скопируйте код из Unit1 во вновь созданный модуль. Добавьте к проекту Unit2 и скомпилируйте проект. Дайте мне знать, если у вас возникнут какие-либо проблемы.</p>
<pre>interface
 
uses
 
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls;
 
type
 
  TForm1 = class(TForm)
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
 
  Form1: TForm1;
  CurrProc: LongInt;
  MyVal: LongInt;
 
implementation
 
uses Unit2;
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
var
 
  NewProc: LongInt;
  MyString: string;
begin
 
  CurrProc := 2; { начальная точка в таблице методов }
  MyVal := 0; { вспомогательная переменная }
  NewProc := 0;
    { возвращаемое значение для следующего индекса в таблице методов }
  while CurrProc &lt; 6 do
  begin
    { выполняем текущий индекс в таблице методов и получаем следующую процедуру }
    NewProc := ProcTable[CurrProc](MyVal);
 
    { просто показываем значения NewProc и CurrProc }
    FmtStr(MyString, 'NewProc [%d] CurrProc [%d]', [NewProc, CurrProc]);
    MessageDlg(MyString, mtInformation, [mbOK], 0);
 
    { присваиваем текущую процедуру возвращаемой процедуре }
    CurrProc := NewProc;
  end;
 
end;
 
end.
</pre>

<pre>
{ Это простой пример, определяющий массив указателей на функции }
 
interface
 
type
 
  { определяем Procs как функцию }
  Procs = function(var ProcNum: LongInt): LongInt;
 
var
 
  { объявляем массив указателей на функции }
  ProcTable: array[1..5] of Procs;
 
  { определения интерфейсов функций }
function Proc1(var MyVal: LongInt): LongInt; far;
function Proc2(var MyVal: LongInt): LongInt; far;
function Proc3(var MyVal: LongInt): LongInt; far;
function Proc4(var MyVal: LongInt): LongInt; far;
function Proc5(var MyVal: LongInt): LongInt; far;
 
implementation
 
uses Dialogs;
 
function Proc1(var MyVal: LongInt): LongInt;
begin
 
  MessageDlg('Процедура 1', mtInformation, [mbOK], 0);
  Proc1 := 6;
end;
 
function Proc2(var MyVal: LongInt): LongInt;
begin
 
  MessageDlg('Процедура 2', mtInformation, [mbOK], 0);
  Proc2 := 3;
end;
 
function Proc3(var MyVal: LongInt): LongInt;
begin
 
  MessageDlg('Процедура 3', mtInformation, [mbOK], 0);
  Proc3 := 4;
end;
 
function Proc4(var MyVal: LongInt): LongInt;
begin
 
  MessageDlg('Процедура 4', mtInformation, [mbOK], 0);
  Proc4 := 5;
end;
 
function Proc5(var MyVal: LongInt): LongInt;
begin
 
  MessageDlg('Процедура 5', mtInformation, [mbOK], 0);
  Proc5 := 1;
end;
 
initialization
 
  { инициализируем содержание массива указателей на функции }
  @ProcTable[1] := @Proc1;
  @ProcTable[2] := @Proc2;
  @ProcTable[3] := @Proc3;
  @ProcTable[4] := @Proc4;
  @ProcTable[5] := @Proc5;
 
end.
</pre>
<p>Я думаю это можно сделать приблизительно так: объявите в каждой форме процедуры, обрабатывающие нажатие кнопки, типа процедуры CutButtonPressed(Sender:TObject) of Object; затем просто назначьте события кнопок OnClick этим процедурам при наступлении событий форм OnActivate. Этот способ соответствует концепции ОО-программирования, но если вам не нравится это, то вы все еще можете воспользоваться указателями функций, которая предоставляет Delphi. </p>
<p>Объявите базовый класс формы с объявлениями абстрактных функций для каждой функции, которую вы хотите вызывать из вашего toolbar. Затем наследуйте каждую вашу форму от базового класса формы и создайте определения этих функций. </p>
<p>Пример: (Здесь может встретиться пара синтаксических ошибок - я не компилил это)</p>
<pre>type
  TBaseForm = class(TForm)
  public
    procedure Method1; virtual; abstract;
  end;
 
type
  TDerivedForm1 = class(TBaseForm)
  public
    procedure Method1; override;
  end;
 
  TDerivedForm2 = class(TBaseForm)
  public
    procedure Method1; override;
  end;
 
procedure TDerivedForm1.Method1;
begin
  ....
end;
 
procedure TDerivedForm2.Method1;
begin
  ....
end;
 
{Для вызова функции из вашего toolbar,
получите активную в настоящий момент форму и вызовите Method1}
 
procedure OnButtonClick;
var
  AForm: TBaseForm;
begin
  AForm := ActiveForm as TBaseForm;
  AForm.Method1;
end;
 
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>

