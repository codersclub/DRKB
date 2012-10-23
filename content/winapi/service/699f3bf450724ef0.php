<h1>Как получить список загруженных драйверов?</h1>
<div class="date">01.01.2007</div>


<pre>
{
  This code takes advantage of the undocumented NtQuerySystemInformation
  API to obtain a list of loaded drivers under Windows NT.
}
 
const
  DRIVER_INFORMATION = 11;
 
type
  TPDWord = ^DWORD;
 
  TDriverInfo = packed record
    Address: Pointer;
    Unknown1: DWORD;
    Unknown2: DWORD;
    EntryIndex: DWORD;
    Unknown4: DWORD;
    Name: array [0..MAX_PATH + 3] of Char;
  end;
 
var
  NtQuerySystemInformation: function (infoClass: DWORD;
  buffer: Pointer;
  bufSize: DWORD;
  returnSize: TPDword): DWORD; stdcall = nil;
 
  function GetDriverInfo: string;
  var 
    temp, Index, numBytes, numEntries: DWORD;
    buf: TPDword;
    driverInfo: ^TDriverInfo;
  begin
    if @NtQuerySystemInformation = nil then
      NtQuerySystemInformation := GetProcAddress(GetModuleHandle('ntdll.dll'),
        'NtQuerySystemInformation');
 
    // Obtain required buffer size
    NtQuerySystemInformation(DRIVER_INFORMATION, @temp, 0, @numBytes);
    // Allocate buffer
    buf := AllocMem(numBytes * 2);
 
    NtQuerySystemInformation(DRIVER_INFORMATION, buf, numBytes * 2, @numBytes);
    numEntries := buf^;
    driverInfo := Pointer(DWORD(buf) + 12);
    Result     := '';
    for Index := 1 to numEntries do 
    begin
      Result := Result + #$D#$A + 'Address: $' + IntToHex(DWORD(driverInfo^.Address), 8) +
        'Name: "' + (driverInfo^.Name) + '"';
      Inc(driverInfo);
    end;
    Delete(Result, 1, 2);
    FreeMem(buf);
  end;
 
  procedure TForm1.Button1Click(Sender: TObject);
  begin
    ListBox1.Items.Add(GetDriverInfo)
  end;
 
 
  // Thanks to Madshi for helping me translate from C++ Code
  // Original Code (C++) :
  //                             NtDriverList v1.0
  //                      Copyright 1998, 1999 Yariv Kaplan
  //                             WWW.INTERNALS.COM
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
