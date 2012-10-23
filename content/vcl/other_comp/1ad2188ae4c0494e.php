<h1>Глюк при запуске приложений через ShellListView</h1>
<div class="date">01.01.2007</div>


<p>Для правки данного глюка необходимо изменить следующую процедуру в исходном коде данного компонента:</p>
<pre>

procedure TCustomShellListView.DblClick;
begin
  if FAutoNavigate and (Selected &lt;&gt; nil) then
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
  if FAutoNavigate and (Selected &lt;&gt; nil) then
    with Folders[Selected.Index] do
      if IsFolder then
        SetPathFromID(AbsoluteID)
      else
        ShellExecute(Handle, 'open', PChar(PathName), nil,
          PChar(ExtractFilePath(PathName)), SW_SHOW);
  inherited DblClick;
end;
</pre>

<p>PS: SW_HIDE = 0</p>
<div class="author">Автор: Rouse_</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
