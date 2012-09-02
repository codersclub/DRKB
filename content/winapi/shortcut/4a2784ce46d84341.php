<h1>Как прочитать shortcut's link information?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ShlObj, 
  ComObj, 
  ActiveX, 
  CommCtrl; 
 
type 
  PShellLinkInfoStruct = ^TShellLinkInfoStruct; 
  TShellLinkInfoStruct = record 
    FullPathAndNameOfLinkFile: array[0..MAX_PATH] of Char; 
    FullPathAndNameOfFileToExecute: array[0..MAX_PATH] of Char; 
    ParamStringsOfFileToExecute: array[0..MAX_PATH] of Char; 
    FullPathAndNameOfWorkingDirectroy: array[0..MAX_PATH] of Char; 
    Description: array[0..MAX_PATH] of Char; 
    FullPathAndNameOfFileContiningIcon: array[0..MAX_PATH] of Char; 
    IconIndex: Integer; 
    HotKey: Word; 
    ShowCommand: Integer; 
    FindData: TWIN32FINDDATA; 
  end; 
 
procedure GetLinkInfo(lpShellLinkInfoStruct: PShellLinkInfoStruct); 
var 
  ShellLink: IShellLink; 
  PersistFile: IPersistFile; 
  AnObj: IUnknown; 
begin 
  // access to the two interfaces of the object 
  AnObj       := CreateComObject(CLSID_ShellLink); 
  ShellLink   := AnObj as IShellLink; 
  PersistFile := AnObj as IPersistFile; 
 
  // Opens the specified file and initializes an object from the file contents. 
  PersistFile.Load(PWChar(WideString(lpShellLinkInfoStruct^.FullPathAndNameOfLinkFile)), 0); 
  with ShellLink do 
  begin 
    // Retrieves the path and file name of a Shell link object. 
    GetPath(lpShellLinkInfoStruct^.FullPathAndNameOfFileToExecute, 
      SizeOf(lpShellLinkInfoStruct^.FullPathAndNameOfLinkFile), 
      lpShellLinkInfoStruct^.FindData, 
      SLGP_UNCPRIORITY); 
 
    // Retrieves the description string for a Shell link object. 
    GetDescription(lpShellLinkInfoStruct^.Description, 
      SizeOf(lpShellLinkInfoStruct^.Description)); 
 
    // Retrieves the command-line arguments associated with a Shell link object. 
    GetArguments(lpShellLinkInfoStruct^.ParamStringsOfFileToExecute, 
      SizeOf(lpShellLinkInfoStruct^.ParamStringsOfFileToExecute)); 
 
    // Retrieves the name of the working directory for a Shell link object. 
    GetWorkingDirectory(lpShellLinkInfoStruct^.FullPathAndNameOfWorkingDirectroy, 
      SizeOf(lpShellLinkInfoStruct^.FullPathAndNameOfWorkingDirectroy)); 
 
    // Retrieves the location (path and index) of the icon for a Shell link object. 
    GetIconLocation(lpShellLinkInfoStruct^.FullPathAndNameOfFileContiningIcon, 
      SizeOf(lpShellLinkInfoStruct^.FullPathAndNameOfFileContiningIcon), 
      lpShellLinkInfoStruct^.IconIndex); 
 
    // Retrieves the hot key for a Shell link object. 
    GetHotKey(lpShellLinkInfoStruct^.HotKey); 
 
    // Retrieves the show (SW_) command for a Shell link object. 
    GetShowCmd(lpShellLinkInfoStruct^.ShowCommand); 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
const 
  br = #13#10; 
var 
  LinkInfo: TShellLinkInfoStruct; 
  s: string; 
begin 
  FillChar(LinkInfo, SizeOf(LinkInfo), #0); 
  LinkInfo.FullPathAndNameOfLinkFile := 'C:\WINNT\Profiles\user\Desktop\FileName.lnk'; 
  GetLinkInfo(@LinkInfo); 
  with LinkInfo do 
    s := FullPathAndNameOfLinkFile + br + 
      FullPathAndNameOfFileToExecute + br + 
      ParamStringsOfFileToExecute + br + 
      FullPathAndNameOfWorkingDirectroy + br + 
      Description + br + 
      FullPathAndNameOfFileContiningIcon + br + 
      IntToStr(IconIndex) + br + 
      IntToStr(LoByte(HotKey)) + br + 
      IntToStr(HiByte(HotKey)) + br + 
      IntToStr(ShowCommand) + br + 
      FindData.cFileName + br + 
      FindData.cAlternateFileName; 
  Memo1.Lines.Add(s); 
end; 
 
// Only for D3 or higher. 
// for D1,D2 users: http://www.hitekdev.com/delphi/shellutlexamples.html 
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
