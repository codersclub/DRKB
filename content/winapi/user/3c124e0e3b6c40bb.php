<h1>Запуск процесса в контексте другого пользователя</h1>
<div class="date">01.01.2007</div>



<pre>
uses
  JwaWinBase; ( http://members.chello.nl/m.vanbrakel2/ )
 
//...
 
procedure TForm1.Button1Click(Sender: TObject);
var 
  si: STARTUPINFOW; 
  pif: PROCESS_INFORMATION; 
  res: Bool;
  s: string;
begin
  //set StartUpInfoW first
  si.cb := SizeOf(startupinfow);
  si.dwFlags  := STARTF_USESHOWWINDOW;
  si.wShowWindow := SW_SHOWDEFAULT;
  si.lpReserved := nil;
  si.lpDesktop := nil;
  si.lpTitle := 'Konsole';
  // run CreateProcessWithLogonW...
  res := CreateProcessWithLogonW('Security', 'ArViCor', 'test', LOGON_WITH_PROFILE,
    'c:\win2kas\system32\regedt32.exe', nil
    , CREATE_DEFAULT_ERROR_MODE, nil, nil, si, pif);
  if booltostr(res) = '0' then 
  begin
 
    //if an error occures, show the error-code
    //this code can be 'translated' with 'net helpmsg ' on command-prompt
    str(GetLastError, s);
    ShowMessage('CreateProcessWithLogonResult: ' + booltostr(res) + #10 +
      'GetLastError: ' + s);
  end;
end;
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
