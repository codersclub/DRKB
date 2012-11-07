<h1>Поиск значения по любому столбцу</h1>
<div class="date">01.01.2007</div>


<p>Частенько встречается следующая ситуация. Вы работате с базой данных, в</p>
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
@sColumnName   varchar(30),
@sQuery        varchar(200),
@sTempQuery    varchar(200),
@sTabname      varchar(30),
@nSearchParam  int

----установим рабочие переменные:
SELECT @sTabname      = 'relTable'     ----имя таблицы, из которой будем производить выборку
SELECT @nSearchParam  = 9348           ----искомое значение, в данном случае - неккий id.


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
---c.xtype = 56    - означает, что нас интересуют только поля таблиц
---c.type  = 38    - означает, что нас интересуют числовые поля

SELECT @sColumnName = ''          --начальная инициализация - на всякий пожарный

WHILE 1 = 1                  
BEGIN
  SET rowcount 1                  --данные из таблицы будем выбирать по одной строке
  SELECT @sColumnName = name      --получили имя 
    FROM  #cname  
    WHERE name &gt; @sName           --следующей колонки
    ORDER BY  name                --обязательно отсортировать по полю, которое выбираем!


  IF @@rowcount = 0               --если дошли до конца временно таблицы
  BEGIN
    SET rowcount 0          
    BREAK                         --завершим цикл
  END

  SET rowcount 0            


  --используем динамическое создание SQL запроса
  SELECT @sTempQuery = ' WHERE ' + @sColumnName + '= ' + Str(@nSearchParam)    
  SELECT @sQuery = 'IF EXIST (SELECT 1 FROM ' + @sTabname + @sTempQuery + ') BEGIN ' +
                   ' SELECT ' + @sColumnName + ',* FROM ' + @sTabname + @sTempQuery + ' END'     

  --исполним его
  EXEC (@sQuery)

  --такие сложности с EXIST нам нужны для того, что бы QueryAnalyzer не мучал нас выводом пустых 
  --результатов запроса
END
DROP TABLE #cname    ---уничтожим временную таблицу
</pre>


<p>Что то похожее можно написать для поиска строкового параметра, я думаю, Вы и сами</p>
<p>справитесь с этой простой задачей. Аналогично, для диапазонов значений, и т.д.</p>
<p>Остаётся лишь подправить по своему вкусу запрос @sTempQuery.</p>
<p>Успехов</p>

<p>P.S. Вчера, пока писал эту приблуду, обнаружил небольшую брешь в БД. А именно - недостаток</p>
<p>записей с определёнными id. Сначала думал, что сам неправильно пишу, но оказалось, что</p>
<p>это глюк БД, при чём глюк - не от немецкого слова счастье, а от русского слова несчастье.</p>
<p>Оказалось - очень полезная штука! Надеюсь, и вам пригодится.</p>

<div class="author">Автор: AQL</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
