<h1>Набор dialup соединения по умолчанию</h1>
<div class="date">01.01.2007</div>


<p>Для w9x, me:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var cmd, par, fil, dir: PChar;
begin
  Cmd := 'open';
  Fil := 'rasdial.exe';
  Par := PChar(edtEntry.Text + ' ' + EdtUser.Text + ' ' + EdtPass.Text);
  Dir := 'C:';
  ShellExecute(Handle, Cmd, Fil, Par, Dir, SW_SHOWMINNOACTIVE);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
var Cmd, Par, Fil, Dir: PChar;
begin
  Cmd := 'open';
  Fil := 'rasdial.exe';
  Par := PChar(EdtEntry.Text + ' /DISCONNECT');
  Dir := 'C:';
  ShellExecute(Handle, Cmd, Fil, Par, Dir, SW_SHOWMINNOACTIVE);
end;
</pre>


<hr />
<pre>
uses Registry, Windows;
 
function DUNDialDefault(Hide: Boolean): Boolean;
var Reg: TRegistry;
  TempResult: Boolean;
  Name, Con: string;
  ASW: Integer;
begin
  with TRegistry.Create do
  try
    RootKey := HKEY_CURRENT_USER;
    if OpenKey('\RemoteAccess', False) then
      begin
        TempResult := True;
        Name := ReadString('Default');
      end
    else
      TempResult := False;
  finally
    Free;
  end;
  if TempResult then
    begin
      if Hide then
        ASW := SW_HIDE
      else
        ASW := SW_SHOWDEFAULT;
      Con := 'rnaui.dll,RnaDial ' + Name;
      ShellExecute(0, nil, 'rundll32.exe', PChar(Con), 'C:\windows\', ASW);
    end; {IF}
  Result := TempResult;
end;
</pre>

<hr />
<p>Для Nt, w2k, XP:</p>
<pre>
Uses ..., WinInet;
 
InternetAutoDial (INTERNET_AUTODIAL_FORCE_ONLINE, Handle);
</pre>

<p>Handle - окно, из которого вызывается функция.</p>

<div class="author">Автор: Song</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

