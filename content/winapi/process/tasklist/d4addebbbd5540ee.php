<h1>Как получить список процессов?</h1>
<div class="date">01.01.2007</div>


<pre>
function IsRunning( sName : string ) : boolean; 
var 
  han : THandle; 
  ProcStruct : PROCESSENTRY32; // from "tlhelp32" in uses clause 
  sID : string; 
begin 
  Result := false; 
  // Get a snapshot of the system 
  han := CreateToolhelp32Snapshot( TH32CS_SNAPALL, 0 ); 
  if han = 0 then 
    exit; 
  // Loop thru the processes until we find it or hit the end 
  ProcStruct.dwSize := sizeof( PROCESSENTRY32 ); 
  if Process32First( han, ProcStruct ) then 
    begin 
      repeat 
        sID := ExtractFileName( ProcStruct.szExeFile ); 
        // Check only against the portion of the name supplied, ignoring case 
        if uppercase( copy( sId, 1, length( sName ) ) ) = uppercase( sName ) then 
          begin 
            // Report we found it 
            Result := true; 
            Break; 
          end; 
      until not Process32Next( han, ProcStruct ); 
    end; 
  // clean-up 
  CloseHandle( han ); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


