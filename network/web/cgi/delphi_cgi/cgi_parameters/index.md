---
Title: Передача параметров
Date: 01.01.2007
---


Передача параметров
===================

::: {.date}
01.01.2007
:::

Передача параметров

Методы GET и POST

Существует по крайней мере два метода передачи параметров CGI-программе.

\<form method=GET action=\"program.exe\"\>

\<form method=POST action=\"program.exe\"\>

Чтобы определить, каким именно методом CGI-программе переданы параметры,
достаточно в вашей программе проверить переменную среды REQUEST\_METHOD.

 

Ниже привдена функция, с помощью которой можно получить значение
переменной среды окружения:

    function getvar(varname:string):string;
    {$IFDEF LINUX}
     begin
      result:=getenv(PChar(varname));
     end;
    {$ELSE}
     var
      buffer:array[0..1024] of char;
      size:integer;
     begin
      size:=GetEnvironmentVariable(PChar(varname),buffer,sizeof(buffer));
      if size=0 then getvar:='' else getvar:=String(buffer);
     end;
    {$ENDIF}

 

Автор предпочитает работать не с массивами, а со строками, поэтому
результат функции преобразовывается в строку...

 

Теперь посмотрим, как определить значение переменной среды под DOS в
.BAT файле:

 

\@ECHO OFF

ECHO content-type: text/html

ECHO.

ECHO
\^\<HTML\^\>\^\<HEAD\^\>\^\<TITLE\^\>\^\</TITLE\^\>\^\</HEAD\^\>\^\<BODY\^\>

ECHO REQUEST\_METHOD=%REQUEST\_METHOD%

ECHO \^\</BODY\^\>\^\</HTML\^\>

 

