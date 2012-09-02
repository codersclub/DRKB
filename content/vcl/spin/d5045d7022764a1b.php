<h1>Элемент управления TEdit, реагирующий на событие OnTimer</h1>
<div class="date">01.01.2007</div>


<p>Как-то раз встала такая проблема: если пользователь какое-то время ничего не вводит в элемент управления Edit, то предупредить его об этом.</p>
<pre>
unit EditOnTime; 
 
interface 
 
uses 
Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, ExtCtrls, StdCtrls; 
 
type 
TEditOnTime = class(TEdit) 
private 
  FInterval: integer; 
  FTimer: TTimer; 
  FOnTimer: TNotifyEvent; 
  procedure SetInterval(Interval: integer); 
  procedure Timer(Sender: TObject); 
protected 
  procedure KeyPress(var Key: char); override; 
public 
  constructor Create(AOwner: TComponent); override; 
  destructor Destroy; override; 
published 
  property Interval: integer read FInterval write SetInterval default 750; 
property OnTimer: TNotifyEvent read FOnTimer write FOnTimer; 
end; 
 
procedure Register; 
 
implementation 
 
//******************* RegisterComponent 
// Здесь мы регистрируем компонент в IDE 
procedure Register; 
begin 
RegisterComponents('MPS', [TEditOnTime]); 
end; 
 
//******************* TEditOnTime.SetInterval 
// устанавливаем интервал таймера 
procedure TEditOnTime.SetInterval(Interval: integer); 
begin 
FInterval := Interval; 
if Assigned(FTimer) then 
  FTimer.Interval := FInterval; 
end; 
 
//******************* TEditOnTime.Create 
constructor TEditOnTime.Create(AOwner: TComponent); 
begin 
FInterval := 750; 
inherited Create(AOwner); 
if not (csDesigning in ComponentState) then 
  try 
   FTimer := TTimer.Create(self); 
   FTimer.Enabled := false; 
   FTimer.Interval := FInterval; 
   FTimer.OnTimer := Timer; 
  except 
   FreeAndNil(FTimer); 
  end; 
end; 
 
//******************* TEditOnTime.Destroy 
destructor TEditOnTime.Destroy; 
begin 
if Assigned(FTimer) then FreeAndNil(FTimer); 
inherited Destroy; 
end; 
 
//******************* TEditOnTime.OnTimer 
procedure TEditOnTime.Timer(Sender: TObject); 
begin 
FTimer.Enabled := false; 
if Assigned(FOnTimer) then FOnTimer(self); 
end; 
 
//******************* TEditOnTime.KeyPress 
procedure TEditOnTime.KeyPress(var Key: char); 
begin 
FTimer.Enabled := false; 
inherited KeyPress(Key); 
FTimer.Enabled := (Text &lt;&gt; '') and Assigned(FTimer) and Assigned(FOnTimer); 
end; 
 
end.
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

