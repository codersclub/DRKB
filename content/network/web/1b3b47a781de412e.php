<h1>Счетчик посещений на Delphi</h1>
<div class="date">01.01.2007</div>

<p>Счетчики предназначены для учета количества посетителей на Ваш сайт. Кроме этого на счетчик можно возложить операции ведения статистики, учет хостов откуда пришли посетители и т.д.</p>
<p>Данный пример демонстрирует работу простого текстового счетчика с ведением списка IP адресов посетителей.</p>
<p>Сначала пропишем обработчик WebActionItem</p>
<pre>
procedure TWM.WMWebActionItemMainAction(Sender: TObject;
    Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
var
    f:TextFile;
begin
    Response.Content:=SetCounter; // Устанавливаем счетчик
 
    // Записываем IP посетителя
    AssignFile(f,log_path);
    Append(f);
    Writeln(f,Request.RemoteAddr);
    CloseFile(f);
end;
Осталось реализовать функцию SetCounter 
function TWM.SetCounter: String;
var
    f:TextFile;
    count:Integer;
begin
    AssignFile(f,counter_path);
    Reset(f);
    // Считываем значение счетчика
    Readln(f,count);
    CloseFile(f);
    //Инкреминируем
    Inc(count);
    Rewrite(f);
    // Записываем
    writeln(f,count);
    CloseFile(f);
    Result:=IntToStr(count);
end;
</pre>
<p>И еще необходимо определить константы имен файлов const</p>
<pre>
    counter_path='counter.dat'; // Файл для значений счетчика
    log_path='counter.log'; // Файл для IP адресов
</pre>
<p>Для работы этого скрипта необходимо создать два файла, для ведения счета и для списка IP. В файле счета необходимо установить начальное значение счетчика, сделать это можно в любом текстовом редакторе.</p>
<p class="p_Heading1">Источник: <a href="https://codenet.ru" target="_blank">https://codenet.ru</a></p>
<hr />&nbsp;</p>
Счетчик посещений это первое, в чем нуждается популярный web сайт. Меня всегда интересует количество людей посетивших мой сайт. Я всегда заинтересован знать количество людей каждый день. И я всегда заинтересован знать, как выходные и праздники влияют на посещения.</p>
Для отслеживания количества посетителей я просто создан однострочный файл, назвав его "counter", который содержит количество посещений. Единственная вещь, которая нам требуется, это простая CGI программа, которая читает этот файл, увеличивает на единичку и записывает обратно. Конечно, прекрасно при этом показывать посетителю эту информацию или в виде картинки или в виде простого текстового сообщения.</p>
<pre>
  {$APPTYPE CONSOLE}
  {$I-}
  var
    f: Text;
    i: Integer;
  begin
    System.Assign(f,'counter');
    reset(f);
    if IOResult = 0 then readln(f,i)
                    else i := 0;
    Inc(i);
    rewrite(f);
    writeln(f,i);
    close(f);
    if IOResult &lt;&gt; 0 then { skip };
    writeln('Content-type: text/html');
    writeln;
    writeln('&lt;HTML&gt;');
    writeln('&lt;BODY&gt;');
    writeln('&lt;CENTER&gt;');
    writeln('You are user &lt;B&gt;',i,'&lt;/B&gt; of Dr.Bobs Delphi Clinic');
    writeln('&lt;/CENTER&gt;');
    writeln('&lt;/BODY&gt;');
    writeln('&lt;/HTML&gt;')
  end.
</pre>
Выше приведенная программа показывает текущее значение в виде текстового сообщения, которое выводится в отдельном фрейме:</p>
<pre>  &lt;HTML&gt;
  &lt;FRAMESET ROWS="64,*"&gt;
    &lt;FRAME SRC=http://www.drbob42.com/cgi-bin/hitcount.exe? NAME="Head"&gt;
    &lt;FRAME  SRC="guest.htm"NAME="Main"&gt;
  &lt;/FRAMESET&gt;
  &lt;/HTML&gt;
</pre>
&nbsp;</p>
Это очень простое CGI приложение. Оно даже не получает ввода, просто преобразовывает удаленный файл на web сервере и возвращает динамическую страницу. Позвольте теперь сделать фокус на более сложном CGI приложении - таком которое требует ввода данных - например гостевой книге.</p>
&nbsp;</p>
<p>Интернет решения от доктора Боба (http://www.drbob42.com)</p>
<p>(c) 2000, Анатолий Подгорецкий, перевод на русский язык (<a href="https://nps.vnet.ee/ftp" target="_blank">https://nps.vnet.ee/ftp</a>)</p>
<div class="author">Автор: Анатолий Подгорецкий</div>
