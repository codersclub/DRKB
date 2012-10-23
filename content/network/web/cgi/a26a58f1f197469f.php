<h1>Гостевая книга</h1>
<div class="date">01.01.2007</div>

<p>Подлинный CGI пример: приложение - гостевая книга (в котором спрашиваем имя и небольшой комментарий), всего лишь несколько строк на Дельфи.</p>
Сначала CGI форма:</p>
  &lt;HTML&gt;</p>
  &lt;BODY&gt;</p>
  &lt;H2&gt;Dr.Bob's Guestbook&lt;/H2&gt;</p>
  &lt;FORM ACTION="http://www.drbob42.com/cgi-bin/guest.exe" METHOD=POST</p>
  Name: &lt;INPUT TYPE=text NAME=name&lt;BR&gt;</p>
  Comments: &lt;TEXTAREA COLS=42 LINES=4 NAME=comments&gt;</p>
  &lt;P&gt;</p>
  &lt;INPUT TYPE=SUBMIT VALUE="Send Comments to Dr.Bob"&gt;</p>
  &lt;/FORM&gt;</p>
  &lt;/BODY&gt;</p>
  &lt;/HTML&gt;</p>
Теперь консольное (Дельфи) приложение:</p>
<pre>
  program CGI;
  {$I-}
  {$APPTYPE CONSOLE}
  uses
    DrBobCGI;
  var
    guest: Text;
    Str: String;
  begin
    Assign(guest,'guest'); // assuming that's the guestbook
    Append(guest);
    if IOResult &lt;&gt; 0 then // open new guestbook
    begin
      Rewrite(guest);
      writeln(guest,'&lt;HTML');
      writeln(guest,'&lt;BODY')
    end;
    writeln(guest,'Date: ',DateTimeToStr(Now),'&lt;BR');
    writeln(guest,'Name: ',Value('name'),'&lt;BR');
    writeln(guest,'Comments: ',Value('comments'),'&lt;HR');
    reset(guest);
    writeln('Content-type: text/html');
    writeln;
    while not eof(guest) do // now output guestbook itself
    begin
      readln(guest,Str);
      writeln(Str)
    end;
    close(guest);
    writeln('&lt;/BODY');
    writeln('&lt;/HTML')
  end.
</pre>
&nbsp;</p>
&nbsp;</p>
Примечание, для того, что бы упростить, мы не используем базу данных для хранения комментариев. Иначе это потребовало установки BDE на web сервере.</p>
&nbsp;</p>
<p>Интернет решения от доктора Боба (http://www.drbob42.com)</p>
<p>(c) 2000, Анатолий Подгорецкий, перевод на русский язык (<a href="https://nps.vnet.ee/ftp" target="_blank">https://nps.vnet.ee/ftp</a>)</p>
<div class="author">Автор: Анатолий Подгорецкий</div>
