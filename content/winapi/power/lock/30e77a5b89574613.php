<h1>How to check if the Workstation is locked?</h1>
<div class="date">01.01.2007</div>


<pre>
function IsWorkstationLocked: Boolean;
var
  hDesktop: HDESK;
begin
  Result := False;
  hDesktop := OpenDesktop('default',
    0, False,
    DESKTOP_SWITCHDESKTOP);
  if hDesktop &lt;&gt; 0 then
  begin
    Result := not SwitchDesktop(hDesktop);
    CloseDesktop(hDesktop);
  end;
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
