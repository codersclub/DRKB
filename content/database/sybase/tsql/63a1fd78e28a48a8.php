<h1>Триггера: поддержка ссылочной целостности</h1>
<div class="date">01.01.2007</div>


<p>Триггера: поддержка ссылочной целостности</p>
</p>
Пользователь может использовать триггера для обеспечения ссылочной целостности данных в базе. Триггера позволяют также проводить “каскадное” изменение данных в связанных таблицах, поддерживают более сложные ограничения целостности данных в таблице по сравнению с правилами,  позволяют сравнивать модифицированные данные и выполнять некоторые действия в результате этого сравнения.</p>
В данной главе обсуждаются следующие темы:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Дается общий обзор триггеров;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Показано, как создавать и удалять триггера;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Описываются способы обеспечения целостности данных в базе с помощью триггеров;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Показано, как связать правило с триггером;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Описываются способы получения информации о триггерах.</td></tr></table></div></p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Что такое триггер ?</td></tr></table></div></p>
Триггер - это сохраняемая процедура специального вида, которая запускается в момент модификации данных в таблице. Триггеры помогают сохранить ссылочную целостность данных пользователя, проверяя их согласованность в логически связанных таблицах. Ссылочная целостность означает, что значения главного ключа (primary key) и значение соответствующего внешнего ключа (foreign key) должны в точности совпадать.</p>
Основным достоинством триггеров является то, что они вызываются автоматически. Они будут работать независимо от причины, которая вызвала модификацию данных, как, например, после ввода данных клерком, так и при выполнении некоторой прикладной процедуры. Триггер может быть связан с одним или несколькими операторами модификации, такими как update, insert или delete. Триггер исполняется один раз в одном SQL операторе.</p>
Триггер “зажигается” (вызывается) только после окончания оператора модификации данных. После запуска триггера SQL Сервер проверяет условия целостности модифицированных данных по типу, соответствию правилам и ограничениям целостности. Триггер и оператор, который вызвал его запуск, рассматриваются как одна транзакция, в рамках которой триггер может вызвать восстановление исходных данных (rolled back) при появлении  ошибки. Другими словами, если в процессе проверки обнаруживается серьезная ошибка, то вся транзакция откатывается назад (rolled back).</p>
Триггера особенно полезны в следующих ситуациях:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Триггер может “каскадно” вносить изменения во взаимосвязанные таблицы базы данных. Например, удаляющий триггер, связанный со столбцом title_id таблицы titles, может также удалить соответствующие строки из таблиц titleauthor, sales и roysched, используя значение в столбце title_id как уникальній ключ;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Триггер может запретить или “откатить” изменения данных, вызывающие нарушение ссылочной целостности, путем нейтрализации транзакции, которая вносит эти изменения. Такой триггер может запуститься, если пользователь попытается указать значение внешнего ключа, которое не совпадает с главным ключом. Например, пользователь может создать вставляющий триггер, связанный с таблицей titleauthor и откатывающий любые вставки строк, в которых значение в столбце title_id не совпадает ни с одним из значений в столбце titles.title_id;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Триггера могут отслеживать значительно более сложные ограничения по сравнению с правилами. В противоположность правилам, в триггерах можно ссылаться на табличные столбцы и объекты базы данных. Например, триггер может запретить увеличение цены книги, превосходящее один процент от аванса;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Триггера могут выполнять простейший “что, если” анализ. Например, триггер может сравнить состояние таблицы до и после модификации данных и предпринять некоторое действие, основанное на этом сравнении.</td></tr></table></div></p>
В этой главе дается синтаксис определения триггеров, обсуждаются вопросы, связанные с их использованием, и приводятся примеры триггеров. В последнем разделе этой главы описываются правила, которых нужно придерживаться при использовании триггеров, и объясняется как запускать системные процедуры помощи, дающие информацию о триггерах.</p>
</p>
Замечание: За исключением триггера deltitle, триггеров, описанных в данной главе, нет в базе данных pubs2, копия которой поставляется с SQL Сервером. Чтобы работать с этими триггерами, пользователь должен создать их с помощью оператора creat trigger. Каждый новый триггер, который определяется для операции  вставки, обновления или удаления, связанных с одной и той же таблицей или столбцом, записывается на место предыдущего без предупреждения и прежний триггер автоматически удаляется.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Сравнение триггеров с ограничениями целостности</td></tr></table></div></p>
Альтернативой использованию триггеров является введение ограничений ссылочной целостности в операторе создания таблицы creat table. Однако, с помощью этих ограничений невозможно решить следующие задачи:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Выполнить “каскадное” изменение данных в связанных таблицах базы данных;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Обеспечить соблюдение сложных ограничений целостности, включающих другие таблицы и объекты базы данных;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Выполнить анализ “что-если” (what if).</td></tr></table></div></p>
Кроме того, ограничения ссылочной целостности не откатывают текущую транзакцию в результате защиты целостности данных. Триггер может нейтрализовать изменения, произошедшие в текущей транзакции, или продолжить ее выполнение в зависимости от того, как пользователь трактует ссылочную целостность. Информация о транзакциях будет дана в главе 17 “Транзакции: сохранение корректности данных и их восстановление”.</p>
Если в приложении пользователя требуется выполнить одно из описанных действий, то ему необходимо использовать триггера. В противном случае, простейшим способом защиты целостности данных является введение ограничений ссылочной целостности. Заметим, что SQL Сервер проверяет справедливость ограничений ссылочной целостности перед запуском любых триггеров, поэтому оператор модификации данных, который нарушает эти ограничения, не вызовет запуска триггера. Более детальная информация об ограничениях ссылочной целостности приводится в главе 7 “Создание баз данных и таблиц”.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Создание триггеров</td></tr></table></div></p>
Триггер является объектом базы данных. Когда создается триггер, пользователь должен указать таблицу и оператор модификации данных, которые должны “зажигать” (активизировать) этот триггер. Затем пользователь указывает действия, которые должен выполнить этот триггер.</p>
Рассмотрим простой пример. Следующий триггер посылает сообщение каждый раз, когда пользователь пытается вставить, удалить или обновить данные в таблице titles:</p>
</p>
create trigger t1</p>
on titles</p>
for insert, update, delete</p>
as</p>
print "Now modify the titleauthor table the same way."</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Синтаксис команды создания триггера creat trigger</td></tr></table></div></p>
Полный синтаксис команды создания триггера имеет следующий вид:</p>
</p>
creat trigger [владелец.]название_триггера</p>
  on [владелец.]название_таблицы</p>
  for {insert, update, delete}</p>
  as SQL_операторы</p>
