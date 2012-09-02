<h1>Путь к папке My Computer</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  ActiveX, ShlObj;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  pShell, ShellFolder: IShellFolder;
  pidl: PITEMIDLIST;
  PMalloc: IMalloc;
  sName: string;
  EnumIDList: IEnumIDList;
  pceltFetched: ULONG;
  lpName: TStrRet;
  slDirectories: TStringList;
begin
  slDirectories := TStringList.Create;
  try
    SHGetDesktopFolder(ShellFolder);
    SHGetSpecialFolderLocation(0,CSIDL_DRIVES, pidl);
    SHGetMalloc(PMalloc);
    ShellFolder.BindToObject(pidl, nil, IID_IShellFolder, Pointer(pShell));
    pShell.EnumObjects(0,SHCONTF_FOLDERS, EnumIDList);
    while EnumIDList.Next(1,pidl, pceltFetched) = S_ok do
    begin
      pceltFetched := 0;
      lpName.uType := 0;
      pShell.GetDisplayNameOf(pidl, SHGDN_FORPARSING, lpName);
      sName := lpName.pOleStr;
      slDirectories.Add(sName);
    end;
    ListBox1.Items.Assign(sldirectories);
  finally
    pMalloc._Release;
    pMalloc := nil;
    slDirectories.Free;
  end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
