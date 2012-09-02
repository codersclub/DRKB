<h1>Получение количества установленных процессоров</h1>
<div class="date">01.01.2007</div>


<pre>
function GettingProcNum: string;  //Win95 or later and NT3.1 or later
var
  Struc:    _SYSTEM_INFO;
begin
  GetSystemInfo(Struc);
  Result:=IntToStr(Struc.dwNumberOfProcessors);
end;
</pre>

