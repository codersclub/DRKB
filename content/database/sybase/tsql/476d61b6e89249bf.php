<h1>Добавление, изменение и удаление данных</h1>
<div class="date">01.01.2007</div>


<p>Добавление, изменение и удаление данных</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Операторы модификации данных</td></tr></table></div>&nbsp;</p>
Команда insert (вставить) позволяет добавлять новые строки в базу данных. Команда update (обновить) позволяет изменить существующие в базе данные. Команда delete (удалить) удаляет данные из базы. А команда writetext (запись текста) позволяет добавлять или изменять тектовые (text) и графические (image) данные без записи больших массивов в системный журнал транзакций.</p>
Все эти операторы вместе называются операторами модификации данных. В этой главе также рассматривается команда truncate table (очистить таблицу), удаляющая все строки в таблице. Другим способом добавления данных в таблицу является их непосредственная перепись из файла с помощью программы-утилиты bcp. Детальная информация об этих возможностях находится в Справочном Руководстве SQL сервера и в Пособии по утилитам SQL Сервера для операционной системы пользователя.</p>
Пользователь может модифицировать данные с помощью одного из операторов insert, update и delete только в одной таблице. Однако, исходные для модификации данные могут выбираться из других таблиц, и даже из других баз данных. Эта возможность является расширением языка Transact-SQL по отношению к стандартной версии языка SQL.</p>
Кроме таблиц, команды модификации данных с некоторыми ограничениями можно применять и к вьюверам, о чем будет рассказано в следующей главе 10: “Вьюверы: ограниченный доступ к данным”. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Права доступа</td></tr></table></div>&nbsp;</p>
Команды модификации данных доступны не каждому пользователю. Владелец базы данных и владельцы ее объектов с помощью команд grant (предоставить) и revoke (отменить) предоставляют отдельным пользователям право на модификацию данных. </p>
Право или привилегии на различные виды модификации данных могут быть предоставлены отдельным пользователям, группам пользователей&nbsp; или всем пользователям. Предоставление этих прав обсуждается в Руководстве пользователя по средствам ограничения доступа SQL Сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ссылочная целостность</td></tr></table></div>&nbsp;</p>
Команды insert, update, delete, и truncate table позволяют изменять данные в базе данных. Однако, если изменить данные в одной таблице и не изменить соответствующие данные в других таблицах, то могут возникнуть противоречия.</p>
Например, если пользователь обнаружил, что в столбец авторского идентификатора au_id для Сильвии Пантели (Sylvia Panteley) введено неправильное значение, а затем изменил его в таблице authors, то ему следует также изменить его в таблице titleauthor и в других таблицах базы данных, в которых имеется этот столбец. Если этого не сделать, то невозможно будет, например, найти названия книг этого автора, поскольку нельзя будет сделать соединение по столбцу au_id.</p>
Общая проблема согласованности данных при их модификации в таблицах&nbsp; базы данных называется проблемой ссылочной целостности. Одним из способов решения этой проблемы является создание специальных процедур, называемых триггерами, которые автоматически запускаются, когда выполняются команды insert, update и delete (команда truncate table не приводит к запуску триггера). Другой способ состоит в определении ограничений ссылочной целостности непосредственно в таблице. Триггера обсуждаются в главе 15: “Триггера: обеспечение ссылочной целостности”, а ограничения целостности рассматриваются в главе 17: “Создание баз данных и таблиц”. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Транзакции</td></tr></table></div>&nbsp;</p>
Копии старого и нового содержимого каждой строки при каждом выполнении оператора модификации данных вносятся в журнал транзакций (за исключением команды writetext). Это означает, что если пользователь запустил транзакцию командой begin transaction (начать транзакцию) и, обнаружив ошибку, решил ее отменить, то сервер сможет восстановить прежнее состояние базы данных, в котором она находилась до начала транзакции.</p>
&nbsp;</p>
Замечание: Изменения, произведенные на удаленном SQL сервере с помощью вызова удаленной процедуры (RPC), не могут быть восстановлены. </p>
&nbsp;</p>
По умолчанию при выполнении команды writetext копии данных не записываются в журнал транзакций. Это позволяет не переполнять его слишком&nbsp; большими массивами текстовой и графической информации, которые могут содержаться в полях text и image. Если установлена опция with log (с регистрацией) для команды writetext, то изменение состояния, вызываемое этой команды, вместе с копиями соответствующих данных также будут записываться в журнал транзакций.</p>
Более детальное обсуждение транзакций будет сделано в главе 17: “Транзакции: Сохранение согласованности данных и их восстановление”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование демонстрационной базы данных </td></tr></table></div>&nbsp;</p>
Если пользователь будет выполнять все примеры, приведенные в этой главе, то, по-видимому, целесообразно начать работу с исходной копией базы данных pubs2, а затем вернуть ее в первоначальное состояние после окончания работы. Для получения исходной копии базы данных pubs2 следует обратиться к системному администратору. </p>
Если работа начинается с исходной копией базы данных pubs2, то, пользователь может сделать временными, все произведенные им изменения, путем включения всех операторов модификации данных в транзакцию с последующей отменой этой транзакции при окончании работы с этой главой. Транзакция начинается с команды:</p>
&nbsp;</p>
begin tran modify_pubs2</p>
&nbsp;</p>
Эта транзакция называется modify_pubs2 (изменение базы данных pubs2). Транзакцию можно отменить в любой момент и вернуться к исходному состоянию базы данных, в котором она была до начала транзакции, с помощью следующей&nbsp; команды:</p>
&nbsp;</p>
rollback tran modify_pubs2</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Правила ввода данных</td></tr></table></div>&nbsp;</p>
Некоторые типы данных, предоставляемые SQL Сервером, требуют соблюдения специальных правил при их вводе и поиске. Эти правила&nbsp; рассматриваются в нижеследующих подразделах. Более детальную информацию о типах данных можно посмотреть в главе 7: ” Создание баз данных и таблиц”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы данных char, nchar, varchar, nvarchar и text</td></tr></table></div>&nbsp;</p>
Не следует забывать, что при введении или поиске данных типа character (символьный), text (текстовый) и datetime (дата-время), их следует заключать в простые или двойные кавычки. Нужно использовать простые кавычки, если включена опция quoted_identifier (идентификатор в кавычках), так как в этом случае SQL Сервер рассматривает текстовую строку, заключенную в двойные кавычки, как идентификатор. Более детально вопросы, связанные с вводом текстовых данных, рассматриваются в Справочном Руководстве SQL Сервера.</p>
При введении символьных строк, длина которых превышает заданную, они укорачиваются до указанной длины в столбцах типа char, nchar, varchar, или nvarchar. Чтобы получить об этом предупреждающее сообщение, следует установить опцию string_truncation. </p>
Существуют два способа распознавания символа кавычек при вводе символьных строк. Первый способ заключается в использовании двух кавычек подряд. Например, если ввод строки начинается с простой кавычки и необходимо&nbsp; включить в нее простую кавычку как один из вводимых символов, то следует указать в этом месте подряд две кавычки, как, например, в предложении: &#8216;I don&#8217;&#8217;t understand&#8217;. Аналогично можно включить в строку двойные кавычки, например: “He said, “”It&#8217;s not realy confusing.”””</p>
Второй способ состоит в использовании кавычек противоположного вида. Другими словами, данные, вводимые в простых кавычках, заключаются в двойные, и наоборот. Например: &#8216;Джорж сказал, “Должен быть другой путь.”&#8217;</p>
Для введения символьной строки, длина которой превышает ширину экрана, нужно ввести обратную косую (\) перед переходом на следующую строку. </p>
Ключевое слово like и символы замены, описанные в главе 2 ”Запросы: выбор данных из таблиц”, могут быть использованы при поиске данных типа character, text, datetime. </p>
О пробелах на концах символьных строк можно прочитать в разделе “Типы данных” в Справочном Руководстве SQL сервера.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы данных datetime и smalldatetime</td></tr></table></div>&nbsp;</p>
Имеется большой выбор форматов для ввода и вывода данных типа datetime (дата время). Форматы ввода и вывода задаются независимо друг от друга. Формат вывода, заданный по умолчанию, позволяет представлять дату и время в следующем виде:”Apr 15 1987 10:23PM”. Команда convert (преобразовать) предоставляет&nbsp;&nbsp; опции для вывода секунд и миллисекунд, а также позволяет изменить порядок, в котором выводятся составляющие даты. Детально форматы даты и времени описаны в главе 10, “Использование встроенных функций в запросах”.</p>
 SQL Сервер воспринимает большое количество различных форматов для ввода даты. При вводе не различаются строчные и заглавные буквы, а пробелы могут находиться в любом месте между различными составляющими даты. При вводе значений типа datetime и smalldatetime их всегда следует заключать в простые или двойные кавычки. (Простые кавычки следует использовать при включенной опции quoted_identifier; так как строку, заключенную в двойные кавычки, SQL Сервер рассматривает в этом случае как идентификатор.) </p>
