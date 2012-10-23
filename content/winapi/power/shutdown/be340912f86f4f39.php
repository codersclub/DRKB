<h1>Закрытие програм при LogOff / Shutdown</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;

 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs;
 
type
  TForm1 = class(TForm)
    procedure FormCreate(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  private
    FSystemShutdown: Boolean;
    procedure WMQueryEndSession(var Message: TWMQueryEndSession); message WM_QUERYENDSESSION;
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
function SetPrivilege(PrivilegeName: String; AEnabled: Boolean): Boolean;
var
  TPPrev, TP: TTokenPrivileges;
  Token: THandle;
  dwRetLen: DWORD;
begin
  Result := False;
  if OpenProcessToken(GetCurrentProcess,
    TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, Token) then
  try
    if LookupPrivilegeValue(nil, PChar(PrivilegeName),TP.Privileges[0].LUID) then
    begin
      TP.PrivilegeCount := 1;
      if AEnabled then
        TP.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED
      else
        TP.Privileges[0].Attributes := 0;
      dwRetLen := 0;
      Result := AdjustTokenPrivileges(Token, False, TP,
        SizeOf(TPPrev), TPPrev, dwRetLen);
    end;
  finally
    CloseHandle(Token);
  end
  else
    RaiseLastOSError;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
const
  SE_SHUTDOWN_NAME = 'SeShutdownPrivilege';
begin
  FSystemShutdown := False;
  if not SetPrivilege(SE_SHUTDOWN_NAME, True) then
    RaiseLastOSError;
end;
 
procedure TForm1.WMQueryEndSession(var Message: TWMQueryEndSession);
begin
  inherited;
  Message.Result := 0;
  AbortSystemShutdown(nil);
  FSystemShutdown := True;
  Close;
end;
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  ShowMessage('Bla...bla...bla!');
  if FSystemShutdown then
    InitiateSystemShutdown(nil, nil, 0, True, False);
end;
 
end.
</pre>
<div class="author">Автор: Александр (Rouse_) Багель</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
