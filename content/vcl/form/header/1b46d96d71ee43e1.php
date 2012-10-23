<h1>Как скрыть кнопку [x] в заголовке окна?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Fernando Silva</div>

<p>Пример показывает, как при инициализации формы происходит поиск нашего окна, а затем вычисление местоположения нужной нам кнопки в заголовке окна.</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var
  hwndHandle: THANDLE;
  hMenuHandle: HMENU;
  iPos: Integer;
 
begin
  hwndHandle := FindWindow(nil, PChar(Caption));
  if (hwndHandle &lt;&gt; 0) then
  begin
    hMenuHandle := GetSystemMenu(hwndHandle, FALSE);
    if (hMenuHandle &lt;&gt; 0) then
    begin
      DeleteMenu(hMenuHandle, SC_CLOSE, MF_BYCOMMAND);
      iPos := GetMenuItemCount(hMenuHandle);
      Dec(iPos);
        { Надо быть уверенным, что нет ошибки т.к. -1 указывает на ошибку }
      if iPos &gt; -1 then
        DeleteMenu(hMenuHandle, iPos, MF_BYPOSITION);
    end;
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


