<h1>Постраничная прокрутка Memo, когда фокус находится на Edit</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Edit1KeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  if Key = VK_F8 then
    SendMessage(Memo1.Handle, { HWND для Memo }
      WM_VSCROLL, { сообщение Windows }
      SB_PAGEDOWN, {на страницу вниз }
      0) { не используется }
  else if Key = VK_F7 then
    SendMessage(Memo1.Handle, WM_VSCROLL, SB_PAGEUP, 0);
end;
 
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
