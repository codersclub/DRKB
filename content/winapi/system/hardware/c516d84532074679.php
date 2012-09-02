<h1>Получение имени конфигурации HardWare profile</h1>
<div class="date">01.01.2007</div>


<pre>
function GettingHWProfileName: string;  //Win95OSR2 or later and NT4.0 or later
var
  pInfo:  tagHW_PROFILE_INFOA;
begin
  GetCurrentHwProfile(pInfo);
  Result:=pInfo.szHwProfileName;
end;
</pre>

