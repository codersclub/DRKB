<h1>Как выгрузить DLL из памяти?</h1>
<div class="date">01.01.2007</div>


<pre>
function KillDll(aDllName: string): Boolean;
var
  hDLL: THandle;
  aName: array[0..10] of char;
  FoundDLL: Boolean;
begin
  StrPCopy(aName, aDllName);
  FoundDLL := False;
  repeat
    hDLL := GetModuleHandle(aName);
    if hDLL = 0 then
      Break;
    FoundDLL := True;
    FreeLibrary(hDLL);
  until False;
  if FoundDLL then
    MessageDlg('Success!', mtInformation, [mbOK], 0)
  else
    MessageDlg('DLL not found!', mtInformation, [mbOK], 0);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
