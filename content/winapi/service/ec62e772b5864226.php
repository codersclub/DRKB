<h1>How immediately start a service after it's installation?</h1>
<div class="date">01.01.2007</div>


<pre>
{ To automatically start a service after its installation use this code }
 
procedure TMyService.ServiceAfterInstall(Sender: TService);
var
  sm: TServiceManager;
begin
  sm := TServiceManager.Create;
  try
    if sm.Connect then
      if sm.OpenServiceConnection(self.name) then
        sm.StartService;
  finally
    sm.Free;
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