SQL Сервер рассматривает дату и время независимо друг от друга, поэтому время может предшествовать дате или располагаться после нее. Любая из&nbsp; составляющих комплекса дата-время может быть опущена, кроме того SQL Сервер может задавать дату и время по умолчанию, о чем будет сказано далее. Если опущены обе составляющие, то по умолчанию будет установлено следующее значение:&nbsp; 1 Января, 1900, 12:00:00:000AM. </p>
Для данных типа datetime наименьшим значением является дата 1 Января 1753 года, а наибольшим - 31 Декабря 9999 года. Для данных типа smalldatetime  такими значениями будут соответственно 1 Января&nbsp; 1900 года и 6 Июня&nbsp; 2079 года. Даты, не попадающие в эти интервалы, должны вводиться, храниться и обрабатываться как данные типа char и&nbsp; varchar. SQL Сервер отвергает любые значения типа даты, не попадающие в указанные интервалы. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ввод значений времени</td></tr></table></div>&nbsp;</p>
Порядок, в котором располагаются компоненты значения времени является существенным. Сначала нужно ввести часы, затем по порядку минуты, секунды, миллисекунды, АМ или am, PM или pm. 12AM - это полночь, а 12PM - это полдень. Для того, чтобы значение воспринималось как время, необходимо разделять его компоненты двоеточиями или ставить указатель AM/PM. Следует заметить, что тип данных smalldatetime  задает время только с точностью до минут.</p>
Миллисекундам должны предшествовать либо двоеточие, либо точка. Если перед миллисекундами стоит двоеточие, то это число означает тысячные доли секунды. Если же миллисекундам предшествует точка, то однозначное число обозначает десятые доли секунды, двузначное - сотые доли секунды, а трехзначное - тысячные. Например, &#8216;12:30:20:1&#8217; обозначает 12 часов, 30 минут, 20 и одна тысячная секунды; &#8216;20:30:20.1&#8217; означает 12 часов, 30 минут, 20 и одна десятая секунды.&nbsp; </p>
Ниже приведены допустимые форматы для данных типа дата-время:</p>
&nbsp;</p>
&nbsp;</p>
14:30 </p>
14:30[:20:999] </p>
14:30[:20.9] </p>
4am </p>
4 PM </p>
[0]4[:30:20:500]AM</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Ввод даты</td></tr></table></div>&nbsp;</p>
Команда set dateformat (установить формат даты) позволяет пользователю&nbsp; точно указать порядок следования компонент даты (месяц, день, год), когда они вводятся как числовые строки с разделителями. Изменение языка с помощью команды set language (установить язык) также может повлять на формат даты, поскольку в каждом языке по умолчанию устанавливается свой формат даты. По умолчанию, устанавливается язык us_english (американский, английский), в котором&nbsp; компоненты даты задаются в следующем порядке mdy (month-месяц, date-дата, year-год). Более детально команда set рассматривается в Справочном Руководстве SQL Сервера.  &nbsp;&nbsp;&nbsp; </p>
&nbsp;</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Замечание: Команда dateformat влияет только на даты, задаваемые в виде чисел с разделителями, например “4.15.90” или “20.05.88”. Она не влияет на даты, в которых месяц указан в символьном виде, например, “April 15, 1990”, или на даты, в которых отсутствуют разделители, например, “19890415”.&nbsp; </p>
&nbsp;</p>
SQL Сервер допускает три основных формата для ввода данных типа даты.&nbsp; Каждый из нижеприведенных форматов даты, при использовании должен заключаться в кавычки и может находиться либо перед, либо после значения времени, как было отмечено выше.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="13">&#183;</td><td>Если название месяца вводится в буквенном (символьном) виде, то действуют следующие соглашения.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Название месяца может быть аббревиатурой из трех символов или полным названием месяца, как указано в спецификации данного языка.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Запятые не обязательны.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Не различается регистр символов.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Если указываются только две последние цифры “уу” в компоненте года, то числа меньше 50 означают год “20yy”, а цифры от 50 включительно и больше означают год “19yy”.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Следует явно указать век, если не указан день или если год отличается от указанных выше значений, принимаемых по умолчанию.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Если день опущен, то по умолчанию устанавливается первый день месяца.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Если название месяца указывается в буквенном виде, то установки сделанные командой dateformat (см. команду set) всегда игнорируются.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Следующие форматы допустимы для алфавитно-цифрового указания даты:</td></tr></table></div>&nbsp;</p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; Apr[il] [15][,] 1988 </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; Apr[il] 15[,] [19]88 </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; Apr[il] 1988 [15] </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; [15] Apr[il][,] 1988 </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 15 Apr[il][,] [19]88 </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 15 [19]88 apr[il] </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; [15] 1988 apr[il] </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 1988 APR[IL] [15] </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; [19]88 APR[IL] 15 </p>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 1988 [15] APR[IL]</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если название месяца, вводится в числовом виде, то оно отделяется от остальных частей даты косой(/), дефисом(-) или точкой (.), и действуют следующие соглашения.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Следует явно указать месяц, день и год.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Строка даты должна иметь один из следующих видов:</td></tr></table></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;число&gt;&lt;разделитель&gt;&lt;число&gt;&lt;разделитель&gt;&lt;число&gt;[&lt;время&gt;]</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; или</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [&lt;время&gt;]&lt;число&gt;&lt;разделитель&gt;&lt;число&gt;&lt;разделитель&gt;&lt;число&gt;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Интерпретация значений даты зависит от установок, сделанных в команде dateformat. Если порядок указания компонент даты не соответствует установленному, то значение либо вообще не будет рассматриваться как дата, поскольку оно не попадет в допустимый интервал, либо оно будет&nbsp; интерпретироваться неправильно.&nbsp; Например, значение “12/10/08” может быть истолковано шестью различными способами в зависимости от порядка следования компонент даты. Более подробно этот вопрос рассматривается в разделе о команде set.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Например, дату “April 15,1988” в формате mdy можно ввести в следующем виде:</td></tr></table></div>&nbsp;</p>
[0]4/15/[19]88</p>
[0]4-15-[19]88</p>
[0]4.15.[19]88</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Далее приведены другие форматы ввода этой даты с разделяющей косой (“/”), в которых можно также использовать в качестве разделителей дефисы и точки: </td></tr></table></div>&nbsp;</p>
15/[0]4/[19]88 (dmy) </p>
[19]88/[0]4/15 (ymd) </p>
[19]88/15/[0]4 (ydm) </p>
[0]4/[19]88/15 (myd) </p>
15/[19]88/[0]4 (dym)</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если дата задана как 4-, 6-, или 8-цифровая строка без разделителей, либо как пустая строка, либо указана только составляющая времени, то действуют следующие соглашения.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Форматы, указанные в команде dateformat, игнорируются.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Если строка состоит из 4-х цифр, то она рассматривается как год, а день и месяц по умолчанию устанавливаются на 1 Января. Первые две цифры в этой строке должны явно указывать столетие (век) и их нельзя опускать.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Строки, состоящие из 6-ти или 8-ми цифр, всегда интерпретируются в формате ymd (год, месяц, число); месяц и число должны быть двузначными числами, например [19]880415.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&rArr;</td><td>Пустая строка (“”) или пропущенная дата интерпретируются как базовая дата 1 Января 1900 года. Например, значение времени “4:33”&nbsp; с опущенной компонентой даты означает “1 Января 1900 года, 4:33AM”.</td></tr></table></div>&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Поиск значений типа даты и времени </td></tr></table></div>&nbsp;</p>
Ключевое слово like (как) и символы замены могут использоваться с данными типа datetime и smalldatetime , также, как и с данными типа char, nchar, varchar, nvarchar, и  text. При использовании ключевого слова like с данными типа datetime и smalldatetime, SQL Сервер вначале преобразует эти данные в стандартный формат datetime, а затем в данные типа varchar. Поскольку стандартный формат datetime  не предусматривает вывод секунд и миллисекунд, то их поиск с помощью ключевого слова like невозможен. Для поиска дат с секундами и миллисекундами должна предварительно использоваться функция преобразования&nbsp; типов данных convert.</p>
Применение ключевого слова like для поиска данных типа datetime и smalldatetime  является хорошим техническим решением, поскольку данные этих типов могут содержать различные компоненты, которые надо явно указывать, чтобы вести поиск в формате даты, что не всегда удобно. Например, если значение “9:20” было введено в столбец arrival_time (время прибытия), то конструкция </p>
&nbsp;</p>
where arrival_time = '9:20'</p>
&nbsp;</p>
не позволит найти соответствующие строки, поскольку SQL Сервер преобразует это значение в дату “Jan 1, 1900 9:20AM”.</p>
Однако, следующая конструкция будет находить нужные данные:</p>
&nbsp;</p>
where arrival_time like '%9:20%'</p>
&nbsp;</p>
Если день месяца, указанный в дате, меньше 10, то при использовании ключевого слова like следует сделать два пробела между днем и месяцем, поскольку они добавляются при преобразовании данных типа дата-время в данные типа varchar, в противном случае поиск может окончиться неудачно. Аналогично, если во временной компоненте час меньше 10, то при преобразовании типов добавляются два пробела между годом и часом. Например, команда вида like May 2% c одним пробелом между “May” и “2” будет находить даты между 20 и 29 мая, но не 2 мая. Не нужно вставлять дополнительные пробелы в других операторах сравнения,&nbsp; поскольку данные типа дата-время преобразуются в данные типа varchar  только для при поиске данных по команде like. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы данных binary, varbinary  и image &nbsp;&nbsp; </td></tr></table></div>&nbsp;</p>
При введении или поиске данных типа binary (двоичный, бинарный), varbinary (двоичный с переменной длиной) и image (графический), им должен предшествовать префикс ”0х”. Например, чтобы указать двоичное значения “FF”, следует ввести “0хFF”.</p>
Если длина вводимого двоичного числа типа binary, varbinary, превосходит длину поля таблицы, то оно укорачивается без предупреждающего сообщения.</p>
Если столбец таблицы типа binary, varbinary имеет длину 10, то это означает, что для хранения данных в этом столбце отведено 10 байтов, каждый из которых может содержать 2 шестнадцатиричные цифры. </p>
При указании значений по умолчанию в столбцах типа binary, varbinary, следует также предварительно указать префикс “0х”.</p>
В Справочном руководстве SQL Сервера можно посмотреть правила&nbsp; добавления концевых нулей для шестнадцатиричных величин.&nbsp;&nbsp;&nbsp;&nbsp; </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы данных money  и&nbsp; smallmoney</td></tr></table></div>&nbsp;</p>
Денежные значения, введенные в экспоненциальном формате (Е), интерпретируются как данные типа float (плавающий). Это может привести к ошибке или к потере точности, когда эти данные хранятся как значения типа money (денежный) или smallmoney (малый денежный).</p>
Денежным значениям может предшествовать соответствующий знак валюты, например, символ доллара ($), йены (Ґ) или фунта стерлинга (Ј), но валютный символ можно и не указывать. Для введения отрицательного денежного значения следует ставить знак минус после символа валюты. Не следует употреблять запятые в данных такого типа.</p>
Хотя ввод данных денежного типа происходит без запятых,&nbsp; по умолчанию при печати денежных значений ставятся запятые после каждых трех цифр.&nbsp; При печати данных типа money и smallmoney, они округляются до центов. Над данными типа money можно выполнять все арифметические операции, за исключением операции взятия модуля.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы данных float, real и double precision</td></tr></table></div>&nbsp;</p>
Числовые величины типа float (плавающий), real (действительный) и doudle precision (двойная точность) вводятся в виде мантиссы, за которой можно указать&nbsp;&nbsp; показатель степени. Мантисса может содержать положительный или отрицательный знак (+,-) и десятичную точку. Показатель степени, который следует за символом “е” или “Е”, может иметь знак, но в нем не должно быть десятичной точки.</p>
При проведении вычислений с этими числовыми величинами, SQL Сервер умножает мантиссу на число 10, возведенное в степень, равную показателю степени. Ниже приведены примеры числовых данных типа float, real, double precision.</p>
&nbsp;</p>
Таблица 8-1: Числовые данные в научном формате</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Введенное значение</p>
</td>
<td ><p>Мантисса</p>
</td>
<td ><p>Показатель</p>
</td>
<td ><p>Величина</p>
</td>
</tr>
<tr >
<td ><p>10Е2</p>
</td>
<td ><p>10</p>
</td>
<td ><p>2</p>
</td>
<td ><p>10*102</p>
</td>
</tr>
<tr >
<td ><p>15.3е1</p>
</td>
<td ><p>15.3</p>
</td>
<td ><p>1</p>
</td>
<td ><p>15.3*101</p>
</td>
</tr>
<tr >
<td ><p>-2.е5</p>
</td>
<td ><p>-2</p>
</td>
<td ><p>5</p>
</td>
<td ><p>-2*105</p>
</td>
</tr>
<tr >
<td ><p>2.2е-1</p>
</td>
<td ><p> 2.2</p>
</td>
<td ><p>-1</p>
</td>
<td ><p>2.2*10-1</p>
</td>
</tr>
<tr >
<td ><p>+56Е+2</p>
</td>
<td ><p>56</p>
</td>
<td ><p>2</p>
</td>
<td ><p>56*102
</td>
</tr>
</table>
&nbsp;</p>
Точность, указанная в столбце одного из этих типов, определяет максимальное число двоичных разрядов, которые выделяются для хранения мантиссы. Для столбцов типа float точность может достигать 48 разрядов, а для столбцов типа real и&nbsp; double precision точность зависит от реализации. Если вводимое в столбец числовое значение превосходит допустимую точность, SQL Сервер сигнализирует об ошибке. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Десятичные и числовые типы данных</td></tr></table></div>&nbsp;</p>
Точные числовые типы данных decimal (десятичный) и numeric (числовой) могут начинаться со знака (+ или -) и могут содержать десятичную точку. Числовое значение данных этого типа зависит от точности (precision) и шкалы (scale), которые указываются следующим образом:</p>
&nbsp;</p>
datatype [(точность [, шкала ])]&nbsp; </p>
&nbsp;</p>
SQL Сервер интерпретирует каждую комбинацию значений точности и шкалы как отдельный тип данных. Например, numeric (10,0)  и&nbsp; numeric (5,0) являются двумя различными типами данных. Точность и шкала определяют диапазон значений, которые могут храниться в столбцах типа decimal и numeric, следующим образом: </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Точность определяет максимальное число десятичных разрядов, которые могут храниться в столбце этого типа. Сюда включаются все разряды, расположенные как слева, так и справа от десятичной точки. Точность представления чисел можно выбрать из диапазона от 1 до 38 разрядов, или использовать по умолчанию точность в 18 разрядов;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Шкала определяет максимальное число разрядов, которые могут располагаться справа от десятичной точки в дробной части числа. Заметим, что шкала должна быть меньше или равна точности. Шкалу можно выбрать из диапазона от 0 до 38 разрядов, или использовать по умолчанию нулевую шкалу.</td></tr></table></div>&nbsp;</p>
Если точность или шкала вводимых данных превышают значения, установленные для столбца этого типа, то SQL сервер сообщает об ошибке. Ниже приведены некоторые примеры правильных значений типа dec и numeric.</p>
&nbsp;</p>
Таблица 8-2: Правильное задание точности и шкалы для числовых данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Входные данные</p>
</td>
<td >Тип данных</p>
</td>
<td >Точность</p>
</td>
<td >Шкала </p>
</td>
<td >Значение</p>
</td>
</tr>
<tr >
<td >12.345</p>
</td>
<td >numeric(5,3)</p>
</td>
<td >5</p>
</td>
<td >3</p>
</td>
<td >12.345</p>
</td>
</tr>
<tr >
<td >-1234.567</p>
</td>
<td >dec(8,4)</p>
</td>
<td >8</p>
</td>
<td >4</p>
</td>
<td >-1234.567
</td>
</tr>
</table>
&nbsp;</p>
Далее приведены примеры неправильных значений этого типа, поскольку они&nbsp; превышают точность или шкалу, установленную для столбцов этого типа.</p>
&nbsp;</p>
Таблица 8-3: Неправильное задание точности и шкалы для числовых данных</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Входные данные</p>
</td>
<td ><p>Тип данных</p>
</td>
<td ><p>Точность</p>
</td>
<td ><p>Шкала</p>
</td>
</tr>
<tr >
<td ><p>1234.567</p>
</td>
<td ><p>numeric(3,3)</p>
</td>
<td ><p>3</p>
</td>
<td ><p>3</p>
</td>
</tr>
<tr >
<td ><p>1234.567</p>
</td>
<td ><p>decimal(6)</p>
</td>
<td ><p>6</p>
</td>
<td ><p>0
</td>
</tr>
</table>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Типы данных int, smallint  и tinyint</td></tr></table></div>&nbsp;</p>
Числовые данные в столбцы типа int (целое), smallint (малое целое) и tinyint (маленькое целое) могут вводиться в Е-формате (научном, экспоненциальном), описанном в предыдущем разделе. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Текущее время</td></tr></table></div>&nbsp;</p>
Нельзя вводить значения в столбец timestamp (текущее время). Здесь надо либо явно указать неопределенное значение “NULL”, либо ввести это значение неявно, не указывая в списке столбцов запроса этот столбец. SQL Сервер автоматически обновляет значение времени в этом столбце после каждой вставки или обновления данных. Более детально этот вопрос обсуждается в разделе “Вставка данных в столбцы специального типа” этой главы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Добавление новых данных</td></tr></table></div>&nbsp;</p>
Команда insert (вставить) используется для добавления строк в базу данных двумя различными способами: с помощью ключевого слова values (значения) или с оператором выбора select.</p>
Ключевое слово values используется для указания значений во всех или некоторых столбцах новой строки. Упрощенный вариант синтаксиса команды insert с ключевым словом&nbsp; values имеет следующий вид: </p>
&nbsp;</p>
insert название_таблицы </p>
  values (константа1, константа2, ...) </p>
