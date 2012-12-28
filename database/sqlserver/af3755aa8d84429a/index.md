---
Title: 10 вещей, которые убедят вас перейти на сервер 2005
Date: 01.01.2007
---


10 вещей, которые убедят вас перейти на сервер 2005
===================================================

::: {.date}
01.01.2007
:::

Arthur Fuller и Stephen Giles (оригинал: 10 things that will convince
you to upgrade to SQL Server 2005)

Перевод Моисеенко С.И.

 \
Узнайте 10 самых важных причин того, почему Вы должны модернизировать
свой сервер до SQL Server 2005. Нововведения последней версии SQL Server
включают Студию Управления (Management Studio), SSIS и встроенные
бизнес-решения (BI - business intelligence).\

Большинство ИТ профессионалов работает с SQL Server 2000 и все еще
поддерживают базы данных на SQL Server 7 (некоторые до сих пор
поддерживают даже базы данных на SQL Server 6.5). С выходом SQL Server
2005 нас часто спрашивают: нужно ли переходить? В этой статье мы даем 10
самых веских причин для перехода на SQL Server 2005.

 \
1. Все, что работает сейчас, будет продолжать работать.\
Студия Управления SQL Server 2005 позволит Вам управлять базами данных
SQL Server 2000 и SQL Server 2005. Студия Управления не будет работать
для SQL Server 6.5 и 7.0, однако, такие базы данных достаточно просто
перевести на приемлемые версии.\

Из-за проблем совместимости, некоторые вещи не будут легко переносимы в
Студию Управления. Например, если ваша база данных SQL Server 2000
содержит диаграммы, то Вы не сможете добраться до них из SQL Server 2005
без модернизации базы данных.

 \
2. SQL Server 2005 включает большее количество компонент.\
Более ранние версии SQL Server комплектовались различными компонентами
несколькими разными способами. Например, полный Enterprise edition
включал все, но Вы, возможно, не были настолько счастливы, чтобы
приобрести эту редакцию. Компонента Analysis Services не была включена в
SQL Server 2000 Standard, и Вы должны были покупать ее отдельно.\

Microsoft изменила свою маркетинговую стратегию и включила все
компоненты в единый пакет. SQL Server 2005 действительно стоит дороже,
чем предыдущие версии, но есть одна невероятная вещь. Так, если Вы
посетите презентацию выпуска SQL Server 2005, то Microsoft предоставит
Вам бесплатную версию без всяких проволочек.

 \
3. В корне отличные пользовательские интерфейсы закатали в один
интерфейс пользователя (UI).\

В старые добрые времена Enterprise Manager\'а и Query Analyzer\'а Query
Profiler, Reporting Services и Data Transformation Services (DTS) были
изолированными приложениями, интерфейсы которых были совсем не
согласованы. Студия Управления SQL Server 2005 дает Вам один прозрачный
UI, который дает доступ ко всем компонентам, включая даже онлайновую
аналитическую обработку (OLAP) и Службы Интеграции SQL Server (SSIS)
безотносительно сервера, на котором находятся эти компоненты. Это
выливается в большую производительность и удешевление затрат на
обучение. Даже если Вы предпочтете сохранить ваши базы данных в формате
SQL Server 2000, Вы сможете использовать замечательный новый интерфейс
для решения своих задач.

 \
4. Подъем языков .NET на новую высоту.\

T-SQL по-прежнему является инструментом, на котором делается 90% вашей
работы. Однако некоторые задачи требуют особой точности; в этих
ситуациях использование T-SQL является, по крайней мере, неуклюжим.
Примерами являются построчная обработка, особенно когда Вы должны
сравнить текущую строку с предыдущей, и запись во множество таблиц в
пределах одной процедуры. Вы можете сделать это в рамках T-SQL. Однако
для вас может оказаться более простым использовать наборы строк .NET
(rowset) для реализации очень сложной логики. Мы не предлагаем, чтобы Вы
переписали все ваши хранимые процедуры в .NET; напротив, думайте об этом
как о дополнительной прекрасной возможности, а не как о замене T-SQL.

 \
