<h1>Как сделать окошко подсказки в редакторе как Delphi по Ctrl-J</h1>
<div class="date">01.01.2007</div>

Автор: Hog</p>
<p>Допустим у тебя TMemo..</p>
<p>1. Делаешь ListBox, заполняешь, visible := false, parent := Memo</p>
<p>2. У Memo в обработчике Memo.onKeyDown что-нибудь типа:</p>
<pre>
if (key = Ord('J')) and (ssCtrl in Shift) then
begin
  lb.Left := Memo.CaretPos.x;
  lb.Top := Memo.CaretPos.y + lb.height;
  lb.Visible := True;
  lb.SetFocus;
end;
</pre>

<p>он показывается.. а дальше работай с листбоксом, вставляй в мемо нужный текст, пряч листбокс</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