</p>
Можно также определить триггер с помощью предложения if update:</p>
</p>
creat trigger [владелец.]название_триггера</p>
  on [владелец.]название_таблицы</p>
  for {insert, update}</p>
  as</p>
  [if update (название_столбца) [{and | or} update (название_столбца)] … ]</p>
       SQL_операторы</p>
  [if update (название_столбца) [{and | or} update (название_столбца)] …</p>
        SQL_операторы] …</p>
</p>
В предложении creat создается триггер и ему присваивается название. Это название должно удовлетворять правилам, установленным для идентификаторов.</p>
В предложении on указывается название таблицы, которая активизирует этот триггер. Эта таблица иногда называется триггерной таблицей.</p>
Триггер создается в текущей базе данных, хотя в нем можно ссылаться на объекты, расположенные в других базах данных. Владелец триггера должен быть тем же, что и владелец таблицы. Никто, кроме владельца таблицы, не может создать для нее триггер. Если явно указывается владелец триггера в предложении creat trigger (создать триггер), то он также должен быть явно указан в предложении on как владелец таблицы и наоборот.</p>
В предложении for указываются операторы модификации данных, которые активизируют триггер при обращении к триггерной таблице. В предыдущем примере сообщение будет выдаваться при выполнении любого из операторов insert, update или delete, которые обращаются к таблице titles.</p>
SQL операторы определяют триггерные условия или триггерные действия. В триггерных условиях задаются дополнительные критерии, которые определяют, надо ли после выполнения операторов вставки, удаления или обновления вызывать триггер или нет. Если в предложении if надо выполнить несколько операторов, то они должны быть заключены в операторные скобки begin и end.</p>
В предложении if update (если обновление) проверяется, надо ли вставлять или обновлять данные в указанном табличном столбце. Условие в предложении if update проверяется на истинность, если название столбца присутствует в предложении set оператора update, даже в том случае, когда обновление не изменяет значение в этом столбце. Предложение if update не используется при удалении данных оператором delete. В этом предложении можно указать несколько столбцов и в одном операторе создания триггера можно поместить несколько предложений if update. Поскольку название таблицы указывается в предложении on, не следует указывать его перед названием столбца в предложении if update.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Операторы, которые нельзя использовать в триггерах</td></tr></table></div></p>
Поскольку триггера выполняются как части транзакций, следующие операторы нельзя использовать в определении триггеров:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Все команды создания объектов, включая создание базы данных, таблицы, индекса, процедуры, умолчания, правила, триггера и вьювера;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Все команды удаления объектов (drop);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Изменение структуры таблицы или базы данных (alter table, alter database);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Удаление таблицы (truncate table);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Команды grant и revoke;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Обновление статистики (update statistics);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Реконфигурации (reconfigure);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Загрузки транзакции и загрузки базы данных (load database, load transaction);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Команды работы с диском (disk init, disk mirror, disk reinit, disk remirror, disk unmirror);</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 113px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="19">&#183;</td><td>Оператор select into.</td></tr></table></div></p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Удаление триггеров</td></tr></table></div></p>
Пользователь может удалить триггер с помощью команды удаления (drop) или путем удаления всей таблицы, с которой он связан.</p>
Команда удаления триггера drop trigger имеет следующий вид:</p>
</p>
drop trigger [владелец.]название_триггера</p>
     [, [владелец.]название_триггера] …</p>
