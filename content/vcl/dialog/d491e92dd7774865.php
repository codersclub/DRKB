<h1>Как открыть диалог создания ярлыка?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  registry, shellapi; 
 
function Launch_CreateShortCut_Dialog(Directory: string): Boolean; 
var 
  reg: TRegistry; 
  cmd: string; 
begin 
  Result := False; 
  reg    := TRegistry.Create; 
  try 
    reg.Rootkey := HKEY_CLASSES_ROOT; 
    if reg.OpenKeyReadOnly('.LNK\ShellNew') then 
    begin 
      cmd    := reg.ReadString('Command'); 
      cmd    := StringReplace(cmd, '%1', Directory, []); 
      Result := True; 
      WinExec(PChar(cmd), SW_SHOWNORMAL); 
    end 
  finally 
    reg.Free; 
  end; 
end; 
 
{Example} 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Launch_CreateShortCut_Dialog('c:\temp'); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
