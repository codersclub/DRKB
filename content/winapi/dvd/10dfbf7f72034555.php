<h1>Как загрузить иконку CD-ROM?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetCDIcon(Drive: Char): TIcon; 
var 
  ico: TIcon; 
  ini: TIniFile; 
  s, p: string; 
  i, j: Integer; 
begin 
  //Abbrechen wenn "AutoRun.Inf" nicht existiert. 
  //Abort if "AutoRun.inf" doesn't exists. 
  if FileExists(Drive + ':\autorun.inf') = False then Exit; 
 
  //"AutoRun.inf" offnen 
  //Opens the "AutoRun.inf" 
  ini := TIniFile.Create(Drive + ':\autorun.inf'); 
  ico := TIcon.Create; 
 
  try 
    //Dateinamen lesen 
    //Read the filename 
    s := ini.ReadString('Autorun', 'ICON', ''); 
 
    //Abbrechen, wenn kein Icon festgelegt wurde 
    //Abort if there is no icon specified 
    if s = '' then Exit; 
 
    //Icon von Datei laden 
    //load the icon from a file 
    if FileExists(s) then ico.LoadFromFile(s); 
    if FileExists(Drive + ':\' + s) then ico.LoadFromFile(Drive + ':\' + s); 
 
    //Icon aus einer Resource laden 
    //Load the icon from a Win32 resource 
    if (FileExists(s) = False) and (FileExists(Drive + ':\' + s) = False) then  
    begin 
      for j := (Pos(',', s) + 1) to Length(s) do  
      begin 
        p := p + s[j]; 
      end; 
      i := StrToInt(p); 
      for j := Length(s) downto (Pos(',', s)) do 
        Delete(s, j, Length(s)); 
 
      if FileExists(s) = False then s := Drive + ':\' + s; 
 
      ico.Handle := ExtractIcon(hinstance, PChar(s), i); 
    end; 
 
    Result := ico; 
  finally 
    ini.Free; 
  end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

