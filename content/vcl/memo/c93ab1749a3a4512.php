<h1>Как перехватить Ctrl-V в компоненте TMemo?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует, как перехватить комбинацию Ctrl-V в компоненте TMemo и поместить в него свой текст вместо того, который в буфере обмена.</p>

<p>Пример:</p>
<pre>
uses ClipBrd;
 
procedure TForm1.Memo1KeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
begin
  if ((Key = ord('V')) and (ssCtrl in Shift)) then begin
    if Clipboard.HasFormat(CF_TEXT) then
      ClipBoard.Clear;
    Memo1.SelText := 'Delphi is RAD!';
    key := 0;
  end;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

