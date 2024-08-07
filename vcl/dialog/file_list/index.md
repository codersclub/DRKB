---
Title: File list view in file dialogs
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


File list view in file dialogs
==============================

    // If an application asks user to select an icon, it's
    // more convenient for the user to see list of files as
    // large icons instead of small icons. Also, for selecting
    // an image file, user will be happier to choose an image
    // by seeing the thumbnails.
     
    // The standard file dialog initialy shows the files in
    // the LIST (small icon) style, and there is no documented
    // way to change this behavior. So, if user wants to see
    // the file list in another style, she/he should change
    // it manually by selecting the desired view style form
    // the provided popup menu.
     
    // Here is a workaround for this limitation to select the
    // reasonable view style for a file dialog.
     
    type
      TFileViewStyle = (fvsIcons, fvsList, fvsDetails, fvsThumbnails, fvsTiles);
     
    function SetFileDialogViewStyle(Handle: THandle; ViewStyle: TFileViewStyle): Boolean;
    const
      CommandIDs: array[TFileViewStyle] of Word = ($7029, $702B, $702C, $702D, $702E);
    var
      NotifyWnd: THandle;
    begin
      Result    := False;
      NotifyWnd := FindWindowEx(GetParent(Handle), 0, 'SHELLDLL_DefView', nil);
      if NotifyWnd <> 0 then
      begin
        SendMessage(NotifyWnd, WM_COMMAND, CommandIDs[ViewStyle], 0);
        Result := True;
      end;
    end;
     
    // Each time the file dialog opens, the above function should
    // be called to set the desired view style. The OnShow event
    // of the file dialogs seems to be the right place for this
    // purpose, however at that time the list is not created yet
    // and the function fails.
     
    // When the file list is created, the dialog raises two events:
    // OnFolderChange and OnSelectionChange events. We can use one
    // of these events for our purpose. However, we have to consider
    // that the function should be called just once for each show.
     
    // Here is a sample usage of the introduced function:
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      OpenDialog1.Tag := 0;
      OpenDialog1.Execute;
    end;
     
    procedure TForm1.OpenDialog1FolderChange(Sender: TObject);
    begin
      if OpenDialog1.Tag = 0 then
      begin
        SetFileDialogViewStyle(OpenDialog1.Handle, fvsIcons)
        OpenDialog1.Tag := 1;
      end;
    end;

