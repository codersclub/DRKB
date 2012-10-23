<h1>Как рисовать на экране</h1>
<div class="date">01.01.2007</div>

Обладая такими способностями, вы сможете, например, разлиновать поверхность экрана как в тетради в клеточку, выводить пугающие пользователя надписи и даже создать эффект окаменение экрана, если, конечно, разработаете алгоритм выполнения данной задачи.</p>
<p>Я покажу как рисовать на экране на примере разлиновки:</p>
<p>Сначала объявите глобальную переменную</p>
<p>Scr: TCanvas;</p>
<p>Затем по событию OnCreate() для формы напишите такой код:</p>
<pre>
Scr := TCanvas.Create;
Scr.Handle := GetDC(HWND_DESKTOP);
 
</pre>
<p>По событию OnDestroy() такой:</p>
<p>Scr.Free;</p>
<p>Обработчик события по нажатию на кнопку пусть выглядит так:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  i: integer;
begin
  i := 0;
  while i &lt; 1024 do
  begin
    with Scr do
    begin
      MoveTo(i, 0);
      LineTo(i, 768);
      i := i + 10;
    end;
  end;
  i := 0;
  while i &lt; 768 do
  begin
    with Scr do
    begin
      MoveTo(0, i);
      LineTo(1024, i);
      i := i + 10;
    end;
  end;
  Button1.Refresh;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Для этого надо воспользоваться функциями API. Получить контекст чужого окна, либо всего экрана:</p>
<p>function GetDC(Wnd: HWnd): HDC;</p>
<p>где Wnd - указатель на нужное окно, или 0 для получения контекста всего экрана. И далее, пользуясь функциями API, нарисовать все что надо.</p>
<pre>
procedure DrawOnScreen;
var
  ScreenDC: hDC;
begin
  ScreenDC := GetDC(0); {получить контекст экрана}
  Ellipse(ScreenDC, 0, 0, 200, 200); {нарисовать}
  ReleaseDC(0, ScreenDC); {освободить контекст}
end;
</pre>
<p>Не забывайте после своих манипуляций посылать пострадавшим (или всем) окнам сообщение о необходимости перерисовки, для восстановления их первоначального вида.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
// Пример рисует две горизонтальные линии на экране используя TDesktopCanvas.
program TrinitronTraining;
 
uses
  Messages, Windows, Graphics, Forms;
 
type
  TDesktopCanvas = class(TCanvas)
  private
    DC : hDC;
    function GetWidth:Integer;
    function GetHeight:Integer;
  public
    constructor Create;
    destructor Destroy; override;
  published
    property Width: Integer read GetWidth;
    property Height: Integer read GetHeight;
end;
 
{ Объект TDesktopCanvas }
function TDesktopCanvas.GetWidth:Integer;
begin
  Result:=GetDeviceCaps(Handle,HORZRES);
end;
 
function TDesktopCanvas.GetHeight:Integer;
begin
  Result:=GetDeviceCaps(Handle,VERTRES);
end;
 
constructor TDesktopCanvas.Create;
begin
  inherited Create;
  DC := GetDC(0);
  Handle := DC;
end;
 
destructor TDesktopCanvas.Destroy;
begin
  Handle := 0;
  ReleaseDC(0, DC);
  inherited Destroy;
end;
 
 
const
  YCount = 2;
 
var
  desktop : TDesktopCanvas;
  dx,dy : Integer;
  i : Integer;
  F : array[1..YCount] of TForm;
 
function CreateLine(Y : Integer) : TForm;
begin
  Result := TForm.Create(Application);
  with Result do begin
    Left := 0;
    Top := y;
    Width := dx;
    Height := 1;
    BorderStyle := bsNone;
    FormStyle := fsStayOnTop;
    Visible := True;
  end;
end;
 
procedure ProcessMessage;
var
  Msg : TMsg;
begin
  if PeekMessage(Msg, 0, 0, 0, PM_REMOVE) then
    if Msg.message = WM_QUIT then
      Application.Terminate;
end;
 
begin
  desktop := TDesktopCanvas.Create;
  try
    dx := desktop.Width;
    dy := desktop.Height div (YCount+1);
  finally
    desktop.free;
  end;
  for i:=1 to YCount do
    F[i]:=CreateLine(i*dy);
  Application.NormalizeTopMosts;
  ShowWindow(Application.Handle, SW_Hide);
 
  for i:=1 to YCount do
    SetWindowPos(F[i].Handle, HWND_TOPMOST, 0,0,0,0, SWP_NOACTIVATE+SWP_NOMOVE+SWP_NOSIZE);
 
  {
  следующие строки используются для того, чтобы не останавливаться
  repeat
  ProcessMessage;
  until false;
  }
  Sleep(15000);
 
  for i:=1 to YCount do
    F[i].Free;
end.
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