</p>
Когда удаляется таблица, то вместе с ней автоматически удаляются любые связанные с ней триггеры. Команда удаления триггера может выполняться только владельцем триггерной таблицы, и нельзя передавать права на ее использование.</p>
</p>
<div style="text-align: center; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Использование триггеров для сохранения ссылочной целостности</td></tr></table></div></p>
Триггера используются для сохранения ссылочной целостности данных, т.е. сохранения жизненно важных свойств данных, таких, например, как уникальность некоторых идентификаторов, в процессе изменения базы данных. Ссылочная целостность обеспечивается через главные (primary) и внешние (foreign) ключи.</p>
Главный ключ - это значение в столбце или комбинация значений в нескольких столбцах, которая однозначно определяет строку. Эти столбцы не могут содержать неопределенных значений и с ними должен быть связан уникальный индекс. Главный ключ таблицы может использоваться для ее соединения через внешние ключи с другими таблицами. Таблица, содержащая главный ключ, может рассматриваться как главная (master) таблица, а связь по ключу, как связь типа главное-детали. В базе данных может быть много таких групп, состоящих из главной таблицы и ее детализаций.</p>
Пользователь может использовать процедуру sp_primarykey для определения главного ключа. После этого ключ добавляется в таблицу syskeys (системные ключи) и может использоваться в процедуре sp_helpjoins.</p>
Например, в базе данных pubs2 столбец title_id является главным ключом таблицы titles. Значение в этом столбце однозначно идентифицирует книгу в таблице titles и этот ключ может использоваться для соединения по столбцу title_id c таблицами titleauthor, salesdetail и roysched. Таким образом, в данном случае таблица titles является главной по отношению к таблицам titleauthor, salesdetail и roysched. Эти взаимосвязи между таблицами показаны на диаграмме в первой главе “База данных pubs2” Справочного пособия SQL Сервера.</p>
Внешний ключ - это значение в столбце или комбинация значений в нескольких столбцах, которая совпадает со значением главного ключа. Внешний ключ может быть не уникальным. Обычно они находятся в соответствии многие-к-одному по отношению к значению главного ключа. Значения внешнего ключа должны быть копией значений главного ключа. Это означает, что любое значение внешнего ключа должно содержаться среди значений главного ключа. Внешний ключ может содержать неопределенные значения. Если какая-либо составная часть внешнего ключа является неопределенной, то и полное значение внешнего ключа должно быть неопределенным. Таблицы с внешними ключами часто называются детализациями или зависимыми таблицами по отношению к главной таблице.</p>
Пользователь может использовать процедуру sp_foreignkey для определения внешних ключей в базе данных. Это позволяет использовать их в процедуре sp_helpjoins и в других процедурах, которые обращаются к таблице syskeys.</p>
Таким образом, столбец title_id в таблицах titleauthor, salesdetail и roysched является внешним ключом, а сами эти таблицы являются детализациями главной таблицы.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Как работают триггера</td></tr></table></div></p>
Триггеры для обеспечения ссылочной целостности запоминают значения внешних ключей вместе со значением главного ключа. После модификации ключевого значения триггер сравнивает новое значение со связанными с ним ключевыми значениями с помощью временных таблиц, которые называются триггерными тестовыми таблицами (trigger test tables). Если пользователь определил свой триггер, то его данные будут сравниваться с данными, которые временно запоминаются в тестовых таблицах.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Проверка модификации данных и триггерные тестовые таблицы</td></tr></table></div></p>
При вызове триггеров используются две специальные таблицы: таблица удаления (deleted table) и таблица добавления (inserted table). Они используются для проверки операторов модификации данных и создания условий для работы триггеров. Пользователь не может непосредственно изменять данные в этих таблицах, но может использовать находящуюся в них информацию для проверки последствий выполнения операторов insert, update или delete.</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В таблице удаления сохраняются копии строк, которые удаляются операторами update или delete. В процессе выполнения этих операторов строки удаляются из триггерной таблицы и помещаются в таблицу удаления. Обычно триггерная таблица и таблица удаления не имеют общих строк.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>В таблице добавления сохраняются копии строк, которые вставляются операторами insert или update. В процессе выполнения этих операторов новые строки вставляются в таблицу добавления и триггерную таблицу одновременно. Таким образом,  таблица добавления всегда содержит копии новых строк, которые были добавлены в триггерную таблицу.</td></tr></table></div></p>
<img src="/pic/embim1736.png" width="543" height="426" vspace="1" hspace="1" border="0" alt=""></p>
Рис. 15-1: Использование триггерных тестовых таблиц при изменении данных</p>
</p>
При установке условий запуска триггера следует использовать  проверочную таблицу, которая соответствует оператору модификации данных. Хотя, вообще говоря, можно обратиться к таблице удаления в процессе проверки оператора insert или к таблице добавления в процессе проверки оператора delete, но в этих случаях эти таблицы будут пусты.</p>
</p>
Замечание: Каждый триггер запускается только один раз в процессе выполнения запроса. Поэтому, если действия триггера зависят от числа модифицируемых строк, то нужно обратиться к глобальной переменной @@rowcount и выполнить для каждой строки соответствующую проверку.</p>
</p>
В следующем примере триггера как раз проводится проверка, где это необходимо, всех модифицированных строк. Глобальная переменная @@rowcount, в которой хранится число строк, модифицированных последним оператором insert delete или update, используется для проверки корректности всех модифицированных строк. Если в триггере используется еще один оператор выбора до того как проверяется значение переменной @@rowcount, то ее значение следует запомнить в локальной переменной, поскольку любой Transact-SQL оператор, который не возвращает никакого значения сбрасывает переменную @@rowcount в ноль.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Пример вставляющего триггера</td></tr></table></div></p>
Когда добавляется строка в таблицу с внешним ключом, то необходимо убедиться, что заданное значение внешнего ключа встречается среди значений главного ключа. Триггер может проверить это условие путем соединения добавляемых строк с исходной таблицей, содержащей главный ключ, с последующим откатом добавления в случае несовпадения этих значений. В следующем примере отменяются любые изменения, производимые оператором insert в случае нарушения условия согласованности ключей хотя бы в одной строке. Позже будет показано как отменять изменения выборочно.</p>
При выполнении оператора insert новые строки добавляются в триггерную таблицу и в триггерную тестовую таблицу добавления. Для проверки совпадения добавленных ключей с главными ключами, образуется соединение между таблицей добавления и главной таблицей (с главными ключами).</p>
Следующий триггер сравнивает значения в столбце title_id таблицы добавления со значениями в одноименном столбце таблицы titles. Предполагается, что пользователь указал для внешнего ключа некоторое непустое значение. Если соединение не может быть выполнено, то транзакция откатывается назад.</p>
</p>
create trigger forinsertrig1</p>
on salesdetail</p>
for insert</p>
as</p>
if (select count(*)</p>
    from titles, inserted</p>
    where titles.title_id = inserted.title_id) != @@rowcount</p>
/* cancel the insert and print a message.*/</p>
  begin</p>
    rollback transaction</p>
    print "No, a title_id does not exist in titles"</p>
  end</p>
/* Otherwise, allow it. */</p>
else</p>
  print "Added! All title_id's exist in titles."</p>
</p>
В этом примере глобальная переменная @@rowcount указывает число добавляемых строк в таблицу salesdetail. Ее значение также совпадает с числом строк вставленных в таблицу добавление. Проверка наличия всех значений ключа из столбца title_id, добавленных в таблицу salesdetail, в таблице titles осуществляется путем соединения таблицы titles и таблицы добавления. Если число соединенных строк, которые подсчитываются в операторе select count(*), отличается от значения переменной @@rowcount, то некоторые из добавленных строк были неправильными и поэтому все изменения, произведенные этой транзакцией, будут отменены.</p>
Этот триггер выдает сообщение об ошибке в случае отката и об успешном завершении транзакции, если все строки правильные.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Пример удаляющего триггера</td></tr></table></div></p>
Когда удаляется строка, содержащая значение главного ключа, то необходимо также удалить все строки в зависимых таблицах, которые содержат то же значение внешнего ключа. Это позволяет сохранить ссылочную целостность, поскольку детализирующие строки удаляются вместе с главной строкой. Если этого не сделать, то в базе данных могут появиться недоступные или лишние строки. Для выполнения этой задачи необходим триггер, который осуществляет каскадное удаление.</p>
Рассмотрим следующий пример. Когда из таблицы titles удаляются несколько строк, то после удаления они добавляются в таблицу удаления. Триггер может проверить зависимые таблицы titleauthor, salesdetail и roysched на наличие строк со значением удаляемого ключа в столбце title_id. Если триггер найдет такую строку, то он удаляет ее.</p>
</p>
create trigger delcascadetrig</p>
on titles</p>
for delete</p>
as</p>
delete titleauthor</p>
from titleauthor, deleted</p>
where titleauthor.title_id = deleted.title_id</p>
        /* Remove titleauthor rows</p>
        ** that match deleted (titles) rows.*/</p>
delete salesdetail</p>
from salesdetail, deleted</p>
where salesdetail.title_id = deleted.title_id</p>
        /* Remove salesdetail rows</p>
        ** that match deleted (titles) rows.*/</p>
delete roysched</p>
from roysched, deleted</p>
where roysched.title_id = deleted.title_id</p>
        /* Remove roysched rows</p>
        ** that match deleted (titles) rows.*/</p>
