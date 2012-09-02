<h1>Как проверить, не запущена ли Terminal Client Session?</h1>
<div class="date">01.01.2007</div>


<pre>
function IsRemoteSession: Boolean;
const
  sm_RemoteSession = $1000; { from WinUser.h }
begin
  Result := GetSystemMetrics(sm_RemoteSession) &lt;&gt; 0;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