&nbsp;</p>
Оператор выбора select используется в команде insert для извлечения данных из других таблиц. Упрощенный вариант синтаксиса команды insert с оператором select имеет следующий вид: </p>
&nbsp;</p>
insert название_таблицы </p>
  select список_столбцов</p>
  from список_таблиц</p>
  where условия_отбора</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Синтаксис команды insert</td></tr></table></div>&nbsp;</p>
Здесь приведен полный синтаксис команды insert:</p>
&nbsp;</p>
insert [into] [база данных.[владелец]] { название_таблицы | название_вьювера } [(список_столбцов)] </p>
{values (константное_выражение [, константное_выражение]...) |&nbsp; </p>
оператор_выбора }</p>
&nbsp;</p>
Замечание: Если с помощью команды insert вставляются текстовые (text) или графические (image) данные, то все эти данные записываються в журнал транзакций. Команда writetext позволяет добавлять эти данные без&nbsp; записи их в журнал транзакций, чтобы избежать записи больших масивов данных в журнал, которые могут содержаться в полях этого типа. Этот вопрос обсуждается также в разделах “Вставка данных в столбцы специального типа” и “Изменение текстовых и графических данных” этой главы.   </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Добавление новых строк с помощью ключевого слова values</td></tr></table></div>&nbsp;</p>
В следующем примере показано, как с помощью оператора insert можно добавить новую строку в таблицу publishers, присваивая значения каждому столбцу новой строки:</p>
&nbsp;</p>
insert into publishers </p>
values ('1622', 'Jardin, Inc.', 'Camden', 'NJ')</p>
&nbsp;</p>
Следует заметить, что данные вводятся в том же порядке, в каком названия столбцов приведены в операторе create table (создать таблицу), т.е. вначале указывается идентификационный номер автора ID, затем имя и фамилия, город и в заключение - название штата. Список данных, вводимый с помощью ключевого слова values, заключается в скобки и каждый элемент списка заключается в простые или двойные кавычки.</p>
Для добавления каждой новой строки нужно использовать отдельный оператор insert. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вставка данных в столбцы специального типа</td></tr></table></div>&nbsp;</p>
Чтобы добавить строку, в которой известны не все значения в столбцах, нужно явно указать названия столбцов вместе с заданными значениями. При этом в остальных столбцах должно допускаться хранение неопределенного значения.&nbsp; Пропущенные столбцы могут также иметь значения, задаваемые по умолчанию. Если пропущенный столбец имеет такое значение, то значение по умолчанию будет записано в этот столбец. </p>
Эту форму оператора вставки особенно удобно использовать для добавления строк, в которых указываются значения для всех столбцов, за исключением столбцов&nbsp; типа text и image, с последующим применением команды writetext для записи больших массивов данных в эти поля, что позволяет избежать запоминания этих массивов в журнале транзакций. Такой способ добавления данных также удобен, когда необходимо пропустить столбец типа timestamp (текущее время). </p>
Например, чтобы добавить строку с данными в столбцах pub_id и pub_name, можно воспользоваться следующей командой:</p>
&nbsp;</p>
insert into publishers (pub_id, pub_name) </p>
values ('1756', 'The Health Center')</p>
&nbsp;</p>
Порядок расположения названий столбцов должен соответствовать порядку следования значений в списке. В следующем примере тот же результат достигается другим способом:</p>
&nbsp;</p>
insert publishers (pub_name, pub_id) </p>
values ('The Health Center', '1756')</p>
&nbsp;</p>
В каждом из приведенных операторов insert значение “1756” вводится в столбец идентификационных кодов, а строка ”The Health Center” вводится в столбец названий издателей. Поскольку столбец pub_id в таблице publishers имеет уникальный индекс, то последовательное выполнение двух этих операторов недопустимо, поскольку при выполнении второго оператора в столбце pub_id уже будет записано значение “1756”, что вызовет сообщение об ошибке. </p>
В нижеприведенном операторе выбора select показана строка, которая была добавлена в таблицу publishers: </p>
&nbsp;</p>
select * </p>
from publishers </p>
where pub_name = 'The Health Center'</p>
&nbsp;</p>
pub_id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pub_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; state </p>
---------&nbsp; --------------------&nbsp;&nbsp; --------&nbsp;&nbsp; ------- </p>
1756&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Health Center&nbsp;&nbsp;&nbsp; NULL&nbsp;&nbsp;&nbsp; NULL</p>
&nbsp;</p>
SQL Сервер записал неопределенное значение NULL в столбцы city и state, поскольку в операторе insert для них не было указано никаких значений, а таблица publishers допускает хранение неопределенных значений в этих столбцах.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Значения, записываемые SQL сервером в&nbsp; столбцы-счетчики</td></tr></table></div>&nbsp;</p>
Если в таблицу, содержащую&nbsp; столбец -счетчик(IDENTITY), добавляется новая строка, то SQL сервер автоматически записывает следующее по порядку число в этот столбец. Название столбца-счетчика нельзя указывать в списке столбцов оператора вставки и нельзя присваивать ему никакокго значения. </p>
Следующий оператор insert добавляет новую строку в таблицу sales_daily. Заметим, что в списке столбцов отсутствует счетчиковый столбец-счетчик row_id:</p>
&nbsp;</p>
insert sales_daily (stor_id)</p>
values ("7896")</p>
&nbsp;</p>
Следующий оператор показывает строку, которая была добавлена в таблицу sales_daily. SQL Сервер автоматически записал следующее по порядку значение в столбец row_id:</p>
&nbsp;</p>
select * from sales_daily</p>
where stor_id = "7896"</p>
&nbsp;</p>
row_id&nbsp;&nbsp;&nbsp; stor_id</p>
-------&nbsp;&nbsp; ---------</p>
  2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7896</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Неопределенные значения, значения по умолчанию,&nbsp; столбцы-счетчики и ошибки</td></tr></table></div>&nbsp;</p>