5. Вы можете получить выигрыш в использовании Reporting Services.\
Мы придерживаемся следующего общего принципа: все, что может быть
сделано на стороне сервера, должно делаться на стороне сервера.
Например, мы полагаем, что построение динамических запросов к SQL Server
в приложении чаще всего глупо. Это приходится делать время от времени,
но лучшее и более безопасное решение состоит в том, чтобы собрать в
приложении параметры, а затем передать их в хранимую процедуру.\

Reporting Services в SQL Server 2005 переносит эту концепцию на более
высокий уровень. В SQL Server 2000 и более ранних версиях отчеты
готовились средствами приложений (C ++, VB, Delphi, Access, Crystal
Reports и т.д.). Вы можете получить огромные преимущества, встроив их в
Reporting Services. Сначала Вы убираете всю логику из данного
приложения. Затем Вы можете использовать Reporting Services фактически
из любого приложения. Это означает, что ваши разработчики приложений
смогут удалить большие объемы кода из своих приложений. В результате
получаем один отчет для всех возможных UI, поэтому, если обнаруживается
ошибка в отчете, Вы исправляете ее в одном месте, и все UI наследуют это
исправление.

 \
6. Встроенные бизнес-решения (BI).\

Бизнес-решения (OLAP) не были встроены в предыдущих версиях SQL Server,
если Вы не покупали редакцию Enterprise edition для SQL Server 2000.
Даже если Вы могли позволить себе это, то Вам приходилось осваивать
новый интерфейс. Используя SQL Server 2005, Вы можете делать все, что и
прежде, но с помощью прозрачного интегрированного UI.

 \
7. Прощай DTS и привет SSIS.\

SQL Server 2005 полностью заменяет DTS новой технологией по имени SSIS,
которая является квантовым скачком вперед. Мы думаем, что самой крутой
частью SSIS является то, что преобразование данных теперь - это объект
SSIS. Наконец, Вы можете действительно сделать управление потоком и
обработку ошибок, строя задачи вне операций извлечения, преобразования,
и загрузки (ETL).

 \
8. Мудрая модернизация с помощью Upgrade Advisor.\

SQL Server 2005 ввел новые функциональные возможности и изменил
существующие, чтобы повысить производительность, безопасность, и
управляемость. Эти изменения могут затронуть ваши уже существующие
приложения. Вот почему команда Microsoft SQL Server разработала Upgrade
Advisor, который разумно проведет Вас через процесс модернизации и
укажет на любые проблемы совместимости, которые могут при этом
возникнуть.

 \
9. Вы теперь имеете детализированную безопасность под руками.\

При дополнении надлежащей схемой базы данных и способностью назначать
некоторые административные задачи, не наделяя каждого разработчика и
младшего администратора базы данных всеми правами Старшего Архитектора
(Senior Architect), Вы можете в значительной степени увеличить
безопасность SQL Server 2005, давая пользователям только те права,
которые им необходимы для выполнения своей работы. (По общему признанию,
некоторые разработчики не могли не видеть в этом серьезное основание для
перехода)

 \
10. Выгода от масштабируемости предприятия.\

SQL Server 2000 имеет проблемы с масштабируемостью предприятия, но все
это теперь в прошлом после выхода в свет SQL Server 2005. Похоже на то,
что SQL Server 2005 готов соревноваться с решениями Oracle и DB2
масштаба предприятия. Причем он обойдется значительно дешевле, чем
аналогичные продукты от Oracle или DB2, независимо от того, как Вы
измеряете стоимость (на процессор или же на место).

 \
Резюме\

Даже если у Вас нет неотложной потребности для миграции от SQL Server 7
или 2000, Вам следует установить SQL Server 2005, поскольку преимущества
огромны. Вы можете продолжить администрирование баз данных на SQL Server
2000, не преобразовывая их, наслаждаясь при этом новыми крутыми
расширениями в SQL Server 2005. Час, проведенный в новой Студии
Управления сервера, заставит Вас забыть все о Enterprise Manager и Query
Analyzer. Они будут казаться вам столь же древними, как CP/М.