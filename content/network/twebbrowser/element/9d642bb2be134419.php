<h1>Как работать со всеми фреймами, отображенными в данный момент в TWebBrowser?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
Перевод материала с сайта members.home.com/hfournier/webbrowser.htm</p>

<p>Данный пример показывает как определить в каких фреймах разрешена команда 'copy':</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  i: integer;
begin
for i := 0 to (WebBrowser1.OleObject.Document.frames.Length - 1) do
  if WebBrowser1.OleObject.Document.frames.item(i).document.queryCommandEnabled('Copy') then
    ShowMessage('copy command is enabled for frame no.' + IntToStr(i));
end;
</pre>


<div class="author">Автор: Peter Friese</div>
