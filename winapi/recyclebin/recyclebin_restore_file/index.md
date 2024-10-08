---
Title: Восстановление файла из корзины
Author: Rouse_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Восстановление файла из корзины
===============================

    // Функция восстанавливает выбранный в ListView элемент из корзины...
    function RestoreElement(const AHandle: THandle; LV: TListView): Boolean;
     
      function GetLVItemText(const Index: Integer): String;
      begin
        if Index = 0 then
          Result := LV.Selected.Caption
        else
          Result := LV.Selected.SubItems.Strings[Index - 1];
      end;
     
    var
      ppidl, Item: PItemIDList;
      Desktop: IShellFolder;
      RecycleBin: IShellFolder2;
      RecycleBinEnum: IEnumIDList;
      Fetched, I: Cardinal;
      Details: TShellDetails;
      Mallok: IMalloc;
      Valid: Boolean;
      Context: IContextMenu;
      AInvokeCommand: TCMInvokeCommandInfo;
    begin
      Result := False;
      if LV = nil then Exit;
      if SHGetMalloc(Mallok) = S_OK then
        if SHGetSpecialFolderLocation(AHandle, CSIDL_BITBUCKET, ppidl) = S_OK then
          if SHGetDesktopFolder(Desktop) = S_OK then
            if Desktop.BindToObject(ppidl, nil, IID_IShellFolder2, RecycleBin) = S_OK then
              if RecycleBin.EnumObjects(AHandle,
                SHCONTF_FOLDERS or SHCONTF_NONFOLDERS or SHCONTF_INCLUDEHIDDEN, RecycleBinEnum) = S_OK  then
              begin
                // Перечиляем содержимое корзины
                while True do
                begin
                  RecycleBinEnum.Next(1, Item, Fetched);
                  if Fetched = 0 then Break;
                  Valid := False;
                  for I := 0 to DETAIL_COUNT - 1 do
                    if RecycleBin.GetDetailsOf(Item, I, Details) = S_OK then
                    try
                      // Ищем нужный нам элемент
                      Valid := GetLVItemText(I) = StrRetToString(Item, Details.str);
                      if not Valid then Break;
                    finally
                      Mallok.Free(Details.str.pOleStr);
                    end;
                  // Если выделенный элемент найден
                  if Valid then
                  begin
                    // Восстанавливаем его при помощи интерфейса IContextMenu
                    if RecycleBin.GetUIObjectOf(AHandle, 1, Item,
                      IID_IContextMenu, nil, Pointer(Context)) = S_OK then
                    begin
                      FillMemory(@AInvokeCommand, SizeOf(AInvokeCommand), 0);
                      with AInvokeCommand do
                      begin
                        cbSize := SizeOf(AInvokeCommand);
                        hwnd := AHandle;
                        // - локализация не нужна...
                        lpVerb := 'undelete'; // - восстановление фийла из корзины...
                        //lpVerb := 'properties'; // - показ диалога свойства...
                        //lpVerb := 'delete'; // - удаление файла из корзины...
                        fMask := 0;
                        lpDirectory := PChar(LV.Selected.SubItems.Strings[0]);
                        nShow := SW_SHOWNORMAL;
                      end;
                      Result := Context.InvokeCommand(AInvokeCommand) = S_OK;
                      Break;
                    end;
                  end;
                end;
              end;
    end; 
     
    procedure TForm1.mnuRestoreClick(Sender: TObject);
    begin
      if ListView1.Selected <> nil then
        if RestoreElement(Handle, ListView1) then ShowMessage('Элемент успешно восстановлен.');
    end;

Пример работы с корзиной можно скачать здесь:

[rbin.zip](../rbin.zip) 2k

