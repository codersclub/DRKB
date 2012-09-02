<h1>Как перехватить клавишу табуляции (Tab) в TEdit?</h1>
<div class="date">01.01.2007</div>


<p>Это можно давольно легко сделать переопределив на форме процедуру CMDialogKey. Чтобы посмотреть как это работает, поместите на форму Edit и введите следующий код:</p>
<pre>
procedure CMDialogKey(Var Msg: TWMKey); 
message CM_DIALOGKEY;
...
procedure TForma.CMDialogKey(Var Msg: TWMKEY);
begin
  if (ActiveControl is TEdit) and
           (Msg.Charcode = VK_TAB) then
  begin
   ShowMessage('Нажата клавиша TAB?');
  end;
  inherited;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