</p>
На практике может возникнуть ситуация, когда необходимо сохранить некоторые из детализирующих строк. Такая необходимость может возникнуть по историческим причинам (например, чтобы проверить, сколько было продано  давно изданных книг) или потому, что транзакции с детализирующими строками еще не были полностью выполнены. Хорошо написанный триггер должен учитывать эти факторы.</p>
В следующем примере триггер deltitle, поставляемый вместе с базой данных pubs2, предотвращает удаление строки с главным ключом, если значение этого ключа встречается в таблице salesdetail. Таким образом, этот триггер сохраняет возможность последующего выбора строк из таблицы salesdetail.</p>
</p>
create trigger deltitle</p>
on titles</p>
for delete</p>
as</p>
if (select count(*)</p>
    from deleted, salesdetail</p>
    where salesdetail.title_id =</p>
    deleted.title_id) &gt; 0</p>
  begin</p>
    rollback transaction</p>
    print "You can't delete a title with sales."</p>
  end</p>
</p>
Этот триггер соединяет удаляемые из таблицы строки titles строки с таблицей salesdetail. Если произошло хотя бы одно соединение, то транзакция откатывается.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Примеры обновляющих триггеров</td></tr></table></div></p>
Поскольку значения главного ключа являются уникальными, то к обновлению этих значений нужно подходить очень внимательно. В этом случае для сохранения ссылочной целостности допускаются лишь транзакции, удовлетворяющие определенным условиям.</p>
Вообще говоря, лучше всего запретить любое редактирование значений главного ключа путем, например, отмены всех прав на этот столбец. Но если необходимо в некоторых случаях разрешить обновление, то следует использовать триггер.</p>
В следующем примере триггер запрещает обновления в столбце таблицы titles.title_id в конце недели (суббота и воскресенье). Предложение if update триггера stopupdatetrig позволяет перенести фокус внимания на столбец titles.title_id. Поэтому данный триггер будет запускаться при попытке обновления значений в этом столбце. Изменения значений в других столбцах не будут приводить к запуску. Когда триггер определит, что нарушены условия обновления, он запрещает изменения и выдает сообщение. Это можно проверить просто записав текущий день недели вместо “Saturday” (суббота) или “Sunday” (воскресенье).</p>
</p>
create trigger stopupdatetrig</p>
on titles</p>
for update</p>
as</p>
/* If an attempt is made to change titles.title_id</p>
** on Saturday or Sunday, cancel the update.</p>
*/</p>
if update (title_id)</p>
    and datename(dw, getdate())</p>
    in ("Saturday", "Sunday")</p>
  begin</p>
    rollback transaction</p>
    print "We don't allow changes to"</p>
    print "primary keys on the weekend!"</p>
  end</p>
</p>
Пользователь может с помощью триггера реагировать на обновление данных в нескольких столбцах. В следующем примере приводится модифицированный триггер stopupdatetrig, который реагирует также на обновление данных в столбцах titles.price и titles.advance. Кроме запрещения обновления главного ключа в конце недели, этот триггер также запрещает обновление цены книги или выданного аванса, если общий доход от продажи этой книги меньше величины аванса. Для этого триггера можно использовать то же название, поскольку в этом случае прежний триггер автоматически удаляется.</p>
</p>
create trigger stopupdatetrig</p>
on titles</p>
for update</p>
as</p>
if update (title_id)</p>
  and datename(dw, getdate())</p>
  in ("Saturday", "Sunday")</p>
  begin</p>
    rollback transaction</p>
    print "We don't allow changes to"</p>
    print "primary keys on the weekend!"</p>
  end</p>
if update (price) or update (advance)</p>
  if (select count(*) from inserted</p>
    where (inserted.price * inserted.total_sales)</p>
    &lt; inserted.advance) &gt; 0</p>
    begin</p>
      rollback transaction</p>
      print "We don't allow changes to price or"</p>
      print "advance for a title until its total"</p>
      print "revenue exceeds its latest advance."</p>
    end</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 16px 63px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Обновление внешнего ключа</td></tr></table></div></p>
Изменение или обновление значения внешнего ключа само по себе, скорее всего, свидетельствует об ошибке. Значения внешнего ключа всегда должны быть копиями значений главного ключа. Эти значения никогда не должны изменяться независимо друг от друга. Если по каким-то причинам нужно обновить значение внешнего ключа, то для сохранения ссылочной целостности необходимо определить триггер, который бы проверял значение ключа по таблице master и отменял бы изменение, если новое значение ключа не соответствует значению главного ключа.</p>
В следующем примере триггер проверяет два возможных источника ошибок: либо обновляемое значение не встречается в столбце title_id таблицы salesdetail, либо нового значения ключа нет в таблице titles.</p>
В этом примере используется составной оператор if…else. Первое условие в операторе if будет истинным, если ни одна строка таблицы salesdetail не удовлетворяет условию, указанному в предложении where оператора update, и следовательно в этом случае оператор выбора select выдаст пустой список. Если при этой проверке был выдан непустой список, то выполняется второй условный оператор, который проверяет встречаются ли новые значения ключа, находящиеся в строках таблицы inserted, в таблице titles. Если при соединении таблиц inserted и titles по столбцу title_id хотя бы одна строка не удовлетворяет условию соединения, то транзакция откатывается и выдается сообщение об ошибке. Если все строки удовлетворяют условию соединения, то выдается сообщение об успешном обновлении таблицы salesdetail.</p>
</p>
create trigger forupdatetrig</p>
on salesdetail</p>
for update</p>
as</p>
declare @row int</p>
/* save value of rowcount */</p>
select @row = @@rowcount</p>
if update (title_id)</p>
  begin</p>
    if (select distinct inserted.title_id</p>
        from inserted) is null</p>
      begin</p>
        rollback transaction</p>
        print "No!  Old title_id must be in</p>
              salesdetail"</p>
      end</p>
    else</p>
      if (select count(*)</p>
          from titles, inserted</p>
          where titles.title_id =</p>
          inserted.title_id) != @row</p>
        begin</p>
          rollback transaction</p>
          print "No! New title_id not in titles"</p>
        end</p>
      else</p>
        print "salesdetail table updated"</p>
  end</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Операции с группами строк</td></tr></table></div></p>
