<h1>How to check, if a CD-Recorder is available? (WinXP)</h1>
<div class="date">01.01.2007</div>


<pre>
{....}
 
uses Registry;
 
{....}
 
function HasCDRecorder: Boolean;
var
  reg: TRegistry;
begin
  reg := TRegistry.Create;
  try
    // set the the Mainkey, 
    reg.RootKey := HKEY_CURRENT_USER;
    // Open a key
    reg.OpenKey('Software\Microsoft\Windows\CurrentVersion\Explorer\CD Burning', False);
    // Check if the Key exists
    Result := reg.ValueExists('CD Recorder Drive');
    // Close the key
    reg.CloseKey;
  finally
    // and free the TRegistry Object
    reg.Free;
  end;
end;
 
// Example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  if HasCDRecorder then
    ShowMessage('CD-Recorder available.')
  else
    ShowMessage('CD-Recorder NOT available.');
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
