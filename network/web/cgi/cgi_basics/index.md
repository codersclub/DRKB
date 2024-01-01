---
Title: CGI
Date: 01.01.2007
---


CGI
===

::: {.date}
01.01.2007
:::

Аббревиатура CGI означает Common Gateway Interface, и является связевым
протоколом между формой в Web браузере (клиент) и приложением запущенным
на Web сервере (сервер). Приложение обычно называется CGI скрипт, но мы
можем использовать Дельфи для написания CGI приложений без скриптов.

Имеется два типа CGI: стандартное или консольное CGI приложение и позже
появилась версия для Windows называемая WinCGI.

1.3.1. Консольное CGI приложение

Стандартное или консольное CGI приложение взаимодействует с формой на
клиенте с помощью переменных среды (управляющая информация), стандартным
входом (данные формы) и стандартным выводом (возвращаемая динамическая
HTML страница).

1.3.2. WinCGI

Приложение WinCGI взаимодействует с формой на клиенте с помощью Windows
.INI файла вместо переменных среды. Windows .INI файл содержит
управляющую информацию, иногда данные формы и имена входного, данных и
выходного файлов.

1.3.3. Delphi и CGI

В данной главе я расскажу, как написать простое Дельфи CGI приложение,
без использования Web Modules или других Client/Server модулей.

Во первых аббревиатура CGI означает Common Gateway Interface, и это
только имя для передачи информации от клиента серверу. На клиентской
стороне это реализуется с помощью формы, содержащей только теги. На
серверной стороне

На сервере запускается CGI приложение, которое иногда называется CGI
скрипт (для примера на Unix машинах, где Perl используется для
исполнения CGI скриптов).

В данной главе я сконцентрирую внимание на написание CGI приложения для
Windows NT web сервера, и использовании 32-битной Дельфи (например
Delphi 2.x или 3.x) для данной задачи, данный код может быть также без
проблем откомпилирован в C++Builder.

Стандартное CGI приложение получает данные через стандартный вход и
должно выдать ответ через стандартный вывод. (например сгенерированную
HTML страницу). Это означает необходимость написания консольного
приложения. Если даже нет входных данных мы все равно можем использовать
CGI приложение для генерации динамических HTML страниц (например для
выдачи данных их таблицы).

1.3.4. Динамический вывод

Для начала посмотрим на стандартное "hello world" CGI приложение.
Единственное, что оно должно сделать, это вернуть HTML страницу со
строкой "hello, world". Перед тем как мы начнем делать это - обратим
внимание на следующее: CGI приложение должно сообщить миру какой (MIME)
формат оно выдает. В нашем случае это "text/html", которое мы должны
указать как: content-type: text/html, и затем одну пустую строку.

Вот код нашего первого "Hello, world!" CGI приложения:

     program CGI1;
     {$APPTYPE CONSOLE}
     begin
       writeln('content-type: text/html');
       writeln;
       writeln('<HTML');
       writeln('<BODY');
       writeln('Hello, world!');
       writeln('</BODY');
       writeln('</HTML')
     end.

 

Если вы откомпилируете данную программу в Дельфи 2 или 3 и затем
запустите ее из web браузера подключенного к web серверу, где оно
записано в исполнимом виде в исполняемом каталоге таком как cgi-bin, то
вы увидите текст "Hello, world!" на странице.

1.3.5. CGI ввод

Теперь, мы знаем как создавать CGI приложение, которое может
генерировать динамическую HTML страницу (или в действительности почти
статическую). Но как  насчет ввода? Здесь более чем одно действие: мы
должны проверять переменную DOS \'CONTENT LENGTH\' что бы знать как
много символов мы можем прочитать со стандартного ввода (если мы
попытаемся читать больше чем есть, то мы повиснем навсегда). Конечно,
это широко известный факт. Я написал компонент TBDosEnvironment чтобы вы
могли иметь доступ до переменных среды DOS:

     unit DrBobDOS;
     interface
     uses
       SysUtils, WinTypes, WinProcs, Classes;
     
     type
       TBDosEnvironment = class(TComponent)
       public
       { Public class declarations (override) }
         constructor Create(AOwner: TComponent); override;
         destructor Destroy; override;
     
       private
       { Private field declarations }
         FDosEnvList: TStringList;
         procedure DoNothing(const Value: TStringList);
     
       protected
       { Protected method declarations }
         Dummy: Word;
         function GetDosEnvCount: Word;
     
       public
       { Public interface declarations }
         function GetDosEnvStr(const Name: String): String;
         { This function is a modified version of the GetEnvVar function that appears in the WinDos unit that comes with Delphi. This function's interface uses Pascal strings instead of null-terminated strings.
         }
     
       published
       { Published design declarations }
         property DosEnvCount: Word read GetDosEnvCount write Dummy;
         property DosEnvList: TStringList read FDosEnvList write DoNothing;
       end;
     
     implementation
     
       constructor TBDosEnvironment.Create(AOwner: TComponent);
       var
         P: PChar;
       begin
         inherited Create(AOwner);
         FDosEnvList := TStringList.Create;
       {$IFDEF WIN32}
         P := GetEnvironmentStrings;
       {$ELSE}
         P := GetDosEnvironment;
       {$ENDIF}
         while P^ <> #0 do
         begin
           FDosEnvList.Add(StrPas(P));
           Inc(P, StrLen(P)+1) { Fast Jump to Next Var }
         end;
       end {Create};
     
       destructor TBDosEnvironment.Destroy;
       begin
         FDosEnvList.Free;
         FDosEnvList := nil;
         inherited Destroy
       end {Destroy};
     
       procedure TBDosEnvironment.DoNothing(const Value: StringList);
       begin
       end {DoNothing};
     
       function TBDosEnvironment.GetDosEnvCount: Word;
       begin
         if Assigned(FDosEnvList) then
           Result := FDosEnvList.Count
         else
           Result := 0;
       end {GetDosEnvCount};
     
       function TBDosEnvironment.GetDosEnvStr(const Name: String): String;
       var
         i: Integer;
         Tmp: String;
       begin
         i := 0;
         Result := '';
         if Assigned(FDosEnvList) then while i < FDosEnvList.Count do
         begin
           Tmp := FDosEnvList[i];
           Inc(i);
           if Pos(Name,Tmp) = 1 then
           begin
             Delete(Tmp,1,Length(Name));
             if Tmp[1] = '=' then
             begin
               Delete(Tmp,1,1);
               Result := Tmp;
               i := FDosEnvList.Count { end while-loop }
             end
           end
         end
       end {GetDosEnvStr};
     end.

 

