<h1>Как открыть CD-ROM, если их несколько в системе?</h1>
<div class="date">01.01.2007</div>


<pre>
// DriveTools 1.0                                                               *
//                 (c) 1999 Jan Peter Stotz                                     *
// If you find bugs, has ideas for missing featurs, feel free to contact me     *
//                           jpstotz@gmx.de                                     *
// Date last modified:   May 22, 1999                                           *
 
unit DriveTools;
 
interface
 
uses
 
  Windows, SysUtils, MMSystem;
 
function CloseCD(Drive: Char): Boolean;
function OpenCD(Drive: Char): Boolean;
 
implementation
 
function OpenCD(Drive: Char): Boolean;
var
 
  Res: MciError;
  OpenParm: TMCI_Open_Parms;
  Flags: DWord;
  S: string;
  DeviceID: Word;
begin
 
  Result := false;
  S := Drive + ':';
  Flags := mci_Open_Type or mci_Open_Element;
  with OpenParm do
  begin
    dwCallback := 0;
    lpstrDeviceType := 'CDAudio';
    lpstrElementName := PChar(S);
  end;
  Res := mciSendCommand(0, mci_Open, Flags, Longint(@OpenParm));
  if Res &lt;&gt; 0 then
    exit;
  DeviceID := OpenParm.wDeviceID;
  try
    Res := mciSendCommand(DeviceID, MCI_SET, MCI_SET_DOOR_OPEN, 0);
    if Res = 0 then
      exit;
    Result := True;
  finally
    mciSendCommand(DeviceID, mci_Close, Flags, Longint(@OpenParm));
  end;
end;
 
function CloseCD(Drive: Char): Boolean;
var
 
  Res: MciError;
  OpenParm: TMCI_Open_Parms;
  Flags: DWord;
  S: string;
  DeviceID: Word;
begin
 
  Result := false;
  S := Drive + ':';
  Flags := mci_Open_Type or mci_Open_Element;
  with OpenParm do
  begin
    dwCallback := 0;
    lpstrDeviceType := 'CDAudio';
    lpstrElementName := PChar(S);
  end;
  Res := mciSendCommand(0, mci_Open, Flags, Longint(@OpenParm));
  if Res &lt;&gt; 0 then
    exit;
  DeviceID := OpenParm.wDeviceID;
  try
    Res := mciSendCommand(DeviceID, MCI_SET, MCI_SET_DOOR_CLOSED, 0);
    if Res = 0 then
      exit;
    Result := True;
  finally
    mciSendCommand(DeviceID, mci_Close, Flags, Longint(@OpenParm));
  end;
end;
 
end.
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

