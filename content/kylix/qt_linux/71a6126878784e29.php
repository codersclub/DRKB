<h1>Как получить имя текущего пользователя?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetCurrentUser: string; 
var 
  pwrec: PPasswordRecord; 
begin 
  pwrec := getpwuid(getuid); 
  Result := pwrec.pw_name; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
