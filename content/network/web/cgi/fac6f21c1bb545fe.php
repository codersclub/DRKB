<h1>Простейший CGI на Дельфи</h1>
<div class="date">01.01.2007</div>


<pre>
program helloworld;
 

 
 
{$E cgi}
begin
  Write('Content type: Text/HTML' + #13#10#13#10);
  Write('Hello World!');
end.
</pre>
<p>Всё что этот код делает это выводит в поток вывода 'Hello World!'. Открываем новый проэкт. Удаляем все из DPR файла, заполняем приведенным кодом. Компиллируем. Полученный файл helloworld.cgi ставим в папку cgi-bin IIS сервера, убеждаемся что в настройках сервера разрешено исполнение серверных скриптов и сам сервер включен, далее открываем браузер и вводим адрес, у меня это:</p>
<p>httр://vitaly/cgi-bin/helloworld.cgi</p>
<p>любуемся надписью "Hello World!" в браузере.</p>
<p>А вот чуть более сложный пример - вывод потока (в данном случае если поток содержит картинку) в браузер:</p>
<pre>
procedure OutputStream(m: TStream);
 

 
 
var h: Integer;
  j: cardinal;
begin
  h := GetStdHandle(STD_OUTPUT_HANDLE);
  try
    WriteFile(h, 'Content type: image/x-MS-bmp' + #13#10#13#10, 32, j, nil);
    WriteFile(h, m.memory^, m.size, j, nil);
  finally
    CloseHandle(h);
  end;
end;
</pre>

<p>Теперь сделанный cgi можно использовать в качестве картинки.</p>
<p>Естественно, что работать такой CGI ,будет только в среде Windows (для работы под Linux надо подумать над компилляцией в среде Kilix)</p>
<p>Ещё типы контента:</p>
<p>text/html</p>
<p>text/plain</p>
<p>text/richtext</p>
<p>image/gif</p>
<p>image/jpeg</p>
<p>image/x-MS-bmp</p>
<p>image/x-xpixmap</p>
<p>video/mpeg</p>
<p>video/quicktime</p>
<p>audio/x-wav</p>
<p>audio/basic (Sun *.au audio files)</p>
<p>audio/mp3</p>
<p>audio/mpeg</p>
<p>audio/x-mp3</p>
<p>audio/x-mpeg</p>
<p>audio/m3u</p>
<p>audio/x-m3u</p>
<p>audio/x-aiff (aif aiff aifc)</p>
<p>application/msword</p>
<p>application/octet-stream (для exe)</p>
<p>application/x-zip</p>
<p>application/mac-binhex40 (hqx)</p>
<p>application/pdf</p>
<p>application/rtf</p>
<p>application/x-latex</p>
<p>application/zip</p>
<p>application/rss+xml</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
