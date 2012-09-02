<h1>Запущен ли Softice?</h1>
<div class="date">01.01.2007</div>


<pre>
//SoftIce in W9x
 
function IsSoftIce95Loaded: boolean;
var
  hFile: Thandle;
begin
  result := false;
  hFile := CreateFileA('\.SICE', GENERIC_READ or GENERIC_WRITE,
    FILE_SHARE_READ or FILE_SHARE_WRITE, nil, OPEN_EXISTING,
    FILE_ATTRIBUTE_NORMAL, 0);
  if (hFile &lt;&gt; INVALID_HANDLE_VALUE) then
  begin
    CloseHandle(hFile);
    result := TRUE;
  end;
end;
// SoftIce in NT OS
 
function IsSoftIceNTLoaded: boolean;
var
  hFile: Thandle;
begin
  result := false;
  hFile := CreateFileA('\.NTICE', GENERIC_READ or GENERIC_WRITE,
    FILE_SHARE_READ or FILE_SHARE_WRITE, nil, OPEN_EXISTING,
    FILE_ATTRIBUTE_NORMAL, 0);
  if (hFile &lt;&gt; INVALID_HANDLE_VALUE) then
  begin
    CloseHandle(hFile);
    result := TRUE;
  end;
end;
//to detect it
if IsSoftIce95Loaded or IsSoftIceNTLoaded then
  Application.Terminate
    {if you insert a "Nag" (Message telling him he uses SoftIce) then a amatuer cracker w'll find this protection in notime}
  //bestway of using this thing is in "project Unit"
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
