---
Title: Путь к папке My Computer
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Путь к папке My Computer
========================

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