Иногда бывает важно различать запросы, выдающие одну строку и более одной строки (группу строк). Это особенно важно, когда триггер должен автоматически перевычислять итоговые значения.</p>
Триггер, использующийся для вычисления итоговых значений, должен содержать предложение group by или подзапросы, которые выполняют неявную группировку, когда вставляется, обновляется или удаляется более одной строки. Поскольку группировка занимает дополнительные ресурсы, то в следующем примере проверяется равна ли единице величина переменной @@rowcount, чтобы специально выделить случай, когда запрос обрабатывает только одну строку в триггерной таблице. Если значение переменной @@rowcount равно единице, то триггер выполняет свои действия без группировки.</p>
В этом примере вставляющий триггер обновляет значение в столбце total_sales таблицы titles каждый раз, когда добавляется новая строка к таблице salesdetail. При этом значение в столбце total_sales устанавливается равным прежнему значению плюс значение, указанное в столбце salesdetail.qty. Это позволяет своевременно обновлять итоговое значение продаж и поддерживать его соответствующим числу продаж, указанных в столбце salesdetail.qty.</p>
</p>
create trigger intrig</p>
on salesdetail</p>
for insert as</p>
    /* check value of @@rowcount */</p>
if @@rowcount = 1</p>
    update titles</p>
      set total_sales = total_sales + qty</p>
      from inserted</p>
      where titles.title_id = inserted.title_id</p>
else</p>
    /* when rowcount is greater than 1,</p>
       use a group by clause */</p>
    update titles</p>
      set total_sales =</p>
        total_sales + (select sum(qty)</p>
      from inserted</p>
      group by inserted.title_id</p>
      having titles.title_id = inserted.title_id)</p>
</p>
</p>
В следующем примере удаляющий триггер обновляет значение в столбце total_sales таблицы titles каждый раз, когда удаляется одна или несколько строк из таблицы salesdetail.</p>
</p>
create trigger deltrig</p>
on salesdetail</p>
for delete</p>
as</p>
    /* check value of @@rowcount */</p>
if @@rowcount = 1</p>
    update titles</p>
      set total_sales = total_sales - qty</p>
      from deleted</p>
      where titles.title_id = deleted.title_id</p>
else</p>
    /* when rowcount is greater than 1,</p>
       use a group by clause */</p>
    update titles</p>
      set total_sales =</p>
        total_sales - (select sum(qty)</p>
      from deleted</p>
      group by deleted.title_id</p>
      having titles.title_id = deleted.title_id)</p>
</p>
</p>
Этот триггер запускается всякий раз, когда происходит удаление строк из таблицы salesdetail. Он устанавливает значение в столбце total_sales, равным прежнему значению минус сумма значений в удаляемых строках по столбцу salesdetail.qty.</p>
В следующем примере обновляющий триггер обновляет значение в столбце total_sales таблицы titles каждый раз, когда обновляется значение в столбце qty таблицы salesdetail. Напомним, что обновление - это добавление, за которым следует удаление. Поэтому этот триггер обращается как к тестовой таблице inserted, так и к тестовой таблице deleted.</p>
</p>
create trigger updtrig</p>
on salesdetail</p>
for update</p>
as</p>
if update (qty)</p>
begin</p>
    /* check value of @@rowcount */</p>
    if @@rowcount = 1</p>
        update titles</p>
          set total_sales = total_sales +</p>
            inserted.qty - deleted.qty</p>
          from inserted, deleted</p>
          where titles.title_id = inserted.title_id</p>
          and inserted.title_id = deleted.title_id</p>
    else</p>
    /* when rowcount is greater than 1,</p>
       use a group by clause */</p>
    begin</p>
        update titles</p>
          set total_sales = total_sales +</p>
            (select sum(qty)</p>
                from inserted</p>
                group by inserted.title_id</p>
                having titles.title_id =</p>
                inserted.title_id)</p>
        update titles</p>
          set total_sales = total_sales -</p>
            (select sum(qty)</p>
                from deleted</p>
                group by deleted.title_id</p>
                having titles.title_id =</p>
                deleted.title id)</p>
    end</p>
end</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Условный вставляющий триггер</td></tr></table></div></p>
Триггера, которые рассматривались до сих пор, трактовали каждый оператор модификации данных в целом. Другими словами, если одна или четыре вставляемые строки были неверными, то весь оператор трактовался как неправильный, и вся транзакция откатывалась.</p>
Однако, вообще говоря, не обязательно отменять все модифицируемые данные, если некоторые из них являются неверными. Используя в триггере коррелирующиеся подзапросы, можно проверять модифицируемые строк одну за другой. Напомним, что коррелирующиеся подзапросы рассматривались в главе 5 “Подзапросы: Использование запросов внутри других запросов”. В этом случае триггер может отделить правильные строки от неправильных.</p>
В следующем примере триггера предполагается существование таблицы newsales. Эта таблица создается с помощью следующего оператора:</p>
</p>
create table newsales</p>
(stor_id    char(4)     not null,</p>
ord_num     varchar(20) not null,</p>
title_id    tid         not null,</p>
qty         smallint    not null,</p>
discount    float       not null)</p>
</p>
В эту таблицу нужно записать четыре строки, чтобы проверить действие условного триггера. В двух из этих строк записаны коды книг в столбце title_id, которые не совпадают ни с одним из таких кодов в таблице titles. Ниже приводятся данные, расположенные в этой таблице:</p>
</p>
newsales</p>
stor_id  ord_num    title_id        qty     discount</p>
------- ----------  ---------       ----    ---------</p>
</p>
7066    BA27619     PS1372         75    40.000000</p>
7066    BA27619     BU7832       100    40.000000</p>
7067    NB-1.242    PSxxxx          50    40.000000</p>
7131    Asoap433    PSyyyy          50    40.000000</p>
</p>
Для перемещения данных из таблицы newsales в таблицу salesdetail можно использовать следующий оператор:</p>
</p>
insert salesdetail</p>
select * from newsales</p>
</p>
Предположим, что пользователь хочет проверить каждую из добавляемых строк. Триггер conditionalinsert, приводимый ниже, анализирует каждую из добавляемых строк одну за другой и удаляет те строки, которые содержат неправильный код книги в столбце title_id. Этот триггер имеет следующий вид:</p>
</p>
create trigger conditionalinsert</p>
on salesdetail</p>
for insert as</p>
if</p>
(select count(*) from titles, inserted</p>
where titles.title_id = inserted.title_id)</p>
    != @@rowcount</p>
begin</p>
  delete salesdetail from salesdetail, inserted</p>
    where salesdetail.title_id = inserted.title_id</p>
    and inserted.title_id not in</p>
    (select title_id from titles)</p>
  print "Only records with matching title_ids</p>
    added."</p>