Если в операторе вставки значения указываются только для некоторых столбцов строки, то для остальных столбцов может возникнуть одна из следующих четырех ситуаций:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>В столбец записывается значения по умолчанию, если оно определено для этого столбца. Более детально о значениях по умолчанию можно прочитать в главе 12 “Определение значений по умолчанию и правил” или в разделе об операторе создания значения по умолчанию create default в Справочном Руководстве SQL Сервера;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>В столбец записывается неопределенное значение, если опция NULL была указана для этого столбца при создании таблицы и с данным столбцом или типом данных не связано никаких значений по умолчанию. Этот вопрос детально обсуждается в разделе об операторе создания таблицы create table&nbsp; в Справочном Руководстве SQL Сервера;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если столбец является счетчиком (IDENTITY), то в него заносится следующее по порядку уникальное значение;&nbsp; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Если столбец не допускает записи неопределенного значения NULL и с ним не связано никаких значений по умолчанию, то выдается сообщение об ошибке, и новая строка не будет добавлена.</td></tr></table></div>&nbsp;</p>
В следующей таблице показано, что будет происходить в этих ситуациях:</p>
&nbsp;</p>
Таблица 8-4: Значение, записываемое в неуказанные столбцы</p>
&nbsp;</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td ><p>Значение по умолчанию?</p>
</td>
<td ><p>Not NULL</p>
</td>
<td ><p>NULL</p>
</td>
<td ><p>Столбец-счетчик</p>
</td>
</tr>
<tr >
<td ><p>Да</p>
</td>
<td ><p>Значение по умолчанию</p>
</td>
<td ><p>Значение по умолчанию</p>
</td>
<td ><p>Следующее по порядку значение</p>
</td>
</tr>
<tr >
<td ><p>Нет</p>
</td>
<td ><p>Сообщение об ошибке</p>
</td>
<td ><p>NULL</p>
</td>
<td ><p>Следующее по порядку значение
</td>
</tr>
</table>
&nbsp;</p>
С помощью системной процедуры sp_help можно получить информацию об определенной таблице,&nbsp; значении по умолчанию, или о любом другом объекте, находящемся в списке sysobjects (системные объекты). Определение значений по умолчанию можно посмотреть с помощью системной процедуры sp_helptext. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Явная запись значений в столбец-счетчик</td></tr></table></div>&nbsp;</p>
Иногда может возникнуть необходимость вставить определенное значение в столбец-счетчик, которое отлично от значения, записываемого SQL Сервером. Например, пользователю нужно вставить в таблицу первую строку со значением в столбце-счетчике, равным 101, а не 1, или строку, которая была ошибочно удалена из таблицы. </p>
Записывать значения в столбец-счетчик разрешается только владельцу таблицы, владельцу базы данных или системному администратору. Перед&nbsp; изменением значения счетчика пользователю следует установить для данной таблицы опцию identity_insert командой set identity_insert on. Заметим, что опция identity_insert может быть установлена в каждый момент времени только для одной таблицы базы данных.</p>
В следующем примере в столбец-счетчик записывается значение 101:</p>
&nbsp;</p>
set identity_insert sales_daily on</p>
insert into sales_daily (syb_identity, stor_id) </p>
values (101, '13-J-9')</p>
&nbsp;</p>
Следует заметить, что в этом операторе insert перечисляются названия всех столбцов таблицы, включая столбец-счетчик, для которого указано определенное значение. Когда для данной таблицы включена опция identity_insert, то в каждом операторе insert, который добавляет данные в эту таблицу, должен быть явно указан полный список названий столбцов. В списке значений должно быть указано новое значение счетчика, поскольку в столбец-счетчик нельзя записывать неопределенное значение. </p>
&nbsp;</p>
Замечание: SQL сервер не требует единственности значений счетчика. Допускается ввод любого положительного целого числа, точность представления которого попадает в диапазон точности, установленной для этого столбца. Для того, чтобы значения счетчика были уникальными, нужно создать уникальный индекс для счетчика-столбца перед установкой его значения.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Правила для ограничения данных в столбцах</td></tr></table></div>Пользователь может определить правило и связать его со столбцом таблицы или своим типом данных. Правила определяют, какие виды данных могут быть добавлены в таблицу.</p>
В качестве примера рассмотрим столбец pub_id таблицы publishers. С ним связано правило pub_idrules, которое определяет допустимые идентификационные коды издателей. Допустимыми являются коды “1389”, “0736”, “0877”, “1622”, или любой четырехзначный код, который начинается с двух цифр “99”. При попытке ввода любых других значений, будет выдано сообщение об ошибке.</p>
Если появилось такое сообщение об ошибке, то следует посмотреть установленные правила&nbsp; с помощью системной процедуры sp_helptext:</p>
&nbsp;</p>
sp_helptext pub_idrule </p>
&nbsp;</p>
text </p>
---------------------------------------------------------</p>
create rule pub_idrule </p>
as @pub_id in ("1389", "0736", "0877", "1622", "1756") or @pub_id like "99[0-9][0-9]"</p>
&nbsp;</p>
Более общая информация об интересующем пользователя правиле может быть получена с помощью процедуры sp_help. Можно также вызвать процедуру sp_help c названием таблицы в качестве параметра, чтобы выяснить для каких столбцов этой таблицы установлены правила. Более детально правила описываются в главе 12 “Определение умолчаний и правил отбора данных”.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вставка новых строк с конструкцией select</td></tr></table></div>&nbsp;</p>
Для выбора данных из одной или нескольких таблиц и вставки их в другую таблицу используется конструкция select в операторе insert. Конструкция select позволяет записывать значения как в некоторые, так и во все столбцы таблицы.</p>
Запись значений только в часть столбцов очень удобна, когда данные извлекаются из другой таблицы. После этого можно с помощью оператора update (обновить) добавить значения во все остальные столбцы. </p>
Перед записью значений не во все столбцы таблицы, нужно проверить наличие значений по умолчанию или возможности использования неопределенного значения в столбцах, в которые не будут записываться новые значения. В противном случае будет получено сообщение об ошибке.</p>
Когда производится перепись значений из одной таблицы в другую, нужно проверить на сравнимость структуры этих таблиц, т.е. соответствующие столбцы обеих таблиц должны быть либо одного типа, либо иметь типы, которые могут быть автоматически преобразованы друг в друга SQL Сервером.</p>
&nbsp;</p>
Замечание: Нельзя переписывать данные из столбца таблицы, в котором допускается неопределенное значение, в таблицу, в которой оно не допускаются, если хотя бы одно из переписываемых значений равно NULL.</p>
&nbsp;</p>
Если столбцы, в которые добавляются значения и из которых они берутся, следуют в том же порядке, в котором они расположены в операторе создания таблицы create table, то пользователь может не указывать названия столбцов в обеих таблицах. Предположим, например, что таблица newauthors содержит сведения об некоторых авторах и имеет ту же структуру, что и таблица authors. Тогда для того, чтобы переписать все строки из таблицы newsauthors в таблицу authors можно выполнить следующий оператор:</p>
&nbsp;</p>
insert authors </p>
select * </p>
from newauthors</p>
&nbsp;</p>
Данные можно переписывать из одной таблицы в другую, даже в том случае, если порядок следования соответствующих друг другу столбцов, указанный в операторах создания этих таблиц, совершенно различный. В этом случае пользователь должен указать в операторах insert и select названия столбцов в таком порядке, чтобы они соответствовали друг другу по типу.&nbsp; </p>
Например, в операторе create table для таблицы authors столбцы расположены в следующем порядке: au_id, au_fname, au_lname, address, а в таблице newauthors те же столбцы расположены в другом порядке: au_id, address, au_lname, au_fname.&nbsp; Тогда пользователь должен в операторе insert установить соответствие между однотипными столбцами. Это можно сделать одним из двух следующих&nbsp; способов:</p>
&nbsp;</p>
insert authors (au_id, address, au_lname, au_fname) </p>
select * from newauthors</p>
&nbsp;</p>
insert authors </p>
select au_id, au_fname, au_lname, address </p>
 &nbsp;&nbsp; from newauthors</p>
