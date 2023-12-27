---
Title: Гостевая книга
Date: 01.01.2007
---


Гостевая книга
==============

::: {.date}
01.01.2007
:::

Подлинный CGI пример: приложение - гостевая книга (в котором спрашиваем
имя и небольшой комментарий), всего лишь несколько строк на Дельфи.

Сначала CGI форма:

\<HTML\>

\<BODY\>

\<H2\>Dr.Bob\'s Guestbook\</H2\>

\<FORM ACTION=\"http://www.drbob42.com/cgi-bin/guest.exe\" METHOD=POST

Name: \<INPUT TYPE=text NAME=name\<BR\>

Comments: \<TEXTAREA COLS=42 LINES=4 NAME=comments\>

\<P\>

\<INPUT TYPE=SUBMIT VALUE=\"Send Comments to Dr.Bob\"\>

\</FORM\>

\</BODY\>

\</HTML\>

Теперь консольное (Дельфи) приложение:

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
        if IOResult <> 0 then // open new guestbook
        begin
          Rewrite(guest);
          writeln(guest,'<HTML');
          writeln(guest,'<BODY')
        end;
        writeln(guest,'Date: ',DateTimeToStr(Now),'<BR');
        writeln(guest,'Name: ',Value('name'),'<BR');
        writeln(guest,'Comments: ',Value('comments'),'<HR');
        reset(guest);
        writeln('Content-type: text/html');
        writeln;
        while not eof(guest) do // now output guestbook itself
        begin
          readln(guest,Str);
          writeln(Str)
        end;
        close(guest);
        writeln('</BODY');
        writeln('</HTML')
      end.

 

 

Примечание, для того, что бы упростить, мы не используем базу данных для
хранения комментариев. Иначе это потребовало установки BDE на web
сервере.

 

Интернет решения от доктора Боба (http://www.drbob42.com)

\(c) 2000, Анатолий Подгорецкий, перевод на русский язык
(<https://nps.vnet.ee/ftp>)
