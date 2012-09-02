<h1>Как определить, насколько долго система находится в Idle?</h1>
<div class="date">01.01.2007</div>


<pre>
function LastInput: DWord;
var
  LInput: TLastInputInfo;
begin
  LInput.cbSize := SizeOf(TLastInputInfo);
  GetLastInputInfo(LInput);
  Result := GetTickCount - LInput.dwTime;
end;
 
 
//Example:
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  Label1.Caption := Format('System Idle since %d ms', [LastInput]);
end;
 
 
// The GetLastInputInfo function retrieves the time
// of the last input event.
// Minimum operating systems: Windows 2000
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
