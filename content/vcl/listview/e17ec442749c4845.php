<h1>Virtual ListView с контекстным меню</h1>
<div class="date">01.01.2007</div>


<p>В Delphi5/Demos есть пример Virtual ListView. программка чем-то напоминает explorer, но без контекстного меню. контекстное меню приделывается так:</p>
<pre>
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
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

