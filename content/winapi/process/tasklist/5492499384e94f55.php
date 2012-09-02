<h1>Disable Ctrl+Alt+Del under Windows XP</h1>
<div class="date">01.01.2007</div>


<pre>
procedure DisableTaskMgr(bTF: Boolean);
var
  reg: TRegistry;
begin
  reg := TRegistry.Create;
  reg.RootKey := HKEY_CURRENT_USER;
 
  reg.OpenKey('Software', True);
  reg.OpenKey('Microsoft', True);
  reg.OpenKey('Windows', True);
  reg.OpenKey('CurrentVersion', True);
  reg.OpenKey('Policies', True);
  reg.OpenKey('System', True);
 
  if bTF = True then
  begin
    reg.WriteString('DisableTaskMgr', '1');
  end
  else if bTF = False then
  begin
    reg.DeleteValue('DisableTaskMgr');
  end;
  reg.CloseKey;
end;
 
// Example Call:
procedure TForm1.Button1Click(Sender: TObject);
begin
  DisableTaskMgr(True);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