&nbsp;</p>
Если же порядок следования столбцов в обеих таблицах не будет одинаковым, то SQL Сервер не сможет закончить выполнение операции insert, или будет выполять ее неправильно, записывая данные не в те столбцы. Например, может оказаться, что адрес записан в столбце au_lname, где должны находиться фамилии.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вычисляемые столбцы</td></tr></table></div>&nbsp;</p>
В конструкции select оператора insert можно указывать вычисляемые столбцы. Например, предположим, что таблица tmp содержит новые строки для таблицы titles, но некоторые данные в них устарели, к примеру необходимо удвоить цену книги в столбце price (цена). Оператор, который увеличивает цену и вставляет строки из таблицы tmp в таблицу titles, выглядит следующим образом:</p>
&nbsp;</p>
insert titles </p>
select title_id, title, type, pub_id, price*2,</p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; advance, total_sales, notes, pubdate, contract</p>
from tmp</p>
&nbsp;</p>
При указании вычисляемых столбцов нельзя заменять звездочкой (*) названия столбцов в операторе select. В этом случае название каждого столбца должно быть явно указано в списке выбора.</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вставка данных в некоторые столбцы</td></tr></table></div>&nbsp;</p>
С помощью оператора select можно добавлять данные в некоторые, но не во все столбцы таблицы, так же, как это делалось в конструкции values. В этом случае нужно просто указать в предложении insert названия столбцов, в которые будут записываться данные.</p>
Например, в таблице authors находится информация о некоторых авторах, у которых пока нет опубликованных книг, и следовательно информации об этих авторах нет в таблице titleauthors. Следующий оператор выбирает коды этих авторов из столбца au_id таблицы authors и вставляет их в таблицу titleauthors, чтобы зарезервировать в ней место для этих авторов:</p>
&nbsp;</p>
insert titleauthor (au_id)</p>
select au_id</p>
 &nbsp;&nbsp; from authors</p>
 &nbsp;&nbsp; where au_id not in</p>
 &nbsp;&nbsp; (select au_id from titleauthor)</p>
