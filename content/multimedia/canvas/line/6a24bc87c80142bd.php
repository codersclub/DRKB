<h1>Как рисовать линии (или еще что-нибудь) на экране (TDesktopCanvas)?</h1>
<div class="date">01.01.2007</div>


<pre>
Пример рисует две горизонтальные линии на экране используя TDesktopCanvas.
} 
program TrinitronTraining; 
 
uses 
  Messages, Windows, Graphics, Forms; 
 
type 
  TDesktopCanvas = class(TCanvas) 
  private 
    DC : hDC; 
    function     GetWidth:Integer; 
    function     GetHeight:Integer; 
  public 
    constructor  Create; 
    destructor   Destroy; override; 
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
 
 
Const 
  YCount    = 2; 
 
Var 
  desktop         : TDesktopCanvas; 
  dx,dy           : Integer; 
  i                : Integer; 
  F                : Array[1..YCount] of TForm; 
 
 
function CreateLine(Y : Integer) : TForm; 
begin 
  Result := TForm.Create(Application); 
  with Result do begin 
    Left      := 0; 
    Top       := y; 
    Width     := dx; 
    Height    := 1; 
    BorderStyle := bsNone; 
    FormStyle   := fsStayOnTop; 
    Visible     := True; 
  end; 
end; 
 
procedure ProcessMessage; 
var 
  Msg     : TMsg; 
begin 
  if PeekMessage(Msg, 0, 0, 0, PM_REMOVE) then 
    if Msg.Message = WM_QUIT then Application.Terminate; 
end; 
 
 
begin 
  desktop := TDesktopCanvas.Create; 
  try 
    dx := desktop.Width; 
    dy := desktop.Height div (YCount+1); 
  finally 
    desktop.free; 
  end; 
  for i:=1 to YCount do F[i]:=CreateLine(i*dy); 
  Application.NormalizeTopMosts; 
  ShowWindow(Application.Handle, SW_Hide); 
 
  for i:=1 to YCount do 
  SetWindowPos(F[i].Handle, HWND_TOPMOST, 0,0,0,0, SWP_NOACTIVATE+SWP_NOMOVE+SWP_NOSIZE); 
 
{ следующие строки используются для того, чтобы не останавливаться
  repeat 
    ProcessMessage; 
  until false; 
{} 
  Sleep(15000); 
 
  for i:=1 to YCount do F[i].Free; 
end.
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

