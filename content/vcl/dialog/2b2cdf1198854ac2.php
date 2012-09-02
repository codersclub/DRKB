<h1>Как показать Run диалог?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  ComObj;
 
procedure TForm1.FormCreate(Sender: TObject);
var
  ShellApplication: Variant;
begin
  ShellApplication := CreateOleObject('Shell.Application');
  ShellApplication.FileRun;
end;
 
 
{*****************************}
 
{2.}
 
{ This code uses the undocumented RunFileDlg function to show the "run" dialog }
// For Win NT
procedure RunFileDlgW(OwnerWnd: HWND; Icon: HICON; lpstrDirectory: PWideChar;
  lpstrTitle: PWideChar; lpstrDescription: PWideChar; Flags: Longint); stdcall;
  external 'Shell32.dll' Index 61;
// For Win 9x (Win NT to show standard captions )
procedure RunFileDlg(OwnerWnd: HWND; Icon: HICON; lpstrDirectory: PChar;
  lpstrTitle: PChar; lpstrDescription: PChar; Flags: Longint); stdcall;
  external 'Shell32.dll' Index 61;
const
  RFF_NOBROWSE = 1; //Removes the browse button.
  RFF_NODEFAULT = 2; // No default item selected.
  RFF_CALCDIRECTORY = 4; // Calculates the working directory from the file name.
  RFF_NOLABEL = 8; // Removes the edit box label.
  RFF_NOSEPARATEMEM = 14; // Removes the Separate Memory Space check box (Windows NT only).
function ShowRunFileDialg(OwnerWnd: HWND; InitialDir, Title, Description: PChar;
  flags: Integer; StandardCaptions: Boolean): Boolean;
var
  HideBrowseButton: Boolean;
  TitleWideChar, InitialDirWideChar, DescriptionWideChar: PWideChar;
  Size: Integer;
begin
  if (Win32Platform = VER_PLATFORM_WIN32_NT) and not StandardCaptions then
  begin
    Size := SizeOf(WideChar) * MAX_PATH;
    InitialDirWideChar := nil;
    TitleWideChar := nil;
    DescriptionWideChar := nil;
    GetMem(InitialDirWideChar, Size);
    GetMem(TitleWideChar, Size);
    GetMem(DescriptionWideChar, Size);
    StringToWideChar(InitialDir, InitialDirWideChar, MAX_PATH);
    StringToWideChar(Title, TitleWideChar, MAX_PATH);
    StringToWideChar(Description, DescriptionWideChar, MAX_PATH);
    try
      RunFileDlgW(OwnerWnd, 0, InitialDirWideChar, TitleWideChar, DescriptionWideChar, Flags);
    finally
      FreeMem(InitialDirWideChar);
      FreeMem(TitleWideChar);
      FreeMem(DescriptionWideChar);
    end;
  end else
    RunFileDlg(OwnerWnd, 0, PChar(InitialDir), PChar(Title), PChar(Description), Flags);
end;
procedure TForm1.Button1Click(Sender: TObject);
begin
  ShowRunFileDialg(FindWindow('Shell_TrayWnd', nil), nil, nil, nil, RFF_NOBROWSE, True);
end;
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