&nbsp;</p>
Однако этот оператор является ошибочным, поскольку в столбец title_id таблицы titleauthor необходимо записать некоторое значение, а в нем не допускается использование неопределенного значения и с ним не связано никаких значений по умолчанию. Поэтому для столбца titles_id нужно указать какое-нибудь псевдозначение (dummy), например константу “xx1111”:</p>
&nbsp;</p>
insert titleauthor (au_id, title_id)</p>
select au_id, "xx1111"</p>
 &nbsp;&nbsp; from authors</p>
 &nbsp;&nbsp; where au_id not in</p>
 &nbsp;&nbsp; (select au_id from titleauthor)</p>
&nbsp;</p>
После выполнения этого оператора таблица titleauthor будет содержать четыре новых строки с кодами авторов в столбце au_id, псевдозначениями в столбце title_id и неопределенными значениями в остальных двух столбцах.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Вставка данных из той же таблицы </td></tr></table></div>Вставлять данные можно в ту же таблицу, из которой они выбираются. Другими словами можно копировать всю строку или какую-то ее часть в ту же таблицу. Например, в таблицу publishers можно вставить новую строку, данные для которой выбираются из этой же таблицы. При этом нужно проверить, что новые значения&nbsp; удовлетворяют правилу, установленному для столбца pub_id. Для такой вставки можно выполнить следующий оператор, за которым следует оператор выбора, показывающий изменения, произошедшие в таблице:</p>
&nbsp;</p>
insert publishers </p>
select "9999", "test", city, state </p>
 &nbsp;&nbsp; from publishers </p>
 &nbsp;&nbsp; where pub_name = "New Age Books"</p>
&nbsp;</p>
select * from publishers</p>
&nbsp;</p>
pub_id&nbsp;&nbsp; pub_name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; city&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; state </p>
------&nbsp; -------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ------------&nbsp;&nbsp; ------ </p>
0736&nbsp;&nbsp;&nbsp; New Age Books&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Boston&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MA </p>
0877&nbsp;&nbsp;&nbsp; Binnet &amp; Hardley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Washington&nbsp;&nbsp; DC </p>
1389&nbsp;&nbsp;&nbsp; Algodata Infosystems&nbsp;&nbsp; Berkeley&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CA </p>
9999&nbsp;&nbsp;&nbsp; test&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Boston&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MA</p>
&nbsp;</p>
Отсюда видно, что в результате выполнения этого оператора в таблицу вставлена новая строка с константами “9999” и “test” в столбцах pub_id и pub_name соответственно, а значения города и штата скопированы в нее из столбцов city и state строки, которая удовлетворяет условиям запроса.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Изменение существующих данных</td></tr></table></div>&nbsp;</p>
Командой update (обновить) можно изменять содержимое отдельных строк, групп строк или всех строк таблицы. В этой команде нужно указать в качестве аргумента название таблицы или вьювера. Как и во всех операторах модификации данных, изменение данных может происходить в каждый момент времени только в одной таблице.</p>
В операторе update нужно указать строку или строки, содержимое которых должно быть изменено, а также данные, которые записываются в эти строки. Эти данные могут задаваться константами или выражениями, или выбираться из других таблиц.</p>
Если оператор update нарушает целостность данных, то обновления данных не происходит и выдается сообщение об ошибке. Например, выполнение оператора обновления будет прервано, если он пытается изменить значения счетчика, или записывает в столбец данные другого типа, или нарушает правило отбора данных,&nbsp; установленное для какого-то столбца. </p>
SQL Сервер не запрещает обновление одной командой update одной и той же строки более чем один раз. Однако, выполнение команды обновления не предусматривает накапливания обновлений от одного оператора. Поэтому, если оператор update обновляет одну строку дважды, то вторая операция обновления будет основываться на исходных данных, а не на результатах первого обновления. Результаты выполнения такого обновления будут непредсказуемы, поскольку они будут зависить от порядка выполнения изменений.</p>
Ограничения при обновлении через вьюверы обсуждаются в главе 9: ”Вьюверы: ограниченный доступ к данным”.</p>
&nbsp;</p>
 Замечание: Ход выполнения команды обновления заносится в журнал транзакций. Если пользователю необходимо обновить большие массивы текстовой или графической информации, то целесообразно использовать команду writetext, поскольку процесс ее выполнения не записывается в журнал операций. Кроме того, существует предел, равный примерно 125К, на объем изменяемых данных в одном операторе обновления. Обсуждение команды writetext можно посмотреть в разделе “Изменение текстовых и графических данных”. </p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Синтаксис команды update</td></tr></table></div>&nbsp;</p>
