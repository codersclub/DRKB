<h1>Передача параметров</h1>
<div class="date">01.01.2007</div>


<p>Методы GET и POST</p>
Существует по крайней мере два метода передачи параметров CGI-программе.</p>
 &lt;form method=GET action="program.exe"&gt;</p>
 &lt;form method=POST action="program.exe"&gt;</p>
Чтобы определить, каким именно методом CGI-программе переданы параметры, достаточно в вашей программе проверить переменную среды REQUEST_METHOD.</p>
</p>
Ниже привдена функция, с помощью которой можно получить значение переменной среды окружения:</p>
<pre>function getvar(varname:string):string;
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
</pre>
</p>
Автор предпочитает работать не с массивами, а со строками, поэтому результат функции преобразовывается в строку...</p>
</p>
Теперь посмотрим, как определить значение переменной среды под DOS в .BAT файле:</p>
</p>
@ECHO OFF</p>
ECHO content-type: text/html</p>
ECHO.</p>
ECHO ^&lt;HTML^&gt;^&lt;HEAD^&gt;^&lt;TITLE^&gt;^&lt;/TITLE^&gt;^&lt;/HEAD^&gt;^&lt;BODY^&gt;</p>
ECHO REQUEST_METHOD=%REQUEST_METHOD%</p>
ECHO ^&lt;/BODY^&gt;^&lt;/HTML^&gt;</p>
</p>
Обратите внимание, что специальные символы, используемые в DOS (такие, как "&lt;", "&gt;", "&amp;",...), необходимо предварять знаком "^".</p>
</p>
Таким образом, если мы обратимся к функции в виде GetVar('REQUEST_METHOD'), то получим в виде строки метод, которым были переданы параметры: 'GET' или 'POST'.</p>
</p>
Согласно Спецификации CGI, параметры могут быть прочитаны:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Из переменной окружения QUERY_STRING для метода GET</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 48px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Из стандартного ввода (STDIN) с помощью процедуры ReadLn для метода POST</td></tr></table></div></p>
Метод POST используется в тех случаях, когда необходимо передать большое количество параметров или большой объем данных. При использовании же метода GET для хранения всех передаваемых параметров используется переменная среды окружения, а она, как вы понимаете, не резиновая, так что ее максимального размера в некоторых случаях может не хватить...</p>
</p>
Метод GET и переменная QUERY_STRING</p>
Переменная среды окружения QUERY_STRING содержит список имен и значений параметров, переданных из формы... Но сначала рассмотри код HTML:</p>
</p>
&lt;form method="GET" action="program.exe"&gt;</p>
&lt;input type=text name="toto" value="titi"&gt;</p>
&lt;input type=submit value="GO"&gt;</p>
&lt;/form&gt;</p>
</p>
<p>Кликнув на "GO" (здесь кликать не надо, это просто пример!), вы запускаете на сервере программу "program.exe" передавая серверу запрос в виде:</p>
<p>https://www.ваш_сервер/cgi-bin/program.exe?toto=titi</p>
<p>Вы видите, что сразу за именем программы следует знак вопроса и передаваемый в программу параметр. В переменную QUERY_STRING как раз и будет помещено все, что находится после символа "?". Заметим, что точно так же можно задать параметры и в обычной ссылке:</p>
<p>&lt;a href="https://www.ваш_сервер/cgi-bin/program.exe?toto=titi"&gt;...&lt;/a&gt;</p>
<p>И последнее уточнение: если запрос содержит несколько параметров, то они отделяются друг от друга амперсандом &amp;. Кроме того, некоторые символы в значениях параметров (например, "&amp;") должны быть представлены в шестнадцатеричной форме %hh, где "hh" - шестнадцатеричный код символа в таблице ANSI. Например, символ амперсанда "&amp;" должен быть представлен в виде "%26".</p>
<p>Представьте, что вам требуется на сайте yahoo.com найти результаты поиска по ключевым словам cgi и delphi, для чего в окне поиска вы вводите "cgi + delphi".</p>
<p>Тогда в результате вашего запроса будет сгенерирован следующий URL:</p>
<p>https://search.yahoo.com/bin/search?p=cgi+%2B+delphi</p>
<p>Тем самым, вы обратитесь к программе "search" и зададите значение параметра "p" равным "cgi + delphi", при этом символ "+" будет автоматически заменен браузером на "%2B", а пробелы - на "+".</p>
<p>Метод POST</p>
<p>Для получения данных, переданных по методу POST, необходимо читать данные из "устройства стандартного ввода" STDIN. Размер данных, переданных по этому методу, помещается сервером в переменную окружения CONTENT_LENGTH.</p>
<p>Посмотрим, как это выглядит в Delphi:</p>
<pre>// Получение переданных параметров
  if getvar('REQUEST_METHOD')='POST' then begin
   parmstring:=getvar('CONTENT_LENGTH');
   if parmstring&lt;&gt;'' then begin
    size:=strtoint(parmstring);
    setlength(parmstring,size);
    for i:=1 to size do read(parmstring[i]);
   end;
  end else
   parmstring:=getvar('QUERY_STRING'); 
