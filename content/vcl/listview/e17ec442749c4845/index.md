---
Title: Virtual ListView с контекстным меню
Date: 01.01.2007
---


Virtual ListView с контекстным меню
===================================

::: {.date}
01.01.2007
:::

В Delphi5/Demos есть пример Virtual ListView. программка чем-то
напоминает explorer, но без контекстного меню. контекстное меню
приделывается так:

    procedure TForm1.PopupMenu1Popup(Sender: TObject);
    var
      ContextMenu : IContextMenu;
      menu : HMENU;
    begin
      FIShellFolder.GetUIObjectOf(Handle, 1, ShellItem(ListView.Selected.Index).ID,
      IID_IContextMenu, nil, ContextMenu);
      menu := CreatePopupMenu();
      ContextMenu.QueryContextMenu(menu, 0, 1, $7FFF, CMF_EXPLORE);
      TrackPopupMenu(menu,
      TPM_LEFTALIGN or TPM_LEFTBUTTON or TPM_RIGHTBUTTON or TPM_RETURNCMD,
      Mouse.CursorPos.x, Mouse.CursorPos.y, 0, Handle, nil);
      DestroyMenu(menu);
    end;

Взято из <https://forum.sources.ru>