Здесь список переменных среды (предоставленный Deepak Shenoy), которые
доступны для CGI программ. Даже ISAPI программы могут использовать эти
переменные:

    +-----------------------------------+-----------------------------------+
    | Environment Variable              | Purpose/Meaning/Value             |
    +-----------------------------------+-----------------------------------+
    | GATEWAY\_INTERFACE                | Версия CGI для которой            |
    |                                   | скомпилирован web сервер          |
    +-----------------------------------+-----------------------------------+
    | SERVER\_NAME                      | IP адрес сервера или имя.         |
    +-----------------------------------+-----------------------------------+
    | SERVER\_PORT                      | Порт на сервер, которые принимает |
    |                                   | HTTP запросы.                     |
    +-----------------------------------+-----------------------------------+
    | SERVER\_PROTOCOL                  | Имя и версия протокола,           |
    |                                   | используемая для обработки        |
    |                                   | запросов.                         |
    +-----------------------------------+-----------------------------------+
    | SERVER\_SOFTWARE                  | Имя (и обычно версия)             |
    |                                   | программного обеспечения сервера. |
    +-----------------------------------+-----------------------------------+
    | AUTH\_TYPE                        | Схема проверки прав используемая  |
    |                                   | сервером (NULL, BASIC)           |
    +-----------------------------------+-----------------------------------+
    | CONTENT\_FILE                     | Файл используемый для передачи    |
    |                                   | данных CGI программе (только      |
    |                                   | Windows HTTPd/WinCGI).            |
    +-----------------------------------+-----------------------------------+
    | CONTENT\_LENGTH                   | Количество байтов переданное на   |
    |                                   | стандартный вход (STDIN) как      |
    |                                   | содержимое POST запроса.          |
    +-----------------------------------+-----------------------------------+
    | CONTENT\_TYPE                     | Тип данных переданных на сервер.  |
    +-----------------------------------+-----------------------------------+
    | OUTPUT\_FILE                      | Имя файла для результата (только  |
    |                                   | Windows HTTPd/WinCGI).            |
    +-----------------------------------+-----------------------------------+
    | PATH\_INFO                        | Дополнительный, относительный     |
    |                                   | путь переданный на сервер после   |
    |                                   | имени скрипта, но до данных       |
    |                                   | запроса.                          |
    +-----------------------------------+-----------------------------------+
    | PATH\_TRANSLATED                  | Та же самая информация, но        |
    |                                   | преобразованная из относительного |
    |                                   | пути в абсолютный.                |
    +-----------------------------------+-----------------------------------+
    | QUERY\_STRING                     | Данные переданные как часть URL,  |
    |                                   | все после символа ? в URL.        |
    +-----------------------------------+-----------------------------------+
    | REMOTE\_ADDR                      | Адрес IP или имя сервера          |
    |                                   | конечного пользователя.           |
    +-----------------------------------+-----------------------------------+
    | REMOTE\_USER                      | Имя пользователя, если            |
    |                                   | используется схема проверки прав. |
    +-----------------------------------+-----------------------------------+
    | REQUEST\_LINE                     | Полный HTTP запрос представляемый |
    |                                   | сервером (зависит от сервера).    |
    +-----------------------------------+-----------------------------------+
    | REQUEST\_METHOD                   | Указывает метод передачи данных,  |
    |                                   | как часть URL (GET) или через     |
    |                                   | стандартный ввод STDIN (POST).    |
    +-----------------------------------+-----------------------------------+
    | SCRIPT\_NAME                      | Имя запущенного скрипта.          |
    +-----------------------------------+-----------------------------------+

Немного еще дополнительной, но важной информации. Немного об переменных
среды, которые особо важны для обработки запроса, и небольшое описание
по обработке стандартных CGI приложений:

REQUEST\_METHOD - указывает, как посланы данные, как POST или как GET
метод.

QUERY\_STRING - если используется GET

CONTENT\_LENGTH - если мы используем POST, то мы должны прочитать
"CONTENT\_LENGTH" символов со стандартного ввода (которые оканчиваются
"Query", подобно QUERY\_STRING при использовании метода GET).

Во всех случаях стандартное CGI приложение должно писать свой вывод на
стандартный выход, если мы используем консольное приложение.

Теперь с помощью компонента TBDosEnvironment мы создадим приложение,
которое примет все три переменных среды, описанных выше и получит
необходимые данные. После этого мы напишем код генерирующий вывод.

Правда просто? Для другого очень маленького  (39 Кб) стандартного CGI
приложения, проверьте Search Engine на моем web сайте. Краткий исходный
код будет опубликован в одной из статей в The Delphi Magazine, но я могу
сказать, что базовый протокол CGI связи не более сложный, чем
представленный здесь.

1.3.6. Input Queries

Сейчас мы попробуем прочитать запрос в стандартном CGI приложении с
помощью 32-битной версии Дельфи (Delphi 2.x или 3.x).

Обычно это двух ступенчатый процесс. Первый шаг создание HTML и
специальный CGI Form-тегов, второй шаг получение данных внутри CGI
приложения на сервере.

HTML CGI форма определяется с помощью тегов \<FORM\>...\</FORM\>.
Открывающий тег также содержит имя метода (GET or POST) и действие,
которое является URLом CGI приложения на web сервере. Например:

\<FORM ACTION=http://www.drbob42.com/cgi-bin/debug.exe METHOD=POST

...

\</FORM

Данная HTML CGI форма посылает свои данные методом POST на мой web
сервер, и выполняет программу debug.exe (из каталога cgi-bin). В данный
момент мы пока не знакомы с концепцией различий между методами POST и
GET (Я всегда использую метод POST). Мы заметим, что здесь пока нет
ничего что бы посылать на сервер методом POST, это позже. Мы должны
указать поля ввода внутри CGI формы. Для этого мы поместим некоторое
количество наиболее стандартных Windows органов управления, все они
предопределены, подобно editbox, memo, listbox, drop-down combobox,
radiobuttons, checkboxes и конечно клавиши "action" (reset или
submit).

Простой editbox это поля ввода типа "text", которое обязано иметь имя
и необязательно размер и ширину в пикселях, и может иметь значение:

\<INPUT TYPE=text NAME=login SIZE=8

 

Результатом этой фразы будет нарисован editbox в котором можно ввести до
восьми символов, и которое будет послано нашему CGI приложению как
"login=xxxxxxxx", где xxxxxxxx данные веденные на форме в окошке
подобному этому

 

Стандартное CGI приложение обязано проверить переменную среды
REQUEST-METHOD для определения метода передачи данных. В случае POST, мы
должны проверить CONTENT-LENGTH для определения количества символов,
которые необходимо прочесть со стандартного ввода. Стандартный ввод
содержит данные (такие как "login-xxxxxxxx") для нашего CGI
приложения.

