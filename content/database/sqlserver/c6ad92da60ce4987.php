<h1>Поиск значения по любому столбцу</h1>
<div class="date">01.01.2007</div>


<p>Частенько встречается следующая ситуация. Вы работате с базой данных, в </p>
<p>которой множество таблиц. К концу рабочего дня голова идёт кругом от</p>
<p>названий столбцов, ...</p>
<p>Ещё ситуация: вы знаете, что где то в таблице должно было появиться опреде-</p>
<p>лённое число (с помощью клиентской программы ввели, например, год своего рождения,</p>
<p>но не желаете разбираться в таблице 200*150000, в какое именно поле и в какой строке</p>
<p>оно оказалось записано...</p>
<p>Или вам просто лень...</p>
<p>В общем - лень - двигатель прогресса.</p>
<p>Сформулируем задачу: можно ли выбрать из таблицы все записи в которых встречается</p>
<p>определённое значение поля в любом из столбцов?</p>
<p>Можно!</p>
<p>Именно для этого я и написал приблуду, которую и хочу представить вашему вниманию.</p>
<p>Надеюсь, что код достаточно хорошо прокомментирован.</p>

<pre>
declare
@sColumnName&nbsp;&nbsp; varchar(30),
@sQuery&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; varchar(200),
@sTempQuery&nbsp;&nbsp;&nbsp; varchar(200),
@sTabname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; varchar(30),
@nSearchParam&nbsp; int

----установим рабочие переменные:
SELECT @sTabname&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = 'relTable' &nbsp;&nbsp;&nbsp; ----имя таблицы, из которой будем производить выборку
SELECT @nSearchParam&nbsp; = 9348 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ----искомое значение, в данном случае - неккий id.


----все имена колонок нашей БД хранятся в таблице syscolumns, все объекты: в таблице sysobjects
----эти две таблицы мы свяжем по полю id, следующим заполним временную таблицу #cname, 
----в которой будут храниться имена всех столбцов интересующей нас таблицы

SELECT c.name INTO #cname 
  FROM syscolumns c, sysobjects o 
  WHERE c.id = o.id 
  AND c.xtype = 56 
  AND o.xtype = 'U' 
  AND c.type = 38 
  AND o.name = @sTabname

---Примечание:
---c.xtype = 56 &nbsp;&nbsp; - означает, что нас интересуют только поля таблиц
---c.type&nbsp; = 38 &nbsp;&nbsp; - означает, что нас интересуют числовые поля

SELECT @sColumnName = '' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --начальная инициализация - на всякий пожарный

WHILE 1 = 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
BEGIN
  SET rowcount 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --данные из таблицы будем выбирать по одной строке
  SELECT @sColumnName = name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --получили имя 
 &nbsp;&nbsp; FROM  #cname&nbsp; 
 &nbsp;&nbsp; WHERE name &gt; @sName&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --следующей колонки
 &nbsp;&nbsp; ORDER BY  name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --обязательно отсортировать по полю, которое выбираем!


  IF @@rowcount = 0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --если дошли до конца временно таблицы
  BEGIN
 &nbsp;&nbsp; SET rowcount 0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
 &nbsp;&nbsp; BREAK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --завершим цикл
  END

  SET rowcount 0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 


  --используем динамическое создание SQL запроса
  SELECT @sTempQuery = ' WHERE ' + @sColumnName + '= ' + Str(@nSearchParam)&nbsp;&nbsp;&nbsp; 
  SELECT @sQuery = 'IF EXIST (SELECT 1 FROM ' + @sTabname + @sTempQuery + ') BEGIN ' +
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' SELECT ' + @sColumnName + ',* FROM ' + @sTabname + @sTempQuery + ' END' &nbsp;&nbsp;&nbsp; 

  --исполним его
  EXEC (@sQuery)

  --такие сложности с EXIST нам нужны для того, что бы QueryAnalyzer не мучал нас выводом пустых 
  --результатов запроса
END
DROP TABLE #cname&nbsp;&nbsp;&nbsp; ---уничтожим временную таблицу
</pre>


<p>Что то похожее можно написать для поиска строкового параметра, я думаю, Вы и сами</p>
<p>справитесь с этой простой задачей. Аналогично, для диапазонов значений, и т.д.</p>
<p>Остаётся лишь подправить по своему вкусу запрос @sTempQuery.</p>
<p>Успехов</p>

<p>P.S. Вчера, пока писал эту приблуду, обнаружил небольшую брешь в БД. А именно - недостаток</p>
<p>записей с определёнными id. Сначала думал, что сам неправильно пишу, но оказалось, что </p>
<p>это глюк БД, при чём глюк - не от немецкого слова счастье, а от русского слова несчастье.</p>
<p>Оказалось - очень полезная штука! Надеюсь, и вам пригодится. </p>

<p class="author">Автор: AQL</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
