<h1>HKey &gt; String</h1>
<div class="date">01.01.2007</div>


<pre>
const
  HKEYNames: array[0..6] of string =
    ('HKEY_CLASSES_ROOT', 
     'HKEY_CURRENT_USER', 
     'HKEY_LOCAL_MACHINE',      
     'HKEY_USERS',
     'HKEY_PERFORMANCE_DATA', 
     'HKEY_CURRENT_CONFIG', 
     'HKEY_DYN_DATA');
 
function HKEYToStr(const Key: HKEY): string;
begin
  if (key &lt; HKEY_CLASSES_ROOT) or (key &gt; HKEY_CLASSES_ROOT+6) then
    Result := ''
  else
    Result := HKEYNames[key - HKEY_CLASSES_ROOT];
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
