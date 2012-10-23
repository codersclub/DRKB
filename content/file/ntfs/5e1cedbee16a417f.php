<h1>Права доступа NTFS</h1>
<div class="date">01.01.2007</div>


<pre>
uses ..., Aclapi, AccCtrl;
 
 
function SetFileAccessRights(AFile, AUser: String; AMask: DWORD): Boolean;
var
  psd             : PSECURITY_DESCRIPTOR;
  dwSize, dwError : DWord;
  bDaclPresent    : Bool;
  bDaclDefaulted  : Bool;
  OldAcl          : PACL;
  NewAcl          : PACL;
  sd              : SECURITY_DESCRIPTOR;
  ea              : EXPLICIT_ACCESS;
begin
  Result := False;
  if WIN32Platform &lt;&gt; VER_PLATFORM_WIN32_NT then Exit;
  psd := nil;
  NewAcl := nil;
  bDaclDefaulted := True;
  if not GetFileSecurity(PChar(AFile), DACL_SECURITY_INFORMATION, Pointer(1),
           0, dwSize) and (GetLastError = ERROR_INSUFFICIENT_BUFFER) 
  then 
  try
    psd := HeapAlloc(GetProcessHeap, 8, dwSize);
    if psd &lt;&gt; nil then 
    begin
      BuildExplicitAccessWithName(@ea, PChar(AUser), AMask,
        SET_ACCESS, SUB_CONTAINERS_AND_OBJECTS_INHERIT{NO_INHERITANCE});
      Result := GetFileSecurity(PChar(AFile), DACL_SECURITY_INFORMATION, psd, dwSize, dwSize) and
        GetSecurityDescriptorDacl(psd, bDaclPresent, OldAcl, bDaclDefaulted) and
        (SetEntriesInAcl(1, @ea, OldAcl, NewAcl) = ERROR_SUCCESS) and
        InitializeSecurityDescriptor(@sd, SECURITY_DESCRIPTOR_REVISION) and
        SetSecurityDescriptorDacl(@sd, True, NewAcl, False) and
        SetFileSecurity(PChar(AFile), DACL_SECURITY_INFORMATION, @sd);
    end;
  finally  
    if NewAcl &lt;&gt; nil then LocalFree(HLocal(NewAcl));
    if psd &lt;&gt; nil then HeapFree(GetProcessHeap, 0, psd);    
  end;
end;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
&nbsp;<br>
Параметры: путь к объекту, имя пользователя, маска доступа, ее расчитываешь вот так:<br>
http://msdn.microsoft.com/library/default....access_mask.asp<br>
&nbsp;<br>
<p>&nbsp;</p>
<div class="author">Автор: Александр (Rouse_) Багель</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a><br>