Рассмотрим сначала упрощенный вариант синтаксиса команды update, когда обновляемые данные задаются с помощью выражения:</p>
&nbsp;</p>
update название_таблицы </p>
set название_столбца = выражение </p>
where условия_отбора</p>
&nbsp;</p>
Например, если Reginald Blotchet-Halls решил бы изменить имя и фамилию на Goodbody Health (Хорошее Здоровье), с тем чтобы поднять тираж своей книги по визуализации, то обновление информации можно осуществить следующим образом :</p>
&nbsp;</p>
update authors </p>
set au_lname = "Health", au_fname = "Goodbody" </p>
where au_lname = "Blotchet-Halls"</p>
&nbsp;</p>
Далее приведен упрощенный синтаксис команды update, когда обновляемые&nbsp; данные выбираются из другой таблицы: </p>
&nbsp;</p>
update название_таблицы </p>
set название_столбца = выражение </p>
  from название_таблицы </p>
  where условия_отбора </p>
&nbsp;</p>
Ниже приведен пример изменения значений в столбце total_sales  таблицы titles, в котором обновляемые данные берутся из таблицы salesdetail, чтобы учесть последние изменения, произошедшие в объеме продаж: </p>
&nbsp;</p>
update titles </p>
set total_sales = total_sales + qty </p>
from titles, sales, salesdetail </p>
where titles.title_id = salesdetail.title_id </p>
and salesdetail.stor_id = sales.stor_id </p>
and sales.date in (select max(sales.date) from sales)</p>
&nbsp;</p>
В этом примере предполагается, что только один набор продаж фиксируется для данной книги на заданную дату, и что обновляемые данные являются самыми новыми. Полный синтаксис команды update выглядит следующим образом: </p>
&nbsp;</p>
update [[база_данных.]владелец.]{ название_таблицы | название_вьювера} </p>
 set&nbsp;&nbsp;&nbsp; [[[база_данных.]владелец.]{ название_таблицы. | название_вьювера. }] </p>
 название _столбца1 = {выражение1 | null | (оператор_выбора) } </p>
 &nbsp;&nbsp;&nbsp; [,название _столбца2 = {выражение2 | null | (оператор_выбора) }]... </p>
 [from&nbsp; [[база_данных.]владелец.]{ название_таблицы | название_вьювера } </p>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [, [[база_данных.]владелец.]{ название_таблицы | название_вьювера }]]... </p>
 [where условия_отбора ]</p>
&nbsp;</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование конструкции set в операторе update</td></tr></table></div>&nbsp;</p>
В конструкции set указываются названия обновляемых столбцов и новые значения этих столбцов. Условия, указываемые в конструкции where, позволяют отобрать строки, значения в которых должны быть обновлены. Следует заметить, что&nbsp; если конструкция where отсутствует, то значения, указанные в конструкции set, будут записаны во все строки таблицы.</p>
&nbsp;</p>
Замечание: Перед тем, как начать выполнение примеров, приведенных в этом разделе, нужно знать как переинсталлировать (вернуть в исходное состояние) демонстрационную базу данных pubs2. </p>
&nbsp;</p>
Например, если все издательства из таблицы publishers перенесут свои штаб-квартиры (оффисы) в Атланту (штат Джорджия), то для изменения соответствующих данных в этой таблице можно выполнить следующий оператор:</p>
&nbsp;</p>
update publishers </p>
set city = "Atlanta", state = "GA"</p>
&nbsp;</p>
Таким же образом можно сделать неопределенным названия всех издательств: </p>
&nbsp;</p>
update publishers </p>
set pub_name = null</p>
&nbsp;</p>
В команде update допускается использование вычисляемых столбцов. Чтобы удвоить все цены в таблице titles, можно выполнить следующий оператор:</p>
&nbsp;</p>
update titles </p>
set price = price * 2</p>
&nbsp;</p>
Поскольку в последнем примере отсутствует конструкция where, то удвоение цен произведено во всех строках таблицы.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование конструкции where в операторе update</td></tr></table></div>&nbsp;</p>
Конструкция where отбирает строки, которые нужно обновить. Например, если предположить, что произошло невероятное событие и из северной Калифорнии выделился штат Pacifica (сокращенно PC), а жители города Окленда&nbsp; проголосовали за изменение названия их города на что-нибудь экстравагантное типа Big Bad Bay City (большой плохой прибрежный город), то следующий оператор обновляет в таблице authors адреса жителей бывшего города Окленда:</p>
&nbsp;</p>
update authors </p>
set state = "PC", city = "Big Bad Bay City" </p>
where state = "CA" and city = "Oakland" </p>
&nbsp;</p>
Для изменения названия штата у жителей других городов северной Калифорнии следует выполнить еще один оператор обновления.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование конструкции from в операторе update</td></tr></table></div>&nbsp;</p>
Конструкция from используется для извлечения данных, необходимых для обновления, из одной или нескольких таблиц. </p>
Например, ранее был приведен пример вставки новых строк в таблицу titleauthor, содержащих информация об авторах, у которых еще нет опубликованных книг. При этом в столбец au_id записывался код автора, а в остальные столбцы записывалось либо пседозначение, либо неопределенное значение. Если один из писателей, например, Дюк Стрингер (Dirk Stringer) опубликовал книгу The Psychology of Computer Cooking (Психология компьютерной кулинарии), то его книге присваивается идентификационный код в таблице titles. Теперь можно обновить строку этого автора в таблице titleauthor, добавив код его книги:</p>
&nbsp;</p>
update titleauthor</p>
set title_id = titles.title_id</p>
from titleauthor, titles, authors</p>
 &nbsp;&nbsp; where titles.title =</p>
 &nbsp;&nbsp; "The Psychology of Computer Cooking"</p>
 &nbsp;&nbsp; and authors.au_id = titleauthor.au_id</p>
 &nbsp;&nbsp; and au_lname = "Stringer"</p>
