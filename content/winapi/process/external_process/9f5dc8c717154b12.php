<h1>Пример EnumWindows</h1>
<div class="date">01.01.2007</div>


<p>Создайте форму и разместите на ней два компонента ListBox.</p>
<p>Скопируйте код, показанный ниже.</p>
<p>Запустите SysEdit.</p>
<p>Запустите форму Delphi. Первый ListBox должен содержать список всех запущенных приложений. Дважды щелкните на SysEdit и нижний ListBox покажет дочернее MDI-окно программы SysEdit.</p>
<p>Paul Powers (Borland)</p>
<pre>
unit Wintask1;
 
 
interface
 
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls;
 
 
type
  TForm1 = class(TForm)
    ListBox1: TListBox;
    ListBox2: TListBox;
    procedure FormCreate(Sender: TObject);
    procedure ListBox1DblClick(Sender: TObject);
  private
    function enumListOfTasks(hWindow: hWnd): Bool; export;
    function enumListOfChildTasks(hWindow: hWnd): Bool; export;
  end;
 
 
  THoldhWnd = class(TObject)
  private
  public
    hWindow: hWnd;
  end;
 
 
var
  Form1: TForm1;
 
 
implementation
 
 
{$R *.DFM}
 
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  enumWindows(@TForm1.EnumListOfTasks, Longint(Self));
  if (ListBox1.Items.Count &gt; 0) then
    ListBox1.ItemIndex := 0;
end;
 
 
function TForm1.enumListOfTasks(hWindow: hWnd): Bool;
var
  HoldString: PChar;
  WindowStyle: Longint;
  IsAChild: Word;
  HoldhWnd: THoldhWnd;
 
 
begin
  GetMem(HoldString, 256);
 
 
  HoldhWnd := THoldhWnd.Create;
  HoldhWnd.hWindow := hWindow;
 
 
  WindowStyle := GetWindowLong(hWindow, GWL_STYLE);
  WindowStyle := WindowStyle and Longint(WS_VISIBLE);
  IsAChild := GetWindowWord(hWindow, GWW_HWNDPARENT);
 
 
 
{Добавляем строку с текстом задачи или именем класса и дескриптор в ListBox1.Items }
  if (GetWindowText(hWindow, HoldString, 255) &gt; 0) and
    (WindowStyle &gt; 0) and (IsAChild = Word(nil)) then
    ListBox1.Items.AddObject(StrPas(HoldString), TObject(HoldhWnd))
  else if (GetClassName(hWindow, HoldString, 255) &gt; 0) and
    (WindowStyle &gt; 0) and (IsAChild = Word(nil)) then
    ListBox1.Items.AddObject(Concat('&lt;', StrPas(HoldString), '&gt;'), TObject(HoldhWnd));
 
 
  FreeMem(HoldString, 256);
  HoldhWnd := nil;
  Result := TRUE;
end;
 
 
function TForm1.enumListOfChildTasks(hWindow: hWnd): Bool;
var
  HoldString: PChar;
  WindowStyle: Longint;
  IsAChild: Word;
  HoldhWnd: THoldhWnd;
 
 
begin
  GetMem(HoldString, 256);
 
 
  HoldhWnd := THoldhWnd.Create;
  HoldhWnd.hWindow := hWindow;
 
 
  WindowStyle := GetWindowLong(hWindow, GWL_STYLE);
  WindowStyle := WindowStyle and Longint(WS_VISIBLE);
  IsAChild := GetWindowWord(hWindow, GWW_HWNDPARENT);
 
 
{Добавляем строку с текстом задачи или именем класса и дескриптор в ListBox1.Items }
  if (GetWindowText(hWindow, HoldString, 255) &gt; 0) and
    (WindowStyle &gt; 0) and (IsAChild &lt;&gt; Word(nil)) then
    ListBox2.Items.AddObject(StrPas(HoldString), TObject(HoldhWnd))
  else if (GetClassName(hWindow, HoldString, 255) &gt; 0) and
    (WindowStyle &gt; 0) and (IsAChild = Word(nil)) then
    ListBox2.Items.AddObject(Concat('&lt;', StrPas(HoldString), '&gt;'), TObject(HoldhWnd));
 
 
  FreeMem(HoldString, 256);
  HoldhWnd := nil;
  Result := TRUE;
end;
 
 
procedure TForm1.ListBox1DblClick(Sender: TObject);
begin
 
  enumChildWindows(THoldhWnd(ListBox1.Items.Objects[ListBox1.ItemIndex]).hWindow, @TForm1.enumListOfChildTasks, Longint(Self));
 
  ListBox2.RePaint;
end;
 
 
end.
</pre>

<p>Дополнение</p>

<p>В Kuliba1000.chm Win32 API/Разное/Пример EnumWindows есть принципиальная ошибка в коде:</p>

<p>ЛЮБАЯ callback ( обратного вызова ) функция в Delphi должна сопровождаться директивой stdcall.</p>

<p>Предоставленный пример просто не работает.</p>

<p>Определение класса формы должно выглядеть как-то так:</p>

<pre>
 
type
  TForm1 = class(TForm)
    ListBox1: TListBox;
    ListBox2: TListBox;
    procedure FormCreate(Sender: TObject);
    procedure ListBox1DblClick(Sender: TObject);
  private
    function enumListOfTasks(hWindow: hWnd): Bool; stdcall;
    function enumListOfChildTasks(hWindow: hWnd): Bool; stdcall;
  end;
</pre>

<p>Директивы export (это написано в Help'е) просто не работают (игнорируются) под Win 32 :(</p>

<p>С наилучшими пожеданиями</p>
<p>Андрей Бреслав</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

