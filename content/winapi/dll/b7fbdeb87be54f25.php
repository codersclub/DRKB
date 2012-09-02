<h1>Как создать DLL только с ресурсами?</h1>
<div class="date">01.01.2007</div>


<p>Создайте и откомпилируйте пустой проект DLL, который содержит ссылку на файл ресурсов .res, который содержит Ваши ресурсы.</p>

<pre>
library ResTest; 
uses 
  SysUtils; 
 
{$R MYRES.RES} 
 
begin 
end. 
 
Для использования такой DLL, просто загрузите dll и ресурсы, которые Вы будете использовать:
 
Пример:
 
{$IFDEF WIN32} 
const BadDllLoad = 0; 
{$ELSE} 
const BadDllLoad = 32; 
{$ENDIF} 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  h : THandle;   
  Icon : THandle; 
 
begin 
  h := LoadLibrary('RESTEST.DLL'); 
 
  if h &lt;= BadDllLoad then 
    ShowMessage('Bad Dll Load') 
  else begin 
    Icon := LoadIcon(h, 'ICON_1'); 
    DrawIcon(Form1.Canvas.Handle, 10, 10, Icon); 
    FreeLibrary(h); 
  end; 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