&nbsp;</p>
Заметим, что, если бы в этом операторе обновления не было соединения по столбцу au_id, то изменились бы коды всех книг в столбце title_ids таблицы titleauthor, т.е. всем книгам в этой таблице присвоился бы код книги The Psychology of Computer Cooking. Заметим также, что, если две таблицы имеют одинаковую структуру, за исключением того, что в одной таблице содержатся неопределенные значения, а в другой они не допускаются, то нельзя вставлять данные из первой таблицы во вторую с помощью конструкции select. Другими словами, поле, не допускающее неопределенные значения, не может быть обновлено путем выбора значений из поля, в котором они допускаются, если по крайней мере, одно из выбираемых значений является неопределенным.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Изменение текстовых и графических данных</td></tr></table></div>&nbsp;</p>
Команда writetext (запись текста) предназначается для изменения текстовых (text) и графических (image) данных без записи их в журнал транзакций, чтобы не увеличивать его объема. Дело в том, что процесс выполнения команды обновления (update), которая также может использоваться для изменения этих данных, всегда фиксируется в журнале транзакций (логируется). В нормальном режиме (по умолчанию) команда writetext не логируется, т.е. предыдущее состояние базы данных не запоминается в журнале транзакций.</p>
&nbsp;</p>
Замечание: Чтобы команда writetext выполнялась в нормальном режиме, т.е. не логировалась, системный администратор должен с помощью системной процедуры sp_dboption установить опцию select into/bulkcopy. Это позволяет производить изменение данных без их логирования. После использования команды writetext необходимо запустить команду dump database. Сброс журнала транзакций (transaction dump) невозможен после нелогированных изменений базы данных при выполнении операций, которые фиксируются в этом журнале.</p>
&nbsp;</p>
Команда writetext полностью заменяет содержимое поля, в которое делается запись. Для выполнения команды writetext необходимо, чтобы это поле уже имело правильный тектовый указатель. Имеется два способа создания текстового указателя:</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Командой insert вставить в это поле (столбец) текстовые или графические данные;</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="28">&#183;</td><td>Обновить поле командой update, записав туда данные или NULL.</td></tr></table></div>&nbsp;</p>
Поскольку “инициализированное” текстовое поле требует 2К памяти, даже если пользователь записывает туда всего несколько слов, то SQL Сервер экономит память и не инициализирует текстовое поле, когда туда вставляется командой insert явное или неявное неопределенное значение. Следующая команда не инициализируют текстовое поле: </p>
&nbsp;</p>
insert blurbs&nbsp; </p>
values ("172-32-1176", NULL) </p>
&nbsp;</p>
После такого оператора вставки необходимо выполнить следующий оператор обновления для инициализации текстового поля:</p>
&nbsp;</p>
update blurbs </p>
set copy=NULL </p>
where au_id="172-32-1176"</p>
&nbsp;</p>
После того как поле инициализировано и появился текстовый указатель можно выполнять команду writetext. В следующем примере текст записывается в уже существующую строку таблицы blurbs:</p>
&nbsp;</p>
declare @val varbinary(16) </p>
select @val = textptr(copy) from blurbs </p>
where&nbsp; au_id="172-32-1176"</p>
writetext blurbs.copy @val&nbsp; "This book is a must for true data junkies."</p>
&nbsp;</p>
В этом примере текстовый указатель записывается в локальную переменную @val, а затем команда writetext записывает новый текст в строку, на которую указывает тестовый указатель.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Удаление данных</td></tr></table></div>&nbsp;</p>
Так же как и операторы insert и update, оператор delete (удалить) может модифицировать как одну, так и несколько строк, но является&nbsp; более удобным для удаления сразу нескольких строк. Как и во всех операторах модификации данных, при удалении строк можно использовать данные из других таблиц. </p>
Например, если пользователь решил удалить одну строку из таблицы publishers, которая относится к издательству Jardin Inc., то следует выполнить следующий оператор:</p>
&nbsp;</p>
delete publishers </p>
where pub_name = "Jardin, Inc."</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Синтаксис команды delete</td></tr></table></div>&nbsp;</p>
Упрощенный вариант синтаксиса команды delete выглядит следующим образом:</p>
&nbsp;</p>
delete название_таблицы </p>
where название_столбца = выражение </p>
&nbsp;</p>
Ниже приведен полный синтаксис этой команды, в котором показано, что строки можно удалять основываясь как на значении выражения, так и на основе данных из других таблиц:</p>
&nbsp;</p>
&nbsp;</p>
delete [from][[база_данных.]владелец.]{ название_таблицы&nbsp; | название_вьювера } </p>
 &nbsp;&nbsp; [from [[база_данных.]владелец.]{ название_таблицы | название_вьювера }&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
 &nbsp;&nbsp; [, [[база_данных.]владелец.]{ название_таблицы | название_вьювера }]...]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
 &nbsp;&nbsp; [where условия_отбора ]&nbsp;&nbsp; </p>
&nbsp;</p>
Необязательное&nbsp; слово from, следующее сразу за ключевым словом delete, сохранено только для совместимости с другими версиями языка SQL. А конструкция from, находящаяся во второй строке синтаксиса, является расширением языка SQL, с помощью которой можно проводить удаление, основываясь на данных из других таблиц.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование конструкции where в операторе delete</td></tr></table></div>&nbsp;</p>
В конструкции where определяются строки, которые нужно удалить. Если в операторе удаления эта конструкция отсутствует, то удаляются все строки таблицы. </p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Использование конструкции from в операторе delete</td></tr></table></div>&nbsp;</p>
Конструкция from, расположенная на второй позиции в операторе delete, является специальным расширением языка Transact-SQL, которая позволяет выбирать данные из других таблиц и в соответствии с ними удалять данные из исходной таблицы. Фактически. данные, которые выбираются с помощью этой конструкции, формируют условия удаления исходных данных.</p>
Предположим, что некоторая компания изучает результаты публикации книг, написанных авторами из Окленда (который здесь называется Big Bad Bay City). Необходимо удалить все эти книги из таблицы titles, но при этом неизвестны ни названия книг, ни их идентификационные коды. Известны только имена авторов и их адреса.</p>
Чтобы удалить книги из таблицы titles, нужно предварительно найти в&nbsp; таблице authors коды авторов, живущих в Окленде, и использовать их для поиска кодов книг этих авторов в таблице titleauthor. Другими словами, необходимо провести тройное соединение (соединение по трем таблицам), чтобы найти в таблице titles, книги подлежащие удалению.</p>
Эти три таблицы нужно включить в конструкцию from оператора удаления. Однако, удаляться будут только те строки, которые удовлетворяют условию, указанному в конструкции where. Для удаления соответствующих данных в других таблицах нужно использовать отдельный (другой) оператор удаления. </p>
Итак, описанный оператор удаления будет выглядеть следующим образом:</p>
&nbsp;</p>
delete titles </p>
from authors, titles, titleauthor </p>
where titles.title_id = titleauthor.title_id </p>
and authors.au_id = titleauthor.au_id </p>
and city = "Big Bad Bay City"</p>
&nbsp;</p>
Триггер deltitle, находящийся в базе данных pubs2, не позволит осуществить действительное удаление этих данных, поскольку он запрещает удаление любых книг, сведения о продаже которых имеются в таблице sales.</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Удаление всех строк таблицы </td></tr></table></div>&nbsp;</p>
Команду truncate table (очистить таблицу) можно использовать для быстрого удаления всех строк из таблицы. Она работает почти всегда быстрее чем оператор delete, в котором нет никаких условий, поскольку при выполнении оператора delete в журнале транзакций фиксируется каждое изменение, в то время как при выполнении команды truncate table в журнале запоминаются все страницы данных, занимаемые таблицей. Эта команда сразу освобождает всю память, занимаемую табличными данными и индексами. После этого освобожденная память может использоваться другими объектами базы данных. Освобождаются также распределенные страницы всех индексов. Не следует забывать о команде update statistics (обновление статистики), которую надо запускать после добавления новых строк в таблицу.</p>
Таблица, освобожденная от данных оператором delete или truncate table, остается в базе данных вместе со своими индексами и всеми другими ассоциированными объектами, до тех пор пока не будет выполнен оператор drop table (удалить таблицу).</p>
&nbsp;</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="21"></td><td>Синтаксис команды truncate table</td></tr></table></div>&nbsp;</p>
Синтаксис команды truncate table имеет следующий вид:</p>
&nbsp;</p>
truncate table [[база_данных.]владелец.] название_таблицы&nbsp; </p>
&nbsp;</p>
Например, удалить все данные из таблицы sales можно следующим образом: </p>
&nbsp;</p>
truncate table sales</p>
&nbsp;</p>
По умолчанию право на использование команды truncate table также, как и команды drop table, имеет владелец таблицы, и это право не может передаваться.</p>
Команда truncate table не запускает триггер удаления. Этот вопрос более подробно рассматривается в главе 15 “Триггера: обеспечение ссылочной целостности данных.</p>
&nbsp;</p>
