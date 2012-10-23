<h1>Вывод изображений</h1>
<div class="date">01.01.2007</div>


<p>Заголовок HTTP-ответа для HTML-страниц</p>
Мы уже знаем, что для сообщения браузеру, что передаваемый документ является HTML-документом, CGI-программа выводит специальный заголовок, не отображаемый браузером: </p>
  WriteLn('Content-Type: text/html');</p>
  WriteLn(''); </p>
HTTP-заголовок для изображений</p>
Точно таким же образом можно с успехом указать и другой тип данных! Например, для вывода изображения в формате GIF достаточно вывести следующее: </p>
  WriteLn('Content-Type: image/gif');</p>
  WriteLn(''); </p>
Таким образом мы сообщаем браузеру, что далее будет следовать именно изображение... </p>
Передача двоичных данных</p>
Для начала давайте разберемся, как отправить двоичные данные в STDOUTPUT. </p>
&nbsp;</p>
Я написал две процедуры: первая выводит поток TSTREAM в STDOUTPUT, а вторая выводит двоичный файл в выходной поток: </p>
<pre>
// Процедура вывода потока в STDOUTPUT.
 // Попробуйте самостоятельно переделать ее для Kylix...
 procedure WriteStream(stream:TStream);
  var
   OutStream:THandleStream;
 begin
  Flush(output); // для передачи заголовка мы используем обычный WRITELN...
 // здесь используется код из программы
 // DCOUNTER for Delphi 3 by Dave Wedwick (dwedwick@bigfoot.com)
  OutputStream:=THandleStream.Create(GetStdHandle(STD_OUTPUT_HANDLE));
  Stream.SaveToStream(OutputStream);
  OutputStream.Free;
 end;
 
 // Процедура для передачи двоичного файла
 procedure WriteFile(FileName:string);
  var
   s:TFileStream;
 begin
  s:=TFileStream.Create(FileName,fmOpenRead);
  WriteStream(s);
 end;
</pre>

<p>Передача GIF файлов</p>
<p>Теперь нам осталось только создать (или взять готовый) GIF файл и вывести его! </p>
<pre>
 procedure WriteGIF(FileName:string);
 begin
   WriteLn('Content-type: image/gif');
   WriteLn;
   WriteFile(FileName);
 end;
</pre>

