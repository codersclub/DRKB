<h1>Как поменять иконку и стpокy в заголовке консольного окна?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  h: HWND;
  AIcon: TIcon;
begin
  AllocConsole;
  SetConsoleTitle(PChar('Console Title'));
  Sleep(0);
  h := FindWindow(nil, PChar('Console Title'));
  AIcon := TIcon.Create;
  ImageList1.GetIcon(0, AIcon);
  SendMessage(h, WM_SETICON, 1, AIcon.Handle);
  AIcon.Free;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

