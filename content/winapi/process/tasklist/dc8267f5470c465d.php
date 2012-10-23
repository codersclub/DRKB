<h1>Помогите спрятать программу из списка задач</h1>
<div class="date">01.01.2007</div>


<p>Или Как заказать сервисный процесс ?</p>
<pre>
unit Stealth;
 
interface
uses
WinTypes, WinProcs, Classes, Forms, SysUtils, Controls, Messages;
 
type
TStealth = class(TComponent)
private
fHideApp: Boolean;
procedure SetHideApp(Value: Boolean);
protected
{ Protected declarations }
procedure HideApplication;
procedure ShowApplication;
public
{ Public declarations }
constructor Create(AOwner: TComponent); override;
destructor Destroy; override;
// procedure Loaded; override;
published
{ Published declarations }
property HideApp: Boolean read fHideApp write SetHideApp default false;
end;
 
function RegisterServiceProcess(dwProcessID, dwType: Integer): Integer; stdcall; external 'KERNEL32.DLL';
 
procedure Register;
 
implementation
 
destructor TStealth.Destroy;
begin
ShowApplication;
inherited destroy;
end;
 
constructor TStealth.Create(AOwner: TComponent);
begin
inherited Create(AOwner);
// fHideform := true;
end;
 
procedure TStealth.SetHideApp(Value: Boolean);
begin
fHideApp := Value;
if Value then HideApplication else ShowApplication;
end;
 
procedure TStealth.HideApplication;
begin
if not (csDesigning in ComponentState) then
RegisterServiceProcess(GetCurrentProcessID, 1);
end;
 
procedure TStealth.ShowApplication;
begin
if not (csDesigning in ComponentState) then
RegisterServiceProcess(GetCurrentProcessID, 0);
end;
 
procedure Register;
begin
RegisterComponents('My', [TStealth]);
end;
 
end.
</pre>
<div class="author">Автор: Admin</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
