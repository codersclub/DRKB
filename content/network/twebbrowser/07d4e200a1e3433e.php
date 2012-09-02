<h1>Как использовать протокол res?</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ:<a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>Перевод материала с сайта members.home.com/hfournier/webbrowser.htm </p>

<p>Протокол " res:" позволяет просмотреть HTML файл, сохранённый как ресурс.</p>
<p>Более подробная информация доступна на Microsoft site:</p>

<pre>
procedure TForm1.LoadHTMLResource;
var
  Flags, TargetFrameName, PostData, Headers: OleVariant;
begin
  WebBrowser1.Navigate('res://' + Application.ExeName + '/myhtml',
    Flags, TargetFrameName, PostData, Headers)
end; 
</pre>

<p>Создайте файл ресурса (*.rc) со следующими строками и откомпилируйте</p>
<p>его при помощи brcc32.exe: MYHTML 23 " .\html\myhtml.htm" MOREHTML 23 " .\html\morehtml.htm" Отредактируйте файл проекта, чтобы он выглядел примерно так: {$R *.RES}</p>
<p>{$R HTML.RES} //где html.rc будет скомпилирован в html.res </p>
