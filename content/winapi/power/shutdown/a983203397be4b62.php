<h1>Как узнать заряженность батарей?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  SysPowerStatus: TSystemPowerStatus;
begin
  GetSystemPowerStatus(SysPowerStatus);
  if Boolean(SysPowerStatus.ACLineStatus) then
  begin
    ShowMessage('System running on AC.');
  end
  else
  begin
    ShowMessage('System running on battery.');
    ShowMessage(Format('Battery power left: %d percent.', [SysPowerStatus.BatteryLifePercent]));
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
