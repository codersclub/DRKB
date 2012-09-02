<h1>Как инсталлировать INF файл?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ShellAPI; 
 
function InstallINF(const PathName: string; hParent: HWND): Boolean; 
var 
  instance: HINST; 
begin 
  instance := ShellExecute(hParent, 
    PChar('open'), 
    PChar('rundll32.exe'), 
    PChar('setupapi,InstallHinfSection DefaultInstall 132 ' + PathName), 
    nil, 
    SW_HIDE); 
 
  Result := instance &gt; 32; 
end; { InstallINF } 
 
// Example: 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  InstallINF('C:\XYZ.inf', 0); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