end</p>
</p>
Этот триггер осуществляет по существу ту же проверку, что и триггер intrig, но транзакция при этом не откатывается. Вместо этого триггер просто удаляет из таблицы неправильные строки. Таким образом, когда триггер запускается он может изменить порядок обработки данных и удалить строки, которые уже вставлены. Сначала строки вставляются в основную таблицу и в таблицу inserted, а затем запускается триггер.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Откатывающие триггера</td></tr></table></div></p>
Пользователь может с помощью триггера выполнить откат (roll back), используя либо оператор rollback trigger (откатить триггер), либо оператор rollback transaction (если триггер запускается как часть транзакции). Однако, оператор rollback trigger отменяет действие только оператора, запустившего этот триггер, в то время как оператор rollback transaction (откатить транзакцию) отменяет всю транзакцию. Например:</p>
</p>
begin tran</p>
insert into publishers (pub_id) values ('9999')</p>
insert into publishers (pub_id) values ('9998')</p>
commit tran</p>
</p>
Если второй оператор вставки запускает триггер, связанный с таблицей publisher, который выдает команду rollback trigger, то откатывается лишь второй оператор вставки, а первая вставка отстанется в таблице. Если же этот триггер выдаст команду rollback transaction, то откатываются оба оператора вставки как части одной транзакции.</p>
Оператор rollback trigger имеет следующий вид:</p>
</p>
rollback trigger</p>
    [with raiserror_оператор]</p>
</p>
Синтаксис оператора rollback transaction описывается в главе 17 “Транзакции: сохранение целостности данных и восстановление”.</p>
В операторе сигнализации ошибки указывается оператор raiserror (возникновение ошибки), который выдает сообщение об ошибке, определенное пользователем, и устанавливает системный флаг, сигнализирующий о возникновении ошибочной ситуации. Это позволяет сообщить клиенту о возникновении ошибки, когда выполняется оператор rollback trigger, и передать информацию о виде ошибки. Например:</p>
</p>
rollback trigger with raiserror 25002</p>
    "title_id does not exist in titles table."</p>
</p>
Дополнительную информацию об операторе raiserror можно найти в главе 13 “Использование пакетов и язык управления заданиями”.</p>
Когда исполняется оператор rollback trigger, SQL Сервер прерывает исполнение текущей команды и прекращает выполнение команд триггера. Если триггер, выдавший команду rollback trigger, был вызван из другого триггера (более высокого уровня), то SQL Сервер отменяет (откатывает) результаты всей работы, выполненной этими триггерами, включая оператор обновления, который запустил первый триггер (более высокого уровня).</p>
В следующем примере вставляющий триггер выполняет функцию, аналогичную ранее описанной в триггере forinsertrig1. Однако в этом триггере используется команда rollback trigger вместо команды rollback transaction, чтобы откатывался только оператор вставки, а не вся транзакция.</p>
</p>
create trigger forinsertrig2</p>
on salesdetail</p>
for insert</p>
as</p>
if (select count(*) from titles, inserted</p>
    where titles.title_id = inserted.title_id) !=</p>
    @@rowcount</p>
   rollback trigger with raiserror 25003</p>
     "Trigger rollback: salesdetail row not added</p>
     because a title_id does not exist in titles."</p>
</p>
Если триггер, содержащий команду rollback transaction, исполняется в пакете, то в случае отката прекращается выполнение всего пакета. В следующем примере оператор вставки запускает триггер, содержащий команду rollback transaction (как и триггер forinsertrig1), поэтому в случае отката оператор удаления не будет выполняться, поскольку выполнение команд в пакете будет прекращено:</p>
</p>
insert salesdetail values ("7777", "JR123",</p>
    "PS9999", 75, 40)</p>
delete salesdetail where stor_id = "7067"</p>
</p>
Если триггер, содержащий команду rollback transaction, исполняется в транзакции, заданной пользователем (user-defined transaction), то команда rollback transaction отменяет результаты работы всего пакета. В следующем примере оператор вставки запускает триггер, содержащий команду rollback transaction, поэтому результаты работы оператора обновления также будут отменены:</p>
</p>
begin tran</p>
update stores set payterms = "Net 30"</p>
    where stor_id = "8042"</p>
insert salesdetail values ("7777", "JR123",</p>
    "PS9999", 75, 40)</p>
</p>
В главе 17 “Транзакции: сохранение корректности данных и их восстановление” дается информации о транзакциях, определенных (заданных) пользователями.</p>
SQL Сервер игнорирует команду rollback trigger, если она расположена вне тела триггера и не выполняет связанную с ним команду raiserror. Однако команда rollback trigger будет выполняться, если она расположена вне триггера, но внутри трианзакции. При этом SQL Сервер откатывает транзакцию и прекращает выполнение текущего оператора пакета.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Многоуровневые вызовы триггеров</td></tr></table></div></p>
Триггера могут иметь до 16 уровней по глубине вложенности вызовов. Количество уровней определяется при инсталляции. Системный администратор может либо разрешить, либо запретить многоуровневые триггера с помощью процедуры sp_configure (конфигурация). Чтобы запретить многоуровневость, нужно выполнить команду:</p>
</p>
sp_configure “allow nested triggers”, 0</p>
</p>
Если разрешен многоуровневый вызов триггеров, то триггер, изменяющий таблицу, может запустить триггер на втором уровне, а тот в свою очередь триггер на третьем уровне и т.д. Если какой-либо триггер в этой цепочке запустит один из предшествующих триггеров, то возникнет бесконечный цикл, который в конце концов приведет к превышению допустимого уровня вложенности и выполнение всей цепочки будет прекращено. Многоуровненвые триггера полезны при выполнении вспомогательных функций таких, как сохранение копий строк, которые были изменены предшествующим триггером.</p>
Например, можно создать триггер для таблицы titleauthor, который создает резервную копию строк, которые были удалены триггером delcascadetrig. Когда триггер delcascadetrig удаляет из таблицы titles, например, книгу с кодом “PS2091”, то он также удаляет этот код из таблицы titleauthor. Чтобы сохранить этот код, можно создать удаляющий триггер для таблицы titleauthor, который сохраняет удаленные строки в другой таблице del_save:</p>
</p>
create trigger savedel</p>
on titleauthor</p>
for delete</p>
as</p>
insert del_save</p>
select * from deleted</p>
</p>
Нежелательно, чтобы использование многоуровневых триггеров зависело от порядка их вызова. Следует использовать отдельные триггеры при каскадной модификации данных, как это было показано в примере с триггером delcascadetrig.</p>
</p>
Замечание: Если триггеры находятся внутри транзакции, то ошибка, произошедшая на любом уровне (включая превышение допустимого уровня вложенности) вызывает прекращение выполнения всей транзакции. При этом все произошедшие изменения данных будут откачены (отменены). Поэтому следует предусматривать в триггерах операторы print или raiseerror, чтобы определить, где произошла ошибка.</p>
</p>
Оператор rollback transaction, исполняющийся в триггере на любом уровне, откатывает изменения, сделанные всеми триггерами, и прекращает выполнение всей транзакции. Оператор rollback trigger касается только вложенных триггеров и оператора изменения данных, который запустил первый триггер цепочки.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Саморекурсивные триггера</td></tr></table></div></p>
 По умолчанию триггера не вызывают сами себя рекурсивным образом. Другими словами, обновляющий триггер не вызывает сам себя в ответ на обновление этой таблицы самим триггером. Если обновляющий триггер вызывается при обновлении некоторого столбца таблицы и сам обновляет значение в другом столбце, то второй раз он уже не вызывается. Однако пользователь может включить опцию self_recursion (саморекурсия) командой set (установить), что позволяет триггерам вызывать себя рекурсивно. Для саморекурсии необходимо также, чтобы была включена конфигурационная переменная nested triggers (допустить многоуровневые триггера).</p>
