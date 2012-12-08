---
Title: Как выделить файлы в Проводнике?
Author: Rouse\_
Date: 01.01.2007
---


Как выделить файлы в Проводнике?
================================

::: {.date}
01.01.2007
:::

Просто открыть окно, и выделить в нём файлы\|папки

Да в принципе путь то нам известен? Известен, посему делаем финт
хвостом:

    uses ..., SHDocVw;

     
    function OpenExplorerAndSelectFile(Path: String): Boolean;
     
      function ParceURLName(const Value: String): String;
      const
        scFilePath: array [0..7] of Char = ('f', 'i', 'l', 'e', ':', '/', '/', '/');
      begin
        if CompareMem(@scFilePath[0], @Value[1], 8) then
        begin
          Result := Copy(Value, 9, Length(Value));
          Result := StringReplace(Result, '/', '\', [rfReplaceAll]);
          Result := StringReplace(Result, '%20', ' ', [rfReplaceAll]);
          Result := IncludeTrailingBackslash(Result);
        end
        else
          Result := Value;
      end;
     
    var
      iShellWindow: IShellWindows;
      iWB: IWebBrowserApp;
      spDisp: IDispatch;
      I: Integer;
      S, FilePath, FileName: String;
    begin
      Result := FileExists(Path);
      if not Result then Exit;
      FilePath := AnsiUpperCase(ExtractFilePath(Path));
      FileName := ExtractFileName(Path);
      iShellWindow := CoShellWindows.Create;
      for I := 0 to iShellWindow.Count - 1 do
      begin
        spDisp := iShellWindow.Item(I);
        if spDisp = nil then Continue;
        spDisp.QueryInterface(IWebBrowserApp, iWB);
        if iWB <> nil then
        begin
          S := ParceURLName(iWB.LocationURL);
          if AnsiUpperCase(S) = FilePath then
          begin
            SendMessage(iWB.HWnd, WM_SYSCOMMAND, SC_CLOSE, 0);
            Break;
          end;
        end;
      end;
      ShellExecute(0, 'open', 'explorer.exe',
        PChar('/select, ' + FileName), PChar(FilePath), SW_SHOWNORMAL);
    end;
     
    procedure TForm18.Button4Click(Sender: TObject);
    begin
      if not OpenExplorerAndSelectFile('c:\windows\notepad.exe') then
        ShowMessage('Файл не найден.');
    end;

\
Это проще чем искать по заголовку.\

 

Взято из <https://forum.sources.ru>

Автор: Rouse\_
