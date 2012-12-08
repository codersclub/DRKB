---
Title: Using the Shell API function SHBrowseForFolder
Date: 01.01.2007
---


Using the Shell API function SHBrowseForFolder
==============================================

::: {.date}
01.01.2007
:::

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
      if lpItemId  nil then begin
        SHGetPathFromIDList(lpItemID, TempPath);
        ShowMessage(TempPath);
        GlobalFreePtr(lpItemID);
      end;
    end;