Обратите внимание, что специальные символы, используемые в DOS (такие,
как \"\<\", \"\>\", \"&\",...), необходимо предварять знаком \"\^\".

 

Таким образом, если мы обратимся к функции в виде
GetVar(\'REQUEST\_METHOD\'), то получим в виде строки метод, которым
были переданы параметры: \'GET\' или \'POST\'.

 

Согласно Спецификации CGI, параметры могут быть прочитаны:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- ------------------------------------------------------
  ·   Из переменной окружения QUERY\_STRING для метода GET
  --- ------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"}
  --- --------------------------------------------------------------------------
  ·   Из стандартного ввода (STDIN) с помощью процедуры ReadLn для метода POST
  --- --------------------------------------------------------------------------
:::

 

Метод POST используется в тех случаях, когда необходимо передать большое
количество параметров или большой объем данных. При использовании же
метода GET для хранения всех передаваемых параметров используется
переменная среды окружения, а она, как вы понимаете, не резиновая, так
что ее максимального размера в некоторых случаях может не хватить...

 

Метод GET и переменная QUERY\_STRING

Переменная среды окружения QUERY\_STRING содержит список имен и значений
параметров, переданных из формы... Но сначала рассмотри код HTML:

 

\<form method=\"GET\" action=\"program.exe\"\>

\<input type=text name=\"toto\" value=\"titi\"\>

\<input type=submit value=\"GO\"\>

\</form\>

 

Кликнув на \"GO\" (здесь кликать не надо, это просто пример!), вы
запускаете на сервере программу \"program.exe\" передавая серверу запрос
в виде:

https://www.ваш\_сервер/cgi-bin/program.exe?toto=titi

Вы видите, что сразу за именем программы следует знак вопроса и
передаваемый в программу параметр. В переменную QUERY\_STRING как раз и
будет помещено все, что находится после символа \"?\". Заметим, что
точно так же можно задать параметры и в обычной ссылке:

\<a href=\"https://www.ваш\_сервер/cgi-bin/program.exe?toto=titi\"\>...\</a\>

И последнее уточнение: если запрос содержит несколько параметров, то они
отделяются друг от друга амперсандом &. Кроме того, некоторые символы в
значениях параметров (например, \"&\") должны быть представлены в
шестнадцатеричной форме %hh, где \"hh\" - шестнадцатеричный код символа
в таблице ANSI. Например, символ амперсанда \"&\" должен быть
представлен в виде \"%26\".

Представьте, что вам требуется на сайте yahoo.com найти результаты
поиска по ключевым словам cgi и delphi, для чего в окне поиска вы
вводите \"cgi + delphi\".

Тогда в результате вашего запроса будет сгенерирован следующий URL:

https://search.yahoo.com/bin/search?p=cgi+%2B+delphi

Тем самым, вы обратитесь к программе \"search\" и зададите значение
параметра \"p\" равным \"cgi + delphi\", при этом символ \"+\" будет
автоматически заменен браузером на \"%2B\", а пробелы - на \"+\".

Метод POST

Для получения данных, переданных по методу POST, необходимо читать
данные из \"устройства стандартного ввода\" STDIN. Размер данных,
переданных по этому методу, помещается сервером в переменную окружения
CONTENT\_LENGTH.

Посмотрим, как это выглядит в Delphi:

    // Получение переданных параметров
      if getvar('REQUEST_METHOD')='POST' then begin
       parmstring:=getvar('CONTENT_LENGTH');
       if parmstring<>'' then begin
        size:=strtoint(parmstring);
        setlength(parmstring,size);
        for i:=1 to size do read(parmstring[i]);
       end;
      end else
       parmstring:=getvar('QUERY_STRING'); 

В заключение я предлагаю вашему вниманию маленькую CGI-программу,
которая просто выводит то, что происходит на сервере:

    program log;
     
    {$apptype console}
     
    // прикручивание к Linux попробуйте сделать сами :)
     
    uses
      windows, sysutils;
     
    var
     i:integer;
     s:string;
     p:pchar;
     
     flog:textfile;
     
    begin
     assignfile(flog,'c:\temp\log.txt');
     rewrite(flog);
     
     WriteLn('Content-Type: text/html');
     WriteLn('');
     
     WriteLn('<html><head><title>Dump CGI</title></head><body>');
     WriteLn('<h1>Dump CGI:</h1>');
     WriteLn('<a href=#Parms>Параметры программы</a><br>');
     WriteLn('<a href=#Query>Параметры CGI</a><br>');
     WriteLn('<a href=#Env>Переменные окружения</a><br>');
     WriteLn('<a href=#Info>Дополнительная информация о CGI</a><br>');
     WriteLn('<hr>');
     
     WriteLn('<a name=Parms><h2>ParamCount=',IntToStr(ParamCount),'</h2><ul>');
     WriteLn(fLog,'ParamCount=',IntToStr(ParamCount));
     
      for i:=0 to ParamCount do begin
       WriteLn('<li>',ParamStr(i));
       WriteLn(fLog,'-',ParamStr(i));
      end;
     
     // Стандартный Ввод
     WriteLn(fLog,'Input :');
     WriteLn('<h2>StdInput:</h2><ul>');
     if Not Eof(Input) then begin
      Read(Input,s);
      WriteLn('<li>',s);
      WriteLn(fLog,s);
     end;
     
     Writeln(fLog,'QUERY_STRING=',ParmString);
     
     WriteLn('<a name=Env><h2>Переменные окружения:</h2><ul>');
     p:=GetEnvironmentStrings;
     while StrLen(p)<>0 do begin
      WriteLn('<li>',p);
      WriteLn(fLog,':',p);
      p:=strend(p);
      inc(p);
     end;
     WriteLn('</ul><hr>');
     
     WriteLn('<a name=Info><a href="https://www.multimania.com/tothpaul">');
     WriteLn('Дополнительная информация о CGI</a>');
     WriteLn('</body></html>');
     
    end.

Примечание:

Кроме стандартного вывода информация параллельно выводится еще и в
лог-файл.
