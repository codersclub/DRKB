<h1>Как производить печать?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm </p>

<p>Есть два способа вывода на печать. Первый пример работает в IE 4.x и выше,</p>
<p>в то время как второй пример расчитан на IE 3.x: </p>
<pre>
var
vaIn, vaOut: OleVariant; 
 
... WebBrowser.ControlInterface.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER, vaIn, vaOut); либо 
 
procedure TForm1.PrintIE;
var
CmdTarget : IOleCommandTarget;
vaIn, vaOut: OleVariant;
begin
if WebBrowser1.Document &lt; &gt; nil then
try
WebBrowser1.Document.QueryInterface(IOleCommandTarget, CmdTarget);
if CmdTarget &lt; &gt; nil then
try
  CmdTarget.Exec( PGuid(nil), OLECMDID_PRINT,
  OLECMDEXECOPT_DONTPROMPTUSER, vaIn, vaOut);
finally
  CmdTarget._Release;
end;
except
  // Ничего
end;
end;
</pre>


<p>Обратите внимание: Если версия Delphi ниже чем 3.02, то необходимо заменить PGuid(nil)</p>
<p>на PGuid(nil)^</p>
<p>. А лучше всего проапгрейдить до 3.02 (если Вы пользуетесь версиями 3.0 или 3.01). </p>