</pre>

<p>В заключение я предлагаю вашему вниманию маленькую CGI-программу, которая просто выводит то, что происходит на сервере:</p>
<pre>program log;
 
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
 
 WriteLn('&lt;html&gt;&lt;head&gt;&lt;title&gt;Dump CGI&lt;/title&gt;&lt;/head&gt;&lt;body&gt;');
 WriteLn('&lt;h1&gt;Dump CGI:&lt;/h1&gt;');
 WriteLn('&lt;a href=#Parms&gt;Параметры программы&lt;/a&gt;&lt;br&gt;');
 WriteLn('&lt;a href=#Query&gt;Параметры CGI&lt;/a&gt;&lt;br&gt;');
 WriteLn('&lt;a href=#Env&gt;Переменные окружения&lt;/a&gt;&lt;br&gt;');
 WriteLn('&lt;a href=#Info&gt;Дополнительная информация о CGI&lt;/a&gt;&lt;br&gt;');
 WriteLn('&lt;hr&gt;');
 
 WriteLn('&lt;a name=Parms&gt;&lt;h2&gt;ParamCount=',IntToStr(ParamCount),'&lt;/h2&gt;&lt;ul&gt;');
 WriteLn(fLog,'ParamCount=',IntToStr(ParamCount));
 
  for i:=0 to ParamCount do begin
   WriteLn('&lt;li&gt;',ParamStr(i));
   WriteLn(fLog,'-',ParamStr(i));
  end;
 
 // Стандартный Ввод
 WriteLn(fLog,'Input :');
 WriteLn('&lt;h2&gt;StdInput:&lt;/h2&gt;&lt;ul&gt;');
 if Not Eof(Input) then begin
  Read(Input,s);
  WriteLn('&lt;li&gt;',s);
  WriteLn(fLog,s);
 end;
 
 Writeln(fLog,'QUERY_STRING=',ParmString);
 
 WriteLn('&lt;a name=Env&gt;&lt;h2&gt;Переменные окружения:&lt;/h2&gt;&lt;ul&gt;');
 p:=GetEnvironmentStrings;
 while StrLen(p)&lt;&gt;0 do begin
  WriteLn('&lt;li&gt;',p);
  WriteLn(fLog,':',p);
  p:=strend(p);
  inc(p);
 end;
 WriteLn('&lt;/ul&gt;&lt;hr&gt;');
 
 WriteLn('&lt;a name=Info&gt;&lt;a href="https://www.multimania.com/tothpaul"&gt;');
 WriteLn('Дополнительная информация о CGI&lt;/a&gt;');
 WriteLn('&lt;/body&gt;&lt;/html&gt;');
 
end.
</pre>

<p class="note">Примечание:</p>
<p>Кроме стандартного вывода информация параллельно выводится еще и в лог-файл.</p>

