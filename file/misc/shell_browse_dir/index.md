---
Title: Как использовать Shell API SHBrowseForFolder?
Date: 01.01.2007
---


Как использовать Shell API SHBrowseForFolder?
=============================================

::: {.date}
01.01.2007
:::

Статья из рассылки "Мастера DELPHI. Новости мира компонент, FAQ,
статьи...".

Как использовать функцию Shell API SHBrowseForFolder чтобы позволить
пользователю выбрать каталог?

    uses ShellAPI, ShlObj;
    procedure TForm1.Button1Click(Sender: TObject);
    var
    TitleName : string;
    lpItemID : PItemIDList;
    BrowseInfo : TBrowseInfo;
    DisplayName : array[0..MAX_PATH] of char;
    TempPath : array[0..MAX_PATH] of char;
    begin
    FillChar(BrowseInfo, sizeof(TBrowseInfo), #0);
    BrowseInfo.hwndOwner := Form1.Handle;
    BrowseInfo.pszDisplayName := @DisplayName;
    TitleName := 'Please specify a directory';
    BrowseInfo.lpszTitle := PChar(TitleName);
    BrowseInfo.ulFlags := BIF_RETURNONLYFSDIRS;
    lpItemID := SHBrowseForFolder(BrowseInfo);
    if lpItemId <> nil then begin
    SHGetPathFromIDList(lpItemID, TempPath);
    ShowMessage(TempPath);
    GlobalFreePtr(lpItemID);
    end;
    end;

 

 

Источник: Дельфи. Вокруг да около.

------------------------------------------------------------------------

Вариант от Анатолия (SAVwa@eleks.lviv.ua)

    threadvar myDir: string;
    function BrowseCallbackProc(hwnd: HWND; uMsg: UINT; lParam: LPARAM; lpData:
    LPARAM): integer; stdcall;
    begin
    Result := 0;
    if uMsg = BFFM_INITIALIZED then begin
    SendMessage(hwnd, BFFM_SETSELECTION, 1, LongInt(PChar(myDir)))
    end;
    end;
    function SelectDirectory(const Caption: string; const Root: WideString;
    var Directory: string): Boolean;
    var
    WindowList: Pointer;
    BrowseInf!
    o: TBrowseInfo;
    Buffer: PChar;
    RootItemIDList, ItemIDList: PItemIDList;
    ShellMalloc: IMalloc;
    IDesktopFolder: IShellFolder;
    Eaten, Flags: LongWord;
    begin
    myDir := Directory;
    Result := False;
    FillChar(BrowseInfo, SizeOf(BrowseInfo), 0);
    if (ShGetMalloc(ShellMalloc) = S_OK) and (ShellMalloc <> nil) then
    begin
    Buffer := ShellMalloc.Alloc(MAX_PATH);
    try
    RootItemIDList := nil;
    if Root <> '' then
    begin
    SHGetDesktopFolder(IDesktopFolder);
    IDesktopFolder.ParseDisplayName(Application.Handle, nil,
    POleStr(Root), Eaten, RootItemIDList, Flags);
    end;
    with BrowseInfo do
    begin
    hwndOwner := Application.Handle;
    pidlRoot := RootItemIDList;
    pszDisplayName := Buffer;
    lpfn := @BrowseCallbackProc;
    lParam := Integer(PChar(Directory));
    lpszTitle := PChar(Caption);
    ulFlags := BIF_RETURNONLYFSDIRS or $0040 or BIF_EDITBOX or
    BIF_STATUSTEXT;
    end;
    WindowList := DisableTaskWindows(0);
    try
    ItemIDList := ShBrowseForFolder(BrowseInfo);
    finally
    EnableTaskWindows(WindowList);
     
    end;
    Result := ItemIDList <> nil;
    if Result then
    begin
    ShGetPathFromIDList(ItemIDList!
   , Buffer);
    ShellMalloc.Free(ItemIDList);
    Directory := Buffer;
    end;
    finally
    ShellMalloc.Free(Buffer);
    end;
    end;
    end;
     

Взято с Vingrad.ru <https://forum.vingrad.ru>