Установка опции self_recursion остается в силе только в течении текущего сеанса работы. Если эта опция устанавливается в теле триггера, то она действует только для триггера, в котором была установлена. Если триггер, в котором была установлена эта опция, завершается или запускает другой триггер, то опция self_recursion выключается. Триггер, в котором была установлена опция self_recursion, может многократно запускать сам себя, если производмые им изменения, приводят к его повторному запуску, но в любом случае глубина вложенности этих самозапусков не должна превышать 16.</p>
Для примера предположим, что в базе данных pubs2 существует следующая таблица new_budget:</p>
</p>
select * from new_budget</p>
unit                  parent_unit       budget</p>
---------------    -------------     -------</p>
</p>
one_department  one_division          10</p>
one_division        company_wide    100</p>
company_wide     NULL             1000</p>
</p>
(3 rows affected)</p>
</p>
Можно создать следующий триггер, который будет рекурсивно обновлять таблицу new_budget, когда изменяются данные в столбце budget:</p>
</p>
create trigger budget_change</p>
on new_budget</p>
for update as</p>
if exists (select * from inserted</p>
            where parent_unit is not null)</p>
begin</p>
    set self_recursion on</p>
    update new_budget</p>
    set new_budget.budget = new_budget.budget +</p>
        inserted.budget - deleted.budget</p>
    from inserted, deleted, new_budget</p>
    where new_budget.unit = inserted.parent_unit</p>
        and new_budget.unit = deleted.parent_unit</p>
end</p>
</p>
Если пользователь обновляет данные в столбце new_budget.budget, увеличив на три его значения на уровне отдела (one_department), то SQL Сервер будет выполнять следующие действия (при условии, что разрешены многоуровневые триггера):</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">1.</td><td>Увеличивает на три значение бюджета с 10 до 13 в строке one_department и запускает триггер budget_change;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">2.</td><td>Триггер обновляет значение бюджета для вышестоящего подразделения (в данном случае one_division) со 100 на 103 и вновь запускает сам себя;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">3.</td><td>Триггер вновь обновляет значение бюджета для вышестоящей структуры (в данном случае company_wide) со 1000 на 1003 и в третий раз запускает сам себя;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">4.</td><td>Теперь триггер пытается найти строку соответствующую вышестоящей структуре для всей компании (company_wide), но поскольку такой не существует (соответствующее поле равно NULL), то следующего обновления не происходит и саморекурсия прекращается. Заключительное состояние таблицы new_budget имеет следующий вид:</td></tr></table></div></p>
select * from new_budget</p>
unit                   parent_unit     budget</p>
--------------- ---------------     -------</p>
</p>
one_department  one_division        13</p>
one_division       company_wide    103</p>
company_wide    NULL                 1003</p>
</p>
(3 rows affected)</p>
</p>
Триггер может запускать себя рекурсивно и другими способами. Например, триггер может вызвать сохраненную процедуру, которая своими действиями приводит к запуску этого триггера (при условии допустимости вложенных запусков). Если в этом триггере не предусмотрено условия, которое ограничивает число рекурсий, то произойдет превышение допустимого уровня вложенности запусков.</p>
Например, если обновляющий триггер вызывает сохраненную процедуру, которая выполняет обновление, то триггер и процедура исполняться ровно один раз, если выключена опция nested triggers (многоуровневые триггера). Если она включена, и отсутствует условие,  ограничивающее  число обновлений в триггере или процедуре 16-ю, то цикл, состоящий из поочередных вызовов триггера и процедуры, будет продолжаться до тех пор, пока не будет превышен порог в 16 уровней.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Правила связанные с триггерами</td></tr></table></div></p>
Таким образом, при создании триггеров нужно обращать внимание на мультистрочные изменения данных, откат триггеров и их многоуровневые запуски. Кроме того, имеются также другие факторы, которые требуют внимания со стороны пользователя.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Триггера и права доступа</td></tr></table></div></p>
Триггер связывается с определенной таблицей. Только владелец таблицы имеет права на выполнение команд create trigger и drop trigger. Эти права нельзя передавать другим лицам.</p>
SQL Сервер допускает создание триггеров, в которых используются команды, на которые у пользователя нет разрешения. Существование такого триггера блокирует всевозможные последующие попытки модификации триггерной таблицы, поскольку триггер запускается при отсутствии соответствующих полномочий и поэтому транзакция прерывается. Пользователь должен либо получить соответствующие права, либо удалить триггер.</p>
Предположим, например, что Жозе (Jose) владеет таблицей salesdetail и создает для нее триггер. Триггер предназначен для обновления значения в столбце titles.total_sales, если обновляется значение в столбце salesdetail.qty. Однако Мария, которая владеет таблицей titles, не предоставила Жозе прав на использование этой таблицы. Когда Жозе попытался обновить таблицу salesdetail, SQL Сервер обнаружил, что Жозе не имеет соответствующих прав и откатил всю обновляющую транзакцию. Таким образом, Жозе должен либо получить от Марии права на обновление столбца titles.total_sales, либо удалить триггер, связанный с таблицей salesdetail.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Ограничения для триггеров</td></tr></table></div></p>
SQL Сервер накладывает на триггера следующие ограничения:</p>
</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>С одной таблицей может быть связано не более трех триггеров: один на обновление, один на добавление и один на удаление;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Каждый триггер должен быть связан только с одной таблицей, но один и тот же триггер может запускаться при различных действиях: обновлении, вставке и удалении;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Триггер нельзя связывать с вьювером или временной таблицей, хотя из триггеров можно обращаться к этим объектам;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 114px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="28">&#183;</td><td>Хотя оператор truncate table по своему действию аналогичен оператору delete без предложения where, поскольку оба этих оператора удаляют из таблицы все строки, тем не менее первый из них не может запустить триггер, так как он применяется ко всей таблицы в целом, когда отдельные строки таблицы не логируются (не запоминаются в журнале транзакций).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Явные и неявные неопределенные значения</td></tr></table></div></p>
Условие if update(название_столбца) в операторе вставки insert выполняется всякий раз, когда в столбец записывается новое значение, которое берется либо из списка выбора оператора select, либо из предложения values. Если происходит явное присваивание неопределенного значения или если это  значение связано со столбцом по умолчанию, то происходит запуск триггера. Если неопределенное значение присваивается неявно, то триггер не запускается.</p>
Следующий пример поясняет эту ситуацию:</p>
</p>
create table junk</p>
(a int null,</p>
 b int not null)</p>
