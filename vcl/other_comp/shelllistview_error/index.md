---
Title: Глюк при запуске приложений через ShellListView
Author: Rouse\_
Date: 01.01.2007
---


Глюк при запуске приложений через ShellListView
===============================================

::: {.date}
01.01.2007
:::

Для правки данного глюка необходимо изменить следующую процедуру в
исходном коде данного компонента:


    procedure TCustomShellListView.DblClick;
    begin
      if FAutoNavigate and (Selected <> nil) then
        with Folders[Selected.Index] do
          if IsFolder then
            SetPathFromID(AbsoluteID)
          else
            ShellExecute(Handle, nil, PChar(PathName), nil,
              PChar(ExtractFilePath(PathName)), 0);  
      inherited DblClick;
    end;
     
    на вот такую:
     
    procedure TCustomShellListView.DblClick;
    begin
      if FAutoNavigate and (Selected <> nil) then
        with Folders[Selected.Index] do
          if IsFolder then
            SetPathFromID(AbsoluteID)
          else
            ShellExecute(Handle, 'open', PChar(PathName), nil,
              PChar(ExtractFilePath(PathName)), SW_SHOW);
      inherited DblClick;
    end;

PS: SW\_HIDE = 0

Автор: Rouse\_

Взято из <https://forum.sources.ru>