Вместо написания сложного стартового кода для каждого CGI приложения, я
написал модуль DrBobCGI для выполнения всех необходимых стартовых
процедур и извлечения входных данных и доступных затем через вызов
единственной функции, называемой "Value". Так для выше приведенного
примера мы можем вызвать "Value(\'login\')" для получения строки
\'xxxxxxxx\'.

    unit DrBobCGI;
     {$I-}
     interface
     var
       ContentLength: Integer = 0;
     
       function Value(const Field: ShortString): ShortString;
       { use this function to get the CGI inputquery values }
     
     implementation
     uses
       SysUtils, Windows;
     
     var
       Data: String = '';
     
       function Value(const Field: ShortString): ShortString;
       var
         i: Integer;
       begin
         Result := '';
         i := Pos(Field+'=',Data);
         if i > 0 then
         begin
           Inc(i,Length(Field)+1);
           while Data[i] <> '&' do
           begin
             Result := Result + Data[i];
             Inc(i)
           end
         end
       end {Value};
     
     var
       P: PChar;
       i: Integer;
       Str: ShortString;
     
     type
       TRequestMethod = (Unknown,Get,Post);
     var
       RequestMethod: TRequestMethod = Unknown;
     
     initialization
       P := GetEnvironmentStrings;
       while P^ <> #0 do
       begin
         Str := StrPas(P);
         if Pos('REQUEST_METHOD=',Str) > 0 then
         begin
           Delete(Str,1,Pos('=',Str));
           if Str = 'POST' then RequestMethod := Post
           else
             if Str = 'GET' then RequestMethod := Get
         end;
         if Pos('CONTENT_LENGTH=',Str) = 1 then
         begin
           Delete(Str,1,Pos('=',Str));
           ContentLength := StrToInt(Str)
         end;
         if Pos('QUERY_STRING=',Str) > 0 then
         begin
           Delete(Str,1,Pos('=',Str));
           SetLength(Data,Length(Str)+1);
           Data := Str
         end;
         Inc(P, StrLen(P)+1)
       end;
       if RequestMethod = Post then
       begin
         SetLength(Data,ContentLength+1);
         for i:=1 to ContentLength do read(Data[i]);
         Data[ContentLength+1] := '&';
       { if IOResult <> 0 then { skip }
       end;
       i := 0;
       while i < Length(Data) do
       begin
         Inc(i);
         if Data[i] = '+' then Data[i] := ' ';
         if (Data[i] = '%') then { special code }
         begin
           Str := '$00';
           Str[2] := Data[i+1];
           Str[3] := Data[i+2];
           Delete(Data,i+1,2);
           Data[i] := Chr(StrToInt(Str))
         end
       end;
       if i > 0 then Data[i+1] := '&'
                else Data := '&'
     finalization
       Data := ''
     end.

 

Я написал кучу CGI приложений за последний год и все они используют
модуль DrBobCGIю Теперь реальное пример: стандартное CGI приложение -
гостевая книга (guestbook), в которой запрашивается ваше имя и небольшой
комментарий, написанное с помощью всего нескольких строк на Дельфи.

Вначале CGI форма:

\<HTML\>

\<BODY\>

\<H2\>Dr.Bob\'s Guestbook\</H2\>

\<FORM ACTION=http://www.drbob42.com/cgi-bin/guest.exe

METHOD=POST\>

Name: \<INPUT TYPE=text NAME=name\>\<BR\>

Comments: \<TEXTAREA COLS=42 LINES=4 NAME=comments\>

\<P\>

\<INPUT TYPE=SUBMIT VALUE="Send Comments to Dr.Bob"\>

\</FORM\>

\</BODY\>

\</HTML\>

Теперь консольное приложение:

 

    program CGI;
     {$I-}
     {$APPTYPE CONSOLE}
     uses
       DrBobCGI;
     var
       guest: Text;
       Str: String;
     begin
       Assign(guest,'book.htm'); // assuming that's the guestbook
       Append(guest);
       if IOResult <> 0 then // open new guestbook
       begin
         Rewrite(guest);
         writeln(guest,'<HTML>');
         writeln(guest,'<BODY>')
       end;
       writeln(guest,'Date: ',DateTimeToStr(Now),'<BR>');
       writeln(guest,'Name: ',Value('name'),'<BR>');
       writeln(guest,'Comments: ',Value('comments'),'<HR>');
       reset(guest);
       while not eof(guest) do // now output guestbook itself
       begin
         readln(guest,Str);
         writeln(Str)
       end;
       close(guest);
       writeln('</BODY>');
       writeln('</HTML>')
     end.

 

Вопрос:

У меня на форме две "submit" клавиши, одна на переход на предыдущую
страницу, другая переход на следующую страницу. Как определить какая из
них была нажата, чтобы я мог выполнить соответствующее действие.

Доктор Боб отвечает:

Вы должны назначить уникальное значение для каждой кнопки
"type=submit", ниже приведен соответствующий код:

\<HTML\>

\<BODY\>

Edit the information and press the SAVE button\<BR\>

To Delete information, press the DELETE button\<BR\>

\<P\>

\<FORM METHOD=POST ACTION=http://www.drbob42.com/cgi-bin/debug.exe\>

\<HR\>

\<input type=text name=name\>

\<P\>

\<input type=reset  value="RESET"\>

\<input type=submit name=action value="SAVE"\>

\<input type=submit name=action value="DELETE"\>

\</FORM\>

\</BODY\>

\</HTML\>

Вы должны получить "Action=SAVE" или "Action=DELETE" после нажатия
одной из этих кнопок.

2. HTML и CGI/WinCGI "трудный путь"

В данной главе показывается, как опубликовать вашу базу данных в
Интернете путем (1) генерации статических страниц из таблиц базы данных,
(2) написания CGI/WinCGI приложений для выполнения запросов к базе
данных без использования Delphi Web Modules.

2.1. HTML-страницы

Допустим, вы имеете базу данных с продуктами. Бумажная реклама очень
накладна. Но реклама в web это что-то новое и за приемлемую цену. Хорошо
было бы иметь вашу базу опубликованной в Интернете, не так ли? Но
организация своего собственного сайта на NT Web Server, работающего с
инструментом типа IntraBuilder или WebHub стоит больших денег, включая
время ни эксперименты и настройку. В данной главе мы покажем быстрый
путь и простой путь публикации вашей базы данных на web: просто
генерируя статические HTML страницы, базируясь на записях в таблице.
Накладно? Нет. Сложно? Я так не думаю. Позвольте указать простой путь на
небольшой базе данных.

2.1.1. Delphi и HTML

Мой главный инструмент разработчики это Дельфи, и мы напишем Delphi
Database HTML Expert в данной главе. Дельфи позволяет подсоединяться
практически к базе данных любого формата. С помощью BDE к Парадоксу и
dBASE, с помощью ODBC например к Access, и с помощью SQL Links к большим
DBMS типа InterBase, Oracle, Sybase и Informix. Также, вы можете купить
дополнительные продукты типа Apollo для связи с таблицами Clipper и
FoxPro. В этой главе мы будем использовать базы формата Парадокс.
Парадокс имеет достаточно развитый формат, что решает многие проблемы
при преобразовании полей, типов и значения из базы в HTML.

2.1.2. Basic HTML

Ввод будет преобразовываться в формат базы данных, а вывод в формат
HTML-страниц.

2.1.3. Преобразование полей

HTML страница может содержать только простой ASCII текст. Конечно, здесь
могут быть и другие вещи встроенный в текст, обычно картинки в .GIF или
.JPEG формат. Таблица базы данных содержит поля, у которых есть
значения, которые можно преобразовать в строки символов. Дельфи даже
имеет встроенное свойство "AsString" для всех основных классов
наследованных от TField. Свойство AsString в действительно преобразующие
свойство. Для TStringField, AsString может использоваться для чтения
значения из поля как строка. Для TBCDField, TCurrencyField, TDateField,
TDateTimeField, TFloatField, TIntegerField, TSmallintField, TTimeField,
и TWordField, свойство AsString преобразует тип в строку при чтении из
поля. Для TBooleanField, свойство AsString возвращает \'T\' или \'F\'.
Для TMemoField, TGraphicField, TBlobField, TBytesField или
TVarBytesField, свойство AsString должно использоваться только для
чтения из поля. Это возвращает строковое выражение \'(Memo)\',
\'(Graphic)\', \'(Blob)\', \'(Bytes)\' или \'(Var Bytes)\'
соответственно. Так как мемо поля могут содержать важную текстовую
информацию, я решил игнорировать все кроме TMemoField, и при работе с
TMemoField мы можем использовать метод SaveToStream для чтения данных из
поля, как мы увидим это позже. Так что мы можем разделить их на две
группы: те у которых мы можем использовать свойство AsString, и те у
которых нет. Мы можем определить третий тип (неизвестный - unknown), и
использовать следующие определения лоя таблиц не более 255 полей:

const

MaxField = 255;

sf\_UnKnown = 0;

sf\_String  = 1;

sf\_Memo    = 2;

 

var

FieldTypes: Array[0..Pred(MaxField)] of Byte; { default unknowns }

Мы должны просмотреть структуру таблицы для получения информации об
типах полей:

 

    with TTable.Create(nil) do
     try
       DatabaseName := ADatabase;
       TableName := ATable;
       Active := True;
       keys := -1; { no key in table }
       for i:=0 to Pred(FieldDefs.Count) do
       begin
         if Fields[i].IsIndexField then keys := i;
         FieldTypes[i] := sf_String; { default }
         if (FieldDefs[i].FieldClass = TMemoField) then
           FieldTypes[i] := sf_Memo
         else
           if (FieldDefs[i].FieldClass = TGraphicField) or
              (FieldDefs[i].FieldClass = TBlobField) or
              (FieldDefs[i].FieldClass = TBytesField) or
              (FieldDefs[i].FieldClass = TVarBytesField) then
             FieldTypes[i] := sf_UnKnown { ignore }
       end
     finally
       Free
     end;

 

2.1.4. Записи

После анализа полей таблицы, мы можем пройтись по всей таблице и
получить значения полей. Для каждой записи в таблице мы сгенерируем
HTML-страницу. Мы можем использовать имена полей как заголовки,
используя тег \<H2\> для ключевых  полей и тег \<H3\>  для не ключевых
полей. Код просматривает всю таблицу т преобразовывает поля в текст и
выводит их в HTML-файл:

    while not Eof do
    begin
      Inc(RecNr);
      System.Assign(f,FileName+'/'+PageNr(RecNr));
      System.Rewrite(f);
      writeln(f,'<HTML>');
      writeln(f,'<HEADER>');
      writeln(f,'<TITLE>');
      writeln(f,Format('%s %d/%d',[ATable,RecNr,RecordCount]));
      writeln(f,'</TITLE>');
      writeln(f,'</HEADER>');
      writeln(f,'<BODY>');
      { print fields }
      for i:=0 to Pred(FieldCount) do 
        if FieldTypes[i] > sf_UnKnown then
        begin
          if (keys >= i) then writeln(f,'<H2>')
                         else writeln(f,'<H3>');
          writeln(f,FieldDefs[i].Name,':');
          if (keys >= i) then writeln(f,'</B><BR>') { </H2> }
                         else writeln(f,'</B><BR>'); { </H3> }
          if FieldTypes[i] = sf_Memo then
            writeMemo(f,Fields[i])
          else writeln(f,Fields[i].AsString);
          if (keys = i) then writeln(f,'<HR>');
        end;
        writeln(f,'</BODY>');
        writeln(f,'</HTML>');
        System.Close(f);
        Next
      end;

 

Заметим, что я использую здесь одно недокументированное свойство HTML:
для окончания заголовка вы можете написать \</B\>, но вы должны
использовать \<BR\> для разрыва строки. Таким образом, вы можете иметь
заголовки, и текст, начинающийся правее и ниже заголовка. Пожалуйста,
учтите, что это недокументированное свойство и вы должны заменить его
раз комментировав \</H2\> и \</H3\> если вы не желаете жить на угле
\<юмор\>. Следующий листинг показывает как получить информацию из мемо
поля базы данных и поместить его в текстовый файл. И наконец после этого
мы отформатируем немного, помня что HTML игнорирует множественные
переводы строки и пробелы.

 

    procedure WriteStream(var f: Text; var Stream: TMemoryStream);
     const
       LF = #10;
       BufSize = 8192; { bigger memos are chopped off!! }
     var
       Buffer: Array[0..Pred(BufSize)] of Char;
       i: Integer;
     begin
       Stream.Seek(0,0);
       if Stream.Size > 0 then
       begin
         Stream.Read(Buffer,Stream.Size);
         for i:=0 to Pred(Pred(Stream.Size)) do
         begin
           { empty line converted to <P> break }
           if (Buffer[i] = LF) and (Buffer[i+1] = LF) then writeln(f,'<P>');
           { strip multiple spaces (are ignored anyway) }
           if not ((Buffer[i] = ' ') and (Buffer[i+1] = ' ')) then write(f,Buffer[i]);
           { start new sentence on a new line (but only in HTML doc itself }
           if (Buffer[i] = '.') and (Buffer[i+1] = ' ') then writeln(f)
         end;
         writeln(f,Buffer[Pred(Stream.Size)])
       end
       else writeln(f,' ') { empty memo }
     end {WriteStream};
     
     procedure WriteMemo(var f: Text; Field: TField);
     var Stream: TMemoryStream;
     begin
       Stream := TMemoryStream.Create;
      (Field AS TMemoField).SaveToStream(Stream);
       WriteStream(f,Stream);
       Stream.Free
     end {WriteMemo};

 

2.1.5. Страницы

Теперь у нас есть метод преобразования записей в HTML страницы, нам
также нужен путь уникальной идентификации каждой записи. Допустим, что
база данных не не содержит более 100,000 записей (Если таблица содержит
свыше 100,000 записей, то конвертирование их в HTML страницы наверно не
очень хорошая идея), Я думаю что подойдет схема где каждая запись
помещается в файл с именем "pag#####.htm", где ##### номер
записи в базе данных. Для уменьшения конфликта имен, каждая таблица
должна размещаться в своем собственном каталоге (например, BIOLIFE.HTM
каталог для BIOLIFE.DB таблиц, так что мы будем иметь
BIOLIFE.HTM/PAG00001.HTM для первой записи из BIOLIFE.DB таблицы).

 

    const
       FirstPage = 'pag00001.htm';
       LastPage: TPageName = 'pag%.5d.htm'; { format }
     
       function PageNr(Nr: Word): TPageName;
       begin
         Result := Format('pag%.5d.htm',[Nr])
       end {PageNr};

Кроме первой страницы PAG00001.HTM, нам также необходимо знать имя
последней страницы, и функцию, которая нам даст номер текущей страницы
для номера записи.

2.1.6. HTML "Живые" клавиши

Неплохо также иметь путь для навигации по записям таблицы, для этого я
использую IMAGE MAP, встроенный в HTML-страницу и работающий даже если
браузер загружает локальный файл. HTML-синтаксис для отображения
картинки следующий:

\<IMG SRC="image.gif"\>        

где image.gif это файл типа .GIF или .JPEG. Мы можем вставить опцию
USEMAP в тег, для указания имени карты образа, например:

\<IMG SRC="image.gif" USEMAP="#map"\>

Внутри страницы мы можем ссылаться на "#map", а в действительности на
картинку. Image map ничего более чем список координат и ссылок. Переход
на ссылку произойдет, мы щелкнем мышкой в указанных координатах.
HTML-синтаксис карты образа, the image map выглядит как навигационная
панель размером 25x125 пикселей:

\<MAP NAME="map"\>

\<AREA SHAPE="rect" COORDS="51,0,75,25"  HREF="next"\>

\<AREA SHAPE="rect" COORDS="76,0,100,25" HREF="last"\>

\<AREA SHAPE="rect" COORDS="101,0,125,25"HREF="this"\>

\</MAP\>

Таким образом, мы можем свой навигатор по базе данных. Для этого нам
необходимо иметь три картинки: одна для первой записи (клавиши первая и
предыдущая запрещены), одна для последней записи (клавиши следующая и
последняя запись запрещены) и одна для записей в середине таблицы (все
клавиши разрешены). В каждой ситуации я назначаю ссылку для одной из
клавиш на другую страницу. Это обеспечивает сильную обратную связь между
нажатиями на клавиши. Конечно, клавиши не могут быть надавлены, но мы
имеем очень быстрый ответ по сравнению с Java или CGI-приложениями (все
что происходит это только прыжок на другую страницу).

Вот код на Дельфи, который генерирует корректный образ и карту для
каждой записи:

      if (RecNr = 1) then { first record }
      begin
        writeln(f,'<IMG SRC="../images/navigatl.gif" '+
                   'ALIGN=RIGHT USEMAP="#map" BORDER="0">');
        writeln(f,'<MAP NAME="map">');
        writeln(f,'<AREA SHAPE="rect" COORDS="51,0,75,25"  HREF="'+
                    PageNr(2)+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="76,0,100,25" HREF="'+
                    LastPage+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="101,0,125,25"HREF="'+
                    PageNr(RecNr)+'">');
      end
      else
      if (RecNr = RecordCount) then { last record }
      begin
        writeln(f,'<IMG SRC="../images/navigatr.gif" '+
                   'ALIGN=RIGHT USEMAP="#map" BORDER="0">');
        writeln(f,'<MAP NAME="map">');
        writeln(f,'<AREA SHAPE="rect" COORDS="0,0,25,25"   HREF="'+
                    FirstPage+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="26,0,50,25"  HREF="'+
                    PageNr(RecNr-1)+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="101,0,125,25"HREF="'+
                    PageNr(RecNr)+'">');
      end
      else { middle record }
      begin
        writeln(f,'<IMG SRC="../images/navigat.gif" '+
                  'ALIGN=RIGHT USEMAP="#map" BORDER="0">');
        writeln(f,'<MAP NAME="map">');
        writeln(f,'<AREA SHAPE="rect" COORDS="0,0,25,25"   HREF="'+
                    FirstPage+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="26,0,50,25"  HREF="'+
                    PageNr(RecNr-1)+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="51,0,75,25"  HREF="'+
                    PageNr(RecNr+1)+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="76,0,100,25" HREF="'+
                    LastPage+'">');
        writeln(f,'<AREA SHAPE="rect" COORDS="101,0,125,25"HREF="'+
                    PageNr(RecNr)+'">');
      end;
      writeln(f,'</MAP>');

 

Все три образа панели навигации хранятся в общем каталоге "../images"
и дают мне шанс конвертировать множество таблиц в одно и тоже время для
всех точек только с помощью этих трех образов. В действительности, в
нашей локальной интрасети мы имеем порядка 23 таблиц преобразованных в
200 HTML страниц, и все они используют эти самые три образа.

2.1.7. Первый результат

После конвертирования базы BIOLIFE.DB, которая содержит много текстовых
данных в мемо поле и одно поле, которое мы игнорируем (image field), мы
получили следующий результат (обратите внимание на заголовок, который
показывает запись 1 из 28):

 

2.1.8. Расширенный HTML

Конечно, не всегда таблица содержит только текстовые поля. Иногда данные
из таблице удобнее представлять в виде таблицы (grid или таблице
подобной структуре). Для этого я должен ввести вас в расширенные HTML
свойства: фреймы и таблицы.

2.1.8.1. Фреймы

Фреймы это в действительности расширение HTML+, которое не
поддерживается некоторыми web браузерами. Фреймы это свойство разделения
вашей web страницы на две или более страниц. Основное свойство фреймом
то, что каждый фрейм может иметь свое собственное имя и может переходить
в другое местонахождение. Так, вы можете иметь индекс или таблицу
оглавления с левой стороны, и например действительное содержимое с
правой стороны. Для таблицы со многими записями вы можете иметь список
ключей слева (главный индекс) и одну индивидуальную запись справа.
Ключевое значение слева конечно ссылка на актуальную страницу с данными
в правом фрейме. Как только мы щелкнем по ссылке в главном индексе
(левый фрейм) в правом фрейме появятся данные относящиеся к этому ключу.
Дополнительно к двум фреймам мы должны иметь главную специальную
страницу, в которой определяем количество и относительные позиции (и
размер) этих фреймов. Я использую для левого фрейма имя "Menu" и
размер 32% от текущей ширины экрана, для правого фрейма имя "Main" и
остаток ширины экрана. В HTML коде это выглядит следующим образом:

\<HTML\>

\<FRAMESET COLS="32%,*"\>

\<FRAME  SRC="pag00000.htm" NAME="Menu"\>

\<FRAME  SRC="pag00001.htm" NAME="Main"\>

\</FRAMESET\>

\</HTML\>

Конечно, вы можете иметь более значимые имена для фреймов (например
имена таблиц), но Я оставлю это на совесть читателя.

2.1.8.2. Таблицы

Использование фреймов для показа содержимого индекса и одной записи это
одна из возможностей. Но имеется возможность отображать это и как
таблицу. HTML 3.0 поддерживает ТАБЛИЦЫ, которое является одним из
наиболее используемых свойств наших дней. Таблицы с рамками и без могут
использоваться для всего, что вы не можете сделать нормальным путем
(например, нет метода иметь множественные колонки в HTML странице, без
использования таблиц). В нашем случае это может быть двух колоночная
таблица с рамкой. В левой колонке мы просто отображаем название каждого
поля, а правой колонке - значение этого поля. Подобно предыдущему
текстовому решению, единственная вещь которую нужно изменить это коды
заголовков в коды таблицы. \<TR\> начинает новую строку таблицы,
заканчивая ее тегом \</TR\>. Тег \<TD\> открывает новое поле,
закачивающее тегом \</TD\>. Для окончательно преобразования, мы должны
написать специальную индексную HTML страницу как файл (файл g в нашем
случае). Преобразованный листинг выглядит следующим образом:

    if (keys >= 0) then
    begin
      writeln(g,'<TR>');
      write(g,'<TD><A HREF="../',FileName,'/',PageNr(RecNr), '"TARGET="Main">');
      writeln(g,RecNr:3,'</A></TD>')
    end;
      { print fields }
    writeln(f,'<TABLE BORDER>');
    for i:=0 to Pred(FieldCount) do if FieldTypes[i] > sf_UnKnown then
    begin
      writeln(f,'<TR>');
      write(f,'<TD><B>',FieldDefs[i].Name,'</B></TD><TD>');
      if FieldTypes[i] = sf_Memo then
        writeMemo(f,Fields[i])
      else writeln(f,Fields[i].AsString);
      writeln(f,'</TD></TR>');
      if (keys >= i) then
        writeln(g,'<TD>',Fields[i].AsString,'</TD>')
    end;
    if (keys >= 0) then writeln(g,'</TR>');
    writeln(f,'</TABLE>');

 

2.1.9. Последний вариант конвертора

Имея объединенные фреймы и таблицы ы нашем конверторе, мы можем
переходить от простой BIOLIFE.DB таблицы к более реалистичной таблицы
продуктов, например PARTS.DB. Данная таблица имеет больше цифровых и
меньше "memo" (или тестовых) данных, и поэтому выглядит лучше когда
данные отображаются в табличном виде с простыми заголовками.

 

"Живые" HTML кнопки работают также как и ранее, и мы можем выбирать
любую запись из фрейма с индексом. Заметим, что содержимое правого
фрейма также содержит текущую позицию (и общее количество записей) в
таблице, так как это тоже генерируется на лету.

В данный момент мы уже имеем два пути для преобразования таблицы в HTML
страницу, или с помощью простого текстового конвертора или с помощью
более сложного конвертора фрейм /таблица, Я написал маленькую программу,
которая использует оба метода. Это простое консольное приложение,
которое нуждается только в имени таблицы как аргумент командной строки
(таблица должна находиться в текущем каталоге). По умолчанию
используется нормальный метод преобразования, тем не менее, если ввести
более одного параметра, то будет использоваться метод преобразования во
фреймы с таблицами (сам дополнительный параметр игнорируется).

 

    program BDE2HTML;
     {$IFDEF WIN32}
     {$APPTYPE CONSOLE}
     uses
     {$ELSE}
     uses WinCrt,
     {$ENDIF}
          Convert, HTables;
     begin
       case ParamCount of
           0: writeln('Usage: BDE2HTML tablename');
           1: Convert.DatabaseHTML('',ParamStr(1));
         else HTables.DatabaseHTML('',ParamStr(1))
       end
     end.

 

2.1.10. Линейка прогресса

Конвертирование маленьких таблиц в небольшое количество страниц не
занимает много времени, не более нескольких секунд. Но конвертирование
больших таблиц в сотни или тысячи страниц может занять несколько минут.
По этой причине я сделал небольшой прогресс индикатор к конвертору.
Простая форма с компонентом TGauge. Мы устанавливаем MinValue и Value в
0, а MaxValue в количество записей в таблице, и после генерации страницы
мы увеличиваем значение Value на единицу. Небольшие часики в левом
верхнем углу показываю количество пройденного времени:

 

2.1.11. Производительность

Единственная разница между реальным приложением обработки баз данных
(например с использованием BDE) и браузером базы данных это
производительность. Наше "приложение" не нуждается ни в каких других
приложениях, кроме стандартного браузера. Посылка данных по сети и
взаимодействие эмулируется с помощью щелчков по картинке-навигатору и
перехода по гипер-ссылке. Ни BDE или ISAPI/NSAPI программы не могут
выполнять подобную архитектуру. Конечно, мы имеем только статические
страницы, поэтому здесь нет возможности делать динамические запросы или
преобразование базы данных. Поэтому нам нет нужды разрабатывать другие
вещи, как CGI скрипты. Но наши сгенерированные страницы могут
"имитировать" Парадокс базу, даже не Unix Web сервере! И особенно для
баз, в которых изменения очень редки, например раз в неделю, это
превосходная схема быстрой и простой организации web сайта.

2.1.12. Заключение

В данной главе мы увидели быстрый и простой путь преобразование Дельфи
таблиц в платформа независимые HTML страницы; или текстовые с
заголовками или в виде фрейм/таблица. Мы изучили, как использовать HTML
технологию, включая карты-картинки, для имитации "живых" клавиш и
выполнения действия. Данная технология может быть применима, как в
Интернет, так и в Интранет приложениях (как минимум для меня). И в
результате хорошая производительность по сравнению с другими решениями
(ограничением может быть нехватка места на сервере, если вы имеете
действительно большое количество HTML страниц). Что еще осталось (как
задание для читателя) это поддержка показа картинок из базы данных и
запросы (например, для генерации master-detail HTML страниц).

2.2. CGI/WinCGI приложения

Допустим, вы имеете базу данных с продуктами. Бумажная реклама очень
накладна. Но реклама в web это что-то новое и за приемлемую цену. Хорошо
бы было иметь вашу базу опубликованной в Интернете, не так ли? Но
организация своего собственного сайта на NT Web Server, работающего с
инструментом типа IntraBuilder или WebHub стоит больших денег, включая
время ни эксперименты и настройку. В данной главе мы покажем быстрый
путь и простой путь публикации вашей базы данных на web: просто
генерируя статические HTML страницы, базируясь на записях в таблице.
Накладно? Нет. Сложно? Я так не думаю. Позвольте указать простой путь на
небольшой базе данных.

2.2.1.Дельфи и CGI

В то время как HTML это стандарт для гипертекстовых документов, CGI
означает Common Gateway Interface, и реализует связевой интерфейс между
клиентом (Web браузер) и сервером (Web сервером). Имеется, по крайней
мере, две различных формы CGI, стандартный CGI и высокоуровневый,
называемый WinCGI (Windows (NT) CGI). Первый использует переменные среды
и стандартные потоки ввода/вывода, второй использует файл формата
Windows INI (в которых указываются имена входного и выходного файлов)
для связи между клиентом и сервером, на котором запущено CGI приложение.
Дельфи 2 CGI приложения являются не визуальными приложениями, то есть
консольными приложениями, где на входе информация (запрос) от клиента, а
на выходе динамический HTML документ, сгенерированный на лету и
отправляемый обратно на клиенту в Web браузер. Информация, введенная на
клиенте посылается серверу и используется для генерации HTML страницы,
может быть послана двумя путями: или с помощью переменных среды
(стандартный CGI) или с помощью Windows INI файлов (WinCGI). В данной
главе мы сфокусируем свое внимание только на стандартных CGI
приложениях!

2.2.2. CGI Формы

Для начала мы должны определить, что хочет клиент, как выглядит
клиентская сторона. Как можно послать серверу информацию для выполнения?
Для этого мы должны использовать специальное расширение HTML, называемое
FORMS. Подобно Дельфи формам, форма это место на котором располагаются
органы управления, такие как edit box, listbox, combobox, button или
multi-line text field. В отличии от Дельфи мы имеем не визуальную среду
разработки формы с использованием HTML кодов. Для примера приведу часть
файла DELBOOKS.HTM. Полный файл можно взять на
http://members.aol.com/drbobnl/delbooks.htm.

\<FORM ACTION="http://www.drbob42.com/cgi-bin/delbooks.exe"
METHOD="POST"\>

\<UL\>

\<INPUT TYPE="radio" NAME="DELPHI" VALUE="0" CHECKED\>Delphi 1.0x
or 2.0x\<BR\>

\<INPUT TYPE="radio" NAME="DELPHI" VALUE="1"\>Delphi 1.0x
only\<BR\>

\<INPUT TYPE="radio" NAME="DELPHI" VALUE="2"\>Delphi 2.0x only

\<P\>

\<LI\>Level:

\<BR\>\<SELECT NAME="Level"\>

   \<OPTION VALUE=""\> don\'t care

   \<OPTION VALUE="1"\> Beginning

   \<OPTION VALUE="2"\> Intermediate

   \<OPTION VALUE="3"\> Advanced

   \</SELECT\>

\<P\>

\</UL\>

\<HR\>

\<P\>

\<INPUT TYPE="RESET" VALUE="Reset Query"\>

\<INPUT TYPE="SUBMIT" VALUE="Get Results"\>

\</FORM\>

Данный код показывает на форме два типа органов управления: три радио
кнопки (выбор между "Delphi 1.0x or 2.0x", "Delphi 1.0x only" и
"Delphi 2.0x only"), и combobox с четырьмя значениями ("don\'t
care", "Beginning", "Intermediate" и "Advanced"). Так же имеется
две обычные кнопки, одна типа "RESET", для сброса введенной информации
и одна типа "SUBMIT", для отправки введенной информации. Для
выполнения запроса из Web браузера на Web сервер необходимо нажать
кнопку типа SUBMIT (в нашем случае кнопку с текстом "Get Results"). Но
как сервер узнает, какое CGI приложение запускать для обработки запроса?
Для этого мы должны обратить внимание на параметр ACTION в теге FORM
(первая строка кода). Параметр ACTION указывает точное местонахождение
CGI приложения, в нашем случае это
http://www.drbob42.com/cgi-bin/delbooks.exe (но ребята не пытайтесь
запускать это у себя дома, так как это ссылка внутри моей Интрасети, а
не Интернета).

В действительности "официальная" DELBOOKS.HTM содержит гораздо больше
органов управления. Она также доступна на
http://members.aol.com/drbobnl/delbooks.htm.

 

Нажатие на клавишу "Get Result" посылает информацию на Web сервер,
котрый запускает delbooks.exe приложение с информацией введенной на
форме. В нашем случае это может быть DELPHI="2", LEVEL="3",
TITLE="", AUTHOR="Bob\_Swart", PUBLISHER="" и ISBN="" (символ
подчеркивания здесь означает пробел). Delphi 2 CGI приложение
delbooks.exe обрабатывает полученную информацию, выполняет запрос и
генерирует динамическую HTML страницу, которую отправляет на стандартный
вывод. Web затем отправляет ее клиенту в его Webбраузеру который
отображает ее на экране.

2.2.3. Переменные среды

Стандартное CGI приложение должно анализировать переменные среды для
определения метода передачи и размера посылаемой информации через
стандартный ввод. Для получения списка переменных среды я всегда
использую простой компонент, который я написал очень давно и компилирую
его с помощью директив условной компиляции, как в Дельфи 1, так и в
Дельфи 2.

 

    unit TBDosEnv;
     interface
     uses
       SysUtils, WinTypes, WinProcs, Classes;
     
     type
       TBDosEnvironment = class(TComponent)
       public
       { Public class declarations (override) }
         constructor Create(AOwner: TComponent); override;
         destructor Destroy; override;
     
       private
       { Private field declarations }
         FDosEnvList: TStringList;
     
       protected
       { Protected method declarations }
         function GetDosEnvCount: Word;
     
       public
       { Public interface declarations }
         function GetDosEnvStr(Const Name: String): String;
         { This function is a modified version of the GetEnvVar function that
           appears in the WinDos unit that comes with Delphi. This function's
           interface uses Pascal strings instead of null-terminated strings.
         }
         property DosEnvCount: Word read GetDosEnvCount;
         property DosEnvList: TStringList read FDosEnvList;
       end;
     
     implementation
     
       constructor TBDosEnvironment.Create(AOwner: TComponent);
       var P: PChar;
           i: Integer;
       begin
         inherited Create(AOwner);
         FDosEnvList := TStringList.Create;
         {$IFDEF WIN32}
         P := GetEnvironmentStrings;
         {$ELSE}
         P := GetDosEnvironment; { Win API }
         {$ENDIF}
         i := 0;
         while P^ <> #0 do
         begin
           Inc(i);
           FDosEnvList.Add(StrPas(P));
           Inc(P, StrLen(P)+1) { Fast Jump to Next Var }
         end;
       end {Create};
     
       destructor TBDosEnvironment.Destroy;
       begin
         FDosEnvList.Free;
         FDosEnvList := nil;
         inherited Destroy
       end {Destroy};
     
       function TBDosEnvironment.GetDosEnvCount: Word;
       begin
         Result := 0;
         if Assigned(FDosEnvList) then Result := FDosEnvList.Count
       end {GetDosEnvCount};
     
       function TBDosEnvironment.GetDosEnvStr(Const Name: String): String;
       var i: Integer;
           Tmp: String;
       begin
         i := 0;
         Result := '';
         if Assigned(FDosEnvList) then while i <FDosEnvList.Count >do
         begin
           Tmp := FDosEnvList[i];
           Inc(i);
           if Pos(Name,Tmp) = 1 then
           begin
             Delete(Tmp,1,Length(Name));
             if Tmp[1] = '=' then
             begin
               Delete(Tmp,1,1);
               Result := Tmp;
               i := FDosEnvList.Count { end while-loop }
             end
           end
         end
       end {GetDosEnvStr};
     end.

 

Данный компонент получает список переменных среды во время своего
создания. Свойство DosEnvCount и DosEnvList является свойством только
для чтения и поэтому лучше его создавать его в на ходу, а не бросать на
форму, так как берется только \'свежий\' список переменных среды, а не
загружается из .DFM файла).

2.2.4. Анализ

Среди переменных среды есть переменная с именем REQUEST\_METHOD. Она
должна иметь значение POST для нашего примера (Я не люблю другие
методы). Затем мы должны найти размер информации, которая передана нам.
Для этого мы должны получить переменную CONTENT\_LENGTH. Сама информация
поступает к нам через стандартный ввод (без маркера конца файла, поэтому
наша задача не пытаться читать больше, чем нам передано). Данные
поступающие через стандартный ввод имеют следующую форму FIELD=VALUE и
разделяется с помощью символа \'&\'. Например: AUTHOR="Bob\_Swart"&.
Поскольку мы имеем весь входной поток, как одну длинную строку, то мы
можем быстро найти параметр AUTHOR с помощью следующей функции:

 

    var
       Data: String;
     
       function Value(Const Field: ShortString): ShortString;
       var i: Integer;
       begin
         Result := '';
         i := Pos(Field+'=',Data);
         if i = 0 then
         begin
           Inc(i,Length(Field)+1);
           while Data[i] <> '&' do
           begin
             Result := Result + Data[i];
             Inc(i)
           end
         end
       end {Value};

 

Следующий шаблон кода показывает как динамически создать переменную
TBDosEnvironment, прочитать информацию со стандартного ввода и получить
строку готовую для анализа переменных формы.

 

    {$APPTYPE CONSOLE}
     var
       Data: String;
       ContentLength,i,j: Integer;
     
     begin
       writeln('HTTP/1.0 200 OK');
       writeln('SERVER: Dr.Bob''s Intranet WebServer 1.0');
       writeln('CONTENT-TYPE: TEXT/HTML');
       writeln;
       writeln('<HTML>');
       writeln('<BODY>');
       writeln('<I>Generated by Dr.Bobs CGI-Expert on </I>',DateTimeToStr(Now));
     
       with TBDosEnvironment.Create(nil) do
       begin
         for i := 0 to Pred(DosEnvCount) do
         begin
           if Pos('REQUEST_METHOD',DosEnvList[i])  0 then
           begin
             Data := DosEnvList[i];
             Delete(Data,1,Pos('=',Data))
           end
         end;
     
         if Data = 'POST' then
         begin
           ContentLength := StrToInt(GetDosEnvStr('CONTENT_LENGTH'));
           SetLength(Data,ContentLength+1);
           j := 0;
           for i:=1 to ContentLength do
           begin
             Inc(j);
             read(Data[j]);
           end;
           Data[j+1] := '&';
           { now call Value or ValueAsInteger to obtain individual values }
         end;

 

Заметим, что первые три "writeln" строки, посылаемые на стандартный
вывод, необходимы для браузера, что бы сообщить ему, что содержимое
страницы имеет тип TEXT/HTML.

2.2.5. Базы данных

При написании CGI приложений, вам необходим, какой то путь для доступа к
данным базы. Одним из простых решений будет использование BDE и
помещение ваших данных в таблицы Парадокса или dBASE. Если по какой либо
причине BDE не инсталлировано на вашем NT Web сервере (может быть ваш
дружественный Internet Provider не предоставляет вам BDE), вы можете
использовать технику старых дней, используйте вместо базы данных файл
записей.. Все что вам нужно, определить тип TRecord  и написать
программу, которая конвертирует вашу базу данных в file of TRecord.

2.2.6. Преобразование

Если вы посмотрите на список полей Парадокса, то вам не составит труда
понять, что не все поля можно просто конвертировать в текстовый формат,
например типа Memo обычно не помещаются в короткие строки (Short
String). А как начет Blob? Для данного типа полей я составил небольшую
таблицу конвертирования.

  ------------------------------------------- ------------------------------
  Paradox field type                          ObjectPascal conversion type
  TStringField (size)                         String[length]
  TIntegerField, TWordField, TSmallIntField   Integer
  Currency                                    Double
  Memo, Blob                                  n/a (ignored)
  ------------------------------------------- ------------------------------

Использую данную таблицу не трудно небольшую программу, которая берет на
вход таблицу и создает программу определения записи на Паскале.

    {$APPTYPE CONSOLE}
     uses DB, DBTables;
     
     var i: Integer;
     begin
       if ParamCount = 1 then with TTable.Create(nil) do
       try
         TableName := ParamStr(1);
         Active := True;
         writeln('Type');
         writeln('  TRecord = record');
         for i:=0 to Pred(FieldDefs.Count) do
         begin
           if (FieldDefs[i].FieldClass = TStringField) then
             writeln(' ':4,FieldDefs[i].Name,': String[',FieldDefs[i].Size,'];')
           else
           begin
             if (FieldDefs[i].FieldClass = TIntegerField) or
                (FieldDefs[i].FieldClass = TWordField) or
                (FieldDefs[i].FieldClass = TSmallintField) then
               writeln(' ':4,FieldDefs[i].Name,': Integer;')
             else
               if (FieldDefs[i].FieldClass = TCurrencyField) then
                 writeln(' ':4,FieldDefs[i].Name,': Double;')
               else
                 writeln('{ ':6,FieldDefs[i].Name,' }')
           end
         end
       finally
         writeln('  end;');
         Free
       end
       else
         writeln('Usage: record tablename')
     end.

 

Конечно, таблица трансляции и программа определения записи должны быть
расширены, что включить и другие типы полей Парадокса, но для примера и
этого достаточно.

2.2.7. Записи

После осознания, что мы можем писать на Delphi 2 CGI приложения без
использования BDE, мы решили сгенерировать тип записи для нашей таблицы
delbooks.db и конвертировать ее записи в файл записей. Использую
программ RECORD.EXE из предыдущей главы мы получили следующее
определение записи.

    Type
       TRecord = record
         ISBN: String[16];
         Title: String[64];
         Author: String[64];
         Publisher: String[32];
         Price: Double;
         Code: String[7];
         { Comments }
         Level: Integer;
         TechnicalContentsQuality: Integer;
         QualityOfWriting: Integer;
         ValueForMoney: Integer;
         OverallAssessment: Integer;
         { Cover }
       end;

 

Теперь нам осталось написать сам конвертор, который в цикле
просматривает записи таблицы, помещает их в запись и записывает в файл.

    {$APPTYPE CONSOLE}
     uses DB, DBTables, SysUtils;
     
     var i: Integer;
         Rec: TRecord;
         F: File of TRecord;
     begin
       if ParamCount = 1 then with TTable.Create(nil) do
       try
         System.Assign(f,ChangeFileExt(ParamStr(1),'.REC'));
         Rewrite(f);
         TableName := ParamStr(1);
         Active := True;
         First;
         while not Eof do with Rec do
         begin
           ISBN := FieldByName('ISBN').AsString;
           Title := FieldByName('Title').AsString;
           Author := FieldByName('Author').AsString;
           Publisher := FieldByName('Publisher').AsString;
           Price := FieldByName('Price').AsFloat;
           Code := FieldByName('Code').AsString;
           Level := FieldByName('Level').AsInteger;
           TechnicalContentsQuality :=
              FieldByName('TechnicalContentsQuality').AsInteger;
           QualityOfWriting := FieldByName('QualityOfWriting').AsInteger;
           ValueForMoney := FieldByName('ValueForMoney').AsInteger;
           OverallAssessment := FieldByName('OverallAssessment').AsInteger;
           write(f,Rec);
           Next
         end
       finally
         System.Close(f);
         Free
       end
       else
         writeln('Usage: convert tablename')
     end.

 

Данная программа может использоваться для полного преобразования таблицы
delbooks.db в файл delbooks.rec с типом записи TRecord. Delphi 2 CGI
приложение может просто открыть этот файл и читать любую запись без
использования BDE. Конечно, преобразование записей не просто сделать, но
для этого мы имеем всегда оригинальную базу и можем запускать 
периодически программу преобразования. Так как я добавляю всего
несколько записей примерно раз в два месяца, то меня это не очень
волнует.

2.2.8. Производительность

Единственное различие между обычным CGI приложением, которое использует
BDE для получения данных и нашим приложением без использования BDE это
производительность. Кроме того, наше CGI всего лишь 70 KB, оно не
нуждается в загрузке BDE, так что время загрузки еще меньше (в
результате еще более высокая производительность). В действительности
реальные CGI приложения, использующие BDE, часто используют ISAPI
(Information Server API) или NSAPI (Netscape Server API) расширения для
сохранения CGI приложения "все-время-в-полете (in the air)".

Еще больше можно повысить производительность, если вместо файла записей
использовать массив записей с предварительно инициализированными
значениями! Вместо создания файла с записями, Я генерирую Паскаль код
для этой цели. Таким образом, я могу генерировать исходный Паскаль код
сразу с нужной информацией. Не нужды в файле записей. И сразу после
компиляции я имею одиночное приложение на Дельфи 2, размером всего 77824
байта, которое содержит информацию об 44 книгах внутри самого себя.

Книги внутри, разбор переменных среды, чтение стандартного ввода,
генерация HTML страницы и отправка ее на стандартный вывод с
динамическим формированием содержимого в зависимости от запроса на
форме. Уверен, что единственный способ получить еще более быстрое
приложение, это вернуться обратно к статическим страницам без запросов.

2.2.9. Подсчет обращений

Код для подсчета обращений весьма прост. Для поля на форме, которое было
выбрано, мы проходим через все записи и добавляем единичку в
соответствующую запись при совпадении информации.

    if DataRec.Author <> '' then
    begin
    {$IFDEF DEBUG}
      writeln('Author: ',DataRec.Author,'<BR>');
    {$ENDIF}
      for i:=1 to Books16 do
        if Pos(DataRec.Author,Book16[i].Author) <> 0 then
          Inc(Result16[i]);
      for i:=1 to Books32 do
        if Pos(DataRec.Author,Book32[i].Author) <> 0 then
    Inc(Result32[i])
    end;

 

Заметим, что конструкция {$IFDEF DEBUG} может быть использована для
вывода значения входного поля в стандартный вывод, так что мы можем
использовать наше CGI приложение для отладки формы. Отладка вашего CGI
приложения может оказать трудной задачей, поскольку вам нужен Web сервер
и браузер для этого...

2.2.10. Результаты запроса

Теперь посмотрим на последнюю часть CGI приложения: часть, в которой
генерируется HTML код. Здесь я использую другое свойство расширенного
HTML, именованные таблицы, что бы вывод выглядел красивее. Для каждой
записи, у которой счетчик более единицы, я выводу счетчик, название,
автора, издательство, ISBN, уровень, техническое содержание, качество
книги, стоимость и общее значение. Я также включаю ссылку из названия на
другое место, где находится более подробное описание. С помощью этого
великолепного свойства динамических HTML страниц: вы даже можете
включать ссылки на статические страницы, так как результат запроса,
часто стартовая точка для прыжка в другое место!

    writeln('<HR>');
    writeln('<P>');
    writeln('<H3>The following books have been found for you:</H3>');
    writeln('<TABLE BORDER>');
    writeln('<TR>');
    writeln('<TH><B>Hits</B></TH>');
    writeln('<TH><B>Title</B></TH>');
    writeln('<TH><B>Author</B></TH>');
    writeln('<TH><B>Publisher</B></TH>');
    writeln('<TH><B>ISBN</B></TH>');
    writeln('<TH><B>Level</B></TH>');
    writeln('<TH>Con</TH>');
    writeln('<TH>Wri</TH>');
    writeln('<TH>Val</TH>');
    writeln('<TH><B>Tot</B></TH>');
    writeln('</TR>');

 

После того как заголовок написан, самое время выводить сами записи. Я не
хочу сортировать их по рейтингу от 5 до 1, так что я просто иду по
списку книг и печатаю каждую со своим рейтингом. Этот путь, потому что я
знаю, что книги уже отсортированы по рейтингу в основной базе
delbooks.db (которая отсортирована по уровню и рейтингу). Обычно книги в
верху списка уже лучший ответ на заданный вопрос.

 

    if DataRec.Delphi2 then
      begin
        for Hits := 5 downto 1 do
        begin
          for i:=1 to Books32 do if Result32[i] = Hits then
          begin
            writeln('<TR>');
            writeln('<TD>',Roman[Hits],'</TD>');
            writeln('<TD><A HREF="',root32,Book32[i].HREF,'">',Book32[i].Title,'</A></TD>');
            writeln('<TD>',Book32[i].Author,'</TD>');
            writeln('<TD>',Book32[i].Publisher,'</TD>');
            writeln('<TD>',Book32[i].ISBN,'</TD>');
            writeln('<TD>',Level[Book32[i].Level],'</TD>');
            writeln('<TD>',Book32[i].TechnicalContentsQuality,'</TD>');
            writeln('<TD>',Book32[i].QualityOfWriting,'</TD>');
            writeln('<TD>',Book32[i].ValueForMoney,'</TD>');
            writeln('<TD><B>',Book32[i].OverallAssessment,'</B></TD>');
            writeln('</TR>')
          end
        end;
        if DataRec.Delphi1 then writeln('<TR></TR>')
      end;
     
      if DataRec.Delphi1 then
      begin
        for Hits := 5 downto 1 do
        begin
          for i:=1 to Books16 do if Result16[i] = Hits then
          begin
            writeln('<TR>');
            writeln('<TD>',Roman[Hits],'</TD>');
            writeln('<TD><A HREF="',root16,Book16[i].HREF,'">',Book16[i].Title,'</A></TD>');
            writeln('<TD>',Book16[i].Author,'</TD>');
            writeln('<TD>',Book16[i].Publisher,'</TD>');
            writeln('<TD>',Book16[i].ISBN,'</TD>');
            writeln('<TD>',Level[Book16[i].Level],'</TD>');
            writeln('<TD>',Book16[i].TechnicalContentsQuality,'</TD>');
            writeln('<TD>',Book16[i].QualityOfWriting,'</TD>');
            writeln('<TD>',Book16[i].ValueForMoney,'</TD>');
            writeln('<TD><B>',Book16[i].OverallAssessment,'</B></TD>');
            writeln('</TR>')
          end
        end
      end;
     
      writeln('</TABLE>');
      writeln('<HR>');
      writeln('<A HREF="http://www.drbob42.com">Dr.Bobs Delphi Clinic</A>');
      writeln('</BODY>');
      writeln('</HTML>');
      writeln;
      Free
    end

 

2.2.11. Отладка CGI

Страницу HTML с результатом, сгенерированную по запросу мы модем увидеть
выполнив CGI приложение. Для этого требуется (персональный) Web сервер.
По этому я написал небольшую программу отладки, используя Delphi 2.01 и
NetManage HTML control:

 

2.2.12. Заключение

Я надеюсь, что я показал, как мы можем писать интерактивные Интернет
(Интранет) CGI приложения с помощью Delphi 2 используя CGI, WinCGI и
Delphi 3 ISAPI/NSAPI Web Modules. Лично я планирую делать многое с
помощью Дельфи для Интернет и Интранет.

 

Интернет решения от доктора Боба (http://www.drbob42.com)

\(c) 2000, Анатолий Подгорецкий, перевод на русский язык
(<https://nps.vnet.ee/ftp>)