</p>
create trigger junktrig</p>
on junk</p>
for insert</p>
as</p>
if update(a) and update(b)</p>
        print "FIRING"</p>
    /*"if update" is true for both columns.</p>
      The trigger is activated.*/</p>
insert junk (a, b) values (1, 2)</p>
    /*"if update" is true for both columns.</p>
      The trigger is activated.*/</p>
insert junk values (1, 2)</p>
    /*Explicit NULL:</p>
      "if update" is true for both columns.</p>
      The trigger is activated.*/</p>
insert junk values (NULL, 2)</p>
    /* If default exists on column a,</p>
      "if update" is true for either column.</p>
      The trigger is activated.*/</p>
insert junk (b) values (2)</p>
    /* If no default exists on column a,</p>
      "if update" is not true for column a.</p>
      The trigger is not activated.*/</p>
insert junk (b)values (2)</p>
</p>
Такой же результат может быть получен, если использовать только одно следующее предложение:</p>
</p>
if update(a)</p>
</p>
Чтобы создать триггер, который запрещает неявное присваивание неопределенного значения, можно воспользоваться следующим условием:</p>
</p>
if update(a) or update(b)</p>
</p>
Затем внутри тела триггера можно указать SQL операторы, которые проверяют является ли значение в столбце a или b неопределенным.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Триггеры и производительность</td></tr></table></div></p>
Уменьшение производительности, связанное с использованием триггеров, обычно очень мало. Основное время при работе триггера тратится на обращение к другим таблицам, которые могут быть расположены как в оперативной памяти, так и на диске.</p>
Триггерные таблицы добавления и удаления всегда располагаются в оперативной памяти. Расположение других таблиц, к которым обращается триггер, в основном, определяется временем его работы.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Команда установки set в триггерах</td></tr></table></div></p>
Команду установки опций set можно использовать внутри триггера. Опция, устанавливаемая этой командой, будет действовать только во время выполнения триггера, а затем ее значение восстанавливается.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Переименование и триггера</td></tr></table></div></p>
Если происходит переименование объекта, к которому обращается триггер, необходимо удалить этот триггер, а затем снова создать его таким образом, чтобы в его тексте использовались только новые названия объектов. Лучше всего вообще воздержаться от переименования объектов, к которым обращаются триггера.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 21px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Получение информации о триггерах</td></tr></table></div></p>
Названия всех триггеров находятся в таблице sysobject, как и всех других объектов базы данных. В поле тип (type) этой таблицы для триггеров указано значение «TR». Следующий запрос находит все триггера текущей базы данных:</p>
</p>
select *</p>
from sysobjects</p>
where type = «TR»</p>
</p>
Все операторы, образующие тело триггера и указанные в команде create trigger, запоминаются в таблице syscomments. Тело триггера можно увидеть с помощью системной процедуры sp_helptext.</p>
Планы исполнения (execution plans) для триггеров хранятся в таблице sysprocedures. Некоторые системные процедуры предоставляют информацию о триггерах из системных таблиц.</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедура sp_help</td></tr></table></div></p>
С помощью системной процедуры sp_help можно получить информацию о триггере. Например, можно получить информацию о триггере deltitle следующим образом:</p>
</p>
sp_help deltitle</p>
</p>
Name        Owner   Type</p>
-----------  -------   -----------</p>
deltitle        dbo      trigger</p>
</p>
Data_located_on_segment  When_created</p>
-----------------------        -----------------</p>
not applicable                   Feb 9 1987  3:56PM</p>
</p>
(return status = 0)</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедура sp_helptext</td></tr></table></div></p>
Чтобы увидеть текст тела триггера, нужно выполнить системную процедуру sp_helptext:</p>
</p>
sp_helptext deltitle</p>
</p>
# Lines of Text</p>
---------------</p>
</p>
              1</p>
</p>
text</p>
---------------------------------------------</p>
</p>
create trigger deltitle</p>
on titles</p>
for delete</p>
as</p>
if (select count(*) from deleted, salesdetail</p>
where salesdetail.title_id = deleted.title_id) &gt;0</p>
begin</p>
rollback transaction</p>
print "You can't delete a title with sales."</p>
end</p>
</p>
<div style="text-align: left; text-indent: 0px; border-color: #000000; border-style: solid; border-width: 1px; border-top: none; border-right: none; border-left: none; padding: 0px 0px 1px 0px; margin: 0px 0px 1px 42px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="21"></td><td>Процедура sp_depends</td></tr></table></div></p>
 Системная процедура sp_depends перечисляет все триггера, которые обращаются к некоторому объекту, или указывает все таблицы и вьюверы, к которым обращается данный триггер. Следующий пример показывает как использовать процедуру sp_depends для получения списка объектов, к которым обращается триггер deltitle:</p>
</p>
sp_depends deltitle</p>
Things the object references in the current database.</p>
</p>
object                  type       updated  selected</p>
----------------   ----------  -------   --------</p>
dbo.salesdetail     user table     no        no</p>
dbo.titles            user table     no        no</p>
</p>
(return status = 0)</p>
</p>
Следующий оператор перечисляет все объекты, которые связаны с таблицей salesdetail:</p>
</p>
sp_depends salesdetail</p>
</p>
Things inside the current database that reference the object.</p>
</p>
object                               type</p>
---------------------------  ----------------</p>
</p>
dbo.deltitle                         trigger</p>
dbo.history_proc                  stored procedure</p>
dbo.insert_salesdetail_proc     stored procedure</p>
dbo.totalsales_trig                 trigger</p>
</p>
(return status = 0)</p>
</p>
