<h1>Как извлечь иконку из EXE или DLL?</h1>
<div class="date">01.01.2007</div>


<p>Такой вот совет пришел ко мне с рассылкой "Ежедневная рассылка сайта Мастера DELPHI", думаю многим будет интересно.</p>
<p>Решить эту задачу нам поможет функция function ExtractIcon(hInstance, filename, iconindex):integer</p>
<p>где hinstance - глобальная переменная приложения, ее изменять не надо. Тип integer.</p>
<p>filename - имя программы или DLL из которой надо извлекать иконки. Тип pchar.</p>
<p>iconindex - порядковый номер иконки в файле (начинается с 0). В одном файле может находится несколько иконок. Тип integer.</p>
<p>Функция находится в модуле ShellApi, так что не забудьте подключить его в uses. Если эта функция возвратит ноль, значит иконок в файле нет.</p>
<p>Данная функция возвращает handle иконки, поэтому применять ее нужно так:</p>
<p>Image1.Picture.Icon.Handle:=ExtractIcon(hInstance, pchar(paramstr(0)), 0);</p>
<p>данное объявление нарисует в Image'e картинку вашего приложения. </p>

<p class="author">Автор: Михаил Христосенко</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr />

<p>Функция ExtractIcon позволяет извлечь иконку из exe, dll и ico-файлов. Если указанная иконка отсутствует, функция возвращает 0. Количество иконок, содержащихся в файле, можно узнать, указав в качестве последнего параметра -1.</p>
<pre>
uses ShellAPI;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  ic: TIcon;
  i, count: integer;
  w: integer;
begin
  if OpenDialog1.Execute = false then Exit;
  Form1.Canvas.FillRect(Form1.Canvas.ClipRect);
  count := ExtractIcon(Application.Handle,
    PChar(OpenDialog1.FileName), -1);
  ic := TIcon.Create;
  w := Form1.Width div 32;
  for i := 0 to count - 1 do begin
 
    ic.Handle := ExtractIcon(Application.Handle,
      PChar(OpenDialog1.FileName), i);
    Form1.Canvas.Draw(32 * (i mod w), 32 * (i div w), ic);
  end;
  ic.Destroy;
end;
</pre>


<p class="author">Автор: Даниил Карапетян (delphi4all@narod.ru)</p>
<p class="author">Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)</p>

